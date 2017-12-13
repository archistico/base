<?php 

/* ----------------------------------------
 *           CONTROLLER GENERICO
 * ----------------------------------------
*/

class Controller {
    public $classe;

    function __construct($nomeclasse) {
        
        $this->classe = $nomeclasse;

        RouteHook::add("before_handler", function() {
            // Before
            if(!is_null($this->classe)) {
                /* ----------------------------------------
                 *      AUTENTICAZIONE / AUTORIZZAZIONE
                 * ----------------------------------------
                 */
                
                Autaut::CHECK_CREDENTIAL(Routes::getInstance()->Load()->getCredential($this->classe));
        
                /* ----------------------------------------
                 *   FINE AUTENTICAZIONE / AUTORIZZAZIONE
                 * ----------------------------------------
                */
            } else {
                echo "<h1>Pagina senza autenticazione </h1>";
            }
        });

        RouteHook::add("after_request", function() {
            // After
        });
    }
}