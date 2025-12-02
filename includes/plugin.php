<?php

namespace RT;

require_once RT_PLUGIN_DIR . 'includes/tool.php';

class Plugin
{
    const SHORTCODE = 'rt-shortcode';

    /**
     * Initializes the plugin.
     *
     * @return void
     */
    public static function init()
    {
        self::loadTextDomain();
        add_action('init', [self::class, 'registerCustomPostTypes']);
        add_action('wp_enqueue_scripts', [self::class, 'registerScripts']);
        add_shortcode('wp-shortcode', [self::class, 'renderShortcode']);
    }

    /**
     * Loads the text domain for the plugin.
     *
     * This method is responsible for loading the translation files for the plugin.
     * It uses the `load_plugin_textdomain()` function to load the translation files
     * from the 'languages' directory of the plugin.
     *
     * @return void
     */
    private static function loadTextDomain()
    {
        load_plugin_textdomain(RT_PLUGIN_DOMAIN, false, dirname(RT_PLUGIN_BASENAME) . '/languages');
    }

    /**
     * Registers the custom post types for the plugin.
     *
     * @return void
     */
    public static function registerCustomPostTypes()
    {
        register_post_type('custom_post_type', [
            'labels' => [
                'name' => __('Custom Post Type', 'rt-plugin-template'),
                'singular_name' => __('Custom Post Type', 'rt-plugin-template'),
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'custom-post-type'],
            'menu_icon' => 'dashicons-admin-post',
            'supports' => ['title', 'editor', 'thumbnail'],
        ]);
    }

    /**
     * Registers the scripts and styles for the plugin.
     *
     * @return void
     */
    public static function registerScripts()
    {
        global $post;

        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, self::SHORTCODE)) {
            wp_enqueue_script('script', RT_PLUGIN_URL . 'assets/dist/js/script.min.js', [], RT_PLUGIN_VERSION, true);
            wp_enqueue_style('style', RT_PLUGIN_URL . 'assets/dist/css/style.min.css', [], RT_PLUGIN_VERSION);
        }
    }

    /**
     * Renders the shortcode for the plugin.
     *
     * This function is responsible for enqueueing necessary scripts and styles,
     * and loading the template for the shortcode.
     */
    public static function renderShortcode()
    {
        return Tool::loadTemplate('shortcode');
    }

    /**
     * Create the necessary database table at plugin activation, and flush links after custom post type creation.
     *
     * @return void
     *
     * @see https://developer.wordpress.org/reference/functions/register_post_type/#flushing-rewrite-on-activation
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

        // self::registerCustomPostTypes();
        // flush_rewrite_rules();
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
