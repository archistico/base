<?php

class Todo {
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

        $todos = TodoEntity::Lista();
        include("views/todo.php");
    }
}

/* -------------------------------------------------
 *                      ADD
 * -------------------------------------------------
 */

class TodoAdd {
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

        if (isset($_POST['todo']) && strlen(trim($_POST['todo'])) > 0) {
            $todo = Utilita::PULISCISTRINGA($_POST['todo']);
        } else {
            $errors[] = 'Todo non passato';
        }

        if(empty($errors)) {

            if(!TodoEntity::Add($todo)) {
                $errors[] = 'Errore inserimento nella base dati';
            } else {
                Flashmessage::ADD(Autaut::LOGGATO(), 'todo', 'ok', 'Aggiunto', 'SUCCESS');
            }
        }

        if(!empty($errors)) {
            foreach($errors as $testo) {
                Flashmessage::ADD(Autaut::LOGGATO(), 'todo', 'Attenzione', $testo, 'ALERT');
            }
        }

        // Rinvia alla pagina
        header("Location: /todo");
    }
}

/* -------------------------------------------------
 *                      DELETE
 * -------------------------------------------------
 */

class TodoDelete {
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

            if(!TodoEntity::DELETE($id)) {
                $errors[] = 'Errore inserimento nella base dati';
            } else {
                Flashmessage::ADD(Autaut::LOGGATO(), 'todo', 'ok', 'cancellato', 'SUCCESS');
            }
        }

        if(!empty($errors)) {
            foreach($errors as $testo) {
                Flashmessage::ADD(Autaut::LOGGATO(), 'todo', 'Attenzione', $testo, 'ALERT');
            }
        }

        // Rinvia alla pagina
        header("Location: /todo");
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


        $todo = TodoEntity::ID($id);

        $messaggio = "Attenzione";
        $elemento = "Cancellare #".$todo['id'].": ".Utilita::DB2HTML($todo['descrizione'])." ?";
        $linkAnnulla = "/todo";

        include("views/tododelete.php");
    }
}

/* -------------------------------------------------
 *                      MODIFY
 * -------------------------------------------------
 */

class TodoModify {
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

        if (isset($_POST['todo']) && strlen(trim($_POST['todo'])) > 0) {
            $todo = Utilita::PULISCISTRINGA($_POST['todo']);
        } else {
            $errors[] = 'Todo non passato';
        }

        if(empty($errors)) {

            if(!TodoEntity::MODIFY($id, $todo)) {
                $errors[] = 'Errore modifica base dati';
            } else {
                Flashmessage::ADD(Autaut::LOGGATO(), 'todo', 'ok', 'Modificato', 'SUCCESS');
            }
        }

        if(!empty($errors)) {
            foreach($errors as $testo) {
                Flashmessage::ADD(Autaut::LOGGATO(), 'todo', 'Attenzione', $testo, 'ALERT');
            }
        }

        // Rinvia alla pagina
        header("Location: /todo");
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

        $todo = TodoEntity::ID($id);
        $linkAnnulla = "/todo";
        include("views/todomodify.php");
    }
}

