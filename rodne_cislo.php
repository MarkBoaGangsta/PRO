<?php

// Funkcia na zistenie pohlavia
function getGender($rodneCislo) {
    // Ak je 3. a 4. číslica >= 50, ide o ženu, inak muž
    $genderNumber = substr($rodneCislo, 2, 2);
    return ($genderNumber >= 50) ? "Žena" : "Muž";
}

// Funkcia na zistenie veku
function getAge($rodneCislo) {
    // Zoberieme prvé štyri číslice, ktoré sú dátum (RRMMDD)
    $year = substr($rodneCislo, 0, 2);
    $month = substr($rodneCislo, 2, 2);
    $day = substr($rodneCislo, 4, 2);

    // Prepočítame rok (roky sa počítajú v formáte 1900 alebo 2000)
    $currentYear = (int) date("Y");
    $fullYear = ($year <= date("y")) ? 2000 + $year : 1900 + $year;

    // Vytvoríme dátum narodenia a počítame vek
    $birthDate = $fullYear . '-' . $month . '-' . $day;
    $age = floor((time() - strtotime($birthDate)) / (365.25 * 24 * 60 * 60));  // Vek v rokoch

    return $age;
}

// Kontrola vstupu a zistenie informácií
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rodneCislo = $_POST['rodne_cislo'];

    if (preg_match("/^\d{10}$/", $rodneCislo)) {
        $pohlavie = getGender($rodneCislo);
        $vek = getAge($rodneCislo);
        echo "Rodné číslo: $rodneCislo<br>";
        echo "Pohlavie: $pohlavie<br>";
        echo "Vek: $vek rokov<br>";
    } else {
        echo "Neplatné rodné číslo. Zadajte 10-ciferné rodné číslo.";
    }
}
?>

<form method="post" action="">
    Zadajte rodné číslo: <input type="text" name="rodne_cislo" maxlength="10" required>
    <button type="submit">Odoslať</button>
</form>
