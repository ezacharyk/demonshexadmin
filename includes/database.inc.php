<?php
/*
 * This file includes a require for MDB2 and connects to the database
 */
require_once 'MDB2.php';
$dsn = 'mysql://demonshex:demonshexdbpass@localhost/demonshex';
$options = array(
    'debug' => 2,
    'result_buffering' => false,
);

$db = MDB2::factory($dsn, $options);
if (MDB2::isError($db)) {
    die($db->getMessage());
}
$db->loadModule('Extended');
$db->setFetchMode(MDB2_FETCHMODE_ASSOC);

?>