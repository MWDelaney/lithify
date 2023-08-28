<?php
namespace MWDelaney\Lithify;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

class MuPlugins
{
    /**
     * Get the plugins curently installed
     */
    public static function getMuPlugins()
    {
      Error this doesn't seem to catch the mu-plugins in directories
        $plugins = get_mu_plugins();
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
}
