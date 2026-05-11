Dit is voor een webshop genaamd WearMe, gemaakt in laravel 13 met blade, breeze en spatie (geen livewire) en een mysql database die verschillende draagbare artikelen verkoopt. denk aan sierraden, horloges, armbanden, kettingen oorbellen en soortgelijke producten.
# Globale requirements
- de website, behalve admin paneel is maar 2/3 breed met ruimte aan de zijkant voor eventuele advertenties.
- adressen moeten in een aparte database met een user is, een user kan meerdere adressen hebben
- code is geschreven via de [**PER 3.0**](https://www.php-fig.org/per/coding-style/).
- alle code is in het Engels, alleen de website zelf is in het nederlands.
- order moet dus voor een user zijn, maar heeft ook een aparte record met adres waar het heen moet
- zoveel mogelijk herbruikbare componenten maken ipv alleen hele blade views met alles er inI
	- ik wil het liefst als dezelfde soort componenten op een webiste worden gebruikt dat dit in aparte compontenten staat, zoals tables, forms, formfields, etc, bijna alles.
- correcte models, factorties en seeders met fake data.
- geen tailwind, alles word geshreven in normnale css
- css en javascript zit in style and script tags in de componenten zelf.
- globale css en js bestand wordt alleen gebruikt voor globale styling die je op elke pagina nodig hebt, en is netjes geschreven in nested css blocks. niet perse 1 groot block, maar misschien wel voor individuele pagina styling. voor blade views staat de css en js wel namelijk in de main css en js bestanden.
- deze applicatie moet gebruik maken van laravel breeze en laravel spatie voor autorizatie en rollen
	- er zijn 3 rollen:
		- user (gewone gebruiker)
		- admin (beheerder die alles kan aanpassen in het admin paneel)
		- superadmin (zelfde als beheerder, maar dit account kan nooit verwijderd worden.)
- input velden moeten geschecked worden zowel op de frontend met html als op de backend in laravel met formrequests
- de hoofd accent kleur van de website is een mooie licht bruin
- website heeft een navigatie header, deze mag wel de hele breedte in nemen. bevat ook een zoekbalk en is sticky / fixed
	- ook deze is gemaakt als een component.
- alles moet natuurlijk goed staan op desktop, maar ook voor mobile.
- (kijk goed of ik niks gemist heb, de database structuur kan je wel uit de pagina's halen)
- verzin zelf de rest

# Pagina's
## Niet ingelogde gebruikers
- **Home**
	- slideshow met actie items
	- categorieën >
		- hoofd category en sub category
	- uitgelichte producten
	- footer met winkel gegevens en headers met links
- **login & account aanmaken**
	- login
		- email
		- wachtwoord
		- onthou mij
		- inlog knop
	- account aanmaken
		- naam
		- email
		- adres gegevens
		- (nog meer eventuele toepasselijke velden)
		- wachtwoord
		- wachtwoord herhalen
		- onthou mij
		- account aanmaken knop
	- wachtwoord reset
		- email
- **Producten**
	- alle producten (max 25 per pagina)
		- kunnen zoeken op naam (fuzzy?)
		- kunnen filteren op:
			- prijs min max
			- categorie
				- collpaseable side view met hoofd categorieën
					- collapseable view met sub categorieën onder de hoofd categorie die je ook gewoon kan aanklikken
			- merk
			- (andere toepasbare velden)
	- enkel product inzien
		- naam
		- categorie
			- subcategorie
				- sub sub categorie
					- etc
		- merk
		- beschrijving (gebruik [EasyMDE](https://github.com/ionaru/easy-markdown-editor))
		- prijs
		- korting (procent of bedrag)
		- foto's
		- stock
		- aantal
		- in winkelwagen stoppen > sessie winkelwagen
- **categorieën**
	- categorieën
		- categorie 
		- subcategorieën
			- je kan op alsnog op de hoofd categorie klikken of op een sub category 
			- > producten pagina gefilterd op categorie of subcategorie
- **winkelwagen (icon met hoeveelheid producten in cart) (in sessie)**
	- overzicht van producten
		- per product zien je foto, naam, en prijs, eventueel korting prijs
		- ook zie je of je product niet uitverkocht is of niet meer actief/beschikbaar is.
		- handel ook correct als bijvoorbeeld een user 3 van iets besteld heeft, maar er nog maar 2 zijn, dit hoort op een subtiele manier wel bekend gemaakt te worden
		- orders zie uitverkocht zijn of niet meer actief zijn hoort ook op een subtiele manier bekend gemaakt te worden.
	- totaal prijs
	- item uit kart kunnen halen of extra er in doen
	- verder naar bestellen > account aanmaken of inloggen
		- sessie cart wordt in de database geladen




## Ingelogde gebruikers
alles van niet ingelogde gebruiken en:
- **login & account aanmaken**
	- uitloggen
- **Producten**
	- enkel product inzien
		- in winkelwagen stoppen > database winkelwagen
- **categorieën**
	- categorieën / sub categorieën
		- subcategorieën
			- > producten pagina gefilterd op categorie
- **winkelwagen (icon met hoeveelheid producten in cart) (in database)**
	- verder naar bestellen
		- > bevestig / check order pagina
- **profiel**
	- overzicht gebruiker
	- gebruiker moet zichzelf kunnen aanpassen zoals naam, email, adres, etc
	- bevestiging bij opslaan. adres wordt niet overschreven, maar de id van het nieuwe adres word er aan gekoppeld aangezien er order zijn die naar een ander adres wordt gestuurd.
	- gebruiker kan meerdere adressen hebben ingevoerd dus die moeten hier allemaal getoond worden.
- **orders**
	- overzicht van geplaatste orders met totaal prijs
	- individuele order inzien
		- alle gegevens van een order, inclusief totaal bedrag en adres waarnaartoe, en order barcode. deze pagina moet printbaar zijn, er is ergens een afdruk knop
		- ook zie je alle producten individueel met prijs, naam, foto, etc (wat toepasbaar is), dit is in principe ook een link naar de product pagina.
- **bedankt pagina**
	- een pagina die je bestelling bevestigd, en dankjewel voor je bestelling zegt, met een printbare order code en overzicht order, in princiepe zelfde pagina als die je kan zien in orders > enkele order.
	- zodra een bestelling besteld is, en je op deze pagina komt, hoort de stock ook gelijk geupdatet te worden.
- **bevestig / check order pagina**
	- je kan hier checken of je order correct is voordat je je bestelling plaats, je kan hier het overzicht van je producten zien inclusief naam, merk, prijs, korting, etc (wat toepasbaar is)
	- producten die niet meer actief zijn of niet in stock zijn, zitten nog wel in de order, maar worden er hier uit gefilterd. deze worden ook niet opgeslagen in de order
	- handel ook correct als bijvoorbeeld een user 3 van iets besteld heeft, maar er nog maar 2 zijn, dit hoort op een subtiele manier wel bekend gemaakt te worden
	- je moet eventueel je adres kunnen wijzigen hier
		- dit overschijft niet je adres in je account, maar maakt wel een nieuw adres in de database, gekoppeld aan de user, en gebruikt deze voor de user
	- bestelling plaatsen >
		- bedankt pagina met printbare order code en overzicht order

## Admins
alles van ingelogde gebruiker en:
een admin paneel waar je dit kan doen
- **login & account aanmaken**
	- uitloggen
	- naar admin paneel
- **Gebruikers**
	- overzicht met alle gebruikers
		- sorteerbaar op verschillende velden van een een  gebruiker, maar ook create datum, edit datum en alfabetisch
		- filterbaar, volgens verschillende velden van een gebruiker.
		- zoekbalk  (fuzzy?)
	- individuele gebruiker gegevens inzien
	- een individuele gebruiker zijn gegevens aanpassen.
		- \*adres wordt niet overschreven, maar de id van het nieuwe adres word aan de user gekoppeld aangezien er order zijn die naar een ander adres wordt gestuurd.
		- verzend wachtwoord reset link via email optie
	- individuele gebruiker aanmaken
	- individuele gebruiker verwijderen 
	- overzicht van gebruikers moet exporteerbaar zijn als csv. je komt op een nieuwe pagina waar je kan filteren op verschillende velden en dan kan je klikken op exporteer
- **beheerders**
	- overzicht van alle beheerders
		- sorteerbaar op verschillende velden van een een  beheerder, maar ook create datum, edit datum en alfabetisch
		- filterbaar, volgens verschillende velden van een beheerder.
		- zoekbalk  (fuzzy?)
	- je kan hier nieuwe beheerders aanmaken, wijzigen, kunnen inzien en verwijderen (je kan de superadmin niet verwijderen of wijzigen)
	- overzicht van beheerders moet exporteerbaar zijn als csv. je komt op een nieuwe pagina waar je kan filteren op verschillende velden en dan kan je klikken op exporteer
- **Producten**
	- overzicht van alle producten
		- sorteerbaar op verschillende velden van een product, maar ook create datum, edit datum en alfabetisch
		- filterbaar, net als in de frontend in de webshop.
		- zoekbalk (fuzzy?)
	- je moet ook producten kunnen aanmaken, verwijderen, kunnen inzien of wijzigen. deze heeft alle velden op de frontend zoals:
		- naam
		- category
			- subcategory
		- merk
		- beschrijving, met titlel en subsecties en lijst, gebruik [EasyMDE](https://github.com/ionaru/easy-markdown-editor)
		- prijs
		- korting (procent of bedrag)
		- foto's
		- stock
		- aantal
		- \* maar ook deze velden:
			- boolean actieproduct (dit bepaald of het product in de acties slideshow op de home pagina komt)
			- boolean actief (niet actieve producten worden niet getoond op de webshop)
			- boolean uitgelicht (dit bepaald of deze in de featured sectie komt op de homepagina)
		- overzicht van producten moet exporteerbaar zijn als csv. je komt op een nieuwe pagina waar je kan filteren op verschillende velden en dan kan je klikken op exporteer
- **categorieën**
	- overzicht alle categorieen en sub categorieen en sub sub caterorieën, etc.
		- sorteerbaar op verschillende velden van een categorie / sub categorie, maar ook create datum, edit datum en alfabetisch
		- filterbaar, volgens de velden van een categorie
		- zoekbalk (fuzzy?)
	- je moet ook categorieen kunnen aanmaken, kunnen inzien, wijzigen en verwijderen
	- en je moet hier sub categorieen kunnen aanmaken, wijzigen en verwijderen.
	- ook moet je kunnen zien hoeveel producten er in iedere categorie 
	- overzicht van categorieen moet exporteerbaar zijn als csv. je komt op een nieuwe pagina waar je kan filteren op verschillende velden en dan kan je klikken op exporteer
- **orders**
	- overzicht van alle geplaatse order en de gebruiker die de order geplaats heeft
		- sorteerbaar op verschillende velden van een order & user, maar ook create datum, edit datum en alfabetisch
		- filterbaar, volgens de velden van een order & user
		- zoekbalk (fuzzy?)
	- je moet een individuele order kunnen aanmaken, kunnen inzien, wijzigen en verwijderen.
		- een idividuele order heeft ook extra velden die hier getoond worden:
			- status: onbehandeld, in behandeling, staat klaar, afgerond. wanneer een order wordt geplaatst is deze standaard onbehandeld.
	- overzicht van orders moet exporteerbaar zijn als csv. je komt op een nieuwe pagina waar je kan filteren op verschillende velden en dan kan je klikken op exporteer
- **profiel**
	- in princiepe moet een beheerder ook zijn eigen gegevens moeten kunnen aanpassen, net als een gebruiker. (behalve de superadmin)
- instellingen
	- winkel gegevens (deze worden getoond in de footer)
		- verschillende gegevens zoals
			- webshop naam
			- email
			- telefoon
			- adres
			- beschrijving
	- headers en links
		- \* voor het tonen in de footer




laravel bestandstructuur context:
- **resources/views**
	- layout
		- _Hierin zitten layout files, denk aan de main layout van de applicatie waar de `<!DOCTYPE html>` in staat bijvoorbeeld. Je hebt bijvoorbeeld een layout voor je applicatie, en een andere layout voor je error pagina._
	- pages
		- _Hier staan je daadwerkelijke views in. De folder structuur volgt de url structuur._
	- components
		- _Hierin staan al je componenten, netjes opgedeeld in folders, maar niet te diep zoals bijvoorbeeld:_
			- _layout/header.blade.php_
			- _checkbox/index.blade.php_
			- _checkbox/round.blade.php_
			  
- **app/Http/Controllers** (controllers volgt dezelfde structuur als de urls / view/pages)
- _Controllers zijn grotendeels voor het regelen van communicatie en het verstrekken van data tussen een page/component en de backend.
	- Page
		- _Deze folder bevat controllers die de url structuur / views/pages structuur volgen en zijn opgedeeld in 2 soorten_
		- User
			- UserController (_alleen resource functies, absoluut geen data verwerking, alleen communicatie en data verstrekking_)
			- UserActionController (_alles dat geen resource functie is, maar wel alleen toebehoort op deze pagina_)
		- Order
			- OrderController
			- OrderActionController
	- Shared
		- _Deze folder bevat alleen generieke acties niet gebonden aan een specifieke pagina, en kunnen meerdere functies bevatten of kunnen invokeable zijn_
		- ExportController
		- PaymentController
		  
- **app/Http/Services** (klassen)
	- _Deze folder is voor logica wanneer een functie in je controller te groot wordt, of wanneer logica op meerdere plekken gebruikt kan worden. Services gebruiken context van de rest van de applicatie, zoals een database verbinding of andere services._
	- PaymentService
	- OrderService

- **app/Http/Utilities** (klassen)
	- _Soortgelijk aan Services, alleen Utilities zijn herbruikbare stukken logica die geen context nodig hebben van de rest van de applicatie, dus geen database verbinding, geen models, geen andere services, etc._
	- ExportUtility
	- FormatUtility

- **app/Helpers**
	- Helpers.php
		- _Dit bestabd bevat generieke functies die te simpel zijn om een Service of Utility voor te maken, deze functies worden op meerdere plekken door de applicatie gebruikt. Zodra je veel functies hebt die in dezelfde category vallen, dan moet dit uitbesteed worden aan een Service of Utility_

- **app/Structures**
	- _Mocht het nodig zijn om een nieuwe data structuur te maken, denk aan iets zoals een collection, dan moet je dit hier plaatsen._

- **app/Traits**
	- _Hier definieer je functionaliteiten die meerdere classen kunnen gebruiken, of bijvoorbeeld meerdere models kunnen implementeren._

- **app/Providers**
- _Providers registreer je wanneer je deze wilt gebruiken als dependency injections. Denk goed na over of je een provider lazy maakt of niet. Deze zijn opgedeeld in 3 folders_
- Extenders
	- _Hier definieer je providers die dingen toevoegen aan bestaande functionaliteiten van laravel_
	- StringExtensionProvider
	- BladeExtensionProvider
- Services
	- _Hier definieer je providers die een service binden_
	- OrderServiceProvider
- Utilities
	- _Hier definieer je providers die een utility binden_
	- ExportUtilityProvider
