# Info
___
> [!section]- #### Tools ^tools
> ___
> ##### https://app.diagrams.net/
>
> Een website waar je diagrammen kan maken zonder account. Deze website mag je gebruiken op je examen.
>
> ##### https://dbdiagram.io/d
>
> Een website waar je ERD’s kan maken zonder account. Deze website mag je gebruiken op je examen.


> [!section]- #### ERD ^erd
> ___
> > [!section]- ##### Wat is een ERD?
> > ___
> > Een ERD is een overzicht van de verschillende data / models / tabellen in je database en de relatie dat deze hebben met elkaar. Hier is een simpele uitleg over erds:
> >
> > https://www.youtube.com/watch?v=xsg9BDiwiJE
>
><br>
>
> > [!section]- ##### Kardinaliteit (verbindingen)
> > ___
> > Kraaienpoten bestaan uit 2 symbolen. het binnenste symbool representeert de minimum hoeveelheid, het buitenste symbool vertegenwoordigt de maximum hoeveelheid. als er maar 1 symbool aan het einde van de lijn staat, dan is dit altijd een aanduiding van de maximum hoeveelheid. minimum valt dan weg.
> > <br>
> >
> > ![[_attachments/Crowsfeet Example.svg]]
> <br>
> 
> > [!section]- ##### ERD voorbeeld
> > ___
> > ![[_attachments/ERD Example.svg]]


> [!section]- #### Wireframe ^wireframe
> ___
> > [!section]- ##### Hoe maak ik een wireframe?
> > ___
> > Wireframes zijn snelle schetsen om snel op papier te krijgen hoe je wilt dat je website of dergelijke er uit komen te zien. Wireframes zijn vooral gericht op de layout en op de navigatie. Hier zijn wat do’s and don’ts voor wireframes:
> > <br>
> >
> > | Do’s | Don’ts |
> > | --- | --- |
> > | ▪ Layout<br>▪ Navigatiestructuur (naar andere wireframes)<br>▪ Content plaatsing<br>▪ Belangrijke UI elementen<br>▪ Snelle schets | ▪ Kleuren<br>▪ Afbeeldingen<br>▪ Formulieren<br>▪ Styling<br>▪ Visuele details |
>
> > [!section]- ##### Wireframe voorbeeld
> > ___
> > ![[_attachments/Wireframe Example.svg]]


