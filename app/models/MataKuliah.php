<?php

class MataKuliah extends BaseModel {
    
    protected $table = 'mata_kuliah';
    
    // Properties (Encapsulation)
    private $id;
    private $kode;
    private $nama;
    private $sks;
    private $semester;
    private $jumlah_pertemuan;
    
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
    
    public function setKode($kode) {
        $this->kode = htmlspecialchars(trim($kode));
        return $this;
    }
    
    public function setNama($nama) {
        $this->nama = htmlspecialchars(trim($nama));
        return $this;
    }
    
    public function setSks($sks) {
        $this->sks = (int)$sks;
        return $this;
    }
    
    public function setSemester($semester) {
        $this->semester = (int)$semester;
        return $this;
    }
    
    public function setJumlahPertemuan($jumlah_pertemuan) {
        $this->jumlah_pertemuan = (int)$jumlah_pertemuan;
        return $this;
    }
    
    // ==========================================
    // GETTER METHODS
    // ==========================================
    
    public function getId() {
        return $this->id;
    }
    
    public function getKode() {
        return $this->kode;
    }
    
    public function getNama() {
        return $this->nama;
    }
    
    public function getSks() {
        return $this->sks;
    }
    
    public function getSemester() {
        return $this->semester;
    }
    
    public function getJumlahPertemuan() {
        return $this->jumlah_pertemuan;
    }
    
    // ==========================================
    // IMPLEMENTASI ABSTRACT METHOD DARI BaseModel
    // ==========================================
    
