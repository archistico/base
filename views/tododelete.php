<?php
require("html_default.php");

/* -----------------------------
 *           HTML
 * -----------------------------
 */
Html_default::HEAD("Base - ".strtoupper(File::FILENAME(__FILE__)));
Html_default::OPENCONTAINER();
Html_default::MENU(File::FILENAME(__FILE__));
Html_default::JUMBOTRON("Studio Archistico", "Todo");

/* -----------------------------
 *       CORPO FILE
 * -----------------------------
 */
Html_default::SHOW_NOTICES(Flashmessage::READ(Autaut::LOGGATO(), File::FILENAME(__FILE__)));

?>
    <div class='box-body'>
    <div class='row'>
        <div class='col-md-12'>
            <h1><?= $messaggio ?></h1>
            <h6><?= $elemento ?></h6>
        </div>
    </div>
    <div class='row paddingTop20'>
        <div class='col-md-6'>
            <a class='btn btn-block btn-secondary btn-lg' href='<?= $linkAnnulla ?>'>Annulla</a>
        </div>
        <div class='col-md-6'>
        <form action="" method="post">
        <input type="hidden" name="id" value="<?= $id ?>"/>
        <input type="submit" value="Delete" class='btn btn-block btn-danger btn-lg'/>
        </form>
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
