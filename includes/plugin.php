<?php

namespace DOMAIN;

class Plugin
{
    public static function init()
    {
        self::loadTextDomain();
        add_action('wp_enqueue_scripts', [self::class, 'registerScripts']);
        add_shortcode('shortcode', [self::class, 'addShortcode']);
    }

    private static function loadTextDomain()
    {
        load_plugin_textdomain(PLUGIN_DOMAIN, false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public static function registerScripts()
    {
        wp_register_script('script', PLUGIN_URL . 'assets/js/script.min.js', [], PLUGIN_VERSION, true);
        wp_register_style('style', PLUGIN_URL . 'assets/css/style.min.css', [], PLUGIN_VERSION);
    }

    public static function addShortcode()
    {
        // wp_enqueue_script();
        // wp_enqueue_style();

        ob_start();
        include PLUGIN_DIR . 'templates/shortcode.php';
        return ob_get_clean();
    }

    /**
     * Create the necessary database table at plugin activation.
     *
     * @return void
     */
    public static function activate()
    {
        // global $wpdb;

        // $tableName = $wpdb->prefix . 'table';

        // $charsetCollate = $wpdb->get_charset_collate();

        // $sql = "CREATE TABLE IF NOT EXISTS $tableName (
        //             id mediumint(9) NOT NULL AUTO_INCREMENT,
        //             -- Add your columns here
        //             PRIMARY KEY  (id)
        //         ) $charsetCollate;";

        // require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // dbDelta($sql);
    }

    /**
     * Drop the database table at plugin uninstallation.
     * 
     * @return void
     */
    public static function uninstall()
    {
        // global $wpdb;

        // $tableName = $wpdb->prefix . 'table';

        // $sql = "DROP TABLE IF EXISTS $tableName";

        // $wpdb->query($sql);
    }
}
