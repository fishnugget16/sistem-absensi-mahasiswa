<?php

abstract class BaseModel {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance(); // Pakai Singleton, bukan new Database()
    }

    // ==========================================
    // METHOD YANG SUDAH ADA DI KODE LAMA
    // ==========================================
    
    public function getAll() {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id DESC");
        return $this->db->resultSet();
    }

    public function getById($id) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM " . $this->table . " WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // ==========================================
    // METHOD TAMBAHAN (AGAR LEBIH LENGKAP)
    // ==========================================
    
    // Hitung jumlah data
    public function count() {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        $result = $this->db->single();
        return $result['total'];
    }
    
    // Cek apakah data ada berdasarkan ID
    public function exists($id) {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table . " WHERE id = :id");
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result['total'] > 0;
    }
    
    // Ambil data dengan limit (untuk pagination)
    public function getPaginated($limit, $offset) {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $this->db->bind(':limit', $limit);
        $this->db->bind(':offset', $offset);
        return $this->db->resultSet();
    }
    
    // Ambil data terbaru (misal: 5 data terakhir)
    public function getLatest($limit = 5) {
        $this->db->query("SELECT * FROM " . $this->table . " ORDER BY id DESC LIMIT :limit");
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    // ==========================================
    // METHOD ABSTRAK (WAJIB DIIMPLEMENTASIKAN OLEH CHILD CLASS)
    // ==========================================
    
    // Method untuk validasi data sebelum save
    abstract public function validate();
    
    // Method untuk menyimpan data (insert atau update)
    abstract public function save();
}