<?php
// outputs the username that owns the running php/ht
$output = shell_exec('ls -lart');
echo "<pre>$output</pre>";
?>
