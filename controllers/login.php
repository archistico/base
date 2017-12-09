<?php

class Login {
    function get() {
        // Creo il formid per questa sessione
        $csrfname = "login:csrf";
        $_SESSION[$csrfname] = md5(rand(0,10000000));

        include("views/login.php");
    }

    function post() {
        $csrfname = "login:csrf";
        $errors = [];

        if(isset($_POST['email'], $_POST['password']) && (isset($_POST[$csrfname]) && isset($_SESSION[$csrfname]) && $_POST[$csrfname] == $_SESSION[$csrfname])) {
            // cancello il CSRF
            $_SESSION[$csrfname] = '';

            // VALIDARE I DATI
            if (empty($_POST['password'])) {
                $errors[] = 'La password non può essere vuota';
            } else {
                $password = Utilita::PULISCISTRINGA($_POST['password']);
            }
            if (empty($_POST['email'])) {
                $errors[] = 'Email non passata';
            } else {
                $email = Utilita::PULISCISTRINGA($_POST['email']);
            }
            // CONTROLLA SU DB SE: EMAIL E PASSWORD CORRISPONDONO
            if(empty($errors)) {
                if(Utente::Check_email_password($email, $password)) {
                    $utente = Utente::FIND_BY_EMAIL($email);
                    if(isset($_COOKIE[GLOBAL_COOKIENAME])) {
                        unset($_COOKIE[GLOBAL_COOKIENAME]);
                        setcookie(GLOBAL_COOKIENAME, null, -1, '/');
                        sleep(1);
                    }
                    if(!isset($_COOKIE[GLOBAL_COOKIENAME])) {
                        $value = md5(rand(0,10000000));
                        setcookie(GLOBAL_COOKIENAME, $value, time()+86400);
                        
                        // NUOVO GESTIONE PER DB
                        $accesso = new Accesso();
                        $accesso->cookiename = $value;
                        $accesso->utentefk = $utente->utenteid;
                        $accesso->utenteruolo= $utente->getRuolo()->descrizione;
                        $accesso->setNow();
                        $accesso->ip = Utilita::GET_CLIENT_IP();
                        $accesso->errore = '-';

                        $accesso->Insert();
                    }
                    Utilita::REDIRECT('index.php');
                    exit();
                } else {
                    $errors[] = 'Password non corretta';
                    // INSERISCO UN ACCESSO FALLATO
                    // NUOVO GESTIONE PER DB
                    $accesso = new Accesso();
                    $accesso->cookiename = 'Non impostato';
                    $accesso->utentefk = -1;
                    $accesso->utenteruolo= "-";
                    $accesso->setNow();
                    $accesso->ip = Utilita::GET_CLIENT_IP();
                    $accesso->errore = $email;

                    $accesso->Insert();
                }
            }

        } else {
            $errors[] = 'Valori passati non corretti';
            // cancello il CSRF
            $_SESSION[$csrfname] = '';
        }

        if(!empty($errors)) {
            foreach($errors as $testo) {
                Flashmessage::ADD('guest', 'login', 'Attenzione', $testo, 'ALERT');
            }
        }

        // Rinvia alla pagina
        //header("Location: /login");

    } // FINE POST
}