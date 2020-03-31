# Pas 1:

- Comprovar esta actual aplicació:
- Testos automàtics (haurien de ser tot verds -> comprovat ok en local meu PC - Sergi Tur)
- Laravel valet per provar domini local: http://lanparty.test/
- Aconseguir copia fitxer .env . En local utilitzo sqlite
- Testos manuals:
  - Login i registre

# Altres petis canvis:
 - Landing page contibuidors

# Tasques a realitzar

- Petits canvis cruds pendents
- Actualitzar versió Laravel
- Actualitzar versió Vuetify

## BACKUP

Creem un tag: ha de permetre tornar endarrera en cas urgència

## Laravel Upgrade

- Versió actual: 5.8
- php artisan --version: Laravel Framework 5.8.5

Tres fases:
- Actualitzar paquet javascript: npm update
- Actualitzar paquets PHP: composer update
- Actualitzar a Laravel 6: https://laravel.com/docs/6.x/upgrade
- Actualitzar a Laravel 7: https://laravel.com/docs/7.x/upgrade

Ajuda de testos: ./vendor/bin/phpunit
Cal executar els testos després upgrades per detectar possibles errors

### Laravel paquets de tercers

- Laravel passport caldrà actualitzar (crec només quan passem a versió Laravel 7)
- Laravel permissions:
  - Truc per previndre possibles errors: buscar a Github issues per paraula clau Laravel 7
- Laravel newsletter (no és crític)
- composer outdated: mostra paquets tenen versions noves
- No tot es pot actualitza, sobretot dependències que no són directes

## PAQUETS ACACHA:

- Tots els acacha/* són obsolets: mirar que cal fer per treure

Paquets:
 "acacha/forge-publish": "^0.1.12",
 "acacha/laravel-social": "^0.2",
 "acacha/user": "^0.2.2",

## Javascript upgrade

### Vue

- Només cal npm update. Ja estem versió 2 i de moment no hi ha versió 3 estable

### Vuetify
- Cal passar a versió 2.0.
 - https://vuetifyjs.com/en/getting-started/releases-and-migrations/
 - Cal aplicar "Migrating from v1.5.x to v2.0.x"
- Aquí no hi ha testos serà més faena comprovar que tot va bé
- Cal visitar totes les pàgines i funcionalitat i tornar-les a comprovar
- Observant la consola apareixen warning i avisos que mirant ajudar a la migració

Fases:
- npm update


