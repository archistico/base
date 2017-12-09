<?php
require("html_default.php");

$filename_corrente = File::FILENAME(__FILE__);

/* -----------------------------
 *           LOGGIN
 * -----------------------------
 */
// Autaut::CHECK_CREDENTIAL(['Amministrazione','Lavoratore','Cliente']);
// POSSO ACCEDERE ALLA RISORSA
// $utentefk = Autaut::LOGGATO();
$utentefk = 1;
$csrfname = $filename_corrente.":".$utentefk.":csrf";

/* -----------------------------
 *           HTML
 * -----------------------------
 */
Html_default::HEAD("Base - ".strtoupper($filename_corrente));
Html_default::OPENCONTAINER();
Html_default::MENU($filename_corrente);
Html_default::JUMBOTRON("Studio Archistico", "Utente");

/* -----------------------------
 *       CORPO FILE
 * -----------------------------
 */
Html_default::SHOW_NOTICES(Flashmessage::READ($utentefk, $filename_corrente));

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
