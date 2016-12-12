<div class ="container-fluid">
    @foreach($fahrraeder as $fahrrad)
        <div class="panel panel-default pull-left fahrrad-information-panel ">
            <div class="panel-heading header-f{{ $fahrrad->id }}">
                <h3 class="panel-title panel-title-zd">Fahrrad #{{ $fahrrad->id }}</h3>
            </div>
            <div class="panel-body panel-body-zd body-f{{ $fahrrad->id}}">
                <div id="fahrrad-inaktiv-wrapper-{{ $fahrrad->id}}" style="display: none;">
                    <div class="row">
                        <div class="col-lg-12 fahrerinformation">Fahrrad ist inaktiv</div>
                    </div>
                </div>

                <div id="fahrrad-aktiv-wrapper-{{ $fahrrad->id}}" style="display: none;">
                    <div class="row">
                        <div class="col-lg-6 fahrerinformation">Fahrer:</div>
                        <div id="fahrername-anzeige-{{ $fahrrad->id }}" class="col-lg-6 fahrerinformation"></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 fahrerinformation ">Geschwindigkeit:</div>
                        <div id="geschwindigkeit-anzeige-{{ $fahrrad->id }}" class="col-lg-6 fahrerinformation"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 fahrerinformation">Gesamtleistung:</div>
                        <div id="gesamtleistung-anzeige-{{ $fahrrad->id }}" class="col-lg-6 fahrerinformation"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 fahrerinformation">Zurückgelegte Kilometer:</div>
                        <div id="strecke-anzeige-{{ $fahrrad->id }}" class="col-lg-6 fahrerinformation"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 fahrerinformation">Fahrdauer:</div>
                        <div id="fahrdauer-anzeige-{{ $fahrrad->id }}" class="col-lg-6 fahrerinformation"></div>
                    </div>
                </div>

            </div>
        </div>

    @endforeach
    <div class="clear"></div>
</div>