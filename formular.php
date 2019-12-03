<!DOCTYPE html>
<html lang="de">

<head>
  <title>Kontaktformular</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Einbinden von JavaScript, CSS Dateien und CSS Frameworks. Der Einfachheit halber sind die Frameworks über ein cdn eingebunden.  -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>

  <?php
  session_start();
  // Einbinden der Datei fst71/mysql_connect.php welche die Zugangsdaten für die Datenbank inkl. prüfung ob die Datei vorhanden ist
  // Ansonsten erhält der Besucher eine simple Fehlermeldung im Browser
  $mysql_connect_file = 'mysql_connect.php';
  if (!file_exists($mysql_connect_file)) {
    echo "Wegen einem technischen Problem steht das Kontaktformular leider aktuell nicht zur Verfügung. Wir bitten um Verständnis. ";
    echo "<br>Bei dringenden Fragen wenden Sie sich bitte an info@domain.com";
  }
  require_once $mysql_connect_file;
  include 'dbinsert.php';

  // SQL Abfrage für die Auswahl der Anrede
  $db_anrede = mysqli_query($link, "SELECT anrede FROM anrede");

  // SQL Abfrage für die möglichen Termine
  $db_termine = mysqli_query($link, "SELECT id, datum, wochentag FROM termine");

  // Verbindung zur Datenbank schließen
  mysqli_close($link);
  ?>

  <!-- ########################### -->
  <!-- START NAVBAR als Menüleiste -->
  <!-- ########################### -->
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">Menuleiste</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="formular.php">Kontaktformular</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="datenbankinhalt.php">Datenbankinhalt</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- ########################### -->
  <!-- ENDE NAVBAR als Menüleiste  -->
  <!-- ########################### -->
  <br>

  <!-- ##################### -->
  <!-- START DES FORMULARES  -->
  <!-- ##################### -->
  <div class="container">
    <!-- Bei "novalidate" wird die Validation durch ein seperates Java Script übernommen -->
    <!-- htmlspecialchars verhindert Cross-site scripting bei PHP_SELF -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="contactForm" name="contactForm" class="needs-validation" novalidate>
      <div class="box_white">

        <!-- ############ -->
        <!-- KONTAKTDATEN -->
        <!-- ############ -->
        <h4><span class="number">1</span> Kontaktdaten</h4>
      </div>
      <div class="box_gray">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="firmenname">Name der Firma, Hochschule oder Organisation <span class="required">*</span> </label>
            <input type="text" class="form-control" id="firmenname" placeholder="Firmenname GmbH" name="firmenname" minlength="3" maxlength="100" required>
            <div class="invalid-feedback">
              Bitte Firmennamen angeben.
            </div>
          </div>
          <div class="form-group col-md-2">
            <label for="anrede">Anrede <span class="required">*</span> </label>
            <select id="anrede" class="custom-select" name="anrede" required>
              <?php
              // Einzelner <option> Wert außerhalb der Schleife der keinen valaue besitzt.
              // Dieser ist notwendig da das Feld den tag required besitzt. Ohne eine option mit value="" würde der Browser den Menüpunkt bereits als ausgewählt markieren
              echo "<option value=\"\" selected>Bitte wählen</option>";
              while (list($anrede) = mysqli_fetch_array($db_anrede)) {
                echo "<option value=\"$anrede\">$anrede</option>";
              }
              ?>
            </select>
            <div class="invalid-feedback">
              Bitte Anrede auswählen.
            </div>
          </div>
          <div class="form-group col-md-4">
            <label for="ansprechpartner">Ansprechpartner <span class="required">*</span></label>
            <!-- /D als Pattern steht für alle nicht Zahlen. Dies ist eine einfach alternative um alle speziellen Buchstaben (Umlaute, ß, á, etc) zuzulassne -->
            <input type="text" class="form-control" id="ansprechpartner" pattern="^\D{3,60}" placeholder="Max Mustermann" name="ansprechpartner" required>
            <div class="invalid-feedback">
              Gültiger Name benötigt.
            </div>
          </div>
          <div class="form-group col-md-6">
            <label for="telnr">Telefonnummer <span class="required">*</span> </label>
            <!-- Einfaches Pattern um Rufnummer, inkl. Zeichen wie (),-,+ zu matchen -->
            <input type="text" class="form-control" id="telnr" name="telnr" pattern="^[-+()0-9\s]{6,20}" maxlength="20" placeholder="0203 555 1234" required>
            <div class="invalid-feedback">
              Gültige Rufnummer benötigt.
            </div>
          </div>
          <div class="form-group col-md-6">
            <label for="email">E-Mail <span class="required">*</span> </label>
            <!-- Einfaches Pattern um auf E-Mail Adressen zu matchen. In entsprechenden RFCs ist der genaue erlaube Aufbau von E-Mail Adressen beschrieben, allerdings wäre
            ein Regex Pattern dafür zu fehleranfällig und ungenau, zudem können TLDs auch erweitert werden -->
            <input type="text" class="form-control" id="email" name="email" pattern="^.*@.*\.{1}.{2,}$" placeholder="name@domain.org" maxlength="80" required>
            <div class="invalid-feedback">
              Gültige E-Mail Adresse benötigt.
            </div>
          </div>
          <div class="form-group col-md-6">
            <label for="bereich">Bereich <span class="required">*</span> </label>
            <select id="bereich" class="custom-select" name="bereich" id="bereich" required>
              <option value="" selected>Bitte wählen</option>
              <option value="Ausbildungsbetrieb">Ausbildungsbetrieb</option>
              <option value="Hochschule">Hochschule</option>
              <option value="Sonstige">Sonstiges</option>
            </select>
            <div class="invalid-feedback">
              Bitte passenden Bereich auswählen.
            </div>
          </div>
          <div class="form-group col-md-6" id="bereichSonstigesDiv">
            <label for="bereichSonstiges"> Sonstiges bitte angeben: <span class="required">*</span> </label>
            <input type="text" class="form-control" id="bereichSonstiges" name="bereichSonstiges" placeholder="z.B. Verein, Organisation, Behörde etc." maxlength="45">
            <div class="invalid-feedback">
              Pflichtfeld, bitte korrekt ausfüllen.
            </div>
          </div>
        </div>
      </div>
      <br>

      <!-- ######### -->
      <!-- INFOSTAND -->
      <!-- ######### -->
      <div class="box_white">
        <h4><span class="number">2</span> Infostand</h4>
      </div>
      <div class="box_gray">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="teilnahmeDatum"><br>Teilnahme am <span class="required">*</span></label>
            <select id="teilnahmeDatum" class="custom-select" name="teilnahmeDatum" id="teilnahmeDatum" required>
              <?php
              echo "<option value=\"\" selected>Bitte wählen</option>";
              while (list($id, $datum, $wochentag) = mysqli_fetch_array($db_termine)) {
                // if Abfrage für besondere darstellung wennd er Benutzer an beiden Tagen kommen möchte (kein Date in DB!)
                if ($datum == null) {
                  echo "<option value=\"beide Tage\">$wochentag</option>";
                } else {
                  // Datumsformnat aus der DB nach DE umwandelnm nur für die Anzeige im Formular, value bleibt das DB Format
                  $db_date = DateTime::createFromFormat('Y-m-d', $datum);
                  $de_date = $db_date->format('d.m.Y');
                  echo "<option value=\"$id\">$de_date - $wochentag</option>";
                }
              }
              ?>
            </select>
            <div class="invalid-feedback">
              Datum der Teilnahme auswählen.
            </div>
          </div>
          <div class="form-group col-md-4">
            <label for="tische"><br>Anzahl benötigter Tische <span class="required">*</span></label>
            <input type="number" class="form-control" id="tische" name="tische" value="0" min="0" max="2" required>
            <div class="invalid-feedback">
              Zulässiger Wert ist nur 0 bis 4.
            </div>
          </div>
          <div class="form-group col-md-4">
            <label for="stuehle"><br>Anzahl benötigter Stühle <span class="required">*</span></label>
            <input type="number" class="form-control" id="stuehle" name="stuehle" value="0" min="0" max="4" required>
            <div class="invalid-feedback">
              Zulässiger Wert ist nur 0 bis 4.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="anmerkung">Anmerkungen </label><small> (Optional)</small>
          <textarea class="form-control" id="anmerkung" name="anmerkung" rows="3" maxlength="200" Placeholder="Maximal Platz für 200 zusätzliche Zeichen..."></textarea>
        </div>
      </div>
      <div class="box_white">
        <h4><br><span class="number">3</span> Vortrag</h4>
      </div>
      <div class="box_gray">
        <div class="form-row">
          <div class="form-group col-md-2">
            <label for="vortrag">Vortrag halten <span class="required">*</span> </label>
            <select id="vortrag" class="custom-select" name="vortrag" required>
              <option value="" selected>Bitte wählen</option>
              <option value=0>Nein</option>
              <option value=1>Ja</option>
            </select>
            <div class="invalid-feedback">
              Auswahl benötigt.
            </div>
          </div>
          <div class="form-group col-md-2" id="inputTalkDateDiv">
            <label for="vortragDatum">Vortrag am: <span class="required">*</span></label>
            <select id="vortragDatum" class="custom-select" id="vortragDatum" name="vortragDatum">
              <option selected value=""> Bitte wählen...</option>
              <option value=2019-11-23>Freitag (23.11)</option>
              <option value=2019-11-24>Samstag (24.11)</option>
            </select>
            <div class="invalid-feedback">
              Bitte Datum auswählen.
            </div>
          </div>
          <div class="form-group col-md-4" id="inputTalkTopicDiv">
            <label for="vortragThema">Thema des Vortrags <span class="required">*</span> </label>
            <input type="text" class="form-control" id="vortragThema" name="vortragThema" placeholder="z.B. Arbeiten in Industrie 4.0" minlength="4" maxlength="50">
            <div class="invalid-feedback">
              Bitte ein Thema angeben.
            </div>
          </div>
          <div class="form-group col-md-4" id="inputTalkTimeDiv">
            <label for="vortragDauer">Dauer des Vortrages <span class="required">*</span></label>
            <select id="vortragDauer" class="custom-select" name="vortragDauer">
              <option selected value="">Bitte wählen...</option>
              <option value=10>10 Minuten</option>
              <option value=15>15 Minuten</option>
              <option value=20>20 Minuten</option>
              <option value=30>30 Minuten</option>
              <option value=45>45 Minuten</option>
              <option value=60>60 Minuten</option>
            </select>
            <div class="invalid-feedback">
              Bitte die Dauer wählen.
            </div>
          </div>
        </div>
      </div>
      <div>

        <!-- ########### -->
        <!-- DATENSCHUTZ -->
        <!-- ########### -->
        <div class="box_white">
          <h4><br>Datenschutz</h4>
        </div>
        <div class="box_yellow">
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
              <label class="form-check-label" for="invalidCheck2">
                Ich akzeptiete die DSGVO konforme speicherung meiner persönlichen Daten. Mehr Informationen zur
                Datenschutzbestimmung finden Sie <a href="https://www.google.de">hier</a>.
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="true" id="emailKopie" name="emailKopie">
              <label class="form-check-label" for="emailKopie">
                Ich möchte eine Kopie der Formulardaten an meine angegebene E-Mail Adresse erhalten.
              </label>
            </div>
          </div>
        </div>
      </div>
      <br>
      <button type="reset" class="btn btn-light">Zurücksetzten</button>
      <button type="submit" class="btn btn-success" value="submit" name="submit"><b>Senden</b></button>
      <br>
      <br>
    </form>
    <!-- ##################### -->
    <!-- ENDE DES FORMULARES  -->
    <!-- ##################### -->

    
    <!-- ################ -->
    <!-- START JAVASCRIPT -->
    <!-- ################ -->

    <!-- Plain JavaScript um bestimmte Elemente (z.B.: Vortrag) auszublenden  -->
    <script>
      $("#vortrag").change(function() {
        // Füge das Attribut required hinzu oder entferne es wieder
        if ($(this).val() == "1") {
          $('#inputTalkDateDiv').show();
          $('#vortragDatum').attr('required', '');
          $('#inputTalkTopicDiv').show();
          $('#vortragThema').attr('required', '');
          $('#inputTalkTimeDiv').show();
          $('#vortragDauer').attr('required', '');
        } else {
          $('#inputTalkDateDiv').hide();
          $('#vortragDatum').removeAttr('required');
          $('#inputTalkTopicDiv').hide();
          $('#vortragThema').removeAttr('required');
          $('#inputTalkTimeDiv').hide();
          $('#vortragDauer').removeAttr('required');
        }
      });
      $("#vortrag").trigger("change");
    </script>

    <!-- Einblenden des Textfeldes Sonstiges für den Bereich -->
    <script>
      $("#bereich").change(function() {
        if ($(this).val() == "Sonstige") {
          $('#bereichSonstigesDiv').show();
          $('#bereichSonstiges').attr('required', '');
        } else {
          $('#bereichSonstigesDiv').hide();
          $('#bereichSonstiges').removeAttr('required');
        }
      });
      $("#bereich").trigger("change");
    </script>

    <!-- Plain JavaScript zum validieren der Formulareingaben  -->
    <!-- Pflichtfelder werden im Formular mit einem roten Stern (*) gekennzeichnet und benötigen das Attribut required -->
    <script>
      (function() {
        'use strict';
        window.addEventListener('load', function() {
          var forms = document.getElementsByClassName('needs-validation');
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>

    <!-- Verhindere das die Formulardaten über ein Reload der Seite erneut in die Datenbank eingetragen werden -->
    <script>
      if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
      }
    </script>

    <!-- ################ -->
    <!-- ENDE JAVASCRIPT -->
    <!-- ################ -->

  </div>

</body>

</html>
