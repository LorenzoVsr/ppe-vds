<?php

// table inscription (id, dateEpreuve, nomEpreuve, urlInscription, urlInscrits, dateOuverture, dateCloture)

class Inscription extends table
{
    /* --- CONTRÔLES MÉTIERS --- */
    public function validateBusinessRules($data)
    {
        $errors = [];

        // dateOuverture > aujourd'hui
        if (isset($data['dateOuverture']) && $data['dateOuverture'] <= date('Y-m-d')) {
            $errors[] = "La date d'ouverture doit être strictement supérieure à la date du jour.";
        }

        // dateCloture > dateOuverture
        if (isset($data['dateOuverture'], $data['dateCloture']) && $data['dateCloture'] <= $data['dateOuverture']) {
            $errors[] = "La date de clôture doit être supérieure à la date d'ouverture.";
        }

        // dateEpreuve > dateCloture
        if (isset($data['dateEpreuve'], $data['dateCloture']) && $data['dateEpreuve'] <= $data['dateCloture']) {
            $errors[] = "La date de l'épreuve doit être supérieure à la date de clôture des inscriptions.";
        }

        return $errors;
    }

    public function __construct()
    {
        parent::__construct('inscription');

        // id par défaut
        $this->idName = 'id';

        /* --- DATE DE L'EPREUVE --- */
        // Renseignée, valide, et > dateCloture
        $input = new InputDate();
        $input->Require = true;
        // La limite min sera la date de fermeture, vue dans la logique métier
        $this->columns['dateEpreuve'] = $input;

        /* --- NOM DE L'EPREUVE --- */
        // Entre 3 et 100 caractères, lettres + chiffres, séparateurs (virgule, espace, tiret)
        $input = new InputText();
        $input->Require = true;
        $input->MinLength = 3;
        $input->MaxLength = 100;
        $input->Pattern = "^[A-Za-z0-9]+([ ,\-][A-Za-z0-9]+)*$";
        $this->columns['nomEpreuve'] = $input;

        /* --- URL INSCRIPTION --- */
        $input = new InputText();
        $input->Require = false;
        $input->Pattern = "^(https?:\\/\\/).+$";
        $this->columns['urlInscription'] = $input;

        /* --- URL INSCRITS --- */
        $input = new InputText();
        $input->Require = false;
        $input->Pattern = "^(https?:\\/\\/).+$";
        $this->columns['urlInscrits'] = $input;

        /* --- DATE OUVERTURE --- */
        // Doit être > aujourd'hui
        $input = new InputDate();
        $input->Require = true;
        $input->Min = date("Y-m-d");
        $this->columns['dateOuverture'] = $input;

        /* --- DATE CLOTURE --- */
        // Doit être > dateOuverture
        $input = new InputDate();
        $input->Require = true;
        // Min sera contrôlé logiquement en aval
        $this->columns['dateCloture'] = $input;
    }

    /* --- SELECTION DE TOUTES LES INSCRIPTIONS --- */
    public static function getAll()
    {
        $sql = "SELECT id, dateEpreuve, nomEpreuve, urlInscription, urlInscrits, dateOuverture, dateCloture FROM inscription;";
        $select = new Select();
        return $select->getRows($sql);
    }

    /* --- RECHERCHE DE LA PROCHAINE EPREUVE OUVERTES AUX INSCRIPTIONS --- */
    public static function getProchaineInscription()
    {
        $sql = <<<SQL
            SELECT id, dateEpreuve, nomEpreuve, urlInscription, urlInscrits, dateOuverture, dateCloture
            FROM inscription
            WHERE dateOuverture <= CURDATE() AND dateCloture >= CURDATE()
            ORDER BY dateEpreuve
            LIMIT 1;
SQL;
        $select = new Select();
        return $select->getRow($sql);
    }

    /* --- AJOUT / MODIFICATION / SUPPRESSION --- */
    public function add($data = null)
    {
        if (!$data) $data = \$_POST;

        // contrôles métiers
        $errors = $this->validateBusinessRules($data);
        if (!empty($errors)) return $errors;

        return parent::insert();
    }()
    {
        return parent::insert();
    }

    public function updateInscription($id, $data = null)
    {
        if (!$data) $data = \$_POST;

        // contrôles métiers
        $errors = $this->validateBusinessRules($data);
        if (!empty($errors)) return $errors;

        return parent::update($id);
    }($id)
    {
        return parent::update($id);
    }

    public static function deleteInscription($id)
    {
        $sql = "DELETE FROM inscription WHERE id = ?";
        $delete = new Delete();
        return $delete->execute([$id]);
    }
}
