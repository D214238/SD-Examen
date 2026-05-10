___

## [[Examen Info/B1-K1 - Realiseert software/W3 - Realiseert (onderdelen van) software/C4 - Versiebeheer|Repo]]
___
> [!section]- #### Branches ^branches
> ___
> - main
> 	- sprint/sprint-1
> 		- _Voor iedere user story maak je een aparte branch volgens dit template:_
> 		- us/us\<nummer\>-\<user-story-naam\>


> [!section]- #### Toestemming ^toestemming
> ___
> Navigeer naar: Settings \> Rules \> Ruleset \> New Ruleset
> <br>
> 
> > [!section]- main
> > ___
> > - Ruleset name: main
> > - Target branches (Add target > Include by pattern): main
> > - [$] Restrict creations
> > - [$] Restrict updates
> > - [#] Restrict deletions
> > - [$] Require linear history
> > - [$] Require deployments to succeed
> > - [$] Require signed commits
> > - [#] Require a pull request before merging
> > 	- Required approvals: 2
> > 	- [$] Dismiss stale pull request approvals when new commits are pushed
> > 	- [$] Require review from specific teams
> > 	- [$] Require review from Code Owners
> > 	- [$] Require approval of the most recent reviewable push
> > 	- [$] Require conversation resolution before merging
> > - [$] Require status checks to pass
> > - [#] Block force pushes
> > - [$] Require code scanning results
> > - [$] Require code quality results
> > - [$] Automatically request Copilot code review
> 
> <br>
> 
> > [!section]- sprint/sprint-1
> > ___
> > - Ruleset name: sprint
> > - Target branches (Add target > Include by pattern): sprint/\*
> > - [$] Restrict creations
> > - [$] Restrict updates
> > - [#] Restrict deletions
> > - [$] Require linear history
> > - [$] Require deployments to succeed
> > - [$] Require signed commits
> > - [#] Require a pull request before merging
> > 	- Required approvals: 1
> > 	- [$] Dismiss stale pull request approvals when new commits are pushed
> > 	- [$] Require review from specific teams
> > 	- [$] Require review from Code Owners
> > 	- [$] Require approval of the most recent reviewable push
> > 	- [$] Require conversation resolution before merging
> > - [$] Require status checks to pass
> > - [#] Block force pushes
> > - [$] Require code scanning results
> > - [$] Require code quality results
> > - [$] Automatically request Copilot code review
> 


> [!section]- #### Labels ^labels
> ___
> Navigeer naar Issues \> Labels
> <br>
> 
> - BUG | red | "Something isn't working"
> - Documentation | blue | "Creation, improvements or additions to documentation"
> - Type: Task | green | "This is a task"
> - Type: User Story | purple | "This is a User Story"
> - WontDo | gray | "This will not be worked on"
> - Question | yellow | "Further information is needed"
> - Invalid | orange | "This doesn't seem right"
> - Enhancement | turquoise | "New feature or request"
> - Duplicate | gray | "This issue already exists"


> [!section] #### Templates ^templates
> ___
> Plaats deze templates in `.github\ISSUES_TEMPLATE` als `UserStory.yml` en `Task.yml`
> <br>
> 
> > [!section]- ##### User Story Template
> > ___
> > ```yaml
> > name: User Story
> > description: Template for a User Story
> > title: "[US <number>]: "
> > labels: ["Type: User Story"]
> > assignees: []
> > 
> > body:
> >   - type: markdown
> >     attributes:
> >       value: |
> >         &nbsp;
> > 
> >   - type: markdown
> >     attributes:
> >       value: |
> >         ## User Story
> > 
> >   - type: textarea
> >     id: user_story
> >     attributes:
> >       label: User Story Description
> >       description: "Describe your user story here:"
> >       value: |
> >         - **Als:** <rol>
> >         - **Wil ik:** <context/wat>
> >         - **Zodat:** <reden/omdat>
> > 
> >   - type: markdown
> >     attributes:
> >       value: |
> >         &nbsp;
> > 
> >   - type: textarea
> >     id: accept_citeria
> >     attributes:
> >       label: Accept Criteria
> >       description: "Describe when you user story is satisfied:"
> >       value: |
> >         - **Gegeven:** <pre-condidite>
> >         - **Wanneer:** <ik dit doe/er dit gebeurt>
> >         - **Dan:** <moet er dit gebeuren>
> > 
> >         ---
> > 
> >         - **Gegeven:** <pre-condidite>
> >         - **Wanneer:** <ik dit doe/er dit gebeurt>
> >         - **Dan:** <moet er dit gebeuren>
> > 
> >   - type: markdown
> >     attributes:
> >       value: |
> >         &nbsp;
> > 
> >   - type: textarea
> >     id: extra_info
> >     attributes:
> >       label: Extra Information / Resources
> >       description: "If this user story needs extra information or attachted documents, like wireframes, or other diagrams, put them here:"
> >       placeholder: |
> >         Extra info...
> > 
> >   - type: markdown
> >     attributes:
> >       value: |
> >         &nbsp;
> > 
> >   - type: textarea
> >     id: revision_notes
> >     attributes:
> >       label: Revision Notes
> >       description: "When a user story fails a test, explain here why, and what the possible fix is:"
> >       value: |
> >         ### <YYYY-MM-DD HH:MM>
> >         - **Test:** <Technisch / Acceptatie>
> >         - **Nummer/Stap:** <nummer>
> >         - **Status:** Gefaald
> >         - **Waarom:** <Reden>
> >         - **Mogelijke oplossing:** <Oplossing>
> >         - **Issues:** #<issue nummer>, #<issue nummer>
> > 
> >         ---
> > 
> >         - **Test:** <Technisch / Acceptatie>
> >         - **Nummer/Stap:** <nummer>
> >         - **Status:** Gefaald
> >         - **Waarom:** <Reden>
> >         - **Mogelijke oplossing:** <Oplossing>
> >         - **Issues:** #<issue nummer>, #<issue nummer>
> > ```
> 
> <br>
> 
> > [!section]- ##### Task Template
> > ___
> > ```yaml
> > name: Task
> > description: Template for a Task
> > title: "[Task]: "
> > labels: ["Type: Task"]
> > assignees: []
> > 
> > body:
> >   - type: markdown
> >     attributes:
> >       value: |
> >         &nbsp;
> > 
> >   - type: markdown
> >     attributes:
> >       value: |
> >         ## Task
> > 
> >   - type: textarea
> >     id: task
> >     attributes:
> >       label: Task Description
> >       description: "Describe your task here:"
> >       placeholder: |
> >         ...
> > 
> >   - type: markdown
> >     attributes:
> >       value: |
> >         &nbsp;
> > 
> >   - type: textarea
> >     id: task_items
> >     attributes:
> >       label: Task Items
> >       description: "List here what you need to do:"
> >       value: |
> >         - [ ] <subtask>
> > 
> >   - type: markdown
> >     attributes:
> >       value: |
> >         &nbsp;
> > 
> >   - type: textarea
> >     id: extra_task_info
> >     attributes:
> >       label: Extra Information / Resources
> >       description: "If this task needs extra information or attachted documents, like wireframes, or other diagrams, put them here:"
> >       placeholder: |
> >         Extra info...
> > ```



## [[Examen Info/B1-K1 - Realiseert software/W1 - Stemt opdracht af, plant werkzaamheden en bewaakt de voortgang/C2 - Kanban#^wat-is-een-kaban|Project]]
___
Maak een nieuwe project aan met de naam van het project waar we alle taken en user stories in bijhouden.

> [!section]- #### Velden
> ___
> Navigeer naar: Projects \> Tasks \> Settings \> Custom fields
> <br>
> 
> > [!section]- ##### Status
> > ___
> > - Backlog | gray | "New items will be gathered here."
> > - To Do | gray | "Items containing complete instructions and necessities and are ready to be assigned and worked on."
> > 	- _Alle nieuwe user stories/taken/issues horen standaard hier in te komen, zorg ervoor dat je dat juist instelt._
> > - Blocked | red | "Items that can't be finished for some reason or when help is needed."
> > - In Progress | green | "Items that are being worked on."
> > - To Revise | yellow | "Items that didn't pass testing and need to be fixed and re-tested."
> > - To Review | purple | "Items that are finished but need to be tested and reviewed by someone."
> > - Done | blue | "Items that have been completed."
> > 	- _wanneer je "fix" of "fixed" gebruikt, horen taken hier in te komen, en automatisch te sluiten_
> > <br>
> > 
> > 
> 
> <br>
> 
> > [!section]- ##### Priority
> > ___
> > - Very High | red | "Has to finished immediately!"
> > - High | orange | "Has to be finished as soon as possible."
> > - Medium | yellow | "Regular priority, flows with the workflow."
> > - Low | green | "Should be finished somewhere in between other tasks but isn't really that important."
> > - Very Low | blue | "Not important, only finish when all other work is finished."
> 
> <br>
> 
> > [!section]- ##### Size
> > ___
> > - XXL | red
> > - XL | red
> > - L | orange
> > - M | yellow
> > - S | green
> > - XS | blue
> > - XXS | blue
> > <br>
> > 
> > _\*Sizes worden voornamelijk gebruikt voor user stories, maar kan ook gebruikt worden voor taken._


> [!section]- #### Views ^views
> ___
> > [!section]- ##### User Stories
> > ___
> > Deze view is een kaban, gefilterd op label "Type: User Story" en gebruikt alle status kolommen
> 
> <br>
> 
> > [!section]- ##### Tasks
> > ___
> > Deze view is een kanban, gefilterd op label "Type: Task" en gebruikt alle kolommen behalve To Review en To Revise. In de context van het project is dit alleen toepasselijk voor User Stories





## Extra info
___
- Taken worden gemaakt als sub-issues van een user story. Zo valt er makkelijk te zien hoe ver een user story.


