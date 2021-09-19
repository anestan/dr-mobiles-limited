<?php

/**
 * Edit this file in order to add WordPress sidebars to your theme.
 *
 * @see https://developer.wordpress.org/reference/functions/register_sidebar/
 */
return [
    [
        'name' => __('First sidebar', THEME_TD),
        'id' => 'sidebar-1',
        'description' => __('Area of first sidebar', THEME_TD),
        'class' => 'custom',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ],
    [
        'name' => __('Shop sidebar', THEME_TD),
        'id' => 'sidebar-shop',
        'description' => __('Area of shop sidebar', THEME_TD),
        'class' => 'custom',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ]
];
