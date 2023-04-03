<?php
/**
 * Shortcode class for the Challenge Plugin.
 *
 * @package ChallengePlugin
 */

namespace ChallengePlugin;

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode class.
 */
class Shortcode {

	/**
	 * Register the shortcode tag [challenge_plugin]
	 */
	public function __construct()
	{
		add_shortcode( 'challenge_plugin', array( $this, 'render_shortcode') );

	}
	/**
	 * Render the shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string Shortcode output.
	 */
	public function render_shortcode( $atts ) {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		ob_start();
		?>
		<table id="challenge-plugin-table">
			<tbody></tbody>
		</table>
		<?php
		return ob_get_clean();
	}

	/**
	 * Enqueue the necessary scripts.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'challenge-plugin-script', CHALLENGE_PLUGIN_URL . 'js/challenge-plugin-script.js', array( 'jquery' ), CHALLENGE_PLUGIN_VERSION, true );
		wp_localize_script( 'challenge-plugin-script', 'challenge_plugin_data', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'challenge_plugin_data_nonce' ),
		) );
	}
}
