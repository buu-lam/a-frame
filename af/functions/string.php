<?php
namespace af;

function class2path($class)
{
    return \str_replace('\\', '/', $class);
}

function path2class($path)
{
    return \str_replace('/', '\\', $path);
}
    
function path2key($path)
{
    return \str_replace('/', '_', $path);
}

function keyize($str, $charset='utf-8')
{
    return \preg_replace('/[^a-z0-9]+/', '_', formatize($str, $charset, '-'));
}

function urlize($str, $charset='utf-8')
{
    return \preg_replace('/[^a-z0-9]+/', '-', formatize($str, $charset, '-'));
}

function filize($str, $charset='utf-8')
{
    return \preg_replace('/[^a-z0-9.]+/', '-', formatize($str, $charset, '-'));

}

function formatize($str, $charset='utf-8', $replace = '')
{
    $str    =   noaccent($str, $charset, $replace);
    $str    =   \strtolower($str);
    return $str;
}

function noaccent($str, $charset='utf-8', $replace = '')
{
    $str = \htmlentities($str, ENT_NOQUOTES, $charset);
    
    $str = \preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '$1', $str);
    $str = \preg_replace('#&([A-za-z]{2})(?:lig);#', '$1', $str); // pour les ligatures e.g. '&oelig;'
    $str = \preg_replace('#&[^;]+;#', $replace, $str); // supprime les autres caractères
    
    return $str;
}

function win2utf8($str)
{
    return \iconv('CP1252', 'UTF-8', $str);
}

function utf82win($str)
{
    return \iconv('UTF-8', 'CP1252', $str);
}

function mac2utf8($str)
{
    return \iconv('macintosh', 'UTF-8', $str);
}

function utf82mac($str)
{
    return \iconv('UTF-8', 'macintosh', $str);
}

/**
 * @link http://rrr.favrat.net/2011/02/18/php-detection-encodage-mac-roman-utf-8/
 * @param string $string
 * @return bool
 */
function is_utf8($string)
{
	// From http://w3.org/International/questions/qa-forms-utf-8.html
	return preg_match('%^(?:
	[\x09\x0A\x0D\x20-\x7E] # ASCII
	| [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
	| \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
	| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
	| \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
	| \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
	| [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
	| \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
	)*$%xs', $string);
}
