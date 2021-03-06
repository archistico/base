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
            <h1>Modifica</h1>
        </div>
    </div>
    <form action="" method="post">
        <div class='row paddingTop20'>
            <div class='col-md-12'>
                <input type="hidden" name="id" value="<?= $todo['id'] ?>"/>
                <input type="text" class="form-control" name="todo" value="<?= Utilita::DB2HTML($todo['descrizione']) ?>" /><br/>
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
