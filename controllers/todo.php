<?php

class Todo {
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

        Autaut::CHECK_CREDENTIAL(['Amministratore','Normale', 'Visitatore']);

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

        Autaut::CHECK_CREDENTIAL(['Amministratore','Normale', 'Visitatore']);

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

        Autaut::CHECK_CREDENTIAL(['Amministratore','Normale', 'Visitatore']);

        /* ----------------------------------------
         *   FINE AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */

        $todo = TodoEntity::ID($id);
        $linkAnnulla = "/todo";
        include("views/todomodify.php");
    }
}

/* -------------------------------------------------
 *                      ENTITY
 * -------------------------------------------------
 */

class TodoEntity {
    public static function Add($todo) {
        $result = false;
        try {

            $query = MySQL::getInstance()->prepare("INSERT INTO todo (descrizione) VALUES (:descrizione)");
            $query->bindValue(':descrizione', Utilita::HTML2DB($todo), PDO::PARAM_STR);
            $result = $query->execute();

        }  catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $result;
    }

    public static function Lista() {
        try {

            $query = MySQL::getInstance()->query("SELECT id, descrizione FROM todo ORDER BY id ASC");
            $todos = $query->fetchAll();

        }  catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $todos;
    }

    public static function ID($id) {
        try {

            $query = MySQL::getInstance()->prepare("SELECT id, descrizione FROM todo WHERE id = :id");
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

            $query = MySQL::getInstance()->prepare("DELETE FROM todo WHERE id = :id");
            $query->bindValue(':id', $id, PDO::PARAM_STR);
            $result = $query->execute();

        }  catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $result;
    }

    public static function MODIFY($id,$todo) {
        $result = false;
        try {

            $query = MySQL::getInstance()->prepare("UPDATE todo SET descrizione = :descrizione WHERE id = :id");
            $query->bindValue(':id', $id, PDO::PARAM_STR);
            $query->bindValue(':descrizione', Utilita::HTML2DB($todo), PDO::PARAM_STR);
            $result = $query->execute();

        }  catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $result;
    }
}
