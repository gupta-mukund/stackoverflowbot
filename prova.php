<?php
require_once "StackApi.php";
require_once "utils.php";

$questions_message = createQuestionsMessage(Stackapi::getPosts("firebase"));
echo $questions_message;