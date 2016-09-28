<?php
include("vendor/autoload.php");

$conv = new Conversion\VerificareTVA\Connect("API KEY");
print_r($conv->check("RO123456"));