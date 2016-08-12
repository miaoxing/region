<?php

use Wei\Db;

require 'vendor/miaoxing/plugin/tests/bootstrap.php';

$wei = wei();

loadTable($wei->appDb, 'regions');
loadTable($wei->appDb, 'areas');

function loadTable(Db $db, $table) {
    $result = $db->fetch("SHOW TABLES LIKE ?", $table);
    if (!$result) {
        $db->executeUpdate(file_get_contents('docs/' . $table . '.sql'));
    }
}