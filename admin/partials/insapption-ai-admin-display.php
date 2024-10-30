<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://insapption.com
 * @since      1.0.0
 *
 * @package    Insapption_Ai
 * @subpackage Insapption_Ai/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="insai-container">
    <?php if (!empty(get_option('insapption_ai_settings')['apikey'])) : ?>
        <div class="insai-settings-container">
            <div class="insai-settings-header">
                <div class="insai-settings-logo">
                    <img src="<?php echo esc_url(INSAI_PLUGIN_DIR_URL . 'img/insai-icon.png'); ?>" class="insai-icon" alt="">
                    <h1><?php echo esc_html('InsapptionAI Settings'); ?></h1>
                </div>
                <div class="insai-settings-buttons">
                    <a href="<?php echo esc_url('https://ai.insapption.com'); ?>" target="_blank" class="insai-primary-button"><?php echo esc_html('Visit InsapptionAI'); ?></a>
                    <button class="insai-danger-button" id="revoke_api_key"><?php echo esc_html('Unlink'); ?></button>
                </div>
            </div>
            <form method="post" id="insai-settings-form" action="post" class="insai-settings-form">
                <?php
                    // Add nonce field for security
                    wp_nonce_field( 'save_api_key_nonce', 'save_api_key_nonce_field' );
                ?>
                <div class="insai-input-group">
                    <label for="apiKey" class="insai-input-label"><?php echo esc_html('API Key'); ?></label>
                    <input type="text" id='apikey' class="insai-input-field" value="<?php echo esc_attr(get_option('insapption_ai_settings')['apikey']); ?>">
                </div>
                <p class="insai-small-text"><?php echo esc_html('You can find your API key on our website.'); ?></p>
                
                <div class="insai-input-group">
                    <label for="website_url" class="insai-input-label"><?php echo esc_html('Website Link'); ?></label>
                    <input type="text" class="insai-input-field" disabled id="website_url" value="<?php echo esc_url(get_site_url()); ?>">
                </div>
                
                <button class="insai-primary-button" type="submit"><?php echo esc_html('Save Changes'); ?></button>
            </form>
        </div>
    <?php else : ?>
        <div class="insai-welcome-container">
            <div class="insai-welcome-row">
                <div class="insai-welcome-logo-container">
                    <img src="<?php echo esc_url(INSAI_PLUGIN_DIR_URL . 'img/insapption-ai-logo.png'); ?>" alt="">
                </div>

                <div class="insai-welcome-text-container">
                    <p>
                        <?php echo esc_html('Please enter your '); ?>
                        <a href="<?php echo esc_url('https://ai.insapption.com/user/my-apis'); ?>"><?php echo esc_html('API Key'); ?></a>
                        <?php echo esc_html(' and the link to your website so that we may connect the plugin with your InsapptionAI account?'); ?> 
                    </p>
                </div>

                <div class="insai-welcome-form-container">
                    <form id="insapption-ai-form" method="post">
                        <?php
                            // Add nonce field for security
                            wp_nonce_field( 'connect_api_key_nonce', 'connect_api_key_nonce_field' );
                        ?>
                        <label for="apiKey"><?php echo esc_html('API Key'); ?></label>
                        <input type="text" name="apikey" id="apikey">
                        <br>
                        <label for="website_url"><?php echo esc_html('Website Link'); ?></label>
                        <input type="text" disabled id="website_url" value="<?php echo esc_url(get_site_url()); ?>">
                        <button class="insai-primary-button" type="submit"><?php echo esc_html('Connect'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
