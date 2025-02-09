document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


    // Sorting functionality
    let currentSort = {
        column: 'created_at',
        direction: 'desc'
    };

    document.querySelectorAll('th[data-sort]').forEach(header => {
        header.addEventListener('click', function() {
            const column = this.dataset.sort;
            const direction = currentSort.column === column && currentSort.direction === 'asc' ? 'desc' : 'asc';
            
            // Update sort icons
            document.querySelectorAll('.fa-sort').forEach(icon => {
                icon.className = 'fas fa-sort ms-1';
            });
            
            const icon = document.getElementById(`sortIcon-${column}`);
            icon.className = `fas fa-sort-${direction === 'asc' ? 'up' : 'down'} ms-1`;

            // Update current sort
            currentSort = { column, direction };

            // Make AJAX request to fetch sorted data
            fetchLogs();
        });
    });

    // Expand/collapse functionality
    document.querySelectorAll('.expand-button').forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('.fa-chevron-right');
            icon.style.transform = icon.style.transform === 'rotate(90deg)' 
                ? 'rotate(0deg)' 
                : 'rotate(90deg)';
            icon.style.transition = 'transform 0.2s';
        });
    });

    // Set default date if not already set
    const dateInput = document.querySelector('input[type="date"]');
    if (!dateInput.value) {
        dateInput.value = new Date().toISOString().split('T')[0];
    }

    // Handle filter and search actions
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        fetchLogs();
    });

    // Fetch logs with applied filters, sort, and search
    function fetchLogs() {
        const search = document.querySelector('input[name="search"]').value;
        const activityType = document.querySelector('select[name="activity_type"]').value;
        const date = document.querySelector('input[name="date"]').value;

        const params = new URLSearchParams({
            search,
            activity_type: activityType,
            date,
            sort_by: currentSort.column,
            sort_order: currentSort.direction
        });

        fetch(`/logs?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                updateTable(data.logs);
            })
            .catch(error => console.error('Error fetching logs:', error));
    }

    // Update the logs table with the response data
    function updateTable(logs) {
        const tbody = document.querySelector('tbody');
        tbody.innerHTML = ''; // Clear the current table data

        logs.forEach(log => {
            const row = document.createElement('tr');
            row.classList.add('cursor-pointer', 'expand-button');
            row.setAttribute('data-bs-toggle', 'collapse');
            row.setAttribute('data-bs-target', `#details-${log.id}`);

            // Format the log's created_at field into a readable date-time format
            const createdAt = new Date(log.created_at).toLocaleString(); 

            row.innerHTML = `
                <td><i class="fas fa-chevron-right"></i></td>
                <td>${createdAt}</td>
                <td>${log.email}</td>
                <td><span class="badge bg-${log.activity_type === 'login' ? 'success' : 'primary'}">${log.activity_type}</span></td>
                <td>${log.status ?? 'N/A'}</td>
            `;

            tbody.appendChild(row);
        });
    }
});
