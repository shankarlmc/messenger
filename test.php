<?php
$text = 'this is just a link  to test https://www.facebook.com/ blah blah';
//check sting for url
$regex = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
if(preg_match($regex, $text, $url)) {
	// $url is now the array of urls
  // here you should check $url content and length
	$create__url = '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>';
	$modefied__text = str_replace($url[0], $create__url, $text);

	echo $modefied__text;

	echo "<br>";
	$URL_STRING = file_get_contents($url[0]);

	//echo file_put_contents("test.html",$URL_STRING);
	// print $URL_STRING;
  // echo "<pre>";
	// echo $URL_STRING;
	// echo "</pre>";
}
else {
echo $text;
}
?>
