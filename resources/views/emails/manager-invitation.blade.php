@component('mail::message')
# Invitació

Aquest email és una invitació per convertir el teu usuari en gestor a l'aplicació de la LAn Party de l'Institut de l'Ebre.

@component('mail::button', ['url' => url("/manage/invitations/{$invitation->code}") ])
Gestionar la LAN PARTY
@endcomponent

Salutacions,<br>
{{ config('app.name') }}
@endcomponent
