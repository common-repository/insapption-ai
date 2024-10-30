<?php

class Insapption_Ai_Admin {

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('wp_ajax_save_validated_key_to_db', array($this, 'save_validated_key_to_db'));
		add_action('wp_ajax_revoke_validated_key_to_db', array($this, 'revoke_validated_key_to_db'));
	}

	public function revoke_validated_key_to_db() {
		check_ajax_referer( 'revoke_api_key_nonce', 'nonce' );

		$options = get_option('insapption_ai_settings');
		$options['apikey'] = '';
		update_option('insapption_ai_settings', $options);
		wp_die(); // All ajax handlers should die when finished
	}

	public function save_validated_key_to_db() {
		check_ajax_referer( 'save_api_key_nonce', 'nonce' );
		// Sanitize and validate nonce before using in wp_verify_nonce
        $nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, 'save_api_key_nonce' ) ) {
            wp_die( 'Permission check failed. Nonce verification failed.' );
        }
		
		if (isset($_POST['api_key'])) {
			$options = get_option('insapption_ai_settings');
			$options['apikey'] = sanitize_text_field(wp_unslash($_POST['api_key'])); // Sanitize user input
			update_option('insapption_ai_settings', $options);
		}
		wp_die(); // All ajax handlers should die when finished
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/insapption-ai-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/insapption-ai-admin.js',
			array( 'jquery' ),
			$this->version,
			false 
		);

		wp_localize_script( $this->plugin_name, 'insapption_ai_admin_ajax_obj', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'revoke_nonce' => wp_create_nonce( 'revoke_api_key_nonce' ), // Create nonce for revoking API key
			'save_nonce' => wp_create_nonce( 'save_api_key_nonce' ), // Create nonce for saving API key
		));

		$options = get_option('insapption_ai_settings');
		$website_url = get_site_url();

		if (is_array($options)) {
			wp_localize_script($this->plugin_name, 'insapption_ai_block_object', array(
				'apikey' => $options['apikey'],
				'websiteUrl' => $website_url
			));
		}
	}

	public function add_plugin_admin_menu() {
		add_menu_page(
            'Insapption AI', // Page title
            'Insapption AI', // Menu title
            'manage_options', // Capabilities
            'insapption-ai', // Menu slug
            array($this, 'display_plugin_admin_page') // Function
        );

		add_submenu_page(
			'insapption-ai', // Parent menu slug
			'Help', // Page title
			'Help', // Menu title
			'manage_options', // Capability required to access the page
			'insapption-ai-help', // Menu slug
			array($this, 'display_plugin_admin_help_page') // Function
		);
	}
	
	public function display_plugin_admin_page() {
        include_once plugin_dir_path(__FILE__) . 'partials/insapption-ai-admin-display.php';
    }

	public function display_plugin_admin_help_page() {
		include_once plugin_dir_path(__FILE__) . 'partials/insapption-ai-admin-help-display.php';
	}

	public function insapption_ai_settings_init() {
		register_setting( 'insapption_ai', 'insapption_ai_settings' );

		add_settings_section(
			'insapption_ai_apikey_section', 
			__( 'API Key', 'insapption-ai' ), 
			array($this, 'insapption_ai_section_callback'), 
			'insapption_ai'
		);
    
		add_settings_field( 
			'insapption_ai_apikey_field', 
			__( 'API Key', 'insapption-ai' ), 
			array($this, 'insapption_ai_apikey_render'), 
			'insapption_ai', 
			'insapption_ai_apikey_section' 
		);
	}

	public function insapption_ai_apikey_render() {
		$options = get_option('insapption_ai_settings');
		$escaped_apikey = esc_attr($options['apikey']); // Escape output
		
		if (!empty($options['apikey'])) {
			echo "<p>Your API Key is " . esc_html($options['apikey']) . "</p>"; // Escape output
			echo "<button id='revoke_api_key'>" . esc_html('Revoke API Key') . "</button>"; // Escape output
		} else {
			echo "<input type='text' id='apikey' name='insapption_ai_settings[apikey]' value='{$escaped_apikey}'>"; // Use escaped variable
		}
	}

	public function insapption_ai_section_callback() {
		echo esc_html__('Please enter your API key obtained from insapption', 'insapption-ai'); // Escape output
	}

	public function insapption_ai_options_page() {
		$options = get_option('insapption_ai_settings');
		$escaped_apikey = esc_attr($options['apikey']); // Escape output
		$website_url = esc_url(get_site_url()); // Escape output
		
		if (!empty($options['apikey'])) {
			echo "<p>Your API Key is " . esc_html($options['apikey']) . "</p>"; // Escape output
			echo "<button id='revoke_api_key'>" . esc_html('Revoke API Key') . "</button>"; // Escape output
			echo "<input type='hidden' id='apikey' value='{$escaped_apikey}'>"; // Use escaped variable
			echo "<input type='hidden' id='website_url' value='{$website_url}'>"; // Use escaped variable
		} else {
			?>
			<form id="insapption-ai-form" method='post'>
				<h2><?php esc_html_e('Insapption AI', 'insapption-ai'); ?></h2> <!-- Escape output and translate -->
				<?php
				settings_fields('insapption_ai');
				do_settings_sections('insapption_ai');
				submit_button();
				?>
				<input type="hidden" id="website_url" value="<?php echo esc_url(get_site_url()); ?>">
			</form>
			<?php
		}
	}
}