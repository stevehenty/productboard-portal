# productboard Portal WordPress Plugin

Embed a productboard portal on a WordPress page using a shortcode.

## Instructions

Add a constant to wp-config.php with the secret key. The default constant name is `PRODUCTBOARD_KEY`.

Run `composer install`, activate the plugin and add the shortcode to a page.

Example:

[productboard url="your embed URL"]

Optional attributes:

- `annonymous_message` The message to display to users that are not logged in.
- `key_constant` Default: "PRODUCTBOARD_KEY" The name of the constant with the productboard secret key. If you have multiple portals you'll need to define multiple constants.
