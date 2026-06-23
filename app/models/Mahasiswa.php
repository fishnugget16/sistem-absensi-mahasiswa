<?php

class Mahasiswa extends BaseModel {
    
    protected $table = 'mahasiswa';
    
    // Properties (Encapsulation)
    private $id;
    private $user_id;
    private $nim;
    private $nama;
    private $prodi;
    private $angkatan;
    private $kelas;
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
    
    public function setNim($nim) {
        $this->nim = htmlspecialchars(trim($nim));
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
    
    public function setAngkatan($angkatan) {
        $this->angkatan = $angkatan;
        return $this;
    }
    
    public function setKelas($kelas) {
        $this->kelas = htmlspecialchars(trim($kelas));
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
    
    public function getNim() {
        return $this->nim;
    }
    
    public function getNama() {
        return $this->nama;
    }
    
    public function getProdi() {
        return $this->prodi;
    }
    
    public function getAngkatan() {
        return $this->angkatan;
    }
    
    public function getKelas() {
        return $this->kelas;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    // ==========================================
    // IMPLEMENTASI ABSTRACT METHOD DARI BaseModel
    // ==========================================
    
    public function validate() {
        $errors = [];
        
        if (empty($this->nim)) {
            $errors['nim'] = "NIM tidak boleh kosong";
        } elseif (strlen($this->nim) < 8) {
            $errors['nim'] = "NIM minimal 8 karakter";
        } elseif (strlen($this->nim) > 20) {
            $errors['nim'] = "NIM maksimal 20 karakter";
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
                $sql = "UPDATE mahasiswa SET 
                            nim = :nim, 
                            nama = :nama, 
                            prodi = :prodi,
                            angkatan = :angkatan, 
                            kelas = :kelas 
                        WHERE id = :id";
                $this->db->query($sql);
                $this->db->bind(':nim', $this->nim);
                $this->db->bind(':nama', $this->nama);
                $this->db->bind(':prodi', $this->prodi);
                $this->db->bind(':angkatan', $this->angkatan);
                $this->db->bind(':kelas', $this->kelas);
                $this->db->bind(':id', $this->id);
                
                if ($this->db->execute()) {
                    return ['success' => true, 'message' => 'Data mahasiswa berhasil diupdate'];
                }
            } else {
                // INSERT
                $sql = "INSERT INTO mahasiswa (user_id, nim, nama, prodi, angkatan, kelas) 
                        VALUES (:user_id, :nim, :nama, :prodi, :angkatan, :kelas)";
                $this->db->query($sql);
                $this->db->bind(':user_id', $this->user_id);
                $this->db->bind(':nim', $this->nim);
                $this->db->bind(':nama', $this->nama);
                $this->db->bind(':prodi', $this->prodi);
                $this->db->bind(':angkatan', $this->angkatan);
                $this->db->bind(':kelas', $this->kelas);
                
                if ($this->db->execute()) {
                    $this->id = $this->db->lastInsertId();
                    return ['success' => true, 'message' => 'Data mahasiswa berhasil ditambahkan', 'id' => $this->id];
                }
            }
            
            return ['success' => false, 'message' => 'Gagal menyimpan data mahasiswa'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    // ==========================================
    // ADDITIONAL METHODS (untuk AdminController)
    // ==========================================
    
    public function getAllMahasiswa() {
        try {
            $sql = "SELECT m.*, u.email, u.username 
                    FROM mahasiswa m
                    LEFT JOIN users u ON m.user_id = u.id
                    ORDER BY m.id DESC";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Ambil semua mahasiswa dengan filter (UNTUK HALAMAN ADMIN)
     * @param string $filter_prodi Filter berdasarkan program studi (kode: TI, SI, TK, dll)
     * @param string $filter_angkatan Filter berdasarkan angkatan
     * @return array Daftar mahasiswa
     */
    public function getAllWithFilters($filter_prodi = '', $filter_angkatan = '') {
        try {
            $sql = "SELECT m.*, u.email, u.username 
                    FROM mahasiswa m
                    LEFT JOIN users u ON m.user_id = u.id
                    WHERE 1=1";
            
            if ($filter_prodi != '') {
                $sql .= " AND m.prodi = :prodi";
            }
            if ($filter_angkatan != '') {
                $sql .= " AND m.angkatan = :angkatan";
            }
            
            $sql .= " ORDER BY m.nama ASC";
            
            $this->db->query($sql);
            
            if ($filter_prodi != '') {
                $this->db->bind(':prodi', $filter_prodi);
            }
            if ($filter_angkatan != '') {
                $this->db->bind(':angkatan', $filter_angkatan);
            }
            
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in getAllWithFilters: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Ambil mahasiswa berdasarkan ID - DIPERBAIKI dengan fallback prodi
     * @param int $id ID mahasiswa
     * @return array|null Data mahasiswa
     */
    public function getMahasiswaById($id) {
        try {
            $sql = "SELECT m.*, u.email, u.username 
                    FROM mahasiswa m
                    LEFT JOIN users u ON m.user_id = u.id
                    WHERE m.id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            $result = $this->db->single();
            
            // Jika prodi kosong, gunakan kelas sebagai fallback
            if ($result && (empty($result['prodi']) || $result['prodi'] === null)) {
                $result['prodi'] = $result['kelas'] ?? '';
            }
            
            return $result;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public function getMahasiswaByNim($nim) {
        try {
            $sql = "SELECT m.*, u.email, u.username 
                    FROM mahasiswa m
                    LEFT JOIN users u ON m.user_id = u.id
                    WHERE m.nim = :nim";
            $this->db->query($sql);
            $this->db->bind(':nim', $nim);
            return $this->db->single();
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Ambil mahasiswa berdasarkan user_id - DIPERBAIKI dengan fallback prodi
     * @param int $user_id ID user
     * @return array|null Data mahasiswa
     */
    public function getMahasiswaByUserId($user_id) {
        try {
            $sql = "SELECT m.*, u.email, u.username 
                    FROM mahasiswa m
                    LEFT JOIN users u ON m.user_id = u.id
                    WHERE m.user_id = :user_id";
            $this->db->query($sql);
            $this->db->bind(':user_id', $user_id);
            $result = $this->db->single();
            
            // Jika prodi kosong, gunakan kelas sebagai fallback
            if ($result && (empty($result['prodi']) || $result['prodi'] === null)) {
                $result['prodi'] = $result['kelas'] ?? '';
            }
            
            return $result;
        } catch (Exception $e) {
            return null;
        }
    }
    
    public function createMahasiswa($nama, $nim, $prodi, $angkatan, $kelas, $email, $password) {
        try {
            // Cek apakah NIM sudah terdaftar
            $sql = "SELECT COUNT(*) as total FROM mahasiswa WHERE nim = :nim";
            $this->db->query($sql);
            $this->db->bind(':nim', $nim);
            $result = $this->db->single();
            
            if ($result['total'] > 0) {
                return ['success' => false, 'message' => 'NIM sudah terdaftar'];
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
                $password = 'mhs123';
            }
            
            // Validasi password max 8 karakter
            if (strlen($password) > 8) {
                return ['success' => false, 'message' => 'Password maksimal 8 karakter'];
            }
            
            $hashedPassword = md5($password);
            
            // Insert ke tabel users
            $sql = "INSERT INTO users (username, email, password, role, nama) 
                    VALUES (:username, :email, :password, 'mahasiswa', :nama)";
            $this->db->query($sql);
            $this->db->bind(':username', $nama);
            $this->db->bind(':email', $email);
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':nama', $nama);
            
            if ($this->db->execute()) {
                $userId = $this->db->lastInsertId();
                
                // Insert ke tabel mahasiswa
                $sql = "INSERT INTO mahasiswa (user_id, nim, nama, prodi, angkatan, kelas) 
                        VALUES (:user_id, :nim, :nama, :prodi, :angkatan, :kelas)";
                $this->db->query($sql);
                $this->db->bind(':user_id', $userId);
                $this->db->bind(':nim', $nim);
                $this->db->bind(':nama', $nama);
                $this->db->bind(':prodi', $prodi);
                $this->db->bind(':angkatan', $angkatan);
                $this->db->bind(':kelas', $kelas);
                
                if ($this->db->execute()) {
                    return ['success' => true, 'message' => 'Mahasiswa berhasil ditambahkan'];
                }
            }
            
            return ['success' => false, 'message' => 'Gagal menambahkan mahasiswa'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    public function updateMahasiswa($id, $nama, $nim, $prodi, $angkatan, $kelas, $email) {
        try {
            // Cek apakah NIM sudah dipakai mahasiswa lain
            $sql = "SELECT COUNT(*) as total FROM mahasiswa WHERE nim = :nim AND id != :id";
            $this->db->query($sql);
            $this->db->bind(':nim', $nim);
            $this->db->bind(':id', $id);
            $result = $this->db->single();
            
            if ($result['total'] > 0) {
                return ['success' => false, 'message' => 'NIM sudah terdaftar untuk mahasiswa lain'];
            }
            
            // Update tabel mahasiswa
            $sql = "UPDATE mahasiswa SET 
                        nim = :nim, 
                        nama = :nama, 
                        prodi = :prodi,
                        angkatan = :angkatan, 
                        kelas = :kelas 
                    WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':nim', $nim);
            $this->db->bind(':nama', $nama);
            $this->db->bind(':prodi', $prodi);
            $this->db->bind(':angkatan', $angkatan);
            $this->db->bind(':kelas', $kelas);
            $this->db->bind(':id', $id);
            
            if ($this->db->execute()) {
                // Update email di tabel users
                $sql = "SELECT user_id FROM mahasiswa WHERE id = :id";
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
                
                return ['success' => true, 'message' => 'Data mahasiswa berhasil diupdate'];
            }
            
            return ['success' => false, 'message' => 'Gagal mengupdate mahasiswa'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    public function deleteMahasiswa($id) {
        try {
            // Ambil user_id dari mahasiswa
            $sql = "SELECT user_id FROM mahasiswa WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            $result = $this->db->single();
            
            if ($result) {
                // Hapus dari tabel users (cascade akan menghapus mahasiswa)
                $sql = "DELETE FROM users WHERE id = :user_id";
                $this->db->query($sql);
                $this->db->bind(':user_id', $result['user_id']);
                
                if ($this->db->execute()) {
                    return ['success' => true, 'message' => 'Mahasiswa berhasil dihapus'];
                }
            }
            
            return ['success' => false, 'message' => 'Gagal menghapus mahasiswa'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    public function countMahasiswa() {
        try {
            $sql = "SELECT COUNT(*) as total FROM mahasiswa";
            $this->db->query($sql);
            $result = $this->db->single();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
    
    public function searchMahasiswa($keyword) {
        try {
            $sql = "SELECT m.*, u.email 
                    FROM mahasiswa m
                    LEFT JOIN users u ON m.user_id = u.id
                    WHERE m.nama LIKE :keyword 
                       OR m.nim LIKE :keyword 
                       OR m.kelas LIKE :keyword
                       OR m.prodi LIKE :keyword
                    ORDER BY m.nama ASC";
            $this->db->query($sql);
            $this->db->bind(':keyword', "%$keyword%");
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }

    // ==================
    // METHOD UNTUK DOSEN - DIPERBAIKI
    // ==================

    /**
     * Ambil mahasiswa berdasarkan mata kuliah (untuk input absensi dosen)
     * MENGGUNAKAN PRODI DAN ANGKATAN DARI MATA KULIAH
     * TANPA perlu relasi di matkul_mahasiswa
     * @param int $matkul_id ID mata kuliah
     * @return array Daftar mahasiswa
     */
    public function getMahasiswaByMatkul($matkul_id) {
        try {
            // Ambil data mata kuliah untuk mendapatkan prodi dan angkatan
            $matkulModel = $this->model('MataKuliah');
            $matkul = $matkulModel->getMataKuliahById($matkul_id);
            
            if (!$matkul) {
                return [];
            }
            
            // Ambil prodi dari kode mata kuliah (2 huruf pertama)
            $prodi = substr($matkul['kode'], 0, 2);
            $angkatan = $matkul['angkatan'] ?? date('Y');
            
            // Ambil mahasiswa berdasarkan prodi dan angkatan
            $sql = "SELECT 
                        m.id, 
                        m.nim, 
                        m.nama, 
                        m.prodi, 
                        m.kelas,
                        m.angkatan
                    FROM mahasiswa m
                    WHERE m.prodi = :prodi 
                      AND m.angkatan = :angkatan
                    ORDER BY m.nama ASC";
            
            $this->db->query($sql);
            $this->db->bind(':prodi', $prodi);
            $this->db->bind(':angkatan', $angkatan);
            $result = $this->db->resultSet();
            
            // Tambahkan status terakhir untuk setiap mahasiswa
            foreach ($result as &$row) {
                $row['status_terakhir'] = $this->getLastStatus($row['id'], $matkul_id);
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in getMahasiswaByMatkul: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Ambil status terakhir mahasiswa untuk mata kuliah tertentu
     * @param int $mahasiswa_id
     * @param int $matkul_id
     * @return string|null
     */
    public function getLastStatus($mahasiswa_id, $matkul_id) {
        try {
            $sql = "SELECT status 
                    FROM absensi 
                    WHERE mahasiswa_id = :mahasiswa_id 
                      AND matkul_id = :matkul_id 
                    ORDER BY tanggal DESC, created_at DESC
                    LIMIT 1";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $this->db->bind(':matkul_id', $matkul_id);
            $result = $this->db->single();
            return $result ? $result['status'] : null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Ambil mahasiswa berdasarkan prodi dan angkatan
     * @param string $prodi Kode prodi (contoh: SI, TI)
     * @param string $angkatan Tahun angkatan
     * @param int $matkul_id ID mata kuliah (untuk status terakhir)
     * @return array Daftar mahasiswa
     */
    public function getMahasiswaByProdiAngkatan($prodi, $angkatan, $matkul_id = 0) {
        try {
            $sql = "SELECT 
                        m.id, 
                        m.nim, 
                        m.nama, 
                        m.prodi, 
                        m.kelas,
                        m.angkatan
                    FROM mahasiswa m
                    WHERE m.prodi = :prodi 
                      AND m.angkatan = :angkatan
                    ORDER BY m.nama ASC";
            
            $this->db->query($sql);
            $this->db->bind(':prodi', $prodi);
            $this->db->bind(':angkatan', $angkatan);
            $result = $this->db->resultSet();
            
            // Tambahkan status terakhir untuk setiap mahasiswa
            if ($matkul_id > 0) {
                foreach ($result as &$row) {
                    $row['status_terakhir'] = $this->getLastStatus($row['id'], $matkul_id);
                }
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in getMahasiswaByProdiAngkatan: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Assign mahasiswa ke mata kuliah
     * @param int $mahasiswa_id
     * @param int $matkul_id
     * @return array
     */
    public function assignToMatkul($mahasiswa_id, $matkul_id) {
        try {
            // Cek apakah sudah terdaftar
            $sql = "SELECT id FROM matkul_mahasiswa 
                    WHERE mahasiswa_id = :mahasiswa_id 
                      AND matkul_id = :matkul_id";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $this->db->bind(':matkul_id', $matkul_id);
            
            if ($this->db->single()) {
                return ['success' => false, 'message' => 'Mahasiswa sudah terdaftar di mata kuliah ini'];
            }

            // Insert ke matkul_mahasiswa
            $sql = "INSERT INTO matkul_mahasiswa (mahasiswa_id, matkul_id) 
                    VALUES (:mahasiswa_id, :matkul_id)";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $this->db->bind(':matkul_id', $matkul_id);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Mahasiswa berhasil ditambahkan ke mata kuliah'];
            }
            
            return ['success' => false, 'message' => 'Gagal menambahkan mahasiswa ke mata kuliah'];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }

    /**
     * Hapus mahasiswa dari mata kuliah
     * @param int $mahasiswa_id
     * @param int $matkul_id
     * @return array
     */
    public function removeFromMatkul($mahasiswa_id, $matkul_id) {
        try {
            $sql = "DELETE FROM matkul_mahasiswa 
                    WHERE mahasiswa_id = :mahasiswa_id 
                      AND matkul_id = :matkul_id";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $this->db->bind(':matkul_id', $matkul_id);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Mahasiswa berhasil dihapus dari mata kuliah'];
            }
            
            return ['success' => false, 'message' => 'Gagal menghapus mahasiswa dari mata kuliah'];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }

    /**
     * Ambil mata kuliah yang diambil oleh mahasiswa
     * @param int $mahasiswa_id
     * @return array
     */
    public function getMatkulByMahasiswaId($mahasiswa_id) {
        try {
            $sql = "SELECT 
                        mk.id, 
                        mk.kode, 
                        mk.nama, 
                        mk.sks,
                        mk.semester,
                        d.nama AS dosen_pengampu
                    FROM mata_kuliah mk
                    JOIN matkul_mahasiswa mm ON mk.id = mm.matkul_id
                    LEFT JOIN dosen d ON mk.dosen_id = d.id
                    WHERE mm.mahasiswa_id = :mahasiswa_id
                    ORDER BY mk.semester, mk.nama";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in getMatkulByMahasiswaId: " . $e->getMessage());
            return [];
        }
    }
}
?>