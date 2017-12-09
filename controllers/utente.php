<?php

class Utente {
    function get() {

        /* ----------------------------------------
         *      AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
         */

        Autaut::CHECK_CREDENTIAL(['Amministratore','Normale', 'Visitatore']);

        /* ----------------------------------------
         *   FINE AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */

        $utenti = UtenteEntity::Lista();
        include("views/utente.php");
    }

    function post() {
        /* ----------------------------------------
         *      AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
         */

        Autaut::CHECK_CREDENTIAL(['Amministratore','Normale', 'Visitatore']);

        /* ----------------------------------------
         *   FINE AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */

        $errors = [];

        // Validazione generale
        if (isset($_POST['denominazione'], $_POST['email'], $_POST['account'], $_POST['password'], $_POST['tipologia']) && strlen(trim($_POST['denominazione'])) > 0) {

            // Validazioni singole

            if (isset($_POST['denominazione']) && strlen(trim($_POST['denominazione'])) > 0) {
                $denominazione = Utilita::PULISCISTRINGA($_POST['denominazione']);
            } else {
                $errors[] = 'Denominazione non passata';
            }

            if (isset($_POST['email']) && strlen(trim($_POST['email'])) > 0) {
                $email = Utilita::PULISCISTRINGA($_POST['email']);
            } else {
                $errors[] = 'Email non passata';
            }

            if (isset($_POST['account']) && strlen(trim($_POST['account'])) > 0) {
                $account = Utilita::PULISCISTRINGA($_POST['account']);
            } else {
                $errors[] = 'Account non passato';
            }

            if (isset($_POST['password']) && strlen(trim($_POST['password'])) > 0) {
                $password = Utilita::PULISCISTRINGA($_POST['password']);
            } else {
                $errors[] = 'Password non passata';
            }

            if (isset($_POST['tipologia']) && strlen(trim($_POST['tipologia'])) > 0) {
                $tipologia = Utilita::PULISCISTRINGA($_POST['tipologia']);
            } else {
                $errors[] = 'Tipologia non passata';
            }

            // Dati non obbligatori

            if (isset($_POST['indirizzo'])) {
                $indirizzo = Utilita::PULISCISTRINGA($_POST['indirizzo']);
            } else {
                $indirizzo = '-';
            }

            if (isset($_POST['cf'])) {
                $cf = Utilita::PULISCISTRINGA($_POST['cf']);
            } else {
                $cf = '-';
            }

            if (isset($_POST['piva'])) {
                $piva = Utilita::PULISCISTRINGA($_POST['piva']);
            } else {
                $piva = '-';
            }

            if (isset($_POST['telefono'])) {
                $telefono = Utilita::PULISCISTRINGA($_POST['telefono']);
            } else {
                $telefono = '-';
            }


        } else {
            $errors[] = 'Dati non passati';
        }

        if(empty($errors)) {

            if(!UtenteEntity::Add($denominazione, $indirizzo, $cf, $piva, $telefono, $email, $account, $password, $tipologia)) {
                $errors[] = 'Errore inserimento nella base dati';
            } else {
                Flashmessage::ADD(Autaut::LOGGATO(), 'utente', 'ok', 'Aggiunto', 'SUCCESS');
            }
        }

        if(!empty($errors)) {
            foreach($errors as $testo) {
                Flashmessage::ADD(Autaut::LOGGATO(), 'utente', 'Attenzione', $testo, 'ALERT');
            }
        }

        // Rinvia alla pagina
        header("Location: /utente");
    }
}


/* -------------------------------------------------
 *                      DELETE
 * -------------------------------------------------
 */

class UtenteDelete {
    function post() {

        /* ----------------------------------------
         *      AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
         */

        Autaut::CHECK_CREDENTIAL(['Amministratore','Normale', 'Visitatore']);

        /* ----------------------------------------
         *   FINE AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */

        $errors = [];

        if (isset($_POST['id']) && strlen(trim($_POST['id'])) > 0) {
            $id = Utilita::PULISCISTRINGA($_POST['id']);
        } else {
            $errors[] = 'ID non passato';
        }

        if(empty($errors)) {

            if(!UtenteEntity::DELETE($id)) {
                $errors[] = 'Errore inserimento nella base dati';
            } else {
                Flashmessage::ADD(Autaut::LOGGATO(), 'utente', 'ok', 'cancellato', 'SUCCESS');
            }
        }

        if(!empty($errors)) {
            foreach($errors as $testo) {
                Flashmessage::ADD(Autaut::LOGGATO(), 'utente', 'Attenzione', $testo, 'ALERT');
            }
        }

        // Rinvia alla pagina
        header("Location: /utente");
    }

