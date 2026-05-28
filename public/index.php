<?php
// 1. Jalankan session aplikasi jika belum berjalan
if (!session_id()) {
    session_start();
}


// Ubah baris ini (hapus kata app/)
require_once '../config/config.php'; 

// Baris sisanya biarkan tetap seperti ini
require_once '../app/core/Router.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Database.php';


// 4. Jalankan sistem pengatur jalur (Router)
$router = new Router();
