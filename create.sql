USE ppe;

SET default_storage_engine = InnoDb;
SET foreign_key_checks = 1;

DROP TABLE IF EXISTS inscription;

CREATE TABLE inscription (
    id            INT           AUTO_INCREMENT PRIMARY KEY,
    nom           VARCHAR(100)  NOT NULL,
    dateEpreuve   DATE          NOT NULL,
    dateOuverture DATE          NOT NULL,
    dateCloture   DATE          NOT NULL,
    lienInscription VARCHAR(500) NULL,
    lienInscrit   VARCHAR(500)  NULL
);
