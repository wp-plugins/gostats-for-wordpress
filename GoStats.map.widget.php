<?php
/*
Plugin Name: GoStats Map Widget
Plugin URI: http://gostats.com
Description: GoStats Display Map Widget for WordPress
Author: Richard Chmura
Version: 1.3
Author URI: http://richardchmura.com
*/

function showMap() 
{
    global $gostats_siteid;
    global $gostats_server;

    $gostats_siteid = get_option('gostats_siteid');
    $gostats_server   = get_option('gostats_server');

  echo "<a href=\"http://gostats.com\"><img title=\"GoStats web traffic Map\" src=\"http://";
echo urlencode($gostats_server);
echo ".gostats.com/map.png?id=";
echo urlencode($gostats_siteid);
echo "\" border=0 alt=\"GoStats web traffic Map\" width=\"200\" height=\"88\"></a>";
}

function widget_GoStatsMap($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?>GoStats Map<?php echo $after_title;
  showMap();
  echo $after_widget;
}

function GoStatsMap_init()
{
  register_sidebar_widget(__('GoStats Map'), 'widget_GoStatsMap');     
}
add_action("plugins_loaded", "GoStatsMap_init");
?>
