USE ppe;

-- IMPORTANT : A lancer AVANT le script declencheur.sql
-- Ces données historiques ne respectent pas la contrainte dateOuverture > CURDATE()
-- qui sera imposée par le déclencheur après insertion

INSERT INTO inscription (nom, dateEpreuve, dateOuverture, dateCloture, lienInscription, lienInscrit) VALUES
(
    'Demi-finale des championnats de France de 5km',
    '2025-09-21',
    '2025-07-01',
    '2025-09-18',
    'https://www.klikego.com/inscription/demi-finale-des-championnats-de-france-de-5km-et-mile-sur-route-2025/running-course-a-pied/1603054434896-26',
    'https://www.klikego.com/inscrits/demi-finale-des-championnats-de-france-de-5km-et-mile-sur-route-2025/1603054434896-26'
),
(
    'Marathon d''Amiens-métropole et Semi-marathon du Val de Somme',
    '2025-10-19',
    '2025-07-01',
    '2025-10-12',
    'https://www.klikego.com/inscription/marathon-damiens-metropole-semi-marathon-de-la-somme-2025/course-a-pied-running/1603054434896-23',
    'https://www.klikego.com/inscrits/marathon-damiens-metropole-semi-marathon-de-la-somme-2025/1603054434896-23'
),
(
    'Finale des 4 saisons',
    '2025-11-02',
    '2025-09-08',
    '2025-10-30',
    NULL,
    NULL
);