    function get($id) {

        /* ----------------------------------------
         *      AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
         */

        Autaut::CHECK_CREDENTIAL(['Amministratore','Normale', 'Visitatore']);

        /* ----------------------------------------
         *   FINE AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */

        $el = UtenteEntity::ID($id);

        $messaggio = "Attenzione";
        $elemento = "Cancellare #".$el['utenteid'].": ".Utilita::DB2HTML($el['denominazione'])." ?";
        $linkAnnulla = "/utente";

        include("views/utentedelete.php");
    }
}

/* -------------------------------------------------
 *                      MODIFY
 * -------------------------------------------------
 */

class UtenteModify {
    function post() {

        /* ----------------------------------------
         *      AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
         */

        Autaut::CHECK_CREDENTIAL(['Amministratore','Normale', 'Visitatore']);

        /* ----------------------------------------
         *   FINE AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */

        $errors = [];

        // Validazione generale
        if (isset($_POST['utenteid'], $_POST['denominazione'], $_POST['email'], $_POST['account'], $_POST['password'], $_POST['tipologia']) && strlen(trim($_POST['denominazione'])) > 0) {

            // Validazioni singole
            if (isset($_POST['utenteid'])) {
                $id = Utilita::PULISCISTRINGA($_POST['utenteid']);
            } else {
                $errors[] = 'id non passato';
            }

            if (isset($_POST['denominazione']) && strlen(trim($_POST['denominazione'])) > 0) {
                $denominazione = Utilita::PULISCISTRINGA($_POST['denominazione']);
            } else {
                $errors[] = 'Denominazione non passata';
            }

            if (isset($_POST['email']) && strlen(trim($_POST['email'])) > 0) {
                $email = Utilita::PULISCISTRINGA($_POST['email']);
            } else {
                $errors[] = 'Email non passata';
            }

            if (isset($_POST['account']) && strlen(trim($_POST['account'])) > 0) {
                $account = Utilita::PULISCISTRINGA($_POST['account']);
            } else {
                $errors[] = 'Account non passato';
            }

            if (isset($_POST['password']) && strlen(trim($_POST['password'])) > 0) {
                $password = Utilita::PULISCISTRINGA($_POST['password']);
            } else {
                $errors[] = 'Password non passata';
            }

            if (isset($_POST['tipologia']) && strlen(trim($_POST['tipologia'])) > 0) {
                $tipologia = Utilita::PULISCISTRINGA($_POST['tipologia']);
            } else {
                $errors[] = 'Tipologia non passata';
            }

            // Dati non obbligatori

            if (isset($_POST['indirizzo'])) {
                $indirizzo = Utilita::PULISCISTRINGA($_POST['indirizzo']);
            } else {
                $indirizzo = '-';
            }

            if (isset($_POST['cf'])) {
                $cf = Utilita::PULISCISTRINGA($_POST['cf']);
            } else {
                $cf = '-';
            }

            if (isset($_POST['piva'])) {
                $piva = Utilita::PULISCISTRINGA($_POST['piva']);
            } else {
                $piva = '-';
            }

            if (isset($_POST['telefono'])) {
                $telefono = Utilita::PULISCISTRINGA($_POST['telefono']);
            } else {
                $telefono = '-';
            }


        } else {
            $errors[] = 'Dati non passati';
        }

        if(empty($errors)) {

            if(!UtenteEntity::Modify($id, $denominazione, $indirizzo, $cf, $piva, $telefono, $email, $account, $password, $tipologia)) {
                $errors[] = 'Errore inserimento nella base dati';
            } else {
                Flashmessage::ADD(Autaut::LOGGATO(), 'utente', 'ok', 'Modificato', 'SUCCESS');
            }
        }

        if(!empty($errors)) {
            foreach($errors as $testo) {
                Flashmessage::ADD(Autaut::LOGGATO(), 'utente', 'Attenzione', $testo, 'ALERT');
            }
        }

        // Rinvia alla pagina
        header("Location: /utente");
    }

    function get($id) {

        /* ----------------------------------------
         *      AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
         */

        Autaut::CHECK_CREDENTIAL(['Amministratore','Normale', 'Visitatore']);

        /* ----------------------------------------
         *   FINE AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */

        $utente = UtenteEntity::ID($id);
        $linkAnnulla = "/utente";
        include("views/utentemodify.php");
    }
}

/* -------------------------------------------------
 *                      ENTITY
 * -------------------------------------------------
 */

class UtenteEntity {

    public $utenteid;
    public $denominazione;
    public $indirizzo;
    public $cf;
    public $piva;
    public $telefono;
    public $email;
    public $account;
    public $password;
    public $tipologia;

