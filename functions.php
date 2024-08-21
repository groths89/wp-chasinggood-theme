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

function get_winners_by_year($year)
{
    $args = array(
        'post_type' => 'winners',
        'meta_key' => 'chasinggood_winner_year',
        'meta_value' => $year
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $winners[] = array(
                'id' => get_the_ID(),
                'name' => get_field('chasinggood_winner_name'),
            );
        }
        wp_reset_postdata();
    }

    wp_send_json($winners);
}
add_action('rest_api_init', 'register_get_winners_by_year_route');

function register_get_winners_by_year_route()
{
    register_rest_route('https://wp.chasinggood.org/wp-json/wp/v2', '/winners/(?P<year>\d+)', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_winners_by_year',
    ));
}
