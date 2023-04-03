<?php
define('WP_TESTS_DIR', '/var/www/docroot/tests/phpunit/includes');
// Load the WordPress test environment
require_once WP_TESTS_DIR . '/bootstrap.php';

define('WP_CORE_DIR', '/var/www/docroot');

require_once WP_CORE_DIR . '/wp-load.php';
require_once WP_CORE_DIR . '/wp-admin/includes/admin.php';

// Load the plugin files
require_once __DIR__ . '/../challenge-plugin.php';

// Activate the plugin
activate_plugin('challenge-plugin/challenge-plugin.php');
