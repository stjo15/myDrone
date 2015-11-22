
 
Kmom04: Databasdrivna modeller
------------------------------------

### Vad tycker du om formulärhantering som visas i kursmomentet? ###

Det blir ju helt klart mindre kod i klasser/controllers/vyer, eller var man nu använder
sig av formulär. Har man många formulär på en sida så är det ju väldigt smidigt att 
ha all hantering i en enda klass. Framförallt blir koden mer överskådlig jämfört med
formulär i ren HTML. Det är ju väldigt fint att ha validering av formulären gömda i klassen
också. Detta tycker jag är nåt som tycker är svårt att få till själv också, så det är fint att ha det 
inbakat där. Väldigt fin, användbar och välgjord modul/klass, CForm, må jag säga.

### Vad tycker du om databashanteringen som visas, föredrar du kanske traditionell SQL? ###

Samma sak när det gäller databasen egentligen, det ger en förenklad och tydligare kod. Det 
blir enkelt att använda sig av databasen och skönt att inte behöva blanda SQL-kod och PHP
i samma dokument. Lite krångligt i början att komma in i det nya sättet att jobba, men 
så är det ju med allt. För övrigt tycker jag det är skoj att börja med databashantering
igen i den här kursen, det är skoj att använda sig av och väldigt användbart i alla slags projekt.

### Gjorde du några vägval, eller extra saker, när du utvecklade basklassen för modeller? ###

Nja, det enda vägvalet var ju om jag skulle lägga metoderna för vanlig databashantering
i Databasmodellens basklass eller direkt i User. Men eftersom mos använde sig av 
det förra så kändes det som att det var bra att följa det exemplet. Känns logiskt för att kunna
återanvända dessa metoder senare också. Jag har inte lagt till något extra egentligen. 
Eftersom jag är lite efter i schemat så ville jag bara få uppgifterna lösta snabbt och enkelt.

### Beskriv vilka vägval du gjorde och hur du valde att implementera kommentarer i databasen. ###

Jag tänkte att jag skulle uppradera min CommentController från tidigare kursmoment, det kändes 
som den enklaste och snabbaste lösningen. Det krävdes dock en hel del ändringar för
att få det att funka tillsammans med CForm och även Databasmodellen som ju är två nya saker 
att implementera. Det krävdes några nya metoder för databasen eftersom man vill söka 
alla kommentarer för en viss sida till skillnad från i User där man söker på alla 
användare, men dessa metoder tycker jag passar bättre i Comment-klassen än i CDatabaseModel. 

### Gjorde du extrauppgiften? Beskriv i så fall hur du tänkte och vilket resultat du fick. ###

Nope jag gjorde inte extrauppgiften den här gången heller. 

### Slutligen ###
 
Det här kursmomentet var ännu en bra övning i att lära känna Anax och MVC lite bättre.
Det var även kul att få lite på riktigt användbara klasser som man kan använda sig av senare också.
Just kommentarsystem och användarlogin finns ju i varje hemsida nästan. Det bidrar 
ju mycket till interaktivitet för användaren. Jag är riktigt nöjd med kursmomentet,
även om jag gärna velat ha mer tid att dyka djupare in i klasserna CForm och User etc och 
jobba mer med designen av kommentarer och användarsidan.