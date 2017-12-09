<?php

class Login {
    function get() {
        // Creo il formid per questa sessione
        $filename_corrente = File::FILENAME(__FILE__);
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
                if(UtenteEntity::Check_email_password($email, $password)) {
                    $utente = UtenteEntity::FIND_BY_EMAIL($email);
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
                        $accesso->utentetipologia= $utente->tipologia;
                        $accesso->setNow();
                        $accesso->ip = Utilita::GET_CLIENT_IP();
                        $accesso->errore = '-';

                        $accesso->Add();
                    }
                    Utilita::REDIRECT('/');
                } else {
                    $errors[] = 'Password non corretta';

                    // INSERISCO UN ACCESSO FALLATO
                    $accesso = new Accesso();
                    $accesso->cookiename = 'Non impostato';
                    $accesso->utentefk = -1;
                    $accesso->utentetipologia = "-";
                    $accesso->setNow();
                    $accesso->ip = Utilita::GET_CLIENT_IP();
                    $accesso->errore = $email;

                    $accesso->Add();
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
        Utilita::REDIRECT('/login');

    } // FINE POST
}