<?php
/**
 * The admin specific functionality of the plugin.
 *
 * @since 1.0
 */

class Quizzie_Admin {

	protected $plugin_name;
	protected $plugin_version;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0
	 */
	public function __construct( $plugin_name, $plugin_version ) {
		$this->plugin_name    = $plugin_name;
		$this->plugin_version = $plugin_version;

		// Example action hook usage. Uncomment or delete.
		//add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}


	/**
	 * Enqueue scripts in WP admin
	 *
	 * @since   1.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'assets/js/quizzie-admin.js', null, $this->plugin_version, true );

	}

}
new Quizzie_Admin( $plugin_name, $plugin_version );