    public function validate() {
        $errors = [];
        
        if (empty($this->kode)) {
            $errors['kode'] = "Kode mata kuliah tidak boleh kosong";
        } elseif (strlen($this->kode) < 3) {
            $errors['kode'] = "Kode mata kuliah minimal 3 karakter";
        } elseif (strlen($this->kode) > 10) {
            $errors['kode'] = "Kode mata kuliah maksimal 10 karakter";
        }
        
        if (empty($this->nama)) {
            $errors['nama'] = "Nama mata kuliah tidak boleh kosong";
        } elseif (strlen($this->nama) < 3) {
            $errors['nama'] = "Nama mata kuliah minimal 3 karakter";
        } elseif (strlen($this->nama) > 100) {
            $errors['nama'] = "Nama mata kuliah maksimal 100 karakter";
        }
        
        if (!empty($this->sks) && ($this->sks < 1 || $this->sks > 6)) {
            $errors['sks'] = "SKS harus antara 1-6";
        }
        
        if (!empty($this->semester) && ($this->semester < 1 || $this->semester > 8)) {
            $errors['semester'] = "Semester harus antara 1-8";
        }
        
        if (!empty($this->jumlah_pertemuan) && ($this->jumlah_pertemuan < 1 || $this->jumlah_pertemuan > 24)) {
            $errors['jumlah_pertemuan'] = "Jumlah pertemuan harus antara 1-24";
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
                $sql = "UPDATE mata_kuliah SET kode = :kode, nama = :nama, sks = :sks, semester = :semester, jumlah_pertemuan = :jumlah_pertemuan WHERE id = :id";
                $this->db->query($sql);
                $this->db->bind(':kode', $this->kode);
                $this->db->bind(':nama', $this->nama);
                $this->db->bind(':sks', $this->sks);
                $this->db->bind(':semester', $this->semester);
                $this->db->bind(':jumlah_pertemuan', $this->jumlah_pertemuan);
                $this->db->bind(':id', $this->id);
                
                if ($this->db->execute()) {
                    return ['success' => true, 'message' => 'Data mata kuliah berhasil diupdate'];
                }
            } else {
                // Cek apakah kode sudah terdaftar
                $sql = "SELECT COUNT(*) as total FROM mata_kuliah WHERE kode = :kode";
                $this->db->query($sql);
                $this->db->bind(':kode', $this->kode);
                $result = $this->db->single();
                
                if ($result['total'] > 0) {
                    return ['success' => false, 'message' => 'Kode mata kuliah sudah terdaftar'];
                }
                
                // INSERT
                $sql = "INSERT INTO mata_kuliah (kode, nama, sks, semester, jumlah_pertemuan) VALUES (:kode, :nama, :sks, :semester, :jumlah_pertemuan)";
                $this->db->query($sql);
                $this->db->bind(':kode', $this->kode);
                $this->db->bind(':nama', $this->nama);
                $this->db->bind(':sks', $this->sks);
                $this->db->bind(':semester', $this->semester);
                $this->db->bind(':jumlah_pertemuan', $this->jumlah_pertemuan);
                
                if ($this->db->execute()) {
                    $this->id = $this->db->lastInsertId();
                    return ['success' => true, 'message' => 'Data mata kuliah berhasil ditambahkan', 'id' => $this->id];
                }
            }
            
            return ['success' => false, 'message' => 'Gagal menyimpan data mata kuliah'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    // ==========================================
    // CRUD METHODS (untuk AdminController)
    // ==========================================
    
    /**
     * Ambil semua mata kuliah (tanpa filter)
     */
    public function getAllMataKuliah() {
        try {
            $sql = "SELECT * FROM mata_kuliah ORDER BY semester ASC, kode ASC";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Ambil semua mata kuliah dengan filter (UNTUK HALAMAN ADMIN)
     * @param string $filter_semester Filter berdasarkan semester
     * @param string $filter_prodi Filter berdasarkan kode prodi (awalan kode)
     * @param string $filter_sks Filter berdasarkan SKS
     * @return array Daftar mata kuliah
     */
    public function getAllWithFilters($filter_semester = '', $filter_prodi = '', $filter_sks = '') {
        try {
            $sql = "SELECT * FROM mata_kuliah WHERE 1=1";
            
            if ($filter_semester != '') {
                $sql .= " AND semester = :semester";
            }
            if ($filter_prodi != '') {
                $sql .= " AND kode LIKE :prodi";
            }
            if ($filter_sks != '') {
                $sql .= " AND sks = :sks";
            }
            
            $sql .= " ORDER BY semester ASC, kode ASC";
            
            $this->db->query($sql);
            
            if ($filter_semester != '') {
                $this->db->bind(':semester', $filter_semester);
            }
            if ($filter_prodi != '') {
                $this->db->bind(':prodi', $filter_prodi . '%');
            }
            if ($filter_sks != '') {
                $this->db->bind(':sks', $filter_sks);
            }
            
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in getAllWithFilters: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Ambil mata kuliah berdasarkan ID
     */
    public function getMataKuliahById($id) {
        try {
            $sql = "SELECT * FROM mata_kuliah WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            return $this->db->single();
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Ambil mata kuliah berdasarkan kode
     */
    public function getMataKuliahByKode($kode) {
        try {
            $sql = "SELECT * FROM mata_kuliah WHERE kode = :kode";
            $this->db->query($sql);
            $this->db->bind(':kode', $kode);
            return $this->db->single();
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Ambil mata kuliah berdasarkan semester
     */
    public function getMataKuliahBySemester($semester) {
        try {
            $sql = "SELECT * FROM mata_kuliah WHERE semester = :semester ORDER BY kode ASC";
            $this->db->query($sql);
            $this->db->bind(':semester', $semester);
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Cari mata kuliah berdasarkan keyword
     */
    public function searchMataKuliah($keyword) {
        try {
            $sql = "SELECT * FROM mata_kuliah 
                    WHERE kode LIKE :keyword 
                       OR nama LIKE :keyword 
                    ORDER BY semester ASC, kode ASC";
            $this->db->query($sql);
            $this->db->bind(':keyword', "%$keyword%");
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Buat mata kuliah baru
     */
    public function createMataKuliah($kode, $nama, $sks, $semester, $jumlah_pertemuan = 14) {
        try {
            // Cek apakah kode sudah terdaftar
            $sql = "SELECT COUNT(*) as total FROM mata_kuliah WHERE kode = :kode";
            $this->db->query($sql);
            $this->db->bind(':kode', $kode);
            $result = $this->db->single();
            
            if ($result['total'] > 0) {
                return ['success' => false, 'message' => 'Kode mata kuliah sudah terdaftar'];
            }
            
            // Insert data
            $sql = "INSERT INTO mata_kuliah (kode, nama, sks, semester, jumlah_pertemuan) VALUES (:kode, :nama, :sks, :semester, :jumlah_pertemuan)";
            $this->db->query($sql);
            $this->db->bind(':kode', $kode);
            $this->db->bind(':nama', $nama);
            $this->db->bind(':sks', $sks);
            $this->db->bind(':semester', $semester);
            $this->db->bind(':jumlah_pertemuan', $jumlah_pertemuan);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Mata kuliah berhasil ditambahkan'];
            }
            
            return ['success' => false, 'message' => 'Gagal menambahkan mata kuliah'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    /**
     * Update mata kuliah
     */
    public function updateMataKuliah($id, $kode, $nama, $sks, $semester, $jumlah_pertemuan = 14) {
        try {
            // Cek apakah kode sudah dipakai matkul lain
            $sql = "SELECT COUNT(*) as total FROM mata_kuliah WHERE kode = :kode AND id != :id";
            $this->db->query($sql);
            $this->db->bind(':kode', $kode);
            $this->db->bind(':id', $id);
            $result = $this->db->single();
            
            if ($result['total'] > 0) {
                return ['success' => false, 'message' => 'Kode mata kuliah sudah terdaftar untuk matkul lain'];
            }
            
            // Update data
            $sql = "UPDATE mata_kuliah SET kode = :kode, nama = :nama, sks = :sks, semester = :semester, jumlah_pertemuan = :jumlah_pertemuan WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':kode', $kode);
            $this->db->bind(':nama', $nama);
            $this->db->bind(':sks', $sks);
            $this->db->bind(':semester', $semester);
            $this->db->bind(':jumlah_pertemuan', $jumlah_pertemuan);
            $this->db->bind(':id', $id);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Data mata kuliah berhasil diupdate'];
            }
            
            return ['success' => false, 'message' => 'Gagal mengupdate mata kuliah'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    /**
     * Hapus mata kuliah
     */
    public function deleteMataKuliah($id) {
        try {
            $sql = "DELETE FROM mata_kuliah WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Mata kuliah berhasil dihapus'];
            }
            
            return ['success' => false, 'message' => 'Gagal menghapus mata kuliah'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    /**
     * Hitung total mata kuliah
     */
    public function countMataKuliah() {
        try {
            $sql = "SELECT COUNT(*) as total FROM mata_kuliah";
            $this->db->query($sql);
            $result = $this->db->single();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
}