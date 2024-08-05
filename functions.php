<?php
if (!function_exists('theme_setup')) {
    function theme_setup()
    {
        add_theme_support('wp-block-styles');
    }
}
add_action('after_setup_theme', 'theme_setup');

add_action('wp_enqueue_scripts', 'chasing_good_enqueue_styles');

add_action('wp_enqueue_scripts', 'custom_scripts');

function chasing_good_enqueue_styles()
{
    wp_enqueue_style(
        'chasing-good-style',
        get_stylesheet_uri()
    );
}

function custom_scripts()
{
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom.js', array(), '1.0', true);
}
