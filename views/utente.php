<?php
require("html_default.php");

/* -----------------------------
 *           HTML
 * -----------------------------
 */
Html_default::HEAD("Base - ".strtoupper(File::FILENAME(__FILE__)));
Html_default::OPENCONTAINER();
Html_default::MENU(File::FILENAME(__FILE__));
Html_default::JUMBOTRON("Studio Archistico", "Utente");

/* -----------------------------
 *       CORPO FILE
 * -----------------------------
 */
Html_default::SHOW_NOTICES(Flashmessage::READ(Autaut::LOGGATO(), File::FILENAME(__FILE__)));

?>
    <div class='row'>
        <div class='col-md-12'>
            <h1>Nuovo utente</h1>
            <form action="" method="post">
                <div class='row'>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='denominazione'>Denominazione</label>
                            <input type='text' class='form-control' placeholder='Denominazione' name='denominazione' required>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='indirizzo'>Indirizzo</label>
                            <input type='text' class='form-control' placeholder='Indirizzo' name='indirizzo' value='-'>
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='cf'>Codice fiscale</label>
                            <input type='text' class='form-control' placeholder='Codice fiscale' name='cf' value='-'>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='piva'>Partita iva</label>
                            <input type='text' class='form-control' placeholder='Partita iva' name='piva' value='-'>
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='telefono'>Telefono</label>
                            <input type='text' class='form-control' placeholder='Telefono' name='telefono' value='-'>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='email'>Email</label>
                            <input type='text' class='form-control' placeholder='Email' name='email' required>
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-3'>
                        <div class='form-group'>
                            <label for='note'>Nome utente (login)</label>
                            <input type='text' class='form-control' placeholder='Account' name='account' required>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'>
                            <label for='password'>Password</label>
                            <input type='text' class='form-control' placeholder='Password' name='password' required>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='tipologia'>Tipologia</label>
                            <select class='form-control' name='tipologia' required>
                                <option value='Visitatore'>Visitatore</option>
                                <option value='Normale'>Normale</option>
                                <option value='Amministratore'>Amministratore</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class='row paddingTop20'>
                    <div class='col-md-12'>
                        <input type="submit" value="REGISTRA" class='btn btn-block btn-lg btn-success'>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class='row paddingTop20'>
        <div class='col-md-12'>
            <h1>Lista utenti</h1>
            <table class='table table-bordered'>
                <thead>
                <tr>
                    <th>Denominazione</th>
                    <th class='d-none d-md-table-cell'>Email</th>
                    <th class='d-none d-md-table-cell'>Tipologia</th>
                    <th class="tdicon"> </th>
                    <th class="tdicon"> </th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach($utenti as $el) {
                    $id = $el['utenteid'];
                    $denominazione = Utilita::DB2HTML($el['denominazione']);
                    $email = Utilita::DB2HTML($el['email']);
                    $tipologia = Utilita::DB2HTML($el['tipologia']);
                    ?>
                    <tr>
                        <td><?= $denominazione ?></td>
                        <td><?= $email ?></td>
                        <td><?= $tipologia ?></td>
                        <td class="tdicon"><a class="btn btn-warning" href='/utente/modify/<?= $id ?>'><i class='fa fa fa-pencil fa-lg' aria-hidden='true'></i></a></td>
                        <td class="tdicon"><a class="btn btn-danger" href='/utente/delete/<?= $id ?>'><i class='fa fa fa-trash fa-lg' aria-hidden='true'></i></a></td>
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
