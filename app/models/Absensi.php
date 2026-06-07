<?php

class Absensi extends BaseModel {
    
    protected $table = 'absensi';
    
    // Properties untuk save/update
    private $id;
    private $mahasiswa_id;
    private $matkul_id;
    private $tanggal;
    private $status;
    private $keterangan;
    
    public function __construct() {
        parent::__construct();
    }
    
    // ========== SETTER METHODS ==========
    public function setId($id) {
        $this->id = $id;
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
    
    public function setTanggal($tanggal) {
        $this->tanggal = $tanggal;
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
    
    // ========== GETTER METHODS ==========
    public function getId() {
        return $this->id;
    }
    
    public function getMahasiswaId() {
        return $this->mahasiswa_id;
    }
    
    public function getMatkulId() {
        return $this->matkul_id;
    }
    
    public function getTanggal() {
        return $this->tanggal;
    }
    
    public function getStatus() {
        return $this->status;
    }
    
    public function getKeterangan() {
        return $this->keterangan;
    }
    
    // ========== IMPLEMENTASI ABSTRACT METHOD DARI BASEMODEL ==========
    
    public function validate() {
        $errors = [];
        
        if (empty($this->mahasiswa_id)) {
            $errors['mahasiswa_id'] = "Mahasiswa ID tidak boleh kosong";
        }
        
        if (empty($this->matkul_id)) {
            $errors['matkul_id'] = "Mata Kuliah ID tidak boleh kosong";
        }
        
        if (empty($this->tanggal)) {
            $errors['tanggal'] = "Tanggal tidak boleh kosong";
        }
        
        if (empty($this->status)) {
            $errors['status'] = "Status tidak boleh kosong";
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
                $sql = "UPDATE absensi SET mahasiswa_id = :mahasiswa_id, matkul_id = :matkul_id, 
                        tanggal = :tanggal, status = :status, keterangan = :keterangan 
                        WHERE id = :id";
                $this->db->query($sql);
                $this->db->bind(':mahasiswa_id', $this->mahasiswa_id);
                $this->db->bind(':matkul_id', $this->matkul_id);
                $this->db->bind(':tanggal', $this->tanggal);
                $this->db->bind(':status', $this->status);
                $this->db->bind(':keterangan', $this->keterangan);
                $this->db->bind(':id', $this->id);
                
                if ($this->db->execute()) {
                    return ['success' => true, 'message' => 'Data absensi berhasil diupdate'];
                }
            } else {
                // INSERT
                $sql = "INSERT INTO absensi (mahasiswa_id, matkul_id, tanggal, status, keterangan) 
                        VALUES (:mahasiswa_id, :matkul_id, :tanggal, :status, :keterangan)";
                $this->db->query($sql);
                $this->db->bind(':mahasiswa_id', $this->mahasiswa_id);
                $this->db->bind(':matkul_id', $this->matkul_id);
                $this->db->bind(':tanggal', $this->tanggal);
                $this->db->bind(':status', $this->status);
                $this->db->bind(':keterangan', $this->keterangan);
                
                if ($this->db->execute()) {
                    $this->id = $this->db->lastInsertId();
                    return ['success' => true, 'message' => 'Data absensi berhasil ditambahkan', 'id' => $this->id];
                }
            }
            
            return ['success' => false, 'message' => 'Gagal menyimpan data absensi'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    
    // ========== METHOD UNTUK MAHASISWA ==========
    
    /**
     * Ambil semua absensi berdasarkan mahasiswa_id
     */
    public function getByMahasiswaId($mahasiswa_id) {
        try {
            $sql = "SELECT a.*, mk.kode, mk.nama as mata_kuliah, mk.sks, mk.semester, mk.jumlah_pertemuan
                    FROM absensi a
                    JOIN mata_kuliah mk ON a.matkul_id = mk.id
                    WHERE a.mahasiswa_id = :mahasiswa_id
                    ORDER BY a.tanggal DESC";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Ambil absensi terbaru berdasarkan mahasiswa_id dan matkul_id (untuk upload surat)
     */
    public function getLatestAbsensiByMahasiswaAndMatkul($mahasiswa_id, $matkul_id) {
        try {
            $sql = "SELECT id FROM absensi 
                    WHERE mahasiswa_id = :mahasiswa_id AND matkul_id = :matkul_id 
                    ORDER BY tanggal DESC LIMIT 1";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $this->db->bind(':matkul_id', $matkul_id);
            return $this->db->single();
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Hitung total kehadiran (status Hadir)
     */
    public function countHadir($mahasiswa_id) {
        try {
            $sql = "SELECT COUNT(*) as total FROM absensi 
                    WHERE mahasiswa_id = :mahasiswa_id AND status = 'Hadir'";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $result = $this->db->single();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Hitung total pertemuan (semua status)
     */
    public function countTotalPertemuan($mahasiswa_id) {
        try {
            $sql = "SELECT COUNT(*) as total FROM absensi 
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
     * Hitung persentase kehadiran
     */
    public function getPersentaseKehadiran($mahasiswa_id) {
        $total = $this->countTotalPertemuan($mahasiswa_id);
        $hadir = $this->countHadir($mahasiswa_id);
        
        if ($total > 0) {
            return round(($hadir / $total) * 100, 2);
        }
        return 0;
    }
    
    /**
     * Ambil daftar mata kuliah yang pernah diikuti mahasiswa (dari absensi)
     */
    public function getMatkulByMahasiswaId($mahasiswa_id) {
        try {
            $sql = "SELECT DISTINCT mk.id, mk.kode, mk.nama, mk.sks, mk.semester
                    FROM mata_kuliah mk
                    JOIN absensi a ON mk.id = a.matkul_id
                    WHERE a.mahasiswa_id = :mahasiswa_id
                    ORDER BY mk.semester ASC, mk.nama ASC";
            $this->db->query($sql);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Ambil semua mata kuliah berdasarkan prodi mahasiswa
     * (menampilkan semua matkul yang kodenya sesuai dengan prodi mahasiswa)
     * Digunakan untuk upload surat izin
     */
    public function getMatkulByProdi($mahasiswa_id) {
        try {
            // 1. Ambil kode prodi dari mahasiswa
            $sql_prodi = "SELECT kelas FROM mahasiswa WHERE id = :mahasiswa_id";
            $this->db->query($sql_prodi);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $mahasiswa = $this->db->single();
            $kode_prodi = $mahasiswa['kelas'] ?? '';
            
            if (empty($kode_prodi)) {
                return [];
            }
            
            // 2. Ambil SEMUA mata kuliah berdasarkan kode prodi
            $sql = "SELECT 
                        mk.id, 
                        mk.kode, 
                        mk.nama, 
                        mk.sks, 
                        mk.semester,
                        mk.jumlah_pertemuan
                    FROM mata_kuliah mk
                    WHERE mk.kode LIKE :kode_prodi
                    ORDER BY mk.semester ASC, mk.nama ASC";
            
            $this->db->query($sql);
            $this->db->bind(':kode_prodi', $kode_prodi . '%');
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in getMatkulByProdi: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Ambil rekap absensi per mata kuliah
     * MENAMPILKAN SEMUA MATA KULIAH SESUAI PRODI MAHASISWA
     * (tanpa perlu menunggu absensi dari dosen)
     */
    public function getRekapPerMatkul($mahasiswa_id) {
        try {
            // 1. Ambil kode prodi dari mahasiswa
            $sql_prodi = "SELECT kelas FROM mahasiswa WHERE id = :mahasiswa_id";
            $this->db->query($sql_prodi);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $mahasiswa = $this->db->single();
            $kode_prodi = $mahasiswa['kelas'] ?? '';
            
            if (empty($kode_prodi)) {
                return [];
            }
            
            // 2. Ambil SEMUA mata kuliah berdasarkan kode prodi
            $sql_matkul = "SELECT 
                                mk.id, 
                                mk.kode, 
                                mk.nama, 
                                mk.sks, 
                                mk.semester,
                                mk.jumlah_pertemuan as total_pertemuan
                           FROM mata_kuliah mk
                           WHERE mk.kode LIKE :kode_prodi
                           ORDER BY mk.semester ASC, mk.nama ASC";
            
            $this->db->query($sql_matkul);
            $this->db->bind(':kode_prodi', $kode_prodi . '%');
            $all_matkul = $this->db->resultSet();
            
            if (empty($all_matkul)) {
                return [];
            }
            
            // 3. Ambil data absensi mahasiswa (status Hadir, Sakit, Izin, Alpa)
            $sql_absensi = "SELECT 
                                mk.id as matkul_id,
                                SUM(CASE WHEN a.status = 'Hadir' THEN 1 ELSE 0 END) as hadir,
                                SUM(CASE WHEN a.status = 'Sakit' THEN 1 ELSE 0 END) as sakit,
                                SUM(CASE WHEN a.status = 'Izin' THEN 1 ELSE 0 END) as izin,
                                SUM(CASE WHEN a.status = 'Alpa' THEN 1 ELSE 0 END) as alpa
                            FROM absensi a
                            JOIN mata_kuliah mk ON a.matkul_id = mk.id
                            WHERE a.mahasiswa_id = :mahasiswa_id
                            GROUP BY mk.id";
            
            $this->db->query($sql_absensi);
            $this->db->bind(':mahasiswa_id', $mahasiswa_id);
            $absensi_data = $this->db->resultSet();
            
            // 4. Gabungkan: semua matkul + data absensi (jika ada)
            $result = [];
            foreach ($all_matkul as $matkul) {
                // Cari data absensi untuk matkul ini
                $hadir = 0;
                $sakit = 0;
                $izin = 0;
                $alpa = 0;
                
                foreach ($absensi_data as $abs) {
                    if ($abs['matkul_id'] == $matkul['id']) {
                        $hadir = $abs['hadir'];
                        $sakit = $abs['sakit'];
                        $izin = $abs['izin'];
                        $alpa = $abs['alpa'];
                        break;
                    }
                }
                
                $result[] = [
                    'id' => $matkul['id'],
                    'kode' => $matkul['kode'],
                    'nama' => $matkul['nama'],
                    'sks' => $matkul['sks'],
                    'semester' => $matkul['semester'],
                    'total_pertemuan' => $matkul['total_pertemuan'],
                    'hadir' => $hadir,
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'alpa' => $alpa
                ];
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in getRekapPerMatkul: " . $e->getMessage());
            return [];
        }
    }
    
    // ========== METHOD UNTUK ADMIN & DOSEN ==========
    
    /**
     * Hitung total absensi hari ini (dari semua mahasiswa)
     * Digunakan untuk statistik dashboard admin
     */
    public function countAbsensiHariIni() {
        try {
            $sql = "SELECT COUNT(*) as total FROM absensi WHERE tanggal = CURDATE()";
            $this->db->query($sql);
            $result = $this->db->single();
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Hitung total absensi berdasarkan filter (untuk dosen)
     * @param string|null $tanggal Filter tanggal
     * @param int|null $matkul_id Filter mata kuliah
     * @param int|null $kelas Filter kelas
     * @return int Jumlah absensi
     */
    public function countAbsensiByFilter($tanggal = null, $matkul_id = null, $kelas = null) {
        try {
            $sql = "SELECT COUNT(*) as total FROM absensi a
                    JOIN mahasiswa m ON a.mahasiswa_id = m.id
                    WHERE 1=1";
            
            if ($tanggal) {
                $sql .= " AND a.tanggal = :tanggal";
            }
            if ($matkul_id) {
                $sql .= " AND a.matkul_id = :matkul_id";
            }
            if ($kelas) {
                $sql .= " AND m.kelas = :kelas";
            }
            
            $this->db->query($sql);
            
            if ($tanggal) {
                $this->db->bind(':tanggal', $tanggal);
            }
            if ($matkul_id) {
                $this->db->bind(':matkul_id', $matkul_id);
            }
            if ($kelas) {
                $this->db->bind(':kelas', $kelas);
            }
            
            $result = $this->db->single();
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /**
     * Ambil semua absensi dengan filter (untuk dosen / rekap)
     * @param string|null $tanggal Filter tanggal
     * @param int|null $matkul_id Filter mata kuliah
     * @param int|null $kelas Filter kelas
     * @return array Daftar absensi
     */
    public function getAllAbsensiWithFilter($tanggal = null, $matkul_id = null, $kelas = null) {
        try {
            $sql = "SELECT a.*, 
                           m.nama as mahasiswa_nama, m.nim, m.kelas,
                           mk.nama as mata_kuliah, mk.kode
                    FROM absensi a
                    JOIN mahasiswa m ON a.mahasiswa_id = m.id
                    JOIN mata_kuliah mk ON a.matkul_id = mk.id
                    WHERE 1=1";
            
            if ($tanggal) {
                $sql .= " AND a.tanggal = :tanggal";
            }
            if ($matkul_id) {
                $sql .= " AND a.matkul_id = :matkul_id";
            }
            if ($kelas) {
                $sql .= " AND m.kelas = :kelas";
            }
            
            $sql .= " ORDER BY a.tanggal DESC, m.nama ASC";
            
            $this->db->query($sql);
            
            if ($tanggal) {
                $this->db->bind(':tanggal', $tanggal);
            }
            if ($matkul_id) {
                $this->db->bind(':matkul_id', $matkul_id);
            }
            if ($kelas) {
                $this->db->bind(':kelas', $kelas);
            }
            
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Ambil statistik absensi per mata kuliah (untuk dosen)
     * @param int|null $matkul_id Filter mata kuliah
     * @return array Statistik
     */
    public function getStatistikPerMatkul($matkul_id = null) {
        try {
            $sql = "SELECT mk.id, mk.kode, mk.nama, mk.sks, mk.jumlah_pertemuan,
                    COUNT(a.id) as total_absensi,
                    SUM(CASE WHEN a.status = 'Hadir' THEN 1 ELSE 0 END) as hadir,
                    SUM(CASE WHEN a.status = 'Sakit' THEN 1 ELSE 0 END) as sakit,
                    SUM(CASE WHEN a.status = 'Izin' THEN 1 ELSE 0 END) as izin,
                    SUM(CASE WHEN a.status = 'Alpa' THEN 1 ELSE 0 END) as alpa
                    FROM mata_kuliah mk
                    LEFT JOIN absensi a ON mk.id = a.matkul_id";
            
            if ($matkul_id) {
                $sql .= " WHERE mk.id = :matkul_id";
            }
            
            $sql .= " GROUP BY mk.id, mk.kode, mk.nama, mk.sks, mk.jumlah_pertemuan
                      ORDER BY mk.nama ASC";
            
            $this->db->query($sql);
            
            if ($matkul_id) {
                $this->db->bind(':matkul_id', $matkul_id);
            }
            
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }
}