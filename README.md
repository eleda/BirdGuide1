# EdNetwork Madárhatározó webalkalmazás

Webes madár határozó alkalmazás, melyben hazai madárfajokat lehet keresni.
2011-ben indult el ez a projekt. Natív PHP alapokon nyugszik, fájlokban vannak tárolva az adatok.
A megjelenítésért a Bootstrap könyvtár a felelős. HTML5 reszponzív megjelenítés van, mobilon is használható az oldal.
Ez az alkalmazás magyarul érhető el.

# Használat

A program élő kiadása itt található meg:
http://ednetwork.pe.hu/birdguide1/guide.php

A kezdőoldalon négy véletlen madárfajt lehet megtalálni. Ez minden betöltéskor más és más.
Egy madár képére kattintva elolvasható a faj neve, rendszertani elnevezése és rövid leírása hangokkal és képpel.
Ha a rendjére kattintunk, akkor a rendszertani rend összes faja megjelenik.

Fent, a navigációs sávban két menüpont van:
Az **Osztályok** menüpont az összes leírt rendszertani osztályt felsorolja. Egy osztályra kattintva 
megjelenik az összes hozzá tartozó faj családokba sorolva.

A **Random** menüponttal egy véletlen madár jeleníthető meg.

A **keresődoboz** segítségével, a madárfaj nevére, rendszertani elnevezésére lehet rákeresi. Az eredmény listájából kiválasztható
a keresendő faj.

# Technikai részletek

A fajok .spe, a magyar fordítások a hu.dic fájlba vannak téve. Név=érték formátumban találhatók mindezek.

A könyvtárak:
- **css**: guide.css, style.css, extra.css: ezek a használt stíluslapok.
- **data**: itt van az összes madárfaj adat fájlja és könyvtárszerkezete.
- **images**: alap képek.
- **js**: extra.js, a videós megjelenítéshez.
- **scripts**: kontroll szkriptek.
- **templates**: sablon szkriptek HTML részekkel.
- **templates**/**fragments**: sablon darabkák.
- **guide.php**: alap PHP, ezzel indul a program.

# Ismert problémák

- A Határozó időnként nem létező madárfajokat próbál megjeleníteni.
- A madárfaj megtekintő oldalán a Carousel időnként összezsugorodik.
- A leírások néha nem túl részletesek. A fényképek néha homályosak.
- Megjelenítési problémák merülhetnek fel.
- Bizonyos keresések nem sikerülnek.
- A kód szervezését újra kell gondolni.

# Jövőbeli fejlesztések

- Lehet, hogy újra lesz gondolva a dizájn.
- A jövőben lehet, hogy nem fájl alapú, hanem adatbázis alapó lesz ez az alkalmazás.
- Több információ kerül fel, jobb minőségű - de még saját - képekkel.
- A webalkalmazáshoz hamarosan mobilalkalmazás is készül.
- A néhány hasonló, sikeres Madárhatározó kezdeményezés mellett/helyett némiképp egyedi projektté alakul át ez a webalkalmazás.

# Verziók

## 1.6.0.170627

Ebben a verzióban az a legfőbb újdonság, hogy újjá lett szervezve a könyvtárrendszer.

- A fajok és a hozzájuk tartozó alkönyvtárak a 'data/spe' könyvtárban vannak
- A rendek a 'data/ordo' könyvtárban vannak
- A segéd PHP új neve: guide_helper.php (régebben guide_fcnlib.php)