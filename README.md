# BirdGuide1

Webes madár határozó alkalmazás, melyben hazai madárfajokat lehet keresni.

2011-ben indult el ez a projekt. Natív PHP alapokon nyugszik, fájlokban vannak tárolva az adatok.

A fajok .spe, a magyar fordítások a hu.dic fájlba vannak téve. Név=érték formátumban találhatók mindezek.

## 1.6.0 verzió

Ebben a verzióban az a legfőbb újdonság, hogy újjá lett szervezve a könyvtárrendszer.

- A fajok és a hozzájuk tartozó alkönyvtárak a 'spe' könyvtárban vannak
- A rendek az 'ordo' könyvtárban vannak
- A segéd PHP új neve: guide_helper.php (régebben guide_fcnlib.php)