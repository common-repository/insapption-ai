<?php

/**
 * Fired during plugin activation
 *
 * @link       https://insapption.com
 * @since      1.0.0
 *
 * @package    Insapption_Ai
 * @subpackage Insapption_Ai/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Insapption_Ai
 * @subpackage Insapption_Ai/includes
 * @author     Insapption Technology <ai@insapption.com>
 */
class Insapption_Ai_Block {

    public static function insapption_ai_register_block() {
        wp_register_script(
            'insapption-ai-block',
            plugins_url('block.js', __FILE__),
            array('wp-blocks', 'wp-editor', 'wp-components', 'wp-api'),
            filemtime(plugin_dir_path(__FILE__) . 'block.js')
        );
    
        register_block_type('insapption-ai/insapption-ai-block', array(
            'editor_script' => 'insapption-ai-block',
        ));
    }

}
