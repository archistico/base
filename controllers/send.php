<?php

class Send {
    function post() {
        if (isset($_POST['payload']) && strlen(trim($_POST['payload'])) > 0) {
            send_payload($_POST['payload'].$_POST['secondo']);
        }
        header("Location: /");
    }
}