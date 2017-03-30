<?php
header("Content-Type: application/json");

echo $_GET['callback'] . '(' . json_encode($markers) . ')';
?>