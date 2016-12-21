<div id="hilfeTabelle" title="Hilfe">
    <h3><b>Fahrertabelle</b></h3><hr/>
    <p>In dieser Tabelle werden alle bereits registrierten Fahrer angezeigt.<br>In den Spalten sind folgende
    Funktionen oder Daten dargestellt:</p>
    <ol>
        <li><u>Button zum Markieren der jeweiligen Tabellenzeile mit den Fahrerdaten:</u> Anschließend
        kann der Fahrer einem Fahrrad zugeordnet werden.</li>
        <li><u>Name:</u> Name des jeweiligen Fahrers</li>
        <li><u>Email:</u> Email-Adresse des jeweiligen Fahrers</li>
        <li><u>Gewicht:</u> Gewicht des jeweiligen Fahrers</li>
        <li><u>Größe:</u> Größe des jeweiligen Fahrers</li>
        <li><u>Betriebsmodus:</u> Hier ist der gewünschte Betriebsmodus des Fahrers eingetragen. Dieser kann
            über die Dropdown-Liste geändert werden und wird bei der Zuordnung automatisch übernommen.</li>
        <li><u>Button zur Löschung des gesamten Fahrerdatensatzes:</u> Dieser wird somit aus der Datenbank entfernt
        und kann auch nicht wiederhergestellt werden.</li>
    </ol>
    <p>Um die Spalten 2, 3 und 4 zu bearbeiten muss ****.<br><p>

    <p>Mithilfe des Buttons "Fahrer hinzufügen" kann ein neuer Datensatz erstellt werden.<br></p>

    Mit der Suchfunktion kann nach dem Datensatz eines bestimmten Fahrers gesucht werden. Dazu muss lediglich
    der Name des gesuchten Fahrers in das Suchfeld eingegeben werden.</p>
</div>

<div id="hilfeInaktiv" title="Hilfe">
    <h3><b>Fahrrad ist inaktiv</b></h3><hr/>
    <p>Dieses Fahrrad wird aktuell nicht benutzt und ist somit inaktiv.<br>Es gibt zwei
        verschiedene Möglichkeiten ihm einen Fahrer zuzuordnen:</p>
    <ol>
        <li><b><u>Wenn der Fahrer bereits in der Fahrertabelle (rechts) eingetragen ist:
                </u></b><br>Zunächst muss der Fahrer in der Tabelle über den
                Button in der ersten Spalte markiert werden. Daraufhin muss der Button "Zuordnung hinzufügen"
                geklickt werden.</li>
        <li><b><u>Wenn der Fahrer noch nicht in der Fahrertabelle (rechts) eingetragen ist:
                </u></b><br>Mit dem Button "Fahrer hinzufügen" kann ein neuer Fahrer
                erstellt werden, der auch direkt einem Fahrrad zugeordnet werden kann.</li>
    </ol>
    <p>Nach dem Zuordnen wird das Fahrrad als aktiv gekennzeichnet, indem die Fahrerinformationen
        angezeigt werden.</p>
</div>

<div id="hilfeAktiv" title="Hilfe">
    <h3><b>Fahrrad ist aktiv</b></h3><hr/>
    <p>Diesem Fahrrad ist ein Fahrer zugeordnet und es wird somit aktiv benutzt.<br>Es werden
        folgende Daten angezeigt:</p>
    <ul>
        <li><b><u>Fahrer:</u></b> Der Name des Fahrers</li>
        <li><b><u>Geschwindigkeit:</u></b> Die aktuelle Geschwindigkeit in Kilometern pro Stunde</li>
        <li><b><u>Gesamtleistung:</u></b> Die Leistung, die der Fahrer ingesamt erzeugt hat, in Kilowatt pro Stunde</li>
        <li><b><u>Zurückgelegte Strecke:</u></b> Die gefahrene Strecke in Kilometern</li>
        <li><b><u>Fahrdauer:</u></b> Die Zeit, die der Fahrer bereits fährt, in Minuten</li>
        <li><b><u>Betriebsmodus:</u></b> Es stehen drei verschiedene Betriebsmodi zur Auswahl,
            die über die Dropdown-Liste eingestellt werden können:
            <ol>
                <li><b>Streckenmodus:</b> In diesem Modus fährt der Fahrer eine virtuelle Strecke ab. Die Strecke ist
                in Abschnitte gegliedert. Jeder Abschnitt hat eine andere Steigung. So hat der Fahrer das Gefühl, dass
                er mal bergauf und mal bergab fährt. Um es möglichst realistisch wirken zu lassen, wird anhand der Größe
                und des Gewichtes des Fahreres noch zusätzlich der Windwiderstand berechnet.</li>
                <li><b>Konstante Leistung:</b> In diesem Betriebsmodus erbringt der Fahrer eine konstante Leistung. Um
                dies zu Erreichen wird die Gegenkraft automatisch geregelt.<br>Tritt der Fahrer langsam, ist die
                Gegenkraft entsprechend hoch und das Treten fällt dem Fahrer schwer.<br>Tritt der Fahrer hingegen schnell
                , dann ist die Gegenkraft geringer und das Treten somit leichter.</li>
                <li><b>Konstantes Drehmoment:</b> In diesem Betriebsmodus ist die Gegenkraft immer gleich. Je nachdem
                wie schnell der Fahrer tritt, erzeugt er eine höhere oder niedrigere Leistung. Das Treten fällt ihm
                jedoch immer gleich schwer bzw. leicht. </li>
            </ol>
        </li>
    </ul>
    <p>Über den Button "Zuordnung löschen" wird die Zuordnung vom Fahrer zum Fahrrad gelöscht und dieses wird
        als inaktiv gekennzeichnet.</p>
</div>