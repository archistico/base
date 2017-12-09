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
            $database = new db();
            $database->query('INSERT INTO accesso (cookiename, utentefk, utentetipologia, data, ip, errore) VALUES(:cookiename, :utentefk, :utentetipologia, :data, :ip, :errore)');
            $database->bind(':cookiename', $this->cookiename);
            $database->bind(':utentefk', $this->utentefk);
            $database->bind(':utentetipologia', Utilita::HTML2DB($this->utentetipologia));
            $database->bind(':data', $this->getData2DB());
            $database->bind(':ip', Utilita::HTML2DB($this->ip));
            $database->bind(':errore', Utilita::HTML2DB($this->errore));

            $result = $database->execute();
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        // chiude il database
        $database = NULL;

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

            $database = new db();
            $database->query('SELECT * FROM accesso WHERE cookiename = :cookiename AND ip=:ip AND data >:ieri');
            $database->bind(':cookiename', $cookiename);
            $database->bind(':ip', $ip);
            $database->bind(':ieri', $ieri);
            $database->execute();
            if($database->rowCount()>0) {
                $exist = true;
            }
        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }

        // chiude il database
        $database = NULL;

        return $exist;
    }

    public static function TIPOLOGIA($cookiename, $ip) {
        try {
            // trova la data di ieri
            $oggi = new DateTime();
            $ieri = $oggi->sub( new DateInterval('P1D') )->format('Y-m-d H:i:s');

            $database = new db();
            $database->query('SELECT * FROM accesso WHERE cookiename = :cookiename AND ip=:ip AND data >:ieri');
            $database->bind(':cookiename', $cookiename);
            $database->bind(':ip', $ip);
            $database->bind(':ieri', $ieri);
            $row = $database->single();

            return Utilita::DB2HTML($row['utentetipologia']);

        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
    }

    public static function UTENTEFK($cookiename, $ip) {
        try {
            // trova la data di ieri
            $oggi = new DateTime();
            $ieri = $oggi->sub( new DateInterval('P1D') )->format('Y-m-d H:i:s');

            $database = new db();
            $database->query('SELECT * FROM accesso WHERE cookiename = :cookiename AND ip=:ip AND data >:ieri');
            $database->bind(':cookiename', $cookiename);
            $database->bind(':ip', $ip);
            $database->bind(':ieri', $ieri);
            $row = $database->single();

            return Utilita::DB2HTML($row['utentefk']);

        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
    }

}

/* --------------------------------------
 *           CLASS ACCESSI
 * --------------------------------------
 */

class Accessi
{
    public $accessi;

    public function __construct()
    {
        $this->accessi = [];
    }

    public function Add($obj)
    {
        $this->accessi[] = $obj;
    }

    public function getAccessi()
    {
        return $this->accessi;
    }

    public function loadAll()
    {
        try {
            $database = new db();
            $database->query('SELECT * FROM accesso');
            $rows = $database->resultset();

            foreach ($rows as $row) {
                $t = new Accesso();
                /*
                $t->fatturaid = $row['fatturaid'];
                $t->setDataDB($row['data']);
                $t->progettofk = $row['progettofk'];
                $t->progetto = Progetto::DB_FIND_BY_ID($row['progettofk']);
                $t->oggetto = Utilita::DB2HTML($row['oggetto']);
                */
                $this->Add($t);
            }

        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
    }
}