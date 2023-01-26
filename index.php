<?php
require_once "StackApi.php";
require_once "utils.php";
require_once "Database.php";

include "Telegram.php";


$telegram = new Telegram($bot_token);

$database = new Database();

$chat_id = $telegram->ChatID();
$name = $telegram->FirstName();
$messages = array();

$received = $telegram->Text();

switch ($received) {
    case '/start':
        array_push($messages, $name . ", welcome to our bot!");
        sendMessagesToChat($telegram, $chat_id, $messages);
        break;
    case '/question':
        array_push($messages, "Write you question...");
        $database->setStatus($chat_id, "question");
        sendMessagesToChat($telegram, $chat_id, $messages);
        break;
    default:
        if ($database->getChatStatus($chat_id) == "question") {
            $questions_message = createQuestionsMessage(Stackapi::getPosts($received));
            array_push($messages, $questions_message);
            sendMessagesToChat($telegram, $chat_id, $messages);
            $database->setStatus($chat_id, "nothing");
            break;
        }
        array_push($messages, "Command not accepted!");
        array_push($messages, "Try again...");
        sendMessagesToChat($telegram, $chat_id, $messages);
        break;
}