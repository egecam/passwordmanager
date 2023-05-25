<?php
// Encryption key (must be a 16, 24, or 32 bytes string)
$encryptionKey = 'your_encryption_key';

// Variable to encrypt
$data = 'Hello, World!';

// Encrypt the data
$encryptedData = openssl_encrypt($data, 'AES-256-CBC', $encryptionKey, 0, substr(hash('sha256', $encryptionKey), 0, 16));

echo 'Encrypted data: ' . $encryptedData . '<br>';

// Decrypt the data
$decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $encryptionKey, 0, substr(hash('sha256', $encryptionKey), 0, 16));

echo 'Decrypted data: ' . $decryptedData;
?>