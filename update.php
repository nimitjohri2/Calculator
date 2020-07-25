<?php
require_once ('./class/DataAccessLayer.php');

//Creating DataAccessLayer object
$dal = new DataAccessLayer();

//Request DAL for live uppdates
$feed = $dal->Update();

//prepare response
echo json_encode($feed, JSON_FORCE_OBJECT);
