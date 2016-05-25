Redovisning
====================================

Kmom01
------------------------------------

Vill börja med att det är roligt att vara igång igen med PHP, trodde inte jag skulle säga det.  
I även denna kursen sitter jag på Windows 7, använder PhpStorm som IDE dock Chrome istället för Firefox.
Börjar bli väldigt bekväm med PhpStorm, det är en fantastiskt IDE med väldiga många riktigt bra funktioner.


Har aldrig tidigare jobbat eller hört något om ramverk. Men vad jag har jobbat och lärt mig i detta kursmomentet så _känns_
det (för tillfället) väldigt smidigt. Bra att vi för varje kurs lär oss struktuera koden på ett ännu snyggare sätt.  
Det samma gäller för alla begrepp som används, det vill säga att även det är nytt. Har fått läsa en del för att försöka få en övergripande förståelse, det blir dock bli överväldigande ganska snabbt.
Just nu känns allt väldigt komplicerat, men det har de dock gjort i början av varje kurs och i slutet har man koll med vad man gör. Så det gäller bara att kämpa på. 

Det gjorde ont i ögonen i slutet av OOPHP när vi blandade PHP och HTML så mycket... Usch. I början så kändes det var så rätt det kunde bli.  

Jag tycker Anax-MVC fungerar rätt bra, den största anledningen till detta är phalcons manual. Mycket bra att det finns tillshands.
Guiderna på dbwebb för första kursmomentet är _riktigt_ bra. Första gången det har flytit på i bra takt. 


Kmom02
------

Har tidigare använt Composer när jag jobbade med [CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) som var bra till de tidigare kurserna när vi var tvungna att följa en viss PSR. 
Använde det inte riktigt på samma sätt, utan jag gjorde något globalt krav med hjälp av composer. CodeSniffer använde jag enbart till att fixa fel automatiskt, vet inte om det kan användas till mer.

Har även kollat runt lite på Packagist, gick igenom några sidor med hittade inget som skulle vara passande. Detta är antagligen brist på kunskap, då vissa paket underlättar vissa specifika saker något otroligt.
Men ska fortsätta och se över och se om det finns något mer som kan vara användbart. Känns som en bra övning att ha koll på hur man installerar/hanterar andra paket förutom Comment paketet. 

När jag hade gjort klart guiden och skulle gå över till kraven, bla att kunna klicka på ID'n för att redigera och använda två olika sidor för olika kommenterar, så trodde jag aldrig att jag skulle klara detta kursmoment. 
Läste på relativt mycket, men majoriteten av alla begrepp var fortfarande grekiska. Sedan började jag gå igenom vissa klasser som skulle användas. Gick igenom hur funktionerna såg ut och vad de gjorde för jobb, mycket blev mer logiskt då. Sen så fick jag testa, testa och testa olika saker och studera de olika resultaten. Fick en "aha" upplevelse i slutet av kursmomentet, alltid lika skönt när några pusselbitar faller på plats. 

Fick lite problem med CommentInSession då jag använde en array (all_comments) som i sin tur hade två olika arrayer (page_1 och page_2) som i sin tur höll arrayer med varje enskild kommentar. 
Då viewAction anropades när användaren klickade på en kommentarsida (vi säger i detta fall det är page 1), så försöker findAll funktionen komma åt en array i sessionen som inte finns.
Löste det genom att använda array_key_exists. Detta fick jag även göra på add funktionen.  

Sen löste jag problemet när användaren ska kunna ta bort en enskild kommentar på ett annorlunda sätt, tror jag. 
Först när jag försökte ta bort så låg nyckeln kvar, detta var inget jag ville. Så jag skapa en ny funktion i klassen CSession där jag gjorde en unset funktion.
Gjorde, så gott det gick, funktionen så generell som möjligt. Finns garanteret att bättre sett att lösa det på. Kanske ska inte ens unset behövas användas - men det funkar utmärkt för mig. 

Sedan, tror jag, att jag lyckades rätt bra med att göra alla funktioner väldigt generella i Comment klassen. Om jag nu skulle vilja lägga till sida att kommentera på så kommer jag inte behöva ändra något i Comment klasserna. 


