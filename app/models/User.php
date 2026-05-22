<?php

class User {
    // Fungsi simulasi mencocokkan username & password admin
    public function checkAdminCredentials($username, $password) {
        $adminDummyUsername = 'admin';
        $adminDummyPassword = 'password123';

        if ($username === $adminDummyUsername && $password === $adminDummyPassword) {
            return [
                'id' => 1,
                'username' => 'admin'
            ];
        }
        return false;
    }
}
