// Main Dashboard Functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeTheme();
    initializeSidebar();
    initializeDropdowns();
    initializeCollapsibles();
});

// Theme Toggle
function initializeTheme() {
    const themeToggle = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('theme') || 'light-theme';
    
    document.body.className = savedTheme;
    updateThemeIcon();
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-theme');
            document.body.classList.toggle('light-theme');
            
            const currentTheme = document.body.classList.contains('dark-theme') ? 'dark-theme' : 'light-theme';
            localStorage.setItem('theme', currentTheme);
            
            updateThemeIcon();
        });
    }
    
    function updateThemeIcon() {
        const themeIcon = document.querySelector('#themeToggle i');
        if (themeIcon) {
            if (document.body.classList.contains('dark-theme')) {
                themeIcon.className = 'fas fa-sun';
            } else {
                themeIcon.className = 'fas fa-moon';
            }
        }
    }
}

// Sidebar Toggle
function initializeSidebar() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            mainContent.classList.toggle('expanded');
        });
    }
    
    if (sidebarClose) {
        sidebarClose.addEventListener('click', function() {
            sidebar.classList.remove('show');
            mainContent.classList.remove('expanded');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = sidebarToggle.contains(event.target);
            
            if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                mainContent.classList.remove('expanded');
            }
        }
    });
}

// Dropdown Menus
function initializeDropdowns() {
    const dropdowns = document.querySelectorAll('.user-dropdown, .notification-dropdown');
    
    dropdowns.forEach(dropdown => {
        const button = dropdown.querySelector('button');
        const menu = dropdown.querySelector('.dropdown-menu');
        
        if (button && menu) {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('show');
            });
        }
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
    });
}

// Collapsible Elements// Collapsible Elements
function initializeCollapsibles() {
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-collapse');
        const header = e.target.closest('.module-header, .content-header');
        const removeBtn = e.target.closest('.remove-module, .remove-content');
        
        // If click is on remove button, do nothing
        if (removeBtn) {
            return;
        }
        
        // If click is on collapse button
        if (btn) {
            e.stopPropagation();
            handleCollapse(btn);
        }
        // If click is on header area (but not on remove button)
        else if (header && !e.target.closest('.module-actions, .content-actions')) {
            handleCollapse(header);
        }
    });
    
    function handleCollapse(element) {
        let btn, target;
        
        // If element is already a button
        if (element.classList.contains('btn-collapse')) {
            btn = element;
        } 
        // If element is a header, find the collapse button within it
        else if (element.classList.contains('module-header') || element.classList.contains('content-header')) {
            btn = element.querySelector('.btn-collapse');
        }
        
        if (!btn) return;
        
        // Determine the target based on header type
        if (btn.closest('.content-header')) {
            const contentHeader = btn.closest('.content-header');
            target = contentHeader.nextElementSibling;
        } 
        else if (btn.closest('.module-header')) {
            const moduleCard = btn.closest('.module-card');
            target = moduleCard.querySelector('.module-body');
        }
        
        if (target && (target.classList.contains('content-body') || target.classList.contains('module-body'))) {
            target.classList.toggle('show');
            btn.classList.toggle('collapsed');
            
            const icon = btn.querySelector('i');
            if (icon) {
                icon.className = target.classList.contains('show') 
                    ? 'fas fa-chevron-down' 
                    : 'fas fa-chevron-right';
            }
        }
    }
}

// File Upload Enhancement
document.addEventListener('DOMContentLoaded', function() {
    const fileUploadAreas = document.querySelectorAll('.file-upload-area');
    
    fileUploadAreas.forEach(area => {
        const fileInput = area.querySelector('.file-input');
        const placeholder = area.querySelector('.upload-placeholder');
        
        // Ensure file input is properly accessible
        if (fileInput) {
            fileInput.style.display = 'block';
            fileInput.style.visibility = 'visible';
            fileInput.style.position = 'absolute';
            fileInput.style.top = '0';
            fileInput.style.left = '0';
            fileInput.style.width = '100%';
            fileInput.style.height = '100%';
            fileInput.style.opacity = '0';
            fileInput.style.cursor = 'pointer';
            fileInput.style.zIndex = '10';
        }
        
        // Click on area triggers file input
        area.addEventListener('click', (e) => {
            // Don't trigger if clicking on the actual file input
            if (e.target !== fileInput) {
                fileInput?.click();
            }
        });
        
        // Drag and drop handlers
        area.addEventListener('dragover', (e) => {
            e.preventDefault();
            area.classList.add('drag-over');
        });
        
        area.addEventListener('dragleave', (e) => {
            e.preventDefault();
            // Only remove class if leaving the area, not just moving between children
            if (!area.contains(e.relatedTarget)) {
                area.classList.remove('drag-over');
            }
        });
        
        area.addEventListener('drop', (e) => {
            e.preventDefault();
            area.classList.remove('drag-over');
            
            if (fileInput && e.dataTransfer.files.length > 0) {
                const files = e.dataTransfer.files;
                
                // Create a new DataTransfer to properly set files
                const dataTransfer = new DataTransfer();
                for (let file of files) {
                    dataTransfer.items.add(file);
                }
                fileInput.files = dataTransfer.files;
                
                // Trigger change event manually
                const event = new Event('change', { bubbles: true });
                fileInput.dispatchEvent(event);
                
                updateFileUploadDisplay(area, files[0]);
            }
        });
        
        // File input change handler
        if (fileInput) {
            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    updateFileUploadDisplay(area, e.target.files[0]);
                    
                    // Debug: Log file info
                    console.log('File selected:', {
                        name: e.target.files[0].name,
                        size: e.target.files[0].size,
                        type: e.target.files[0].type
                    });
                }
            });
        }
    });
    
    function updateFileUploadDisplay(area, file) {
        const placeholder = area.querySelector('.upload-placeholder');
        if (placeholder && file) {
            const fileSize = (file.size / (1024 * 1024)).toFixed(2);
            const fileType = file.type.split('/')[0]; // 'video' or 'image'
            
            let icon = 'fa-file';
            if (fileType === 'video') icon = 'fa-video';
            if (fileType === 'image') icon = 'fa-image';
            
            placeholder.innerHTML = `
                <i class="fas ${icon} text-success"></i>
                <h4 class="text-wrap-anywhere">${file.name}</h4>
                <p>${fileSize} MB • ${file.type}</p>
                <p class="upload-hint">Click or drag to change file</p>
            `;
            
            // Add success styling
            area.classList.add('file-selected');
        }
    }
    
    // Debug function to check form data before submission
    window.debugFormData = function() {
        const formData = new FormData(document.getElementById('courseForm'));
        console.log('=== FORM DATA DEBUG ===');
        for (let pair of formData.entries()) {
            if (pair[1] instanceof File) {
                console.log(`${pair[0]}: File - ${pair[1].name} (${pair[1].size} bytes)`);
            } else {
                console.log(`${pair[0]}: ${pair[1]}`);
            }
        }
        console.log('=== END DEBUG ===');
    };
});