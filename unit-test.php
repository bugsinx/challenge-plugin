<?php

class Challenge_Test extends WP_UnitTestCase {

function test_data_requested_once_per_hour() {
   // Call AJAX endpoint multiple times within an hour
   for ( $i = 0; $i < 10; $i++ ) {
      $response = wp_remote_get( admin_url( 'admin-ajax.php?action=challenge_data' ) );
   }
   
   // Get the number of API requests made
   $api_requests = get_transient( 'challenge_api_requests' );

   // Ensure that API requests were only made once in the last hour
   $this->assertLessThanOrEqual( 1, $api_requests );
}

}
