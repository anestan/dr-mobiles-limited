<!doctype html>
<html {!! get_language_attributes() !!}>
<head>
    <meta charset="{{ get_bloginfo('charset') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property='og:title' content='{{ get_bloginfo( 'name' ) }}'/>
    <meta property='og:image' content='{{ get_template_directory_uri() . '/screenshot.png' }}'/>
    <meta property='og:description' content='{{ get_bloginfo( 'description' ) }}'/>
    <meta property='og:url' content='{{ home_url() }}'/>
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <script defer src="{{ mix('/js/alpine.js') }}"></script>
    <!--Start of Zendesk Chat Script-->
    <script type="text/javascript">
      window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
      _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
        $.src="https://v2.zopim.com/?nMfx1AqBpsqhGqylnbQK8HnxWsF4QGsA";z.t=+new Date;$.
          type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
    </script>
    <!--End of Zendesk Chat Script-->
    @head
</head>
<body @php(body_class())>
@include('layouts.header')
<main>
    @yield('content')
</main>
@include('layouts.footer')
@footer
</body>
</html>
