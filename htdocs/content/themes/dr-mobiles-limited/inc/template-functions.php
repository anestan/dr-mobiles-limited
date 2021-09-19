<?php

use Themosis\Support\Facades\Action;
use Themosis\Support\Facades\Ajax;
use Themosis\Support\Facades\Filter;

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
Filter::add('body_class', function ($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
});

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
Action::add('wp_head', function () {
    if (is_singular() && pings_open()) {
        echo '<link rel="pingback" href="' . esc_url(get_bloginfo('pingback_url')) . '">';
    }
});

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
Action::add('after_setup_theme', function () {
    $GLOBALS['content_width'] = 640;
}, 0);

Action::remove('wp_head', 'print_emoji_detection_script', 7);
Action::remove('wp_print_styles', 'print_emoji_styles', 10);
Action::remove('admin_print_scripts', 'print_emoji_detection_script', 10);
Action::remove('admin_print_styles', 'print_emoji_styles', 10);

Action::add('wp_enqueue_scripts', function () {
    wp_enqueue_style('dashicons');
});

Action::add('init', function () {
    add_editor_style('dist/css/editor.css');
});

Filter::add('tiny_mce_before_init', function ($init_array) {
    $init_array['font_formats'] = 'Poppins=poppins,sans-serif;Sarpanch=sarpanch,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';

    return $init_array;
});

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(
        [
            'menu_title' => 'Global',
            'page_title' => 'Global',
            'menu_slug'  => 'global',
            'redirect'   => false,
            'icon_url'   => 'dashicons-admin-page',
        ]
    );
}

function validateRecaptcha($action, $token)
{
    if (!isset($token)) {
        return false;
    }

    $parameters = ['secret' => get_field('google_recaptcha_secret_key', 'option'), 'response' => $token];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    $response = curl_exec($ch);
    $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    curl_close($ch);

    if ($response['success'] && $response['action'] === $action && $response['score'] >= 0.5) {
        return $response['success'];
    }

    return false;
}

Ajax::listen('submit_contact_us_form', function () {
    if (!env('APP_DEBUG')) {
        if (!wp_verify_nonce($_POST['wp_nonce'], 'wp-nonce') || !validateRecaptcha($_POST['action'],
                $_POST['recaptcha_token'])) {
            http_response_code(400);
            die();
        }
    }

    $to = array_column(get_field('contact_recipients', 'options'), 'email');
    $subject = 'Contact Us Enquiry';
    $headers = [];
    $headers[] = 'From: ' . $_POST['name'] . ' <' . $_POST['email'] . '>';

    ob_start();

    echo '<p><strong>Name</strong>: ' . $_POST['name'] . '</p>
<p><strong>Phone</strong>: ' . $_POST['phone'] . '</p>
<p><strong>Email</strong>: ' . $_POST['email'] . '</p>
<p><strong>Message</strong>: ' . $_POST['message'] . '</p>
';

    $message = ob_get_clean();

    $mail = wp_mail($to, $subject, $message, $headers);

    if (!$mail) {
        http_response_code(400);
    }

    http_response_code(200);

    die();
});
