# Gestió usuaris

- [ ] Mantenir usuaris altres anys

## Control de pagament

- [X] Pagar -> assignar ticket (de la llista de tickets disponibles)
  - [X] Afegir columna session a cada ticket (taula tickets)
    - [X] Permet indicar a quina sessió correspon el ticket
    - [X] String lliure -> nosaltres farem sessió per any -> 2018 2019
    - [X] Actualitzar a explotació els tickets diponibles a sessió 2018
    
Apartat /manage/participants:

     

# Gestió Events

- [X] Afegir suport SofDeletes
- [X] Mostrar a EventsManager tots els events (softdeleted i normals)
  - [X] Controlador i testos nous AllEvents
- [X] A la vista events per a usuaris (/home) només mostrar els events published i no deleted_at
- [X] Creades accions noves per archivar i activar (deleted_at) events
  - [X] Creats controladors i testos
  
## CREAR TICKETS PER ALS ESDEVIMENTS

- [ ] A Events Manager crear botó/acció afegir tickets  
  
## Afegir nou event

- [ ] TODO

## EDITAR EVENTS
- [ ] TODO   

# Landing Page

- [X] Link a la web facebook: https://www.facebook.com/LanPartyIesEbre/
- [ ] Cartell: posar a la Landing Page -> link fixe /cartell
- [ ] Programa: link al programa: /programa
- [ ] Preu de la inscripció? 3€
- [ ] Llista de premis
- [ ] Col·laboradors
- [X] Apartat de contacte
- [X] Apartat de com arribar: Google Maps

# Canvis a competicions:

- Competició per grups
Counter Strike - Global Offensive (grups de 3 components): Limitat a 25 grups
Overwatch (grups de 6 components): Limitat a 15 grups
League of Legends (grups de 5 components): Limitat a 25 grups
- Competició Individual
FIFA19: Limitat a 32 places

- [ ] Canviar la Landing Page el Age of empires per un FIFA 19

# Registre usuaris

- [X] Checkbox acceptar condicions
- [X] Link fixe a les normes/condicions:
  - [X] lanparty.iesebre.com/condicions
  - [X] env(URL)/condicions
  - [ ] Redireccionar la URL condicions a on pertoqui
- [X] Login -> recordar usuari


# Managers Management

- [ ] Mostrar la llista de Managers
- [ ] Enviar invitació a un manager

# Canvi periode acadèmic

Procediment inici nou periode Lanparty

- Dades generals:
  - Dies Lanparty
  - Data inici inscripció usuaris
  - Aturar inscripcions al final lanparty
- Canviar els events
 - Events antics (arxivar): archived_at: no mostrar els esdeveniments archived!
 - Events nous: CRUD
- Generador de tickets:
  - Per cada event possibilitat de regenerar tickets
- Assignació de números
  - Generador de números (indicar quantitat)
  - Crear uns quants números més  
- Gestionar managers:
 - Treure rol company altres anys
 - Invitar nous companys/managers 
 
# Menu navegació esquerra

- [X] Que siguin links els mòduls i no només responguin a clicks
- [X] Marcar el menú seleccionat/actiu amb un color diferent
- [X] NavigationDrawer moguda a un component a mida 

# Events Manager
- [X] Apartat Events Manager
  - [X] Test web i controlador més vista i component Vue
  - [ ] Crear test api TDD: /api/v1/events CRUD
    - [ ] Index (refresh)
    - [ ] Store normal
    - [ ] Store amb validació (comprovar el 422). Objecte request amb validation
    - [ ] Només managers (objecte request autorització 403 i 401)
    - [ ] Edit -> 
       - [ ] inline: En la mateixa taula
       - [ ] dialeg
    - [ ] Delete
    - [ ] Delete múltiple
    - [ ] Show
  - [ ] Component Vue
    - [ ] Component Principal (Events)
      - [ ] Separar en subcomponents: 1 màxim de 1 window.axios per component   
      - [ ] event-add: Botó Add (FAB)
      - [ ] event-list: datatables amb refresh
      - [ ] event-delete: amb confirm
      - [ ] event-edit
Camps:
  - 
    $table->increments('id');
              $table->string('name');
              $table->unsignedInteger('inscription_type_id');
              $table->string('image');
              $table->string('regulation'); // URL Validació
              $table->integer('participants_number')->nullable();
              $table->datetime('published_at')->nullable();
              $table->timestamps();  

# Users Manager

# Environment

- [X] Separar fitxer env en local del de explotació

# Bugs

- [ ] Error 500 (Server Error sense més dades) Pàgina de login
  - [ ] Crear regression test
  
# Crear branca de producció

- [ ] Crear la branca
- [ ] Utilitzar en producció

# Favicons i touchsicons 

- [ ] Copiar de scool
- [ ] Vendor extraction i defer a pàgina principal

# optimització errors amb snackbar i Axios interceptor

- [ ] Login porti a l'última pàgina logada

# Service worker offline

- [ ] Passar a workbox
- [ ] importar imatges amb webpack
- [ ] Que funcioni igualment offline el newsletter subscribe

# Actualitzar Laravel:

- [X] Versió de partida: Laravel Framework 5.6.19
 - [X] Upgrade de 5.6 a 5.7: https://laravel.com/docs/5.7/upgrade#upgrade-5.7.0
 - [X] https://laravel.com/docs/5.8/upgrade#upgrade-5.8.0
 - [X] npm update
 - [X] laravel mix to 4.0
 - [X] phpunit to 8.0
 
# Activar Email verification

- [ ] TODO
 
# Bugs

## Error tests

PHPUnit 6.5.8 by Sebastian Bergmann and contributors.

1) Tests\Feature\AcceptInvitationTest::viewing_an_unused_invitation
Error: Class 'Dotenv\Environment\DotenvFactory' not found

Funciona correctament executant:
./vendor/bin/phpunit