> [!section]- #### Use Case Diagram ^use-case-diagram
> ___
> > [!section]- ##### Wat is een use case diagram?
> > ___
> > Een Use Case Diagram is een diagram dat wordt gebruikt om snel en overzichtelijk het doel van je applicatie te laten zien. Op hoog niveau wordt er getoond hoe gebruikers (actors) met een systeem interageren en welke functionaliteiten het systeem biedt.
> > <br>
> > 
> > Het belangrijkste doel is systeemeisen visueel maken zodat iedereen (developers, stakeholders, business) snel begrijpt:
> >
> > - Wie het systeem gebruikt (actors)
> > - Wat het systeem moet kunnen (use cases / functionaliteiten)
> > - Hoe die interacties globaal verlopen
> > <br>
> >
> > In sommige gevallen is het beter om je use case diagram op te splitsen in meerdere diagrammen als ze te groot en te complex worden. Of misschien zijn er meerdere primaire actoren in je systeem die je beter in aparte diagrammen kan plaatsen. Denk bijvoorbeeld aan een klant of een verkoper op een webshop. Beide kunnen een primaire actor zijn, maar beide actoren hebben verschillende use cases op de website. Maar denk bijvoorbeeld ook aan als je zo veel verschillende dingen kan doen op je webshop, dat je eerst een heel hoog level use case diagram maakt, met termen zoals “view products” en “buy products” en dat je daarna aparte use case diagrammen maakt om ze verder te specificeren. Als je bijvoorbeeld dan “Buy products” pakt kan je deze weer opsplitsen in “Add product to cart”, “Remove product from cart”, “View items in cart”, “change quantity of items in cart”, etc.
> ><br>
> >
> > Let op, op wat je noteert als use case. Een use case is een bepaalde functie die je doet om een bepaald doel te bereiken. Erg generieke doelen kan je misschien beter weglaten. En je moet ook opletten dat je je use cases niet te klein of te specifiek maakt. Een use case diagram is voor een globaal overzicht, niet elk detail van de applicatie hoeft uitgewerkt te zijn.
>
> > [!section]- ##### Actoren
> > ___
> > ###### Primaire actoren
> > ___
> > primaire actoren staan aan de linker kant van de diagram en zijn de actoren die als eerst met het systeem interacteren. Dit zijn de actoren die het systeem gebruiken om een bepaald doel te bereiken. Denk bijvoorbeeld aan klant die een webshop bezoekt.
> > <br>
> >
> > ###### Secundaire actoren
> > ___
> > Secundaire actoren staan aan de rechter kan van de diagram en ondersteunen het systeem tijdens de verschillende use cases. Deze actoren maken alleen gebruik van het systeem als reactie op primaire actoren. Denk bijvoorbeeld de betalingsprovider van een webshop.
>
> > [!section]- ##### Use cases
> > ___
> > Use cases zijn acties die je neemt in het systeem om een bepaald doel te bereiken. Deze zijn niet te klein, en deze zijn ook niet te abstract met vakjargon. De use cases zijn geschreven vanuit het perspectief van de primaire actoren.
> > <br>
> >
> > | Slechte voorbeelden | Goede voorbeelden |
> > | --- | --- |
> > | • Wachtwoord controleren<br>• Database opslaan<br>• Prijs berekenen<br>• Kleur aanpassen van de text op mijn profiel | • Account registreren<br>• Inloggen<br>• Profiel bewerken<br>• Product bekijken<br>• Product toevoegen<br>• Product aanpassen |
>
> > [!section]- ##### Includes & Extends
> > ___
> > ###### Includes
> > ___
> > Includes zijn dingen die **altijd** uitgevoerd worden als een use case wordt uitgevoerd. Dit is ook gewoon een bubbel, net als een use case. Een include wordt genoteerd als een pijl met stippellijn, en de pijl wijst naar de include bubbel. Ook in of boven de stippellijn staat \<\<include\>\> genoteerd.
> > <br>
> >
> > ![[_attachments/Include example.svg|500]]
> ><br>
> >
> > ###### Extends
> > ___
> > Extends zijn dingen die **optioneel** uitgevoerd worden als een use case wordt uitgevoerd. Dit is ook gewoon een bubbel, net als een use case. Een extend wordt genoteerd als een pijl met stippellijn, en de pijl wijst naar de use case bubbel. Ook in of boven de stippellijn staat \<\<extend\>\> genoteerd.
> > <br>
> >
> > ![[_attachments/Exclude example.svg|500]]
>
> > [!section]- ##### Use case diagram voorbeeld
> > ___
> > > [!section]- ###### Breed
> > > ___
> > > ![[_attachments/Use case breed.svg]]
> > <br>
> >
> > > [!section]- ###### Specific
> > > ___
> > > ![[_attachments/Use case specifiek.svg]]


> [!section]- #### Sitemap ^sitemap
> ___
> Een sitemap is heel erg simpel. Het is een lijst van elke unieke url van je website zonder parameters.
> <br>
>
> ```text
> Home
> │
> ├── Products
> │   ├── Categories
> │   │   ├── Electronics
> │   │   ├── Clothing
> │   │   └── Home & Kitchen
> │   ├── Product Detail Page
> │   └── Search Results
> │
> ├── Cart
> │   └── Checkout
> │       ├── Shipping Information
> │       ├── Payment
> │       └── Order Confirmation
> │
> ├── Account
> │   ├── Login / Register
> │   ├── Profile
> │   ├── Orders
> │   └── Saved Items
> │
> ├── About
> │
> ├── Contact
> │
> └── Support
>     ├── FAQ
>     └── Returns & Refunds
> ```


