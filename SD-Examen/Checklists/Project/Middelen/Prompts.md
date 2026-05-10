> [!section]- #### Generate user stories ^generate-user-stories
> ___
> ```text
> opdracht-context:
> <opdracht>
> 
> prompt:
> Maak User Stories op basis van de opdracht-context. De User stories moeten het I.N.V.E.S.T model volgen.
> Zet deze user stories in een tabel met de headers: "Als", "wil ik", "zodat". 
> De user stories volgen deze context:
> Als <rol> wil ik <context/wat> zodat <reden/omdat>
> ```





#### Hulpmiddelen voor prompts
___
Als je maar 1 rij kopieert, en in excel wilt plakken, dan plakt hij deze verticaal. als je dit horizontaal wilt plakken, dan klik je ff hier op nadat je de rij hebt gekopieerd:

```dataviewjs
const text = "Reformat row";
const btn = dv.el('button', text);

btn.onclick = () => {
    navigator.clipboard.readText().then(t => {
        // Clean up the text and replace newlines with tabs
        const horizontal = t.trim().replace(/\r?\n/g, '\t');
        
        navigator.clipboard.writeText(horizontal).then(() => {
            btn.innerText = "✓ Copied to Clipboard!";
            
            // Reset the text after 1 second
            setTimeout(() => {
                btn.innerText = text;
            }, 1000);
        });
    }).catch(err => {
        btn.innerText = "Error: Check Console";
        console.error(err);
    });
};

```

