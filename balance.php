<?php

require_once('functions.php');

$bitcoin = GetBitcoin();

if (count($argv) != 2) {
    print("Missing address as first argument.\n");
    exit(1);
}

$unspent = getUnspent($bitcoin, $argv[1]);

printf("Current balance for %s is %.5f.\n", $argv[1], $unspent);

