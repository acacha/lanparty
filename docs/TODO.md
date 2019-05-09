# PARTICIPANTS

- [ ] No es mostren correctament la llista esdeveniments a les que s'ha apuntat un usuari en anys anteriors 

# CONTROL PAGAMENT

- [ ] Mostrar totes les competicions a les que està inscrit
 - [ ] Treure alert
 - [ ] A les competicions de grup no hi ha operacions només lectura 
- [ ] Mostrar el total a pagar per l'usuari al costat del checkbox pagar
- [ ] Un cop un usuari ha pagat no es pot inscriure a més competicions?
  - [ ] hauria de passar per recepció pagar competicions extres, se li marca com no pagat i es pot apuntar?
  - [ ] De fet hi ha algun límit per competicions
  - [ ] Mostrar una llista usuaris incoherents -> no quadra el que han pagat amb el que estan apuntats 

# SORTEIG

- [ ] En explotació els winners no s'actualizen sino fem un F5
- [ ] El nom usuari es massa grana a la llista de winners i surt una mica tallat per sota
- [ ] Utilitzar ellipsis i si cal vue-tooltip per mostrar noms de regals que no caben a la llista
- [ ] Impedir es pugui sortejar regals 2018 amb middleware

# PREMIS

- [ ] camp user_id passar a relació polimorfica? -> Un regal pot ser assignat a un usuari però també a un grup persones
- [ ] Al assignar un premi s'assigna u número al premi i a partir d'aquí s'agafa el usuari -> Cal user_id?
- [ ] Crec que es pot pensar millor la solució ara relació persones/grups/premis no em barrufa

# EVENTS

- [ ] Afegir preu de l'esdeveniment -> Ara totes les competicions 1€

# BUGS

- [X] el link de canviar paraula de pas des de email porta a la home si l'usuari ja està registrat
  - [X] Es mostra formulari ok si l'usuari esta log off: tret middleware guest
  - [X] Diu que falta el email (error 422) quan el email està ja posat

# PETITS DETALLS

- [X] modificar/esborrar d'usauris a l'apartat participants no fa res
  - [X] no està fet -> comentar botons per que no apareguin 
- [ ] Al apuntar-se a un event de grup el switch es queda marcat si no acabes el registre (tancas). Només problema forntend al fer f5 està tot ok. 

# SESSIONS

- [X] Apartat de generació de sessions
  - [X] No cal creat taula sessions, simplement un fitxer config.
  - [X] Passar a javascript info de config
- [X] Desplegable de sessions a participants agafi les sessions de config
- [X] Crear middleware per protegir certes operacions relacionades amb la sessió:
  - [X] Impedeixi executar canvis en sessions archivades (anys anteriors)   

# ERRORS

- [X] 404 Al registrar un grup amb usuaris: URL:  https://lanparty.test/api/v1/events/3/register_group
  - [X] Arreglat tipic select no retornar object 
  
# Gestió usuaris

- [X] Mantenir usuaris altres anys

## Control de pagament

- [X] Pagar -> assignar ticket (de la llista de tickets disponibles)
  - [X] Afegir columna session a cada ticket (taula tickets)
    - [X] Permet indicar a quina sessió correspon el ticket
    - [X] String lliure -> nosaltres farem sessió per any -> 2018 2019
    - [X] Actualitzar a explotació els tickets diponibles a sessió 2018
    
Apartat /manage/participants:

- [X] Afegir un desplegable que mostri les diferents sessions de tickets
- [X] Es pot no marcar cap sessió aleshores es mostren dades de totes les sessions
  - [X] Un cop escollida sessió mostrar només usuaris han pagat aquella sessió
- [X] Permetre als managers afegir i eliminar tickets per sessió    
    
## Control de números de sorteig

- [X] Assignar número -> assignar usuari a un numero disponible (de la llista de numeros disponibles taula numbers)
  - [X] Afegir columna session a cada numero (taula numbers)
    - [X] Permet indicar a quina sessió correspon el numero
    - [X] String lliure -> nosaltres farem sessió per any -> 2018 2019
    - [X] Actualitzar a explotació els numbers diponibles a sessió 2018   

- [X] Mostrar els números per sessió
  - [X] A la vista participants es mostren tots els números assignats, mostrar només sessió actual
    -  [X] POder consultar números assignats anys anteriors
  - [X] assignació i eliminació de números tingui en compte la sessió actual
  - [X] La llista d'esdeveniments als quals l'usuari s'ha inscrit:
    - [X] Mostrar només events actius

# Gestió Events

- [X] Afegir suport SofDeletes
- [X] Mostrar a EventsManager tots els events (softdeleted i normals)
  - [X] Controlador i testos nous AllEvents
- [X] A la vista events per a usuaris (/home) només mostrar els events published i no deleted_at
- [X] Creades accions noves per archivar i activar (deleted_at) events
  - [X] Creats controladors i testos
  
## CREAR TICKETS PER ALS ESDEVIMENTS

- [X] A Events Manager crear botó/acció afegir tickets  
- [X] El mateix perls números
  
## Afegir nou event

- [ ] TODO -> alumnes crèdit sintesi

## EDITAR EVENTS
- [ ] TODO   

# Landing Page

- [X] Link a la web facebook: https://www.facebook.com/LanPartyIesEbre/
- [ ] Cartell: posar a la Landing Page -> link fixe /cartell
- [X] Programa: link al programa: /programa
- [X] Preu de la inscripció? 3€
- [ ] Preus de les competicions
- [X] Llista de premis
- [X] Col·laboradors
- [X] Apartat de contacte
- [X] Apartat de com arribar: Google Maps

# Canvis a competicions:

- Competició per grups
Counter Strike - Global Offensive (grups de 3 components): Limitat a 25 grups
Overwatch (grups de 6 components): Limitat a 15 grups
League of Legends (grups de 5 components): Limitat a 25 grups
- Competició Individual
FIFA19: Limitat a 32 places

- [X] Canviar la Landing Page el Age of empires per un FIFA 19

# Registre usuaris

- [X] Checkbox acceptar condicions
- [X] Link fixe a les normes/condicions:
  - [X] lanparty.iesebre.com/condicions
  - [X] env(URL)/condicions
  - [ ] Redireccionar la URL condicions a on pertoqui
- [X] Login -> recordar usuari


# Managers Management

- [X] Mostrar la llista de Managers
- [X] Enviar invitació a un manager

# Canvi periode acadèmic

- [ ] Fitxer de config és configuren les sessions i la sessió actual

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

- [X] Error 500 (Server Error sense més dades) Pàgina de login
  - [X] Crear regression test
  
# Crear branca de producció

- [X] Crear la branca
- [X] Utilitzar en producció

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
