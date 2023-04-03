<?php
/**
 * Plugin Name: Challenge Plugin
 * Description: A plugin that retrieves data from an external API and displays it in a table using a shortcode and a WordPress admin page.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * Text Domain: challenge-plugin
 * Domain Path: /languages
 *
 * @package ChallengePlugin
 */

defined( 'ABSPATH' ) || exit;

// Define the plugin's root file and folder paths.
define( 'CHALLENGE_PLUGIN_VERSION', '1.0.0' );
define( 'CHALLENGE_PLUGIN_FILE', __FILE__ );
define( 'CHALLENGE_PLUGIN_DIR', plugin_dir_path( CHALLENGE_PLUGIN_FILE ) );
define( 'CHALLENGE_PLUGIN_URL', plugin_dir_url( CHALLENGE_PLUGIN_FILE ) );

// Load the autoloader.
require_once CHALLENGE_PLUGIN_DIR . 'autoloader.php';

// Instantiate plugin classes.
new ChallengePlugin\Admin_Page();
new ChallengePlugin\Shortcode();
new ChallengePlugin\Ajax_Handler();
new ChallengePlugin\WP_CLI_Commands();


