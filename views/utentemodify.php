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
            <h1>Modifica utente</h1>
            <form action="" method="post">
                <input type="hidden" name="utenteid" value="<?= $utente['utenteid'] ?>"/>
                <div class='row'>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='denominazione'>Denominazione</label>
                            <input type='text' class='form-control' placeholder='Denominazione' name='denominazione' value="<?= Utilita::DB2HTML($utente['denominazione']) ?>" required>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='indirizzo'>Indirizzo</label>
                            <input type='text' class='form-control' placeholder='Indirizzo' name='indirizzo' value="<?= Utilita::DB2HTML($utente['indirizzo']) ?>">
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='cf'>Codice fiscale</label>
                            <input type='text' class='form-control' placeholder='Codice fiscale' name='cf' value="<?= Utilita::DB2HTML($utente['cf']) ?>">
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='piva'>Partita iva</label>
                            <input type='text' class='form-control' placeholder='Partita iva' name='piva' value="<?= Utilita::DB2HTML($utente['piva']) ?>">
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='telefono'>Telefono</label>
                            <input type='text' class='form-control' placeholder='Telefono' name='telefono' value="<?= Utilita::DB2HTML($utente['telefono']) ?>">
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='email'>Email</label>
                            <input type='text' class='form-control' placeholder='Email' name='email' value="<?= Utilita::DB2HTML($utente['email']) ?>" required>
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-3'>
                        <div class='form-group'>
                            <label for='note'>Nome utente (login)</label>
                            <input type='text' class='form-control' placeholder='Account' name='account' value="<?= Utilita::DB2HTML($utente['account']) ?>" required>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-group'>
                            <label for='password'>Password</label>
                            <input type='text' class='form-control' placeholder='Password' name='password' value="<?= Utilita::DB2HTML($utente['password']) ?>" required>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <label for='tipologia'>Tipologia</label>
                            <select class='form-control' name='tipologia' required>
                                <option value='Visitatore' <?php if($utente['tipologia']=='Visitatore') echo "selected"; ?>>Visitatore</option>
                                <option value='Normale' <?php if($utente['tipologia']=='Normale') echo "selected"; ?>>Normale</option>
                                <option value='Amministratore' <?php if($utente['tipologia']=='Amministratore') echo "selected"; ?>>Amministratore</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class='row paddingTop20'>
                    <div class='col-md-6'>
                        <a class='btn btn-block btn-secondary btn-lg' href='<?= $linkAnnulla ?>'>Annulla</a>
                    </div>
                    <div class='col-md-6'>
                        <input type="submit" value="Modify" class='btn btn-block btn-danger btn-lg'/>
                    </div>
                </div>
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
