set -e

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

  # Get the ID of the page
  ID=$( wp post list --format=ids --post_type=page --name=$post_name )

# ----------
# Menu Items
# ----------

  IFS=:
  for menu in ${this_page_var[menus]}
  do

    if [ "${this_page_var[title]}" = 'Bennerley Viaduct: The Iron Giant' ]
    then
      menu_item_title='Home'
    else
      menu_item_title="${this_page_var[title]}"
    fi

    if [[ ! $(                                                                 \
      wp menu item list "$menu" --fields=db_id,title --format=json |           \
      jq ".[] | select(.title == \"$menu_item_title\") | .db_id"
    ) ]]
    then

      wp menu item add-post "$menu" $ID --title="$menu_item_title"

    fi

  done

# --------------------
# Page featured images
# --------------------

  wp post meta update $ID _thumbnail_id $(                                     \
    wp post list --format=ids --post_type=attachment                           \
      --name=${this_page_var[featured_image]}                                  \
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

wp option update show_on_front page
wp option update page_on_front $(                                              \
  wp post list --format=ids --post_type=page --name=home-page                  \
)
