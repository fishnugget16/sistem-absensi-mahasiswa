<?php

class MataKuliah extends BaseModel {
    
    protected $table = 'mata_kuliah';
    
    // Properties (Encapsulation)
    private $id;
    private $kode;
    private $nama;
    private $sks;
    private $semester;
    
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
                $sql = "UPDATE mata_kuliah SET kode = :kode, nama = :nama, sks = :sks, semester = :semester WHERE id = :id";
                $this->db->query($sql);
                $this->db->bind(':kode', $this->kode);
                $this->db->bind(':nama', $this->nama);
                $this->db->bind(':sks', $this->sks);
                $this->db->bind(':semester', $this->semester);
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
                $sql = "INSERT INTO mata_kuliah (kode, nama, sks, semester) VALUES (:kode, :nama, :sks, :semester)";
                $this->db->query($sql);
                $this->db->bind(':kode', $this->kode);
                $this->db->bind(':nama', $this->nama);
                $this->db->bind(':sks', $this->sks);
                $this->db->bind(':semester', $this->semester);
                
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
    // ADDITIONAL METHODS (untuk AdminController)
    // ==========================================
    
    public function getAllMataKuliah() {
        try {
            $sql = "SELECT * FROM mata_kuliah ORDER BY semester ASC, kode ASC";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
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
    
    public function updateMataKuliah($id, $kode, $nama, $sks, $semester, $jumlah_pertemuan) {
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
}