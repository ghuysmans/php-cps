<?php
//DO NOT RUN THIS WITHOUT CHANGING THE KEY!
require_once 'vendor/autoload.php';
use Opis\Closure\SerializableClosure;
//SerializableClosure::setSecretKey("secret");

function dump($l) {
	?><ul><?php foreach ($l as $x) {?><li><?=$x?></li><?php }?></ul><?php
}

function step($cur, $cont) {
	$w = new SerializableClosure(function () use ($cur, $cont) {
		if (empty($_POST['x']))
			$cont($cur);
		else {
			$cur[] = $_POST['x'];
			step($cur, $cont);
		}
	});
	$s = serialize($w);
?>
<p>Here's the continuation closure encoded in a hidden form input:</p>
<pre><?=htmlentities($s)?></pre>
<form method="post">
<input type="hidden" name="k" value="<?=htmlspecialchars($s, ENT_QUOTES)?>">
<p>Please don't run your own code.</p>
<?php //dump($cur); ?>
<label>
	Write something, or an empty string to stop:
	<input name="x" autofocus>
</label>
</form>
<?php
}


if (isset($_REQUEST['k'])) {
	$k = str_replace("\r", '', $_REQUEST['k']); //added by the browser
	unserialize($k)();
}
else
	step(array(), function($l) {
		?><p>Here's what you've just entered:</p><?php
		dump($l);
	});
