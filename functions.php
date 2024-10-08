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

function my_theme_styles_endpoint()
{
    $styles = array(
        'primary_color' => get_theme_mod('primary_color', '#007cba'), // Example theme mod
        'secondary_color' => get_theme_mod('secondary_color', '#fff'),
        // Add other relevant styles
    );

    return rest_ensure_response($styles);
}

add_action('rest_api_init', 'my_theme_styles_endpoint');

add_filter('rest_query_vars', function ($valid_vars) {
    return array_merge($valid_vars, array('chasinggood_winner_year', 'meta_query'));
});

add_filter('rest_post_query', function ($args, $request) {
    $year   = $request->get_param('chasinggood_winner_year');

    if (! empty($year)) {
        $args['meta_query'] = array(
            array(
                'key'     => 'chasinggood_winner_year',
                'value'   => $year,
                'compare' => '=',
            )
        );
    }

    return $args;
}, 10, 2);
