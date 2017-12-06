<?php
require("html_default.php");

$filename_corrente = File::FILENAME(__FILE__);
$basename_corrente = File::BASENAME(__FILE__);

/* -----------------------------
 *           HTML
 * -----------------------------
 */
Html_default::HEAD("Base - ".strtoupper($filename_corrente));
Html_default::OPENCONTAINER();
Html_default::MENU($basename_corrente);
Html_default::JUMBOTRON("Studio Archistico", "Base");

/* -----------------------------
 *       CORPO FILE
 * -----------------------------
 */
?>
<div class='row'>
<div class='col-md-12'>

<strong>Queue Size:</strong> <span id="size"><?= $stats['size']; ?></span> | 
<strong>Total Sends:</strong> <span id="sends"><?= $stats['sends']; ?></span> |
<strong>Total Receives:</strong> <span id="receives"><?= $stats['receives']; ?></span><br/>

<hr />

<h2>Send</h2>
<form action="./send" method="post">
<div class='form-group'>
<textarea class="form-control" name="payload"></textarea><br/>
<input class="form-control" type="number" name="secondo"></input><br/>
<input type="submit" value="Send" class='btn btn-block btn-lg'/>
<div>
</form>

<hr />

<h2>Receive</h2>
<div id="payload"></div><br/>
<input type="submit" value="Receive" onclick="receive(); return false;"  class='btn btn-block btn-lg'/>

</div>
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
function update() {
  $.get("./stats", function(b) {
    $('#size').html(b.size);
    $('#sends').html(b.sends);
    $('#receives').html(b.receives);
  });
}

function receive() {
  $.get("./receive", function(a) {
    $('#payload').html(a.payload);
    update();
  });
}
</script>


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

