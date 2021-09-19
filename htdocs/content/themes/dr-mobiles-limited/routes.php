<?php

/**
 * Theme routes.
 *
 * The routes defined inside your theme override any similar routes
 * defined on the application global scope.
 */

use Themosis\Support\Facades\Asset;
use Themosis\Support\Facades\Route;

$theme = app()->make('wp.theme');

Route::fallback(function () {
    return redirect('/');
});

Route::any('front', function () use ($theme) {
    Asset::add('front-style', 'css/front.css', [], $theme->getHeader('version'))->to('front');
    Asset::add('front-script', 'js/front.js', [], $theme->getHeader('version'))->to('front');

    return view('pages.front');
});

Route::any('page', [
    ['repair-services'],
    function () {
        return view('pages.repair-services');
    }
]);

Route::any('page', [
    ['repair-tracker'],
    function () {
        return view('pages.repair-tracker');
    }
]);

Route::any('page', [
    ['contact-us'],
    function () use ($theme) {
        $contact_us = Asset::add('contact-us-script', 'js/contact-us.js', [],
            $theme->getHeader('version'))->to('front');

        $contact_us->localize('contact_us_script_data', [
            'google_recaptcha_site_key'    => get_field('google_recaptcha_site_key', 'options'),
            'wp_ajax'                      => admin_url('admin-ajax.php'),
            'wp_nonce'                     => wp_create_nonce('wp-nonce'),
            'contact_label_1'              => get_field('contact_label_1', 'options'),
            'contact_label_2'              => get_field('contact_label_2', 'options'),
            'contact_label_3'              => get_field('contact_label_3', 'options'),
            'contact_label_4'              => get_field('contact_label_4', 'options'),
            'contact_error_1'              => get_field('contact_error_1', 'options'),
            'contact_error_2'              => get_field('contact_error_2', 'options'),
            'contact_error_3'              => get_field('contact_error_3', 'options'),
            'contact_error_4'              => get_field('contact_error_4', 'options'),
            'contact_error_5'              => get_field('contact_error_5', 'options'),
            'contact_label_submit'         => get_field('contact_label_submit', 'options'),
            'contact_submission_succeeded' => get_field('contact_submission_succeeded', 'options'),
            'contact_submission_failed'    => get_field('contact_submission_failed', 'options'),
        ]);

        return view('pages.contact-us');
    }
]);
