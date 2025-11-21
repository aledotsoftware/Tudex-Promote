<?php
$db=new SQLite3(__DIR__.'/../database/database.sqlite');
$res=$db->query('PRAGMA table_info(ad_zones)');
while($r=$res->fetchArray(SQLITE3_ASSOC)) print_r($r);
echo "\n";
$res2=$db->query('PRAGMA table_info(creatives)');
if ($res2) while($r=$res2->fetchArray(SQLITE3_ASSOC)) print_r($r);
else echo "no creatives table\n";
