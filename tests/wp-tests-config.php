<?php
// Define database configuration
define( 'DB_NAME', 'test_database_name' );
define( 'DB_USER', 'test_database_user' );
define( 'DB_PASSWORD', 'test_database_password' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

// Set WP_DEBUG to true
define( 'WP_DEBUG', true );

// Define paths to WordPress files
define( 'ABSPATH', dirname( __FILE__ ) . '/wordpress/' );
define( 'WP_CONTENT_DIR', dirname( ABSPATH ) . '/wp-content' );
define( 'WP_TESTS_DIR', dirname( __FILE__ ) . '/wordpress-tests-lib' );
define( 'WP_LANG_DIR', WP_CONTENT_DIR . '/languages' );
define( 'WP_DEFAULT_THEME', 'twentytwenty' );

// Define the URL for the site
define( 'WP_TESTS_DOMAIN', 'localhost' );
define( 'WP_TESTS_EMAIL', 'admin@example.org' );
define( 'WP_TESTS_TITLE', 'Test Site' );
define( 'WP_HOME', 'http://' . WP_TESTS_DOMAIN );
define( 'WP_SITEURL', 'http://' . WP_TESTS_DOMAIN . '/wordpress' );

// Define the test database table prefix
$table_prefix  = 'wp_';

// Include the WordPress test suite bootstrap file
require_once WP_TESTS_DIR . '/includes/bootstrap.php';
