<?php
if ($argc < 2) { echo "Usage: php show_table.php table_name\n"; exit(1);} 
$table = $argv[1];
$db=new SQLite3(__DIR__.'/../database/database.sqlite');
$res=$db->query("PRAGMA table_info($table)");
if (!$res) { echo "table $table not found\n"; exit(1);} 
while($r=$res->fetchArray(SQLITE3_ASSOC)) print_r($r);
