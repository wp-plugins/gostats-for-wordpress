<?php
/*
Plugin Name: GoStats 
Plugin URI: http://gostats.com
Description: Add web tracking to your blog in seconds. 
Version: 1.3
Author: Richard Chmura
Author URI: http://gostats.com/
*/




add_action('admin_menu','gostats_admin');

function gostats_admin()
{

	if ( function_exists('add_submenu_page') ) {
		add_options_page('GoStats', 'GoStats', 9, basename(__FILE__), 'gostats_manage');
	}
}

function gostats_manage()
{
	if (isset($_POST['gostats_siteid'])) {
		update_option('gostats_siteid', $_POST['gostats_siteid']);
		update_option('gostats_server', substr($_POST['gostats_server'],0,7));

		echo '<div class="updated"><p><strong>Options saved</strong></p></div>';
	}

	$gostats_siteid = get_option('gostats_siteid');
        $gostats_server = get_option('gostats_server');

?>
<div class="wrap">
<h2>GoStats Options
</h2>
	
<form name="form1" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<fieldset class="options">Enter your Site id<br/>
	<input type="text" name="gostats_siteid" value="<?php echo stripslashes($gostats_siteid);?>">	
        <fieldset class="options">Enter your GoStats server (c1, monster, c3 or c4).  If 
		you do not see a server id in your summary url (login at <a href="http://gostats.com">      	        http://gostats.com</a> to see), try entering c1 as your server id.<br/>
        <input type="text" name="gostats_server" value="<?php echo stripslashes($gostats_server);?>">
<?php

	$gostats_siteid = get_option('gostats_siteid');
        $gostats_server = get_option('gostats_server');
	if (!empty($gostats_siteid)) {
		echo "&nbsp;<span>(<a href=\"http://";
                if (!empty($gostats_server)){
                    echo $gostats_server;
                }else{
                    echo "monster";
                }
                echo ".gostats.com/click.xml?";
		echo $gostats_siteid;
		echo "\">View stats &raquo;</a>)</span>";
	}else{
/*
		$file = file_get_contents("http://login.gostats.com/goapi/signup");
		$depth = array();

		function startElement($parser, $name, $attrs) 
		{
		   global $depth;
		   for ($i = 0; $i < $depth[$parser]; $i++) {
		       echo "  ";
		   }
		   echo "$name\n";
		   $depth[$parser]++;
		}

		function endElement($parser, $name) 
		{
		   global $depth;
		   $depth[$parser]--;
		}

		$xml_parser = xml_parser_create();
		xml_set_element_handler($xml_parser, "startElement", "endElement");
		echo $file;

		if (!xml_parse($xml_parser, $file)) {
		   die(sprintf("XML error: %s at line %d",
		               xml_error_string(xml_get_error_code($xml_parser)),
		               xml_get_current_line_number($xml_parser)));
		}
		
		xml_parser_free($xml_parser);
*/
	}
?>
	</fieldset>
	<p class="submit">
	<input type="submit" name="Submit" value="Update Options &raquo;" />
	</p>
</form>
</div>
<?php
}

add_action('wp_footer','gostats_getcode');

function gostats_getcode()
{
	global $gostats_siteid;
	global $gostats_server;

	$gostats_siteid = get_option('gostats_siteid');
	$gostats_server   = get_option('gostats_server');
	if (!empty($gostats_siteid)) {
		/*echo "<script type=\"text/javascript\" ";
		echo "src=\"http://monster.gostats.com/js/count4.js?id=";
		echo urlencode($gostats_siteid);
		echo "\"></script>\n";
                */
echo "<!-- GoStats.com -->
<script type=\"text/javascript\"><!--//--><![CDATA[//><!--
var go_aid=";
echo urlencode($gostats_siteid);
echo ";
var go_cid=1;
var go_iid=1;
var go_z='';
var go_serv='";
echo urlencode($gostats_server);
echo ".gostats.com';
var go_cw=88;
var go_ch=31;
var go_js=\"1.0\";
var go_r=Math.random()+\"&amp;a=\"+go_aid+\"&amp;t=\"+go_cid+\"&amp;i=\"+
go_iid+\"&amp;r=\"+
escape(document.referrer)+\"&amp;p=\"+escape(window.location.href);
document.cookie=\"gostats=1; path=/\";
go_r+=\"&amp;c=\"+(document.cookie?\"y\":\"n\");
//--><!]]></script>
<script type=\"text/javascript\" language=\"javascript1.1\"><!--//--><![CDATA[//><!--
go_js=\"1.1\";
go_r+=\"&amp;j=\"+(navigator.javaEnabled()?\"y\":\"n\");
//--><!]]></script>
<script type=\"text/javascript\" language=\"javascript1.2\"><!--//--><![CDATA[//><!--
go_js=\"1.2\";
go_r+=\"&amp;w=\"+screen.width+\"&amp;h=\"+screen.height+\"&amp;d=\"+
(((navigator.appName.substring(0,3)==\"Mic\"))?screen.colorDepth:screen.pixelDepth);
//--><!]]></script>
<script type=\"text/javascript\" language=\"javascript1.3\"><!--//--><![CDATA[//><!--
go_js=\"1.3\";
//--><!]]></script>
<script type=\"text/javascript\" src=\"http://";
echo urlencode($gostats_server);
echo ".gostats.com/js/count4.js?id=";

echo urlencode($gostats_siteid);
echo "\"></script>
<noscript><div><a href=\"http://";
echo urlencode($gostats_server);
echo ".gostats.com/click.xml?";
echo urlencode($gostats_siteid);
echo "\" target=\"_top\"><img
src=\"http://";
echo urlencode($gostats_server);
echo ".gostats.com/bin/count?a=";
echo urlencode($gostats_siteid);
echo "&amp;t=1&amp;i=1&amp;z=\"
style=\"border-width:0px;width:88px;height:31px\" alt=\"web counter\" 
width=\"88\" height=\"31\" /></a><br />
<a style=\"font-size: 9px\" href=\"http://gostats.com\" 
title=\"GoStats web counter\">web stats counter</a></div></noscript>
<!-- GoStats.com -->";

	}
}
?>