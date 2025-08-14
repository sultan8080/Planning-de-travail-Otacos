import './bootstrap.js';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.scss';

// ✅ DataTables imports
import 'jquery';
import 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';

// ✅ Initialize DataTables after Turbo navigation
document.addEventListener('turbo:load', () => {
    const tables = document.querySelectorAll('.datatable');
    tables.forEach(table => {
        if (!$.fn.DataTable.isDataTable(table)) {
            $(table).DataTable();
        }
    });
});
