<?php 

/* ----------------------------------------
 *           CONTROLLER GENERICO
 * ----------------------------------------
*/

class Controller {
    function __construct() {
        RouteHook::add("before_handler", function() {
            // Before
        });

        RouteHook::add("after_request", function() {
            // After
        });
    }
}