<?php
require $_SERVER['DOCUMENT_ROOT'] . '/include/autoload.php';

$titre = "Gestion des inscriptions en ligne";
$lesInscriptions = json_encode(Inscription::getAll());

$head = <<<HTML
    <script>
        const lesInscriptions = $lesInscriptions;
    </script>
HTML;

require RACINE . '/include/interface.php';
