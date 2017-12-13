<?php

class Utente {
    function get() {

        /* ----------------------------------------
         *      AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */
        Autaut::CHECK_CREDENTIAL(Routes::getInstance()->Load()->getCredential(get_class()));

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
        Autaut::CHECK_CREDENTIAL(Routes::getInstance()->Load()->getCredential(get_class()));

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
        Autaut::CHECK_CREDENTIAL(Routes::getInstance()->Load()->getCredential(get_class()));

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
        Autaut::CHECK_CREDENTIAL(Routes::getInstance()->Load()->getCredential(get_class()));

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
        Autaut::CHECK_CREDENTIAL(Routes::getInstance()->Load()->getCredential(get_class()));

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
        Autaut::CHECK_CREDENTIAL(Routes::getInstance()->Load()->getCredential(get_class()));

        /* ----------------------------------------
         *   FINE AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */

        $utente = UtenteEntity::ID($id);
        $linkAnnulla = "/utente";
        include("views/utentemodify.php");
    }
}

