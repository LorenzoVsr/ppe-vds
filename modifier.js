"use strict";

import {appelAjax} from "/composant/fonction/ajax.js";
import {afficherSousLeChamp} from "/composant/fonction/afficher.js";
import {donneesValides, configurerFormulaire, effacerLesErreurs} from "/composant/fonction/formulaire.js";

/* global lesDonnees */

// Pré-remplissage du formulaire avec les données existantes
document.getElementById('nom').value = lesDonnees.nom ?? '';
document.getElementById('dateOuverture').value = lesDonnees.dateOuverture ?? '';
document.getElementById('dateCloture').value = lesDonnees.dateCloture ?? '';
document.getElementById('dateEpreuve').value = lesDonnees.dateEpreuve ?? '';
document.getElementById('lienInscription').value = lesDonnees.lienInscription ?? '';
document.getElementById('lienInscrit').value = lesDonnees.lienInscrit ?? '';

configurerFormulaire();

document.getElementById('btnModifier').addEventListener('click', () => {
    effacerLesErreurs();

    const nom = document.getElementById('nom').value.trim();
    const dateOuverture = document.getElementById('dateOuverture').value;
    const dateCloture = document.getElementById('dateCloture').value;
    const dateEpreuve = document.getElementById('dateEpreuve').value;
    const lienInscription = document.getElementById('lienInscription').value.trim();
    const lienInscrit = document.getElementById('lienInscrit').value.trim();

    if (!donneesValides()) return;

    // Contrôles croisés sur les dates
    if (dateCloture && dateOuverture && dateCloture <= dateOuverture) {
        afficherSousLeChamp('dateCloture', 'La date de clôture doit être supérieure à la date d\'ouverture');
        return;
    }
    if (dateEpreuve && dateCloture && dateEpreuve <= dateCloture) {
        afficherSousLeChamp('dateEpreuve', 'La date de l\'épreuve doit être supérieure à la date de clôture');
        return;
    }

    const lesValeurs = {
        nom,
        dateOuverture,
        dateCloture,
        dateEpreuve,
        lienInscription,
        lienInscrit
    };

    appelAjax({
        url: '/ajax/modifier.php',
        data: {
            table: 'Inscription',
            id: lesDonnees.id,
            lesValeurs: JSON.stringify(lesValeurs)
        },
        success: () => {
            window.location.href = 'index.php';
        }
    });
});
