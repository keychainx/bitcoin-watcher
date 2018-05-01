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

## Tryint out

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

Each time a new TX is received or confirmed, it will call the script
