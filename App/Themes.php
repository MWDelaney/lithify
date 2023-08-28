<?php
namespace MWDelaney\Lithify;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

class Themes
{
    /**
     * Get the themes curently installed
     */
    public static function getInstalledThemes()
    {
        $themes = wp_get_themes();
        $installed_themes = [];
        foreach ($themes as $theme => $data) {
            // Get the name and version of the plugin
            $name = explode('/', $theme)[0];
            $version = $data['Version'];
            // Add the plugin and version to the array
            $installed_themes[$name] = $version;
        }
        return $installed_themes;
    }


    /**
     * Check if the theme is registered at wordpress.org
     */
    public static function themeExists($theme)
    {
        $url = 'https://wordpress.org/themes/' . $theme . '/';
        $headers = get_headers($url);
        if (strpos($headers[0], '200')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the themes that are available on wpackagist
     */
    public static function getWpackagistThemes($themes)
    {
        $wpackagist_themes = [];
        foreach ($themes as $theme => $version) {
            if (self::themeExists($theme)) {
                $wpackagist_themes[$theme] = $version;
            }
        }
        return $wpackagist_themes;
    }

    /**
     * Get the themes that are not available on wpackagist
     */
    public static function getOtherThemes($themes)
    {
        $other_themes = [];
        foreach ($themes as $theme => $version) {
            if (! self::themeExists($theme)) {
                $other_themes[$theme] = $version;
            }
        }
        return $other_themes;
    }
}
