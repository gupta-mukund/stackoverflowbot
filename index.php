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
        $options = [
            [
                $telegram->buildInlineKeyboardButton("Answers", $url = "jjso")
            ]
        ];

        $kb = $telegram->buildInlineKeyBoard($options, $onetime = true);


        $content = array('chat_id' => $chat_id, 'reply_markup' => $kb, 'text' => "This is a Keyboard Test");
        $telegram->sendMessage($content);
        // array_push($messages, $name . ", welcome to our bot!");
        // sendMessagesToChat($telegram, $chat_id, $messages);
        break;
    case '/question':
        array_push($messages, "Write you question...");
        $database->setStatus($chat_id, "question");
        sendMessagesToChat($telegram, $chat_id, $messages);
        break;
    default:
        if (substr($received, 0, 10) == "/question_") {
            $question = createSingleQuestionMessage(Stackapi::singleQuestion(substr($received, 10)));
            array_push($messages, $question);
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