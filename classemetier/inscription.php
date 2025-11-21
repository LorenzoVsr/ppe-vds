<?php

class Inscription extends Table
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $inscription->add([
        "nom"              => $_POST['nom'],
        "date_epreuve"     => $_POST['date_epreuve'],
        "date_ouverture"   => $_POST['date_ouverture'],
        "date_cloture"     => $_POST['date_cloture'],
        "lien_inscription" => $_POST['lien_inscription'],
        "lien_inscrits"    => $_POST['lien_inscrits']
    ]);

    echo "<p style='color:green'>✔️ Course ajoutée avec succès</p>";
    }


    <form method="POST">
    Nom : <br>
    <input type="text" name="nom" required><br><br>

    Date épreuve : <br>
    <input type="date" name="date_epreuve" required><br><br>

    Date ouverture : <br>
    <input type="date" name="date_ouverture" required><br><br>

    Date clôture : <br>
    <input type="date" name="date_cloture" required><br><br>

    Lien inscription : <br>
    <input type="text" name="lien_inscription" required><br><br>

    Lien inscrits : <br>
    <input type="text" name="lien_inscrits" required><br><br>

    <button type="submit">Ajouter</button>
    </form>
}

?>