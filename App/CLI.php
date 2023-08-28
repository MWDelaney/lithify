<?php
namespace MWDelaney\Lithify;

use WP_CLI;
use WP_CLI_Command;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Init class for Lithify.
 */
class CLI
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Register the command
        WP_CLI::add_command('lithify', [$this, 'lithify'], [
            'shortdesc' => 'Converts a WordPress site to Bedrock.',


        ]);
    }

    // Divider for the CLI output
    private function divider($array, $item)
    {
        $divider = "├──";
        // If the key of this item is the last item in the array, change the divider
        if (array_key_last($array) == $item) {
            $divider = "└──";
        }
        return $divider;
    }


    /**
     * Lithify command.
     *
     */
    public function lithify($args, $assoc_args)
    {

        // Get the production URL from the database
        $prod_url = get_site_url();

        // If the production URL is empty, error
        if (empty($prod_url)) {
            WP_CLI::error('Production URL not found. Is WordPress installed?');
        }

        // Get the development URL from the .env file
        $dev_url = getenv('WP_HOME');

        // If the development URL is empty, error
        if (empty($dev_url)) {
            WP_CLI::error('ENV variable WP_HOME not found. Is Bedrock set up?');
        }

        // Get installed plugins from the plugins class
        $plugins = Plugins::getInstalledPlugins();
        $wpackagist_plugins = Plugins::getWpackagistPlugins($plugins);
        $other_plugins = Plugins::getOtherPlugins($plugins);
        $themes = Themes::getInstalledThemes();
        $wpackagist_themes = Themes::getWpackagistThemes($themes);
        $other_themes = Themes::getOtherThemes($themes);
        $mu_plugins = MuPlugins::getMuPlugins();

        // Display a spinner while the command runs
        echo WP_CLI::colorize('%g 🪨 Lithifying...%n');
        WP_CLI::line('');
        WP_CLI::line('');

        // // Make a colorized header for the database section of this command
        // echo WP_CLI::colorize('%y 🗃️  - Database%n');
        // WP_CLI::line('');
        // WP_CLI::log('-------');
        // WP_CLI::line('');

        // // Show proposed changes
        // echo WP_CLI::colorize(' - %r ' . $prod_url . ' ➡️  %g' . $dev_url . ' %n');
        // WP_CLI::line('');
        // echo WP_CLI::colorize(' - %r wp-content/uploads ➡️  %gapp/uploads %n');
        // WP_CLI::line('');
        // WP_CLI::line('');
        // WP_CLI::confirm('Replace database strings?');
        // WP_CLI::runcommand('search-replace ' . get_site_url() . '/wp-content/uploads ' . get_site_url() . '/app/uploads');
        // WP_CLI::log('Database strings replaced.');

        WP_CLI::line('');
        WP_CLI::line('');

        // Make a colorized header for the dependencies section of this command
        echo WP_CLI::colorize('🤖 - %yDependencies%n');
        WP_CLI::line('');

        // Plugins header
        echo WP_CLI::colorize('├── 🔌 %yPlugins%n');
        WP_CLI::line('');

        // Loop through the wpackagist plugins and show a line with its name and version
        // Composer plugins header
        echo WP_CLI::colorize('│    ├── 🐘 Plugins to be added with Composer');
        WP_CLI::line('');
        // If the wpackagist plugins array is empty, show a message
        if (empty($wpackagist_plugins)) {
            echo WP_CLI::colorize('│         └── %rNo plugins to add with Composer%n');
            WP_CLI::line('');
        } else {
            foreach ($wpackagist_plugins as $plugin => $version) {

                echo WP_CLI::colorize('│    │    ' . $this->divider($wpackagist_plugins, $plugin) . ' %g' . $plugin . ' %b(' . $version . ')%n');
                WP_CLI::line('');
            }
        }
        WP_CLI::line('│    │');

        // Git plugins header
        echo WP_CLI::colorize('│    ├── 🐙 Plugins to be added with Git');
        WP_CLI::line('');
        // If the other_plugins array is empty, show a message
        if (empty($wpackagist_plugins)) {
            echo WP_CLI::colorize('│         └── %rNo plugins to add with Git%n');
            WP_CLI::line('');
        } else {
            foreach ($other_plugins as $plugin => $version) {
                echo WP_CLI::colorize('│    │    ' . $this->divider($other_plugins, $plugin) . ' %g' . $plugin . ' %b(' . $version . ')%n');
                WP_CLI::line('');
            }
        }
        WP_CLI::line('│    │');

        // Mu-plugins header
        echo WP_CLI::colorize('│    ├── 🐙 mu-plugins to be added with Git');
        WP_CLI::line('');
        // if the mu_plugins array is empty, show a message
        if (empty($mu_plugins)) {
            echo WP_CLI::colorize('│    |    └── %rNo mu-plugins to add with Git%n');
            WP_CLI::line('');
        } else {
            foreach ($mu_plugins as $plugin => $version) {
                echo WP_CLI::colorize('│      │    ' . $this->divider($mu_plugins, $plugin) . ' %g' . $plugin . ' %b(' . $version . ')%n');
                WP_CLI::line('');
            }
        }
        WP_CLI::line('│    │');

        // Themes header
        echo WP_CLI::colorize('└── 🎨 %yThemes%n');
        WP_CLI::line('');

        // Loop through the wpackagist themes and show a line with its name and version
        // Composer themes header
        echo WP_CLI::colorize('     ├── 🐘 Themes to be added with Composer');
        WP_CLI::line('');
        // If the wpackagist themes array is empty, show a message
        if (empty($wpackagist_themes)) {
            echo WP_CLI::colorize('         └── %rNo themes to add with Composer%n');
            WP_CLI::line('');
        } else {
            foreach ($wpackagist_themes as $theme => $version) {
                echo WP_CLI::colorize('     │    ' . $this->divider($wpackagist_themes, $theme) . ' %g' . $theme . ' %b(' . $version . ')%n');
                WP_CLI::line('');
            }
        }
        WP_CLI::line('     │');

        // Git themes header
        echo WP_CLI::colorize('     └── 🐙 Themes to be added with Git');
        WP_CLI::line('');
        // If the other_themes array is empty, show a message
        if (empty($other_themes)) {
            echo WP_CLI::colorize('         └── %rNo themes to add with Git%n');
            WP_CLI::line('');
        } else {
            foreach ($other_themes as $theme => $version) {
                echo WP_CLI::colorize('          ' . $this->divider($other_themes, $theme) . ' %g' . $theme . ' %b(' . $version . ')%n');
                WP_CLI::line('');
            }
        }

        // // For each plugin to be added with Git, show a line with its name and version
        // echo WP_CLI::colorize('%y 🐙 🔌  Plugins to be added with Git%n');
        // WP_CLI::line('');

        // foreach ($other_plugins as $plugin => $version) {
        //     echo WP_CLI::colorize('  - %g' . $plugin . ' - %b' . $version . ' %n');
        //     WP_CLI::line('');
        // }
        // WP_CLI::line('');

        // // For each plugin to be added with Git, show a line with its name and version
        // echo WP_CLI::colorize('%y 🐙 🔌  mu-plugins to be added with Git%n');
        // WP_CLI::line('');

        // foreach ($mu_plugins as $plugin => $version) {
        //     echo WP_CLI::colorize('  - %g' . $plugin . ' - %b' . $version . ' %n');
        //     WP_CLI::line('');
        // }
        // WP_CLI::line('');

        // // For each theme from wpackagist, show a line with its name and version
        // echo WP_CLI::colorize('%y 🐘 🎨  Themes to be added with Composer%n');
        // WP_CLI::line('');
        // foreach ($themes as $theme => $version) {
        //     echo WP_CLI::colorize('  - %g' . $theme . ' - %b' . $version . ' %n');
        //     WP_CLI::line('');
        // }
        // WP_CLI::line('');

        // // For each theme to be added with Git, show a line with its name and version
        // echo WP_CLI::colorize('%y 🐙 🎨  Themes to be added with Git%n');
        // WP_CLI::line('');
        // foreach ($other_themes as $theme => $version) {
        //     echo WP_CLI::colorize('  - %g' . $theme . ' - %b' . $version . ' %n');
        //     WP_CLI::line('');
        // }

        WP_CLI::line('');
        WP_CLI::line('');
        WP_CLI::log('Generating Composer and Git commands...');
        $cmd = Utils::generateCommands($wpackagist_plugins, $other_plugins, $wpackagist_themes, $other_themes, $mu_plugins);
        WP_CLI::line('');
        WP_CLI::line('');

        WP_CLI::success("Lithification complete! 🎉");
        echo WP_CLI::colorize('⚠️  %YAction required:%n Copy the following commands and run them from your Bedrock directory (usually "site"):');
        WP_CLI::line('');
        WP_CLI::line('');
        echo WP_CLI::colorize('%b' . $cmd);
        WP_CLI::line('');
        WP_CLI::line('');
        WP_CLI::log('🪨');
    }
}
