<?php
/*
Plugin Name:
Plugin URI:
Description:
Version: 1.0.0
author:
author uri:
developer:
developer uri:
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
