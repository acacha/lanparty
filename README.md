# Features

Principal
- Registrar-se
- Pàgina usuari normal (Participant) inicial:
  - Llista de events las que esta apuntat
  - Llista de números que té assignats

- Landing Page
  - http://attendize.website/e/1/acmes-amazing-demo-event
  - Icona/Logo
  - CTA: registrar-se i compartir xarxes socials
  - Descripció/competicions
  - Google maps del lloc
- Login (With social Login: Facebook)
- Registre:també amb social
- Dades extra:
  - DNI
  - Nom i Cognoms
  - nickname?

Interfície material amb Vuetify

URL: play.lanparty.iesebre.com

Administradors
- Buscar usuari: autocompletar er nom i codi al mateix desplegable autocompletar
- Accions sobre un usuari:
  - Cobrar: estat cobrat
  - Assignar numero

Manteniment
- CRUD de competicions/events (no cal sempre són mateixes o similars: seed / helper /línia de comandes)
  - Nom
  - Descripció: opcional
  
Base de dades

event
- id
- name
- description

registration
- Taula polimorfica
- event_id
- registable_id
- registable_type: usuari directe o grup

numbers (números de sorteig)
- id 
- user_id
- num
- type_number_id

type_numbers
  
Groups
- id
- name
- user_id

Premis
Sembla no s'utilitza  

Participants
- Rol per defecte
- Pàgina inicial:
 - Mostrar llista de competicions: estat inscrit/no inscrit
  - Inscriure's a una competició
   - Competicions en grup:
     - Només el lider del grup fa la inscripció
     - Primer crear grup: posar nom
     - Convidar persones al grup: enviament de email per confirmar? TODO
     - Apuntar grup
   - Competicions individuals
 - Mostrar llista de números assignats  
 - Codi QR cal? millor un número de ticket? Amb codi de barres?
 
Interfície general:
- Links
 - Veure pàgina antiga
 
# Inscripció
- 