<?php
/*
Plugin Name: RT Plugin Template
Plugin URI: https://github.com/Theo-Rige/wp-plugin-template
Description: A simple WordPress plugin template.
Text Domain: rt-plugin-template
Version: 1.0.0
author: Theo Rige
author uri: rigetheo.netlify.app
developer: Theo Rige
developer uri: rigetheo.netlify.app
*/

use RT\Plugin;

if (!defined('ABSPATH')) exit;

define('RT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('RT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RT_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('RT_PLUGIN_DOMAIN', 'rt-plugin-template');
define('RT_PLUGIN_VERSION', '1.0.0');

require_once RT_PLUGIN_DIR . 'includes/plugin.php';

register_activation_hook(__FILE__, [Plugin::class, 'activate']);
register_uninstall_hook(__FILE__, [Plugin::class, 'uninstall']);

Plugin::init();
