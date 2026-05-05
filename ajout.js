"use strict";

import {appelAjax} from "/composant/fonction/ajax.js";
import {afficherSousLeChamp} from "/composant/fonction/afficher.js";
import {donneesValides, configurerFormulaire, effacerLesErreurs} from "/composant/fonction/formulaire.js";

// Date minimale pour l'ouverture : demain
const demain = new Date();
demain.setDate(demain.getDate() + 1);
const demainStr = demain.toISOString().split('T')[0];
document.getElementById('dateOuverture').min = demainStr;

configurerFormulaire();

document.getElementById('btnAjouter').addEventListener('click', () => {
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

    const formData = new FormData();
    formData.append('table', 'Inscription');
    formData.append('nom', nom);
    formData.append('dateOuverture', dateOuverture);
    formData.append('dateCloture', dateCloture);
    formData.append('dateEpreuve', dateEpreuve);
    if (lienInscription) formData.append('lienInscription', lienInscription);
    if (lienInscrit) formData.append('lienInscrit', lienInscrit);

    appelAjax({
        url: '/ajax/ajouter.php',
        data: formData,
        success: () => {
            window.location.href = 'index.php';
        }
    });
});
