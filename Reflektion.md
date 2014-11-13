Webbteknik_II-Lab01
===================

#Reflektion

##Vad tror Du vi har för skäl till att spara det skrapade datat i JSON-format?
För att minska trafiken till sidan så att sidan inte blir seg. 
Filen blir också enkel att spara/hantera, vilket gör det lättare att lagra historik.

##Olika jämförelsesiter är flitiga användare av webbskrapor. Kan du komma på fler typer av tillämplingar där webbskrapor förekommer?
Sidan http://isthereanydeal.com/ använder sig av skrapor. De letar reda på det billigaste stället att köpa ett visst spel. 
Andra sidor är väl sökmotorer som skrapar ner information om sidor.

##Hur har du i din skrapning underlättat för serverägaren?
Jag använder Cache, då behövs inte lika många request göras.
Efter att jag hämtat ner datan så ser jag till att jag stänger min curl med curl_close.
Jag har också försökt att inte göra så mycket anrop till sidan, försöker hämta allting på en gång.
Vet dock inte om jag har lyckats då jag hämtar kurserna från alla sidorna först, sen hämtar jag 
datan som bara gick att få tag på genom kurssidan.

##Vilka etiska aspekter bör man fundera kring vid webbskrapning?
Vissa sidor är väl mer skrapvänliga än andra. 
Privata sidor och bloggar kanske inte är så schyst att skrapa. Om någon skulle skrapa en blogg där någon skriver
reviews och sedan använda dessa reviews så skulle det ju vara riktigt taskigt.
Jag tror det handlar mest om vad man gör med datan.
Men så länge man har tilllåtelse från sidans ägare så är det ju lugnt att skrapa.

##Vad finns det för risker med applikationer som innefattar automatisk skrapning av webbsidor? Nämn minst ett par stycken!
-Att sidan ändras vilket som skulle kunna resultera i en oändlig loop när skrapningen ska göras.
-Om man har en automatisk skrapning så kanske man får med data som man egenltigen inte ska ha tillgång till. (Om man bryter mot robots.txt)

##Tänk dig att du skulle skrapa en sida gjord i ASP.NET WebForms. Vad för extra problem skulle man kunna få då?
Då skulle jag få problem med viewstate. Viewstate innehåller data som blir oåtkomlig när man använder webforms...

##Välj ut två punkter kring din kod du tycker är värd att diskutera vid redovisningen. Det kan röra val du gjort, tekniska lösningar eller lösningar du inte är riktigt nöjd med.
-Kändes som att jag lyckades göra en rätt liten applikation med få klasser och inte jätte mycket koddupplikation.
-Känns som min skrapa fungerar bra. Den hämtar och skriver ut och lyssnar på cachen. Listan som visas är kanske 
inte den snyggaste, men den gör sitt jobb.
-Fråga om hurvida jag identiferar mig eller ej. Gör jag det? Jag måste ha missat något...

##Hitta ett rättsfall som handlar om webbskrapning. Redogör kort för detta.
Lite svårt att hitta. Kommer inte på något jag har hört om heller.

##Känner du att du lärt dig något av denna uppgift?
Massor om Curl och webbskrapning. 
Visste ju inget innan, och nu har jag byggt en enkel webbskrapa. 
