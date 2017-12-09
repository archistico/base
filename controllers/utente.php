<?php

class Utente {
    function get() {
        $utenti = UtenteEntity::Lista();
        include("views/utente.php");
    }

    function post() {
        $utentefk = 1;
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
                Flashmessage::ADD($utentefk, 'utente', 'ok', 'Aggiunto', 'SUCCESS');
            }
        }

        if(!empty($errors)) {
            foreach($errors as $testo) {
                Flashmessage::ADD($utentefk, 'utente', 'Attenzione', $testo, 'ALERT');
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
        $utentefk = 1;
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
                Flashmessage::ADD($utentefk, 'utente', 'ok', 'cancellato', 'SUCCESS');
            }
        }

        if(!empty($errors)) {
            foreach($errors as $testo) {
                Flashmessage::ADD($utentefk, 'utente', 'Attenzione', $testo, 'ALERT');
            }
        }

        // Rinvia alla pagina
        header("Location: /utente");
    }

    function get($id) {
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
        $utentefk = 1;
        $errors = [];

        if (isset($_POST['id']) && strlen(trim($_POST['id'])) > 0) {
            $id = Utilita::PULISCISTRINGA($_POST['id']);
        } else {
            $errors[] = 'ID non passato';
        }

        if (isset($_POST['todo']) && strlen(trim($_POST['todo'])) > 0) {
            $todo = Utilita::PULISCISTRINGA($_POST['todo']);
        } else {
            $errors[] = 'Todo non passato';
        }

        if(empty($errors)) {

            if(!TodoEntity::MODIFY($id, $todo)) {
                $errors[] = 'Errore modifica base dati';
            } else {
                Flashmessage::ADD($utentefk, 'todo', 'ok', 'Modificato', 'SUCCESS');
            }
        }

        if(!empty($errors)) {
            foreach($errors as $testo) {
                Flashmessage::ADD($utentefk, 'todo', 'Attenzione', $testo, 'ALERT');
            }
        }

        // Rinvia alla pagina
        header("Location: /todo");
    }

    function get($id) {
        $todo = TodoEntity::ID($id);
        $linkAnnulla = "/todo";
        include("views/todomodify.php");
    }
}

/* -------------------------------------------------
 *                      ENTITY
 * -------------------------------------------------
 */

class UtenteEntity {
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
            $todo = $query->fetch(PDO::FETCH_ASSOC);

        }  catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $todo;
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
}
