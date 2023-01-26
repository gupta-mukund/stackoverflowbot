<?php
$bot_token = "5917169168:AAHkK-7ocybD11gqylwtvu0WZ8aPxSgoHBg";

function sendMessagesToChat($bot_connection, $client_id, $data)
{
    foreach ($data as $msg) {
        $content = array("chat_id" => $client_id, "text" => $msg);
        $bot_connection->sendMessage($content);
    }
}