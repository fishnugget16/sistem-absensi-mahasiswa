<?php

class SuratIzin extends BaseModel {
    
    protected $table = 'surat_izin';
    
    // Properties untuk save/update
    private $id;
    private $absensi_id;
    private $mahasiswa_id;
    private $matkul_id;
    private $file_path;
    private $jenis;
    private $status;
    private $keterangan;
    private $keterangan_admin;
    private $tanggal_upload;
    
    public function __construct() {
        parent::__construct();
    }
    
    // ========== SETTER METHODS ==========
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function setAbsensiId($absensi_id) {
        $this->absensi_id = $absensi_id;
        return $this;
    }
    
    public function setMahasiswaId($mahasiswa_id) {
        $this->mahasiswa_id = $mahasiswa_id;
        return $this;
    }
    
    public function setMatkulId($matkul_id) {
        $this->matkul_id = $matkul_id;
        return $this;
    }
    
    public function setFilePath($file_path) {
        $this->file_path = $file_path;
        return $this;
    }
    
    public function setJenis($jenis) {
        $this->jenis = $jenis;
        return $this;
    }
    
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }
    
    public function setKeterangan($keterangan) {
        $this->keterangan = $keterangan;
        return $this;
    }
    
    public function setKeteranganAdmin($keterangan_admin) {
        $this->keterangan_admin = $keterangan_admin;
        return $this;
    }
    
    public function setTanggalUpload($tanggal_upload) {
        $this->tanggal_upload = $tanggal_upload;
        return $this;
    }
    
    // ========== GETTER METHODS ==========
    public function getId() {
        return $this->id;
    }
    
    public function getAbsensiId() {
        return $this->absensi_id;
    }
    
    public function getMahasiswaId() {
        return $this->mahasiswa_id;
    }
    
    public function getMatkulId() {
        return $this->matkul_id;
    }
    
    public function getFilePath() {
        return $this->file_path;
    }
    
    public function getJenis() {
        return $this->jenis;
    }
    
    public function getStatus() {
        return $this->status;
    }
    
    public function getKeterangan() {
        return $this->keterangan;
    }
    
    public function getKeteranganAdmin() {
        return $this->keterangan_admin;
    }
    
    public function getTanggalUpload() {
        return $this->tanggal_upload;
    }
    
    // ========== IMPLEMENTASI ABSTRACT METHOD DARI BASEMODEL ==========
    
    public function validate() {
        $errors = [];
        
        if (empty($this->file_path)) {
            $errors['file_path'] = "File path tidak boleh kosong";
        }
        
        if (empty($this->jenis)) {
            $errors['jenis'] = "Jenis surat tidak boleh kosong";
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
                $sql = "UPDATE surat_izin SET absensi_id = :absensi_id, mahasiswa_id = :mahasiswa_id,
                        matkul_id = :matkul_id, file_path = :file_path, jenis = :jenis, status = :status, 
                        keterangan = :keterangan, keterangan_admin = :keterangan_admin
                        WHERE id = :id";
                $this->db->query($sql);
                $this->db->bind(':absensi_id', $this->absensi_id);
                $this->db->bind(':mahasiswa_id', $this->mahasiswa_id);
                $this->db->bind(':matkul_id', $this->matkul_id);
                $this->db->bind(':file_path', $this->file_path);
                $this->db->bind(':jenis', $this->jenis);
                $this->db->bind(':status', $this->status);
                $this->db->bind(':keterangan', $this->keterangan);
                $this->db->bind(':keterangan_admin', $this->keterangan_admin);
                $this->db->bind(':id', $this->id);
                
                if ($this->db->execute()) {
                    return ['success' => true, 'message' => 'Data surat izin berhasil diupdate'];
                }
            } else {
                // INSERT (dengan prioritas mahasiswa_id & matkul_id)
                if (!empty($this->mahasiswa_id) && !empty($this->matkul_id)) {
                    $sql = "INSERT INTO surat_izin (mahasiswa_id, matkul_id, file_path, jenis, status, keterangan, tanggal_upload) 
                            VALUES (:mahasiswa_id, :matkul_id, :file_path, :jenis, :status, :keterangan, NOW())";
                    $this->db->query($sql);
                    $this->db->bind(':mahasiswa_id', $this->mahasiswa_id);
                    $this->db->bind(':matkul_id', $this->matkul_id);
                } else {
                    $sql = "INSERT INTO surat_izin (absensi_id, file_path, jenis, status, keterangan, tanggal_upload) 
                            VALUES (:absensi_id, :file_path, :jenis, :status, :keterangan, NOW())";
                    $this->db->query($sql);
                    $this->db->bind(':absensi_id', $this->absensi_id);
                }
                $this->db->bind(':file_path', $this->file_path);
                $this->db->bind(':jenis', $this->jenis);
                $this->db->bind(':status', $this->status);
                $this->db->bind(':keterangan', $this->keterangan);
                
                if ($this->db->execute()) {
                    $this->id = $this->db->lastInsertId();
                    return ['success' => true, 'message' => 'Data surat izin berhasil ditambahkan', 'id' => $this->id];
                }
            }
            
            return ['success' => false, 'message' => 'Gagal menyimpan data surat izin'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    // ========== METHOD UNTUK MAHASISWA ==========
    
    /**
     * Ambil semua surat izin berdasarkan mahasiswa_id (join ke absensi untuk data lama)
     * dan juga data baru yang langsung menggunakan mahasiswa_id
     */
    public function getByMahasiswaId($mahasiswa_id) {
        try {
            $sql = "SELECT s.*, a.tanggal, mk.nama as mata_kuliah, mk.kode
                    FROM surat_izin s
                    LEFT JOIN absensi a ON s.absensi_id = a.id
                    LEFT JOIN mata_kuliah mk ON COALESCE(a.matkul_id, s.matkul_id) = mk.id
                    WHERE s.mahasiswa_id = :mahasiswa_id
                    ORDER BY s.tanggal_upload DESC";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Ambil surat izin berdasarkan mahasiswa_id dengan filter status
     * @param int $mahasiswa_id ID mahasiswa
     * @param string $filter_status Filter status (semua, pending, disetujui, ditolak)
     * @return array Daftar surat izin
     */
    public function getByMahasiswaIdWithFilter($mahasiswa_id, $filter_status = 'semua') {
        try {
            $sql = "SELECT s.*, a.tanggal, mk.nama as mata_kuliah, mk.kode
                    FROM surat_izin s
                    LEFT JOIN absensi a ON s.absensi_id = a.id
                    LEFT JOIN mata_kuliah mk ON COALESCE(a.matkul_id, s.matkul_id) = mk.id
                    WHERE s.mahasiswa_id = :mahasiswa_id";
            
            if ($filter_status != 'semua') {
                $sql .= " AND s.status = :status";
            }
            
            $sql .= " ORDER BY s.tanggal_upload DESC";
            
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            
            if ($filter_status != 'semua') {
                $this->db->bind(':status', $filter_status);
            }
            
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Hitung jumlah surat izin mahasiswa berdasarkan status
     * @param int $mahasiswa_id ID mahasiswa
     * @param string|null $status Status (pending, disetujui, ditolak)
     * @return int Jumlah surat izin
     */
    public function countByMahasiswaIdAndStatus($mahasiswa_id, $status = null) {
        try {
            $sql = "SELECT COUNT(*) as total FROM surat_izin 
                    WHERE mahasiswa_id = :mahasiswa_id";
            
            if ($status !== null) {
                $sql .= " AND status = :status";
            }
            
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            
            if ($status !== null) {
                $this->db->bind(':status', $status);
            }
            
            $result = $this->db->single();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Hitung jumlah surat izin mahasiswa
     */
    public function countByMahasiswaId($mahasiswa_id) {
        try {
            $sql = "SELECT COUNT(*) as total FROM surat_izin 
                    WHERE mahasiswa_id = :mahasiswa_id";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $result = $this->db->single();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Simpan surat izin baru berdasarkan mahasiswa_id dan matkul_id (tanpa absensi)
     * @param int $mahasiswa_id ID mahasiswa
     * @param int $matkul_id ID mata kuliah
     * @param string $file_path Path file yang diupload
     * @param string $jenis Jenis surat (sakit, izin, dispensasi)
     * @param string|null $keterangan Keterangan tambahan
     * @return array Hasil operasi
     */
    public function createSuratIzinByMahasiswa($mahasiswa_id, $matkul_id, $file_path, $jenis, $keterangan = null) {
        try {
            $sql = "INSERT INTO surat_izin (mahasiswa_id, matkul_id, file_path, jenis, keterangan, status, tanggal_upload) 
                    VALUES (:mahasiswa_id, :matkul_id, :file_path, :jenis, :keterangan, 'pending', NOW())";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $this->db->bind(':matkul_id', $matkul_id);
            $this->db->bind(':file_path', $file_path);
            $this->db->bind(':jenis', $jenis);
            $this->db->bind(':keterangan', $keterangan);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Surat izin berhasil diupload'];
            }
            return ['success' => false, 'message' => 'Gagal mengupload surat izin'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    /**
     * Simpan surat izin baru (lama, berdasarkan absensi_id)
     */
    public function createSuratIzin($absensi_id, $file_path, $jenis, $keterangan = null) {
        try {
            $sql = "INSERT INTO surat_izin (absensi_id, file_path, jenis, keterangan, status, tanggal_upload) 
                    VALUES (:absensi_id, :file_path, :jenis, :keterangan, 'pending', NOW())";
            $this->db->query($sql);
            $this->db->bind(':absensi_id', $absensi_id);
            $this->db->bind(':file_path', $file_path);
            $this->db->bind(':jenis', $jenis);
            $this->db->bind(':keterangan', $keterangan);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Surat izin berhasil diupload'];
            }
            return ['success' => false, 'message' => 'Gagal mengupload surat izin'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    /**
     * Ambil data surat izin berdasarkan id (tanpa join)
     */
    public function getById($id) {
        try {
            $sql = "SELECT * FROM surat_izin WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            return $this->db->single();
        } catch (Exception $e) {
            return null;
        }
    }
    
    // ========== METHOD UNTUK ADMIN & DOSEN ==========
    
    /**
     * Ambil detail surat izin lengkap dengan data mahasiswa dan mata kuliah
     */
    public function getDetailById($id) {
        try {
            $sql = "SELECT s.*, 
                           a.tanggal, 
                           m.nama as mahasiswa_nama, m.nim, m.kelas as prodi,
                           mk.nama as mata_kuliah, mk.kode
                    FROM surat_izin s
                    LEFT JOIN absensi a ON s.absensi_id = a.id
                    LEFT JOIN mahasiswa m ON s.mahasiswa_id = m.id
                    LEFT JOIN mata_kuliah mk ON COALESCE(a.matkul_id, s.matkul_id) = mk.id
                    WHERE s.id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            return $this->db->single();
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Ambil semua surat izin (untuk admin & dosen)
     * @param string|null $status Filter status (pending, disetujui, ditolak)
     * @return array Daftar surat izin
     */
    public function getAllSuratIzin($status = null) {
        try {
            $sql = "SELECT s.*, a.tanggal, mk.nama as mata_kuliah, mk.kode,
                           m.nama as mahasiswa_nama, m.nim, m.kelas as prodi
                    FROM surat_izin s
                    LEFT JOIN absensi a ON s.absensi_id = a.id
                    LEFT JOIN mahasiswa m ON s.mahasiswa_id = m.id
                    LEFT JOIN mata_kuliah mk ON COALESCE(a.matkul_id, s.matkul_id) = mk.id";
            
            if ($status !== null) {
                $sql .= " WHERE s.status = :status";
            }
            
            $sql .= " ORDER BY s.tanggal_upload DESC";
            
            $this->db->query($sql);
            
            if ($status !== null) {
                $this->db->bind(':status', $status);
            }
            
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Ambil semua surat izin berdasarkan mata kuliah (untuk dosen yang mengampu)
     * @param int $dosen_id ID dosen
     * @return array Daftar surat izin
     */
    public function getSuratIzinByDosenId($dosen_id) {
        try {
            $sql = "SELECT s.*, a.tanggal, mk.nama as mata_kuliah, mk.kode,
                           m.nama as mahasiswa_nama, m.nim, m.kelas as prodi
                    FROM surat_izin s
                    LEFT JOIN absensi a ON s.absensi_id = a.id
                    LEFT JOIN mahasiswa m ON s.mahasiswa_id = m.id
                    LEFT JOIN mata_kuliah mk ON COALESCE(a.matkul_id, s.matkul_id) = mk.id
                    WHERE mk.dosen_id = :dosen_id
                    ORDER BY s.tanggal_upload DESC";
            
            $this->db->query($sql);
            $this->db->bind(':dosen_id', $dosen_id);
            
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Update status surat izin (setujui/tolak) oleh admin/dosen
     * @param int $id ID surat izin
     * @param string $status Status baru (disetujui/ditolak)
     * @param string|null $keterangan_admin Keterangan dari admin/dosen
     * @return array Hasil operasi
     */
    public function updateStatus($id, $status, $keterangan_admin = null) {
        try {
            $sql = "UPDATE surat_izin SET status = :status, 
                    keterangan_admin = :keterangan_admin 
                    WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':status', $status);
            $this->db->bind(':keterangan_admin', $keterangan_admin);
            $this->db->bind(':id', $id);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Status surat izin berhasil diupdate'];
            }
            return ['success' => false, 'message' => 'Gagal mengupdate status'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    /**
     * Hitung total surat izin berdasarkan status
     * @param string|null $status Status (pending, disetujui, ditolak)
     * @return int Jumlah surat izin
     */
    public function countByStatus($status = null) {
        try {
            $sql = "SELECT COUNT(*) as total FROM surat_izin";
            if ($status !== null) {
                $sql .= " WHERE status = :status";
            }
            
            $this->db->query($sql);
            if ($status !== null) {
                $this->db->bind(':status', $status);
            }
            
            $result = $this->db->single();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Hitung total surat izin untuk dashboard
     * @return array Statistik surat izin
     */
    public function getStatistik() {
        try {
            $sql = "SELECT 
                        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                        SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
                        SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak,
                        COUNT(*) as total
                    FROM surat_izin";
            
            $this->db->query($sql);
            return $this->db->single();
        } catch (Exception $e) {
            return [
                'pending' => 0,
                'disetujui' => 0,
                'ditolak' => 0,
                'total' => 0
            ];
        }
    }
    
    /**
     * Hapus surat izin (dan file fisiknya)
     * @param int $id ID surat izin
     * @return array Hasil operasi
     */
    public function deleteSuratIzin($id) {
        try {
            // Ambil file path dulu
            $surat = $this->getById($id);
            if ($surat && $surat['file_path']) {
                $filePath = $_SERVER['DOCUMENT_ROOT'] . '/aplikasi-absensi-mahasiswa/public/' . $surat['file_path'];
                if (file_exists($filePath)) {
                    unlink($filePath); // Hapus file fisik
                }
            }
            
            // Hapus dari database
            $sql = "DELETE FROM surat_izin WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            
            if ($this->db->execute()) {
                return ['success' => true, 'message' => 'Surat izin berhasil dihapus'];
            }
            return ['success' => false, 'message' => 'Gagal menghapus surat izin'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
}