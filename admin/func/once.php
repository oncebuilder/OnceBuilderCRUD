<?php

# SOME FUNCTIONS -------------------
function filter($source,$unfilter=false){
	//$pole=trim($pole); // uwam zbędne spacje
	if (get_magic_quotes_gpc()){
		//$source = stripslashes($source); // usuwam ukośniki'
	}

	if($unfilter==false){
		$source = str_replace(
			array("&"    , '"'     , "<"   , ">"   , "\0", "\\"  , "'"  ),   // z
			array("&amp;", "&quot;", "&lt;", "&gt;", ""  , "\\\\", "\'" ), // na
			$source
		);
	}else{
		$source = str_replace(
			array("&amp;", "&quot;", "&lt;", "&gt;", ""  , "\\\\", "\'" ),   // z
			array("&"    , '"'     , "<"   , ">"   , "\0", "\\"  , "'"  ), // na
			$source
		);
	}
	return $source;
}

function filterHTML($pole,$un=false){
	$pole=trim($pole); // uwam zbędne spacje
	if (get_magic_quotes_gpc())
	//$nazwa = htmlspecialchars($nazwa, ENT_QUOTES);
	$pole = stripslashes($pole); // usuwam ukośniki'
	if($un==false){
		$pole = str_replace(
			array("&"    , '"'     , "<"   , ">"   , "'"      ),   // z
			array("&amp;", "&quot;", "&lt;", "&gt;", "&#039;" ), // na
			$pole
		);
	}else{
		$pole = str_replace(
			array("&amp;", "&quot;", "&lt;", "&gt;" , "&#039;" ),   // z
			array("&"    , '"'     , "<"   , ">"    , "'"      ), // na
			$pole
		);
	}
	return $pole;
}

$g=$_GET;
$p=$_POST;

function a($a){
	print_r($a);
}

function m(){
	print_r(mysql_error());
}

?>