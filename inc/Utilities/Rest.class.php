<?php

class Rest
{
    public static function call($method, $callData = [])
    {
        $requestHeader = ['requesttype' => $method];

        $data = array_merge($requestHeader, $callData);

        $options = [
            'http' => [
                'header' => 'Content-type: application/json',
                'method' => $method,
                'content' => json_encode($data),
            ],
        ];

        $context = stream_context_create($options);

        $result = file_get_contents(API_URL, false, $context);

        return json_decode($result);
    }
}
