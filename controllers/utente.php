<?php

class Utente {
    function get() {
        $utenti = UtenteEntity::Lista();
        include("views/utente.php");
    }
}

/* -------------------------------------------------
 *                      ADD
 * -------------------------------------------------
 */

class UtenteAdd {
    function post() {
        $utentefk = 1;
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
                Flashmessage::ADD($utentefk, 'todo', 'ok', 'Aggiunto', 'SUCCESS');
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

            if(!TodoEntity::DELETE($id)) {
                $errors[] = 'Errore inserimento nella base dati';
            } else {
                Flashmessage::ADD($utentefk, 'todo', 'ok', 'cancellato', 'SUCCESS');
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

        $messaggio = "Attenzione";
        $elemento = "Cancellare #".$todo['id'].": ".Utilita::DB2HTML($todo['descrizione'])." ?";
        $linkAnnulla = "/todo";
        $linkAzione = "/todo";

        include("views/tododelete.php");
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

            $query = MySQL::getInstance()->query("SELECT * FROM utente ORDER BY denominazione ASC");
            $lista = $query->fetchAll();

        }  catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $lista;
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
