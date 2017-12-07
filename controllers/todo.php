<?php

class Todo {
    function get() {
        $todos = TodoEntity::List();
        include("views/todo.php");
    }
}

/* -------------------------------------------------
 *                      ADD
 * -------------------------------------------------
 */

class TodoAdd {
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

class TodoDelete {
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
        $elemento = "Cancellare ".$todo['id'].": ".$todo['descrizione']." ?";
        $linkAnnulla = "/todo";
        $linkAzione = "/todo";

        include("views/tododelete.php");
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
            $query->bindValue(':descrizione', $todo, PDO::PARAM_STR);
            $result = $query->execute();

        }  catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
        
        return $result;
    }

    public static function List() {
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
}
