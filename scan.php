<?php

require_once("./Scanner.php");

$basePath = "./"; 
$scanner = new Scanner( $basePath );
$hashes = $scanner->scan();
$date = date("h_i_s-d_M_Y");

$scanner->Save( "_scan_result/scan_$date.dat", [ "files"=>$hashes, "basepath"=>$basePath, "date"=>$date ] );


