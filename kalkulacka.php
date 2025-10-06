<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Jednoduchá kalkulačka</title>
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
    $cislo1 = floatval($_POST["cislo1"]);
    $cislo2 = floatval($_POST["cislo2"]);
    $operacia = $_POST["operacia"];
    $vysledok = null;

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
            $vysledok = "Neplatná operácia!";
    }

    echo "<h3>Výsledok: $vysledok</h3>";
}
?>
</body>
</html>
