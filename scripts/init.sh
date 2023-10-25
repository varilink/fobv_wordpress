# ------------------------------------------------------------------------------
# wp-scripts/init.sh
# ------------------------------------------------------------------------------

# WP-CLI actions to initialise this WordPress site. These actions can be applied
# to any new installation of the site to put in place its skeleton structure and
# theme. They are constructed so as to be idempotent, so that they can be rerun
# if needed.

# -------
# Plugins
# -------

# Plugins that are installed from the WordPress Plugin Directory and so the
# versions of these plugins used are controlled by the install command. Note
# that the restricted-site-access plugin is only activated when needed.
wp plugin install contact-form-7 --activate
wp plugin install restricted-site-access
wp plugin install wp-mail-smtp --activate

# My plugins that are installed from source repositories using Ansible. The
# versions of these plugins used are controlled by Git.
wp plugin activate fobv-event
wp plugin activate fobv-site
wp plugin activate varilink-forms
wp plugin activate varilink-mailchimp
wp plugin activate varilink-paypal

# ----------
# Permalinks
# ----------

wp option update permalink_structure /%postname%/
wp rewrite flush

# -----
# Menus
# -----

# We create "classic" menus that can then be manually imported within the block
# theme used by this website. There does not yet seem to be a straightforward
# way to create the new type of menus used in block themes with their menu
# items, short of setting the blocks in the post_content for the menu post.

for menu in 'Main Menu' 'Visit the Viaduct Menu' 'Support our Charity Menu'
do

  if [[ ! $(                                                                   \
    wp menu list --format=json |                                               \
    jq ".[] | select(.name == \"$menu\") | .term_id"                           \
  ) ]]
  then
    wp menu create "$menu"
  fi

done

# ----------------
# Theme activation
# ----------------

wp theme activate fobv-site

# --------------
# Images (theme)
# --------------

wp option update uploads_use_yearmonth_folders 0

images="footer-logo.webp header-logo.webp viaduct-panorama-1.webp"
images="$images viaduct-panorama-2.webp viaduct-panorama-3.webp"
images="$images viaduct-panorama-4.webp viaduct-panorama-5.webp"
images="$images viaduct-panorama-6.webp viaduct-panorama-7.webp"
images="$images viaduct-panorama-8.webp viaduct-panorama-9.webp"
images="$images viaduct-panorama-10.webp"

for image in $images
do

  # If we ever add an attachment with the same name as an existing attachment
  # WordPress resolves this by adding '-' followed by an integer to the name.
  # So include what are effectively duplicates if any are found when deleting
  # existing posts associated with this image.

  for post_name in $(                                                          \
    wp post list --post_type=attachment --field=name                           \
     | grep "^${image%.*}\(-[[:digit:]]\)\?" | tr '\n' ' '                     \
  )
  do

    # A post list based on a post's name should only return one ID but since
    # post list can return an empty list or a list containing more than one ID
    # we use xargs.

    wp post list --post_type=attachment --name=$post_name --format=ids        \
     | xargs --no-run-if-empty wp post delete --force

  done

  wp_content="$(wp eval 'echo ABSPATH;')/wp-content"

  id=$(                                                                        \
    wp media import                                                            \
      $(wp eval 'echo ABSPATH;')/wp-content/uploads/fobv-media/$image.webp     \
      --porcelain
  )

  if [ "$image" = 'header-logo.webp' ]
  then

    wp option update site_logo $id

  fi

done

wp option update uploads_use_yearmonth_folders 1

# ----------------
# Pages (skeleton)
# ----------------

# Create the top-level pages that form the skeleton of the site. These commands
# are constructed so that if they only act if the pages aren't already there.
# This is so that we don't lose user updates on reruns. Note that I'm finding
# that trying to list posts based on post name isn't reliable, which is strange
# because I'm sure it's worked before, hence the pipe to `jq`.

