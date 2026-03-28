<h1>Avviso Scadenze Edil2</h1>
<p>I seguenti veicoli sono in scadenza:</p>
<ul>
    @foreach($vehicles as $vehicle)
        <li>{{ $vehicle->plate_number }} - Scadenza: {{ $vehicle->insurance_expiry->format('d/m/Y') }}</li>
    @endforeach
</ul>