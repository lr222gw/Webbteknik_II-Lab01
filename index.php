<?php
/**
 * Created by PhpStorm.
 * User: Lowe
 * Date: 2014-11-12
 * Time: 21:31
 */

//Börjar med att skapa en curl-get för att få ner sidan.
function curlGetRequest($url){
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL, $url); //Anger vilken adress vår handler som hantera...

    
}