<?php

class Router {
    protected $controller = 'AuthController'; // Controller default jika URL kosong
    protected $method = 'index';             // Fungsi default jika URL kosong
    protected $params = [];

    public function __construct() {
        $url = $this->parseURL();

        // 1. Cek apakah ada file Controller yang sesuai di folder controllers
        if (!empty($url) && file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        // 2. Panggil file controller-nya
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 3. Cek apakah ada fungsi (method) yang dipanggil di dalam controller tersebut
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 4. Kelola parameter jika ada sisa URL
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // 5. Jalankan controller & method, serta kirimkan params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Fungsi untuk membersihkan dan memecah URL menjadi array
    public function parseURL() {
        
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
        
            // DEBUG: Hapus komentar untuk cek
            // echo "<pre>URL: "; print_r($url); echo "</pre>";
        
            return $url;
        }

        // Membaca URL dari server bawaan PHP maupun Apache (.htaccess)
        $url = $_GET['url'] ?? $_SERVER['PATH_INFO'] ?? '';
        if ($url) {
            $url = trim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
