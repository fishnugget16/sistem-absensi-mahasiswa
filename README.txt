Aplikasi Absensi Mahasiswa

###############
STRUKTUR FOLDER
###############

sistem-absensi-oop/
│
├── app/
│ ├── core/
│ │ ├── BaseModel.php
│ │ ├── Database.php
│ │ ├── Controller.php
│ │ └── Router.php
│ │
│ ├── interfaces/
│ │ └── Exportable.php
│ │
│ ├── models/
│ │ ├── User.php
│ │ ├── Dosen.php
│ │ ├── Mahasiswa.php
│ │ ├── MataKuliah.php
│ │ ├── Absensi.php
│ │ ├── RekapAbsensi.php
│ │ └── SuratIzin.php
│ │
│ ├── controllers/
│ │ ├── AuthController.php
│ │ ├── AdminController.php
│ │ ├── DosenController.php
│ │ ├── MahasiswaController.php
│ │ └── ExportController.php
│ │
│ └── views/
│ ├── auth/
│ │ ├── login.php
│ │ └── dashboard.php
│ │
│ ├── admin/
│ │ ├── mahasiswa/
│ │ │ ├── index.php
│ │ │ ├── create.php
│ │ │ └── edit.php
│ │ │
│ │ ├── dosen/
│ │ │ ├── index.php
│ │ │ ├── create.php
│ │ │ └── edit.php
│ │ │
│ │ └── matakuliah/
│ │ ├── index.php
│ │ ├── create.php
│ │ └── edit.php
│ │
│ ├── dosen/
│ │ └── absensi/
│ │ ├── input.php
│ │ ├── rekap.php
│ │ └── search.php
│ │
│ └── mahasiswa/
│ ├── absensi/
│ │ └── lihat.php
│ └── surat/
│ └── upload.php
│
├── config/
│ ├── database.php
│ └── config.php
│
├── public/
│ ├── index.php
│ ├── .htaccess
│ ├── css/
│ │ └── style.css
│ ├── js/
│ │ └── script.js
│ └── uploads/
│ └── surat/
│
├── sql/
│ └── database.sql
│
├── .gitignore
├── README.md
└── .env