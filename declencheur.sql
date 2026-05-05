USE ppe;

-- IMPORTANT : A lancer après le script insert.sql

DROP TRIGGER IF EXISTS avantAjoutInscription;
DROP TRIGGER IF EXISTS avantModificationInscription;

DELIMITER $$

CREATE TRIGGER avantAjoutInscription
BEFORE INSERT ON inscription
FOR EACH ROW
BEGIN
    SET NEW.nom = TRIM(NEW.nom);

    IF CHAR_LENGTH(NEW.nom) < 3 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '~Le nom doit comporter au moins 3 caractères';
    END IF;

    IF CHAR_LENGTH(NEW.nom) > 100 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '~Le nom ne peut pas dépasser 100 caractères';
    END IF;

    IF NEW.nom REGEXP '<script|drop|select|insert|delete|update|--|/\\*|\\*/' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '~Le nom contient des caractères ou des mots interdits';
    END IF;

    -- dateOuverture doit être strictement supérieure à la date du jour
    IF NEW.dateOuverture <= CURDATE() THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '~La date d''ouverture doit être supérieure à la date du jour';
    END IF;

    -- dateCloture doit être strictement supérieure à dateOuverture
    IF NEW.dateCloture <= NEW.dateOuverture THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '~La date de clôture doit être supérieure à la date d''ouverture';
    END IF;

    -- dateEpreuve doit être strictement supérieure à dateCloture
    IF NEW.dateEpreuve <= NEW.dateCloture THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '~La date de l''épreuve doit être supérieure à la date de clôture';
    END IF;
END$$

CREATE TRIGGER avantModificationInscription
BEFORE UPDATE ON inscription
FOR EACH ROW
BEGIN
    SET NEW.nom = TRIM(NEW.nom);

    IF CHAR_LENGTH(NEW.nom) < 3 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '~Le nom doit comporter au moins 3 caractères';
    END IF;

    IF CHAR_LENGTH(NEW.nom) > 100 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '~Le nom ne peut pas dépasser 100 caractères';
    END IF;

    IF NEW.nom REGEXP '<script|drop|select|insert|delete|update|--|/\\*|\\*/' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '~Le nom contient des caractères ou des mots interdits';
    END IF;

    IF NEW.dateOuverture <= CURDATE() THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '~La date d''ouverture doit être supérieure à la date du jour';
    END IF;

    IF NEW.dateCloture <= NEW.dateOuverture THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '~La date de clôture doit être supérieure à la date d''ouverture';
    END IF;

    IF NEW.dateEpreuve <= NEW.dateCloture THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '~La date de l''épreuve doit être supérieure à la date de clôture';
    END IF;
END$$

DELIMITER ;
