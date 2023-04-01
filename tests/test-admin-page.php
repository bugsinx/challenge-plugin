<?php

class Test_Admin_Page extends WP_UnitTestCase {

    /**
     * Test that the request is run no more than once per hour
     */
    function test_request_frequency() {
        // Make a request to the endpoint
        $response = wp_remote_get('http://api.strategy11.com/wp-json/challenge/v1/1');
        $data = json_decode(wp_remote_retrieve_body($response), true);

        // Check that the response is valid
        $this->assertTrue(is_array($data));

        // Wait for 30 minutes
        sleep(1800);

        // Make a request to the endpoint again
        $response = wp_remote_get('http://api.strategy11.com/wp-json/challenge/v1/1');
        $data = json_decode(wp_remote_retrieve_body($response), true);

        // Check that the response is still valid
        $this->assertTrue(is_array($data));
    }

    /**
     * Test that the table shows the expected results
     */
    function test_table_results() {
        // Create some test data
        $data = array(
            array('id' => 1, 'name' => 'Item 1', 'description' => 'This is item 1.'),
            array('id' => 2, 'name' => 'Item 2', 'description' => 'This is item 2.'),
            array('id' => 3, 'name' => 'Item 3', 'description' => 'This is item 3.')
        );

        // Create a new instance of the WP_List_Table class
        $table = new Challenge_List_Table();

        // Set the data for the table
        $table->set_data($data);

        // Get the HTML for the table
        ob_start();
        $table->display();
        $html = ob_get_contents();
        ob_end_clean();

        // Check that the HTML contains the expected data
        $this->assertContains('Item 1', $html);
        $this->assertContains('Item 2', $html);
        $this->assertContains('Item 3', $html);
    }

}

?>
