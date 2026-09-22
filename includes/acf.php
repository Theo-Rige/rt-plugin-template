<?php

namespace RT;

require_once RT_PLUGIN_PATH . 'includes/form.php';


class ACF {

    /**
     * Initializes the ACF class.
     */
    public static function init() {
        add_filter('acf/settings/load_json', [self::class, 'addJsonLoadPath']);
        add_filter("acf/settings/save_json/key=post_type_6ab2376e22fde", [self::class, 'getJsonPath']);
        add_filter("acf/settings/save_json/key=group_6ab239d71dcaa", [self::class, 'getJsonPath']);
    }

    /**
     * Get the path to the ACF JSON folder.
     * 
     * @return string The path to the ACF JSON folder.
     */
    public static function getJsonPath() {
        return RT_PLUGIN_PATH . 'acf-json';
    }

    /**
     * Add the ACF JSON load path.
     * 
     * @param array $paths The existing ACF JSON load paths.
     * 
     * @return array The modified ACF JSON load paths.
     */
    public static function addJsonLoadPath($paths) {
        $paths[] = self::getJsonPath();

        return $paths;
    }
}
