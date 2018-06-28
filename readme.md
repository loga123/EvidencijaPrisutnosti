<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## O projektu

Aplikacija je napravljena u sklopu specijalističkog završnog rada iz kolegija "Izgradnja objektno orijentiranih aplikacija". Aplikacija je namjenjena za evidentiranje studentske prisutnosti na nastavi. Za diplomski su napravljene dvije aplikacije (desktop i web) koje komuniciraju s istom bazom podataka (relacjskom bazom podataka). 

Web aplikacija za razliku od desktop aplikacije nema mogućnost automatske evidencije studenata preko čitača kartica. Evidencija studenata vrši se ručno na način da se odaberu studenti koji su prisutni na predavanju, te se evidentira njihovo prisustvo. Evidentiranje studenata za zadani termin može se mijenjati, što znači da profesor može evidentirati dodatno studente za taj termin za razliku od desktop aplikacije gdje se studenti ne mogu dodavati ručno. Web aplikacija u odnosu na desktop aplikaciju ima više operacija. Administrator ima ovlasti za registraciju novih korisnika (studenata, profesora, administratora), može povezivati studente i profesore s kolegijima, pregledavat studente po kolegijima, te pregledavat kolegije po profesorima. Administrator unosi nove studije fakulteta, uređuje ih, te ih briše. Također iste operacije može raditi i za godine studija, kolegije, razine pristupa. Što se tiče evidencije studenata, administrator može unositi termine za kolegije, pregledavat studente po terminu, dodatno bilježiti studente na termin nastave, brisati studente s termina, te pregledava ukupnu prisutnost studenata po kolegiju.
Profesor u web aplikaciji ima drugačije ovlasti od administratora. Profesor može registrirat studenta u sustav. Nadalje može pregledavati studente po svojim kolegijima, može unositi studente na svoje kolegije, pregledavati podatke studenata, te brisati studente s kolegija. Za svoje kolegije može unositi termine nastave, bilježiti studente na termin nastave, brisati studente s termina, pregledavati studente po terminu i pregledavati ukupnu prisutnost studenata po kolegiju.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
