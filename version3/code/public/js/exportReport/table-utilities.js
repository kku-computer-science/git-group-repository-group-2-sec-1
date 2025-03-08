/**
 * Table Utilities
 * Functions for generating and handling table data in the activity report
 */

// Global variables
let currentPage = 1;
const itemsPerPage = 10;

/**
 * Get Bootstrap color class for activity type
 * @param {string} type - Activity type
 * @returns {string} Bootstrap color class
 */
function getColorClassForType(type) {
    const colorMap = {
        'loginSuccess': 'success',
        'loginFail': 'danger',
        'logout': 'primary',
        'error': 'warning',
        'create': 'purple',
        'update': 'info',
        'delete': 'orange',
        'callPaper': 'blue'
    };
    
    return colorMap[type] || 'secondary';
}

/**
 * Generate and display the activity table
 * @param {Array} activities - Filtered activities to display
 * @param {Object} activityTypeConfig - Configuration for activity types
 * @param {number} page - Page number to display
 */
function generateActivityTable(activities, activityTypeConfig, page) {
    try {
        currentPage = page || 1;
        const tableBody = document.getElementById('activityTableBody');
        if (!tableBody) {
            console.error('Activity table body not found');
            return null;
        }

        tableBody.innerHTML = '';
        
        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (!activities || !Array.isArray(activities) || activities.length === 0) {
            console.warn('No activities to display in table');
            tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-4">ไม่พบข้อมูลกิจกรรมในช่วงเวลาที่เลือก</td></tr>';
            return null;
        }
        
        // Calculate pagination
        const totalPages = Math.ceil(activities.length / itemsPerPage);
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, activities.length);
        
        // Get activities for current page
        const currentActivities = activities.slice(startIndex, endIndex);
        
        // Add rows to table
        currentActivities.forEach(activity => {
            const row = document.createElement('tr');
            
            try {
                // Format date
                let formattedDate = '';
                try {
                    const date = new Date(activity.timestamp);
                    formattedDate = date.toLocaleDateString('th-TH', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                } catch (e) {
                    console.warn('Error formatting date:', e);
                    formattedDate = activity.timestamp || '';
                }
                
                // Get activity type config
                const typeConfig = activityTypeConfig && activityTypeConfig[activity.type];
                const typeLabel = typeConfig ? typeConfig.label : activity.type;
                
                // Create status badge
                const statusBadge = `<span class="badge bg-${activity.status === 'success' ? 'success' : 'danger'}">${activity.status === 'success' ? 'สำเร็จ' : 'ไม่สำเร็จ'}</span>`;
                
                // Create activity type badge
                const typeClass = getColorClassForType(activity.type);
                const typeBadge = `<span class="text-black badge activity-type-${activity.type}">${typeLabel}</span>`;
                
                // Set row content
                row.innerHTML = `
                    <td>${formattedDate}</td>
                    <td>${activity.username || ''}</td>
                    <td><span class="badge bg-secondary bg-opacity-50 text-black">${activity.ipAddress || ''}</span></td>
                    <td>${typeBadge}</td>
                    <td>${activity.details || ''}</td>
                    <td>${statusBadge}</td>
                `;
            } catch (error) {
                console.error('Error creating table row:', error);
                row.innerHTML = '<td colspan="6" class="text-center">ข้อมูลไม่ถูกต้อง</td>';
            }
            
            tableBody.appendChild(row);
        });
        
        // Update table info
        updateTableInfo(activities.length, startIndex + 1, endIndex);
        
        // Update pagination
        updatePagination(activities, currentPage, totalPages);
        
        return {
            currentPage,
            totalPages,
            totalItems: activities.length
        };
    } catch (error) {
        console.error('Error generating activity table:', error);
        return null;
    }
}

/**
 * Update table information text
 * @param {number} totalItems - Total number of items
 * @param {number} startItem - Starting item number
 * @param {number} endItem - Ending item number
 */