> [!section]- #### Flowchart ^flowchart
> ___
> > [!section]- ##### Wat is een flowchart?
> > ___
> > - happy path behalve wanneer error
> > - alleen gefocust op logica, dus niet het laden van webpagina’s of klikken op iets in de flowchart zetten
> > - alleen choice diamanten gebruiken als het echt waarde toevoegt. als het niks veranderd dan niet toevoegen.
> > - de ui navigeren gebeurt automatisch door de processen en keuzes.
> > - flowchart kan gedetailleerd zijn en dus wel stappen bevatten zoals click hierop en dan stuur door naar die pagina. maar denk van te voren wat het doel is van de flowchart en of dat nodig is. voor een opdrachtgever als overview zijn zulke details niet nodig, en er kan wel van redelijk wat aannames worden genomen over wat er gebeurt. maar ze kunnen wel handig zijn voor bijvoorbeeld programmeurs om een bepaald process in kaart te brengen, en te weten wat ze exact moeten doen. Denk ook vooral bij elke vorm of dat het toegevoegde waarde heeft. je kan wel een zooitje processen toevoegen, maar zou de logica en betekenis hetzelfde zijn als ze weg gelaten worden of samengevoegd worden in andere vormen. je kan bijvoorbeeld een proces makes voor het doorsturen naar een andere pagina, maar je kan daar ook vanuit gaan dat dat gebeurd nadat je een bepaalde keus hebt gemaakt.
>
> > [!section]- ##### Vormen
> > ___
> > ![[_attachments/Flowchart shapes.svg]]
>
> > [!section]- ##### Zwembanen (Swimlanes)
> > ___
> > Flowcharts vormen kunnen ook worden verdeeld in aparte kolommen in dezelfde flowchart om een overzicht te creëren welke processen bijvoorbeeld in een specifieke sectie uitgevoerd worden. Je kan bijvoorbeeld een flowchart verdelen in de verschillende branches in je bedrijf. Of je kan het bijvoorbeeld opsplitsen in frontend en backend.
>
> > [!section]- ##### Flowchart voorbeeld
> > ___
> > ![[_attachments/Flowchart example.svg]]


> [!section]- #### Regels ^regels
> ___
> ##### AVG / GDPR
> ___
> niet perse belangrijk voor examen. Je kan meer lezen op deze website: https://www.autoriteitpersoonsgegevens.nl/themas/basis-avg/avg-algemeen/de-avg-in-het-kort.
> <br>
> 
> ##### Ethiek
> ___
> Niet perse belangrijk voor examen.


> [!section]- #### Activiteitendiagram ^activiteitendiagram
> ___
> Dit is in principe een wat dommere / simpelere variant van een flowchart. Dit ga je waarschijnlijk niet gebruiken voor je examen. Dit gebruik je om een bepaald process in simpele termen door te lopen. Je kan er hier meer over vinden: [UML 2.0 Activity Diagrams](https://www.youtube.com/watch?v=XFTAIj2N2Lc).


> [!section]- #### Klassendiagram ^klassendiagram
> ___
> Dit is precies wat je denkt dat het is, een kant tekening van één of meerdere klassen in je code. Dit ga je niet gebruiken op je examen, maar je kan er eventueel hier meer over vinden: [UML Class Diagram Tutorial](https://www.visual-paradigm.com/guide/uml-unified-modeling-language/uml-class-diagram-tutorial/).


# Vereisten
___
- Juiste diagrammen zijn gemaakt die correct toebehoren tot het project.
- De diagrammen bevatten geen fouten.
- De schema’s die gekozen zijn, zijn goed toepasselijk voor de functionaliteit / user stories.