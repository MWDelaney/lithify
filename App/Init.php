<?php
namespace MWDelaney\Lithify;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Init class for Lithify.
 */
class Init
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Add the lithify command to WP-CLI
        new CLI();
    }
}
