#!/bin/sh

. ./odpkg.env

echo "setting production.yml"
sed -i -e"s|__WP_URL__|$WP_URL|g" ./dashboard/config/settings/production.yml
sed -i -e"s|__CKAN_URL__|$CKAN_URL|g" ./dashboard/config/settings/production.yml
sed -i -e"s|__GOOGLE_ANALYTICS_ID__|$DASHBOARD_GOOGLE_ANALYTICS_ID|g" ./dashboard/config/settings/production.yml
sed -i -e"s|__GOOGLE_MAP_KEY__|$GOOGLE_MAP_KEY|g" ./dashboard/config/settings/production.yml


echo "setting custom_option.ini"
cp -f ./ckan/custom_options.ini.org ./ckan/custom_options.ini
sed -i -e"s|__WP_URL__|$WP_URL|g" ./ckan/custom_options.ini
sed -i -e"s|__RAILS_URL__|$RAILS_URL|g" ./ckan/custom_options.ini
sed -i -e"s|__GOOGLE_ANALYTICS_ID__|$CKAN_GOOGLE_ANALYTICS_ID|g" ./ckan/custom_options.ini

echo "setting wordpress.sql"
cp -f ./mysql/wordpress.sql.org ./mysql/wordpress.sql
sed -i -e"s|__GOOGLE_ANALYTICS_ID__|$WP_GOOGLE_ANALYTICS_ID|g" ./mysql/wordpress.sql
sed -i -e"s|__CKAN_URL__|https:\/\/$CKAN_URL|g" ./mysql/wordpress.sql
sed -i -e"s|__WP_URL__|https:\/\/$WP_URL|g" ./mysql/wordpress.sql
sed -i -e"s|__RAILS_URL__|https:\/\/$RAILS_URL|g" ./mysql/wordpress.sql
sed -i -e"s|__MAIL_FROM__|$MAIL_FROM|g" ./mysql/wordpress.sql
sed -i -e"s|__SMTP_HOST__|$SMTP_HOST|g" ./mysql/wordpress.sql
sed -i -e"s|__SMTP_PORT__|$SMTP_PORT|g" ./mysql/wordpress.sql
sed -i -e"s|__SMTP_USER__|$SMTP_USER|g" ./mysql/wordpress.sql
sed -i -e"s|__SMTP_PASS__|$SMTP_PASS|g" ./mysql/wordpress.sql
sed -i -e"s|__SMTP_AUTH__|$SMTP_AUTH|g" ./mysql/wordpress.sql
sed -i -e"s|__SMTP_SSL__|$SMTP_SSL|g" ./mysql/wordpress.sql

echo "setting colors"
sed -i -e"s|0097E0|$MAIN_COLOR|ig" ./ckan/ckanext-bodik_theme/ckanext/bodik_theme/public/bodik_odcs.css
sed -i -e"s|58C5F9|$SUB_COLOR|ig" ./ckan/ckanext-bodik_theme/ckanext/bodik_theme/public/bodik_odcs.css
sed -i -e"s|0097E0|$MAIN_COLOR|ig" ./wordpress/wp-content/themes/odpkg/style.css
sed -i -e"s|58C5F9|$SUB_COLOR|ig" ./wordpress/wp-content/themes/odpkg/style.css
sed -i -e"s|0097E0|$MAIN_COLOR|ig" ./dashboard/app/assets/stylesheets/map.scss.erb
sed -i -e"s|58C5F9|$SUB_COLOR|ig" ./dashboard/app/assets/stylesheets/map.scss.erb

echo "create mount dir"
sudo mkdir -p /opt/odpkg/log/{postgresql,mysql}
sudo chmod -R 777 /opt/odpkg/log/

echo "change permission wp-content/"
chmod -R 777 wordpress/wp-content/
echo "change permission ckandata/"
sudo mkdir -p /opt/odpkg/ckan/data
sudo chmod -R 777 /opt/odpkg/ckan/data

echo "change ckan map data"
sudo patch -st ./ckan/ckan/ckanext/reclineview/theme/public/vendor/recline/recline.js ckan/ckan.patch
