<?php

namespace App\Models;

class VideoChatManager 
{
    public static function authentication($apiKey, $apiSec, $peerId, $duration = 1200) {
        if (empty($apiKey))
            return VIDEOCHAT_ERROR_API_KEY;
        if (empty($apiSec))
            return VIDEOCHAT_ERROR_API_SEC;
        if (empty($peerId))
            return VIDEOCHAT_ERROR_PEER_ID;

        $timestamp = time();
        $authToken = self::calculateAuthToken($apiKey, $apiSec, $peerId, $timestamp, $duration);

        $returnJSON = array(
            'timestamp' => $timestamp,
            'ttl' => $duration,
            'authToken' => $authToken,
            'peerId' => $peerId
        );

        return $returnJSON;
    }

    public static function calculateAuthToken($apiKey, $apiSec, $peerId, $timestamp, $duration) {
        $message = "$timestamp:" . $duration . ":$peerId";
        return base64_encode(hash_hmac('sha256', $message, $apiSec, true));
    }

    public static function generatePeerId()
    {
        $length = 16;

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
