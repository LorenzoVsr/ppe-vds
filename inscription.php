<?php
declare(strict_types=1);

class Inscription extends Table
{
    public function __construct()
    {
        parent::__construct('inscription');

        // nom : 3-100 caractères, lettres/chiffres séparés par virgule, espace ou tiret
        $input = new InputText();
        $input->Require = true;
        $input->MinLength = 3;
        $input->MaxLength = 100;
        $input->Pattern = "^[0-9A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ](?:[, \\-]?[0-9A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ])*$";
        $input->SupprimerEspaceSuperflu = true;
        $this->columns['nom'] = $input;

        // dateEpreuve : obligatoire, doit être > dateCloture (contrôle croisé via trigger)
        $input = new InputDate();
        $input->Require = true;
        $this->columns['dateEpreuve'] = $input;

        // dateOuverture : obligatoire, strictement supérieure à la date du jour
        $input = new InputDate();
        $input->Require = true;
        $input->Min = date('Y-m-d', strtotime('+1 day'));
        $this->columns['dateOuverture'] = $input;

        // dateCloture : obligatoire, doit être > dateOuverture (contrôle croisé via trigger)
        $input = new InputDate();
        $input->Require = true;
        $this->columns['dateCloture'] = $input;

        // lienInscription : URL facultative vers le formulaire d'inscription
        $input = new InputUrl();
        $input->Require = false;
        $this->columns['lienInscription'] = $input;

        // lienInscrit : URL facultative vers la liste des inscrits
        $input = new InputUrl();
        $input->Require = false;
        $this->columns['lienInscrit'] = $input;

        $this->listOfColumns->Values = ['nom', 'dateEpreuve', 'dateOuverture', 'dateCloture', 'lienInscription', 'lienInscrit'];
    }

    /**
     * Récupère toutes les inscriptions triées par date d'épreuve croissante
     */
    public static function getAll(): array
    {
        $sql = <<<SQL
            SELECT id, nom,
                   dateEpreuve,   DATE_FORMAT(dateEpreuve,   '%d/%m/%Y') AS dateEpreuveFr,
                   dateOuverture, DATE_FORMAT(dateOuverture, '%d/%m/%Y') AS dateOuvertureFr,
                   dateCloture,   DATE_FORMAT(dateCloture,   '%d/%m/%Y') AS dateCloturesFr,
                   lienInscription, lienInscrit
            FROM inscription
            ORDER BY dateEpreuve ASC;
SQL;
        $select = new Select();
        return $select->getRows($sql);
    }

    /**
     * Récupère une inscription par son identifiant
     */
    public static function getById(int $id): ?array
    {
        $sql = <<<SQL
            SELECT id, nom, dateEpreuve, dateOuverture, dateCloture, lienInscription, lienInscrit
            FROM inscription
            WHERE id = :id;
SQL;
        $select = new Select();
        return $select->getRow($sql, ['id' => $id]);
    }

    /**
     * Récupère les inscriptions dont la clôture n'est pas encore passée
     */
    public static function getActives(): array
    {
        $sql = <<<SQL
            SELECT id, nom,
                   dateEpreuve,   DATE_FORMAT(dateEpreuve,   '%d/%m/%Y') AS dateEpreuveFr,
                   dateOuverture, DATE_FORMAT(dateOuverture, '%d/%m/%Y') AS dateOuvertureFr,
                   dateCloture,   DATE_FORMAT(dateCloture,   '%d/%m/%Y') AS dateCloturesFr,
                   lienInscription, lienInscrit
            FROM inscription
            WHERE dateCloture >= CURDATE()
            ORDER BY dateEpreuve ASC;
SQL;
        $select = new Select();
        return $select->getRows($sql);
    }

    /**
     * Supprime une inscription par son identifiant
     */
    public static function supprimer(int $id): void
    {
        $db = Database::getInstance();
        $sql = "DELETE FROM inscription WHERE id = :id;";
        $cmd = $db->prepare($sql);
        $cmd->bindValue('id', $id);
        $cmd->execute();
    }
}
