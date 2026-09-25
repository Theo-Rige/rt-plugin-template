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
     * Enqueue a static asset.
     *
     * @param string $handle The handle for the script or style.
     * @param string $relativePath The relative path to the asset file.
     * @param array $dependencies Optional. An array of dependencies.
     * @param bool $isScript Optional. Whether the asset is a script.
     * @param string $version Optional. The version of the asset.
     */
    public static function enqueueAsset($handle, $relativePath, $dependencies = [], $isScript = false, $version = RT_PLUGIN_VERSION) {
        if (!file_exists(RT_PLUGIN_PATH . 'assets/' . $relativePath)) {
            error_log("The asset file for handle '$handle' does not exist at path: " . RT_PLUGIN_PATH . 'assets/' . $relativePath);
            return;
        }

        if ($isScript) {
            wp_enqueue_script($handle, RT_PLUGIN_URL . 'assets/' . $relativePath, $dependencies, $version, true);
        } else {
            wp_enqueue_style($handle, RT_PLUGIN_URL . 'assets/' . $relativePath, $dependencies, $version);
        }
    }
}
