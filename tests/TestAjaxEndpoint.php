<?php
/**
 * Test case for the Ajax_Handler class. Is the request run multiple times an hour?
 *
 * @package ChallengePlugin
 */
namespace ChallengePlugin;

require_once __DIR__ . '/../includes/class-ajax-handler.php';

class TestAjaxEndpoint extends \WP_UnitTestCase {

    public function test_api_call_limit() {
        // Setup test variables
        $handler = new Ajax_Handler(true);
        $http_count = 0;

        // Mock wp_remote_get to return cached data and count requests
        add_filter('pre_http_request', function ($preempt, $parsed_args, $url) use (&$http_count) {
            // Increment the request counter
            $http_count++;

            // Return mocked API response
            return array(
                'body' => json_encode(array('test' => 'value')),
                'response' => array(
                    'code' => 200,
                    'message' => 'OK'
                )
            );
        }, 10, 3);

        // First call should make an API request so it should count 1 request and set the data on transient cache
        $handler->get_data(true);
        $this->assertEquals(1, $http_count);

        // Second call should return cached data and not make an API request, so the count should still be 1
        $handler->get_data(true);
        $this->assertEquals(1, $http_count);

        // Set the transient expiration time to 1 second to simulate the passing of an hour but on 1 second
        set_transient('challenge_plugin_data', array('data' => array('test' => 'value')), 1);

        // Wait for 2 seconds so that the transient gets expired.
        sleep(2);

        // Third call should make an API request because the cache has expired
        $handler->get_data(true);
        $this->assertEquals(2, $http_count);
    }
}

