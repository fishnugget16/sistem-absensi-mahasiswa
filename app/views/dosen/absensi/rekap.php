<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Rekap Absensi - Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        /* ===== BASE STYLE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
            overflow-x: hidden;
        }

        .navbar-custom {
            background: #1e1e1e;
            padding: 12px 24px;
            border-bottom: 1px solid #2a2a2a;
            position: sticky;
            top: 0;
            z-index: 1001;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            min-height: 60px;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
            height: 100%;
        }

        .toggle-btn {
            background: transparent;
            border: none;
            color: #e8eaed;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 4px;
            transition: background 0.2s;
            height: 36px;
            width: 36px;
        }

        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            cursor: default;
            pointer-events: none;
            user-select: none;
            height: 36px;
            line-height: 1;
        }

        .navbar-brand i {
            color: #4caf50;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .navbar-brand span {
            color: #e8eaed;
            font-size: 18px;
            font-weight: 500;
            display: flex;
            align-items: center;
            height: 24px;
            line-height: 24px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
            height: 100%;
        }

        .user-info {
            color: #9aa0a6;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-info i {
            color: #4caf50;
            font-size: 16px;
        }

        .logout-link {
            color: #dc3545 !important;
            font-size: 14px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .logout-link:hover {
            color: #ef5350 !important;
        }

        .side-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100%;
            background: #1e1e1e;
            border-right: 1px solid #2a2a2a;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1050;
            overflow-y: auto;
        }

        .side-menu-overlay.open {
            transform: translateX(0);
        }

        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1040;
            display: none;
        }

        .sidebar-backdrop.show {
            display: block;
        }

        .side-menu-overlay .nav-menu {
            list-style: none;
            padding: 20px 16px 20px 16px;
            margin-top: 0;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            margin-bottom: 4px;
            cursor: default;
            pointer-events: none;
            user-select: none;
            min-height: 48px;
            border-radius: 10px;
        }

        .sidebar-brand i {
            color: #4caf50;
            font-size: 16px;
            width: 22px;
            text-align: center;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .sidebar-brand span {
            color: #e8eaed;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            line-height: 1;
        }

        .side-menu-overlay .nav-item {
            margin-bottom: 4px;
        }

        .side-menu-overlay .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: #9aa0a6;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s;
            cursor: pointer;
            min-height: 48px;
        }

        .side-menu-overlay .nav-link i {
            width: 22px;
            font-size: 16px;
            text-align: center;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .side-menu-overlay .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #e8eaed;
        }

        .side-menu-overlay .nav-link.active {
            background: rgba(76, 175, 80, 0.15);
            color: #4caf50;
        }

        .side-menu-overlay .nav-link.logout {
            color: #ef5350;
            margin-top: 30px;
        }

        .side-menu-overlay .nav-link.logout:hover {
            background: rgba(239, 83, 80, 0.1);
            color: #ef5350;
        }

        .main-content {
            width: 100%;
            min-height: calc(100vh - 60px);
        }

        .header-panel {
            background: linear-gradient(135deg, #1a2a1a 0%, #1e1e1e 100%);
            padding: 28px 32px;
            margin-bottom: 28px;
            border-bottom: 1px solid #2a2a2a;
        }

        .header-title {
            margin-bottom: 0;
        }

        .header-title h2 {
            font-size: 24px;
            font-weight: 500;
            color: #e8eaed;
            margin-bottom: 6px;
        }

        .header-title h2 i {
            color: #4caf50;
            margin-right: 10px;
        }

        .header-title p {
            font-size: 13px;
            color: #9aa0a6;
            margin: 0;
        }

        .main-container {
            padding: 0 32px 40px 32px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        /* ===== FORM FILTER ===== */
        .filter-card {
            background: #1e1e1e;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #2a2a2a;
            width: 100%;
            margin-bottom: 28px;
        }

        .filter-card h4 {
            color: #e8eaed;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #2a2a2a;
        }

        .filter-card h4 i {
            color: #4caf50;
            margin-right: 10px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            align-items: end;
        }

        .filter-group {
            margin-bottom: 0;
        }

        .filter-group label {
            color: #9aa0a6;
            font-size: 12px;
            font-weight: 500;
            display: block;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .filter-group label i {
            color: #4caf50;
            margin-right: 4px;
        }

        .filter-group .form-control {
            background: #2a2a2a;
            border: 1px solid #3c4043;
            border-radius: 8px;
            color: #e8eaed;
            padding: 8px 12px;
            font-size: 13px;
            transition: all 0.2s;
            width: 100%;
            min-height: 42px;
            font-family: 'Roboto', sans-serif;
        }

        .filter-group .form-control:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
            background: #2a2a2a;
            color: #e8eaed;
        }

        .filter-group .form-control::placeholder {
            color: #5f6368;
        }

        /* ===== CUSTOM SELECT MATA KULIAH ===== */
        .custom-select-container {
            position: relative;
            width: 100%;
        }

        .custom-select-trigger {
            background: #2a2a2a;
            border: 1px solid #3c4043;
            border-radius: 8px;
            padding: 8px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s;
            color: #e8eaed;
            font-size: 13px;
            min-height: 42px;
            font-family: 'Roboto', sans-serif;
        }

        .custom-select-trigger:hover {
            border-color: #4caf50;
        }

        .custom-select-trigger.open {
            border-color: #4caf50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
        }

        .custom-select-trigger i {
            transition: transform 0.2s;
            color: #9aa0a6;
        }

        .custom-select-trigger.open i {
            transform: rotate(180deg);
        }

        .custom-select-trigger .selected-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .custom-select-options {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #1e1e1e;
            border: 1px solid #3c4043;
            border-radius: 8px;
            margin-top: 4px;
            z-index: 100;
            display: none;
            max-height: 280px;
            overflow: hidden;
            flex-direction: column;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .custom-select-options.show {
            display: flex;
        }

        .custom-select-options .options-list {
            overflow-y: auto;
            max-height: 220px;
        }

        .custom-select-options .options-list::-webkit-scrollbar {
            width: 6px;
        }

        .custom-select-options .options-list::-webkit-scrollbar-track {
            background: #2a2a2a;
            border-radius: 3px;
        }

        .custom-select-options .options-list::-webkit-scrollbar-thumb {
            background: #4caf50;
            border-radius: 3px;
        }

        .option-item {
            padding: 10px 12px;
            cursor: pointer;
            transition: all 0.2s;
            color: #e8eaed;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #1a1a1a;
            font-family: 'Roboto', sans-serif;
        }

        .option-item:last-child {
            border-bottom: none;
        }

        .option-item i {
            width: 20px;
            font-size: 14px;
            color: #4caf50;
        }

        .option-item:hover {
            background: rgba(76, 175, 80, 0.1);
        }

        .option-item.selected {
            background: rgba(76, 175, 80, 0.2);
            color: #4caf50;
        }

        /* ===== CUSTOM DATE INPUT ===== */
        .date-trigger-wrapper {
            position: relative;
            width: 100%;
        }

        .date-trigger {
            background: #2a2a2a;
            border: 1px solid #3c4043;
            border-radius: 8px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.2s;
            min-height: 42px;
            color: #e8eaed;
            font-size: 13px;
            font-family: 'Roboto', sans-serif;
        }

        .date-trigger:hover {
            border-color: #4caf50;
        }

        .date-trigger i {
            color: #4caf50;
            font-size: 18px;
            flex-shrink: 0;
        }

        .date-trigger .date-display {
            flex: 1;
            font-weight: 500;
        }

        .date-trigger .date-arrow {
            color: #9aa0a6;
            transition: transform 0.2s;
            flex-shrink: 0;
        }

        .date-trigger:hover .date-arrow {
            transform: translateX(3px);
        }

        /* ===== MODAL DATE PICKER ===== */
        .date-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .date-modal-overlay.show {
            display: flex;
        }

        .date-modal-content {
            background: #1e1e1e;
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            max-height: 90vh;
            border: 1px solid #2a2a2a;
            animation: modalFadeIn 0.3s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .date-modal-header {
            padding: 20px 24px 12px 24px;
            border-bottom: 1px solid #2a2a2a;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .date-modal-header h4 {
            color: #e8eaed;
            font-size: 18px;
            font-weight: 500;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Roboto', sans-serif;
        }

        .date-modal-header h4 i {
            color: #4caf50;
            font-size: 18px;
        }

        .date-modal-close {
            background: transparent;
            border: none;
            color: #9aa0a6;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.2s;
            padding: 0 4px;
        }

        .date-modal-close:hover {
            color: #dc3545;
            transform: rotate(90deg);
        }

        .date-modal-body {
            padding: 20px 24px 16px 24px;
            overflow-y: auto;
            max-height: 60vh;
        }

        .date-wheel-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            padding: 10px 0 15px 0;
            position: relative;
        }

        .date-wheel-container::before,
        .date-wheel-container::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            height: 35px;
            pointer-events: none;
            z-index: 2;
        }

        .date-wheel-container::before {
            top: 0;
            background: linear-gradient(to bottom, #1e1e1e, transparent);
        }

        .date-wheel-container::after {
            bottom: 0;
            background: linear-gradient(to top, #1e1e1e, transparent);
        }

        .date-wheel-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            max-width: 120px;
            position: relative;
            z-index: 3;
        }

        .date-wheel {
            width: 100%;
            height: 120px;
            overflow-y: auto;
            scroll-snap-type: y mandatory;
            padding: 40px 0;
            position: relative;
            scroll-behavior: smooth;
        }

        .date-wheel::-webkit-scrollbar {
            display: none;
        }

        .date-wheel {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .date-wheel-item {
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5f6368;
            font-size: 16px;
            scroll-snap-align: center;
            transition: all 0.2s ease;
            cursor: pointer;
            font-weight: 400;
            padding: 0 4px;
            text-align: center;
            user-select: none;
            font-family: 'Roboto', sans-serif;
        }

        .date-wheel-item:hover {
            color: #9aa0a6;
        }

        .date-wheel-item.active {
            color: #4caf50;
            font-size: 24px;
            font-weight: 600;
            text-shadow: 0 0 30px rgba(76, 175, 80, 0.15);
        }

        .date-wheel-label {
            font-size: 11px;
            color: #5f6368;
            text-align: center;
            margin-top: 8px;
            font-weight: 400;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-family: 'Roboto', sans-serif;
        }

        .date-modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #2a2a2a;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-cancel-date {
            background: #3c4043;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            color: white;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Roboto', sans-serif;
        }

        .btn-cancel-date:hover {
            background: #4a4e54;
        }

        .btn-confirm-date {
            background: #4caf50;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            color: white;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Roboto', sans-serif;
        }

        .btn-confirm-date:hover {
            background: #43a047;
            transform: translateY(-1px);
        }

        /* ===== TABLE ===== */
        .table-card {
            background: #1e1e1e;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #2a2a2a;
            width: 100%;
        }

        .table-card .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #2a2a2a;
            flex-wrap: wrap;
            gap: 12px;
        }

        .table-card .table-header h4 {
            color: #e8eaed;
            font-size: 18px;
            font-weight: 500;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .table-card .table-header h4 i {
            color: #4caf50;
            margin-right: 10px;
        }

        .table-card .table-header .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .table-card .table-header .badge-total {
            background: rgba(76, 175, 80, 0.15);
            color: #4caf50;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
        }

        .btn-export-pdf {
            background: #dc3545;
            border: none;
            padding: 6px 16px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            min-height: 34px;
            font-family: 'Roboto', sans-serif;
        }

        .btn-export-pdf:hover {
            background: #c82333;
            transform: translateY(-1px);
            color: white;
        }

        .btn-export-pdf i {
            font-size: 14px;
        }

        /* ===== TABLE WRAPPER - FIX TEARING ===== */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid #2a2a2a;
            background: #1e1e1e;
        }

        .table-dark-custom {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            color: #e8eaed;
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            table-layout: fixed;
        }

        /* === KOLOM WIDTH === */
        .table-dark-custom .col-no {
            width: 40px;
            text-align: center;
        }
        .table-dark-custom .col-tanggal {
            width: 100px;
        }
        .table-dark-custom .col-nim {
            width: 115px;
        }
        .table-dark-custom .col-nama {
            width: 150px;
        }
        .table-dark-custom .col-kelas {
            width: 130px;
        }
        .table-dark-custom .col-matkul {
            width: 160px;
        }
        .table-dark-custom .col-kode {
            width: 70px;
        }
        .table-dark-custom .col-status {
            width: 100px;
            text-align: center;
        }

        .table-dark-custom thead {
            background: #161616;
            border-bottom: 2px solid #2a2a2a;
        }

        .table-dark-custom th {
            text-align: left;
            padding: 12px 12px;
            font-weight: 600;
            font-size: 11px;
            color: #9aa0a6;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-family: 'Roboto', sans-serif;
            white-space: nowrap;
            border-bottom: 2px solid #2a2a2a;
            background: #161616;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        .table-dark-custom td {
            padding: 11px 12px;
            border-bottom: 1px solid #1a1a1a;
            vertical-align: middle;
            font-family: 'Roboto', sans-serif;
            background: transparent;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table-dark-custom tbody tr {
            transition: background 0.15s ease;
        }

        .table-dark-custom tbody tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .table-dark-custom tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== CLASS BADGE ===== */
        .class-badge {
            display: inline-block;
            padding: 2px 10px;
            background: rgba(76, 175, 80, 0.1);
            border-radius: 4px;
            color: #4caf50;
            font-size: 11px;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            border: 1px solid rgba(76, 175, 80, 0.12);
            white-space: nowrap;
            letter-spacing: 0.2px;
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }

        /* ===== STATUS BADGE ===== */
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            min-width: 65px;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            letter-spacing: 0.2px;
            white-space: nowrap;
        }

        .status-badge.hadir {
            background: rgba(76, 175, 80, 0.15);
            color: #4caf50;
        }

        .status-badge.sakit {
            background: rgba(255, 152, 0, 0.15);
            color: #ff9800;
        }

        .status-badge.izin {
            background: rgba(33, 150, 243, 0.15);
            color: #2196f3;
        }

        .status-badge.alpa {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .status-badge .status-icon {
            font-size: 10px;
        }

        .text-ellipsis {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 100%;
        }

        .alert-success-custom {
            background: #1a2c1a;
            border-left: 3px solid #4caf50;
            padding: 12px 16px;
            border-radius: 8px;
            color: #9aef9a;
            font-size: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Roboto', sans-serif;
        }

        .alert-success-custom i {
            color: #4caf50;
            font-size: 18px;
        }

        .alert-error-custom {
            background: #2c1a1a;
            border-left: 3px solid #dc3545;
            padding: 12px 16px;
            border-radius: 8px;
            color: #ef9a9a;
            font-size: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Roboto', sans-serif;
        }

        .alert-error-custom i {
            color: #dc3545;
            font-size: 18px;
        }

        .custom-confirm-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
            z-index: 1100;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .custom-confirm-overlay.show {
            display: flex;
        }

        .custom-confirm-dialog {
            background: #1e1e1e;
            border-radius: 16px;
            width: 90%;
            max-width: 400px;
            padding: 24px;
            border: 1px solid #2a2a2a;
            animation: modalFadeIn 0.2s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .confirm-icon {
            text-align: center;
            margin-bottom: 20px;
        }

        .confirm-icon i {
            font-size: 56px;
            color: #dc3545;
        }

        .confirm-title {
            text-align: center;
            color: #e8eaed;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 8px;
            font-family: 'Roboto', sans-serif;
        }

        .confirm-message {
            text-align: center;
            color: #9aa0a6;
            font-size: 14px;
            margin-bottom: 24px;
            line-height: 1.5;
            font-family: 'Roboto', sans-serif;
        }

        .confirm-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .confirm-buttons .btn-cancel-confirm {
            background: #3c4043;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Roboto', sans-serif;
        }

        .confirm-buttons .btn-cancel-confirm:hover {
            background: #4a4e54;
        }

        .confirm-buttons .btn-logout-confirm {
            background: #dc3545;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Roboto', sans-serif;
        }

        .confirm-buttons .btn-logout-confirm:hover {
            background: #c82333;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .filter-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .filter-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .header-panel {
                padding: 20px 20px;
            }
            .main-container {
                padding: 0 20px 30px 20px;
            }
            .filter-card {
                padding: 18px;
            }
            .table-card {
                padding: 18px;
            }
            .table-dark-custom .col-nama {
                width: 120px;
            }
            .table-dark-custom .col-matkul {
                width: 130px;
            }
        }

        @media (max-width: 768px) {
            .navbar-custom {
                padding: 10px 16px;
                min-height: 56px;
            }
            .header-panel {
                padding: 16px 16px;
            }
            .main-container {
                padding: 0 16px 24px 16px;
            }
            .filter-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .user-info span {
                display: none;
            }
            .logout-link span {
                display: none;
            }
            .navbar-brand span {
                display: none;
            }
            .table-dark-custom th,
            .table-dark-custom td {
                padding: 8px 10px;
                font-size: 12px;
            }
            .table-card .table-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .table-card .table-header .header-actions {
                width: 100%;
                justify-content: space-between;
            }
            .status-badge {
                font-size: 10px;
                padding: 2px 8px;
                min-width: 55px;
            }
            .btn-export-pdf {
                padding: 5px 12px;
                font-size: 12px;
                min-height: 30px;
            }
            .class-badge {
                font-size: 10px;
                padding: 2px 6px;
            }
            .table-dark-custom .col-nama {
                width: 100px;
            }
            .table-dark-custom .col-matkul {
                width: 110px;
            }
            .table-dark-custom .col-kelas {
                width: 100px;
            }
            .table-dark-custom .col-nim {
                width: 100px;
            }
            .table-dark-custom .col-tanggal {
                width: 80px;
            }
            .table-dark-custom .col-status {
                width: 80px;
            }
            .table-dark-custom .col-kode {
                width: 60px;
            }
        }

        @media (max-width: 576px) {
            .filter-card {
                padding: 14px;
            }
            .table-card {
                padding: 14px;
            }
            .table-dark-custom th,
            .table-dark-custom td {
                padding: 6px 8px;
                font-size: 11px;
            }
            .date-wheel-container {
                gap: 8px;
            }
            .date-wheel {
                height: 84px;
                padding: 24px 0;
            }
            .date-wheel-item {
                height: 28px;
                font-size: 12px;
            }
            .date-wheel-item.active {
                font-size: 18px;
            }
            .date-wheel-col {
                max-width: 70px;
            }
            .date-modal-body {
                padding: 16px;
            }
            .date-modal-header h4 {
                font-size: 16px;
            }
            .date-wheel-label {
                font-size: 9px;
                margin-top: 4px;
            }
            .class-badge {
                font-size: 9px;
                padding: 1px 5px;
            }
            .status-badge {
                font-size: 9px;
                padding: 2px 6px;
                min-width: 45px;
                gap: 2px;
            }
            .status-badge .status-icon {
                font-size: 8px;
            }
            .table-card .table-header .header-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 6px;
            }
            .btn-export-pdf {
                justify-content: center;
            }
            .table-dark-custom .col-nama {
                width: 70px;
            }
            .table-dark-custom .col-matkul {
                width: 80px;
            }
            .table-dark-custom .col-kelas {
                width: 80px;
            }
            .table-dark-custom .col-nim {
                width: 80px;
            }
            .table-dark-custom .col-tanggal {
                width: 70px;
            }
            .table-dark-custom .col-status {
                width: 70px;
            }
            .table-dark-custom .col-kode {
                width: 50px;
            }
            .table-dark-custom .col-no {
                width: 30px;
            }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<div class="navbar-custom">
    <div class="navbar-left">
        <button class="toggle-btn" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="navbar-brand">
            <i class="fas fa-graduation-cap"></i>
            <span>SENMA</span>
        </div>
    </div>
    <div class="navbar-right">
        <span class="user-info">
            <i class="fas fa-user-circle"></i>
            <span><?= htmlspecialchars($_SESSION['nama'] ?? 'Dosen'); ?></span>
        </span>
        <a href="#" class="logout-link" id="logoutBtn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<div class="side-menu-overlay" id="sideMenuOverlay">
    <ul class="nav-menu">
        <li class="sidebar-brand">
            <i class="fas fa-graduation-cap"></i>
            <span>SENMA</span>
        </li>

        <li class="nav-item">
            <a href="<?= BASEURL; ?>/DosenController/index" class="nav-link">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/DosenController/inputAbsensi" class="nav-link">
                <i class="fas fa-pen-alt"></i> Input Absensi
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/DosenController/rekapAbsensi" class="nav-link active">
                <i class="fas fa-chart-bar"></i> Rekap Absensi
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link logout" id="sideLogoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>

<!-- ===== CONFIRM LOGOUT ===== -->
<div id="customConfirmOverlay" class="custom-confirm-overlay">
    <div class="custom-confirm-dialog">
        <div class="confirm-icon">
            <i class="fas fa-sign-out-alt"></i>
        </div>
        <div class="confirm-title">Konfirmasi Logout</div>
        <div class="confirm-message" id="confirmMessage">
            Apakah Anda yakin ingin keluar dari sistem?
        </div>
        <div class="confirm-buttons">
            <button class="btn-cancel-confirm" id="confirmCancelBtn">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="btn-logout-confirm" id="confirmLogoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
    </div>
</div>

<!-- ===== MODAL DATE PICKER ===== -->
<div id="dateModal" class="date-modal-overlay">
    <div class="date-modal-content">
        <div class="date-modal-header">
            <h4>
                <i class="fas fa-calendar-alt"></i> Pilih Tanggal
            </h4>
            <button class="date-modal-close" id="dateModalClose">&times;</button>
        </div>
        <div class="date-modal-body">
            <div class="date-wheel-container">
                <div class="date-wheel-col">
                    <div class="date-wheel" id="dayWheel">
                        <!-- Akan di-generate oleh JavaScript -->
                    </div>
                    <div class="date-wheel-label">Hari</div>
                </div>
                <div class="date-wheel-col">
                    <div class="date-wheel" id="monthWheel">
                        <!-- Akan di-generate oleh JavaScript -->
                    </div>
                    <div class="date-wheel-label">Bulan</div>
                </div>
                <div class="date-wheel-col">
                    <div class="date-wheel" id="yearWheel">
                        <?php 
                        $currentYear = date('Y');
                        for ($y = $currentYear - 50; $y <= 3000; $y++): 
                        ?>
                        <div class="date-wheel-item" data-value="<?= $y; ?>">
                            <?= $y; ?>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <div class="date-wheel-label">Tahun</div>
                </div>
            </div>
        </div>
        <div class="date-modal-footer">
            <button class="btn-cancel-date" id="dateCancelBtn">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="btn-confirm-date" id="dateConfirmBtn">
                <i class="fas fa-check"></i> Pilih Tanggal
            </button>
        </div>
    </div>
</div>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-content">

    <!-- HEADER PANEL -->
    <div class="header-panel">
        <div class="header-title">
            <h2><i class="fas fa-chart-bar"></i> Rekap Absensi</h2>
            <p>Lihat dan filter data absensi mahasiswa</p>
        </div>
    </div>

    <!-- MAIN CONTAINER -->
    <div class="main-container">

        <!-- ===== FILTER CARD ===== -->
        <div class="filter-card">
            <h4><i class="fas fa-filter"></i> Filter Data</h4>

            <form action="<?= BASEURL; ?>/DosenController/rekapAbsensi" method="GET" id="formFilter">
                <div class="filter-grid">
                    <!-- Mata Kuliah - Custom Select -->
                    <div class="filter-group">
                        <label for="matkulSelect"><i class="fas fa-book"></i> Mata Kuliah</label>
                        <div class="custom-select-container" id="matkulSelectContainer">
                            <div class="custom-select-trigger" id="matkulSelectTrigger">
                                <span class="selected-text" id="selectedMatkulText">
                                    <?php 
                                    $selected_matkul_id = $data['filter_matkul'] ?? '';
                                    $selected_matkul_text = '-- Semua --';
                                    foreach ($data['matkul_list'] as $matkul) {
                                        if ($matkul['id'] == $selected_matkul_id) {
                                            $selected_matkul_text = htmlspecialchars($matkul['nama'] . ' (' . $matkul['kode'] . ')');
                                            break;
                                        }
                                    }
                                    echo $selected_matkul_text;
                                    ?>
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="custom-select-options" id="matkulSelectOptions">
                                <div class="options-list" id="matkulOptionsList">
                                    <div class="option-item <?= ($selected_matkul_id == '') ? 'selected' : ''; ?>" data-value="">
                                        <i class="fas fa-list"></i> -- Semua --
                                    </div>
                                    <?php foreach ($data['matkul_list'] as $matkul): ?>
                                    <div class="option-item <?= ($selected_matkul_id == $matkul['id']) ? 'selected' : ''; ?>" 
                                         data-value="<?= $matkul['id']; ?>">
                                        <i class="fas fa-book-open"></i> 
                                        <?= htmlspecialchars($matkul['nama'] . ' (' . $matkul['kode'] . ')'); ?>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="filter_matkul" id="selectedMatkulValue" value="<?= $data['filter_matkul']; ?>">
                    </div>

                    <!-- Tanggal - Custom Date Picker -->
                    <div class="filter-group">
                        <label for="dateTrigger"><i class="fas fa-calendar-day"></i> Tanggal</label>
                        <div class="date-trigger-wrapper">
                            <div class="date-trigger" id="dateTrigger">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="date-display" id="dateDisplay">
                                    <?= $data['filter_tanggal'] ? date('d F Y', strtotime($data['filter_tanggal'])) : '-- Pilih Tanggal --'; ?>
                                </span>
                                <i class="fas fa-chevron-right date-arrow"></i>
                            </div>
                        </div>
                        <input type="hidden" name="filter_tanggal" id="hiddenTanggal" value="<?= $data['filter_tanggal']; ?>">
                    </div>

                    <!-- Kelas -->
                    <div class="filter-group">
                        <label for="filter_kelas"><i class="fas fa-users"></i> Kelas</label>
                        <input type="text" name="filter_kelas" id="filter_kelas" class="form-control" 
                               placeholder="Contoh: TI-001-20262306" value="<?= htmlspecialchars($data['filter_kelas']); ?>">
                    </div>

                    <!-- NIM -->
                    <div class="filter-group">
                        <label for="filter_nim"><i class="fas fa-id-card"></i> NIM</label>
                        <input type="text" name="filter_nim" id="filter_nim" class="form-control" 
                               placeholder="Cari NIM..." value="<?= htmlspecialchars($data['filter_nim']); ?>">
                    </div>

                    <!-- Nama Mahasiswa -->
                    <div class="filter-group">
                        <label for="filter_nama"><i class="fas fa-user"></i> Nama Mahasiswa</label>
                        <input type="text" name="filter_nama" id="filter_nama" class="form-control" 
                               placeholder="Cari nama..." value="<?= htmlspecialchars($data['filter_nama']); ?>">
                    </div>
                </div>
            </form>
        </div>

        <!-- ===== TABLE CARD ===== -->
        <div class="table-card">
            <div class="table-header">
                <h4><i class="fas fa-list"></i> Data Absensi</h4>
                <div class="header-actions">
                    <span class="badge-total">
                        <i class="fas fa-database"></i> Total: <?= count($data['absensi']); ?> data
                    </span>
                    <a href="<?= BASEURL; ?>/DosenController/exportPDF?<?= http_build_query([
                        'filter_matkul' => $data['filter_matkul'],
                        'filter_tanggal' => $data['filter_tanggal'],
                        'filter_kelas' => $data['filter_kelas']
                    ]); ?>" 
                       class="btn-export-pdf" target="_blank">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>

            <?php if (empty($data['absensi'])): ?>
            <div class="alert-error-custom">
                <i class="fas fa-info-circle"></i>
                <span>Belum ada data absensi yang ditemukan. Coba ubah filter atau input absensi terlebih dahulu.</span>
            </div>
            <?php else: ?>

            <div class="table-wrapper">
                <table class="table-dark-custom">
                    <thead>
                        <tr>
                            <th class="col-no">#</th>
                            <th class="col-tanggal">Tanggal</th>
                            <th class="col-nim">NIM</th>
                            <th class="col-nama">Nama Mahasiswa</th>
                            <th class="col-kelas">Kelas</th>
                            <th class="col-matkul">Mata Kuliah</th>
                            <th class="col-kode">Kode</th>
                            <th class="col-status">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($data['absensi'] as $abs): ?>
                        <?php 
                        // ===== FORMAT KELAS =====
                        // Format: [PRODI]-[KODE_KELAS]-[TANGGAL_YYMMDD]
                        
                        // 1. Ambil PRODI dari kode mata kuliah (2 huruf pertama)
                        $prodi = isset($abs['kode']) ? substr($abs['kode'], 0, 2) : 'XX';
                        
                        // 2. Ambil KODE_KELAS dari data kelas atau generate
                        $kelas_raw = $abs['kelas'] ?? '';
                        if (!empty($kelas_raw)) {
                            $parts = explode('-', $kelas_raw);
                            if (count($parts) >= 2) {
                                $kode_kelas = $parts[1] . '-' . ($parts[2] ?? '00');
                            } else {
                                $kode_kelas = '001';
                            }
                        } else {
                            $kode_kelas = '001';
                        }
                        
                        // 3. Ambil TANGGAL format YYMMDD
                        $tanggal_kelas = date('ymd', strtotime($abs['tanggal']));
                        
                        // 4. Gabungkan menjadi format kelas
                        $kelas_format = $prodi . '-' . $kode_kelas . '-' . $tanggal_kelas;
                        ?>
                        <tr>
                            <td class="col-no"><?= $no++; ?></td>
                            <td class="col-tanggal"><?= date('d-m-Y', strtotime($abs['tanggal'])); ?></td>
                            <td class="col-nim"><?= htmlspecialchars($abs['nim'] ?? '-'); ?></td>
                            <td class="col-nama text-ellipsis" title="<?= htmlspecialchars($abs['mahasiswa_nama'] ?? '-'); ?>">
                                <?= htmlspecialchars($abs['mahasiswa_nama'] ?? '-'); ?>
                            </td>
                            <td class="col-kelas"><span class="class-badge"><?= htmlspecialchars($kelas_format); ?></span></td>
                            <td class="col-matkul text-ellipsis" title="<?= htmlspecialchars($abs['mata_kuliah'] ?? '-'); ?>">
                                <?= htmlspecialchars($abs['mata_kuliah'] ?? '-'); ?>
                            </td>
                            <td class="col-kode"><?= htmlspecialchars($abs['kode'] ?? '-'); ?></td>
                            <td class="col-status">
                                <span class="status-badge <?= strtolower($abs['status'] ?? ''); ?>">
                                    <?php if ($abs['status'] == 'Hadir'): ?>
                                        <i class="fas fa-check-circle status-icon"></i>
                                    <?php elseif ($abs['status'] == 'Sakit'): ?>
                                        <i class="fas fa-thermometer-half status-icon"></i>
                                    <?php elseif ($abs['status'] == 'Izin'): ?>
                                        <i class="fas fa-file-alt status-icon"></i>
                                    <?php elseif ($abs['status'] == 'Alpa'): ?>
                                        <i class="fas fa-times-circle status-icon"></i>
                                    <?php endif; ?>
                                    <?= $abs['status'] ?? '-'; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php endif; ?>
        </div>

    </div>
