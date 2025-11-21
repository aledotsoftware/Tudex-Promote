<?php
$dbPath = __DIR__ . '/../database/database.sqlite';
if (!file_exists($dbPath)) {
    echo "Database file not found: $dbPath\n";
    exit(1);
}
$db = new SQLite3($dbPath);
$row = $db->querySingle("select * from ad_zones where id=4", true);
if ($row) {
    echo "FOUND ad_zone:\n";
    print_r($row);
    exit(0);
}
$s = $db->querySingle("select id from sites where id=3", true);
if (! $s) {
    echo "SITE_NOT_FOUND\n";
    exit(1);
}
$ok = $db->exec("INSERT INTO ad_zones (id,site_id,name,width,height,type,created_at,updated_at) VALUES (4,3,'auto-test',NULL,NULL,'banner',datetime('now'),datetime('now'))");
if ($ok) echo "INSERTED ad_zone id=4\n";
else echo "INSERT FAILED: " . $db->lastErrorMsg() . "\n";
