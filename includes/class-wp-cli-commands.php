<?php
/**
 * WP CLI commands for the Challenge Plugin.
 *
 * @package ChallengePlugin
 */

namespace ChallengePlugin;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\WP_CLI' ) ) {
    return;
}

/**
 * WP CLI commands.
 */
class WP_CLI_Commands {

    /**
     * Refresh the challenge plugin data.
     *
     * ## EXAMPLES
     *
     * wp challenge-plugin refresh-data
     *
     * @when after_wp_load
     */
    public function refresh_data() {
        // Implement the refresh logic here.
        // For example, you could delete any cached data.
        delete_transient( 'challenge_plugin_data' );
        \WP_CLI::success( 'Challenge Plugin data has been refreshed.' );
    }

}

// Register the WP CLI command.
\WP_CLI::add_command( 'challenge-plugin', __NAMESPACE__ . '\\WP_CLI_Commands' );
