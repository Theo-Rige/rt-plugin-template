<?php
/*
Plugin Name: RT Plugin Template
Plugin URI: https://github.com/Theo-Rige/wp-plugin-template
Description: A simple WordPress plugin template.
Version: 1.0.0
Author: Theo Rige
Author URI: https://rigetheo.netlify.app/
Developer: Theo Rige
Developer URI: https://rigetheo.netlify.app/
Text Domain: rt-plugin-template
Domain Path: /languages
*/

declare(strict_types=1);

use RT\Plugin;

defined('ABSPATH') || exit;

const RT_PLUGIN_DIR       = __DIR__;
const RT_PLUGIN_FILE      = __FILE__;
const RT_PLUGIN_PATH      = RT_PLUGIN_DIR . '/';
const RT_PLUGIN_DOMAIN    = 'rt-plugin-template';
const RT_PLUGIN_VERSION   = '1.0.0';

define('RT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('RT_PLUGIN_BASENAME', plugin_basename(__FILE__));

require_once RT_PLUGIN_PATH . 'includes/plugin.php';

register_activation_hook(__FILE__, [Plugin::class, 'activate']);
register_uninstall_hook(__FILE__, [Plugin::class, 'uninstall']);

Plugin::init();
