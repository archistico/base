<?php

class Send {
    function post() {
        $utentefk = 1;

        if (isset($_POST['payload']) && strlen(trim($_POST['payload'])) > 0) {
            send_payload($_POST['payload'].$_POST['secondo']);
            Flashmessage::ADD(1, 'dashboard', 'ok', 'messaggio', 'SUCCESS');
        }

        header("Location: /");
    }
}