<?php

namespace RT;

class Tool {
    /**
     * Loads a template file and returns its output.
     *
     * @param string $path The path to the template file.
     * @return string The output of the template file.
     */
    public static function loadTemplate($path, $data = null, $echo = false) {
        if ($data) extract($data);

        $themeTemplate = get_stylesheet_directory() . '/' . RT_PLUGIN_DOMAIN . "/$path.php";

        ob_start();
        require file_exists($themeTemplate) ? $themeTemplate : RT_PLUGIN_PATH . "templates/$path.php";

        if ($echo) {
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }

    /**
     * Loads an SVG file and returns it as a string.
     *
     * @param string $name The name of the SVG file to load.
     * @param string|null $class Optional. The CSS class to apply to the SVG element. Default is null.
     * @return string The SVG file content as a string.
     */
    public static function loadSVG($name, $class = null) {
        ob_start();
        include RT_PLUGIN_PATH . 'assets/svg/' . $name . '.svg';
        $svg = ob_get_clean();
        $svg = str_replace('<svg', '<svg class="icon icon--' . (!empty($class) ? $class : $name) . '"', $svg);
        return $svg;
    }

    /**
     * Enqueue a JS file.
     * 
     * @param string $handle The name of the script. Should be unique.
     * @param string $path The path to the script file, relative to the plugin directory.
     * @param array $deps Optional. An array of registered script handles this script depends on. Default is an empty array.
     * @param string|null $version Optional. The version of the script. Default is the plugin version.
     * @param bool $inFooter Optional. Whether to enqueue the script before </body> instead of in the <head>. Default is true.
     */
    public static function enqueueScript($handle, $path, $deps = [], $version = RT_PLUGIN_VERSION, $inFooter = true) {
        if (!file_exists(RT_PLUGIN_PATH . 'assets/' . $path . '.min.js')) {
            error_log("The JS file for handle '$handle' does not exist at path: " . RT_PLUGIN_PATH . 'assets/' . $path . '.min.js');
            return;
        }

        wp_enqueue_script($handle, RT_PLUGIN_URL . 'assets/' . $path . '.min.js', $deps, $version, $inFooter);
    }

    /**
     * Enqueue a CSS file.
     * 
     * @param string $handle The name of the style. Should be unique.
     * @param string $path The path to the style file, relative to the plugin directory.
     * @param array $deps Optional. An array of registered style handles this style depends on. Default is an empty array.
     * @param string|null $version Optional. The version of the style. Default is the plugin version.
     * @param string $media Optional. The media for which this stylesheet has been defined. Default is 'all'.
     */
    public static function enqueueStyle($handle, $path, $deps = [], $version = RT_PLUGIN_VERSION, $media = 'all') {
        if (!file_exists(RT_PLUGIN_PATH . 'assets/' . $path . '.min.css')) {
            error_log("The CSS file for handle '$handle' does not exist at path: " . RT_PLUGIN_PATH . 'assets/' . $path . '.min.css');
            return;
        }

        wp_enqueue_style($handle, RT_PLUGIN_URL . 'assets/' . $path . '.min.css', $deps, $version, $media);
    }
}
