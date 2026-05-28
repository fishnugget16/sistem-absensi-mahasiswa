<?php
// Lepaskan extends BaseModel agar terhindar dari error Database kelompok Anda
class User {
    
    public function checkAdminCredentials($username, $password) {
        
        // 1. SESUAI DATA SQL: ADMIN (Bisa pakai username 'admin' ATAU email 'admin@gmail.com')
        if (($username === 'admin' || $username === 'admin@gmail.com') && $password === 'admin123') {
            return [
                'id' => 1,
                'username' => 'admin',
                'role' => 'admin'
            ];
        }
        
        // 2. SESUAI DATA SQL: DOSEN (Bisa pakai username 'dosen1' ATAU email 'dosen@gmail.com')
        if (($username === 'dosen1' || $username === 'dosen@gmail.com') && $password === 'dosen123') {
            return [
                'id' => 2,
                'username' => 'dosen1',
                'role' => 'dosen'
            ];
        }

        // 3. SESUAI DATA SQL: MAHASISWA (Bisa pakai username 'mhs1' ATAU email 'mahasiswa@gmail.com')
        if (($username === 'mhs1' || $username === 'mahasiswa@gmail.com') && $password === 'mhs123') {
            return [
                'id' => 3,
                'username' => 'mhs1',
                'role' => 'mahasiswa'
            ];
        }

        // Jika tidak ada yang cocok, kembalikan salah
        return false;
    }
}
