<?php
require_once ('./class/DataAccessLayer.php');

$dal = new DataAccessLayer();

$feed = $dal->Update();

echo json_encode($feed, JSON_FORCE_OBJECT);
