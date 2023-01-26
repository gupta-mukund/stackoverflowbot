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

switch ($telegram->Text()) {
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
            $all_posts = Stackapi::getPosts($telegram->Text());
            array_push($messages, "arrivato");
            sendMessagesToChat($telegram, $chat_id, $messages);
            break;
        }
        array_push($messages, "Command not accepted!");
        array_push($messages, "Try again...");
        sendMessagesToChat($telegram, $chat_id, $messages);
        break;
}

$messages = array();

// $all_posts = Stackapi::getPosts("firebase");


// foreach ($all_posts as $post) {
//     echo $post->{"title"};
//     echo "<br>";
//     echo $post->{"question_id"};
//     echo "<br>";
//     echo $post->{"answer_count"};
//     echo "<br>";
//     echo $post->{"score"};
//     echo "<br>";
// }