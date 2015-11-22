
 
Kmom05: Bygg ut ramverket
------------------------------------

### Var hittade du inspiration till ditt val av modul och var hittade du kodbasen som du använde? ###

Jag tänkte lite på vad jag ville ha för extra funktioner i mitt slutprojekt för den här kursen, 
och ville gärna att någon som ville få reda på om någon har skrivit ett svar på en kommentar/fråga 
skulle kunna få reda på det utan att gå in på sidan. När jag då kollade igenom förslagen
på moduler i övningen för kursmomentet tänkte jag att jag skulle lösa det genom RSS.

Jag förstod inte så mycket av RSS-klassen i Lydia som det länkades till i övningen,
så jag kollade runt lite på nätet (Googlade) för att försöka hitta en användbar klass.
Jag hittade [den här guiden](http://www.webreference.com/authoring/languages/xml/rss/custom_feeds/index.html)
som var väldigt enkel och grundläggande; en bra grund att utgå ifrån. Resten löstes 
genom att bygga ut CDatabaseModel (som vi gjorde med User) och gjorde om User-klassen
till en ny klass: [CRssFeed](https://github.com/stjo15/CRssFeed). 

### Hur gick det att utveckla modulen och integrera i ditt ramverk? ###

Det var lättare sagt än gjort. Den första patrullen jag stötte på var att jag först 
försökte visa den resulterande xml-koden som en view. Det kom jag snart på inte skulle
fungera eftersom varje sida har en massa default-views som header, footer oh annan html.
Så jag var tvungen att komma på ett annat sätt att visa den. Idén att göra en readfile()
för att öppna xml-filen fick jag faktsikt från Lydia-klassen för RSS i övningen. Min lösning
blev att skapa en xml-fil för varje RSS-flöde man skapade och göra en readfile() viewAction i controllern. 
Otroligt nog så funkade detta och webbläsaren läste den och föreslog att man kunde prenumerera på flödet :D

Det andra större problemet var att 'items'-delen av xml-filen inte visades/sparades. 
Jag fick ett felmeddelande i stil med att objekt inte kan användas som array i foreach.
Det tog ett tag att komma på att första elementet i arrayen när jag läste resultatet från 
databasen var ett objekt. Lösningen blev att ändra det här elementet till att visa 'id'-kolumnen
istället i en if-sats. Annars blev det lite trixande med valideringen av xml-filen
när jag trodde att jag var klar. Jag var tvungen att sätta in default-värden om användaren 
inte lade in bildlänkar, och bildhöjd mm. Dessutom var tidformatet jag hade i mina kommentarer fel
format för RSS, så jag fick söka runt för att se hur man ändrar tidformat till RFC822-format, som
det skulle vara. Enkelt: 

    $rfc822time = date('r', strtotime($item['timestamp']));
    
Till sist fick jag till valideringen och jag kände mig nästan klar...

### Hur gick det att publicera paketet på Packagist? ###

Själva publiceringen på Packagist var inga problem alls. Guiden för detta i övningen var bra 
så det var bara att följa den. Enda felet jag fick i början var egentligen med namnet på
paketet; det fick inte vara stora bokstäver. Jag tyckte namnet blev lite fult men jaja...
Jag har haft lite problem med att fatta Git innan, men detta släppte med den suveräna 
steg-för-steg-guiden i kapitel 17 i kurslitteraturen.
Annars var jag mest nervös för den biten, som jag hade haft problem med innan. 
Det var väldigt smidigt att packagist kan auto-synka paket från Git-hub och installationen 
för detta var inte svår heller. 

### Hur gick det att skriva dokumentationen och testa att modulen fungerade tillsammans med Anax MVC? ###

Jag började med att försöka testa modulen i Anax för att sedan skriva dokumumentationen. 
Det var här nånstans som jag insåg att jag hade gjort lite fel från början och att jag bara 
var halvvägs igenom att klara av uppgiften. Jag hade utvecklat modulen i min egen vidareutvecklade
Anax-MVC som redan hade massa klasser för formulär och databas. Så min modul som var helt beroende 
av CDatabaseModel och CForm funkade givetvis inte med grundversionen av Anax. Det visste 
jag väl kanske att den inte skulle göra men jag hade missat att det ingick i uppgiften 
att testa den i grundversionen, utan tänkte väl att jag skulle visa upp [slutresultatet 
i min me-sida](http://www.student.bth.se/~stjo15/phpmvc/kmom05/Stalles-Me-sida/webroot/rss). 

Men jag fick kavla upp ärmarna och gräva ner mig i koden igen. Jag tänkte att jag skulle göra en enkel
exempelsida bara för att testa att allt fungerar. Men det funkade inte så bra; autoloadern kunde
inte hitta klasserna. Jag testade att ändra lite med namespaces i composer.json men fick inte till det. 
Jag tänkte "eh, jag orkar inte med Composer" och skrev i dokumentationen att man måste föra över klasserna
till Anax-MVC/src. Det funkade, fast jag var tvungen att lägga till en massa nya klasser i modulen som 
de första klasserna var beroende av. Men sen tänkte jag när jag läste igenom kraven för kursmomentet:
"hmm, det här är nog inte vad mos vill att vi ska göra..." Och så studerade jag hur namespaces
i phpmvc/comment-modulen såg ut, så insåg jag att jag ju måste ändra namespace till RssFeed i varje klass.
Sen var dokumentationen inga problem att skriva.

### Gjorde du extrauppgiften? Beskriv i så fall hur du tänkte och vilket resultat du fick. ###

Nope jag gjorde inte extrauppgiften den här gången heller. 

### Slutligen ###

Det här kursmomentet var mer tidskrävande än jag i början tänkte att det skulle vara.
Mest berodde det nog på att jag dels borde ha utvecklat modulen i grundversionen av Anax-MVC, 
och dels på att det var mycket som jag inte hade fattat med namespaces och composer och RSS
som jag fick läsa på lite om. Jag ville först lägga in DatabaseModel och CForm som dependencies 
i Composer, men när jag sökte på dessa i Packagist så hittade jag inte dem, så jag valde att lägga
in de klasserna i själv modulen. Så modulen funkar nu utan att ladda ner dessa klasser separat.
Jag är medveten om att detta inte är idealiskt, eftersom man kanske redan har dessa klasser 
i sitt Anax. Men då får man väl ta bort dem då... :P
Jag är själv nöjd med min modul CRssFeed. Det blir väldigt enkelt att skapa RSS-flöden
i mitt ramverk oavsett om det är en blogg, kommentarflöde eller uppdateringar i vilken
databas som helst. Slutresultatet på min me-sida syns 
[här](http://www.student.bth.se/~stjo15/phpmvc/kmom05/Stalles-Me-sida/webroot/kmom04).
Det är alltså RSS-symbolen man kan klicka på för att komma till xml-dokumentet för
det kommentarsflödet.

Det här är länken till en xml-fil för att validera RSS-flödet i [W3 Feed Validator](https://validator.w3.org/feed/):
    
    http://www.student.bth.se/~stjo15/phpmvc/kmom05/Stalles-Me-sida/app/rss/kmom04_rss.xml
    
Här är en länk till modulen CRssFeed i Packagist: [stjo15/c-rss-feed](https://packagist.org/packages/stjo15/c-rss-feed)

 
