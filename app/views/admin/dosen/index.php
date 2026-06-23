<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title><?= $data['judul_halaman'] ?? 'Data Dosen' ?> - Admin</title>
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

        .content-card {
            background: #1e1e1e;
            border-radius: 12px;
            padding: 24px;
            margin: 24px;
            border: 1px solid #2a2a2a;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-title {
            color: #e8eaed;
            font-size: 20px;
            font-weight: 500;
            margin: 0;
        }

        .page-title i {
            color: #4caf50;
            margin-right: 10px;
        }

        /* ===== FILTER SECTION ===== */
        .filter-section {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            border: 1px solid #2a2a2a;
        }

        .filter-title {
            color: #e8eaed;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .filter-title i {
            color: #4caf50;
            margin-right: 8px;
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 150px;
        }

        .filter-group label {
            color: #9aa0a6;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            display: block;
        }

        .filter-group label i {
            margin-right: 4px;
        }

        /* ===== CUSTOM SELECT ===== */
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
        }

        .custom-select-trigger:hover {
            border-color: #4caf50;
        }

        .custom-select-trigger i {
            transition: transform 0.2s;
            color: #9aa0a6;
        }

        .custom-select-trigger.open i {
            transform: rotate(180deg);
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

        .options-list {
            overflow-y: auto;
            max-height: 220px;
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

        .filter-active {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(76, 175, 80, 0.15);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            color: #4caf50;
        }

        .filter-active i {
            font-size: 10px;
            cursor: pointer;
        }

        .filter-active i:hover {
            color: #dc3545;
        }

        /* ===== BUTTONS ===== */
        .btn-add {
            background: #4caf50;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            color: white;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover {
            background: #43a047;
            transform: translateY(-1px);
            color: white;
        }

        .btn-back, .btn-pagination {
            background: #3c4043;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            color: white;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-back:hover, .btn-pagination:hover {
            background: #4a4e54;
            color: white;
        }

        .btn-pagination:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 16px;
            margin-top: 24px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .pagination-info {
            color: #9aa0a6;
            font-size: 13px;
        }

        /* ===== TABLE ===== */
        .table-wrapper {
            overflow-x: auto;
            overflow-y: visible;
            border-radius: 8px;
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        .data-table thead tr {
            border-bottom: 2px solid #2a2a2a;
        }

        .data-table th {
            text-align: left;
            padding: 14px 12px;
            color: #4caf50;
            font-weight: 500;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 12px 12px;
            color: #e8eaed;
            font-size: 14px;
            border-bottom: 1px solid #2a2a2a;
            vertical-align: middle;
        }

        .data-table tbody tr {
            cursor: pointer;
            transition: background 0.2s;
            position: relative;
        }

        .data-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .data-table tbody tr.expanded {
            background: rgba(76, 175, 80, 0.08);
        }

        .data-table tbody tr .expand-icon {
            display: inline-block;
            transition: transform 0.3s ease;
            color: #4caf50;
            font-size: 14px;
            margin-right: 6px;
        }

        .data-table tbody tr.expanded .expand-icon {
            transform: rotate(180deg);
        }

        .data-table code {
            background: #2a2a2a;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
            color: #e8eaed;
        }

        /* ===== EXPANDED ROW ACTION ===== */
        .action-row {
            display: none;
            background: rgba(255, 255, 255, 0.02);
            border-bottom: 1px solid #2a2a2a;
        }

        .action-row td {
            padding: 0 12px 12px 12px;
        }

        .action-row.show {
            display: table-row;
        }

        .action-row .action-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 12px 8px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            border: 1px solid #2a2a2a;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
            background: transparent;
            color: #e8eaed;
        }

        .action-btn:hover {
            transform: translateY(-1px);
        }

        .action-btn:active {
            transform: scale(0.97);
        }

        .action-btn .action-icon {
            font-size: 15px;
        }

        .action-btn.action-matkul {
            background: rgba(76, 175, 80, 0.15);
            color: #4caf50;
        }

        .action-btn.action-matkul:hover {
            background: rgba(76, 175, 80, 0.25);
        }

        .action-btn.action-edit {
            background: rgba(255, 152, 0, 0.15);
            color: #ff9800;
        }

        .action-btn.action-edit:hover {
            background: rgba(255, 152, 0, 0.25);
        }

        .action-btn.action-delete {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .action-btn.action-delete:hover {
            background: rgba(220, 53, 69, 0.25);
        }

        .action-divider {
            width: 1px;
            background: #2a2a2a;
            flex-shrink: 0;
        }

        /* ===== MODAL ASSIGN MATA KULIAH ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: #1e1e1e;
            border-radius: 16px;
            width: 100%;
            max-width: 700px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            border: 1px solid #2a2a2a;
            animation: modalFadeIn 0.2s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(10px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #2a2a2a;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .modal-header h4 {
            color: #e8eaed;
            font-size: 18px;
            font-weight: 500;
            margin: 0;
        }

        .modal-header h4 i {
            color: #4caf50;
            margin-right: 10px;
        }

        .modal-close {
            background: transparent;
            border: none;
            color: #9aa0a6;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.2s;
            padding: 0 4px;
        }

        .modal-close:hover {
            color: #dc3545;
        }

        .modal-body {
            padding: 20px 24px;
            overflow-y: auto;
            flex: 1;
        }

        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #2a2a2a;
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #4caf50;
            border-radius: 3px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #2a2a2a;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-shrink: 0;
        }

        .modal-footer .btn-close-modal {
            background: #3c4043;
            border: none;
            padding: 8px 24px;
            border-radius: 6px;
            color: white;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .modal-footer .btn-close-modal:hover {
            background: #4a4e54;
        }

        /* ===== MATA KULIAH LIST DI MODAL ===== */
        .matkul-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .matkul-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            border: 1px solid #2a2a2a;
            transition: all 0.2s;
        }

        .matkul-item:hover {
            border-color: #3c4043;
        }

        .matkul-item .matkul-info {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .matkul-item .matkul-info .kode {
            background: #2a2a2a;
            padding: 2px 10px;
            border-radius: 4px;
            font-size: 12px;
            color: #4caf50;
            font-weight: 500;
        }

        .matkul-item .matkul-info .nama {
            color: #e8eaed;
            font-size: 14px;
        }

        .matkul-item .matkul-info .kelas {
            color: #9aa0a6;
            font-size: 12px;
            background: rgba(255, 255, 255, 0.05);
            padding: 2px 10px;
            border-radius: 4px;
        }

        .matkul-item .matkul-action {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .matkul-item .matkul-action .badge-assigned {
            background: rgba(76, 175, 80, 0.2);
            color: #4caf50;
            padding: 2px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }

        .matkul-item .matkul-action .btn-assign {
            background: #4caf50;
            border: none;
            padding: 4px 14px;
            border-radius: 4px;
            color: white;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .matkul-item .matkul-action .btn-assign:hover {
            background: #43a047;
        }

        .matkul-item .matkul-action .btn-assign:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .matkul-item .matkul-action .btn-remove {
            background: #dc3545;
            border: none;
            padding: 4px 14px;
            border-radius: 4px;
            color: white;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .matkul-item .matkul-action .btn-remove:hover {
            background: #c82333;
        }

        .info-text-modal {
            color: #9aa0a6;
            font-size: 13px;
            margin-bottom: 16px;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            border-left: 3px solid #4caf50;
        }

        .info-text-modal i {
            color: #4caf50;
            margin-right: 8px;
        }

        .info-text-modal .count-current {
            color: #4caf50;
            font-weight: 500;
        }

        .info-text-modal .count-max {
            color: #ff9800;
            font-weight: 500;
        }

        .alert-modal {
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 12px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-modal.success {
            background: #1a2c1a;
            color: #9aef9a;
            border-left: 3px solid #4caf50;
        }

        .alert-modal.error {
            background: #2c1a1a;
            color: #ef9a9a;
            border-left: 3px solid #dc3545;
        }

        .alert-modal i {
            font-size: 16px;
        }

        /* ===== CUSTOM CONFIRM OVERLAY ===== */
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

        /* ===== CUSTOM CONFIRM OVERLAY - Z-INDEX LEBIH TINGGI ===== */
        #customConfirmAssignOverlay {
            z-index: 99999 !important;
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

        .confirm-icon {
            text-align: center;
            margin-bottom: 20px;
        }

        .confirm-icon.delete-icon i {
            color: #ff9800;
            font-size: 56px;
        }

        .confirm-icon.logout-icon i {
            color: #dc3545;
            font-size: 56px;
        }

        .confirm-icon.assign-icon i {
            color: #4caf50;
            font-size: 56px;
        }

        .confirm-title {
            text-align: center;
            color: #e8eaed;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .confirm-message {
            text-align: center;
            color: #9aa0a6;
            font-size: 14px;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .confirm-message strong {
            color: #e8eaed;
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
        }

        .confirm-buttons .btn-cancel-confirm:hover {
            background: #4a4e54;
        }

        .confirm-buttons .btn-delete-confirm {
            background: #dc3545;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .confirm-buttons .btn-delete-confirm:hover {
            background: #c82333;
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
        }

        .confirm-buttons .btn-logout-confirm:hover {
            background: #c82333;
        }

        .confirm-buttons .btn-confirm-assign {
            background: #4caf50;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .confirm-buttons .btn-confirm-assign:hover {
            background: #43a047;
        }

        .alert-success {
            background: #1a2c1a;
            border: 1px solid #4caf50;
            color: #9aef9a;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #2c1a1a;
            border: 1px solid #dc3545;
            color: #ef9a9a;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .navbar-custom {
                padding: 10px 16px;
                min-height: 56px;
            }
            .content-card {
                margin: 16px;
                padding: 16px;
            }
            .page-title {
                font-size: 18px;
            }
            .btn-add {
                padding: 6px 14px;
                font-size: 12px;
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
            .modal-content {
                max-width: 100%;
                margin: 10px;
                max-height: 95vh;
            }
            .modal-header {
                padding: 16px;
            }
            .modal-body {
                padding: 16px;
            }
            .modal-footer {
                padding: 12px 16px;
                flex-wrap: wrap;
            }
            .matkul-item {
                flex-wrap: wrap;
                gap: 8px;
            }
            .matkul-item .matkul-info {
                flex-wrap: wrap;
            }
            .matkul-item .matkul-action {
                width: 100%;
                justify-content: flex-end;
            }
            .filter-row {
                flex-direction: column;
            }
            .filter-group {
                width: 100%;
            }
            .pagination-container {
                justify-content: center;
                flex-direction: column;
                gap: 8px;
            }
            .data-table {
                min-width: 600px;
            }
            .action-container {
                flex-direction: column;
                align-items: stretch;
            }
            .action-divider {
                display: none;
            }
            .action-btn {
                justify-content: center;
                padding: 10px 16px;
            }
        }

        @media (max-width: 576px) {
            .data-table {
                min-width: 500px;
            }
            .modal-content {
                border-radius: 12px;
            }
            .matkul-item .matkul-info .nama {
                font-size: 13px;
            }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            .content-card {
                margin: 20px;
            }
            .matkul-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (min-width: 1400px) {
            .content-card {
                margin: 28px 40px;
                padding: 28px;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
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
            <span><?= $_SESSION['nama'] ?? $_SESSION['username'] ?? 'Admin'; ?></span>
        </span>
        <a href="#" class="logout-link" id="logoutBtn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<!-- Overlay Sidebar -->
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<div class="side-menu-overlay" id="sideMenuOverlay">
    <ul class="nav-menu">
        <li class="sidebar-brand">
            <i class="fas fa-graduation-cap"></i>
            <span>SENMA</span>
        </li>

        <li class="nav-item">
            <a href="<?= BASEURL; ?>/AuthController/dashboard" class="nav-link">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/AdminController/mahasiswa" class="nav-link">
                <i class="fas fa-user-graduate"></i> Kelola Mahasiswa
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/AdminController/dosen" class="nav-link active">
                <i class="fas fa-chalkboard-user"></i> Kelola Dosen
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/AdminController/matakuliah" class="nav-link">
                <i class="fas fa-book-open"></i> Kelola Mata Kuliah
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/AdminController/surat_izin" class="nav-link">
                <i class="fas fa-file-alt"></i> Surat Izin
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link logout" id="sideLogoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>

<!-- Custom Confirm Dialog untuk DELETE -->
<div id="customConfirmDeleteOverlay" class="custom-confirm-overlay">
    <div class="custom-confirm-dialog">
        <div class="confirm-icon delete-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="confirm-title">Konfirmasi Hapus</div>
        <div class="confirm-message" id="confirmDeleteMessage">
            Apakah Anda yakin ingin menghapus data ini?
        </div>
        <div class="confirm-buttons">
            <button class="btn-cancel-confirm" id="confirmDeleteCancelBtn">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="btn-delete-confirm" id="confirmDeleteBtn">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
    </div>
</div>

<!-- Custom Confirm Dialog untuk LOGOUT -->
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
            <button class="btn-logout-confirm" id="confirmLogoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
    </div>
</div>

<!-- ===== CUSTOM CONFIRM DIALOG FOR ASSIGN/REMOVE (Z-INDEX TERTINGGI) ===== -->
<div id="customConfirmAssignOverlay" class="custom-confirm-overlay" style="z-index:99999 !important;">
    <div class="custom-confirm-dialog">
        <div class="confirm-icon assign-icon">
            <i class="fas fa-exchange-alt"></i>
        </div>
        <div class="confirm-title" id="confirmAssignTitle">Konfirmasi</div>
        <div class="confirm-message" id="confirmAssignMessage">
            Apakah Anda yakin?
        </div>
        <div class="confirm-buttons">
            <button class="btn-cancel-confirm" id="confirmAssignCancelBtn">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="btn-confirm-assign" id="confirmAssignBtn">
                <i class="fas fa-check"></i> Ya, Lanjutkan
            </button>
        </div>
    </div>
</div>

<!-- ===== MODAL ASSIGN MATA KULIAH ===== -->
<div id="modalAssignMatkul" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h4><i class="fas fa-book-open"></i> Tentukan Mata Kuliah untuk Dosen</h4>
            <button class="modal-close" id="modalCloseBtn">&times;</button>
        </div>
        <div class="modal-body" id="modalBody">
            <div id="modalContent">
                <div style="text-align:center; color:#9aa0a6; padding:40px 0;">
                    <i class="fas fa-spinner fa-spin" style="font-size:24px;"></i>
                    <p style="margin-top:12px;">Memuat data...</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-close-modal" id="modalCloseBtnFooter">Tutup</button>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="content-card">
        <div class="page-header">
            <h3 class="page-title"><i class="fas fa-chalkboard-user"></i> <?= $data['judul_halaman'] ?></h3>
            <a href="<?= BASEURL; ?>/AdminController/dosenCreate" class="btn-add">
                <i class="fas fa-plus"></i> Tambah Dosen
            </a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert-success"><i class="fas fa-check-circle"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert-danger"><i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- FILTER SECTION -->
        <div class="filter-section">
            <div class="filter-title">
                <i class="fas fa-filter"></i> Filter Data
            </div>
            <form method="GET" action="<?= BASEURL; ?>/AdminController/dosen" id="filterForm">
                <div class="filter-row">
                    <div class="filter-group">
                        <label><i class="fas fa-code-branch"></i> Program Studi</label>
                        <input type="hidden" name="filter_prodi" id="selectedProdiValue" value="<?= isset($_GET['filter_prodi']) ? htmlspecialchars($_GET['filter_prodi']) : ''; ?>">
                        <div class="custom-select-container" id="prodiSelectContainer">
                            <div class="custom-select-trigger" id="prodiSelectTrigger">
                                <span id="selectedProdiText">
                                    <?php 
                                    $selected_prodi = isset($_GET['filter_prodi']) ? $_GET['filter_prodi'] : '';
                                    $prodi_display = '';
                                    if ($selected_prodi == 'TI') $prodi_display = 'Teknik Informatika (TI)';
                                    elseif ($selected_prodi == 'SI') $prodi_display = 'Sistem Informasi (SI)';
                                    elseif ($selected_prodi == 'TK') $prodi_display = 'Teknik Komputer (TK)';
                                    elseif ($selected_prodi == 'MI') $prodi_display = 'Manajemen Informatika (MI)';
                                    elseif ($selected_prodi == 'KA') $prodi_display = 'Komputerisasi Akuntansi (KA)';
                                    elseif ($selected_prodi == 'TE') $prodi_display = 'Teknik Elektro (TE)';
                                    elseif ($selected_prodi == 'DKV') $prodi_display = 'Desain Komunikasi Visual (DKV)';
                                    elseif ($selected_prodi == 'BD') $prodi_display = 'Bisnis Digital (BD)';
                                    else $prodi_display = '-- Semua Prodi --';
                                    echo $prodi_display;
                                    ?>
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="custom-select-options" id="prodiSelectOptions">
                                <div class="options-list" id="prodiOptionsList">
                                    <div class="option-item" data-value="">
                                        <i class="fas fa-list"></i> -- Semua Prodi --
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'TI') ? 'selected' : ''; ?>" data-value="TI">
                                        <i class="fas fa-laptop-code"></i> Teknik Informatika (TI)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'SI') ? 'selected' : ''; ?>" data-value="SI">
                                        <i class="fas fa-database"></i> Sistem Informasi (SI)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'TK') ? 'selected' : ''; ?>" data-value="TK">
                                        <i class="fas fa-microchip"></i> Teknik Komputer (TK)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'MI') ? 'selected' : ''; ?>" data-value="MI">
                                        <i class="fas fa-chart-line"></i> Manajemen Informatika (MI)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'KA') ? 'selected' : ''; ?>" data-value="KA">
                                        <i class="fas fa-calculator"></i> Komputerisasi Akuntansi (KA)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'TE') ? 'selected' : ''; ?>" data-value="TE">
                                        <i class="fas fa-plug"></i> Teknik Elektro (TE)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'DKV') ? 'selected' : ''; ?>" data-value="DKV">
                                        <i class="fas fa-palette"></i> Desain Komunikasi Visual (DKV)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'BD') ? 'selected' : ''; ?>" data-value="BD">
                                        <i class="fas fa-chart-simple"></i> Bisnis Digital (BD)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Active Filters Display -->
        <?php 
        $active_filters = [];
        if (isset($_GET['filter_prodi']) && $_GET['filter_prodi'] != '') {
            $prodi_name = '';
            if ($_GET['filter_prodi'] == 'TI') $prodi_name = 'Teknik Informatika (TI)';
            elseif ($_GET['filter_prodi'] == 'SI') $prodi_name = 'Sistem Informasi (SI)';
            elseif ($_GET['filter_prodi'] == 'TK') $prodi_name = 'Teknik Komputer (TK)';
            elseif ($_GET['filter_prodi'] == 'MI') $prodi_name = 'Manajemen Informatika (MI)';
            elseif ($_GET['filter_prodi'] == 'KA') $prodi_name = 'Komputerisasi Akuntansi (KA)';
            elseif ($_GET['filter_prodi'] == 'TE') $prodi_name = 'Teknik Elektro (TE)';
            elseif ($_GET['filter_prodi'] == 'DKV') $prodi_name = 'Desain Komunikasi Visual (DKV)';
            elseif ($_GET['filter_prodi'] == 'BD') $prodi_name = 'Bisnis Digital (BD)';
            $active_filters[] = $prodi_name;
        }
        ?>
        <?php if (!empty($active_filters)): ?>
        <div style="margin-bottom: 20px; display: flex; gap: 8px; flex-wrap: wrap;">
            <?php foreach ($active_filters as $filter): ?>
            <span class="filter-active">
                <i class="fas fa-tag"></i> <?= $filter; ?>
            </span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- TABLE -->
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:30px;"></th>
                        <th style="width:40px;">#</th>
                        <th>NIDN</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Email</th>
                        <th style="width:60px; text-align:center;">Matkul</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $limit = 10;
                    $total_data = count($data['dosen']);
                    $total_pages = ceil($total_data / $limit);
                    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($current_page < 1) $current_page = 1;
                    if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;
                    
                    $start_index = ($current_page - 1) * $limit;
                    $display_data = array_slice($data['dosen'], $start_index, $limit);
                    
                    $query_params = [];
                    if (isset($_GET['filter_prodi']) && $_GET['filter_prodi'] != '') {
                        $query_params[] = 'filter_prodi=' . $_GET['filter_prodi'];
                    }
                    $query_string = !empty($query_params) ? '&' . implode('&', $query_params) : '';
                    ?>
                    
                    <?php if (empty($display_data)): ?>
                    <tr>
                        <td colspan="7" style="text-align:center; color:#9aa0a6; padding:40px 0;">
                            <i class="fas fa-inbox" style="font-size:24px; display:block; margin-bottom:8px;"></i>
                            Tidak ada data dosen yang sesuai filter
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php $no = $start_index + 1; foreach ($display_data as $dsn): ?>
                        <!-- Main Row -->
                        <tr class="dosen-main-row" data-dosen-id="<?= $dsn['id']; ?>" onclick="toggleRow(<?= $dsn['id']; ?>)">
                            <td style="text-align:center;">
                                <span class="expand-icon">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </td>
                            <td><?= $no++; ?></td>
                            <td><code><?= htmlspecialchars($dsn['nidn'] ?? '-'); ?></code></td>
                            <td><?= htmlspecialchars($dsn['nama'] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($dsn['prodi'] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($dsn['email'] ?? '-'); ?></td>
                            <td style="text-align:center;">
                                <?php 
                                $matkul_count = isset($dsn['matkul_count']) ? $dsn['matkul_count'] : 0;
                                $max = 4;
                                $color = $matkul_count >= $max ? '#dc3545' : ($matkul_count >= 3 ? '#ff9800' : '#4caf50');
                                ?>
                                <span class="matkul-count" style="background:rgba(255,255,255,0.05); padding:2px 12px; border-radius:12px; font-size:13px; color:<?= $color; ?>;">
                                    <?= $matkul_count; ?>/<?= $max; ?>
                                </span>
                            </td>
                        </tr>
                        <!-- Action Row (Expanded) -->
                        <tr class="action-row" id="action-row-<?= $dsn['id']; ?>">
                            <td colspan="7">
                                <div class="action-container">
                                    <button class="action-btn action-matkul" onclick="event.stopPropagation(); openAssignModal(<?= $dsn['id']; ?>, '<?= htmlspecialchars($dsn['nama']); ?>', '<?= htmlspecialchars($dsn['prodi']); ?>')">
                                        <span class="action-icon"><i class="fas fa-book-open"></i></span>
                                        Tentukan Mata Kuliah
                                    </button>
                                    <div class="action-divider"></div>
                                    <a href="<?= BASEURL; ?>/AdminController/dosenEdit/<?= $dsn['id']; ?>" class="action-btn action-edit" onclick="event.stopPropagation();">
                                        <span class="action-icon"><i class="fas fa-edit"></i></span>
                                        Edit Dosen
                                    </a>
                                    <div class="action-divider"></div>
                                    <button class="action-btn action-delete" onclick="event.stopPropagation(); showDeleteConfirmDialog('Apakah Anda yakin ingin menghapus data dosen <strong><?= htmlspecialchars($dsn['nama']); ?></strong>?', '<?= BASEURL; ?>/AdminController/dosenDelete/<?= $dsn['id']; ?>')">
                                        <span class="action-icon"><i class="fas fa-trash"></i></span>
                                        Hapus Dosen
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <?php if ($total_data > $limit): ?>
        <div class="pagination-container">
            <div class="pagination-info">
                Menampilkan <?= $start_index + 1; ?> - <?= min($start_index + $limit, $total_data); ?> dari <?= $total_data; ?> data
            </div>
            <div class="d-flex gap-2">
                <?php if ($current_page > 1): ?>
                <a href="?page=<?= $current_page - 1; ?><?= $query_string; ?>" class="btn-pagination">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </a>
                <?php else: ?>
                <button class="btn-pagination" disabled>
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </button>
                <?php endif; ?>
                
                <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?= $current_page + 1; ?><?= $query_string; ?>" class="btn-pagination">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </a>
                <?php else: ?>
                <button class="btn-pagination" disabled>
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </button>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <a href="<?= BASEURL; ?>/AuthController/dashboard" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<script>
// ========== TOGGLE ROW EXPAND ==========
function toggleRow(dosenId) {
    var actionRow = document.getElementById('action-row-' + dosenId);
    var mainRow = document.querySelector('.dosen-main-row[data-dosen-id="' + dosenId + '"]');
    
    if (!actionRow || !mainRow) return;
    
    // Close all other expanded rows
    document.querySelectorAll('.action-row.show').forEach(function(row) {
        if (row.id !== 'action-row-' + dosenId) {
            row.classList.remove('show');
            var prevRow = row.previousElementSibling;
            if (prevRow && prevRow.classList.contains('dosen-main-row')) {
                prevRow.classList.remove('expanded');
                var icon = prevRow.querySelector('.expand-icon i');
                if (icon) {
                    icon.className = 'fas fa-chevron-down';
                }
            }
        }
    });
    
    // Toggle current row
    actionRow.classList.toggle('show');
    mainRow.classList.toggle('expanded');
    
    var icon = mainRow.querySelector('.expand-icon i');
    if (icon) {
        if (mainRow.classList.contains('expanded')) {
            icon.className = 'fas fa-chevron-up';
        } else {
            icon.className = 'fas fa-chevron-down';
        }
    }
}

// Close expanded rows when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.data-table')) {
        document.querySelectorAll('.action-row.show').forEach(function(row) {
            row.classList.remove('show');
            var prevRow = row.previousElementSibling;
            if (prevRow && prevRow.classList.contains('dosen-main-row')) {
                prevRow.classList.remove('expanded');
                var icon = prevRow.querySelector('.expand-icon i');
                if (icon) {
                    icon.className = 'fas fa-chevron-down';
                }
            }
        });
    }
});

// ========== MODAL ASSIGN MATA KULIAH ==========
const modalAssign = document.getElementById('modalAssignMatkul');
const modalBody = document.getElementById('modalContent');
let currentDosenId = null;
var BASE_URL = '<?= BASEURL; ?>';

// ===== FUNGSI UPDATE TABEL =====
function updateTableMatkulCount(dosenId, newCount) {
    var mainRow = document.querySelector('.dosen-main-row[data-dosen-id="' + dosenId + '"]');
    if (mainRow) {
        var countCell = mainRow.querySelector('.matkul-count');
        if (countCell) {
            var max = 4;
            var color = newCount >= max ? '#dc3545' : (newCount >= 3 ? '#ff9800' : '#4caf50');
            countCell.textContent = newCount + '/' + max;
            countCell.style.color = color;
        }
    }
}

function openAssignModal(dosenId, dosenNama, dosenProdi) {
    currentDosenId = dosenId;
    modalAssign.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    modalBody.innerHTML = `
        <div style="text-align:center; color:#9aa0a6; padding:40px 0;">
            <i class="fas fa-spinner fa-spin" style="font-size:24px;"></i>
            <p style="margin-top:12px;">Memuat data mata kuliah...</p>
        </div>
    `;
    
    var url = BASE_URL + '/AdminController/getMatkulByDosen/' + dosenId;
    
    fetch(url)
        .then(function(response) {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            return response.json();
        })
        .then(function(data) {
            if (data.success === false) {
                modalBody.innerHTML = `
                    <div class="alert-modal error">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>Error:</strong> ${data.message || 'Gagal memuat data'}
                        <br><br>
                        <button onclick="closeModal()" class="btn-close-modal">Tutup</button>
                    </div>
                `;
                return;
            }
            
            renderModalContent(dosenId, dosenNama, dosenProdi, data);
        })
        .catch(function(error) {
            console.error('❌ Fetch error:', error);
            modalBody.innerHTML = `
                <div class="alert-modal error">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Gagal memuat data!</strong>
                    <br><br>
                    <small>Error: ${error.message}</small>
                    <br><br>
                    <button onclick="closeModal()" class="btn-close-modal">Tutup</button>
                </div>
            `;
        });
}

function renderModalContent(dosenId, dosenNama, dosenProdi, data) {
    var matkulList = data.matkul || [];
    var assignedIds = data.assigned || [];
    var currentCount = assignedIds.length;
    var max = 4;
    var isFull = currentCount >= max;
    var prodi = data.prodi || dosenProdi;

    var html = `
        <div class="info-text-modal">
            <i class="fas fa-info-circle"></i>
            <strong>${dosenNama}</strong> (${prodi}) 
            - Saat ini mengampu <span class="count-current" id="countCurrent">${currentCount}</span> dari <span class="count-max">${max}</span> mata kuliah
            ${isFull ? ' <span style="color:#dc3545; font-weight:500;">(Maksimal tercapai!)</span>' : ''}
            <br>
            <small style="color:#5f6368;">Menampilkan mata kuliah dengan kode <strong>${prodi}-xxx</strong></small>
        </div>
    `;

    if (matkulList.length === 0) {
        html += `
            <div class="alert-modal error">
                <i class="fas fa-info-circle"></i>
                Tidak ada mata kuliah untuk prodi <strong>${prodi}</strong>. 
                Pastikan kode mata kuliah diawali dengan <strong>${prodi}-</strong> (contoh: ${prodi}-001).
            </div>
        `;
    } else {
        html += `<div class="matkul-grid">`;
        matkulList.forEach(function(matkul) {
            var isAssigned = assignedIds.includes(matkul.id);
            var kodeDisplay = matkul.kode || '-';
            var namaDisplay = matkul.nama || '-';
            var semesterDisplay = matkul.semester ? 'Sem ' + matkul.semester : '';
            var sksDisplay = matkul.sks ? matkul.sks + ' SKS' : '';
            
            html += `
                <div class="matkul-item" id="matkul-${matkul.id}" data-matkul-id="${matkul.id}">
                    <div class="matkul-info">
                        <span class="kode">${kodeDisplay}</span>
                        <span class="nama">${namaDisplay}</span>
                        <span class="kelas">${semesterDisplay} ${sksDisplay}</span>
                    </div>
                    <div class="matkul-action">
                        ${isAssigned ? `
                            <span class="badge-assigned"><i class="fas fa-check"></i> Diampu</span>
                            <button class="btn-remove" onclick="removeMatkul(${dosenId}, ${matkul.id})" data-matkul-id="${matkul.id}">
                                <i class="fas fa-times"></i> Lepas
                            </button>
                        ` : `
                            <button class="btn-assign" onclick="assignMatkul(${dosenId}, ${matkul.id})" ${isFull ? 'disabled title="Maksimal 4 mata kuliah"' : ''} data-matkul-id="${matkul.id}">
                                <i class="fas fa-plus"></i> Ambil
                            </button>
                        `}
                    </div>
                </div>
            `;
        });
        html += `</div>`;
    }

    modalBody.innerHTML = html;
}

// ========== CUSTOM CONFIRM DIALOG FOR ASSIGN/REMOVE (Z-INDEX TERTINGGI) ==========
const confirmAssignOverlay = document.getElementById('customConfirmAssignOverlay');
const confirmAssignMessage = document.getElementById('confirmAssignMessage');
const confirmAssignCancelBtn = document.getElementById('confirmAssignCancelBtn');
const confirmAssignBtn = document.getElementById('confirmAssignBtn');
let pendingAssignAction = null;
let pendingAssignData = null;

function showAssignConfirmDialog(message, action, dosenId, matkulId, currentCount) {
    var iconElement = document.querySelector('#customConfirmAssignOverlay .assign-icon i');
    var titleElement = document.getElementById('confirmAssignTitle');
    
    if (action === 'success') {
        iconElement.className = 'fas fa-check-circle';
        iconElement.style.color = '#4caf50';
        titleElement.textContent = '✅ Berhasil';
    } else if (action === 'error') {
        iconElement.className = 'fas fa-exclamation-circle';
        iconElement.style.color = '#dc3545';
        titleElement.textContent = '❌ Gagal';
    } else {
        iconElement.className = 'fas fa-exchange-alt';
        iconElement.style.color = '#4caf50';
        titleElement.textContent = 'Konfirmasi';
    }
    
    confirmAssignMessage.innerHTML = message;
    pendingAssignAction = action;
    pendingAssignData = { dosenId, matkulId, currentCount };
    confirmAssignOverlay.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeAssignConfirmDialog() {
    confirmAssignOverlay.classList.remove('show');
    document.body.style.overflow = '';
    pendingAssignAction = null;
    pendingAssignData = null;
    
    document.getElementById('confirmAssignBtn').innerHTML = '<i class="fas fa-check"></i> Ya, Lanjutkan';
    document.getElementById('confirmAssignBtn').disabled = false;
    document.getElementById('confirmAssignBtn').onclick = executeAssignAction;
    
    var iconElement = document.querySelector('#customConfirmAssignOverlay .assign-icon i');
    if (iconElement) {
        iconElement.className = 'fas fa-exchange-alt';
        iconElement.style.color = '#4caf50';
    }
    document.getElementById('confirmAssignTitle').textContent = 'Konfirmasi';
}

function executeAssignAction() {
    if (!pendingAssignAction || !pendingAssignData) return;
    
    const { dosenId, matkulId, currentCount } = pendingAssignData;
    
    if (document.getElementById('confirmAssignBtn').disabled) {
        return;
    }
    
    document.getElementById('confirmAssignBtn').disabled = true;
    document.getElementById('confirmAssignBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    
    if (pendingAssignAction === 'assign') {
        if (currentCount >= 4) {
            showAssignConfirmDialog(
                'Dosen ini sudah mencapai maksimal 4 mata kuliah!',
                'error', dosenId, matkulId, currentCount
            );
            document.getElementById('confirmAssignBtn').innerHTML = '<i class="fas fa-times"></i> Tutup';
            document.getElementById('confirmAssignBtn').disabled = false;
            document.getElementById('confirmAssignBtn').onclick = function() {
                closeAssignConfirmDialog();
            };
            return;
        }
        
        var url = BASE_URL + '/AdminController/assignMatkul';
        fetch(url, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'dosen_id=' + dosenId + '&matkul_id=' + matkulId
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            return response.json();
        })
        .then(function(data) {
            closeAssignConfirmDialog();
            
            if (data && data.success === true) {
                var newCount = currentCount + 1;
                
                var countElement = document.getElementById('countCurrent');
                if (countElement) {
                    countElement.textContent = newCount;
                }
                
                updateTableMatkulCount(dosenId, newCount);
                
                var dosenNama = document.querySelector('.dosen-main-row[data-dosen-id="' + dosenId + '"]').querySelector('td:nth-child(4)').textContent.trim();
                var dosenProdi = document.querySelector('.dosen-main-row[data-dosen-id="' + dosenId + '"]').querySelector('td:nth-child(5)').textContent.trim();
                
                var urlData = BASE_URL + '/AdminController/getMatkulByDosen/' + dosenId;
                fetch(urlData)
                    .then(function(res) { return res.json(); })
                    .then(function(newData) {
                        renderModalContent(dosenId, dosenNama, dosenProdi, newData);
                    });
                
                showAssignConfirmDialog(
                    'Mata kuliah berhasil diassign.',
                    'success', dosenId, matkulId, currentCount
                );
                document.getElementById('confirmAssignBtn').innerHTML = '<i class="fas fa-check"></i> OK';
                document.getElementById('confirmAssignBtn').disabled = false;
                document.getElementById('confirmAssignBtn').onclick = function() {
                    closeAssignConfirmDialog();
                };
            } else {
                var errorMessage = data && data.message ? data.message : 'Terjadi kesalahan';
                showAssignConfirmDialog(
                    errorMessage,
                    'error', dosenId, matkulId, currentCount
                );
                document.getElementById('confirmAssignBtn').innerHTML = '<i class="fas fa-times"></i> Tutup';
                document.getElementById('confirmAssignBtn').disabled = false;
                document.getElementById('confirmAssignBtn').onclick = function() {
                    closeAssignConfirmDialog();
                };
            }
        })
        .catch(function(error) {
            closeAssignConfirmDialog();
            showAssignConfirmDialog(
                'Terjadi kesalahan. Silakan coba lagi.',
                'error', dosenId, matkulId, currentCount
            );
            document.getElementById('confirmAssignBtn').innerHTML = '<i class="fas fa-times"></i> Tutup';
            document.getElementById('confirmAssignBtn').disabled = false;
            document.getElementById('confirmAssignBtn').onclick = function() {
                closeAssignConfirmDialog();
            };
        });
        
    } else if (pendingAssignAction === 'remove') {
        var url = BASE_URL + '/AdminController/removeMatkul';
        fetch(url, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'dosen_id=' + dosenId + '&matkul_id=' + matkulId
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            return response.json();
        })
        .then(function(data) {
            closeAssignConfirmDialog();
            
            if (data && data.success === true) {
                var newCount = currentCount - 1;
                if (newCount < 0) newCount = 0;
                
                var countElement = document.getElementById('countCurrent');
                if (countElement) {
                    countElement.textContent = newCount;
                }
                
                updateTableMatkulCount(dosenId, newCount);
                
                var dosenNama = document.querySelector('.dosen-main-row[data-dosen-id="' + dosenId + '"]').querySelector('td:nth-child(4)').textContent.trim();
                var dosenProdi = document.querySelector('.dosen-main-row[data-dosen-id="' + dosenId + '"]').querySelector('td:nth-child(5)').textContent.trim();
                
                var urlData = BASE_URL + '/AdminController/getMatkulByDosen/' + dosenId;
                fetch(urlData)
                    .then(function(res) { return res.json(); })
                    .then(function(newData) {
                        renderModalContent(dosenId, dosenNama, dosenProdi, newData);
                    });
                
                showAssignConfirmDialog(
                    'Mata kuliah berhasil dilepas.',
                    'success', dosenId, matkulId, currentCount
                );
                document.getElementById('confirmAssignBtn').innerHTML = '<i class="fas fa-check"></i> OK';
                document.getElementById('confirmAssignBtn').disabled = false;
                document.getElementById('confirmAssignBtn').onclick = function() {
                    closeAssignConfirmDialog();
                };
            } else {
                var errorMessage = data && data.message ? data.message : 'Terjadi kesalahan';
                showAssignConfirmDialog(
                    errorMessage,
                    'error', dosenId, matkulId, currentCount
                );
                document.getElementById('confirmAssignBtn').innerHTML = '<i class="fas fa-times"></i> Tutup';
                document.getElementById('confirmAssignBtn').disabled = false;
                document.getElementById('confirmAssignBtn').onclick = function() {
                    closeAssignConfirmDialog();
                };
            }
        })
        .catch(function(error) {
            closeAssignConfirmDialog();
            showAssignConfirmDialog(
                'Terjadi kesalahan. Silakan coba lagi.',
                'error', dosenId, matkulId, currentCount
            );
            document.getElementById('confirmAssignBtn').innerHTML = '<i class="fas fa-times"></i> Tutup';
            document.getElementById('confirmAssignBtn').disabled = false;
            document.getElementById('confirmAssignBtn').onclick = function() {
                closeAssignConfirmDialog();
            };
        });
    }
}

confirmAssignCancelBtn.addEventListener('click', function() {
    closeAssignConfirmDialog();
});

confirmAssignBtn.addEventListener('click', executeAssignAction);

confirmAssignOverlay.addEventListener('click', function(event) {
    if (event.target === confirmAssignOverlay) {
        closeAssignConfirmDialog();
    }
});

// ===== FUNGSI assignMatkul & removeMatkul =====
function assignMatkul(dosenId, matkulId) {
    var countElement = document.getElementById('countCurrent');
    var currentCount = countElement ? parseInt(countElement.textContent) : 0;
    
    if (currentCount >= 4) {
        showAssignConfirmDialog(
            'Dosen ini sudah mencapai maksimal 4 mata kuliah!',
            'error', dosenId, matkulId, currentCount
        );
        document.getElementById('confirmAssignBtn').innerHTML = '<i class="fas fa-times"></i> Tutup';
        document.getElementById('confirmAssignBtn').onclick = function() {
            closeAssignConfirmDialog();
        };
        return;
    }
    
    var matkulItem = document.getElementById('matkul-' + matkulId);
    if (!matkulItem) {
        alert('Data mata kuliah tidak ditemukan. Silakan refresh halaman.');
        return;
    }
    
    var matkulNama = matkulItem.querySelector('.nama').textContent || 'Mata Kuliah';
    var matkulKode = matkulItem.querySelector('.kode').textContent || '';
    
    var message = `
        <strong>📖 Ambil Mata Kuliah</strong><br>
        Apakah Anda yakin ingin mengambil mata kuliah<br>
        <strong>${matkulKode} - ${matkulNama}</strong><br>
        untuk dosen ini?
    `;
    document.getElementById('confirmAssignBtn').innerHTML = '<i class="fas fa-check"></i> Ya, Lanjutkan';
    document.getElementById('confirmAssignBtn').disabled = false;
    document.getElementById('confirmAssignBtn').onclick = function() {
        executeAssignAction('assign', dosenId, matkulId, currentCount);
    };
    showAssignConfirmDialog(message, 'assign', dosenId, matkulId, currentCount);
}

function removeMatkul(dosenId, matkulId) {
    var countElement = document.getElementById('countCurrent');
    var currentCount = countElement ? parseInt(countElement.textContent) : 0;
    
    var matkulItem = document.getElementById('matkul-' + matkulId);
    if (!matkulItem) {
        alert('Data mata kuliah tidak ditemukan. Silakan refresh halaman.');
        return;
    }
    
    var matkulNama = matkulItem.querySelector('.nama').textContent || 'Mata Kuliah';
    var matkulKode = matkulItem.querySelector('.kode').textContent || '';
    
    var message = `
        <strong>📖 Lepas Mata Kuliah</strong><br>
        Apakah Anda yakin ingin melepas mata kuliah<br>
        <strong>${matkulKode} - ${matkulNama}</strong><br>
        dari dosen ini?
    `;
    document.getElementById('confirmAssignBtn').innerHTML = '<i class="fas fa-check"></i> Ya, Lanjutkan';
    document.getElementById('confirmAssignBtn').disabled = false;
    document.getElementById('confirmAssignBtn').onclick = function() {
        executeAssignAction('remove', dosenId, matkulId, currentCount);
    };
    showAssignConfirmDialog(message, 'remove', dosenId, matkulId, currentCount);
}

// ===== MODAL CLOSE =====
function closeModal() {
    modalAssign.classList.remove('show');
    document.body.style.overflow = '';
}

document.getElementById('modalCloseBtn').addEventListener('click', closeModal);
document.getElementById('modalCloseBtnFooter').addEventListener('click', closeModal);
modalAssign.addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

// ========== CUSTOM CONFIRM DELETE ==========
const confirmDeleteOverlay = document.getElementById('customConfirmDeleteOverlay');
const confirmDeleteMessage = document.getElementById('confirmDeleteMessage');
const confirmDeleteCancelBtn = document.getElementById('confirmDeleteCancelBtn');
const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
let pendingDeleteUrl = null;

function showDeleteConfirmDialog(message, deleteUrl) {
    confirmDeleteMessage.innerHTML = message;
    pendingDeleteUrl = deleteUrl;
    confirmDeleteOverlay.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeDeleteConfirmDialog() {
    confirmDeleteOverlay.classList.remove('show');
    document.body.style.overflow = '';
    pendingDeleteUrl = null;
}

confirmDeleteCancelBtn.addEventListener('click', closeDeleteConfirmDialog);
confirmDeleteBtn.addEventListener('click', function() {
    if (pendingDeleteUrl) {
        window.location.href = pendingDeleteUrl;
    }
    closeDeleteConfirmDialog();
});
confirmDeleteOverlay.addEventListener('click', function(event) {
    if (event.target === confirmDeleteOverlay) closeDeleteConfirmDialog();
});

// ========== CONFIRM LOGOUT ==========
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
}

confirmLogoutCancelBtn.addEventListener('click', closeLogoutConfirmDialog);
confirmLogoutBtn.addEventListener('click', executeLogout);
confirmLogoutOverlay.addEventListener('click', (e) => {
    if (e.target === confirmLogoutOverlay) closeLogoutConfirmDialog();
});

logoutBtn.addEventListener('click', (e) => {
    e.preventDefault();
    showLogoutConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout');
});

sideLogoutBtn.addEventListener('click', (e) => {
    e.preventDefault();
    showLogoutConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout');
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

// ========== CUSTOM SELECT FOR PRODI FILTER ==========
function initCustomSelect(containerId, triggerId, optionsId, selectedTextId, selectedValueId, formId) {
    const container = document.getElementById(containerId);
    const trigger = document.getElementById(triggerId);
    const optionsContainer = document.getElementById(optionsId);
    const selectedText = document.getElementById(selectedTextId);
    const selectedValue = document.getElementById(selectedValueId);
    const filterForm = document.getElementById(formId);

    function toggleDropdown() {
        optionsContainer.classList.toggle('show');
        trigger.classList.toggle('open');
    }

    function selectOption(value, text) {
        selectedText.textContent = text;
        selectedValue.value = value;
        
        optionsContainer.querySelectorAll('.option-item').forEach(opt => {
            opt.classList.remove('selected');
        });
        
        const selectedOpt = Array.from(optionsContainer.querySelectorAll('.option-item')).find(
            opt => opt.getAttribute('data-value') === value
        );
        if (selectedOpt) selectedOpt.classList.add('selected');
        
        optionsContainer.classList.remove('show');
        trigger.classList.remove('open');
        
        if (filterForm) {
            filterForm.submit();
        }
    }

    trigger.addEventListener('click', toggleDropdown);

    optionsContainer.querySelectorAll('.option-item').forEach(option => {
        option.addEventListener('click', () => {
            const value = option.getAttribute('data-value');
            const text = option.textContent.trim();
            selectOption(value, text);
        });
    });

    document.addEventListener('click', function(event) {
        if (container && !container.contains(event.target)) {
            optionsContainer.classList.remove('show');
            trigger.classList.remove('open');
        }
    });
}

initCustomSelect('prodiSelectContainer', 'prodiSelectTrigger', 'prodiSelectOptions', 'selectedProdiText', 'selectedProdiValue', 'filterForm');
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>