function updateTableInfo(totalItems, startItem, endItem) {
    const tableInfo = document.getElementById('tableInfo');
    if (tableInfo) {
        tableInfo.textContent = `แสดง ${startItem} ถึง ${endItem} จากทั้งหมด ${totalItems} รายการ`;
    }
}

/**
 * Update pagination controls
 * @param {Array} activities - All filtered activities
 * @param {number} currentPage - Current page number
 * @param {number} totalPages - Total number of pages
 */
function updatePagination(activities, currentPage, totalPages) {
    const pagination = document.getElementById('pagination');
    if (!pagination) {
        console.error('Pagination element not found');
        return;
    }
    
    pagination.innerHTML = '';
    
    // If no items or only one page, don't show pagination
    if (!activities || activities.length === 0 || totalPages <= 1) {
        return;
    }
    
    // Previous page button
    const prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>`;
    
    if (currentPage > 1) {
        prevLi.addEventListener('click', (e) => {
            e.preventDefault();
            generateActivityTable(activities, window.activityTypeConfig, currentPage - 1);
        });
    }
    
    pagination.appendChild(prevLi);
    
    // Page number buttons
    const maxPages = 5; // Maximum number of page links to show
    let startPage = Math.max(1, currentPage - Math.floor(maxPages / 2));
    let endPage = Math.min(totalPages, startPage + maxPages - 1);
    
    // Adjust if we're at the end
    if (endPage - startPage + 1 < maxPages && startPage > 1) {
        startPage = Math.max(1, endPage - maxPages + 1);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        const pageLi = document.createElement('li');
        pageLi.className = `page-item ${i === currentPage ? 'active' : ''}`;
        pageLi.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        
        if (i !== currentPage) {
            pageLi.addEventListener('click', (e) => {
                e.preventDefault();
                generateActivityTable(activities, window.activityTypeConfig, i);
            });
        }
        
        pagination.appendChild(pageLi);
    }
    
    // Next page button
    const nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>`;
    
    if (currentPage < totalPages) {
        nextLi.addEventListener('click', (e) => {
            e.preventDefault();
            generateActivityTable(activities, window.activityTypeConfig, currentPage + 1);
        });
    }
    
    pagination.appendChild(nextLi);
}

/**
 * Filter activities based on date range and activity types
 * @param {Array} allActivities - All available activities
 * @param {string} startDate - Start date in YYYY-MM-DD format
 * @param {string} endDate - End date in YYYY-MM-DD format
 * @param {Array} activityTypes - Array of activity types to include
 * @returns {Array} Filtered activities
 */
function filterActivities(allActivities, startDate, endDate, activityTypes) {
    try {
        if (!Array.isArray(allActivities)) {
            console.error('Activities must be an array');
            return [];
        }
        
        if (!Array.isArray(activityTypes)) {
            console.error('Activity types must be an array');
            return [];
        }
        
        const start = new Date(startDate);
        start.setHours(0, 0, 0, 0);
        
        const end = new Date(endDate);
        end.setHours(23, 59, 59, 999);
        
        return allActivities.filter(activity => {
            try {
                const activityDate = new Date(activity.timestamp);
                const isInDateRange = activityDate >= start && activityDate <= end;
                const isSelectedType = activityTypes.includes(activity.type);
                
                return isInDateRange && isSelectedType;
            } catch (error) {
                console.warn('Error filtering activity:', error, activity);
                return false;
            }
        });
    } catch (error) {
        console.error('Error in filterActivities:', error);
        return [];
    }
}

/**
 * Get selected activity types from checkboxes
 * @returns {Array} Array of selected activity types
 */
function getSelectedActivityTypes() {
    try {
        const checkboxes = document.querySelectorAll('input[name="activityType[]"]:checked');
        if (!checkboxes || checkboxes.length === 0) {
            console.warn('No activity type checkboxes selected');
            return [];
        }
        return Array.from(checkboxes).map(checkbox => checkbox.value);
    } catch (error) {
        console.error('Error getting selected activity types:', error);
        return [];
    }
}
