<?php

namespace App\Models;

use App\Core\BaseModel;

class Mahasiswa extends BaseModel
{
    // Encapsulation: private properties
    private $id;
    private $nim;
    private $nama;
    private $jurusan;
    private $tipe; // 'mahasiswa', 'dosen', 'matkul'
    
    // Session keys
    private $sessionKeys = [
        'mahasiswa' => 'daftar_mahasiswa',
        'dosen' => 'daftar_dosen',
        'matkul' => 'daftar_matkul'
    ];

    // Constructor
    public function __construct()
    {
        parent::__construct();
        $this->initSessionData();
    }

    // ==========================================
    // INITIALIZATION (DATA DUMMY)
    // ==========================================

    private function initSessionData()
    {
        // Data dummy Mahasiswa
        if (!isset($_SESSION['daftar_mahasiswa'])) {
            $_SESSION['daftar_mahasiswa'] = [
                ['id' => 1, 'nim' => '422025016', 'nama' => 'Federico', 'jurusan' => 'Teknik Informatika'],
                ['id' => 2, 'nim' => '422025014', 'nama' => 'Farrel', 'jurusan' => 'Sistem Informasi']
            ];
        }
        
        // Data dummy Dosen
        if (!isset($_SESSION['daftar_dosen'])) {
            $_SESSION['daftar_dosen'] = [
                ['id' => 1, 'nidn' => 'D001', 'nama' => 'Aldo, M.T.', 'jurusan' => 'Dosen OOP']
            ];
        }
        
        // Data dummy Mata Kuliah
        if (!isset($_SESSION['daftar_matkul'])) {
            $_SESSION['daftar_matkul'] = [
                ['id' => 1, 'kode' => 'MK01', 'nama' => 'Object Oriented Programming', 'sks' => 3]
            ];
        }
    }

    // ==========================================
    // SETTER METHODS (Encapsulation)
    // ==========================================

    public function setId($id)
    {
        $this->id = (int)$id;
        return $this;
    }

    public function setNim($nim)
    {
        $this->nim = htmlspecialchars(trim($nim));
        return $this;
    }

    public function setNama($nama)
    {
        $this->nama = htmlspecialchars(trim($nama));
        return $this;
    }

    public function setJurusan($jurusan)
    {
        $this->jurusan = htmlspecialchars(trim($jurusan));
        return $this;
    }

    public function setTipe($tipe)
    {
        $this->tipe = $tipe;
        return $this;
    }

    // ==========================================
    // GETTER METHODS (Encapsulation)
    // ==========================================

    public function getId()
    {
        return $this->id;
    }

