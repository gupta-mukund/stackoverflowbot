<?php

class Stackapi
{
    private static $GET_POSTS_URL = "https://api.stackexchange.com/search/advanced?pagesize=7&page=1&site=stackoverflow.com&filter=withbody&q=";
    private static $GET_ANSWERS_URL = "https://api.stackexchange.com/2.3/questions/{id}/answers?order=desc&sort=activity&site=stackoverflow";
    private static $GET_SINGLE_ANSWERS_POST_URL = "https://api.stackexchange.com/2.3/answers/{id}?site=stackoverflow&filter=withbody";

    private static $GET_SINGLE_QUESTION = "https://api.stackexchange.com/2.3/questions/{id}?site=stackoverflow&filter=withbody";

    private static function get_json($url)
    {
        $url = str_replace(' ', '%20', $url);
        $ch = curl_init();

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url, CURLOPT_HEADER => 0, CURLOPT_RETURNTRANSFER => 1, CURLOPT_ENCODING => 'gzip'
        ));
        $data = curl_exec($ch);
        $resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($resultCode == 200) {
            return json_decode($data);
        } else {
            return false;
        }
    }

    public static function getPosts($text)
    {
        return self::get_json(self::$GET_POSTS_URL . $text)->{"items"};
    }

    public static function getAllAnswers($question_id)
    {
        $res = str_replace("{id}", strval($question_id), self::$GET_ANSWERS_URL);
        return self::get_json($res)->{"items"};
    }
    public static function getSingleAnswer($answer_id)
    {
        $res = str_replace("{id}", strval($answer_id), self::$GET_SINGLE_ANSWERS_POST_URL);
        return self::get_json($res)->{"items"};
    }

    public static function singleQuestion($question_id)
    {
        $res = str_replace("{id}", strval($question_id), self::$GET_SINGLE_QUESTION);
        return self::get_json($res)->{"items"};
    }
}