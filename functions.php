<?php

require_once('bitcoin.php');

function get_configuration() {
    $config_file = __DIR__ . "/config.ini";
    if (!file_exists($config_file)) {
        print("Configuration file doesn't exist.\n");
        exit(1);
    }

    $config = parse_ini_file($config_file, true);
    if (!$config) {
        print("Could not parse the ini file.\n");
        exit(1);
    }

    return $config;
}

function GetBitcoin() {
    $config = get_configuration();

    return new Bitcoin(
        $config['rpc']['user'],
        $config['rpc']['pass'],
        $config['rpc']['host'],
        $config['rpc']['port']
    );
}

function getUnspent($bitcoin, $address, $minconf = 6, $maxconf = 999999)
{
    $amount = 0.0;

    $unspent = $bitcoin->listunspent(
        $minconf,
        $maxconf,
        array($address)
    );

    foreach($unspent as $utxo) {
        $amount += $utxo['amount'];
    }

    return $amount;
}

