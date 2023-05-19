# ------------------------------------------------------------------------------
# wp-scripts/init.sh
# ------------------------------------------------------------------------------

# WP-CLI actions to initialise this WordPress site

wp theme install wp-bootstrap-starter --version=3.3.6
wp theme activate wp-bootstrap-starter-child
wp theme delete twentyseventeen
wp theme delete twentynineteen
wp theme delete twentytwenty
