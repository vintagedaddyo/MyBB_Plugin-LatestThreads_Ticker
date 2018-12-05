<?php
/*
* MyBB: Latest Threads Ticker
*
* File: latestthreads_ticker.php
*
* Authors: Madhan Kumar M & Vintagedaddyo
*
* MyBB Version: 1.8
*
* Plugin Version: 1.1
*
*/

if (!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

// Plugin hooks

$plugins->add_hook("index_start", "latestthreads");
$plugins->add_hook("index_start", "latestthreads_ticker_index_start");

// Plugin info

function latestthreads_ticker_info()
{
	global $db, $mybb, $lang;
	$lang->load("latestthreads_ticker");
	$lang->latestthreads_ticker_Desc = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;">' . '<input type="hidden" name="cmd" value="_s-xclick">' . '<input type="hidden" name="hosted_button_id" value="AZE6ZNZPBPVUL">' . '<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">' . '<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">' . '</form>' . $lang->latestthreads_ticker_Desc;
	return Array(
		'name' => $lang->latestthreads_ticker_Name,
		'description' => $lang->latestthreads_ticker_Desc,
		'website' => $lang->latestthreads_ticker_Web,
		'author' => $lang->latestthreads_ticker_Auth,
		'authorsite' => $lang->latestthreads_ticker_AuthSite,
		'version' => $lang->latestthreads_ticker_Ver,
		'codename' => $lang->latestthreads_ticker_CodeName,
		'compatibility' => $lang->latestthreads_ticker_Compat
	);
}

// Activate plugin

function latestthreads_ticker_activate()
{
	global $db, $mybb, $lang, $settings;

	$lang->load("latestthreads_ticker");

	$latestthreads_ticker_group = array(
		'gid' => '0',
		'name' => 'latestthreads_ticker',
		'title' => $lang->latestthreads_ticker_title_setting_group,
		'description' => $lang->latestthreads_ticker_description_setting_group,
		'disporder' => '1',
		'isdefault' => '0'
	);

	$db->insert_query('settinggroups', $latestthreads_ticker_group);

	$gid = $db->insert_id();

	$latestthreads_ticker_setting_1 = array(
		'sid' => '0',
		'name' => 'latestthreads_ticker_enable_index',
		'title' => $lang->latestthreads_ticker_title_setting_1,
		'description' => $lang->latestthreads_ticker_description_setting_1,
		'optionscode' => 'yesno',
		'value' => '1',
		'disporder' => '1',
		'gid' => intval($gid)
	);

	$latestthreads_ticker_setting_2 = array(
		'sid' => '0',
		'name' => 'latestthreads_ticker_css_input_1',
		'title' => $lang->latestthreads_ticker_title_setting_2,
		'description' => $lang->latestthreads_ticker_description_setting_2,
		'optionscode' => 'textarea',
		'value' => '.ticker {
background: #0f0f0f url(images/tcat.png) top left repeat-x;
border: 2px solid #000;
text-align: center;
margin: 10px auto;
padding: 5px 20px;
font-weight: bold;
color: #FFFFFF;
border-radius: 0px 5px 5px 0px;
}

.tickerhead {
background: #0066a2 url(images/thead.png) top left repeat-x;
color: #FFFFFF;
text-align: center;
font-weight: bold;
font-size: 15px;
font-style: italic;
border-radius: 10px 0px 0px 10px;
}

td.ticker a {
color: #EEEEEE;
text-decoration: none;
}

td.ticker a:hover {
color: #DDDDDD;
text-decoration: none;
}',
		'disporder' => '2',
		'gid' => intval($gid)
	);

	$latestthreads_ticker_setting_3 = array(
		'sid' => '0',
		'name' => 'latestthreads_ticker_max_threads',
		'title' => $lang->latestthreads_ticker_title_setting_3,
		'description' => $lang->latestthreads_ticker_description_setting_3,
		'optionscode' => 'text',
		'value' => '20',
		'disporder' => '3',
		'gid' => intval($gid)
	);

	$latestthreads_ticker_setting_4 = array(
		'sid' => '0',
		'name' => 'latestthreads_ticker_exclude_forums',
		'title' => $lang->latestthreads_ticker_title_setting_4,
		'description' => $lang->latestthreads_ticker_description_setting_4,
		'optionscode' => 'text',
		'value' => '27,28,33,37',
		'disporder' => '4',
		'gid' => intval($gid)
	);

	$latestthreads_ticker_setting_5 = array(
		'sid' => '0',
		'name' => 'latestthreads_ticker_behavior',
		'title' => $lang->latestthreads_ticker_title_setting_5,
		'description' => $lang->latestthreads_ticker_description_setting_5,
		'optionscode' => 'text',
		'value' => 'scroll',
		'disporder' => '5',
		'gid' => intval($gid)
	);

	$latestthreads_ticker_setting_6 = array(
		'sid' => '0',
		'name' => 'latestthreads_ticker_direction',
		'title' => $lang->latestthreads_ticker_title_setting_6,
		'description' => $lang->latestthreads_ticker_description_setting_6,
		'optionscode' => 'text',
		'value' => 'left',
		'disporder' => '6',
		'gid' => intval($gid)
	);

	$latestthreads_ticker_setting_7 = array(
		'sid' => '0',
		'name' => 'latestthreads_ticker_amount',
		'title' => $lang->latestthreads_ticker_title_setting_7,
		'description' => $lang->latestthreads_ticker_description_setting_7,
		'optionscode' => 'text',
		'value' => '2',
		'disporder' => '7',
		'gid' => intval($gid)
	);

	$latestthreads_ticker_setting_8 = array(
		'sid' => '0',
		'name' => 'latestthreads_ticker_delay',
		'title' => $lang->latestthreads_ticker_title_setting_8,
		'description' => $lang->latestthreads_ticker_description_setting_8,
		'optionscode' => 'text',
		'value' => '5',
		'disporder' => '8',
		'gid' => intval($gid)
	);

	$db->insert_query('settings', $latestthreads_ticker_setting_1);
	$db->insert_query('settings', $latestthreads_ticker_setting_2);
	$db->insert_query('settings', $latestthreads_ticker_setting_3);
	$db->insert_query('settings', $latestthreads_ticker_setting_4);
	$db->insert_query('settings', $latestthreads_ticker_setting_5);
	$db->insert_query('settings', $latestthreads_ticker_setting_6);
	$db->insert_query('settings', $latestthreads_ticker_setting_7);
	$db->insert_query('settings', $latestthreads_ticker_setting_8);

	rebuild_settings();

	// Add New Template

	$ltt_template = array(
		"title" => 'latestthreads_ticker_tmplt',
		"template" => $db->escape_string('
	       <style>
	       {$mybb->settings[\'latestthreads_ticker_css_input_1\']}
	       </style>
	       <table width="100%" cellspacing="0" cellpadding="4" border="0" align="center">
<tr>
<td width="10%" class="tickerhead">{$lang->latestthreads_ticker_trending}</td>
<td width="90%" class="ticker">
<marquee behavior="{$mybb->settings[\'latestthreads_ticker_behavior\']}" direction="{$mybb->settings[\'latestthreads_ticker_direction\']}" onmouseover="this.stop();" onmouseout="this.start();" scrollamount="{$mybb->settings[\'latestthreads_ticker_amount\']}" scrolldelay="{$mybb->settings[\'latestthreads_ticker_delay\']}">
{$latestthreads}
</marquee>
</td></tr></table><br />') ,
		"sid" => "-1",
		"version" => 1800,
		"dateline" => TIME_NOW
	);

	$db->insert_query('templates', $ltt_template);

	require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";

	// Insert template

	find_replace_templatesets("index", "#" . preg_quote('{$forums}') . "#i", '{$latestthreads_ticker_tmplt}{$forums}');
}

// Deactivate plugin

function latestthreads_ticker_deactivate()
{
	global $db, $mybb;

	$db->query("DELETE FROM " . TABLE_PREFIX . "settings WHERE name IN ('latestthreads_ticker_behavior')");
	$db->query("DELETE FROM " . TABLE_PREFIX . "settings WHERE name IN ('latestthreads_ticker_direction')");
	$db->query("DELETE FROM " . TABLE_PREFIX . "settings WHERE name IN ('latestthreads_ticker_amount')");
	$db->query("DELETE FROM " . TABLE_PREFIX . "settings WHERE name IN ('latestthreads_ticker_delay')");
	$db->query("DELETE FROM " . TABLE_PREFIX . "settings WHERE name IN ('latestthreads_ticker_max_threads')");
	$db->query("DELETE FROM " . TABLE_PREFIX . "settings WHERE name IN ('latestthreads_ticker_exclude_forums')");
	$db->query("DELETE FROM " . TABLE_PREFIX . "settings WHERE name IN ('latestthreads_ticker_css_input_1')");
	$db->query("DELETE FROM " . TABLE_PREFIX . "settings WHERE name IN ('latestthreads_ticker_enable_index')");
	$db->query("DELETE FROM " . TABLE_PREFIX . "settinggroups WHERE name='latestthreads_ticker'");

	rebuild_settings();

	// Remove template

	$db->query("DELETE FROM " . TABLE_PREFIX . "templates WHERE title = 'latestthreads_ticker_tmplt'");

	require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";

	// Remove inserted template

	find_replace_templatesets("index", "#" . preg_quote('{$latestthreads_ticker_tmplt}') . "#i", '', 0);
}

// Run latest threads function

function latestthreads()
{
	global $mybb, $db, $latestthreads;

    $exclude_forums =  htmlspecialchars_uni($mybb->settings['latestthreads_ticker_exclude_forums']);

    if($exclude_forums == NULL) 
    {   
    	$exclude_forums =  '27,28,33,37';
    }

    $max =  htmlspecialchars_uni($mybb->settings['latestthreads_ticker_max_threads']);

    if($max == NULL) 
    {
    	$max =  '20';
    }

	$query = $db->query("SELECT * FROM " . TABLE_PREFIX . "threads  WHERE `fid` NOT IN($exclude_forums) ORDER BY `tid` DESC LIMIT $max");

	while ($result = $db->fetch_array($query))
	{
		$latestthreads.= "<a href=\"showthread.php?tid={$result['tid']}\">" . htmlspecialchars_uni($result['subject']) . "</a>";
		$latestthreads.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}

	return $latestthreads;
}

// Run latest threads ticker on index

function latestthreads_ticker_index_start()
{
	global $db, $mybb, $templates, $latestthreads, $latestthreads_ticker_tmplt, $lang;

	$lang->load("latestthreads_ticker");
	
	if ($mybb->settings['latestthreads_ticker_enable_index'] == 1)
	{
		eval("\$latestthreads_ticker_tmplt = \"" . $templates->get("latestthreads_ticker_tmplt") . "\";");
	}
}

?>
