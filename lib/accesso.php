<?php
/* --------------------------------------
 *           CLASS ACCESSI
 * --------------------------------------
 */

class Accesso {
    public $accessoid;  // int

    public $cookiename; // string
    public $utentefk;   // int
    public $utentetipologia;// string

    public $data;       // timestamp
    public $ip;         // text

    public $errore;       // string

    // Tengo anche la classe
    public $utente;     // utente

    public function getData2DB() {
        return $this->data->format('Y-m-d H:i:s');
    }

    public function setNow() {
        $dtz = new DateTimeZone("Europe/Rome"); //Your timezone
        $now = new DateTime(date("Y-m-d H:i:s"), $dtz);

        $this->data = $now;
    }

    public function Add() {
        // Aggiungi alla base dati
        $result = false;

        try {

            $query = MySQL::getInstance()->prepare("INSERT INTO accesso (cookiename, utentefk, utentetipologia, data, ip, errore) VALUES(:cookiename, :utentefk, :utentetipologia, :data, :ip, :errore)");
            $query->bindValue(':cookiename', $this->cookiename, PDO::PARAM_STR);
            $query->bindValue(':utentefk', $this->utentefk, PDO::PARAM_STR);
            $query->bindValue(':utentetipologia', Utilita::HTML2DB($this->utentetipologia), PDO::PARAM_STR);
            $query->bindValue(':data', $this->getData2DB(), PDO::PARAM_STR);
            $query->bindValue(':ip', Utilita::HTML2DB($this->ip), PDO::PARAM_STR);
            $query->bindValue(':errore', Utilita::HTML2DB($this->errore), PDO::PARAM_STR);
            $result = $query->execute();

        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $result;
    }

    public function Update($data) {
        // Modifica in base al cookiename

    }

    /* -------- FUNZIONI STATICHE ----------*/
    public static function EXIST($cookiename, $ip) {
        $exist = false;

        try {
            // trova la data di ieri
            $oggi = new DateTime();
            $ieri = $oggi->sub( new DateInterval('P1D') )->format('Y-m-d H:i:s');

            $query = MySQL::getInstance()->prepare("SELECT * FROM accesso WHERE cookiename = :cookiename AND ip=:ip AND data >:ieri");
            $query->bindValue(':cookiename', $cookiename, PDO::PARAM_STR);
            $query->bindValue(':ip', $ip, PDO::PARAM_STR);
            $query->bindValue(':ieri', $ieri, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetchAll();

            if(count($result)>0) {
                $exist = true;
            }
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        return $exist;
    }

    public static function TIPOLOGIA($cookiename, $ip) {
        try {
            // trova la data di ieri
            $oggi = new DateTime();
            $ieri = $oggi->sub( new DateInterval('P1D') )->format('Y-m-d H:i:s');

            $query = MySQL::getInstance()->prepare("SELECT * FROM accesso WHERE cookiename = :cookiename AND ip=:ip AND data >:ieri");
            $query->bindValue(':cookiename', $cookiename, PDO::PARAM_STR);
            $query->bindValue(':ip', $ip, PDO::PARAM_STR);
            $query->bindValue(':ieri', $ieri, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetchAll();

            return Utilita::DB2HTML($result[0]['utentetipologia']);

        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
    }

    public static function UTENTEFK($cookiename, $ip) {
        try {
            // trova la data di ieri
            $oggi = new DateTime();
            $ieri = $oggi->sub( new DateInterval('P1D') )->format('Y-m-d H:i:s');

            $query = MySQL::getInstance()->prepare("SELECT * FROM accesso WHERE cookiename = :cookiename AND ip=:ip AND data >:ieri");
            $query->bindValue(':cookiename', $cookiename, PDO::PARAM_STR);
            $query->bindValue(':ip', $ip, PDO::PARAM_STR);
            $query->bindValue(':ieri', $ieri, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetchAll();

            return Utilita::DB2HTML($result[0]['utentefk']);

        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
    }

}