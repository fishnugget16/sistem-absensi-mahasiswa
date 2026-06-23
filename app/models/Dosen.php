<?php

class Dosen extends BaseModel {
    
    protected $table = 'dosen';
    
    // Properties (Encapsulation)
    private $id;
    private $user_id;
    private $nidn;
    private $nama;
    private $prodi;
    private $email;
    private $password;
    
    // Constructor
    public function __construct() {
        parent::__construct();
    }
    
    // ==========================================
    // SETTER METHODS
    // ==========================================
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function setUserId($user_id) {
        $this->user_id = $user_id;
        return $this;
    }
    
    public function setNidn($nidn) {
        $this->nidn = htmlspecialchars(trim($nidn));
        return $this;
    }
    
    public function setNama($nama) {
        $this->nama = htmlspecialchars(trim($nama));
        return $this;
    }
    
    public function setProdi($prodi) {
        $this->prodi = htmlspecialchars(trim($prodi));
        return $this;
    }
    
    public function setEmail($email) {
        $this->email = htmlspecialchars(trim($email));
        return $this;
    }
    
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }
    
    // ==========================================
    // GETTER METHODS
    // ==========================================
    
    public function getId() {
        return $this->id;
    }
    
    public function getUserId() {
        return $this->user_id;
    }
    
    public function getNidn() {
        return $this->nidn;
    }
    
    public function getNama() {
        return $this->nama;
    }
    
    public function getProdi() {
        return $this->prodi;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    // ==========================================
    // IMPLEMENTASI ABSTRACT METHOD DARI BaseModel
    // ==========================================
    
    public function validate() {
        $errors = [];
        
        if (empty($this->nidn)) {
            $errors['nidn'] = "NIDN tidak boleh kosong";
        } elseif (strlen($this->nidn) < 8) {
            $errors['nidn'] = "NIDN minimal 8 karakter";
        } elseif (strlen($this->nidn) > 20) {
            $errors['nidn'] = "NIDN maksimal 20 karakter";
        }
        
        if (empty($this->nama)) {
            $errors['nama'] = "Nama tidak boleh kosong";
        } elseif (strlen($this->nama) < 3) {
            $errors['nama'] = "Nama minimal 3 karakter";
        } elseif (strlen($this->nama) > 100) {
            $errors['nama'] = "Nama maksimal 100 karakter";
        }
        
        if (!empty($this->email) && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Format email tidak valid";
        }
        
        return $errors;
    }
    
    public function save() {
        $errors = $this->validate();
        if (!empty($errors)) {
            return ['success' => false, 'message' => 'Validasi gagal', 'errors' => $errors];
        }
        
        try {
            if (isset($this->id) && !empty($this->id)) {
                // UPDATE
                $sql = "UPDATE dosen SET nidn = :nidn, nama = :nama, prodi = :prodi WHERE id = :id";
                $this->db->query($sql);
                $this->db->bind(':nidn', $this->nidn);
                $this->db->bind(':nama', $this->nama);
                $this->db->bind(':prodi', $this->prodi);
                $this->db->bind(':id', $this->id);
                
                if ($this->db->execute()) {
                    return ['success' => true, 'message' => 'Data dosen berhasil diupdate'];
                }
            } else {
                // INSERT
                $sql = "INSERT INTO dosen (nidn, nama, prodi) VALUES (:nidn, :nama, :prodi)";
                $this->db->query($sql);
                $this->db->bind(':nidn', $this->nidn);
                $this->db->bind(':nama', $this->nama);
                $this->db->bind(':prodi', $this->prodi);
                
                if ($this->db->execute()) {
                    $this->id = $this->db->lastInsertId();
                    return ['success' => true, 'message' => 'Data dosen berhasil ditambahkan', 'id' => $this->id];
                }
            }
            
            return ['success' => false, 'message' => 'Gagal menyimpan data dosen'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    // ==========================================
    // ADDITIONAL METHODS (untuk AdminController)
    // ==========================================
    
    /**
     * Ambil semua dosen dengan jumlah mata kuliah yang diampu
     * @return array Daftar dosen dengan matkul_count
     */
    public function getAllDosen() {
        try {
            // Query sederhana tanpa subquery dulu untuk testing
            $sql = "SELECT d.*, u.email, u.username 
                    FROM dosen d
                    LEFT JOIN users u ON d.user_id = u.id
                    ORDER BY d.id DESC";
            $this->db->query($sql);
            $result = $this->db->resultSet();
            
            // Tambahkan matkul_count manual (jika perlu)
            if (!empty($result)) {
                foreach ($result as &$row) {
                    $row['matkul_count'] = $this->countMatkulByDosen($row['id']);
                }
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in getAllDosen: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Ambil semua dosen dengan filter prodi (UNTUK HALAMAN ADMIN)
     * @param string $filter_prodi Filter berdasarkan program studi
     * @return array Daftar dosen dengan matkul_count
     */
    public function getAllWithFilters($filter_prodi = '') {
        try {
            // Query sederhana tanpa subquery dulu untuk testing
            $sql = "SELECT d.*, u.email, u.username 
                    FROM dosen d
                    LEFT JOIN users u ON d.user_id = u.id
                    WHERE 1=1";
            
            $params = [];
            
            if ($filter_prodi != '') {
                $sql .= " AND d.prodi = :prodi";
                $params[':prodi'] = $filter_prodi;
            }
            
            $sql .= " ORDER BY d.nama ASC";
            
            $this->db->query($sql);
            
            foreach ($params as $key => $value) {
                $this->db->bind($key, $value);
            }
            
            $result = $this->db->resultSet();
            
            // Tambahkan matkul_count manual (jika perlu)
            if (!empty($result)) {
                foreach ($result as &$row) {
                    $row['matkul_count'] = $this->countMatkulByDosen($row['id']);
                }
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in getAllWithFilters: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Hitung jumlah mata kuliah yang diampu oleh dosen
     * @param int $dosen_id ID dosen
     * @return int Jumlah mata kuliah
     */
    private function countMatkulByDosen($dosen_id) {
        try {
            $sql = "SELECT COUNT(*) as total FROM mata_kuliah WHERE dosen_id = :dosen_id";
            $this->db->query($sql);
            $this->db->bind(':dosen_id', $dosen_id);
            $result = $this->db->single();
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Ambil data dosen berdasarkan ID
     * @param int $id ID dosen
     * @return array|null Data dosen
     */
    public function getDosenById($id) {
        try {
            $sql = "SELECT d.*, u.email, u.username 
                    FROM dosen d
                    LEFT JOIN users u ON d.user_id = u.id
                    WHERE d.id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            $result = $this->db->single();
            
            if ($result) {
                $result['matkul_count'] = $this->countMatkulByDosen($id);
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in getDosenById: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Ambil dosen berdasarkan NIDN
     * @param string $nidn NIDN dosen
     * @return array|null Data dosen
     */
    public function getDosenByNidn($nidn) {
        try {
            $sql = "SELECT d.*, u.email, u.username 
                    FROM dosen d
                    LEFT JOIN users u ON d.user_id = u.id
                    WHERE d.nidn = :nidn";
            $this->db->query($sql);
            $this->db->bind(':nidn', $nidn);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Error in getDosenByNidn: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Ambil dosen berdasarkan user_id
     * @param int $user_id ID user
     * @return array|null Data dosen
     */
    public function getDosenByUserId($user_id) {
        try {
            $sql = "SELECT d.*, u.email, u.username 
                    FROM dosen d
                    LEFT JOIN users u ON d.user_id = u.id
                    WHERE d.user_id = :user_id";
            $this->db->query($sql);
            $this->db->bind(':user_id', $user_id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Error in getDosenByUserId: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Buat dosen baru
     * @param string $nama Nama dosen
     * @param string $nidn NIDN dosen
     * @param string $prodi Program studi
     * @param string $email Email
     * @param string $password Password
     * @return array Hasil operasi
     */
    public function createDosen($nama, $nidn, $prodi, $email, $password) {
        try {
            // Cek apakah NIDN sudah terdaftar
            $sql = "SELECT COUNT(*) as total FROM dosen WHERE nidn = :nidn";
            $this->db->query($sql);
            $this->db->bind(':nidn', $nidn);
            $result = $this->db->single();
            
            if ($result['total'] > 0) {
                return ['success' => false, 'message' => 'NIDN sudah terdaftar'];
            }
            
            // Cek apakah email sudah terdaftar di users
            $sql = "SELECT COUNT(*) as total FROM users WHERE email = :email";
            $this->db->query($sql);
            $this->db->bind(':email', $email);
            $result = $this->db->single();
            
            if ($result['total'] > 0) {
                return ['success' => false, 'message' => 'Email sudah terdaftar'];
            }
            
            // Default password jika kosong
            if (empty($password)) {
                $password = 'dosen123';
            }
            
            // Validasi password max 8 karakter
            if (strlen($password) > 8) {
                return ['success' => false, 'message' => 'Password maksimal 8 karakter'];
            }
            
            $hashedPassword = md5($password);
            
            // Insert ke tabel users
            $sql = "INSERT INTO users (email, password, role, username) VALUES (:email, :password, 'dosen', :username)";
            $this->db->query($sql);
            $this->db->bind(':email', $email);
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':username', $nama);
            
            if ($this->db->execute()) {
                $userId = $this->db->lastInsertId();
                
                // Insert ke tabel dosen
                $sql = "INSERT INTO dosen (user_id, nidn, nama, prodi) VALUES (:user_id, :nidn, :nama, :prodi)";
                $this->db->query($sql);
                $this->db->bind(':user_id', $userId);
                $this->db->bind(':nidn', $nidn);
                $this->db->bind(':nama', $nama);
                $this->db->bind(':prodi', $prodi);
                
                if ($this->db->execute()) {
                    return ['success' => true, 'message' => 'Dosen berhasil ditambahkan'];
                }
            }
            
            return ['success' => false, 'message' => 'Gagal menambahkan dosen'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    /**
     * Update data dosen
     * @param int $id ID dosen
     * @param string $nama Nama dosen
     * @param string $nidn NIDN dosen
     * @param string $prodi Program studi
     * @param string $email Email
     * @return array Hasil operasi
     */
    public function updateDosen($id, $nama, $nidn, $prodi, $email) {
        try {
            // Cek apakah NIDN sudah dipakai dosen lain
            $sql = "SELECT COUNT(*) as total FROM dosen WHERE nidn = :nidn AND id != :id";
            $this->db->query($sql);
            $this->db->bind(':nidn', $nidn);
            $this->db->bind(':id', $id);
            $result = $this->db->single();
            
            if ($result['total'] > 0) {
                return ['success' => false, 'message' => 'NIDN sudah terdaftar untuk dosen lain'];
            }
            
            // Update tabel dosen
            $sql = "UPDATE dosen SET nidn = :nidn, nama = :nama, prodi = :prodi WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':nidn', $nidn);
            $this->db->bind(':nama', $nama);
            $this->db->bind(':prodi', $prodi);
            $this->db->bind(':id', $id);
            
            if ($this->db->execute()) {
                // Update email di tabel users
                $sql = "SELECT user_id FROM dosen WHERE id = :id";
                $this->db->query($sql);
                $this->db->bind(':id', $id);
                $result = $this->db->single();
                
                if ($result) {
                    $sql = "UPDATE users SET email = :email, username = :nama WHERE id = :user_id";
                    $this->db->query($sql);
                    $this->db->bind(':email', $email);
                    $this->db->bind(':nama', $nama);
                    $this->db->bind(':user_id', $result['user_id']);
                    $this->db->execute();
                }
                
                return ['success' => true, 'message' => 'Data dosen berhasil diupdate'];
            }
            
            return ['success' => false, 'message' => 'Gagal mengupdate dosen'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    /**
     * Hapus dosen
     * @param int $id ID dosen
     * @return array Hasil operasi
     */
    public function deleteDosen($id) {
        try {
            // Ambil user_id dari dosen
            $sql = "SELECT user_id FROM dosen WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            $result = $this->db->single();
            
            if ($result) {
                // Hapus dari tabel users (cascade akan menghapus dosen)
                $sql = "DELETE FROM users WHERE id = :user_id";
                $this->db->query($sql);
                $this->db->bind(':user_id', $result['user_id']);
                
                if ($this->db->execute()) {
                    return ['success' => true, 'message' => 'Dosen berhasil dihapus'];
                }
            }
            
            return ['success' => false, 'message' => 'Gagal menghapus dosen'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    /**
     * Hitung total dosen
     * @return int Jumlah dosen
     */
    public function countDosen() {
        try {
            $sql = "SELECT COUNT(*) as total FROM dosen";
            $this->db->query($sql);
            $result = $this->db->single();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Cari dosen berdasarkan keyword
     * @param string $keyword Keyword pencarian
     * @return array Hasil pencarian
     */
    public function searchDosen($keyword) {
        try {
            $sql = "SELECT d.*, u.email 
                    FROM dosen d
                    LEFT JOIN users u ON d.user_id = u.id
                    WHERE d.nama LIKE :keyword 
                       OR d.nidn LIKE :keyword 
                       OR d.prodi LIKE :keyword
                    ORDER BY d.nama ASC";
            $this->db->query($sql);
            $this->db->bind(':keyword', "%$keyword%");
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in searchDosen: " . $e->getMessage());
            return [];
        }
    }
}