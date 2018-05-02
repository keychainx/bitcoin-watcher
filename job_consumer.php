<?php

/*
create table job(id int unsigned auto_increment primary key, job TEXT);
 */

$db = new PDO('mysql:host=172.17.0.2;dbname=mysql;charset=utf8', 'root', 'pass');

$stmt = $db->prepare("SELECT id, job FROM job ORDER BY ID ASC LIMIT 1;");
$deletion_stmt = $db->prepare("DELETE FROM job WHERE id = :id");

if ($stmt->execute()) {
    while ($row = $stmt->fetch()) {
        printf("Found job #%d\n", $row['id']);
        $job = json_decode($row['job']);
        print_r($job);

        // Do the job
        // XXX

        // Remove the job from the queue
        $deletion_stmt->execute(array("id" => $row['id']));
    }
}




