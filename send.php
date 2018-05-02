<?php

require_once('functions.php');

$bitcoin = GetBitcoin();

if (count($argv) != 3) {
    print("Usage: address amount.\n");
    printf("Ex: %s 2MvCypYEL9ThcUNwkJRfhwt9sdFD9VyxN3C 0.1\n", $argv[0]);
    exit(1);
}

$address = $argv[1];
$amount = $argv[2];

$txid = $bitcoin->sendtoaddress(
    $address,
    $amount
);

printf("Transaction sent: %s\n", $txid);

/* Sample:
$ php send.php 2MvCypYEL9ThcUNwkJRfhwt9sdFD9VyxN3C 0.1
Transaction sent: ab7f35a3152a1909d44158baba6e9a23abe76da2f0add3c1b0d158a9a39b9017
 */
