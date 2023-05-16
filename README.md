# Woordspel

Het hoofddoel van de casus is het kunnen ontwikkelen van een dynamische website met behulp van het Laravel framework. Laravel is een populair framework en maakt gebruik van codeer principes (MVC) wat je erg vaak gebruikt wordt binnen bedrijven.

# Om het project goed te starten beide in terminal typen.

php artisan serve & npm run dev

# Eisen van de casus

Onderstaand vind je de eisen die verwerkt moeten worden bij het uitwerken van het Laravel project.

Landing Page De bezoeker van de website komt bij het laden van de website uit op de landing page. Het is de bedoeling dat de landing page de bezoeker een duidelijk beeld geeft wat er gespeeld kan worden op de website. Op de landingspage is ook een overzicht te vinden met een leaderboard. Hier staat wie deze dag, deze week en aller tijde het meest gewonnen potjes heeft.

[Voldaan] Gebruikers Op de website moet het mogelijk zijn om als gebruiker jezelf te kunnen registreren en te kunnen inloggen.

Spel spelen Het spel dient turn-based gespeeld te worden. Het systeem kiest een willekeurig woord en start het spel. Speler 1 mag eerst een woord raden. Als het woord niet geraden is, mag speler 2. Speler 2 ziet vervolgens welk woord geraden is door de tegenstander en mag dan zelf aan de slag. Iedere speler mag 4 keer raden en als het woord niet geraden is, dan is het spel voorbij en is het gelijkspel. Als het woord wel geraden is door een speler, dan heeft deze speler gewonnen.

[Meebezig] Vrienden toevoegen Spelers moeten elkaar kunnen toevoegen als vriend. Je kan op username of email elkaar uitnodigen. Een andere speler kan deze uitnodiging accepteren of weigeren. Ik wil als speler die iemand uitnodigt als vriend, de laatste status kunnen zien.

Een spel kan je starten door te kiezen voor willekeurige tegenstander of door te kiezen tegen welke vriend je dit wilt spelen. Als je kiest voor willekeurige tegenstander, dan speel je tegen een willekeurige speler die in het systeem voorkomt. Dit moet een speler zijn met de minst “open” games. Als je kiest voor een vriend, dan wordt het spel uiteraard gespeeld tegen een vriend. Het spel kan pas starten als de andere speler de speluitnodiging accepteert.
