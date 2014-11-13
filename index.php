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

function scrapeOnCoursepress($data, $baseUrl){//Designar en unik skrapa för coursepress (då den har id/classer som är unika för sidan).
    $arrayWithNodes=[];
    $dom = new DOMDocument(); //skapar min Dom
    if($dom->loadHTML($data)){ // Om if lyckas så är datan som skickas in giltig, då används den datan i samband med vår dom.

        $xpath = new DOMXPath($dom);
        $nodeList = new DOMNodeList();

        $nodeList = $xpath->query('//ul[@id = "blogs-list"]/li//div[@class = "item-title"]/a'); // en ganska rätt beskrivning som ger mig

        foreach($nodeList as $node){// Låter mig göra om från list till array...
            $arrayWithNodes[] = $node;
        }
        $nextNode = $xpath->query('//a[@class = "next page-numbers"]');

        $nextHREF ="";
        foreach($nextNode as $nextNode){ //tar fram url till nästa sida...
            //Obs, körs bara om nextNode finns...
            $nextHREF = $nextNode->getAttribute("href");
            $newData = doCurlGetRequest($baseUrl.$nextHREF);

            $newData = scrapeOnCoursepress($newData,$baseUrl);
            foreach($newData as $node){
                $arrayWithNodes[] = $node; // konverterar till array...
            }


            break; // bryter; använder bara foreach som fulhack..
        }

    }
    return $arrayWithNodes;
}
function scrapeRest($scrpedDataArray){
    $arrayToJson = [];
    for($i=0; $i<count($scrpedDataArray);$i++ ){
        $regex = '/http:\/\/coursepress.lnu.se\/kurs\/\w*/';
        if(preg_match($regex, $scrpedDataArray[$i]->getAttribute("href")) === 1){ //En spärr som ser till att vi bara tar kurser och inte andra saker...
            $arrayToJson[$i]["Name"] = $scrpedDataArray[$i]->nodeValue;
            $arrayToJson[$i]["Url"] = $scrpedDataArray[$i]->getAttribute("href");
            $extraInfoArr = getLastInformation($arrayToJson[$i]["Url"]);

            if(isset($extraInfoArr["courseID"])){
                $arrayToJson[$i]["courseID"] = $extraInfoArr["courseID"];
            }else{$arrayToJson[$i]["courseID"] = "no information";}

            if(isset($extraInfoArr["courseplanLink"])){
                $arrayToJson[$i]["courseplanLink"] = $extraInfoArr["courseplanLink"];
            }else{$arrayToJson[$i]["courseplanLink"] = "no information";}

            if(isset($extraInfoArr["courseIntroText"])){
                $arrayToJson[$i]["courseIntroText"] = $extraInfoArr["courseIntroText"];
            }else{$arrayToJson[$i]["courseIntroText"] = "no information";}

            if(isset($extraInfoArr["latestPost"])){
                $arrayToJson[$i]["latestPost"] = $extraInfoArr["latestPost"];
            }else{$arrayToJson[$i]["latestPost"] = "no information";}

            if(isset($extraInfoArr["courseID"])){
                $arrayToJson[$i]["courseID"] = $extraInfoArr["courseID"];
            }else{$arrayToJson[$i]["courseID"] = "no information";}

        }
    }

    

    echo "<pre>";
    var_dump($arrayToJson);
    echo "</pre>";

}
function getLastInformation($urlToCourse){
    $arrayToreturn = [];

    $data = doCurlGetRequest($urlToCourse);
    $dom = new DOMDocument();

    $test = true;//

    $dom->loadHTML($data);

    if($test){ // Här skulle egentligen "$dom->loadHTML($data)" stå, av någon anledning så får jag problem.. (?)
        $xpath = new DOMXPath($dom);

        $courseCode = $xpath->query('//div[@id = "header-wrapper"]//li[last()]/a');
        //$arrayToreturn["courseID"] = $courseCode->nodeValue;
        foreach($courseCode as $courseCode){
            $arrayToreturn["courseID"] = $courseCode->nodeValue;

        }

        $courseplanlink = $xpath->query('//ul[@id = "menu-main-nav-menu"]//li/a | //ul[@id = "menu-svensk-meny"]//li/ul/li/a | //ul[@id = "menu-huvudmeny"]//li/ul/li/a');
        foreach($courseplanlink as $courseCode){
            if($courseCode->nodeValue === "Kursplan"){
                $arrayToreturn["courseplanLink"] = $courseCode->getAttribute("href");
            }
        }

        $courseIntro = $xpath->query('//div[@id = "content"]/article[1] | //section[@id = "content"]/article[1]' );
        foreach($courseIntro as $courseCode){
            $arrayToreturn["courseIntroText"] = "";
            $arrayToreturn["courseIntroText"] .= $courseCode->nodeValue;

        }

        $courseIntro = $xpath->query('//section[@id = "content"]/article[2]/header/h1 | //div[@id = "content"]/section/article[1]/header/h1 ' );
        foreach($courseIntro as $courseCode){
            $arrayToreturn["latestPost"]["Title"] = $courseCode->nodeValue;

        }
        $courseIntro = $xpath->query('//section[@id = "content"]/article[2]/header/p | //div[@id = "content"]/section/article[1]/header/h1 ');
        foreach($courseIntro as $courseCode){
            $arrayToreturn["latestPost"]["AuthorAndTime"] = $courseCode->nodeValue;

        }

        /*echo "<pre>";
        var_dump($arrayToreturn);
        echo "</pre>";*/


    }
    return $arrayToreturn;

}
libxml_use_internal_errors(true); // OBS DENNA används för att se till att jag inte får massor felmeddelanden... för saker jag inte förstår...
$baseUrl = "http://coursepress.lnu.se";
$url = "http://coursepress.lnu.se/kurser/";//"https://coursepress.lnu.se/kurser/?bpage=5";
$data = doCurlGetRequest($url); //Noterade att "/"-tecknet på slutet var viktigt...od och synkronisera denna till GitHub.

$scrpedDataArray = scrapeOnCoursepress($data,$baseUrl);

scrapeRest($scrpedDataArray);

echo $data;
//var_dump($scrpedDataArray);
