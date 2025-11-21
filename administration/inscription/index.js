// index.js – Gestion des inscriptions (administration)
// Utilise tableau.js pour le tri et génère les lignes dynamiquement

import { activerTri } from '/composant/tableau/tableau.js';

// Fonction utilitaire : format yyyy-mm-dd → dd/mm/yyyy
function formatDateFR(dateIso) {
    const [a, m, j] = dateIso.split('-');
    return `${j}/${m}/${a}`;
}

// Détermination de l'état des inscriptions
function getEtat(ouverture, cloture) {
    const aujourdHui = new Date().toISOString().split('T')[0];
    if (aujourdHui < ouverture) return { texte: 'À venir', classe: 'text-primary' };
    if (aujourdHui > cloture) return { texte: 'Fermées', classe: 'text-danger' };
    return { texte: 'Ouvertes', classe: 'text-success' };
}

// Remplissage du tableau
export function afficherInscriptions(data) {
    const tbody = document.getElementById("lesLignes");
    tbody.innerHTML = "";

    for (const ins of data) {
        const etat = getEtat(ins.dateOuverture, ins.dateCloture);

        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>
                <a href="modifier.php?id=${ins.id}" class="btn btn-sm btn-warning me-1">✏️</a>
                <a href="supprimer.php?id=${ins.id}" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette inscription ?');">🗑️</a>
            </td>
            <td data-type="date">${formatDateFR(ins.dateEpreuve)}</td>
            <td>${ins.nomEpreuve}<br><span class="${etat.classe}">${etat.texte}</span></td>
            <td data-type="date">${formatDateFR(ins.dateOuverture)}</td>
            <td data-type="date">${formatDateFR(ins.dateCloture)}</td>
        `;
        tbody.appendChild(tr);
    }

    // Mise à jour du compteur
    document.getElementById("nb").textContent = data.length;
}

// Fonction principale
function init() {
    // 1) Affichage initial
    afficherInscriptions(lesInscriptions);

    // 2) Activation du tri
    activerTri({
        idTable: 'lesLignes',
        getData: () => lesInscriptions,
        afficher: afficherInscriptions,
        triInitial: { colonne: 'dateEpreuve', sens: 'asc' }
    });
}

// Lancement
init();

