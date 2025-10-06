<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Kalkulačka s databázou</title>
</head>
<body>
<h2>Kalkulačka</h2>
<form method="post">
    <input type="number" name="cislo1" step="any" required>

    <select name="operacia">
        <option value="plus">+</option>
        <option value="minus">−</option>
        <option value="krat">×</option>
        <option value="deleno">÷</option>
    </select>

    <input type="number" name="cislo2" step="any" required>

    <button type="submit">Vykonať</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pripojenie k databáze
    $servername = "localhost";
    $username = "root";       // zmeň podľa svojho nastavenia
    $password = "";           // zmeň podľa svojho nastavenia
    $dbname = "kalkulacka_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Chyba pripojenia: " . $conn->connect_error);
    }

    // Vstupy z formulára
    $cislo1 = floatval($_POST["cislo1"]);
    $cislo2 = floatval($_POST["cislo2"]);
    $operacia = $_POST["operacia"];
    $vysledok = "";

    // Výpočet
    switch ($operacia) {
        case "plus":
            $vysledok = $cislo1 + $cislo2;
            break;
        case "minus":
            $vysledok = $cislo1 - $cislo2;
            break;
        case "krat":
            $vysledok = $cislo1 * $cislo2;
            break;
        case "deleno":
            if ($cislo2 != 0) {
                $vysledok = $cislo1 / $cislo2;
            } else {
                $vysledok = "Chyba: delenie nulou!";
            }
            break;
        default:
            $vysledok = "Neznáma operácia";
    }

    // Výpis výsledku
    echo "<h3>Výsledok: $vysledok</h3>";

    // Uloženie do databázy
    $stmt = $conn->prepare("INSERT INTO vypocty (cislo1, cislo2, operacia, vysledok) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ddss", $cislo1, $cislo2, $operacia, $vysledok);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
