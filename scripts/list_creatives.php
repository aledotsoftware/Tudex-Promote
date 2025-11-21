<?php
$dbPath = __DIR__.'/../database/database.sqlite';
$db = new SQLite3($dbPath);
$res = $db->query('select id, campaign_id, width, height, file_url, click_url from creatives limit 50');
while ($r = $res->fetchArray(SQLITE3_ASSOC)) {
    print_r($r);
}
