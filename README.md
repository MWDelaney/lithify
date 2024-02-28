# 🪨 Lithify for WordPress and Bedrock

Lithify is a WordPress plugin that adds a WP-CLI command to convert a traditional WordPress site into a Bedrock-style WordPress installation.

## Installation and Usage

1. Create a new Trellis site and initialize a new Git repository:

    ```bash
    $ mkdir example.com && cd example.com && trellis new . && git init
    ```

2. Update Trellis PHP version to match the version of PHP used by your WordPress site. For example, if your WordPress site is running PHP 7.4, update `trellis/group_vars/all/main.yml`:

    ```yaml
    php_version: "7.4"
    ```

3. Update Bedrock WordPress version to match the version of WordPress used by your WordPress site. For example, if your WordPress site is running WordPress 5.2.2, update `site/composer.json`:

    ```json
    "roots/wordpress": "5.2.2",
    ```

3. Update Bedrock PHP version to match the version from step 2:

    ```json
    "php": ">=7.4",
    ```

5. Copy your WordPress `plugins`, `themes`, `mu-plugin`, and `uploads` directories into the Bedrock `site/web/app` directory.

6. Add Lithify as a dependency to Bedrock:

    ```bash
    $ composer require mwdelaney/lithify
    ```

7. SSH to your development server and navigate to the Bedrock directory:

    ```bash
    $ trellis ssh development
    $ cd /srv/www/example.com/current
    ```

8. Import your WordPress database:

    ```bash
    $ wp db import example.sql
    ```

9. Activate Lithify:

    ```bash
    $ wp plugin activate lithify
    ```

10. Run the `lithify` command and follow the prompts to lithify your site:

    ```bash
    $ wp lithify
    ```
