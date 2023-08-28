<?php
namespace MWDelaney\Lithify;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

class Utils
{

    /**
     * Generate the complete series of Git and Composer commands
     */
    public static function generateCommands($wpackagist_plugins, $other_plugins, $wpackagist_themes, $other_themes, $mu_plugins)
    {
        $cmd = '';

        // Generate a composer.json require line for each plugin at its current version
        $cmd .= 'composer require';
        foreach ($wpackagist_plugins as $plugin => $version) {
            $cmd .= ' wpackagist-plugin/' . $plugin . ':^' . $version;
        }

        // Generate a git command to add each $other_plugin to the project
        foreach ($other_plugins as $plugin => $version) {
            $cmd .= ' && git add -f web/app/plugins/' . $plugin;
        }

        // Generate a composer.json require line for each theme at its current version
        $cmd .= ' && composer require';
        foreach ($wpackagist_themes as $theme => $version) {
            $cmd .= ' wpackagist-theme/' . $theme . ':' . $version;
        }

        // Generate a git command to add each $other_theme to the project
        foreach ($other_themes as $theme => $version) {
            $cmd .= ' && git add -f web/app/themes/' . $theme;
        }

        // Add mu-plugins to git
        foreach ($mu_plugins as $plugin => $version) {
            $cmd .= ' && git add -f web/app/mu-plugins/' . $plugin;
        }

        // Commit the changes
        $cmd .= ' && git commit -m "Add plugins and themes via Lithify"';

        // Return the complete output
        return $cmd;
    }
}
