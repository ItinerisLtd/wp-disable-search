<?php
/**
 * Plugin Name:     Disable Search
 * Plugin URI:      https://www.itineris.co.uk/
 * Description:     Disable WP Search
 * Version:         0.1.0
 * Author:          Itineris Limited
 * Author URI:      https://www.itineris.co.uk/
 * Text Domain:     wp-disable-search
 */

declare(strict_types=1);

namespace Itineris\WPDisableSearch;

use WP_Query;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

add_action('parse_query', function (WP_Query $query, bool $error = true): void {
    if (! is_search()) {
        return;
    }

    $query->is_search = false;
    $query->query_vars['s'] = false;
    $query->query['s'] = false;

    if ($error) {
        $query->is_404 = true;
    }
}, 10, 2);

add_filter('get_search_form', '__return_empty_string');

add_action('widgets_init', function (): void {
    unregister_widget('WP_Widget_Search');
});

add_filter('disable_wpseo_json_ld_search', '__return_true');
