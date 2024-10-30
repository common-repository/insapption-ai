<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Provide a admin area help view for the plugin
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
<div class="insai-container" id="insaiHelpPage">
    <div class="insai-page-head">
        <div class="insai-head-logo">
            <img src="<?php echo esc_url(INSAI_PLUGIN_DIR_URL . 'img/insai-icon.png'); ?>" class="insai-icon" alt="">
            <h1><?php echo esc_html('InsapptionAI Help'); ?></h1>
        </div>
        <div class="">
            <button class="insai-primary-button"><?php echo esc_html('Contact Us!'); ?></button>
        </div>
    </div>
    <div class="">
        <div class="insai-row insai-overview-container">
            <h2 class="insai-question"><?php echo esc_html('Overview'); ?></h2>
            <div class="insai-answer">
                <ul class="insai-overview-questions-list">
                    <li style="margin-top: 15px;">
                        <span><?php echo esc_html('Getting Started'); ?></span>
                        <ul>
                            <li>
                                <a href="#connect-account"><?php echo esc_html('How do I connect to my InsapptionAI account?'); ?></a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="insai-overview-questions-list">
                    <li style="margin-top: 15px;">
                        <span><?php echo esc_html('Generating Content'); ?></span>
                        <ul>
                            <li>
                                <a href="#generate-content"><?php echo esc_html('How do I generate content?'); ?></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="insai-row" id="connect-account">
            <h2 class="insai-question"><?php echo esc_html('Q: How do I connect to my InsapptionAI account?'); ?></h2>
            <div class="insai-answer">
                <p><?php echo esc_html('Not sure how to connect the plugin to your Insapption AI account? Please see and follow the steps below that explain how to do this.'); ?></p>
                <ol>
                    <li><?php echo sprintf(esc_html('Go to the %s page in WordPress.'), '<a href="./admin.php?page=insapption-ai" target="_BLANK">Insapption AI</a>'); ?></li>
                    <li><?php echo esc_html('Enter your API Key into the API Key field.'); ?></li>
                    <li><?php echo esc_html('Your Website address will be auto-filled.'); ?></li>
                    <li><?php echo esc_html('Click the Connect button.'); ?></li>
                </ol>
                <p><?php echo esc_html('Once you have done this, we will check if your API key exists and connect the plugin on your site to your Insapption AI account.'); ?></p>
            </div>
        </div>

        <div class="insai-row" id="generate-content">
            <h2 class="insai-question"><?php echo esc_html('Q: How do I generate content?'); ?></h2>
            <div class="insai-answer">
                <p><?php echo esc_html('Unsure about content creation? Take a look at the following steps that provide a brief guide on using our Insapption AI Gutenberg block to generate content.'); ?></p>
                <ol>
                    <li><?php echo esc_html('Create or Edit a post.'); ?></li>
                    <li><?php echo esc_html('Add the Insapption AI block.'); ?></li>
                    <li><?php echo esc_html('Select the language and type of content that you want to generate.'); ?></li>
                    <li><?php echo esc_html('Give the AI information to work with.'); ?></li>
                    <li><?php echo esc_html('Turn on the Generate Image section if you want to generate image-related content.'); ?></li>
                    <li><?php echo esc_html('Click the Generate Content button.'); ?></li>
                </ol>
                <div class="insai-gif-container">
                    <img src="<?php echo esc_url(INSAI_PLUGIN_DIR_URL . 'img/how-to-1.gif'); ?>" alt="" class="insai-gif insai-gif-half">
                    <img src="<?php echo esc_url(INSAI_PLUGIN_DIR_URL . 'img/how-to-2.gif'); ?>" alt="" class="insai-gif insai-gif-half">
                </div>
                <p><?php echo esc_html('Once you have done the above steps, the AI will start generating content and output the content in the post editor.'); ?></p>
            </div>
        </div>

    </div>
</div>