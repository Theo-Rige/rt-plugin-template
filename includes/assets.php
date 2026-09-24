<?php

namespace RT;

class Assets {

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
