Bitcoin PHP Module
==================

## Files

There are several files in this repository:

* bitcoin.php: Main bitcoin library. Will be used to connect to bitcoin's RPC;
* functions.php: Wrapper of bitcoin library, with config & other useful functions;
* watcher.php: The watcher/notify script;
* balance.php: A sample script to get balance of an address;
* create_address.php: A sample script to create an address.

## Set up

Configure the module by settings the ini file:

```shell
cp config.ini.sample config.ini
```

You need to edit the config.ini to setup the RPC connexion.

```ini
[rpc]
user=rpc
pass=G_ItwBtmLExGnuobxYzUuJGNhsSxl-6gv9pIF69xHEs=
host=127.0.0.1
port=18332
```

## Trying out

This projects comes in 3 parts:

* The library (bitcoin.php & functions.php);
* A few scripts to handle the on-the-fly operations (address creation, get balance);
* The watcher program, started by bitcoind when a new transaciton arrives.

This goal is the following:

* We create a few addresses using create_address.php. Address is stored in the
  bitcoin's wallet.  We can create a lot of addresses. The script will return both
  the public & private keys.
* When a new transaction involving an address in the wallet arrives, bitcoind
  (which is configured to notify for transactions, see below), will launch
  another php script in which it will read information and store it in a file.
  You can use a database instead.

### Get balance

```shell
php balance.php 2NGKp9JsCG3k2dGjjWtgJCgQ4urtXc1gdo6
Current balance for 2NGKp9JsCG3k2dGjjWtgJCgQ4urtXc1gdo6 is 1.93996.
```

### Configure bitcoind to use the watcher.php script.

Add the following line to bitcoin.conf:

```conf
walletnotify=/usr/bin/php /home/mycroft/dev/bitcoin-php/watcher.php %s
```

Then, restart bitcoind.

When a new transaction will arrive for one of its address, it will call the
watcher.php script, that will retrieve transaction notified and then write in
/tmp/notifications the received information.

Each time a new TX is received or confirmed, it will call the script and write the following in the file:

On reception:

```
[{"tx_id":"837e756f2c9a9970683fad89089e9ef8385591476b9450989a7e944c2c162140","tx_vout":0,"blockhash":null,"category":"receive","amount":0.25,"address":"2N38NMtmbav4rPXBoHdvDq9LRrUVjeDzgjF","confirmations":0,"unconfirmed":0,"confirmed":0.5}]
```

On confirmation:

```
[{"tx_id":"837e756f2c9a9970683fad89089e9ef8385591476b9450989a7e944c2c162140","tx_vout":0,"blockhash":"000000000000025cfb79f04150c7b182fa29f2fed9c42e4314f4cb49bc182fbc","category":"receive","amount":0.25,"address":"2N38NMtmbav4rPXBoHdvDq9LRrUVjeDzgjF","confirmations":1,"unconfirmed":0.25,"confirmed":0.5}]
```

