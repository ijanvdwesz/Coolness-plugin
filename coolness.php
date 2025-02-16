<?php
/*
Plugin Name: Coolness
Plugin URI: https://www.IjansCV.wordpress.com/
Description: A plugin that keeps track of post views.
Version: 1.3
Author: Ijan van der Westhuizen
Author URI: https://www.IjansCV.wordpress.com/
License: Unlicensed
*/

// Increments view count for single posts
function coolness_new_view() {
    if (!is_single()) {
        return;
    }

    global $post;

    if (!isset($post) || !is_object($post)) {
        return;
    }

    $views = get_post_meta($post->ID, 'coolness_views', true);
    if (!$views) {
        $views = 0;
    }

    $views++;

    update_post_meta($post->ID, 'coolness_views', $views);
}
add_action('wp_head', 'coolness_new_view');

// Fetches and displays view count for a post
function coolness_views() {
    global $post;
    $views = get_post_meta($post->ID, 'coolness_views', true);

    // Ensures $views is treated as an integer
    $views = (int)$views;

    // dynamically generates view for 1 and views for plural
    $view_text = $views === 1 ? 'view' : 'views';
    return "This post has $views $view_text.";
}
// Appends view count to post content
function coolness_display_views($content) {
    if (is_single()) {
        $view_count = '<p style="text-align: center; margin-top: 20px; font-style: italic;">' . coolness_views() . '</p>';
        $content .= $view_count;
    }
    return $content;
}
add_filter('the_content', 'coolness_display_views');

// Sets default views to 0 for new posts
function coolness_set_default_views_on_create($post_id, $post, $update) {
    // Only acts on new posts (not updates)
    if ($update || $post->post_type !== 'post') {
        return;
    }

    // Checks if the post already has 'coolness_views' set
    $views = get_post_meta($post_id, 'coolness_views', true);
    if ($views === '') {
        // Explicitly sets to 0 if not already set
        update_post_meta($post_id, 'coolness_views', 0);
    }
}
add_action('wp_insert_post', 'coolness_set_default_views_on_create', 10, 3);

// Displays a list of top viewed posts
function coolness_list() {
    $searchParams = [
        'posts_per_page' => -1, // Retrieves all posts
        'post_type' => 'post',  // Only posts
        'post_status' => 'publish',  // Only published posts
        'meta_key' => 'coolness_views',  // The custom field for views
    ];

    $list = new WP_Query($searchParams);

    $posts_with_views = [];

    if ($list->have_posts()) {
        while ($list->have_posts()) {
            $list->the_post();
            $views = get_post_meta(get_the_ID(), 'coolness_views', true);
            if (!$views) {
                $views = 0; // Default's to 0 if no views are set
            }

            //dynamically generates correct plural/singular form for the top posts page
            $view_text = ($views == 1) ? 'view' : 'views'; // Make sure to check for singular/plural

            $posts_with_views[] = [
                'title' => get_the_title(),
                'link' => get_permalink(),
                'views' => $views,
                'view_text' => $view_text
            ];
        }

        // Sorts the array by 'views' in descending order
        usort($posts_with_views, function ($a, $b) {
            return $b['views'] - $a['views'];
        });

        // Displays the top 10 posts
        echo '<h1>Top Posts</h1><ol>';
        foreach (array_slice($posts_with_views, 0, 10) as $post) {
            echo '<li><a href="' . $post['link'] . '">' . $post['title'] . '</a> - ' . $post['views'] . ' ' . $post['view_text'] . '</li>';
        }
        echo '</ol>';
    } else {
        echo '<p>No posts found.</p>';
    }

    wp_reset_postdata();
}
// Register the [top_posts] shortcode
function coolness_register_shortcode() {
    add_shortcode('top_posts', 'coolness_list');
}
add_action('init', 'coolness_register_shortcode');