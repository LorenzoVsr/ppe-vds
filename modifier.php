<?php
require $_SERVER['DOCUMENT_ROOT'] . '/include/autoload.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    Erreur::afficherReponse("Identifiant invalide", 'global');
}

$id = (int)$_GET['id'];
$inscription = Inscription::getById($id);

if (!$inscription) {
    Erreur::afficherReponse("Cette inscription n'existe pas", 'global');
}

$titre = "Modifier une inscription en ligne";
$lesDonnees = json_encode($inscription);

$head = <<<HTML
    <script>
        const lesDonnees = $lesDonnees;
    </script>
HTML;

require RACINE . '/include/interface.php';
