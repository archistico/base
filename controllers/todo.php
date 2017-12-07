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
                Flashmessage::ADD($utentefk, 'todo', 'ok', 'messaggio', 'SUCCESS');
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
}
