<!DOCTYPE html>
<html lang="de">

<head>
  <title>Kontaktformular</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Einbinden von JavaScript, CSS Dateien und CSS Frameworks. Der Einfachheit halber sind die Frameworks über ein cdn eingebunden.  -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
</head>

<body>

  <?php
  // Einbinden der Datei fst71/mysql_connect.php welche die Zugangsdaten für die Datenbank inkl. prüfung ob die Datei vorhanden ist
  // Ansonsten erhält der Besucher eine simple Fehlermeldung im Browser
  $mysql_connect_file = 'mysql_connect.php';
  if (!file_exists($mysql_connect_file)) {
    echo "Wegen einem technischen Problem steht das Kontaktformular leider aktuell nicht zur Verfügung. Wir bitten um Verständnis. ";
    echo "<br>Bei dringenden Fragen wenden Sie sich bitte an info@domain.com";
  }
  require_once $mysql_connect_file;

  $db_select_all_rows = mysqli_query($link, "SELECT * FROM anmeldungen");

  mysqli_close($link);

  // Wandel das Datum aus der Datenbank in das typische Format in Deutschland um (dd.mm.yyyy)
  function deDate($datum)
  {
    $db_date = DateTime::createFromFormat('Y-m-d', $datum);
    return $db_date->format('d.m.Y');
  }

  ?>

  <!-- ########################### -->
  <!-- START NAVBAR / Menüleiste   -->
  <!-- ########################### -->
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">Menuleiste</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <li class="nav-item ">
            <a class="nav-link" href="formular.php">Kontaktformular</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="datenbankinhalt.php">Datenbankinhalt</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- ########################### -->
  <!-- ENDE NAVBAR / Menüleiste    -->
  <!-- ########################### -->
  <br>


  <!-- ############# -->
  <!-- START TABELLE -->
  <!-- ############# -->
  <div class="container-fluid">
    <table id="anmeldung" class="table-bordered compact hover" >
      <thead>
        <tr>
          <th>Firma</th>
          <th>Kategorie</th>
          <th>Anspechpartner</th>
          <th>Tel.-Nr.</th>
          <th>E-Mail</th>
          <th>Teilnahme</th>
          <th>Tische</th>
          <th>Stühle</th>
          <th>Anmerkung</th>
          <th>Vortrag</th>
          <th>Datum</th>
          <th>Thema</th>
          <th>Dauer</th>
        </tr>
      </thead>
      <?php

      if (mysqli_num_rows($db_select_all_rows) > 0) {

        while ($row = mysqli_fetch_assoc($db_select_all_rows)) {
          ?>
          <tr>
            <td> <?php echo $row["firmenname"]; ?> </td>
            <td> <?php echo $row["bereich"]; ?> </td>
            <!-- Ternary Logic in PHP -->
            <!-- Bedingung ? True : False -->
            <td> <?php echo (($row["anrede"] == "keine Angabe") ? $row["ansprechpartner"] : $row["anrede"] . " " .  $row["ansprechpartner"]); ?> </td>
            <td> <?php echo $row["telnr"]; ?> </td>
            <td> <?php echo $row["email"]; ?> </td>
            <!-- Verschachtelte Ternary Logic in PHP, entspricht if mit elseif -->
            <!-- Bedingung ? True : (Bedingung ? True : False ) -->
            <td> <?php echo ($row["teilnahmeDatum"] == 3 ? "Fr. und Sa." : ($row["teilnahmeDatum"] == 1 ? "Fr." : "Sa.")); ?> </td>
            <td> <?php echo $row["tische"]; ?> </td>
            <td> <?php echo $row["stuehle"]; ?> </td>
            <td> <?php echo (empty($row["anmerkung"]) ? "-" : $row["anmerkung"]); ?> </td>
            <td> <?php echo (($row["vortrag"] == 1) ? "Ja" : "Nein"); ?></td>
            <td> <?php echo (($row["vortrag"] == 0) ? "-" : deDate($row["vortragDatum"])); ?> </td>
            <td> <?php echo (($row["vortrag"] == 0) ? "-" : $row["vortragThema"]); ?> </td>
            <td> <?php echo (($row["vortrag"] == 0) ? "-" : $row["vortragDauer"] . " Min."); ?> </td>
          </tr>

      <?php
        }
      }
      ?>
    </table>
    <!-- ############# -->
    <!-- ENDE TABELLE -->
    <!-- ############# -->
    <br>
  </div>

  <script>
    $('#anmeldung').DataTable({
      responsive: true
    });
  </script>
</body>

</html>
