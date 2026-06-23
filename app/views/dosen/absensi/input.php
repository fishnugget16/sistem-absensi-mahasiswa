<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Input Absensi - Dosen</title>
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
            padding: 12px 20px;
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

        /* ===== FORM CARD ===== */
        .form-card {
            background: #1e1e1e;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #2a2a2a;
            width: 100%;
            margin-bottom: 28px;
        }

        .form-card h4 {
            color: #e8eaed;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #2a2a2a;
        }

        .form-card h4 i {
            color: #4caf50;
            margin-right: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            color: #9aa0a6;
            font-size: 13px;
            font-weight: 500;
            display: block;
            margin-bottom: 6px;
        }

        .form-group label i {
            color: #4caf50;
            margin-right: 6px;
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
            padding: 10px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s;
            color: #e8eaed;
            font-size: 14px;
            min-height: 46px;
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
            max-height: 300px;
            overflow: hidden;
            flex-direction: column;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .custom-select-options.show {
            display: flex;
        }

        .search-box {
            padding: 10px;
            border-bottom: 1px solid #3c4043;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .search-box i {
            color: #9aa0a6;
            font-size: 14px;
        }

        .search-box input {
            background: transparent;
            border: none;
            color: #e8eaed;
            width: 100%;
            outline: none;
            font-size: 13px;
        }

        .search-box input::placeholder {
            color: #5f6368;
        }

        .options-list {
            overflow-y: auto;
            max-height: 240px;
        }

        .options-list::-webkit-scrollbar {
            width: 6px;
        }

        .options-list::-webkit-scrollbar-track {
            background: #2a2a2a;
            border-radius: 3px;
        }

        .options-list::-webkit-scrollbar-thumb {
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
        }

        .option-item:last-child {
            border-bottom: none;
        }

        .option-item i {
            width: 20px;
            font-size: 14px;
            color: #4caf50;
            flex-shrink: 0;
        }

        .option-item:hover {
            background: rgba(76, 175, 80, 0.1);
        }

        .option-item.selected {
            background: rgba(76, 175, 80, 0.2);
            color: #4caf50;
        }

        .option-item .badge-kelas {
            background: rgba(255, 255, 255, 0.05);
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 10px;
            color: #9aa0a6;
            margin-left: auto;
            flex-shrink: 0;
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
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.2s;
            min-height: 46px;
            color: #e8eaed;
            font-size: 14px;
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

        /* ===== MODAL DATE PICKER CUSTOM ===== */
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

        /* ===== DATE PICKER SCROLL WHEEL ===== */
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
        }

        .btn-confirm-date:hover {
            background: #43a047;
            transform: translateY(-1px);
        }

        /* ===== BUTTONS ===== */
        .btn-primary-custom {
            background: #4caf50;
            border: none;
            padding: 10px 28px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-custom:hover {
            background: #43a047;
            transform: translateY(-1px);
        }

        .btn-primary-custom:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary-custom {
            background: #3c4043;
            border: none;
            padding: 10px 28px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary-custom:hover {
            background: #4a4e54;
        }

        /* ===== TABLE MAHASISWA ===== */
        .table-wrapper {
            overflow-x: auto;
            overflow-y: visible !important;
            margin-top: 20px;
        }

        .table-dark-custom {
            width: 100%;
            border-collapse: collapse;
            color: #e8eaed;
            min-width: 600px;
        }

        .table-dark-custom th {
            text-align: left;
            padding: 12px 14px;
            font-weight: 500;
            font-size: 12px;
            color: #9aa0a6;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #2a2a2a;
            position: sticky;
            top: 0;
            background: #1e1e1e;
            z-index: 5;
        }

        .table-dark-custom td {
            padding: 12px 14px;
            font-size: 14px;
            border-bottom: 1px solid #1a1a1a;
            vertical-align: middle;
            overflow: visible !important;
            position: relative;
        }

        .table-dark-custom tbody tr {
            overflow: visible !important;
        }

        .table-dark-custom tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        .table-dark-custom .no-data td {
            text-align: center;
            color: #5f6368;
            padding: 40px 0;
            font-style: italic;
        }

        /* ===== CUSTOM CHECKBOX ===== */
        .checkbox-cell {
            text-align: center;
            padding: 8px 10px !important;
        }

        .checkbox-cell input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            background: transparent;
            border: 2px solid #4caf50;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
            flex-shrink: 0;
            margin: 0 auto;
            display: inline-block;
            vertical-align: middle;
        }

        .checkbox-cell input[type="checkbox"]:checked {
            background: #4caf50;
            border-color: #4caf50;
        }

        .checkbox-cell input[type="checkbox"]:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #121212;
            font-size: 12px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .checkbox-cell input[type="checkbox"]:hover {
            border-color: #66bb6a;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
        }

        .select-all-cell {
            text-align: center;
            padding: 8px 10px !important;
        }

        .select-all-cell input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            background: transparent;
            border: 2px solid #4caf50;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
            flex-shrink: 0;
            margin: 0 auto;
            display: inline-block;
            vertical-align: middle;
        }

        .select-all-cell input[type="checkbox"]:checked {
            background: #4caf50;
            border-color: #4caf50;
        }

        .select-all-cell input[type="checkbox"]:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #121212;
            font-size: 12px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .select-all-cell input[type="checkbox"]:hover {
            border-color: #66bb6a;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
        }

        /* ===== CUSTOM STATUS SELECT (DROPDOWN) - TANPA BADGE ===== */
        .status-select-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
            max-width: 130px;
        }

        .status-select-wrapper .status-trigger {
            background: #2a2a2a;
            border: 1px solid #3c4043;
            border-radius: 8px;
            padding: 6px 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s;
            color: #e8eaed;
            font-size: 13px;
            min-height: 38px;
            width: 100%;
            position: relative;
            z-index: 10;
        }

        .status-select-wrapper .status-trigger:hover {
            border-color: #4caf50;
        }

        .status-select-wrapper .status-trigger.open {
            border-color: #4caf50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
        }

        .status-select-wrapper .status-trigger .status-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 500;
        }

        /* Warna teks status */
        .status-text.hadir {
            color: #4caf50;
        }

        .status-text.sakit {
            color: #ff9800;
        }

        .status-text.izin {
            color: #2196f3;
        }

        .status-text.alpa {
            color: #dc3545;
        }

        .status-select-wrapper .status-trigger .status-icon {
            color: #9aa0a6;
            font-size: 12px;
            margin-left: 8px;
            transition: transform 0.2s;
            flex-shrink: 0;
        }

        .status-select-wrapper .status-trigger.open .status-icon {
            transform: rotate(180deg);
        }

        /* DROPDOWN OVERLAY - POSITION FIXED DI ATAS TABEL */
        .status-select-wrapper .status-options {
            position: fixed;
            background: #1e1e1e;
            border: 1px solid #3c4043;
            border-radius: 8px;
            z-index: 99999 !important;
            display: none;
            max-height: 200px;
            overflow: hidden;
            flex-direction: column;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            min-width: 130px;
            padding: 4px 0;
        }

        .status-select-wrapper .status-options.show {
            display: flex;
        }

        .status-select-wrapper .status-options .status-option-list {
            overflow-y: auto;
            max-height: 160px;
            padding: 4px 0;
        }

        .status-select-wrapper .status-options .status-option-list::-webkit-scrollbar {
            width: 4px;
        }

        .status-select-wrapper .status-options .status-option-list::-webkit-scrollbar-track {
            background: #2a2a2a;
            border-radius: 2px;
        }

        .status-select-wrapper .status-options .status-option-list::-webkit-scrollbar-thumb {
            background: #4caf50;
            border-radius: 2px;
        }

        .status-select-wrapper .status-option-item {
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.2s;
            color: #e8eaed;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-select-wrapper .status-option-item:hover {
            background: rgba(76, 175, 80, 0.1);
        }

        .status-select-wrapper .status-option-item.selected {
            background: rgba(76, 175, 80, 0.15);
        }

        /* Warna teks di option */
        .status-select-wrapper .status-option-item .status-opt-text {
            font-weight: 500;
        }

        .status-select-wrapper .status-option-item .status-opt-text.hadir {
            color: #4caf50;
        }

        .status-select-wrapper .status-option-item .status-opt-text.sakit {
            color: #ff9800;
        }

        .status-select-wrapper .status-option-item .status-opt-text.izin {
            color: #2196f3;
        }

        .status-select-wrapper .status-option-item .status-opt-text.alpa {
            color: #dc3545;
        }

        .status-select-wrapper .status-option-item i {
            width: 18px;
            font-size: 14px;
            flex-shrink: 0;
        }

        .status-select-wrapper .status-option-item i.fa-check-circle {
            color: #4caf50;
        }

        .status-select-wrapper .status-option-item i.fa-thermometer-half {
            color: #ff9800;
        }

        .status-select-wrapper .status-option-item i.fa-file-alt {
            color: #2196f3;
        }

        .status-select-wrapper .status-option-item i.fa-times-circle {
            color: #dc3545;
        }

        .badge-count {
            background: rgba(76, 175, 80, 0.15);
            color: #4caf50;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin-left: 8px;
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
        }

        .alert-error-custom i {
            color: #dc3545;
            font-size: 18px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #2a2a2a;
            flex-wrap: wrap;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* ===== CUSTOM CONFIRM DIALOG ===== */
        .custom-confirm-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(8px);
            z-index: 99999 !important;
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
            max-width: 420px;
            padding: 28px;
            border: 1px solid #2a2a2a;
            animation: modalFadeIn 0.2s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        }

        .custom-confirm-dialog .confirm-icon {
            text-align: center;
            margin-bottom: 16px;
        }

        .custom-confirm-dialog .confirm-icon i {
            font-size: 48px;
        }

        .custom-confirm-dialog .confirm-icon.save-icon i {
            color: #4caf50;
        }

        .custom-confirm-dialog .confirm-icon.logout-icon i {
            color: #dc3545;
        }

        .custom-confirm-dialog .confirm-title {
            text-align: center;
            color: #e8eaed;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .custom-confirm-dialog .confirm-message {
            text-align: center;
            color: #9aa0a6;
            font-size: 14px;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .custom-confirm-dialog .confirm-message strong {
            color: #e8eaed;
        }

        .custom-confirm-dialog .confirm-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .custom-confirm-dialog .confirm-buttons .btn-cancel-confirm {
            background: #3c4043;
            border: none;
            padding: 10px 28px;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-confirm-dialog .confirm-buttons .btn-cancel-confirm:hover {
            background: #4a4e54;
        }

        .custom-confirm-dialog .confirm-buttons .btn-confirm-action {
            border: none;
            padding: 10px 28px;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-confirm-dialog .confirm-buttons .btn-confirm-action.save {
            background: #4caf50;
        }

        .custom-confirm-dialog .confirm-buttons .btn-confirm-action.save:hover {
            background: #43a047;
        }

        .custom-confirm-dialog .confirm-buttons .btn-confirm-action.logout {
            background: #dc3545;
        }

        .custom-confirm-dialog .confirm-buttons .btn-confirm-action.logout:hover {
            background: #c82333;
        }

        /* ===== CUSTOM TOAST NOTIFICATION ===== */
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            background: #1e1e1e;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            padding: 16px 24px;
            min-width: 300px;
            max-width: 450px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            animation: slideInRight 0.4s ease;
            display: none;
        }

        .toast-notification.show {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .toast-notification .toast-icon {
            font-size: 24px;
            flex-shrink: 0;
        }

        .toast-notification .toast-icon.success {
            color: #4caf50;
        }

        .toast-notification .toast-icon.error {
            color: #dc3545;
        }

        .toast-notification .toast-content {
            flex: 1;
        }

        .toast-notification .toast-title {
            color: #e8eaed;
            font-weight: 500;
            font-size: 15px;
        }

        .toast-notification .toast-message {
            color: #9aa0a6;
            font-size: 13px;
            margin-top: 2px;
        }

        .toast-notification .toast-close {
            background: transparent;
            border: none;
            color: #9aa0a6;
            font-size: 18px;
            cursor: pointer;
            padding: 0 4px;
            flex-shrink: 0;
        }

        .toast-notification .toast-close:hover {
            color: #e8eaed;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .toast-notification.hide {
            animation: slideOutRight 0.4s ease forwards;
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        @media (max-width: 992px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            .header-panel {
                padding: 20px 20px;
            }
            .main-container {
                padding: 0 20px 30px 20px;
            }
            .form-card {
                padding: 18px;
            }
            .date-modal-content {
                max-width: 100%;
                margin: 10px;
            }
            .date-wheel {
                height: 100px;
                padding: 30px 0;
            }
            .date-wheel-item {
                height: 34px;
                font-size: 14px;
            }
            .date-wheel-item.active {
                font-size: 20px;
            }
            .date-wheel-container {
                gap: 12px;
            }
            .date-wheel-col {
                max-width: 90px;
            }
            .table-dark-custom {
                min-width: 550px;
            }
            .custom-confirm-dialog {
                padding: 20px;
                width: 95%;
            }
            .toast-notification {
                min-width: 250px;
                max-width: 350px;
                padding: 14px 18px;
                top: 10px;
                right: 10px;
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
            .form-card {
                padding: 14px;
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
            .table-dark-custom {
                min-width: 480px;
            }
            .form-actions {
                flex-direction: column;
            }
            .form-actions .btn-primary-custom,
            .form-actions .btn-secondary-custom {
                width: 100%;
                justify-content: center;
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
            .status-select-wrapper {
                max-width: 100%;
            }
            .status-select-wrapper .status-trigger {
                font-size: 12px;
                padding: 4px 8px;
                min-height: 34px;
            }
            .custom-confirm-dialog .confirm-title {
                font-size: 16px;
            }
            .custom-confirm-dialog .confirm-message {
                font-size: 13px;
            }
            .custom-confirm-dialog .confirm-buttons .btn-cancel-confirm,
            .custom-confirm-dialog .confirm-buttons .btn-confirm-action {
                padding: 8px 20px;
                font-size: 13px;
            }
            .toast-notification {
                min-width: 200px;
                max-width: 300px;
                padding: 12px 14px;
                top: 10px;
                right: 10px;
                font-size: 13px;
            }
            .toast-notification .toast-icon {
                font-size: 20px;
            }
            .toast-notification .toast-title {
                font-size: 14px;
            }
            .toast-notification .toast-message {
                font-size: 12px;
            }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            .form-row {
                grid-template-columns: 1fr 1fr;
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
            <a href="<?= BASEURL; ?>/DosenController/inputAbsensi" class="nav-link active">
                <i class="fas fa-pen-alt"></i> Input Absensi
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/DosenController/rekapAbsensi" class="nav-link">
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

<!-- ===== TOAST NOTIFICATION ===== -->
<div id="toastNotification" class="toast-notification">
    <div class="toast-icon" id="toastIcon">
        <i class="fas fa-check-circle"></i>
    </div>
    <div class="toast-content">
        <div class="toast-title" id="toastTitle">Berhasil</div>
        <div class="toast-message" id="toastMessage">Absensi berhasil disimpan</div>
    </div>
    <button class="toast-close" id="toastClose">&times;</button>
</div>

<!-- ===== CUSTOM CONFIRM DIALOG SAVE ===== -->
<div id="customConfirmSaveOverlay" class="custom-confirm-overlay">
    <div class="custom-confirm-dialog">
        <div class="confirm-icon save-icon">
            <i class="fas fa-save"></i>
        </div>
        <div class="confirm-title">Konfirmasi Simpan</div>
        <div class="confirm-message" id="confirmSaveMessage">
            Apakah Anda yakin ingin menyimpan absensi untuk <strong id="saveCount">0</strong> mahasiswa?
        </div>
        <div class="confirm-buttons">
            <button class="btn-cancel-confirm" id="confirmSaveCancelBtn">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="btn-confirm-action save" id="confirmSaveBtn">
                <i class="fas fa-check"></i> Simpan
            </button>
        </div>
    </div>
</div>

<!-- ===== CUSTOM CONFIRM DIALOG LOGOUT ===== -->
<div id="customConfirmLogoutOverlay" class="custom-confirm-overlay">
    <div class="custom-confirm-dialog">
        <div class="confirm-icon logout-icon">
            <i class="fas fa-sign-out-alt"></i>
        </div>
        <div class="confirm-title">Konfirmasi Logout</div>
        <div class="confirm-message" id="confirmLogoutMessage">
            Apakah Anda yakin ingin keluar dari sistem?
        </div>
        <div class="confirm-buttons">
            <button class="btn-cancel-confirm" id="confirmLogoutCancelBtn">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="btn-confirm-action logout" id="confirmLogoutBtn">
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
    <div class="header-panel">
        <div class="header-title">
            <h2><i class="fas fa-pen-alt"></i> Input Absensi</h2>
            <p>Pilih mata kuliah dan input absensi mahasiswa</p>
        </div>
    </div>

    <div class="main-container">
        <div class="form-card">
            <h4><i class="fas fa-filter"></i> Pilih Mata Kuliah & Tanggal</h4>

            <?php if (isset($_SESSION['toast'])): ?>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast('<?= $_SESSION['toast']['type']; ?>', '<?= $_SESSION['toast']['title']; ?>', '<?= $_SESSION['toast']['message']; ?>');
            });
            </script>
            <?php unset($_SESSION['toast']); endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
            <div class="alert-success-custom">
                <i class="fas fa-check-circle"></i>
                <span><?= $_SESSION['success']; ?></span>
            </div>
            <?php unset($_SESSION['success']); endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert-error-custom">
                <i class="fas fa-exclamation-circle"></i>
                <span><?= $_SESSION['error']; ?></span>
            </div>
            <?php unset($_SESSION['error']); endif; ?>

            <form action="<?= BASEURL; ?>/DosenController/inputAbsensi" method="GET" id="formFilter" onchange="this.submit()">
                <div class="form-row">
                    <div class="form-group">
                        <label for="matkulSelect">
                            <i class="fas fa-book"></i> Mata Kuliah
                        </label>
                        <div class="custom-select-container" id="matkulSelectContainer">
                            <div class="custom-select-trigger" id="matkulSelectTrigger">
                                <span class="selected-text" id="selectedMatkulText">
                                    <?php 
                                    $selected_matkul_id = $data['selected_matkul'] ?? 0;
                                    $selected_matkul_text = '-- Pilih Mata Kuliah --';
                                    foreach ($data['matkul_list'] as $matkul) {
                                        if ($matkul['id'] == $selected_matkul_id) {
                                            $selected_matkul_text = htmlspecialchars($matkul['nama'] . ' (' . $matkul['kode'] . ')');
                                            if (isset($matkul['kelas']) && !empty($matkul['kelas'])) {
                                                $selected_matkul_text .= ' - ' . htmlspecialchars($matkul['kelas']);
                                            }
                                            break;
                                        }
                                    }
                                    echo $selected_matkul_text;
                                    ?>
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="custom-select-options" id="matkulSelectOptions">
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" id="matkulSearchInput" placeholder="Cari mata kuliah...">
                                </div>
                                <div class="options-list" id="matkulOptionsList">
                                    <div class="option-item" data-value="">
                                        <i class="fas fa-list"></i> -- Pilih Mata Kuliah --
                                    </div>
                                    <?php foreach ($data['matkul_list'] as $matkul) { ?>
                                    <div class="option-item <?= ($data['selected_matkul'] == $matkul['id']) ? 'selected' : ''; ?>" 
                                         data-value="<?= $matkul['id']; ?>">
                                        <i class="fas fa-book-open"></i> 
                                        <?= htmlspecialchars($matkul['nama'] . ' (' . $matkul['kode'] . ')'); ?>
                                        <?php if (isset($matkul['kelas']) && !empty($matkul['kelas'])) { ?>
                                        <span class="badge-kelas"><?= htmlspecialchars($matkul['kelas']); ?></span>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="matkul_id" id="selectedMatkulValue" value="<?= $data['selected_matkul'] ?? 0; ?>">
                    </div>

                    <div class="form-group">
                        <label for="dateTrigger">
                            <i class="fas fa-calendar-day"></i> Tanggal Absensi
                        </label>
                        <div class="date-trigger-wrapper">
                            <div class="date-trigger" id="dateTrigger">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="date-display" id="dateDisplay">
                                    <?= date('d F Y'); ?>
                                </span>
                                <i class="fas fa-chevron-right date-arrow"></i>
                            </div>
                        </div>
                        <input type="hidden" name="tanggal" id="hiddenTanggal" value="<?= date('Y-m-d'); ?>">
                    </div>
                </div>
            </form>
        </div>

        <!-- ===== TABLE MAHASISWA ===== -->
        <?php if ($data['selected_matkul'] > 0): ?>
        <div class="form-card">
            <h4>
                <i class="fas fa-users"></i> Daftar Mahasiswa
                <span class="badge-count"><?= count($data['mahasiswa_list']); ?> mahasiswa</span>
                <?php if (!empty($data['prodi_display']) && !empty($data['angkatan_display'])): ?>
                <span style="font-size: 12px; color: #4caf50; margin-left: 10px;">
                    <i class="fas fa-filter"></i> 
                    Prodi: <?= htmlspecialchars($data['prodi_display']); ?> | 
                    Angkatan: <?= htmlspecialchars($data['angkatan_display']); ?>
                </span>
                <?php endif; ?>
            </h4>

            <?php if (empty($data['mahasiswa_list'])): ?>
            <div class="alert-error-custom">
                <i class="fas fa-info-circle"></i>
                <span>
                    Tidak ada mahasiswa yang terdaftar untuk mata kuliah ini.
                    <?php if (!empty($data['prodi_display']) && !empty($data['angkatan_display'])): ?>
                    (Prodi: <?= htmlspecialchars($data['prodi_display']); ?>, 
                    Angkatan: <?= htmlspecialchars($data['angkatan_display']); ?>)
                    <?php endif; ?>
                </span>
            </div>
            <?php else: ?>

            <form action="<?= BASEURL; ?>/DosenController/inputAbsensiStore" method="POST" id="formAbsensi">
                <input type="hidden" name="matkul_id" value="<?= $data['selected_matkul']; ?>">
                <input type="hidden" name="tanggal" id="formTanggal" value="<?= date('Y-m-d'); ?>">

                <div class="table-wrapper">
                    <table class="table-dark-custom">
                        <thead>
                            <tr>
                                <th style="width:50px;" class="select-all-cell">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th style="width:60px;">No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th style="width:130px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data['mahasiswa_list'] as $mhs): ?>
                            <tr>
                                <td class="checkbox-cell">
                                    <input type="checkbox" name="mahasiswa_id[]" value="<?= $mhs['id']; ?>" 
                                           class="row-checkbox" checked>
                                </td>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($mhs['nim'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($mhs['nama']); ?></td>
                                <td>
                                    <div class="status-select-wrapper" data-mahasiswa-id="<?= $mhs['id']; ?>">
                                        <div class="status-trigger" onclick="toggleStatusDropdown(this, event)">
                                            <span class="status-text <?= strtolower($mhs['status_terakhir'] ?? 'Hadir'); ?>">
                                                <?= $mhs['status_terakhir'] ?? 'Hadir'; ?>
                                            </span>
                                            <i class="fas fa-chevron-down status-icon"></i>
                                        </div>
                                        <div class="status-options">
                                            <div class="status-option-list">
                                                <div class="status-option-item <?= (($mhs['status_terakhir'] ?? 'Hadir') == 'Hadir') ? 'selected' : ''; ?>" data-value="Hadir" onclick="selectStatus(this, event)">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span class="status-opt-text hadir">Hadir</span>
                                                </div>
                                                <div class="status-option-item <?= (($mhs['status_terakhir'] ?? 'Hadir') == 'Sakit') ? 'selected' : ''; ?>" data-value="Sakit" onclick="selectStatus(this, event)">
                                                    <i class="fas fa-thermometer-half"></i>
                                                    <span class="status-opt-text sakit">Sakit</span>
                                                </div>
                                                <div class="status-option-item <?= (($mhs['status_terakhir'] ?? 'Hadir') == 'Izin') ? 'selected' : ''; ?>" data-value="Izin" onclick="selectStatus(this, event)">
                                                    <i class="fas fa-file-alt"></i>
                                                    <span class="status-opt-text izin">Izin</span>
                                                </div>
                                                <div class="status-option-item <?= (($mhs['status_terakhir'] ?? 'Hadir') == 'Alpa') ? 'selected' : ''; ?>" data-value="Alpa" onclick="selectStatus(this, event)">
                                                    <i class="fas fa-times-circle"></i>
                                                    <span class="status-opt-text alpa">Alpa</span>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="status[]" value="<?= $mhs['status_terakhir'] ?? 'Hadir'; ?>">
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-primary-custom" id="btnSubmit">
                        <i class="fas fa-save"></i> Simpan Semua Absensi
                    </button>
                    <button type="button" class="btn-secondary-custom" id="btnUncheckAll">
                        <i class="fas fa-square"></i> Uncheck Semua
                    </button>
                </div>
            </form>

            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ===== SCRIPTS ===== -->
<script>
    // ========== TOAST NOTIFICATION ==========
    function showToast(type, title, message) {
        const toast = document.getElementById('toastNotification');
        const icon = document.getElementById('toastIcon');
        const titleEl = document.getElementById('toastTitle');
        const msgEl = document.getElementById('toastMessage');

        // Reset class
        toast.className = 'toast-notification';
        icon.className = 'toast-icon';

        if (type === 'success') {
            icon.classList.add('success');
            icon.innerHTML = '<i class="fas fa-check-circle"></i>';
            titleEl.textContent = title || 'Berhasil';
        } else {
            icon.classList.add('error');
            icon.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
            titleEl.textContent = title || 'Gagal';
        }

        msgEl.textContent = message || '';

        toast.classList.add('show');

        // Auto hide setelah 5 detik
        clearTimeout(window.toastTimeout);
        window.toastTimeout = setTimeout(function() {
            hideToast();
        }, 5000);
    }

    function hideToast() {
        const toast = document.getElementById('toastNotification');
        toast.classList.add('hide');
        setTimeout(function() {
            toast.classList.remove('show', 'hide');
        }, 400);
    }

    document.getElementById('toastClose').addEventListener('click', hideToast);

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
        const searchInput = document.getElementById('matkulSearchInput');
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

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                container.querySelectorAll('.option-item').forEach(option => {
                    const text = option.textContent.toLowerCase();
                    if (text.includes(searchTerm) || option.getAttribute('data-value') === '') {
                        option.style.display = 'flex';
                    } else {
                        option.style.display = 'none';
                    }
                });
            });
        }

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
        const formTanggal = document.getElementById('formTanggal');
        const modalClose = document.getElementById('dateModalClose');
        const cancelBtn = document.getElementById('dateCancelBtn');
        const confirmBtn = document.getElementById('dateConfirmBtn');
        
        let selectedDay = new Date().getDate();
        let selectedMonth = new Date().getMonth() + 1;
        let selectedYear = new Date().getFullYear();

        function setInitialWheels() {
            const now = new Date();
            const day = now.getDate();
            const month = now.getMonth() + 1;
            const year = now.getFullYear();

            if (dayWheel) {
                dayWheel.scrollToValue(day);
            }
            
            if (monthWheel) {
                monthWheel.scrollToValue(month);
            }
            
            const yearItems = document.querySelectorAll('#yearWheel .date-wheel-item');
            let targetYear = null;
            for (let item of yearItems) {
                if (parseInt(item.getAttribute('data-value')) === year) {
                    targetYear = item;
                    break;
                }
            }
            if (targetYear) {
                targetYear.scrollIntoView({ block: 'center' });
                yearItems.forEach(item => item.classList.remove('active'));
                targetYear.classList.add('active');
            }

            selectedDay = day;
            selectedMonth = month;
            selectedYear = year;
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
            if (formTanggal) formTanggal.value = isoDate;
            
            closeDateModal();
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

    // ========== STATUS SELECT DROPDOWN - OVERLAY DI ATAS ==========
    function toggleStatusDropdown(trigger, event) {
        event.stopPropagation();
        event.preventDefault();
        const wrapper = trigger.closest('.status-select-wrapper');
        const options = wrapper.querySelector('.status-options');
        const isOpen = options.classList.contains('show');
        
        // Tutup semua dropdown lain
        document.querySelectorAll('.status-options.show').forEach(el => {
            if (el !== options) el.classList.remove('show');
        });
        document.querySelectorAll('.status-trigger.open').forEach(el => {
            if (el !== trigger) el.classList.remove('open');
        });
        
        if (isOpen) {
            options.classList.remove('show');
            trigger.classList.remove('open');
        } else {
            // Posisikan dropdown dengan fixed di atas tabel
            const rect = trigger.getBoundingClientRect();
            const optionsHeight = 160;
            const windowHeight = window.innerHeight;
            const spaceBelow = windowHeight - rect.bottom;
            const spaceAbove = rect.top;
            
            // Set style fixed
            options.style.position = 'fixed';
            options.style.width = Math.max(rect.width, 130) + 'px';
            options.style.zIndex = '99999';
            
            // Tentukan posisi vertikal
            if (spaceBelow < optionsHeight && spaceAbove > optionsHeight) {
                // Tampilkan di atas
                options.style.top = (rect.top - optionsHeight - 5) + 'px';
                options.style.bottom = 'auto';
            } else {
                // Tampilkan di bawah
                options.style.top = (rect.bottom + 5) + 'px';
                options.style.bottom = 'auto';
            }
            
            // Posisi horizontal
            let left = rect.left;
            if (left + rect.width > window.innerWidth - 10) {
                left = window.innerWidth - rect.width - 10;
            }
            if (left < 10) {
                left = 10;
            }
            options.style.left = left + 'px';
            options.style.right = 'auto';
            
            options.classList.add('show');
            trigger.classList.add('open');
        }
    }

    function selectStatus(element, event) {
        event.stopPropagation();
        event.preventDefault();
        const optionItem = element.closest('.status-option-item');
        const wrapper = optionItem.closest('.status-select-wrapper');
        const trigger = wrapper.querySelector('.status-trigger');
        const options = wrapper.querySelector('.status-options');
        const statusText = trigger.querySelector('.status-text');
        const hiddenInput = wrapper.querySelector('input[type="hidden"]');
        const value = optionItem.getAttribute('data-value');
        
        wrapper.querySelectorAll('.status-option-item').forEach(opt => {
            opt.classList.remove('selected');
        });
        optionItem.classList.add('selected');
        
        // Update text dengan warna sesuai status
        const statusClass = value.toLowerCase();
        statusText.textContent = value;
        statusText.className = 'status-text ' + statusClass;
        hiddenInput.value = value;
        
        options.classList.remove('show');
        trigger.classList.remove('open');
    }

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.status-select-wrapper')) {
            document.querySelectorAll('.status-options.show').forEach(el => {
                el.classList.remove('show');
            });
            document.querySelectorAll('.status-trigger.open').forEach(el => {
                el.classList.remove('open');
            });
        }
    });

    // Tutup dropdown saat scroll
    window.addEventListener('scroll', function() {
        document.querySelectorAll('.status-options.show').forEach(el => {
            el.classList.remove('show');
        });
        document.querySelectorAll('.status-trigger.open').forEach(el => {
            el.classList.remove('open');
        });
    });

    // ========== CUSTOM CONFIRM DIALOG SAVE ==========
    const confirmSaveOverlay = document.getElementById('customConfirmSaveOverlay');
    const confirmSaveMessage = document.getElementById('confirmSaveMessage');
    const confirmSaveCancelBtn = document.getElementById('confirmSaveCancelBtn');
    const confirmSaveBtn = document.getElementById('confirmSaveBtn');
    const submitBtn = document.getElementById('btnSubmit');
    let pendingFormSubmit = null;

    function showSaveConfirmDialog(count) {
        const countElement = document.getElementById('saveCount');
        if (countElement) {
            countElement.textContent = count;
        }
        confirmSaveOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSaveConfirmDialog() {
        confirmSaveOverlay.classList.remove('show');
        document.body.style.overflow = '';
        pendingFormSubmit = null;
    }

    function executeSave() {
        if (pendingFormSubmit) {
            pendingFormSubmit();
        }
        closeSaveConfirmDialog();
    }

    confirmSaveCancelBtn.addEventListener('click', closeSaveConfirmDialog);
    confirmSaveBtn.addEventListener('click', executeSave);

    confirmSaveOverlay.addEventListener('click', function(event) {
        if (event.target === confirmSaveOverlay) {
            closeSaveConfirmDialog();
        }
    });

    // ========== CUSTOM CONFIRM DIALOG LOGOUT ==========
    const confirmLogoutOverlay = document.getElementById('customConfirmLogoutOverlay');
    const confirmLogoutMessage = document.getElementById('confirmLogoutMessage');
    const confirmLogoutCancelBtn = document.getElementById('confirmLogoutCancelBtn');
    const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
    const logoutBtn = document.getElementById('logoutBtn');
    const sideLogoutBtn = document.getElementById('sideLogoutBtn');

    let pendingLogoutUrl = null;

    function showLogoutConfirmDialog(message, logoutUrl) {
        confirmLogoutMessage.innerHTML = message;
        pendingLogoutUrl = logoutUrl;
        confirmLogoutOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeLogoutConfirmDialog() {
        confirmLogoutOverlay.classList.remove('show');
        document.body.style.overflow = '';
        pendingLogoutUrl = null;
    }

    function executeLogout() {
        if (pendingLogoutUrl) {
            window.location.href = pendingLogoutUrl;
        }
        closeLogoutConfirmDialog();
    }

    confirmLogoutCancelBtn.addEventListener('click', closeLogoutConfirmDialog);
    confirmLogoutBtn.addEventListener('click', executeLogout);

    confirmLogoutOverlay.addEventListener('click', function(event) {
        if (event.target === confirmLogoutOverlay) {
            closeLogoutConfirmDialog();
        }
    });

    logoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        showLogoutConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout');
    });

    sideLogoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        showLogoutConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout');
    });

    // ========== SUBMIT HANDLER ==========
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Hitung jumlah mahasiswa yang dicentang
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            if (checkedBoxes.length === 0) {
                showToast('error', 'Peringatan', 'Pilih minimal 1 mahasiswa untuk diinput absensinya!');
                return;
            }
            
            // Tampilkan custom confirm dialog
            showSaveConfirmDialog(checkedBoxes.length);
            
            // Set pending submit
            const form = document.getElementById('formAbsensi');
            pendingFormSubmit = function() {
                form.submit();
            };
        });
    }

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

    // ========== FITUR TAMBAHAN ==========
    const selectAllCheckbox = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(cb => {
                cb.checked = this.checked;
            });
        });
    }

    const btnUncheckAll = document.getElementById('btnUncheckAll');
    if (btnUncheckAll) {
        btnUncheckAll.addEventListener('click', function() {
            rowCheckboxes.forEach(cb => {
                cb.checked = false;
            });
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = false;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (rowCheckboxes.length > 0 && selectAllCheckbox) {
            const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const hiddenTanggal = document.getElementById('hiddenTanggal');
        const formTanggal = document.getElementById('formTanggal');
        if (hiddenTanggal && hiddenTanggal.value === '') {
            const now = new Date();
            hiddenTanggal.value = now.getFullYear() + '-' + 
                                 String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                                 String(now.getDate()).padStart(2, '0');
        }
        if (formTanggal && formTanggal.value === '') {
            const now = new Date();
            formTanggal.value = now.getFullYear() + '-' + 
                               String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                               String(now.getDate()).padStart(2, '0');
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>