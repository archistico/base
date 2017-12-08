<?php
require("html_default.php");

$filename_corrente = File::FILENAME(__FILE__);
$basename_corrente = File::BASENAME(__FILE__);

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
Html_default::MENU($basename_corrente);
Html_default::JUMBOTRON("Studio Archistico", "Todo");

/* -----------------------------
 *       CORPO FILE
 * -----------------------------
 */
Html_default::SHOW_NOTICES(Flashmessage::READ($utentefk, $filename_corrente));

?>
    <div class='box-body'>
    <div class='row'>
        <div class='col-md-12'>
            <h1>Modifica</h1>
        </div>
    </div>
    <form action="" method="post">
        <div class='row paddingTop20'>
            <div class='col-md-12'>
                <input type="hidden" name="id" value="<?= $todo['id'] ?>"/>
                <textarea class="form-control" name="todo"><?= $todo['descrizione'] ?></textarea><br/>
            </div>
        </div>

        <div class='row'>
            <div class='col-md-6'>
                <a class='btn btn-block btn-secondary btn-lg' href='<?= $linkAnnulla ?>'>Annulla</a>
            </div>
            <div class='col-md-6'>
                <input type="submit" value="Modify" class='btn btn-block btn-danger btn-lg'/>
            </div>
        </div>
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
Html_default::SCRIPT(True);
Html_default::END();
