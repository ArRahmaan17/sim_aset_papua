<?php

// Menentukan jalur ke autoload.php di direktori vendor Laravel
$autoloadPath = __DIR__.'/../vendor/autoload.php';

// Memeriksa apakah autoload.php ada dan dapat dimuat
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
} else {
    // Tindakan yang perlu diambil jika autoload.php tidak ditemukan
    echo 'File autoload.php tidak ditemukan.';
    // Misalnya, Anda dapat memunculkan pesan kesalahan atau tindakan lain yang sesuai.
}
