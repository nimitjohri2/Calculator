<?php
require_once ('./class/DataAccessLayer.php');

//$_POST['first'] = 5;
//$_POST['operator'] = 4;
//$_POST['second'] = 10;

$answer = 0;
$equation = '';

switch ($_POST['operator'])
{
    case '1':
        $equation = $_POST['first'] . ' ' . '+' . ' ' . $_POST['second'] . ' = ' . (intval($_POST['first']) + intval($_POST['second']));
        $answer = (intval($_POST['first']) + intval($_POST['second']));
        break;
    case '2':
        $equation = $_POST['first'] . ' ' . '-' . ' ' . $_POST['second'] . ' = ' . (intval($_POST['first']) - intval($_POST['second']));
        $answer = (intval($_POST['first']) - intval($_POST['second']));
        break;
    case '3':
        $equation = $_POST['first'] . ' ' . '*' . ' ' . $_POST['second'] . ' = ' . (intval($_POST['first']) * intval($_POST['second']));
        $answer = (intval($_POST['first']) * intval($_POST['second']));
        break;
    case '4':
        $equation = $_POST['first'] . ' ' . '/' . ' ' . $_POST['second'] . ' = ' . (intval($_POST['first']) / intval($_POST['second']));
        $answer = (intval($_POST['first']) / intval($_POST['second']));
        break;
}

$dal = new DataAccessLayer() ;
$inserted = $dal->Log($equation);

$status = 0;
if ($inserted)
{
    $dal->Maintainence();

    $status = 1;
}
else
    $status = 0;

echo json_encode(array(
    'status' => $status,
    'answer' => $answer
));