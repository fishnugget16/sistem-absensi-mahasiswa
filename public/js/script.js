// ========== ARSIP FUNGSI GLOBAL ==========

// ========== 1. TOGGLE SIDEBAR ==========
function initSidebar() {
    const toggleBtn = document.getElementById('toggleSidebar');
    const brandToggle = document.getElementById('brandToggle');
    const sideMenu = document.getElementById('sideMenuOverlay');
    const backdrop = document.getElementById('sidebarBackdrop');

    if (!toggleBtn || !sideMenu || !backdrop) return;

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
    if (brandToggle) brandToggle.addEventListener('click', toggleSidebar);
    backdrop.addEventListener('click', closeSidebar);

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sideMenu.classList.contains('open')) {
            closeSidebar();
        }
    });
}

// ========== 2. CUSTOM CONFIRM LOGOUT DIALOG ==========
function initLogoutConfirm() {
    const confirmOverlay = document.getElementById('customConfirmOverlay');
    const confirmMessage = document.getElementById('confirmMessage');
    const confirmCancelBtn = document.getElementById('confirmCancelBtn');
    const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
    const logoutBtn = document.getElementById('logoutBtn');
    const sideLogoutBtn = document.getElementById('sideLogoutBtn');

    if (!confirmOverlay) return;

    let pendingLogoutUrl = null;

    function showConfirmDialog(message, logoutUrl) {
        if (confirmMessage) confirmMessage.innerHTML = message;
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

    if (confirmCancelBtn) confirmCancelBtn.addEventListener('click', closeConfirmDialog);
    if (confirmLogoutBtn) confirmLogoutBtn.addEventListener('click', executeLogout);
    
    confirmOverlay.addEventListener('click', (e) => {
        if (e.target === confirmOverlay) closeConfirmDialog();
    });

    if (logoutBtn) {
        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            showConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', logoutBtn.dataset.logoutUrl);
        });
    }

    if (sideLogoutBtn) {
        sideLogoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            showConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', sideLogoutBtn.dataset.logoutUrl);
        });
    }
}

// ========== 3. CUSTOM SELECT DROPDOWN ==========
function initCustomSelect(containerId, optionsId, selectedTextId, selectedValueId) {
    const container = document.getElementById(containerId);
    const trigger = container ? container.querySelector('.custom-select-trigger') : null;
    const optionsContainer = document.getElementById(optionsId);
    const selectedText = document.getElementById(selectedTextId);
    const selectedValue = document.getElementById(selectedValueId);

    if (!container || !trigger || !optionsContainer) return;

    function toggleDropdown() {
        optionsContainer.classList.toggle('show');
        trigger.classList.toggle('open');
    }

    function selectOption(value, text) {
        if (selectedText) selectedText.textContent = text;
        if (selectedValue) selectedValue.value = value;
        
        container.querySelectorAll('.option-item').forEach(opt => {
            opt.classList.remove('selected');
        });
        
        const selectedOpt = Array.from(container.querySelectorAll('.option-item')).find(
            opt => opt.getAttribute('data-value') == value
        );
        if (selectedOpt) selectedOpt.classList.add('selected');
        
        optionsContainer.classList.remove('show');
        trigger.classList.remove('open');
    }

    trigger.addEventListener('click', toggleDropdown);

    container.querySelectorAll('.option-item').forEach(option => {
        option.addEventListener('click', () => {
            const value = option.getAttribute('data-value');
            const text = option.textContent.trim();
            selectOption(value, text);
        });
    });

    document.addEventListener('click', function(event) {
        if (!container.contains(event.target)) {
            optionsContainer.classList.remove('show');
            trigger.classList.remove('open');
        }
    });
}

// ========== 4. SEARCH FILTER UNTUK CUSTOM SELECT ==========
function initSearchFilter(searchInputId, optionsListId) {
    const searchInput = document.getElementById(searchInputId);
    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const optionsList = document.getElementById(optionsListId);
        if (!optionsList) return;
        
        optionsList.querySelectorAll('.option-item').forEach(option => {
            const text = option.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                option.style.display = 'flex';
            } else {
                option.style.display = 'none';
            }
        });
    });
}

// ========== INISIALISASI SEMUA FUNGSI SAAT DOKUMEN SIAP ==========
document.addEventListener('DOMContentLoaded', function() {
    initSidebar();
    initLogoutConfirm();
    
    // Init custom select untuk Program Studi
    initCustomSelect('prodiSelectContainer', 'prodiSelectOptions', 'selectedProdiText', 'selectedProdiValue');
    initSearchFilter('prodiSearchInput', 'prodiOptionsList');
});