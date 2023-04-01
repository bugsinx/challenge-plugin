<?php

class Test_Shortcode extends WP_UnitTestCase {

    /**
     * Test that the shortcode displays the correct data
     */
    function test_shortcode_display() {
        // Make a request to the endpoint and get the response data
        $response = wp_remote_get('http://api.strategy11.com/wp-json/challenge/v1/1');
        $data = json_decode(wp_remote_retrieve_body($response), true);

        // Create some test data
        $expected_output = '<table><thead><tr><th>ID</th><th>Name</th><th>Description</th></tr></thead><tbody>';
        foreach ($data as $item) {
            $expected_output .= '<tr><td>' . $item['id'] . '</td><td>' . $item['name'] . '</td><td>' . $item['description'] . '</td></tr>';
        }
        $expected_output .= '</tbody></table>';

        // Get the output of the shortcode
        $output = do_shortcode('[challenge_shortcode]');

        // Check that the output is correct
        $this->assertEquals($expected_output, $output);
    }

}

?>