# Page vars to hold page details. Var names can include '_' but not '-'.
declare -A home_page
home_page[title]='Bennerley Viaduct: The Iron Giant'
home_page[menus]='Main Menu'
home_page[featured_image]=viaduct-panorama-1
declare -A visit_the_viaduct
visit_the_viaduct[title]='Visit the Viaduct'
visit_the_viaduct[menus]='Main Menu:Visit the Viaduct Menu'
visit_the_viaduct[featured_image]=viaduct-panorama-2
visit_the_viaduct[template]=visit-the-viaduct-section-page
declare -A getting_there
getting_there[title]='Getting There'
getting_there[menus]='Visit the Viaduct Menu'
getting_there[featured_image]=viaduct-panorama-3
getting_there[template]=visit-the-viaduct-section-page
declare -A history
history[title]=History
history[menus]='Visit the Viaduct Menu'
history[featured_image]=viaduct-panorama-4
history[template]=visit-the-viaduct-section-page
declare -A support_our_charity
support_our_charity[title]='Support our Charity'
support_our_charity[menus]='Main Menu:Support our Charity Menu'
support_our_charity[featured_image]=viaduct-panorama-5
support_our_charity[template]=support-our-charity-section-page
declare -A about_us
about_us[title]='About Us'
about_us[menus]='Support our Charity Menu'
about_us[featured_image]=viaduct-panorama-6
about_us[template]=support-our-charity-section-page
declare -A latest_news
latest_news[title]='Latest News'
latest_news[menus]='Support our Charity Menu'
latest_news[featured_image]=viaduct-panorama-7
latest_news[template]=support-our-charity-section-page

for page_var in \
  home_page \
  visit_the_viaduct getting_there history \
  support_our_charity about_us latest_news
do

  post_name=`echo -n $page_var | tr '_' '-'`

  declare -n this_page_var=$page_var

  # Get the ID of the page if it already exists.
  ID=$(                                                                        \
    wp post list --fields=ID,name --format=json --post_type=page |             \
    jq ".[] | select(.post_name == \"$post_name\") | .ID"                      \
  )

  if [[ ! $ID ]]
  then

    # The page didn't already exist so create it.
    ID=$(                                                                      \
      wp post create                                                           \
      --post_type=page --post_status=publish --porcelain                       \
      --post_title="${this_page_var[title]}" --post_name=$post_name            \
    )

  fi

# ----------
# Menu Items
# ----------

  IFS=:
  for menu in ${this_page_var[menus]}
  do

    if [[ ! $(                                                                 \
      wp menu item list "$menu" --fields=db_id,title --format=json |           \
      jq ".[] | select(.title == \"${this_page_var[title]}\") | .db_id"
    ) ]]
    then
      wp menu item add-post "$menu" $ID
    fi

  done

# --------------------
# Page featured images
# --------------------

  wp post meta update $ID _thumbnail_id $(                                     \
    wp post list --post_type=attachment --fields=ID,name --format=json | jq    \
    ".[] | select(.post_name == \"${this_page_var[featured_image]}\") | .ID"   \
  )

# --------------
# Page templates
# --------------

  if [[ "${this_page_var[template]}" ]]
  then
    wp post meta update $ID _wp_page_template ${this_page_var[template]}
  fi

  unset -n this_page_var

done

# --------------
# Option updates
# --------------

wp option update show_on_front page
wp option update page_on_front $(                                              \
  wp post list --fields=ID,name --format=json --post_type=page |               \
    jq '.[] | select(.post_name == "home-page") | .ID'                         \
)

# ---------------------------------
# Editor role access to site editor
# ---------------------------------

wp cap add administrator fobv_manage_options
wp cap add editor edit_theme_options
wp cap add editor fobv_manage_options

# -------------------------------------
# Disable comments and pings by default
# -------------------------------------

wp option update default_pingback_flag ""
wp option update default_ping_status ""
wp option update default_comment_status ""

# ------------------------------------------------------
# Disable comments and pings on existing posts and pages
# ------------------------------------------------------

wp post list --format=ids                                                      \
  | xargs --no-run-if-empty wp post update --comment_status=closed
wp post list --format=ids                                                      \
  | xargs --no-run-if-empty wp post update --ping_status=closed
wp post list --post_type=page --format=ids                                     \
  | xargs --no-run-if-empty wp post update --ping_status=closed
