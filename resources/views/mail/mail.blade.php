<div><h4>Hallo {{$name}},</h4>
    <p>vielen Dank für die Teilnahme am Fahrradkino auf dem Hochschulinformationstag
        <br>der Westfälischen Hochschule Gelsenkirchen am 20.01.2017.</p>
    <p>Deine Statistik:<br></p>
    <ul>
        <li>Modus: {{$modus}}</li>
        <li>Durchschnittsgeschwindigkeit: {{$geschwindigkeit}}km/h</li>
        <li>Gesamtleistung: {{$gesamtleistung}} Watt</li>
        <li>Zurückgelegte Kilometer: {{$kilometer}}km</li>
        <li>Fahrdauer: {{$fahrdauer}}</li>
    </ul>
    <p>Mit freundlichen Grüßen<br></p>
    <p>Das Fahrradkino-Team<br></p>
    <p>Westfälische Hochschule<br>Gelsenkirchen Bocholt Recklinghausen<br>Neidenburger Str. 43<br>45897 Gelsenkirchen
    </p>
    <div id="app">
        <div class="header">
            <nav class="container-fluid">
                <div class="logo">
                    <img src="{{URL::asset('/img/whs_logo.png')}}" alt="Logo" class="pull-right">
                </div>
                <div class="softwaretitel-wrapper">
                    <a class="softwaretitel" href="{{ url('/') }}">
                        <span>SPIN WiSe 16/17 Fahrradergometer</span>
                    </a>
                </div>
            </nav>
        </div>
    </div>
</div>