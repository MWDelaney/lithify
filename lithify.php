<?php
/**
 * Plugin Name: Lithify
 * Plugin URI: https://github.com/mwdelaney/lithify
 * Description: Lithify is a WordPress plugin generates a composer `require` command to assist in converting a traditional WordPress website into a Roots/Bedrock website.
 * Version: 0.1.0
 * Author: Michael Delaney
 * Author URI: https://github.com/mwdelaney/
 *
 * @package Lithify
 */

namespace MWDelaney\Lithify;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

// Require Composer autoloader if it exists.
require __DIR__ . '/vendor/autoload.php';

// Initialize the plugin
$lithify = new Init();
