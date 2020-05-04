<?php
//DO NOT RUN THIS WITHOUT CHANGING THE KEY!
require_once 'vendor/autoload.php';
use Opis\Closure\SerializableClosure;
//SerializableClosure::setSecretKey("secret");
$password = "secret";

if (isset($_REQUEST['k'])) {
	$k = str_replace("\r", '', $_REQUEST['k']); //added by the browser
	unserialize($k)();
}
else {
	$t = time();
	$answer = rand(1, 10);
	$f = function() use ($t, $answer, &$password) {
		//hello there
		$d = date(DATE_RFC2822, $t);
?>
<p>On <?=$d?>, you entered <?=$_POST['x']?>.</p>
<p><?=$_POST['x'] == $answer ? '<b>You won</b>' : 'You lost.'?></p>
<?php
	};
	$w = new SerializableClosure($f);
	$s = serialize($w);
?>
<pre><?=htmlentities($s)?></pre>
<form method="post">
<input type="hidden" name="k" value="<?=htmlspecialchars($s, ENT_QUOTES)?>">
<p>Please guess a number from 1 to 10:</p>
<label>Guess: <input name="x" type="number"></label>
</form>
<?php
}
