<?php

$url = "http://aftabcurrency.com/login_script.php";
$url2 = "http://aftabcurrency.com/somepage";
$cookie = 'cookies.txt';
$timeout = 30;

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_TIMEOUT,         10);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,  $timeout );
curl_setopt($ch, CURLOPT_COOKIEJAR,       $cookie);
curl_setopt($ch, CURLOPT_COOKIEFILE,      $cookie);
curl_setopt ($ch, CURLOPT_POST, 1);
curl_setopt ($ch,CURLOPT_POSTFIELDS,"user_name=user&user_password=pass&passcode=code");
$result = curl_exec($ch);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
$page = curl_exec($ch);
curl_close($ch);

if(!empty($ch)) { //if any html is actually returned
    $pokemon_doc = new DOMDocument;
    libxml_use_internal_errors(true);
    $pokemon_doc->loadHTML($page);
    libxml_clear_errors();

    $pokemon_xpath = new DOMXPath($pokemon_doc);

    $price = $pokemon_xpath->evaluate('string(//div[@class="prices"]/meta[@itemprop="price"]/@content)');
    echo $price;

    $rupees = $pokemon_xpath->evaluate('string(//div[@class="prices"]/div/span)');
    echo $rupees;
}
else {
    print "Not found";
}

?>
