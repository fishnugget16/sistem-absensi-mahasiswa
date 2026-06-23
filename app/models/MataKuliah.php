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
    private $dosen_id;
    private $angkatan; // <-- TAMBAHKAN PROPERTY ANGKATAN
    
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
    
    public function setDosenId($dosen_id) {
        $this->dosen_id = $dosen_id;
        return $this;
    }
    
    public function setAngkatan($angkatan) { // <-- TAMBAHKAN SETTER
        $this->angkatan = $angkatan;
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
    
    public function getDosenId() {
        return $this->dosen_id;
    }
    
    public function getAngkatan() { // <-- TAMBAHKAN GETTER
        return $this->angkatan;
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
                // UPDATE - TAMBAHKAN ANGKATAN
                $sql = "UPDATE mata_kuliah SET 
                            kode = :kode, 
                            nama = :nama, 
                            sks = :sks, 
                            semester = :semester, 
                            jumlah_pertemuan = :jumlah_pertemuan, 
                            dosen_id = :dosen_id,
                            angkatan = :angkatan 
                        WHERE id = :id";
                $this->db->query($sql);
                $this->db->bind(':kode', $this->kode);
                $this->db->bind(':nama', $this->nama);
                $this->db->bind(':sks', $this->sks);
                $this->db->bind(':semester', $this->semester);
                $this->db->bind(':jumlah_pertemuan', $this->jumlah_pertemuan);
                $this->db->bind(':dosen_id', $this->dosen_id);
                $this->db->bind(':angkatan', $this->angkatan);
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
                
                // INSERT - TAMBAHKAN ANGKATAN
                $sql = "INSERT INTO mata_kuliah (kode, nama, sks, semester, jumlah_pertemuan, dosen_id, angkatan) 
                        VALUES (:kode, :nama, :sks, :semester, :jumlah_pertemuan, :dosen_id, :angkatan)";
                $this->db->query($sql);
                $this->db->bind(':kode', $this->kode);
                $this->db->bind(':nama', $this->nama);
                $this->db->bind(':sks', $this->sks);
                $this->db->bind(':semester', $this->semester);
                $this->db->bind(':jumlah_pertemuan', $this->jumlah_pertemuan);
                $this->db->bind(':dosen_id', $this->dosen_id);
                $this->db->bind(':angkatan', $this->angkatan);
                
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
     * Ambil semua mata kuliah (tanpa filter) - TAMBAHKAN ANGKATAN
     */
    public function getAllMataKuliah() {
        try {
            $sql = "SELECT mk.*, d.nama as dosen_nama, d.nidn 
                    FROM mata_kuliah mk
                    LEFT JOIN dosen d ON mk.dosen_id = d.id
                    ORDER BY mk.semester ASC, mk.kode ASC";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Ambil semua mata kuliah dengan filter - TAMBAHKAN FILTER ANGKATAN
     */
    public function getAllWithFilters($filter_semester = '', $filter_prodi = '', $filter_sks = '', $filter_angkatan = '') {
        try {
            $sql = "SELECT mk.*, d.nama as dosen_nama, d.nidn 
                    FROM mata_kuliah mk
                    LEFT JOIN dosen d ON mk.dosen_id = d.id
                    WHERE 1=1";
            
            if ($filter_semester != '') {
                $sql .= " AND mk.semester = :semester";
            }
            if ($filter_prodi != '') {
                $sql .= " AND mk.kode LIKE :prodi";
            }
            if ($filter_sks != '') {
                $sql .= " AND mk.sks = :sks";
            }
            if ($filter_angkatan != '') {
                $sql .= " AND mk.angkatan = :angkatan";
            }
            
            $sql .= " ORDER BY mk.semester ASC, mk.kode ASC";
            
            $this->db->query($sql);
            
            if ($filter_semester != '') {
                $this->db->bind(':semester', $filter_semester);
            }
            if ($filter_prodi != '') {
                $this->db->bind(':prodi', $filter_prodi . '-%');
            }
            if ($filter_sks != '') {
                $this->db->bind(':sks', $filter_sks);
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
     * Ambil mata kuliah berdasarkan ID
     */
    public function getMataKuliahById($id) {
        try {
            $sql = "SELECT mk.*, d.nama as dosen_nama, d.nidn 
                    FROM mata_kuliah mk
                    LEFT JOIN dosen d ON mk.dosen_id = d.id
                    WHERE mk.id = :id";
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
            $sql = "SELECT mk.*, d.nama as dosen_nama, d.nidn 
                    FROM mata_kuliah mk
                    LEFT JOIN dosen d ON mk.dosen_id = d.id
                    WHERE mk.kode = :kode";
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
            $sql = "SELECT mk.*, d.nama as dosen_nama, d.nidn 
                    FROM mata_kuliah mk
                    LEFT JOIN dosen d ON mk.dosen_id = d.id
                    WHERE mk.semester = :semester 
                    ORDER BY mk.kode ASC";
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
            $sql = "SELECT mk.*, d.nama as dosen_nama, d.nidn 
                    FROM mata_kuliah mk
                    LEFT JOIN dosen d ON mk.dosen_id = d.id
                    WHERE mk.kode LIKE :keyword 
                       OR mk.nama LIKE :keyword 
                    ORDER BY mk.semester ASC, mk.kode ASC";
            $this->db->query($sql);
            $this->db->bind(':keyword', "%$keyword%");
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Buat mata kuliah baru - TAMBAHKAN PARAMETER ANGKATAN
     */
    public function createMataKuliah($kode, $nama, $sks, $semester, $jumlah_pertemuan = 14, $dosen_id = null, $angkatan = null) {
        try {
            // Cek apakah kode sudah terdaftar
            $sql = "SELECT COUNT(*) as total FROM mata_kuliah WHERE kode = :kode";
            $this->db->query($sql);
            $this->db->bind(':kode', $kode);
            $result = $this->db->single();
            
            if ($result['total'] > 0) {
                return ['success' => false, 'message' => 'Kode mata kuliah sudah terdaftar'];
            }
            
            // Insert data - TAMBAHKAN ANGKATAN
            $sql = "INSERT INTO mata_kuliah (kode, nama, sks, semester, jumlah_pertemuan, dosen_id, angkatan) 
                    VALUES (:kode, :nama, :sks, :semester, :jumlah_pertemuan, :dosen_id, :angkatan)";
            $this->db->query($sql);
            $this->db->bind(':kode', $kode);
            $this->db->bind(':nama', $nama);
            $this->db->bind(':sks', $sks);
            $this->db->bind(':semester', $semester);
            $this->db->bind(':jumlah_pertemuan', $jumlah_pertemuan);
            $this->db->bind(':dosen_id', $dosen_id);
            $this->db->bind(':angkatan', $angkatan);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Mata kuliah berhasil ditambahkan'];
            }
            
            return ['success' => false, 'message' => 'Gagal menambahkan mata kuliah'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    /**
     * Update mata kuliah - TAMBAHKAN PARAMETER ANGKATAN
     */
    public function updateMataKuliah($id, $kode, $nama, $sks, $semester, $jumlah_pertemuan = 14, $dosen_id = null, $angkatan = null) {
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
            
            // Update data - TAMBAHKAN ANGKATAN
            $sql = "UPDATE mata_kuliah SET 
                        kode = :kode, 
                        nama = :nama, 
                        sks = :sks, 
                        semester = :semester, 
                        jumlah_pertemuan = :jumlah_pertemuan, 
                        dosen_id = :dosen_id,
                        angkatan = :angkatan 
                    WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':kode', $kode);
            $this->db->bind(':nama', $nama);
            $this->db->bind(':sks', $sks);
            $this->db->bind(':semester', $semester);
            $this->db->bind(':jumlah_pertemuan', $jumlah_pertemuan);
            $this->db->bind(':dosen_id', $dosen_id);
            $this->db->bind(':angkatan', $angkatan);
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

    // ==========================================
    // METHOD UNTUK DOSEN
    // ==========================================

    /**
     * Ambil mata kuliah berdasarkan dosen_id
     * @param int $dosen_id ID dosen
     * @return array Daftar mata kuliah
     */
    public function getByDosenId($dosen_id) {
        try {
            $sql = "SELECT * FROM mata_kuliah WHERE dosen_id = :dosen_id ORDER BY semester ASC, nama ASC";
            $this->db->query($sql);
            $this->db->bind(':dosen_id', $dosen_id);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in getByDosenId: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Hitung mata kuliah berdasarkan dosen_id
     * @param int $dosen_id ID dosen
     * @return int Jumlah mata kuliah
     */
    public function countByDosenId($dosen_id) {
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

    // ==========================================
    // METHOD UNTUK RELASI DENGAN MAHASISWA
    // ==========================================

    /**
     * Ambil mahasiswa yang terdaftar di mata kuliah tertentu
     * @param int $matkul_id ID mata kuliah
     * @return array Daftar mahasiswa
     */
    public function getMahasiswaByMatkulId($matkul_id) {
        try {
            $sql = "SELECT 
                        m.id, 
                        m.nim, 
                        m.nama, 
                        m.prodi, 
                        m.kelas,
                        m.angkatan
                    FROM mahasiswa m
                    JOIN matkul_mahasiswa mm ON m.id = mm.mahasiswa_id
                    WHERE mm.matkul_id = :matkul_id
                    ORDER BY m.nama ASC";
            $this->db->query($sql);
            $this->db->bind(':matkul_id', $matkul_id);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in getMahasiswaByMatkulId: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Hitung jumlah mahasiswa di mata kuliah tertentu
     * @param int $matkul_id ID mata kuliah
     * @return int Jumlah mahasiswa
     */
    public function countMahasiswaByMatkulId($matkul_id) {
        try {
            $sql = "SELECT COUNT(*) as total 
                    FROM matkul_mahasiswa 
                    WHERE matkul_id = :matkul_id";
            $this->db->query($sql);
            $this->db->bind(':matkul_id', $matkul_id);
            $result = $this->db->single();
            return $result ? (int)$result['total'] : 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Cek apakah mahasiswa terdaftar di mata kuliah tertentu
     * @param int $mahasiswa_id
     * @param int $matkul_id
     * @return bool
     */
    public function isMahasiswaRegistered($mahasiswa_id, $matkul_id) {
        try {
            $sql = "SELECT id FROM matkul_mahasiswa 
                    WHERE mahasiswa_id = :mahasiswa_id 
                      AND matkul_id = :matkul_id";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $this->db->bind(':matkul_id', $matkul_id);
            return $this->db->single() ? true : false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Registrasi mahasiswa ke mata kuliah
     * @param int $mahasiswa_id
     * @param int $matkul_id
     * @return array
     */
    public function registerMahasiswa($mahasiswa_id, $matkul_id) {
        try {
            // Cek apakah sudah terdaftar
            if ($this->isMahasiswaRegistered($mahasiswa_id, $matkul_id)) {
                return ['success' => false, 'message' => 'Mahasiswa sudah terdaftar di mata kuliah ini'];
            }

            $sql = "INSERT INTO matkul_mahasiswa (mahasiswa_id, matkul_id) 
                    VALUES (:mahasiswa_id, :matkul_id)";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $this->db->bind(':matkul_id', $matkul_id);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Mahasiswa berhasil terdaftar'];
            }
            
            return ['success' => false, 'message' => 'Gagal mendaftarkan mahasiswa'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }

    /**
     * Hapus registrasi mahasiswa dari mata kuliah
     * @param int $mahasiswa_id
     * @param int $matkul_id
     * @return array
     */
    public function unregisterMahasiswa($mahasiswa_id, $matkul_id) {
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

    // ==========================================
    // METHOD UNTUK ASSIGN MATA KULIAH KE DOSEN
    // ==========================================

    /**
     * Ambil mata kuliah berdasarkan prodi (cocokkan prefix kode)
     * Contoh: prodi = "SI" → cari kode LIKE 'SI-%'
     * @param string $prodi Kode prodi (contoh: SI, TI, TK)
     * @return array Daftar mata kuliah
     */
    public function getByProdi($prodi) {
        try {
            $sql = "SELECT * FROM mata_kuliah 
                    WHERE kode LIKE :prodi_prefix 
                    ORDER BY semester ASC, kode ASC";
            $this->db->query($sql);
            $this->db->bind(':prodi_prefix', $prodi . '-%');
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in getByProdi: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Ambil mata kuliah berdasarkan prodi DAN angkatan (BARU)
     * @param string $prodi Kode prodi (contoh: SI, TI)
     * @param int $angkatan Tahun angkatan
     * @return array Daftar mata kuliah
     */
    public function getByProdiAndAngkatan($prodi, $angkatan) {
        try {
            $sql = "SELECT * FROM mata_kuliah 
                    WHERE kode LIKE :prodi_prefix 
                      AND (angkatan = :angkatan OR angkatan IS NULL OR angkatan = 0 OR angkatan = 'Semua' OR angkatan = '')
                    ORDER BY semester ASC, kode ASC";
            
            $this->db->query($sql);
            $this->db->bind(':prodi_prefix', $prodi . '-%');
            $this->db->bind(':angkatan', $angkatan);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in getByProdiAndAngkatan: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Assign mata kuliah ke dosen
     * @param int $matkul_id ID mata kuliah
     * @param int $dosen_id ID dosen
     * @return array Hasil operasi
     */
    public function assignDosen($matkul_id, $dosen_id) {
        try {
            // Cek apakah matkul sudah punya dosen
            $sql = "SELECT dosen_id FROM mata_kuliah WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $matkul_id);
            $result = $this->db->single();
            
            if ($result && $result['dosen_id'] && $result['dosen_id'] != $dosen_id) {
                return ['success' => false, 'message' => 'Mata kuliah ini sudah diampu oleh dosen lain'];
            }
            
            $sql = "UPDATE mata_kuliah SET dosen_id = :dosen_id WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':dosen_id', $dosen_id);
            $this->db->bind(':id', $matkul_id);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Mata kuliah berhasil diassign ke dosen'];
            }
            return ['success' => false, 'message' => 'Gagal mengassign mata kuliah'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }

    /**
     * Lepas mata kuliah dari dosen (set dosen_id menjadi NULL)
     * @param int $matkul_id ID mata kuliah
     * @return array Hasil operasi
     */
    public function removeDosen($matkul_id) {
        try {
            $sql = "UPDATE mata_kuliah SET dosen_id = NULL WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $matkul_id);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Mata kuliah berhasil dilepas dari dosen'];
            }
            return ['success' => false, 'message' => 'Gagal melepas mata kuliah'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }

    /**
     * Ambil mata kuliah yang belum punya dosen
     * @return array Daftar mata kuliah tanpa dosen
     */
    public function getMatkulTanpaDosen() {
        try {
            $sql = "SELECT * FROM mata_kuliah WHERE dosen_id IS NULL OR dosen_id = 0 ORDER BY semester ASC, nama ASC";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in getMatkulTanpaDosen: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Ambil mata kuliah dengan info dosen pengampu
     * @return array Daftar mata kuliah dengan nama dosen
     */
    public function getAllWithDosen() {
        try {
            $sql = "SELECT mk.*, d.nama as dosen_nama, d.nidn 
                    FROM mata_kuliah mk
                    LEFT JOIN dosen d ON mk.dosen_id = d.id
                    ORDER BY mk.semester ASC, mk.kode ASC";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in getAllWithDosen: " . $e->getMessage());
            return [];
        }
    }
}
?>