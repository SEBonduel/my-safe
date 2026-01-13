<?php

use PHPUnit\Framework\TestCase;
use App\Utils\Crypto;

class CryptoTest extends TestCase {

    // On utilise une clé hexadécimale de 32 octets pour les tests
    private string $key;

    protected function setUp(): void {
        // '1234...' répété pour faire 32 octets (64 hex)
        $this->key =
        hex2bin("000102030405060708090a0b0c0d0e0f000102030405060708090a0b0c0d0e0f");
    }

    public function testEncryptionReturnsJson() {
        $message = "Mon Secret";
        $encrypted = Crypto::encrypt($message, $this->key);

        // Vérifie que ça ressemble à du JSON
        $this->assertJson($encrypted);
        // Vérifie que ça contient les champs nécessaires
        $this->assertStringContainsString('ciphertext', $encrypted);
        $this->assertStringContainsString('iv', $encrypted);
    }
 
    public function testDecryptionWorks() {
        $original = "Mot de passe très secret";

        // Chiffrement
        $encrypted = Crypto::encrypt($original, $this->key);

        // Déchiffrement
        $decrypted = Crypto::decrypt($encrypted, $this->key);

        // Assert : Le déchiffré doit être égal à l'original
        $this->assertEquals($original, $decrypted);
    }
}