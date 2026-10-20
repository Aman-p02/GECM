/**
 * GEC MODASA — ADMIN PANEL JAVASCRIPT
 * Handles sidebar toggling, instant table search filtering, CSV export, print, and modal dialogs.
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Mobile Sidebar Toggle
    const sidebar = document.getElementById('adminSidebar');
    const toggleBtn = document.getElementById('sidebarToggleBtn');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('open');
        });
    }

    // 2. Real-Time Table Search Filter
    const searchInputs = document.querySelectorAll('[data-table-search]');
    searchInputs.forEach(function (input) {
        input.addEventListener('keyup', function () {
            const query = this.value.toLowerCase().trim();
            const targetTableId = this.getAttribute('data-table-search');
            const table = document.getElementById(targetTableId);
            if (!table) return;

            const tbody = table.querySelector('tbody');
            if (!tbody) return;

            const rows = tbody.querySelectorAll('tr');
            rows.forEach(function (row) {
                // If it's a "no records" row, ignore
                if (row.classList.contains('no-records-row')) return;
                const text = row.textContent.toLowerCase();
                if (text.indexOf(query) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // 3. Status Filter Dropdown
    const statusFilters = document.querySelectorAll('[data-table-filter]');
    statusFilters.forEach(function (select) {
        select.addEventListener('change', function () {
            const filterValue = this.value.toLowerCase().trim();
            const targetTableId = this.getAttribute('data-table-filter');
            const table = document.getElementById(targetTableId);
            if (!table) return;

            const tbody = table.querySelector('tbody');
            if (!tbody) return;

            const rows = tbody.querySelectorAll('tr');
            rows.forEach(function (row) {
                if (row.classList.contains('no-records-row')) return;
                if (!filterValue || filterValue === 'all') {
                    row.style.display = '';
                    return;
                }
                const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();
                const rowCategory = (row.getAttribute('data-category') || '').toLowerCase();
                if (rowStatus === filterValue || rowCategory === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // 4. Print Functionality
    const printButtons = document.querySelectorAll('.btn-export-print');
    printButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            window.print();
        });
    });

    // 5. Excel / CSV Export
    const excelButtons = document.querySelectorAll('.btn-export-excel');
    excelButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const targetTableId = this.getAttribute('data-target-table') || 'dataTable';
            const table = document.getElementById(targetTableId);
            if (!table) return;

            let csv = [];
            const rows = table.querySelectorAll('tr');
            for (let i = 0; i < rows.length; i++) {
                let row = [], cols = rows[i].querySelectorAll('th, td');
                // Skip actions column (last column if named Actions)
                let colCount = cols.length;
                if (cols[cols.length - 1] && cols[cols.length - 1].textContent.trim().toLowerCase() === 'actions') {
                    colCount = cols.length - 1;
                }
                for (let j = 0; j < colCount; j++) {
                    let text = cols[j].innerText.replace(/"/g, '""').trim();
                    row.push('"' + text + '"');
                }
                if (row.length > 0) {
                    csv.push(row.join(','));
                }
            }
            const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
            const downloadLink = document.createElement('a');
            downloadLink.download = (targetTableId || 'export') + '_' + new Date().toISOString().slice(0, 10) + '.csv';
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = 'none';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        });
    });

    // 6. PDF Export (clean print fallback with instructions or direct trigger)
    const pdfButtons = document.querySelectorAll('.btn-export-pdf');
    pdfButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            window.print();
        });
    });

    // 7. Auto Dismiss Alerts
    const alerts = document.querySelectorAll('.admin-alert');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.4s ease';
            setTimeout(function () {
                if (alert.parentNode) alert.parentNode.removeChild(alert);
            }, 400);
        }, 5000);
    });
});

// Modal Helpers
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
    }
}

// Close modal if user clicks on overlay background
document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('active');
    }
});
