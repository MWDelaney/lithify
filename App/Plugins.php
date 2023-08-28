<?php
namespace MWDelaney\Lithify;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

class Plugins
{
    /**
     * Get the plugins curently installed
     */
    public static function getInstalledPlugins()
    {
        $plugins = get_plugins();
        $installed_plugins = [];
        foreach ($plugins as $plugin => $data) {
            // Get the name and version of the plugin
            $name = explode('/', $plugin)[0];
            $version = $data['Version'];
            // Add the plugin and version to the array
            $installed_plugins[$name] = $version;
        }
        return $installed_plugins;
    }


    /**
     * Check if the plugin is registered at wordpress.org
     */
    public static function pluginExists($plugin)
    {
        $url = 'https://wordpress.org/plugins/' . $plugin . '/';
        $headers = get_headers($url);
        if (strpos($headers[0], '200')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the plugins that are available on wpackagist
     */
    public static function getWpackagistPlugins($plugins)
    {
        $wpackagist_plugins = [];
        foreach ($plugins as $plugin => $version) {
            if (self::pluginExists($plugin)) {
                $wpackagist_plugins[$plugin] = $version;
            }
        }
        return $wpackagist_plugins;
    }

    /**
     * Get the plugins that are not available on wpackagist
     */
    public static function getOtherPlugins($plugins)
    {
        $other_plugins = [];
        foreach ($plugins as $plugin => $version) {
            if (! self::pluginExists($plugin)) {
                $other_plugins[$plugin] = $version;
            }
        }
        return $other_plugins;
    }
}
