
 
Kmom06: Bygg ut ramverket
------------------------------------

### Var du bekant med några av dessa tekniker innan du började med kursmomentet? ###

Inte alls. Det här var helt nytt för mig. Som det mesta annat som har introducerats i den här kursen.

### Hur gick det att göra testfall med PHPUnit? ###

Jag hade för det första stora problem med att installera PHPUnit i min Windows 10-maskin.
Jag fick en felkod i Cygwin att det inte gick att öppna phpunit. Det tog lång tid 
att testa olika lösningar som jag hittade både i dbwebbs forum och internetsökning i övrigt.
Till sist fick jag lösningen från mos som var otroligt enkel; det var bara att skriva 
'phpunit.bat' i Cygwins kommandorad istället för 'phpunit'! När det var löst så kunde
jag äntligen börja med övningen att skriva min första testklass 'RssFeedTest' som 
skulle testa modulen som jag gjorde i kmom05. Det var inte så svårt att skriva ett 
test i den lokala miljön; det krävdes bara lite research om de olika assertions.

Jo just det, det blev en hel del krångel när jag skulle få det att funka tillsammans 
med en installation av Anax. Själva testmetoden I SIG var inte svår att skriva, 
det var att få till alla paths och konfigurationer och dependencies som jag inte fick till.
Min modul CRssFeed är ju beroende både av DatabaseBasic och DatabaseModel, och dessutom
CForm, så allting skulle hamna på sin plats och få sina dependencies. 
Jag tänkte, 'nej, varför skulle jag göra en modul som har så många beroenden?!' 
Bara installationen av Anax från Packagist var inte helt lätt, och det blev mycket trixande med detta.
Jag har lite svårt att ens återberätta vad jag har gått igenom i detalj eftersom 
det har blivit små justeringar av koden för att inte få felmeddelanden, så jag
kan inte ens komma ihåg vilka problem jag stötte på nu.

### Hur gick det att integrera med Travis? ###

När jag fick ett underbart 'OK' från PhpUnit till sist så var det dags att lägga upp det  i Travis. 
Här fick jag minst lika mycket problem som med att få OK lokalt. Det var framförallt
fyra-fem saker jag fastnade i:

1: Installationen av 'bygget' misslyckades flertalet gånger
och det blev mycket testande bara för att få till .travis.yml. 2: Jag utgick från koden
i 'Mumin' i övningen, men denna utgick från DatabaseBasic och inte DatabaseModel 
som min modul var en påbyggnad till. Det tog en bra stund att komma på det, och därför fattade
jag inte varför servicen db->setOptions() inte hittades. Det löstes genom att 
starta en ny instans av DatabaseBasic i setUpBeforeClass()-metoden för att skapa 
en tabell. 3: Jag fick ett felmeddelande om att 'serialization of closure is not allowed'.
Det var väldigt kryptiskt och jag fick lite olika svar på olika forum när jag sökte på det.
Till sist hittade jag något som liknade min situation och det handlade om att det skedde
någon backup av globala variabler, jag förstod inte riktigt vad det var men lösningen 
var att lägga till det här i testklassen nedanför namespace:

     /**
     * @backupGlobals disabled
     */
    
Det gjorde susen! 4: Jag hade några syntaxfel i inmatningen av parametrarna till
tabellvärdena, så jag fick felkod 25 om att parametrarna inte stämde. Mycket sökning
om felkoden med till sist tänkte jag efter lite och kom på att det var ett ganska 
enkelt syntaxfel. Sånt som kan hända när man är lite trött och stressad. 5: Kunde
inte få till det med dependencies mellan funktionerna i RssFeed och CDatabaseBasic 
eller hur man ska uttrycka det. Travis ville inte att man skulle använda $this och
det gick inte få in databasen som en service i $di mfl liknande problem som hade 
med samma sak att göra egentligen. Jag testade mig fram ganska många gånger och 
till sist löstes det genom att lägga 

     $di->setShared('db', function() {
            $db = new \CRssFeed\Database\CDatabaseBasic();
            $db->setOptions(['dsn' => "sqlite:memory::", "verbose" => false]);
            $db->connect();
            return $db;
        });
        
direkt i setUpBeforeClass() för att kunna använda sig av den här databasen i 
klasserna jag var beroende av. 

Det här löste det sista problemet och jag fick ett efterlängtat grönt 'OK'! 
Det blev totalt 37 röda tester innan det gröna 38:e kom.

### Hur gick det att integrera med Scrutinizer? ###

Det var inga problem alls. Det var bara att logga in med GitHub-kontot och
välja repot jag ville analysera. Sen gjorde Scrutinizer resten.

### Hur känns det att jobba med dessa verktyg, krångligt, bekvämt, tryggt? Kan du tänka dig att fortsätta använda dem? ###

Alltså: VÄLDIGT KRÅNGLIGT ATT KOMMA IGÅNG. Men när skutan väl är ute till havs så 
seglar hon själv. Känns väldigt skönt att kunna luta sig tillbaka mot Scrutinizer och
Travis för att se om det är några fel. Väldigt tidskrävande att göra testklasser och 
allt annat bös, men när det väl är klart så går ju testandet extremt smidigt och 
man kan ju testa om och om igen, och ofta. Otroligt användbart. Och jag tror 
Scrutinizer kan hitta många dolda buggar som det är svårt att hitta när man testar 
koden själv. Jag kommer absolut att försöka använda mig av enhetstester vid större 
projekt och när man har gott om tid. I längden tjänar man lätt in den tiden tror jag!

### Slutligen ###

Dags att gå vidare till projektet. Bråttom nu!