    public function getNim()
    {
        return $this->nim;
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function getJurusan()
    {
        return $this->jurusan;
    }

    public function getTipe()
    {
        return $this->tipe;
    }

    private function getSessionKey()
    {
        return $this->sessionKeys[$this->tipe];
    }

    // ==========================================
    // CRUD METHODS (Implementasi abstract class)
    // ==========================================

    public function save()
    {
        $sessionKey = $this->getSessionKey();
        
        if ($this->id && $this->id > 0) {
            // UPDATE mode
            foreach ($_SESSION[$sessionKey] as $key => $item) {
                if ($item['id'] == $this->id) {
                    $_SESSION[$sessionKey][$key]['nim'] = $this->nim;
                    $_SESSION[$sessionKey][$key]['nama'] = $this->nama;
                    $_SESSION[$sessionKey][$key]['jurusan'] = $this->jurusan;
                    return true;
                }
            }
            return false;
        } else {
            // CREATE mode
            $newId = count($_SESSION[$sessionKey]) > 0 
                     ? max(array_column($_SESSION[$sessionKey], 'id')) + 1 
                     : 1;
            
            $newData = [
                'id' => $newId,
                'nim' => $this->nim,
                'nama' => $this->nama,
                'jurusan' => $this->jurusan
            ];
            
            $_SESSION[$sessionKey][] = $newData;
            $this->id = $newId;
            return true;
        }
    }

    public function delete()
    {
        $sessionKey = $this->getSessionKey();
        
        foreach ($_SESSION[$sessionKey] as $key => $item) {
            if ($item['id'] == $this->id) {
                unset($_SESSION[$sessionKey][$key]);
                $_SESSION[$sessionKey] = array_values($_SESSION[$sessionKey]);
                return true;
            }
        }
        return false;
    }

    public function validate()
    {
        $errors = [];
        
        if (empty($this->nim)) {
            $errors[] = "NIM / NIDN / Kode tidak boleh kosong";
        }
        
        if (empty($this->nama)) {
            $errors[] = "Nama tidak boleh kosong";
        }
        
        if (strlen($this->nama) < 3) {
            $errors[] = "Nama minimal 3 karakter";
        }
        
        if (empty($this->jurusan)) {
            $errors[] = "Jurusan / Prodi tidak boleh kosong";
        }
        
        return $errors;
    }

    // ==========================================
    // ADDITIONAL METHODS (READ)
    // ==========================================

    public function getAllMahasiswa()
    {
        return $_SESSION['daftar_mahasiswa'];
    }

    public function getAllDosen()
    {
        return $_SESSION['daftar_dosen'];
    }

    public function getAllMatkul()
    {
        return $_SESSION['daftar_matkul'];
    }

    public function findById($id, $tipe)
    {
        $sessionKey = $this->sessionKeys[$tipe];
        
        foreach ($_SESSION[$sessionKey] as $item) {
            if ($item['id'] == $id) {
                $this->id = $item['id'];
                $this->nim = $item['nim'] ?? $item['nidn'] ?? $item['kode'] ?? '';
                $this->nama = $item['nama'];
                $this->jurusan = $item['jurusan'] ?? $item['sks'] ?? '';
                $this->tipe = $tipe;
                return $this;
            }
        }
        return null;
    }

    public function findByIdDinamis($id, $tipe)
    {
        $sessionKey = $this->sessionKeys[$tipe];
        
        foreach ($_SESSION[$sessionKey] as $item) {
            if ($item['id'] == $id) {
                return $item;
            }
        }
        return null;
    }

    public function tambahDinamis($data, $tipe)
    {
        $this->setTipe($tipe);
        $this->setNim($data['nim']);
        $this->setNama($data['nama']);
        $this->setJurusan($data['jurusan']);
        
        return $this->save();
    }

    public function updateDinamis($data, $id, $tipe)
    {
        $this->setTipe($tipe);
        $this->setId($id);
        $this->setNim($data['nim']);
        $this->setNama($data['nama']);
        $this->setJurusan($data['jurusan']);
        
        return $this->save();
    }

    public function deleteDinamis($id, $tipe)
    {
        $this->setTipe($tipe);
        $this->setId($id);
        
        return $this->delete();
    }

    public function getTotalCount($tipe)
    {
        $sessionKey = $this->sessionKeys[$tipe];
        return count($_SESSION[$sessionKey]);
    }

    public function search($keyword, $tipe)
    {
        $sessionKey = $this->sessionKeys[$tipe];
        $results = [];
        
        $keyword = strtolower($keyword);
        
        foreach ($_SESSION[$sessionKey] as $item) {
            if (strpos(strtolower($item['nama']), $keyword) !== false ||
                strpos(strtolower($item['nim'] ?? $item['nidn'] ?? $item['kode'] ?? ''), $keyword) !== false) {
                $results[] = $item;
            }
        }
        
        return $results;
    }

    public function getStatistik()
    {
        return [
            'mahasiswa' => count($_SESSION['daftar_mahasiswa']),
            'dosen' => count($_SESSION['daftar_dosen']),
            'matkul' => count($_SESSION['daftar_matkul'])
        ];
    }
}