Kmom03
------

Vill börja med att säga att CSS har blivit otroligt mycket roligare i detta kursmomentet. Har aldrig riktigt tyckt om CSS innan,
men har blivit något jag kan leva med nu. Har hört om LESS tidigare på lektionerna, men aldrig haft koll på vad det är - tills nu. 
LESS får 10/10 PGA det gjorde styling så mycket mer intressant. Gillade starkt att det gick att använda variabler och funktioner, blir väldigt lätt att styla och ändra med den möjligheten. 
Speciellt om andra ska använda det. 

Det är dock väldigt mycket jag har kvar att lära inom CSS, just att jag har fokuserat så lite på det i tidigare kurser. Det känns rätt tråkigt att det har blivit så, då jag inte är helt 100% på detta kursmoment. 
Men om jag ska se det från ett annat håll har jag lärt mig mer nu, av ren nyfikenhet, än vad jag har under en väldigt lång tid. 

Ett 'problem' jag hade under detta kursmoement var att jag ville se några typ av felmeddelande som LESS skulle genererat. La för mycket tid på detta utan att kunna lösa det.
Men som tur väl fick jag en relativt bra förståelse hur lessphp fungerar. Har sett efter att style.php genererar felmeddelande, men inte på min stationära som är min huvudsakliga utvecklingmiljö. En förklaring till detta kommer i nästa stycke.

Hade väldigt mycket problem med rättigheter under kursmoment. Dum som jag var så körde jag en chmod 777 via cygwin och sen dess har jag haft otrolig problem med att style.php ska skriva style.css. 
Det har varit allt från en tom sida när jag anropar style.php eller tecken som nedan. 

    �6F9�b�}e|�3A��1f�U!b�N}�b�v�d3z�[8m��Im���g^�)_ 
    
Nu vet jag att jag aldrig ska använda chmod 777 på windows, har fortfarande problem med rättigheterna på min stationära... Som tur väl så var det bara lokalt (använder dropbox) så det fungerade som det skulle på min laptop. 
En sak jag dock stör mig på, men antagligen är detta PGA mitt chmod kommando, men varje gång jag laddar upp via dbwebb kommandot så får jag ändra rättigheterna på studentservern då style.php inte har rätt att skriva. 

Det fick mig dock att fixa att jag per automatik laddar upp filer till studentservern när jag använder CTRL + S i phpstorm, efter lite krångel. Så kommer antagligen inte använda dbwebb kommandot så mycket i framtiden.

Har alltid gjort samma style på alla mina tidigare sidor, även denna, just för jag har avskytt att positionera element på ett snyggt sätt. En annan anledning
är att jag inte har känt att CSS har något roligt att erbjuda. 
Med hjälp av The Sematic Grid löste det alla mina problem, efter man hade fått kläm på det.

Normalize, vad jag kunde se, gjorde inte jättestor skillnad. Hade ingen aning att det fanns 'färdiga inställningar' i de olika webbläsare. Bootstrap var väldigt intressant, insåg hur kraftfull LESS kan vara. Kollade igenom deras git reop och la till några knappar. Såg att vi hade lånat väldigt mycket där ifrån, smart gjort. Verkar vara extremt populärt.
Mitt tema är gjort precis som i guiden, med 12 regioner. Kommer dock att fortsätta experimentera med detta under en väldigt lång tid. 

