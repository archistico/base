<?php
require("html_default.php");

/* -----------------------------
 *           HTML
 * -----------------------------
 */
Html_default::HEAD("Base - ".strtoupper($filename_corrente), true);
Html_default::OPENCONTAINER();

/* -----------------------------
 *       CORPO FILE
 * -----------------------------
 */
Html_default::SHOW_NOTICES(Flashmessage::READ('guest', $filename_corrente));

?>
    <form class='form-signin' name='login_form' id='login_form' onsubmit='DoSubmit();' method='post'>
        <h2 class='form-signin-heading'>Login</h2>
        <label for='email' class='sr-only'>Email</label>
        <input type='email' id='email' name='email' class='form-control' placeholder='Email address' required autofocus>
        <label for='p' class='sr-only'>Password</label>
        <input type='password' id='password_chiaro' name='password_chiaro' class='form-control' placeholder='Password' required>
        <input type='hidden' name='<?= $csrfname ?>' value='<?= htmlspecialchars($_SESSION[$csrfname]) ?>'>
        <button class='btn btn-lg btn-primary btn-block' type='submit'>ENTRA</button>
    </form>

<?php
/* -----------------------------
 *      FINE CORPO FILE
 * -----------------------------
 */


/* -----------------------------
 *      FINE HTML
 * -----------------------------
 */
Html_default::CLOSECONTAINER();
Html_default::SCRIPT(True, false, false, true);
Html_default::END();
