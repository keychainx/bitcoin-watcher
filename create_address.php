<?php

require_once('functions.php');

$bitcoin = GetBitcoin();

$address = $bitcoin->getnewaddress("", "p2sh-segwit");
$priv_address = $bitcoin->dumpprivkey($address);

printf("Address: %s\n", $address);
printf("Private: %s\n", $priv_address);