Försökte även att ladda upp mitt tema på [git](https://github.com/gusseleet/anax-theme/tree/master), med lite mer tid så skulle jag antagligen ha kunnat göra det väldigt användarvändligt. Kommer försöka uppdatera och uteveckla mitt tema under en tid. Vem vet, någon kommer kanske att använda det någon gång... 
Löste så att användaren inte behövde anax-mvc för att använda det, men blev inte alls lika smidigt. 

#### Kort och gott, styla sidor har blivit roligt.

Kmom04
------


Ännu ett väldigt användbar klass. CForm är en riktigt smidig funktion i Anax, magisk med andra ord.

Det är dock lite omständligt i början med att använda klasser som någon annan har skapat. Men med lite exempel och inspektion av koden så blir det bättre. 
För varje kursmoment  blir saker jag har tyckt varit omständliga enklare. Det ser mycket snyggare ut att skapa ett formulär via Cform (även mer lättläsligt).

Databashanteringen som vi använder med hjälp av CDatabase är helt ny för mig. Jag gillar dock enkelheten i att hantera datan i databasen som objekt.
Kan tänka mig att det blir en del begränsningar, men just nu har jag inte märkt något. Måste jag säga att jag föredrar detta istället för traditionell SQL.

Valde, precis som i guiden, att låta controllern göra jobbet och använda en nästan tom klass (user/comment) som bygger ut databasen.
Skapade ytligare två klasser som ärvde från CForm. Ett formulär för User och ett formulär för comments. Först skapade jag formulären i controller klasserna. Men det blev inte snyggt  och blev snabbt en väldigt stor klass.
Så jag valde att bryta ut det jag kunde och lägga i separata klasser.

Själva implementationen med comments och databasen är väldigt lik så jag hanterade users.
Funderade på hur jag skulle gå till väga när det kommer finnas olika topcis samt kommentarer till dessa. Kom fram till att det borde vara som när jag hanterade genre/filmer i tidigare kurs. 

Fick återigen en bra överblick hur ramverket är uppbyggt. För första gången så har det rullat på väldigt bra efter man läst igenom guiderna utan några direkt stora hinder.

Det uppstod dock lite problem här och där. Ett av problemen var med databasen. Kunde inte nå den via Workbench och sidan på studentservern ville inte laddas. Kunde inte droppa tabellen heller.
Efter lite googling verkade det som att tabellen var korrupt. Men la till kopplingen till Databasen i Phpstorm och där hade jag inte problem att droppa tabellen. Varför det inte gick att göra via workbench har jag fortfarande ingen aning om. 

Såg även att CForm inte hade stöd för 'rows' och 'cols' i ett TextArea element, så jag gjorde lite ändringar och vips - nu fungerar det. 
Skulle dock vilja designa det jag skapar via CForm (så som submit-knappar och textfält) på samma sätt som exempel nedan. 


    <a class="btn btn-default" href="<?=$this->url->create('comment/removeSingle/' . $comment->id)?>" role="button" data-toggle="Testing" title="Remove this comment">Remove</a> </div>
Har inte hittat en lösning på detta.

La även till att användaren kan rösta på olika kommentarer, dessa sorteras från högsta till lägsta. Fick lägga till sortBy för att det skulle fungera.
 
Något jag störde mig på var att sidan, efter ett klick på en upvote/downvote, ändrade position. Ställde frågan om hur man skulle lösa detta och svaret var JavaScript.
Efter lite sökning hittade jag ett bra script som jag la in. Funkar utmärkt!

Kmom05
------
Jag började med att sitta några dagar med att göra en Escape klass, för att escapa specialteken innan de skrivs ut i någon vy.
Är inte alls instatt i detta. Det jag har använt är htmlentelties() i tidigare kursmoment.

Att escapa url:er och html attributer var inte större konstigheter. Sen kom det till att göra samma sak för JavaScript/CSS. Hittade lite kod på hur det skulle göras, men förstod det inte riktigt 100%. 
3 dagar in, så kände jag att det inte riktigt var min grej.

Jag började då med en loggning klass. Inspirationen fick jag från artikeln “Bygg ut ditt Anax MVC med en egen modul och publicera via Packagist”.
Började med att surfa runt lite och kolla på diverse klasser som utförde detta.
Hade ingen aning att det var möjligt att göra sin egen error controller, php levererar. 

Sen började jag läsa om set_error_handler, som var en stor punkt i det hela. I början fick jag inte riktigt klämm på hur just min funktion skulle användas vid ett felmeddelande.
Tog mig ett tag innan jag förstod att jag skulle sätta en klass och en funktion när jag använde set_error_handler. 
Efter det så var det inga direkt stora förhinder.

Något jag var lite ittiterad över var att "errno" (den första parametern) innehöll vilken nåva felet var på som en *int*. 
Efter lite sökning hittade jag en funktion som gjorde om felnivån (int) till string, så det blir lite mer lättläsligt när jag skriver det till fil. 

Modulen är fristående från Anax-MVC. Jag tyckte det blev lättast så. Tidigare föreläsningar har det även nämnts att nästa kurskoment blir betydligt lättare. Så jag valde den vägen. Att integrera den i ramverket var inga problem.

Nästa problem var att publicera det på Packagist, har aldrig gjort detta innan. Hade lite problem att strukturera upp .json filen så att packagist köpte det.
Efter det så var det fel branch på Packagist, hade skapat en 1.0 tagg och pushat den via git. Men såg endast dev versionen. Efter yttligare en update (v1.2) så kom det upp och allt fungerade som det skulle.

Att skriva dokumentationen var inga större svårigheter, då det inte är någon stor klass. Det var dock väldigt roligt att skriva en 'guide' (om man nu kan kalla det de). Modulen fungerade bra med ANAX-MVC. Laddade ner ett färskt ANAX och la in kraven i composer.json och vips - allt fungerar.
 


Kmom06
------
Ett väldigt intressant kursmoment. Har hört talas på föreläsningarna om testning innan, men har aldrig riktigt förstått vad det handla om. 
När jag hörde "gör ett test-case" hade jag ingen aning om hur det skulle gå till. Men nu är det rätt logiskt. Du anropar en funktion, definierar sedan innan vad som ska returneras och kolla om så är fallet.
Riktigt smart. Trodde inte, från första början, att jag skulle skriva mina testfall själv. Kan lätt få de att vara ok, fast egentligen så fungerar de inte. Med lite mer insyn förstår jag hur dumt det låter nu.

Att installera PHPUnit var inga större problem. Var dock tvungen att skapa ett alias så jag kunde enbart använda "phpunit" som ett kommando.  Gjorde några körningar av test på mumin, gick jätte bra.
Fått en del kunskap om git och taggar, hade lite problem med det. Men mer om det senare. 

Efter jag fått PHPUnit att fungera skapade jag en egen test-klass och skulle försöka. Det tog mig 4 timmar. Problemet var att det inte körde igenom några test och att koden skrevs ut i terminalen. 
Googlade som en galning och pratade med folk i chatten. Till slut kom det fram att jag inte hade en korrekt öppningstagg. Underbart. Efter det rullade på rätt bra.
Fick dock PHPUnit att fungera med PHPStorm, så allt var inte förgäves. 

Är inte helt hundra hur man ska testa saker som inte returnerar något (förutom när man testar exceptions). Tex har jag en medlemsvariabel man kan sätta true eller false. 
Kan vara så att man sätter den till false sedan använder en get-funktion för att se att medlemsvariablen har ett korrekt värde. Hade ingen get-funktionen till denna variablen och känndes inte rätt att lägga till en bara för att använda den till test.
Sen hade jag några funktioner som öppnar och stänger en fil, var inte riktigt med på hur de skulle testas heller.

Fanns även några funktioner som returnerade en formaterad text. Problemet där var att jag skapade ett datum och en viss tid, som inte är samma som datumet i en annan funktion och där med inte blir korrekt när jag använder assertEquals.

Integrera med Travis var inga större problem. Satt en hel dag och försökte fixa med "mumin". Jag ville att Travis skulle köras på tag v1.0 men det ville inte Travis. Lärde mig rätt mycket under den dagen om taggar.
Scrutinizer hade jag aldrig några problem med. 

I början kändes alla dessa verktyg omöjliga och klumpiga. Jag hade inte riktigt koll på vad jag gjorde eller vad verktygen hade att erbjuda.
Nu vill jag använda dessa verktyg på alla mina klasser och se vad som är möjligt att förbättra (även för att kunna visa upp alla fina badges...). Kommer absolut använda dessa i framtiden.

Valde att inte göra extrauppgiften.

[Scrutinizer](https://scrutinizer-ci.com/g/gusseleet/ErrorLogger/?branch=master)
[Travis](https://travis-ci.org/gusseleet/ErrorLogger)