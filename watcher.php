<?php

require_once('functions.php');

if (count($argv) != 2) {
    print("Missing TXID as first argument.\n");
    exit(1);
}

$txid = $argv[1];

$bitcoin = GetBitcoin();
$tx = $bitcoin->gettransaction($txid);
if (!$tx) {
    print("Invalid transaction.\n");
    exit(1);
}

$details = array();

foreach($tx['details'] as $tx_details) {
    $address = $tx_details['address'];
    $balance_unconfirmed = getUnspent($bitcoin, $address, 1, 5);
    $balance_confirmed = getUnspent($bitcoin, $address, 6, 999999);

    $details[] = array(
        'tx_id' =>    $txid,
        'tx_vout' =>  $tx_details['vout'],
        'blockhash' => $tx['blockhash'],
        'category' => $tx_details['category'],
        'amount' =>   $tx_details['amount'],
        'address' =>  $tx_details['address'],
        'confirmations' => $tx['confirmations'],
        'unconfirmed' => $balance_unconfirmed,
        'confirmed' => $balance_confirmed
    );
}

// Write in database.
// XXX

$fd = fopen('/tmp/notifications', 'a+');
fprintf($fd, json_encode($details) . "\n");
fclose($fd);
