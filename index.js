"use strict";

import {appelAjax} from "/composant/fonction/ajax.js";
import {confirmer} from "/composant/fonction/afficher.js";
import {creerBoutonSuppression, creerBoutonModification} from "/composant/fonction/formulaire.js";

/* global lesInscriptions */

const lesLignes = document.getElementById('lesLignes');
const nb = document.getElementById('nb');

nb.innerText = lesInscriptions.length;

for (const element of lesInscriptions) {
    const id = element.id;
    const tr = lesLignes.insertRow();
    tr.style.verticalAlign = 'middle';
    tr.id = id;

    // Colonne actions
    const tdAction = document.createElement('td');
    const container = document.createElement('div');
    Object.assign(container.style, {display: 'flex', gap: '8px', alignItems: 'center'});

    const btnModifier = creerBoutonModification(() => {
        window.location.href = 'modifier.php?id=' + id;
    });
    container.appendChild(btnModifier);

    const supprimer = () =>
        appelAjax({
            url: '/ajax/supprimer.php',
            data: {table: 'Inscription', id: id},
            success: () => {
                tr.remove();
                nb.innerText = parseInt(nb.innerText) - 1;
            }
        });
    container.appendChild(creerBoutonSuppression(() => confirmer(supprimer)));

    tdAction.appendChild(container);
    tr.appendChild(tdAction);

    // Nom
    const tdNom = tr.insertCell();
    tdNom.innerText = element.nom;
    tdNom.style.fontWeight = 'bold';

    // Date épreuve
    tr.insertCell().innerText = element.dateEpreuveFr;

    // Date ouverture
    tr.insertCell().innerText = element.dateOuvertureFr;

    // Date clôture
    tr.insertCell().innerText = element.dateCloturesFr;

    // Lien inscription
    const tdLienInscription = tr.insertCell();
    tdLienInscription.style.textAlign = 'center';
    if (element.lienInscription) {
        const a = document.createElement('a');
        a.href = element.lienInscription;
        a.target = '_blank';
        a.title = 'Ouvrir le lien d\'inscription';
        a.innerText = '🔗';
        tdLienInscription.appendChild(a);
    } else {
        tdLienInscription.innerText = '—';
    }

    // Lien inscrits
    const tdLienInscrit = tr.insertCell();
    tdLienInscrit.style.textAlign = 'center';
    if (element.lienInscrit) {
        const a = document.createElement('a');
        a.href = element.lienInscrit;
        a.target = '_blank';
        a.title = 'Voir les inscrits';
        a.innerText = '🔗';
        tdLienInscrit.appendChild(a);
    } else {
        tdLienInscrit.innerText = '—';
    }
}
