<?php

/*
create table job(id int unsigned auto_increment primary key, job TEXT);
 */

$db = new PDO('mysql:host=172.17.0.2;dbname=mysql;charset=utf8', 'root', 'pass');

$stmt = $db->prepare("INSERT INTO job(job) VALUES(:job)");

$job = array(
    'type' => 'send',
    'address' => '2MvCypYEL9ThcUNwkJRfhwt9sdFD9VyxN3C',
    'amount' => 1.0
);
$job_str = json_encode($job);

$stmt->bindParam(':job', $job_str);
$stmt->execute();

echo "Done";


