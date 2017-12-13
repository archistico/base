<?php

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
    