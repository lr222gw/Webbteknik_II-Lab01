<?php
/**
 * Created by PhpStorm.
 * User: Lowe
 * Date: 2014-11-12
 * Time: 21:31
 */

//Börjar med att skapa en curl-get för att få ner sidan.
function doCurlGetRequest($url){
    $ch = curl_init();
    $data = "";

    if(true){ // Ska användas för att kontrollera om vi ska använda en chachad version eller inte...

        curl_setopt($ch,CURLOPT_URL, $url); //Anger vilken adress vår handler som hantera...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Vi ställer in handlern på att inte skriva ut datan när den har hämtat den.

        $data = curl_exec($ch);
        curl_close($ch);//För att den inte behöver vara öppen mer...
    }

    return $data;// returnerar html-datan.
}

function scrapeOnCoursepress($data){//Designar en unik skrapa för coursepress (då den har id/classer som är unika för sidan).

    $dom = new DOMDocument(); //skapar min Dom
    if($dom->loadHTML($data)){ // Om if lyckas så är datan som skickas in giltig, då används den datan i samband med vår dom.

        $xpath = new DOMXPath($dom);

        $nodeList = $xpath->query('//ul[@id = "blogs-list"]/li//a'); // en ganska rätt beskrivning som ger mig
    }

    return $nodeList;

}


$data = doCurlGetRequest("http://coursepress.lnu.se/kurser/"); //Noterade att "/"-tecknet på slutet var viktigt...od och synkronisera denna till GitHub.
$scrpedDataNodeList = scrapeOnCoursepress($data);
echo $data;
foreach($scrpedDataNodeList as $aa){
    echo $aa->nodeValue . "<br />";
}
var_dump($scrpedDataNodeList);