</div>

<!-- ===== SCRIPTS ===== -->
<script>
    // ========== INFINITE SCROLL WHEEL ==========
    function createInfiniteWheel(wheelId, items, itemHeight = 40) {
        const wheel = document.getElementById(wheelId);
        if (!wheel) return null;
        
        wheel.innerHTML = '';
        const totalItems = items.length;
        const copies = 5;
        const originalItems = [...items];
        
        for (let c = 0; c < copies; c++) {
            originalItems.forEach((item, index) => {
                const div = document.createElement('div');
                div.className = 'date-wheel-item';
                div.setAttribute('data-value', item.value);
                div.setAttribute('data-index', index);
                div.textContent = item.label;
                div.style.height = itemHeight + 'px';
                wheel.appendChild(div);
            });
        }
        
        const centerIndex = Math.floor((copies * totalItems) / 2);
        const centerOffset = centerIndex * itemHeight;
        wheel.scrollTop = centerOffset - (wheel.clientHeight / 2) + (itemHeight / 2);
        
        function checkAndResetScroll() {
            const scrollTop = wheel.scrollTop;
            const maxScroll = wheel.scrollHeight - wheel.clientHeight;
            const threshold = itemHeight * totalItems;
            
            if (scrollTop < threshold) {
                wheel.scrollTop += (copies - 2) * totalItems * itemHeight;
                return true;
            } else if (scrollTop > maxScroll - threshold) {
                wheel.scrollTop -= (copies - 2) * totalItems * itemHeight;
                return true;
            }
            return false;
        }
        
        let scrollTimeout = null;
        let isResetting = false;
        
        wheel.addEventListener('scroll', function(e) {
            if (isResetting) return;
            
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                isResetting = true;
                checkAndResetScroll();
                isResetting = false;
                updateActiveItem(wheel);
            }, 50);
        });
        
        function updateActiveItem(wheelEl) {
            const items = wheelEl.querySelectorAll('.date-wheel-item');
            const containerRect = wheelEl.getBoundingClientRect();
            const centerY = containerRect.top + containerRect.height / 2;
            
            let closest = null;
            let closestDist = Infinity;
            
            items.forEach(item => {
                const rect = item.getBoundingClientRect();
                const itemCenter = rect.top + rect.height / 2;
                const dist = Math.abs(itemCenter - centerY);
                
                if (dist < closestDist) {
                    closestDist = dist;
                    closest = item;
                }
            });
            
            if (closest) {
                items.forEach(item => item.classList.remove('active'));
                closest.classList.add('active');
                
                const value = parseInt(closest.getAttribute('data-value'));
                const wheelId = wheelEl.id;
                if (wheelId === 'dayWheel') {
                    selectedDay = value;
                } else if (wheelId === 'monthWheel') {
                    selectedMonth = value;
                }
            }
        }
        
        function scrollToValue(value) {
            const items = wheel.querySelectorAll('.date-wheel-item');
            let targetItem = null;
            
            for (let item of items) {
                if (parseInt(item.getAttribute('data-value')) === value) {
                    targetItem = item;
                    break;
                }
            }
            
            if (targetItem) {
                isResetting = true;
                targetItem.scrollIntoView({ block: 'center' });
                setTimeout(() => {
                    isResetting = false;
                    updateActiveItem(wheel);
                }, 100);
            }
        }
        
        return {
            scrollToValue: scrollToValue,
            updateActive: function() {
                updateActiveItem(wheel);
            },
            getWheel: function() {
                return wheel;
            }
        };
    }

    // ========== INIT WHEELS ==========
    const dayData = [];
    for (let d = 1; d <= 31; d++) {
        dayData.push({ value: d, label: String(d).padStart(2, '0') });
    }
    
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    const monthData = monthNames.map((name, index) => ({
        value: index + 1,
        label: name
    }));
    
    const dayWheel = createInfiniteWheel('dayWheel', dayData);
    const monthWheel = createInfiniteWheel('monthWheel', monthData);

    // ========== CUSTOM SELECT MATA KULIAH ==========
    (function() {
        const container = document.getElementById('matkulSelectContainer');
        const trigger = document.getElementById('matkulSelectTrigger');
        const optionsContainer = document.getElementById('matkulSelectOptions');
        const selectedText = document.getElementById('selectedMatkulText');
        const selectedValue = document.getElementById('selectedMatkulValue');
        const filterForm = document.getElementById('formFilter');

        function toggleDropdown() {
            optionsContainer.classList.toggle('show');
            trigger.classList.toggle('open');
        }

        function selectOption(value, text, element) {
            selectedText.textContent = text;
            selectedValue.value = value;
            
            container.querySelectorAll('.option-item').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            if (element) {
                element.classList.add('selected');
            } else {
                const selectedOpt = Array.from(container.querySelectorAll('.option-item')).find(
                    opt => opt.getAttribute('data-value') == value
                );
                if (selectedOpt) selectedOpt.classList.add('selected');
            }
            
            optionsContainer.classList.remove('show');
            trigger.classList.remove('open');
            
            if (filterForm) {
                filterForm.submit();
            }
        }

        trigger.addEventListener('click', toggleDropdown);

        container.querySelectorAll('.option-item').forEach(option => {
            option.addEventListener('click', function(e) {
                e.stopPropagation();
                const value = this.getAttribute('data-value');
                const text = this.textContent.trim();
                selectOption(value, text, this);
            });
        });

        document.addEventListener('click', function(event) {
            if (!container.contains(event.target)) {
                optionsContainer.classList.remove('show');
                trigger.classList.remove('open');
            }
        });
    })();

    // ========== CUSTOM DATE PICKER ==========
    (function() {
        const dateModal = document.getElementById('dateModal');
        const dateTrigger = document.getElementById('dateTrigger');
        const dateDisplay = document.getElementById('dateDisplay');
        const hiddenTanggal = document.getElementById('hiddenTanggal');
        const modalClose = document.getElementById('dateModalClose');
        const cancelBtn = document.getElementById('dateCancelBtn');
        const confirmBtn = document.getElementById('dateConfirmBtn');
        const filterForm = document.getElementById('formFilter');
        
        let selectedDay = new Date().getDate();
        let selectedMonth = new Date().getMonth() + 1;
        let selectedYear = new Date().getFullYear();

        // Set initial value jika ada tanggal yang dipilih
        const currentDate = hiddenTanggal.value;
        if (currentDate) {
            const parts = currentDate.split('-');
            if (parts.length === 3) {
                selectedYear = parseInt(parts[0]);
                selectedMonth = parseInt(parts[1]);
                selectedDay = parseInt(parts[2]);
            }
        }

        function setInitialWheels() {
            if (dayWheel) {
                dayWheel.scrollToValue(selectedDay);
            }
            if (monthWheel) {
                monthWheel.scrollToValue(selectedMonth);
            }
            
            const yearItems = document.querySelectorAll('#yearWheel .date-wheel-item');
            let targetYear = null;
            for (let item of yearItems) {
                if (parseInt(item.getAttribute('data-value')) === selectedYear) {
                    targetYear = item;
                    break;
                }
            }
            if (targetYear) {
                targetYear.scrollIntoView({ block: 'center' });
                yearItems.forEach(item => item.classList.remove('active'));
                targetYear.classList.add('active');
            }
        }

        function openDateModal() {
            dateModal.classList.add('show');
            document.body.style.overflow = 'hidden';
            setTimeout(setInitialWheels, 150);
        }

        function closeDateModal() {
            dateModal.classList.remove('show');
            document.body.style.overflow = '';
        }

        function confirmDate() {
            const dateObj = new Date(selectedYear, selectedMonth - 1, selectedDay);
            const formatted = dateObj.toLocaleDateString('id-ID', { 
                day: '2-digit', 
                month: 'long', 
                year: 'numeric' 
            });
            const isoDate = selectedYear + '-' + 
                           String(selectedMonth).padStart(2, '0') + '-' + 
                           String(selectedDay).padStart(2, '0');
            
            dateDisplay.textContent = formatted;
            hiddenTanggal.value = isoDate;
            
            closeDateModal();
            
            if (filterForm) {
                filterForm.submit();
            }
        }

        dateTrigger.addEventListener('click', openDateModal);
        modalClose.addEventListener('click', closeDateModal);
        cancelBtn.addEventListener('click', closeDateModal);
        confirmBtn.addEventListener('click', confirmDate);

        dateModal.addEventListener('click', function(e) {
            if (e.target === this) closeDateModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && dateModal.classList.contains('show')) {
                closeDateModal();
            }
            if (e.key === 'Enter' && dateModal.classList.contains('show')) {
                confirmDate();
            }
        });

        document.addEventListener('scroll', function(e) {
            const dayActive = document.querySelector('#dayWheel .date-wheel-item.active');
            if (dayActive) {
                selectedDay = parseInt(dayActive.getAttribute('data-value'));
            }
            
            const monthActive = document.querySelector('#monthWheel .date-wheel-item.active');
            if (monthActive) {
                selectedMonth = parseInt(monthActive.getAttribute('data-value'));
            }
            
            const yearActive = document.querySelector('#yearWheel .date-wheel-item.active');
            if (yearActive) {
                selectedYear = parseInt(yearActive.getAttribute('data-value'));
            }
        }, true);
    })();

    // ========== CUSTOM CONFIRM DIALOG ==========
    const confirmOverlay = document.getElementById('customConfirmOverlay');
    const confirmMessage = document.getElementById('confirmMessage');
    const confirmCancelBtn = document.getElementById('confirmCancelBtn');
    const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
    const logoutBtn = document.getElementById('logoutBtn');
    const sideLogoutBtn = document.getElementById('sideLogoutBtn');

    let pendingLogoutUrl = null;

    function showConfirmDialog(message, logoutUrl) {
        confirmMessage.innerHTML = message;
        pendingLogoutUrl = logoutUrl;
        confirmOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeConfirmDialog() {
        confirmOverlay.classList.remove('show');
        document.body.style.overflow = '';
        pendingLogoutUrl = null;
    }

    function executeLogout() {
        if (pendingLogoutUrl) {
            window.location.href = pendingLogoutUrl;
        }
    }

    confirmCancelBtn.addEventListener('click', closeConfirmDialog);
    confirmLogoutBtn.addEventListener('click', executeLogout);

    confirmOverlay.addEventListener('click', function(event) {
        if (event.target === confirmOverlay) {
            closeConfirmDialog();
        }
    });

    logoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        showConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout');
    });

    sideLogoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        showConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout');
    });

    // ========== TOGGLE SIDEBAR ==========
    const toggleBtn = document.getElementById('toggleSidebar');
    const sideMenu = document.getElementById('sideMenuOverlay');
    const backdrop = document.getElementById('sidebarBackdrop');

    function openSidebar() {
        sideMenu.classList.add('open');
        backdrop.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sideMenu.classList.remove('open');
        backdrop.classList.remove('show');
        document.body.style.overflow = '';
    }

    function toggleSidebar() {
        if (sideMenu.classList.contains('open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }

    toggleBtn.addEventListener('click', toggleSidebar);
    backdrop.addEventListener('click', closeSidebar);

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sideMenu.classList.contains('open')) {
            closeSidebar();
        }
    });

    // ========== AUTO SUBMIT FILTER ==========
    let filterTimeout = null;
    document.querySelectorAll('#filter_kelas, #filter_nim, #filter_nama').forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(() => {
                const form = document.getElementById('formFilter');
                if (form) form.submit();
            }, 500);
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>