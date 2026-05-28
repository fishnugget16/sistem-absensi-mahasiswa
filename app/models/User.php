<?php

class User {
    
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Cek kredensial login dari database
     * Email: bebas (nama@domain.kampus.ac.id)
     * Password: maksimal 8 karakter
     */
    public function checkAdminCredentials($email, $password) {
        
        // Validasi password maksimal 8 karakter
        if (strlen($password) > 8) {
            return false;
        }
        
        // Cari user berdasarkan email
        $sql = "SELECT * FROM users WHERE email = :email";
        $this->db->query($sql);
        $this->db->bind(':email', $email);
        $user = $this->db->single();
        
        if ($user) {
            // Verifikasi password (MD5 karena password max 8 karakter)
            if (md5($password) === $user['password']) {
                // Jika role mahasiswa, ambil data NIM dari tabel mahasiswa
                $nim = null;
                if ($user['role'] === 'mahasiswa') {
                    $sql2 = "SELECT nim FROM mahasiswa WHERE user_id = :user_id";
                    $this->db->query($sql2);
                    $this->db->bind(':user_id', $user['id']);
                    $mahasiswa = $this->db->single();
                    $nim = $mahasiswa['nim'] ?? null;
                }
                
                // Jika role dosen, ambil data NIDN dari tabel dosen
                $nidn = null;
                if ($user['role'] === 'dosen') {
                    $sql2 = "SELECT nidn FROM dosen WHERE user_id = :user_id";
                    $this->db->query($sql2);
                    $this->db->bind(':user_id', $user['id']);
                    $dosen = $this->db->single();
                    $nidn = $dosen['nidn'] ?? null;
                }
                
                return [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'nama' => $user['nama'],
                    'nim' => $nim,
                    'nidn' => $nidn
                ];
            }
        }
        
        return false;
    }
    
    /**
     * Registrasi user baru
     * Email: bebas (nama@domain.kampus.ac.id)
     * Password: maksimal 8 karakter
     */
    public function register($email, $password, $nama, $role, $nim = null, $nidn = null) {
        
        // Validasi password maksimal 8 karakter
        if (strlen($password) > 8) {
            return ['success' => false, 'message' => 'Password maksimal 8 karakter'];
        }
        
        if (strlen($password) < 4) {
            return ['success' => false, 'message' => 'Password minimal 4 karakter'];
        }
        
        // Validasi email sudah terdaftar
        $sql = "SELECT COUNT(*) as total FROM users WHERE email = :email";
        $this->db->query($sql);
        $this->db->bind(':email', $email);
        $result = $this->db->single();
        
        if ($result['total'] > 0) {
            return ['success' => false, 'message' => 'Email sudah terdaftar'];
        }
        
        // Simpan user baru
        $hashedPassword = md5($password);
        
        $sql = "INSERT INTO users (email, password, role, nama) VALUES (:email, :password, :role, :nama)";
        $this->db->query($sql);
        $this->db->bind(':email', $email);
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':role', $role);
        $this->db->bind(':nama', $nama);
        
        if ($this->db->execute()) {
            $userId = $this->db->lastInsertId();
            
            // Jika role mahasiswa, buat entri di tabel mahasiswa
            if ($role === 'mahasiswa') {
                // Generate NIM otomatis jika tidak diberikan
                $defaultNim = $nim ?: 'NIM' . $userId . date('y');
                $this->createMahasiswaRecord($userId, $defaultNim);
            }
            
            // Jika role dosen, buat entri di tabel dosen
            if ($role === 'dosen') {
                $defaultNidn = $nidn ?: 'DSN' . $userId;
                $this->createDosenRecord($userId, $defaultNidn);
            }
            
            return ['success' => true, 'message' => 'Registrasi berhasil'];
        }
        
        return ['success' => false, 'message' => 'Registrasi gagal'];
    }
    
    /**
     * Buat record mahasiswa setelah registrasi
     */
    private function createMahasiswaRecord($userId, $nim) {
        $sql = "INSERT INTO mahasiswa (user_id, nim) VALUES (:user_id, :nim)";
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':nim', $nim);
        $this->db->execute();
    }
    
    /**
     * Buat record dosen setelah registrasi
     */
    private function createDosenRecord($userId, $nidn) {
        $sql = "INSERT INTO dosen (user_id, nidn) VALUES (:user_id, :nidn)";
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':nidn', $nidn);
        $this->db->execute();
    }
    
    /**
     * Ambil role dari email berdasarkan domain
     */
    public function getRoleFromEmail($email) {
        if (strpos($email, '@mhs.kampus.ac.id') !== false) {
            return 'mahasiswa';
        }
        if (strpos($email, '@dsn.kampus.ac.id') !== false) {
            return 'dosen';
        }
        if (strpos($email, '@admin.kampus.ac.id') !== false) {
            return 'admin';
        }
        return null;
    }
    
    /**
     * Validasi format email (domain harus sesuai)
     */
    public function validateEmailFormat($email) {
        $role = $this->getRoleFromEmail($email);
        return $role !== null;
    }
    
    /**
     * Ambil semua user
     */
    public function getAllUsers() {
        $sql = "SELECT id, email, role, nama, created_at FROM users ORDER BY id ASC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }
    
    /**
     * Ambil user berdasarkan email
     */
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $this->db->query($sql);
        $this->db->bind(':email', $email);
        return $this->db->single();
    }
    
    /**
     * Ambil user berdasarkan ID
     */
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    /**
     * Ambil data mahasiswa berdasarkan user_id
     */
    public function getMahasiswaByUserId($userId) {
        $sql = "SELECT * FROM mahasiswa WHERE user_id = :user_id";
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }
    
    /**
     * Ambil data dosen berdasarkan user_id
     */
    public function getDosenByUserId($userId) {
        $sql = "SELECT * FROM dosen WHERE user_id = :user_id";
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }
    
    /**
     * Update password user
     */
    public function updatePassword($email, $newPassword) {
        if (strlen($newPassword) > 8) {
            return ['success' => false, 'message' => 'Password maksimal 8 karakter'];
        }
        
        if (strlen($newPassword) < 4) {
            return ['success' => false, 'message' => 'Password minimal 4 karakter'];
        }
        
        $hashedPassword = md5($newPassword);
        
        $sql = "UPDATE users SET password = :password WHERE email = :email";
        $this->db->query($sql);
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':email', $email);
        
        if ($this->db->execute()) {
            return ['success' => true, 'message' => 'Password berhasil diubah'];
        }
        
        return ['success' => false, 'message' => 'Gagal mengubah password'];
    }
    
    /**
     * Hapus user
     */
    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    /**
     * Hitung total user
     */
    public function getTotalUsers() {
        $sql = "SELECT COUNT(*) as total FROM users";
        $this->db->query($sql);
        $result = $this->db->single();
        return $result['total'];
    }
    
    /**
     * Hitung user berdasarkan role
     */
    public function getUserCountByRole($role) {
        $sql = "SELECT COUNT(*) as total FROM users WHERE role = :role";
        $this->db->query($sql);
        $this->db->bind(':role', $role);
        $result = $this->db->single();
        return $result['total'];
    }
}