# ------------------------------------------------------------------------------
# wp-scripts/restore.sh
# ------------------------------------------------------------------------------

# WP-CLI actions when restoring this WordPress site from a backup for desktop
# development and testing using fobv-docker.

wp search-replace www.bennerleyviaduct.org.uk fobv
wp search-replace https://fobv http://fobv
