<?php

namespace App\Utils;

use RuntimeException;

class Crypto
{
    public static function encrypt(string $message, string $key): string
    {
        $iv = random_bytes(16);

        $ciphertext = openssl_encrypt(
            $message,
            'aes-256-cbc',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($ciphertext === false) {
            throw new RuntimeException('Encryption failed');
        }

        $json = json_encode([
            'ciphertext' => base64_encode($ciphertext),
            'iv' => base64_encode($iv),
        ]);

        if ($json === false) {
            throw new RuntimeException('JSON encoding failed');
        }

        return $json;
    }

    public static function decrypt(string $json, string $key): string
    {
        $data = json_decode($json, true);

        if (!is_array($data) || !isset($data['ciphertext'], $data['iv'])) {
            throw new RuntimeException('Invalid encrypted payload');
        }

        $ciphertext = base64_decode($data['ciphertext'], true);
        $iv = base64_decode($data['iv'], true);

        $plaintext = openssl_decrypt(
            $ciphertext,
            'aes-256-cbc',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($plaintext === false) {
            throw new RuntimeException('Decryption failed');
        }

        return $plaintext;
    }
}
