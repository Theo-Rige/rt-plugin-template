<?php

namespace DOMAIN;

class Tool
{
    /**
     * Loads a template file and returns its output.
     *
     * @param string $path The path to the template file.
     * @return string The output of the template file.
     */
    public static function loadTemplate($path, $data = null, $echo = false)
    {
        if ($data) extract($data);

        $themeTemplate = get_stylesheet_directory() . '/' . PLUGIN_DOMAIN . "/$path.php";

        ob_start();
        require file_exists($themeTemplate) ? $themeTemplate : PLUGIN_DIR . "templates/$path.php";

        if ($echo) {
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
}
