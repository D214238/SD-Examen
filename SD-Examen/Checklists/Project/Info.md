# Project structuur
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

- 