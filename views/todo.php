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
    <div class='row'>
        <div class='col-md-12'>
            <h1>New todo</h1>
            <form action="/todoadd" method="post">
                <div class='form-group'>
                    <input type="text" class="form-control" name="todo"><br/>
                    <input type="submit" value="Send" class='btn btn-block btn-lg btn-success'>
                </div>
            </form>
        </div>
    </div>

    <div class='row'>
        <div class='col-md-12'>
            <h1>List todo</h1>
            <table id='tabella' class='table table-bordered table-hover'>
                <thead>
                <tr>
                    <th class="tdicon">#</th>
                    <th>Todo</th>
                    <th class="tdicon">Mod.</th>
                    <th class="tdicon">Canc.</th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach($todos as $todo) {
                    $id = $todo['id'];
                    $descrizione = Utilita::DB2HTML($todo['descrizione']);
                    ?>
                    <tr>
                        <td class="tdicon"><?= $id ?></td>
                        <td><?= $descrizione ?></td>
                        <td class="tdicon"><a class="btn btn-warning" href='/todo/modify/<?= $id ?>'><i class='fa fa fa-pencil fa-lg' aria-hidden='true'></i></a></td>
                        <td class="tdicon"><a class="btn btn-danger" href='/todo/delete/<?= $id ?>'><i class='fa fa fa-trash fa-lg' aria-hidden='true'></i></a></td>
                    </tr>
                    <?php
                }
                ?>

                </tbody>
            </table>
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
