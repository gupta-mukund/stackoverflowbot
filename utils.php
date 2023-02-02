<?php
$bot_token = "5917169168:AAHkK-7ocybD11gqylwtvu0WZ8aPxSgoHBg";
$orange_diamond = "&#128310;";
$blue_diamond = "&#128311;";

function sendMessagesToChat($bot_connection, $client_id, $data)
{
    foreach ($data as $msg) {
        $content = array("chat_id" => $client_id, "text" => $msg, 'parse_mode' => "HTML");
        $bot_connection->sendMessage($content);
    }
}

function createQuestionsMessage($data)
{
    global $orange_diamond, $blue_diamond;
    $result = "";
    if (count($data) == 0) {
        return "No questions";
    }
    foreach ($data as $single) {
        $result = $result . $orange_diamond;
        $result = $result . " Q: " . $single->{"title"};
        $result = $result . "\n";
        $result = $result . $blue_diamond . " votes: " . $single->{"score"} . ", answers: " . $single->{"answer_count"} . "\n";
        $result = $result . substr(strip_tags(html_entity_decode($single->{"body"})), 0, 300) . " ...\n";
        $result = $result . "/question_" . $single->{"question_id"};
        $result = $result . "\n\n";
    }
    return strip_tags($result);
}

function createSingleQuestionMessage($data)
{
    $result = "";
    foreach ($data as $single) {
        $result = $result . "Q " . $single->{"title"} . "\n";
        $result = $result . html_entity_decode($single->{"body"});
    }
    return strip_tags($result);
}

function createAllAnswersMessage($data)
{
    $result = "";
    if (count($data) == 0) {
        return "No answers!";
    }
    foreach ($data as $single) {
        $result = $result . "/answer_" . $single->{"answer_id"} . "\n";
    }

    return strip_tags($result);
}

function createSingleAnswerMessage($data)
{
    $result = "";
    if (count($data) == 0) {
        return "Wrong answer id";
    }
    $result = $result . html_entity_decode($data[0]->{"body"});

    return strip_tags($result);
}