<!-- ########################################################################### -->
<!-- PHP DATEI ZUM VALIDIEREN DER FORMULAREINGABE UND EINTRAGEN IN DIE DATENBANK -->
<!-- ########################################################################### -->

<?php

if (isset($_POST['submit'])) {

	# Anlegen der Variablen und zuweisen eines leeren Wertes  
	$firmenname = $anrede = $ansprechpartner = $telnr = $email = $bereich = $teilnahmeDatum = $tische = $stuehle = $anmerkung = $vortrag = $vortragDatum = $vortragDauer = $vortragThema = $emailKopie = $bereichSonstige = "";

	# DebugMode für zusätzliche Ausgaben falls benötigt 
	$debugMode = false;

	# Filtern von niocht erlauben Eingaben 
	function correctForminput($input)
	{
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}

	$firmenname 	 = correctForminput($_POST['firmenname']);
	$anrede 	 = correctForminput($_POST['anrede']);
	$ansprechpartner = correctForminput($_POST['ansprechpartner']);
	$telnr 		 = correctForminput($_POST['telnr']);
	$email 		 = correctForminput($_POST['email']);
	$bereich 	 = correctForminput($_POST['bereich']);
	$bereichSonstige = correctForminput($_POST['bereichSonstiges']);
	$teilnahmeDatum  = correctForminput($_POST['teilnahmeDatum']);
	$tische 	 = correctForminput($_POST['tische']);
	$stuehle 	 = correctForminput($_POST['stuehle']);
	$anmerkung 	 = correctForminput($_POST['anmerkung']);
	$vortrag 	 = correctForminput($_POST['vortrag']);
	$vortragDatum 	 = correctForminput($_POST['vortragDatum']);
	$vortragThema 	 = correctForminput($_POST['vortragThema']);
	$vortragDauer 	 = correctForminput($_POST['vortragDauer']);
	$emailKopie 	 = correctForminput($_POST['emailKopie']);



	# Prüfe ob optionale Variablen leer sind und setzte ggf. null als Wert für die DB 
	if (empty($anmerkung)) {
		$anmerkung = NULL;
	}

	if (empty($emailKopie)) {
		$emailKopie = false;
	}

	if ($vortrag == 0) {
		$vortragDatum = NULL;
		$vortragThema = NULL;
		$vortragDauer = NULL;
	}

	if ($bereich == "Sonstige") {
		$bereich = $bereichSonstige;
	}

	if ($debugMode) {
		echo "Firma: $firmenname <br>";
		echo "Anrede: $anrede <br>";
		echo "AP: $ansprechpartner<br>";
		echo "Tel.: $telnr<br>";
		echo "Email: $email<br>";
		echo "Bereich: $bereich<br>";
		echo "Teilnahme Datum: $teilnahmeDatum<br>";
		echo "Anzahl Tische: $tische<br>";
		echo "Anzahl Stühle: $stuehle<br>";
		echo "Anmerkung: $anmerkung<br>";
		echo "Vortrag: $vortrag<br>";
		echo "Vortrag am: $vortragDatum<br>";
		echo "Vortragsthema: $vortragThema<br>";
		echo "Vortragsdauer: $vortragDauer<br>";
		echo "Kopie an E-Mail: $emailKopie<br>";
	}


	$sql_insert = $link->prepare("INSERT INTO anmeldungen 
					 (firmenname, anrede, ansprechpartner, telnr, email, bereich, teilnahmeDatum, tische, stuehle, anmerkung, vortrag, vortragDatum, vortragThema, vortragDauer, emailKopie) 
					VALUES 
					 (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");

	# Mögliche Datebtypen für Platzhalter: 
	#i - integer
	#d - double
	#s - string
	#b - BLOB

	$sql_insert->bind_param("sssssssiisissii", $firmenname, $anrede, $ansprechpartner, $telnr, $email, $bereich, $teilnahmeDatum, $tische, $stuehle, $anmerkung, $vortrag, $vortragDatum, $vortragThema, $vortragDauer, $emailKopie);
	$sql_insert->execute();
	$num = mysqli_affected_rows($link);

	if ($debugMode) {
		$num = mysqli_affected_rows($link);
		echo "<br>Anzahl der hinzugefügten Datensätze: " . $num . "<br>";
	}

	# Prüfe die Anzahl der geänderten Datensätze 
	# num > 0 = Datensatz wurde erfolgreich eingetragen 
	# num == 0 (else Block) = Datensatz wurde nicht eingetragen, Benutzer erhält Fehlermeldung 
	if ($num > 0) {
		include("erfolg.html");
		echo "<script type='text/javascript'>
			$(document).ready(function(){
			$('#ModalErfolg').modal('show');
			});
			</script>";
	} else {
		include("fehler.html");
		echo "<script type='text/javascript'>
			 $(document).ready(function(){
			 $('#ModalFehler').modal('show');
			 });
			 </script>";
	}

	//mysqli_close($link);

	# ####################################################################
	# Sende eine Kopie der Formulardaten an die angegebene E-Mail Adresse 
	# ####################################################################
	if ($emailKopie) {

		$vortrag = ($vortrag == 1 ? "Ja" : "Nein");
		$vortragThema = ($vortrag == "Ja" ? $vortragThema : " -");
		$teilnahmeDatum = ($teilnahmeDatum == 3 ? "Fr. und Sa." : ($teilnahmeDatum == 1 ? "Sa." : "Fr."));

		if ($vortrag == "Ja") {
			$vortragString = 'Vortrag am: ' . $vortragDatum . "\r\n" .
							 'Thema: ' . $vortragThema . "\r\n"; 
		}
		else {
			$vortragString = ''; 
		}

		$subject = 'Ausbildungstag 2019';
		$nachricht = 'Sehr geehrte Damen und Herren,' . "\r\n\r\n" .
			'vielen Tag für die Anmeldung am Ausbildungstag 2019 am GSO in Köln. In dieser E-Mail befinden sich Ihre angegebenen Kontaktdaten zur Kontrolle:'
			. "\r\n\r\n" .
			'Firma: ' . $firmenname . "\r\n" .
			'Kategorie: ' . $bereich . "\r\n" .
			'Ansprechpartner: ' . $ansprechpartner . "\r\n" .
			'Telefonnummer: ' . $telnr . "\r\n" .
			'E-Mail: ' . $email . "\r\n" .
			'Teilnahme am: ' . $teilnahmeDatum . "\r\n" .
			'Anzahl Tische: ' . $tische . "\r\n" .
			'Anzahl Stühle: ' . $stuehle . "\r\n" .
			'Vortrag: ' . $vortrag . "\r\n" .
			$vortragString . "\r\n\r\n" . 
			'Bei Fragen können Sie sich gerne an info@domain.com wenden. ' . "\r\n\r\n" . 
			'Viele Grüße ' . "\r\n\r\n" .
			'Ihr Team der GSO Köln'
			;

		// php mail weigert sich den $header als Array anzunehmen
		// Moeglicherweise bug?  
		$header = 'From: kontaktformular@furmanczak.de' . "\r\n" .
			'Reply-To: kontaktformular@furmanczak.de' . "\r\n" .
			'MIME-Version: 1.0' . "\r\n" .
			'Content-type: text/plain; charset="UTF-8"' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		mail($email, $subject, $nachricht, $header);
	}
}
