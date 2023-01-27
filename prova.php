<?php
require_once "StackApi.php";
require_once "utils.php";

echo substr("/answer_73894934793", 8);

//$questions_message = createQuestionsMessage(Stackapi::getPosts("firebase"));
//$all_answers = createAllAnswersMessage(Stackapi::getAllAnswers("75050946"));
$answer = StackApi::getSingleAnswer("73742790");
echo htmlentities($answer[0]->{"body"});