<?php
require_once "StackApi.php";
require_once "utils.php";

//$questions_message = createQuestionsMessage(Stackapi::getPosts("firebase"));
$all_answers = createAllAnswersMessage(Stackapi::getAllAnswers("75050946"));
echo $all_answers;