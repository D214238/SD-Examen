/**
 * @RunJS {n:'Startup/Custom fonts'} 
 */

async function loadFonts() {
    const { vault } = app;
    const adapter = vault.adapter;
    const fontsPath = ".obsidian/fonts";

    // 1. The Lookup Map
    // Key: The exact filename in your .obsidian/fonts folder
    // Value: Array of configurations (Family + Weight)

    const fontLibrary = {
        // --- Font Awesome: Pro ---
        "fa-solid-900.woff2": [
            { family: "Font Awesome 7 Pro", weight: "900", style: "normal" },
            { family: "Font Awesome 5 Pro", weight: "900", style: "normal" },
            { family: "FontAwesome", style: "normal" }
        ],
        "fa-regular-400.woff2": [
            { family: "Font Awesome 7 Pro", weight: "400", style: "normal" },
            { family: "Font Awesome 5 Pro", weight: "400", style: "normal" },
            {
                family: "FontAwesome",
                style: "normal",
                unicodeRange: "u+f003,u+f006,u+f014,u+f016-f017,u+f01a-f01b,u+f01d,u+f022,u+f03e,u+f044,u+f046,u+f05c-f05d,u+f06e,u+f070,u+f087-f088,u+f08a,u+f094,u+f096-f097,u+f09d,u+f0a0,u+f0a2,u+f0a4-f0a7,u+f0c5,u+f0c7,u+f0e5-f0e6,u+f0eb,u+f0f6-f0f8,u+f10c,u+f114-f115,u+f118-f11a,u+f11c-f11d,u+f133,u+f147,u+f14e,u+f150-f152,u+f185-f186,u+f18e,u+f190-f192,u+f196,u+f1c1-f1c9,u+f1d9,u+f1db,u+f1e3,u+f1ea,u+f1f7,u+f1f9,u+f20a,u+f247-f248,u+f24a,u+f24d,u+f255-f25b,u+f25d,u+f271-f274,u+f278,u+f27b,u+f28c,u+f28e,u+f29c,u+f2b5,u+f2b7,u+f2ba,u+f2bc,u+f2be,u+f2c0-f2c1,u+f2c3,u+f2d0,u+f2d2,u+f2d4,u+f2dc"
            }
        ],
        "fa-light-300.woff2": [
            { family: "Font Awesome 7 Pro", weight: "300", style: "normal" },
            { family: "Font Awesome 5 Pro", weight: "300", style: "normal" }
        ],
        "fa-thin-100.woff2": [
            { family: "Font Awesome 7 Pro", weight: "100", style: "normal" }
        ],

        // --- Font Awesome: Brands ---
        "fa-brands-400.woff2": [
            { family: "Font Awesome 7 Brands", weight: "400", style: "normal" },
            { family: "Font Awesome 5 Brands", weight: "400", style: "normal" },
            { family: "FontAwesome", style: "normal" }
        ],

        // --- Font Awesome: Duotone ---
        "fa-duotone-900.woff2": [
            { family: "Font Awesome 7 Duotone", weight: "900", style: "normal" },
            { family: "Font Awesome 5 Duotone", weight: "900", style: "normal" }
        ],
        "fa-duotone-regular-400.woff2": [
            { family: "Font Awesome 7 Duotone", weight: "400", style: "normal" }
        ],
        "fa-duotone-light-300.woff2": [
            { family: "Font Awesome 7 Duotone", weight: "300", style: "normal" }
        ],
        "fa-duotone-thin-100.woff2": [
            { family: "Font Awesome 7 Duotone", weight: "100", style: "normal" }
        ],

        // --- Font Awesome: Sharp ---
        "fa-sharp-solid-900.woff2": [
            { family: "Font Awesome 7 Sharp", weight: "900", style: "normal" }
        ],
        "fa-sharp-regular-400.woff2": [
            { family: "Font Awesome 7 Sharp", weight: "400", style: "normal" }
        ],
        "fa-sharp-light-300.woff2": [
            { family: "Font Awesome 7 Sharp", weight: "300", style: "normal" }
        ],
        "fa-sharp-thin-100.woff2": [
            { family: "Font Awesome 7 Sharp", weight: "100", style: "normal" }
        ],

        // --- Font Awesome: Sharp Duotone ---
        "fa-sharp-duotone-solid-900.woff2": [
            { family: "Font Awesome 7 Sharp Duotone", weight: "900", style: "normal" }
        ],
        "fa-sharp-duotone-regular-400.woff2": [
            { family: "Font Awesome 7 Sharp Duotone", weight: "400", style: "normal" }
        ],
        "fa-sharp-duotone-light-300.woff2": [
            { family: "Font Awesome 7 Sharp Duotone", weight: "300", style: "normal" }
        ],
        "fa-sharp-duotone-thin-100.woff2": [
            { family: "Font Awesome 7 Sharp Duotone", weight: "100", style: "normal" }
        ],

        // --- Font Awesome: Legacy ---
        "fa-v4compatibility.woff2": [
            {
                family: "FontAwesome",
                style: "normal",
                unicodeRange: "u+f041,u+f047,u+f065-f066,u+f07d-f07e,u+f080,u+f08b,u+f08e,u+f090,u+f09a,u+f0ac,u+f0ae,u+f0b2,u+f0d0,u+f0d6,u+f0e4,u+f0ec,u+f10a-f10b,u+f123,u+f13e,u+f148-f149,u+f14c,u+f156,u+f15e,u+f160-f161,u+f163,u+f175-f178,u+f195,u+f1f8,u+f219,u+f27a"
            }
        ],

        // --- Regular fonts: Open Sans ---
        "OpenSans-VariableFont_wdth,wght.ttf": [
            { family: "Open Sans", weight: "100 900", style: "normal" }
        ],
        "OpenSans-Italic-VariableFont_wdth,wght.ttf": [
            { family: "Open Sans", weight: "100 900", style: "italic" }
        ],

        // --- Regular fonts: Ubuntu Mono ---
        "UbuntuMono-Regular.ttf": [
            { family: "Ubuntu Mono", weight: "400", style: "normal" }
        ],
        "UbuntuMono-Bold.ttf": [
            { family: "Ubuntu Mono", weight: "700", style: "normal" }
        ],
        "UbuntuMono-Italic.ttf": [
            { family: "Ubuntu Mono", weight: "400", style: "italic" }
        ],
        "UbuntuMono-BoldItalic.ttf": [
            { family: "Ubuntu Mono", weight: "700", style: "italic" }
        ]
    };

        if (!(await adapter.exists(fontsPath))) {
            console.warn("Fonts folder not found:", fontsPath);
            return;
        }

    // 2. Scan folder once
    const folderContents = await adapter.list(fontsPath);
    const fontFiles = folderContents.files.filter(f => /\.(ttf|otf|woff2|woff)$/i.test(f));

    for (const filePath of fontFiles) {
        const fileName = filePath.split('/').pop();
        
        // 3. Lookup using square brackets []
        let config = fontLibrary[fileName];

        // 4. Default if not in library
        if (!config) {
            const fontName = fileName
                .replace(/\.[^/.]+$/, "")
                .replace(/[^A-Za-z0-9]+/g, " ")
                .trim();

            config = [{ family: fontName, weight: "400" }];
            console.log(`Auto-detected: ${fontName}`);
        }

        const fontUrl = adapter.getResourcePath(filePath);
        for (const setting of config) {
            const fontSettings = {
                weight: setting.weight,
                style: setting.style || 'normal',
                display: 'block'
            };

            if (setting.unicodeRange) fontSettings.unicodeRange = setting.unicodeRange;

            try {
                const font = new FontFace(setting.family, `url(${fontUrl})`, fontSettings);
                await font.load();
                document.fonts.add(font);
            } catch (e) {
                console.error(`Failed to load ${setting.family}:`, e);
            }
        }
    }
    console.log("All fonts loaded successfully.");
}

loadFonts();