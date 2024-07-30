<?php
/*
Plugin Name: WP Plugin Template
Plugin URI: https://github.com/Theo-Rige/wp-plugin-template
Description: A simple WordPress plugin template.
Version: 1.0.0
author: Theo Rige
author uri: rigetheo.netlify.app
developer: Theo Rige
developer uri: rigetheo.netlify.app
*/

use DOMAIN\Plugin;

if (!defined('ABSPATH')) exit;

define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PLUGIN_DOMAIN', 'domain');
define('PLUGIN_VERSION', '1.0.0');

require_once PLUGIN_DIR . 'includes/plugin.php';

register_activation_hook(__FILE__, [Plugin::class, 'activate']);
register_uninstall_hook(__FILE__, [Plugin::class, 'uninstall']);

add_action('init', [Plugin::class, 'init']);
