<?php

function bbDecode($string) {
	global $url, $theme;
	
	$urlSmiley = '/data/img/smileys';
	
  $find = array(
      "'\[b\](.*?)\[/b\]'is",
      "'\[u\](.*?)\[/u\]'is",
      "'\[i\](.*?)\[/i\]'is",
      "'\[s\](.*?)\[/s\]'is",
      "'\[code\](.*?)\[/code\]'is",
      "'\[quote\](.*?)\[/quote\]'is",
      "'\[quote=(.*?)\](.*?)\[/quote\]'is",
      "'\[span=(.*?)\](.*?)\[/span\]'i",
      "'\[div=(.*?)\](.*?)\[/div\]'is",
      "'\[h\](.*?)\[/h\]'i",
      "'\[url\](.*?)\[/url\]'i",
      "'\[url=(.*?)\](.*?)\[/url\]'i",
      "'\[video\](.*?)\[/video\]'i",
      "'\[video width=(.*?) height=(.*?)\](.*?)\[/video\]'i",
      "'\[img\](.*?)\[/img\]'i",
      "'\[img title=(.*?) rel=(.*?)\](.*?)\[/img\]'i",
      "'\[img title=(.*?)\](.*?)\[/img\]'i",
      "'(:\))'i",
      "'(;\))'i",
      "'(:D)'i",
      "'(\^\^)'i",
      "'(:P)'i",
      "'(:s)'i",
      "'(:\$)'i",
      "'(:O)'i",
      "'(:\()'i"
  );

  $replace = array(
      "<strong>\\1</strong>",
      "<u>\\1</u>",
      "<i>\\1</i>",
      "<del>\\1</del>",
      "<pre>\\1</pre>",
      "<q>\\1</q>",
      "<q><span class=\"cite\">\\1 a écrit</span><br />\\2</q>",
      "<span class=\"\\1\">\\2</span>",
      "<div class=\"\\1\">\\2</div>",
      "<b>\\1</b><br />",
      "<a href=\"\\1\">\\1</a>",
      "<a href=\"\\1\">\\2</a>",
      "<object width=\"480\" height=\"387\" class=\"center\"><param name=\"movie\" value=\"\\1\"></param><embed src=\"\\1\" type=\"application/x-shockwave-flash\" width=\"480\" height=\"387\"></embed></object>",
      "<object width=\"\\1\" height=\"\\2\" class=\"center\"><param name=\"movie\" value=\"\\3\"></param><embed src=\"\\3\" type=\"application/x-shockwave-flash\" width=\"\\1\" height=\"\\2\"></embed></object>",
      "<a href=\"\\1\" rel=\"prettyPhoto\"><img src=\"\\1\" alt=\"\" /></a>",
      "<a href=\"\\3\" rel=\"prettyPhoto[\\2]\"><img class=\"illustration\" src=\"\\3\" alt=\"\\1\" /></a>",
      "<a href=\"\\2\" rel=\"prettyPhoto\"><img src=\"\\2\" alt=\"\\1\" /></a>",
      '<img src="' . Url::Display ($urlSmiley . '/icon_smile.png') . '" alt="\\1" />',
      '<img src="' . Url::Display ($urlSmiley . '/icon_wink.png') . '" alt="\\1" />',
      '<img src="' . Url::Display ($urlSmiley . '/icon_biggrin.gif') . '" alt="\\1" />',
      '<img src="' . Url::Display ($urlSmiley . '/icon_wink.png') . '" alt="\\1" />',
      '<img src="' . Url::Display ($urlSmiley . '/icon_razz.gif') . '" alt="\\1" />',
      '<img src="' . Url::Display ($urlSmiley . '/icon_confused.png') . '" alt="\\1" />',
      '<img src="' . Url::Display ($urlSmiley . '/icon_rolleyes.gif') . '" alt="\\1" />',
      '<img src="' . Url::Display ($urlSmiley . '/icon_surprised.gif') . '" alt="\\1" />',
      '<img src="' . Url::Display ($urlSmiley . '/icon_sad.png') . '" alt="\\1" />'
  );

  $string = preg_replace($find, $replace, $string);
  $string = makeLinks($string);

  return $string;
}

# Transform URL and e-mails into links
function makeLinks($string) {
  $string = preg_replace_callback('/\s(http|https|ftp):(\/\/){0,1}([^\"\s]*)/i','splitUri',$string);
  return $string;
}

# Split links, require for makeLinks
function splitUri($matches) {
  global $url_attribut;
  $uri = $matches[1].':'.$matches[2].$matches[3];
  $t = parse_url($uri);
  $link = (strlen($matches[3]) > 25) ? substr($matches[3],0,25).'...' : $matches[3];
					
  if (!empty($t['scheme'])) {
    return ' <a href="'.$uri.'" title="'.$uri.'" '.$url_attribut.'>'.$link.'</a>';
  } else {
    return $uri;
  }
}

function filterChar ($text) {
	$search = array ('@(é|è|ê|ë|Ê|Ë)@','@(á|ã|à|â|ä|Â|Ä)@i','@(ì|í|î|ï|Î|Ï)@i','@(ú|û|ù|ü|Û|Ü)@i','@(ò|ó|õ|ô|ö|Ô|Ö)@i','@(ñ|Ñ)@i','@(ý|ÿ|Ý)@i','@(ç)@i','@(æ)@i', '@( )@i','@[^a-zA-Z0-9_]@');  
	$replace = array ('e','a','i','u','o','n','y','c','ae', '_','');
	
	return preg_replace($search, $replace, mb_strtolower($text));
}
