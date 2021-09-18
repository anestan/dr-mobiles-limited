<?php

namespace Themosis\Core\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Router;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;

class Handler implements ExceptionHandler
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * A list of the internal exception types that should not be reported.
     *
     * @var array
     */
    protected $internalDontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class
    ];

    /**
     * A list of inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation'
    ];

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Report or log an exception.
     *
     * @param \Exception $e
     *
     * @throws Exception
     */
    public function report(Exception $e)
    {
        if ($this->shouldntReport($e)) {
            return;
        }

        if (method_exists($e, 'report')) {
            return $e->report();
        }

        try {
            $logger = $this->container->make(LoggerInterface::class);
        } catch (Exception $e) {
            throw $e;
        }

        $logger->error(
            $e->getMessage(),
            array_merge(
                $this->context(),
                [
                    'exception' => $e
                ]
            )
        );
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $e
     *
     * @throws \Illuminate\Container\EntryNotFoundException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        } elseif ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($e);

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        } elseif ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return $request->expectsJson() ?
            $this->prepareJsonResponse($request, $e) :
            $this->prepareResponse($request, $e);
    }

    /**
     * Render an exception to the console.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Exception                                        $e
     */
    public function renderForConsole($output, Exception $e)
    {
        (new ConsoleApplication())->renderException($e, $output);
    }

    /**
     * Prepare exception for rendering.
     *
     * @param Exception $e
     *
     * @return Exception
     */
    protected function prepareException(Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        } elseif ($e instanceof AuthorizationException) {
            $e = new AccessDeniedHttpException($e->getMessage(), $e);
        } elseif ($e instanceof TokenMismatchException) {
            $e = new HttpException(419, $e->getMessage(), $e);
        }

        return $e;
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param Request                 $request
     * @param AuthenticationException $e
     *
     * @return Response
     */
    protected function unauthenticated($request, AuthenticationException $e)
    {
        return $request->expectsJson()
            ? response()->json(['message' => $e->getMessage()], 401)
            : redirect()->guest($e->redirectTo() ?? route('login'));
    }

    /**
     * Create a response instance from the given validation exception.
     *
     * @param ValidationException $e
     * @param Request             $request
     *
     * @return SymfonyResponse
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        return $request->expectsJson()
            ? $this->invalidJson($request, $e)
            : $this->invalid($request, $e);
    }

    /**
     * Convert a validation exception into a response.
     *
     * @param Request             $request
     * @param ValidationException $e
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function invalid($request, ValidationException $e)
    {
        $url = $e->redirectTo ?? url()->previous();

        return redirect($url)
            ->withInput($request->except($this->dontFlash))
            ->withErrors($e->errors(), $e->errorBag);
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param Request             $request
     * @param ValidationException $e
     *
     * @return JsonResponse
     */
    protected function invalidJson($request, ValidationException $e)
    {
        return response()->json([
            'message' => $e->getMessage(),
            'errors' => $e->errors()
        ], $e->status);
    }

    /**
     * Determine if the exception handler should be reported.
     *
     * @param Exception $e
     *
     * @return bool
     */
    public function shouldReport(Exception $e)
    {
        return ! $this->shouldntReport($e);
    }

    /**
     * Determine if the exception is in the "do not report" list.
     *
     * @param Exception $e
     *
     * @return bool
     */
    protected function shouldntReport(Exception $e)
    {
        $dontReport = array_merge($this->dontReport, $this->internalDontReport);

        return ! is_null(Arr::first($dontReport, function ($type) use ($e) {
            return $e instanceof $type;
        }));
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param $request
     * @param Exception $e
     *
     * @throws \Illuminate\Container\EntryNotFoundException
     *
     * @return JsonResponse
     */
    protected function prepareJsonResponse($request, Exception $e)
    {
        $status = $this->isHttpException($e) ? $e->getStatusCode() : 500;
        $headers = $this->isHttpException($e) ? $e->getHeaders() : [];

        return new JsonResponse(
            $this->convertExceptionToArray($e),
            $status,
            $headers,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }

    /**
     * Convert the given exception to an array.
     *
     * @param Exception $e
     *
     * @throws \Illuminate\Container\EntryNotFoundException
     *
     * @return array
     */
    protected function convertExceptionToArray(Exception $e)
    {
        return config('app.debug') ? [
            'message' => $e->getMessage(),
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all()
        ] : [
            'message' => $this->isHttpException($e) ? $e->getMessage() : 'Server Error'
        ];
    }

    /**
     * Prepare a response for the given exception.
     *
     * @param \Illuminate\Http\Request $request
     * @param Exception                $e
     *
     * @throws \Illuminate\Container\EntryNotFoundException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function prepareResponse($request, Exception $e)
    {
        if (! $this->isHttpException($e) && config('app.debug')) {
            return $this->toIlluminateResponse(
                $this->convertExceptionToResponse($e),
                $e
            );
        }

        if (! $this->isHttpException($e)) {
            $e = new HttpException(500, $e->getMessage());
        }

        return $this->toIlluminateResponse(
            $this->renderHttpException($e),
            $e
        );
    }

    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param Exception $e
     *
     * @return bool
     */
    protected function isHttpException(Exception $e)
    {
        return $e instanceof HttpException;
    }

    /**
     * Map the given exception into an Illuminate response.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param Exception                                  $e
     *
     * @return \Illuminate\Http\Response
     */
    protected function toIlluminateResponse($response, Exception $e)
    {
        if ($response instanceof SymfonyRedirectResponse) {
            $response = new SymfonyRedirectResponse(
                $response->getTargetUrl(),
                $response->getStatusCode(),
                $response->headers->all()
            );
        } else {
            $response = new Response(
                $response->getContent(),
                $response->getStatusCode(),
                $response->headers->all()
            );
        }

        return $response->withException($e);
    }

    /**
     * Convert an exception to a response instance.
     *
     * @param Exception $e
     *
     * @throws \Illuminate\Container\EntryNotFoundException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertExceptionToResponse(Exception $e)
    {
        $headers = $this->isHttpException($e) ? $e->getHeaders() : [];
        $statusCode = $this->isHttpException($e) ? $e->getStatusCode() : 500;

        try {
            $content = config('app.debug') && class_exists(Whoops::class)
                ? $this->renderExceptionWithWhoops($e)
                : $this->renderExceptionWithSymfony($e, config('app.debug'));
        } catch (Exception $e) {
            $content = $content ?? $this->renderExceptionWithSymfony($e, config('app.debug'));
        }

        return SymfonyResponse::create(
            $content,
            $statusCode,
            $headers
        );
    }

    /**
     * Render an exception using Whoops.
     *
     * @param Exception $e
     *
     * @return string
     */
    protected function renderExceptionWithWhoops(Exception $e)
    {
        return tap(new Whoops(), function ($whoops) {
            $whoops->pushHandler($this->whoopsHandler());
            $whoops->writeToOutput(false);
            $whoops->allowQuit(false);
        })->handleException($e);
    }

    /**
     * Get the Whoops handler for the application.
     *
     * @return \Whoops\Handler\Handler
     */
    protected function whoopsHandler()
    {
        return tap(new PrettyPageHandler(), function ($handler) {
            $files = new Filesystem();
            $handler->handleUnconditionally(true);

            foreach (config('app.debug_blacklist', []) as $key => $secrets) {
                foreach ($secrets as $secret) {
                    $handler->blacklist($key, $secret);
                }
            }

            if (config('app.editor', false)) {
                $handler->setEditor(config('app.editor'));
            }

            $handler->setApplicationPaths(
                array_flip(Arr::except(
                    array_flip($files->directories(base_path())),
                    [base_path('vendor')]
                ))
            );
        });
    }

    /**
     * Render an exception to a string using Symfony.
     *
     * @param Exception $e
     * @param $debug
     *
     * @return string
     */
    protected function renderExceptionWithSymfony(Exception $e, $debug)
    {
        return (new SymfonyExceptionHandler($debug))->getHtml(FlattenException::create($e));
    }

    /**
     * Render the given HttpException.
     *
     * @param \Symfony\Component\HttpKernel\Exception\HttpException $e
     *
     * @throws \Illuminate\Container\EntryNotFoundException
     *
     * @return \Symfony\Component\HttpFoundation\Response;
     */
    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();

        $paths = collect(view()->getFinder()->getPaths());

        view()->replaceNamespace('errors', $paths->map(function ($path) {
            return "{$path}/errors";
        })->push(__DIR__.'/views')->all());

        if (view()->exists($view = "errors::{$status}")) {
            return response()->view($view, [
                'exception' => $e
            ], $status, $e->getHeaders());
        }

        return $this->convertExceptionToResponse($e);
    }

    /**
     * Get the default context variables for logging.
     *
     * @return array
     */
    protected function context()
    {
        try {
            return [
                'userId' => Auth::id(),
                'email' => Auth::user() ? Auth::user()->email : null
            ];
        } catch (Throwable $e) {
            return [];
        }
    }
}
