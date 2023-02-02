<?php

require_once "StackApi.php";
require_once "utils.php";

$data = Stackapi::getPosts("How to center a div");
var_dump($data);
echo "<h1>Ciao</h1>";
$res = createQuestionsMessage($data);
var_dump($res);