> [!danger]- Cruciaal
> ___
> Bij 0 punten zak je. Je moet minimaal 1 punt behalen.

# Info
___
> [!section]- #### Technische test ^technische-test
> ___
> Een technische test is bedoeld om de implementatie van je code te testen. Op deze manier is er duidelijkheid dat de code naar toebehoren werkt en niet onverwachte bugs kan veroorzaken. Daarom test je verschillende dingen en probeer je je eigen functionaliteiten te breken om ervoor te zorgen dat dingen niet onverwachts verkeerd kunnen in productie. Een technische test mag vakjargon gebruiken. test bijvoorbeeld of api calls naar toebehoren werken of wat anders.
> <br>
>
> Een technische test bevat de volgende onderdelen:
>
> - Testdoel/use case/feature. Wat ga je testen.
> - Verbonden user stories.
> - Pre-conditie. Wat heb je nodig en wat moet je gedaan hebben voordat je de test uitvoert.
> - Beschrijving van wat er zou moeten gebeuren als de test succesvol wordt uitgevoerd (happy path)
> - Uitzonderingen. Wat kan er allemaal mis gaan.
> - Post-conditie. Wat is de verwachte uitkomst, wat is er gebeurt.
> - Minimaal 3 verschillende tests:
>   - Happy path test: De test waar je alles doet zoals het hoort en alles goed gaat.
>   - Low edge case test: Een test waarbij je iets verkeerd doet wat waarschijnlijk veel gebruikers verkeerd kunnen doen. Denk aan het invoeren van verkeerde gegevens bijvoorbeeld.
>   - High edge case test: Een test waarbij je iets verkeerd doet wat bijna niemand verkeerd zou doen maar misschien alsnog schade kan veroorzaken. Denk aan een sql injectie of het injecteren van javascript.
> - Een test bestaat uit:
>   - Stappen die je moet uitvoeren
>   - Data die je nodig hebt
>   - Een manier om te noteren of de test geslaagd is of niet
>   - Het verwachte resultaat. 
>   - Opmerking


> [!section]- #### Acceptatie test ^acceptatie-test
> ___
> Een acceptatie test is bedoeld om aan de opdrachtgever te laten zien, en te overtuigen dat de user story die afgerond is ook helemaal werkt naar toebehoren. Dit zorgt er voor dat er geen geschil kan komen tussen ontwikkelaars en de opdrachtgever over de afgeronde functionaliteiten. Daarom is het belangrijk om de opdrachtgever de test zelf uit te laten voeren, en daarom moeten er dus ook duidelijke instructies zijn zodat ze opdrachtgever deze makkelijk kan volgen. Ook een handtekening is belangrijk omdat dit vastlegt dat er akkoord is gegevens op de geteste functionaliteit, en hiermee afgerond is. De acceptatie test moet een happy path bevatten, en om het zo rond mogelijk te maken, kan de test ook low edge cases bevatten. Acceptatie tests zijn simpel en bevatten geen vak jargon.
> <br>
>
> Een acceptatietest bevat de volgende onderdelen:
>
> - De user story, wat je test.
> - Pre-conditie, wat moet de opdrachtgever doen voordat hij kan beginnen met testen.
> - Vertel stap voor stap wat de opdrachtgever moet doen, en welke gegevens hij daarvoor moet gebruiken.
> - Na elke stap die de opdrachtgever neemt, als er iets te testen valt, vraag wat er zou moeten gebeuren en zorg ervoor dat de opdrachtgever kan beantwoorden met ja of nee.
> - Test de happy path en het liefst ook low edge cases.
> - Ruimte voor een opmerking.
> - Handtekening.


# Minimale Vereisten
___
- Bij iedere test case (of automatische tests) is ten minste aanwezig:
    - Het 'Happy Path' beschreven/getest.
    - Testdata aanwezig voor het “Happy Path”.
    - Het gewenste resultaat beschreven/getest.
    - Een instructie voor de tester aanwezig (of een automatische test gecodeerd).

# Vereisten
___
- Bij iedere test case (of automatische tests) is ten minste aanwezig:
    - Het 'Happy Path' beschreven/getest.
    - Testdata aanwezig voor het “Happy Path”.
    - Het gewenste resultaat beschreven/getest.
    - Een instructie voor de tester aanwezig (of een automatische test gecodeerd).
- En voor alle test cases zijn:
    - In het geval van een technische test:
        - Een of meer alternatieve paden beschreven.
        - testdata voor alternatieve paden geleverd.
    - In het geval van acceptatie test:
        - Handtekening veld voor akkoord.
