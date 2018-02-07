<h1>User info:</h1>
<ul>
    <li>{{ $user->name }}</li>
    <li>{{ $user->email }}</li>
    <li>{{ $user->givenName }}</li>
    <li>{{ $user->sn1 }}</li>
    <li>{{ $user->sn2 }}</li>
    <li>{{ $user->identifier }}</li>
    <li>{{ $user->formatted_created_at_date }}</li>
</ul>

<h2>Events</h2>

<ul>
    @foreach($events as $event)
    <li> {{ $event->name }}</li>
    @endforeach
</ul>

<h2>Numbers</h2>

<ul>
    @foreach($user->numbers as $number)
        <li> {{ $number->value }} | {{ $number->type }}</li>
    @endforeach
</ul>
