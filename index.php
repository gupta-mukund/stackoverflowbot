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
    case '/end':
        break;
    default:
        if (substr($received, 0, 10) == "/question_") {
            $id = substr($received, 10);
            $question = createSingleQuestionMessage(Stackapi::singleQuestion($id));
            $all_answers = createAllAnswersMessage(Stackapi::getAllAnswers($id));
            array_push($messages, $question);
            array_push($messages, $all_answers);
            sendMessagesToChat($telegram, $chat_id, $messages);
            break;
        }
        if (substr($received, 0, 8) == "/answer_") {
            $id = substr($received, 8);
            $answer = createSingleAnswerMessage(StackApi::getSingleAnswer($id));
            array_push($messages, $answer);
            sendMessagesToChat($telegram, $chat_id, $messages);
            break;
        }
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