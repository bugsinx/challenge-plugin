<?php

class Test_Ajax_Endpoint extends WP_UnitTestCase {

    /**
     * Test that the AJAX endpoint returns the correct data
     */
    function test_ajax_endpoint_data() {
        // Make a request to the endpoint and get the response data
        $response = wp_remote_get('http://api.strategy11.com/wp-json/challenge/v1/1');
        $data = json_decode(wp_remote_retrieve_body($response), true);

        // Make an AJAX request to the endpoint
        $_GET['action'] = 'challenge_ajax';
        ob_start();
        do_action('wp_ajax_challenge_ajax');
        $output = ob_get_clean();

        // Check that the output is correct
        $this->assertEquals($data, json_decode($output, true));
    }

}

?>