    public static function Add($denominazione, $indirizzo, $cf, $piva, $telefono, $email, $account, $password, $tipologia) {
        $result = false;
        try {

            $query = MySQL::getInstance()->prepare("INSERT INTO utente VALUES (null, :denominazione, :indirizzo, :cf, :piva, :telefono, :email, :account, :password, :tipologia)");
            $query->bindValue(':denominazione', Utilita::HTML2DB($denominazione), PDO::PARAM_STR);
            $query->bindValue(':indirizzo', Utilita::HTML2DB($indirizzo), PDO::PARAM_STR);
            $query->bindValue(':cf', Utilita::HTML2DB($cf), PDO::PARAM_STR);
            $query->bindValue(':piva', Utilita::HTML2DB($piva), PDO::PARAM_STR);
            $query->bindValue(':telefono', Utilita::HTML2DB($telefono), PDO::PARAM_STR);
            $query->bindValue(':email', Utilita::HTML2DB($email), PDO::PARAM_STR);
            $query->bindValue(':account', Utilita::HTML2DB($account), PDO::PARAM_STR);
            $query->bindValue(':password', Utilita::HTML2DB($password), PDO::PARAM_STR);
            $query->bindValue(':tipologia', Utilita::HTML2DB($tipologia), PDO::PARAM_STR);
            $result = $query->execute();

        }  catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $result;
    }

    public static function Lista() {
        try {

            $query = MySQL::getInstance()->query("SELECT * FROM utente ORDER BY denominazione ASC");
            $lista = $query->fetchAll();

        }  catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $lista;
    }

    public static function ID($id) {
        try {

            $query = MySQL::getInstance()->prepare("SELECT * FROM utente WHERE utenteid = :id");
            $query->bindValue(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $utente = $query->fetch(PDO::FETCH_ASSOC);

        }  catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $utente;
    }

    public static function DELETE($id) {
        $result = false;
        try {

            $query = MySQL::getInstance()->prepare("DELETE FROM utente WHERE utenteid = :id");
            $query->bindValue(':id', $id, PDO::PARAM_STR);
            $result = $query->execute();

        }  catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $result;
    }

    public static function MODIFY($id, $denominazione, $indirizzo, $cf, $piva, $telefono, $email, $account, $password, $tipologia) {
        $result = false;
        try {

            $query = MySQL::getInstance()->prepare("UPDATE utente SET denominazione=:denominazione, indirizzo=:indirizzo, cf=:cf, piva=:piva, telefono=:telefono, email=:email, account=:account, password=:password, tipologia=:tipologia WHERE utenteid = :id");
            $query->bindValue(':id', $id, PDO::PARAM_STR);
            $query->bindValue(':denominazione', Utilita::HTML2DB($denominazione), PDO::PARAM_STR);
            $query->bindValue(':indirizzo', Utilita::HTML2DB($indirizzo), PDO::PARAM_STR);
            $query->bindValue(':cf', Utilita::HTML2DB($cf), PDO::PARAM_STR);
            $query->bindValue(':piva', Utilita::HTML2DB($piva), PDO::PARAM_STR);
            $query->bindValue(':telefono', Utilita::HTML2DB($telefono), PDO::PARAM_STR);
            $query->bindValue(':email', Utilita::HTML2DB($email), PDO::PARAM_STR);
            $query->bindValue(':account', Utilita::HTML2DB($account), PDO::PARAM_STR);
            $query->bindValue(':password', Utilita::HTML2DB($password), PDO::PARAM_STR);
            $query->bindValue(':tipologia', Utilita::HTML2DB($tipologia), PDO::PARAM_STR);
            $result = $query->execute();

        }  catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $result;
    }

    public static function CHECK_EMAIL_PASSWORD($email, $password) {
        $check = false;
        try {

            $query = MySQL::getInstance()->prepare("SELECT password FROM utente WHERE email = :email");
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->execute();
            $utente = $query->fetch(PDO::FETCH_ASSOC);

            if($password==hash('sha512',($utente['password']))) {
                $check = true;
            }
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $check;
    }

    public static function FIND_BY_EMAIL($email) {
        try {
            $query = MySQL::getInstance()->prepare("SELECT *FROM utente WHERE email = :email");
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->execute();
            $ut = $query->fetch(PDO::FETCH_ASSOC);

            $utente = new UtenteEntity();
            $utente->utenteid = $ut['utenteid'];
            $utente->denominazione = $ut['denominazione'];
            $utente->indirizzo = $ut['indirizzo'];
            $utente->cf = $ut['cf'];
            $utente->piva = $ut['piva'];
            $utente->telefono = $ut['telefono'];
            $utente->email = $ut['email'];
            $utente->account = $ut['account'];
            $utente->password = $ut['password'];
            $utente->tipologia = $ut['tipologia'];

            return $utente;
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return null;
    }
}
