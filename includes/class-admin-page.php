<?php
/**
 * AdminPage class for the Challenge Plugin.
 *
 * @package ChallengePlugin
 */

namespace ChallengePlugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Admin_Page {
    public function __construct( ) {
        add_action( 'admin_menu', array( $this, 'register') );
    }

    public function render() {
        wp_enqueue_script( 'challenge-admin-js', CHALLENGE_PLUGIN_URL . 'js/admin.js', array(), CHALLENGE_PLUGIN_VERSION, true );
        wp_enqueue_style( 'challenge-admin-css', CHALLENGE_PLUGIN_URL . 'css/admin.css', array(), CHALLENGE_PLUGIN_VERSION, 'all' );
?>
<div class="frm_wrap">
<div id="frm_top_bar" class="frm_nav_bar">
	<a href="#" class="frm-header-logo">
        <img src="<?php echo CHALLENGE_PLUGIN_URL; ?>images/logo.svg" alt="" width="35px">
    </a>
	<div class="frm_top_left">
		<h1>
        API Table
        </h1>
	</div>
    <div id="frm-publishing">
        <button id="refresh-data" class="button frm-button-secondary frm_animate_bg"> Refresh Data </button>
    </div>        
</div>
<hr>
    <?php
            // Create an instance of the table
            $table = new Challenge_List_Table();
            $table->prepare_items();
            $table->display();
        

        echo '</div></div>';
    }   

    public function register() {
        add_menu_page(
            'Challenge Page',
            'My Challenge',
            'manage_options',
            'challenge-plugin',
            array( $this, 'render'),
            'dashicons-chart-area'
        );
    }    
}