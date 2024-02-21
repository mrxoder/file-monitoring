<?php

require_once("./Scanner.php");


$scanner = new Scanner();
$hashes = $scanner->scan();
$scanner->Save( "scan_".time().".dat", $hashes );