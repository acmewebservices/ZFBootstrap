<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.capitalize.php
 * Type:     modifier
 * Name:     capitalize
 * Purpose:  capitalize words in the string
 * -------------------------------------------------------------
 */
function smarty_modifier_twitterparse($string){

	// parse urls
	$pattern = '/([A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&amp;\?\/.=]+)/i';
	$replacement = '<a href="$1" target="_blank">$1</a>';
	$string = preg_replace($pattern, $replacement, $string);

	// parse usernames
	$pattern = '/[@]+([A-Za-z0-9-_]+)/';
	$replacement = '<a href="http://twitter.com/$1" target="_blank">@$1</a>';
	$string = preg_replace($pattern, $replacement, $string);

	// parse hashtags
	$pattern = '/[#]+([A-Za-z0-9-_]+)/';
	$replacement = '#<a href="http://search.twitter.com/search?q=%23$1" target="_blank">$1</a>';
	$string = preg_replace($pattern, $replacement, $string);

	return $string;
}
?>