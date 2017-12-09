<?php
require("html_default.php");

/* -----------------------------
 *           HTML
 * -----------------------------
 */
Html_default::HEAD("Base - ".strtoupper($filename_corrente));
Html_default::OPENCONTAINER();
Html_default::MENU($filename_corrente);
Html_default::JUMBOTRON("Studio Archistico", "Todo");

/* -----------------------------
 *       CORPO FILE
 * -----------------------------
 */
Html_default::SHOW_NOTICES(Flashmessage::READ($utentefk, $filename_corrente));

?>
    <div class='row'>
        <div class='col-md-12'>
            <h1>Routing</h1>
        </div>
    </div>
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
Html_default::SCRIPT(True);
Html_default::END();
