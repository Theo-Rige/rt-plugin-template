<?php

namespace RT;

class Assets {
    /**
     * The URL of the Vite development server.
     */
    private const VITE_DEV_URL = 'http://localhost:5173/';
    /**
     * Store the handles of development scripts.
     */
    private static array $devScripts = [];

    /**
     * Store the development server state (null initially, then boolean).
     */
    private static ?bool $isDev = null;

    /**
     * Initialize the Assets class.
     */
    public static function init() {
        add_filter('script_loader_tag', [self::class, 'addModuleType'], 10, 3);
    }

    /**
     * Check if the development mode is active.
     *
     * @return bool True if in development mode, false otherwise.
     */
    private static function isDevMode(): bool {
        if (null !== self::$isDev) return self::$isDev;

        self::$isDev = false;
        $response    = wp_remote_get(self::VITE_DEV_URL, ['timeout' => 0.2]);

        if (!is_wp_error($response)) {
            $code = wp_remote_retrieve_response_code($response);

            if ($code === 200 || $code === 404) {
                self::$isDev = true;
            }
        }

        return self::$isDev;
    }

    /**
     * Enqueue a Vite asset, handling both development and production environments.
     *
     * @param string $handle The handle for the script or style.
     * @param string $relativePath The relative path to the asset file.
     * @param array $dependencies Optional. An array of dependencies.
     * @param bool $isScript Optional. Whether the asset is a script.
     */
    public static function enqueueViteAsset($handle, $relativePath, $dependencies = [], $isScript = false) {
        $distURL    = RT_PLUGIN_URL . 'dist/';
        $distPath   = RT_PLUGIN_PATH . 'dist/';

        if (self::isDevMode()) {
            if ($isScript) {
                if (!wp_script_is('vite-client', 'enqueued')) {
                    wp_enqueue_script('vite-client', self::VITE_DEV_URL . '@vite/client', [], null, true);
                }

                wp_enqueue_script($handle, self::VITE_DEV_URL . 'assets/' . $relativePath, $dependencies, null, true);

                self::$devScripts[] = $handle;
            } else {
                $devPath = $relativePath;

                if (strpos($devPath, 'css/') === 0) $devPath = str_replace('css/', 'scss/', $devPath);

                $devPath = str_replace('.css', '.scss', $devPath);

                wp_enqueue_style($handle, self::VITE_DEV_URL . 'assets/' . $devPath, $dependencies, null);
            }
        } else {
            $pathInfo = pathinfo($relativePath);
            $basePath = $pathInfo['dirname'] . '/' . $pathInfo['filename'];

            $basePath = preg_replace('/^(js|css)\//', '', $basePath);

            if ($isScript) {
                $fileUrl  = $distURL . 'js/' . $basePath . '.min.js';
                $filePath = $distPath . 'js/' . $basePath . '.min.js';

                if (!file_exists($filePath)) {
                    error_log("The JS file for handle '$handle' does not exist at path: " . $filePath);
                    return;
                }

                wp_enqueue_script($handle, $fileUrl, $dependencies, RT_PLUGIN_VERSION, true);
            } else {
                $fileUrl  = $distURL . 'css/' . $basePath . '.min.css';
                $filePath = $distPath . 'css/' . $basePath . '.min.css';

                if (!file_exists($filePath)) {
                    error_log("The CSS file for handle '$handle' does not exist at path: " . $filePath);
                    return;
                }

                wp_enqueue_style($handle, $fileUrl, $dependencies, RT_PLUGIN_VERSION);
            }
        }
    }

    /**
     * Add type="module" to Vite scripts in development mode.
     *
     * @param string $tag The original script tag.
     * @param string $handle The script handle.
     * @param string $src The script source URL.
     * 
     * @return string Modified script tag with type="module" if applicable.
     */
    public static function addModuleType($tag, $handle, $src) {
        if ('vite-client' === $handle || in_array($handle, self::$devScripts, true)) {
            return str_replace('<script ', '<script type="module" ', $tag);
        }

        return $tag;
    }
}
