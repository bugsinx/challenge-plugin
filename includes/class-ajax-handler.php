<?php
/**
 * AJAX handler class for the Challenge Plugin.
 *
 * @package ChallengePlugin
 */

namespace ChallengePlugin;

defined( 'ABSPATH' ) || exit;

/**
 * AJAX handler class.
 */
class Ajax_Handler {

    /**
     * Initialize the AJAX handler.
     */
    public function __construct( $init = true ) {
        if ( $init ) {
            add_action( 'wp_ajax_challenge_plugin_data', array( $this, 'get_data' ) );
            add_action( 'wp_ajax_nopriv_challenge_plugin_data', array( $this, 'get_data' ) );
            add_action( 'wp_ajax_challenge_plugin_refresh_data', array( $this, 'refresh_data' ) );
        }
    }

    /**
     * Get the data from the API endpoint.
     */
    public function get_data( $no_ajax = false ) {
        $data = self::get_cached_data();
        
        if ( ! empty( $data ) && true !== $no_ajax ) {
            wp_send_json_success( $data );
        }
        if ( ! empty( $data ) && true === $no_ajax ) {
            return $data;
        }        

        $response = wp_remote_get( 'http://api.strategy11.com/wp-json/challenge/v1/1' );
        if ( is_wp_error( $response )  && true !== $no_ajax ) {
            wp_send_json_error( array(
                'error' => $response->get_error_message(),
            ) );
        }

        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body );

        if ( empty( $data )  && true !== $no_ajax ) {
            wp_send_json_error( array(
                'error' => __( 'Error retrieving data from API endpoint.', 'challenge-plugin' ),
            ) );
        }

        self::cache_data( $data );
        if ( true !== $no_ajax ) {
            wp_send_json_success( $data );
        } else {
            return $data;
        }
    }

    /**
     * Refresh the cached data.
     */
    public function refresh_data() {        
        self::cache_data( null );

        if ( isset($_POST['ajax']) ) {
            wp_send_json_success( 1 );
        }
    }

    /**
     * Get the cached data.
     *
     * @return mixed The cached data, or null if there is no cached data.
     */
    private function get_cached_data() {
        $data = get_transient( 'challenge_plugin_data' );
        if ( empty( $data ) ) {
            return null;
        }

        return $data;
    }

    /**
     * Cache the data for 1 hour.
     *
     * @param mixed $data The data to cache, or null to clear the cache.
     */
    private function cache_data( $data ) {
        if ( empty( $data ) ) {
            delete_transient( 'challenge_plugin_data' );
            return;
        }

        set_transient( 'challenge_plugin_data', $data, HOUR_IN_SECONDS );
    }
}
