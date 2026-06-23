<?php

abstract class BaseModel {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance(); // Pakai Singleton
    }

    // ==========================================
    // METHOD UNTUK MEMUAT MODEL LAIN
    // ==========================================
    
    /**
     * Load another model
     * @param string $model Nama model (contoh: 'Mahasiswa', 'Dosen')
     * @return object Instance model yang diminta
     */
    public function model($model) {
        $modelClass = $model;
        $filePath = __DIR__ . '/../models/' . $modelClass . '.php';
        
        if (file_exists($filePath)) {
            require_once $filePath;
            return new $modelClass();
        }
        
        throw new Exception("Model '$modelClass' not found at: " . $filePath);
    }

    // ==========================================
    // METHOD CRUD DASAR
    // ==========================================
    
    /**
     * Ambil semua data
     * @return array
     */
    public function getAll() {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id DESC");
        return $this->db->resultSet();
    }

    /**
     * Ambil data berdasarkan ID
     * @param int $id
     * @return array|null
     */
    public function getById($id) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Hapus data berdasarkan ID
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $this->db->query("DELETE FROM " . $this->table . " WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // ==========================================
    // METHOD TAMBAHAN
    // ==========================================
    
    /**
     * Hitung jumlah data
     * @return int
     */
    public function count() {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }
    
    /**
     * Cek apakah data ada berdasarkan ID
     * @param int $id
     * @return bool
     */
    public function exists($id) {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table . " WHERE id = :id");
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        return ($result['total'] ?? 0) > 0;
    }
    
    /**
     * Ambil data dengan limit (untuk pagination)
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getPaginated($limit, $offset) {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
    
    /**
     * Ambil data terbaru
     * @param int $limit
     * @return array
     */
    public function getLatest($limit = 5) {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id DESC LIMIT :limit");
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    // ==========================================
    // METHOD ABSTRAK (WAJIB DIIMPLEMENTASIKAN OLEH CHILD CLASS)
    // ==========================================
    
    /**
     * Method untuk validasi data sebelum save
     * @return array Daftar error
     */
    abstract public function validate();
    
    /**
     * Method untuk menyimpan data (insert atau update)
     * @return array Hasil operasi
     */
    abstract public function save();
}