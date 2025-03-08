/**
 * Chart Utilities
 * Functions for generating and handling charts in the activity report
 */

// Global variables
let activityChart = null;

/**
 * Generate and display the activity chart
 * @param {Array} activities - Filtered activities to display
 * @param {Object} activityTypeConfig - Configuration for activity types
 */
function generateActivityChart(activities, activityTypeConfig) {
    // Group activities by date and type
    const groupedData = groupActivitiesByDateAndType(activities, activityTypeConfig);
    
    // Get canvas element
    const ctx = document.getElementById('activityChart').getContext('2d');
    
    // Destroy existing chart if it exists
    if (activityChart) {
        activityChart.destroy();
    }
    
    // Create new chart
    activityChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: groupedData.dates,
            datasets: groupedData.datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true,
                    title: {
                        display: true,
                        text: 'วันที่'
                    }
                },
                y: {
                    stacked: true,
                    title: {
                        display: true,
                        text: 'จำนวนกิจกรรม'
                    },
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'กราฟแสดงกิจกรรมผู้ใช้งานในระบบ',
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    padding: {
                        top: 10,
                        bottom: 20
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });
    
    return activityChart;
}

/**
 * Group activities by date and type for charting
 * @param {Array} activities - Activities to group
 * @param {Object} activityTypeConfig - Configuration for activity types
 * @returns {Object} Object with dates array and datasets array
 */
function groupActivitiesByDateAndType(activities, activityTypeConfig) {
    // Sort activities by date
    const sortedActivities = [...activities].sort((a, b) => {
        return new Date(a.timestamp) - new Date(b.timestamp);
    });
    
    // Get unique dates
    const dateMap = {};
    
    sortedActivities.forEach(activity => {
        const date = new Date(activity.timestamp).toISOString().split('T')[0];
        if (!dateMap[date]) {
            dateMap[date] = {};
            Object.keys(activityTypeConfig).forEach(type => {
                dateMap[date][type] = 0;
            });
        }
        dateMap[date][activity.type]++;
    });
    
    // Convert to arrays for Chart.js
    const dates = Object.keys(dateMap).sort();
    
    // Create datasets
    const datasets = [];
    Object.keys(activityTypeConfig).forEach(type => {
        // Check if this activity type exists in the filtered data
        const exists = sortedActivities.some(activity => activity.type === type);
        
        if (exists) {
            const config = activityTypeConfig[type];
            datasets.push({
                label: config.label,
                data: dates.map(date => dateMap[date][type]),
                backgroundColor: config.color,
                borderColor: config.color.replace('0.7', '1.0'),
                borderWidth: 1
            });
        }
    });
    
    return { dates, datasets };
}

/**
 * Generate statistics summary cards
 * @param {Array} activities - Filtered activities to summarize
 * @param {Object} activityTypeConfig - Configuration for activity types
 * @returns {Object} Stats data by activity type
 */
function generateStatsSummary(activities, activityTypeConfig) {
    const statsContainer = document.getElementById('statsContainer');
    statsContainer.innerHTML = '';
    
    // Count activities by type
    const typeCounts = {};
    const activityTypes = Object.keys(activityTypeConfig);
    
    // Initialize counts
    activityTypes.forEach(type => {
        typeCounts[type] = 0;
    });
    
    // Count activities
    activities.forEach(activity => {
        if (typeCounts.hasOwnProperty(activity.type)) {
            typeCounts[activity.type]++;
        }
    });
    
    // Calculate total activities
    const totalActivities = activities.length;
    
    // Create total activities stat
    const totalStat = createStatCard('ทั้งหมด', totalActivities, 'fas fa-chart-line', 'primary');
    statsContainer.appendChild(totalStat);
    
    // Create stat cards for each activity type with at least 1 occurrence
    activityTypes.forEach(type => {
        if (typeCounts[type] > 0) {
            const config = activityTypeConfig[type];
            const colorClass = getColorClassForType(type);
            const statCard = createStatCard(
                config.label, 
                typeCounts[type], 
                getIconForActivityType(type), 
                colorClass
            );
            statsContainer.appendChild(statCard);
        }
    });
    
    return typeCounts;
}
/**
* Create a stat card element with improved text contrast
 * @param {string} label - Stat label
 * @param {number} count - Stat count
 * @param {string} iconClass - Font Awesome icon class
 * @param {string} colorClass - Bootstrap color class
 * @returns {HTMLElement} Stat card element
 */
function createStatCard(label, count, iconClass, colorClass) {
    const colDiv = document.createElement('div');
    colDiv.className = 'col-md-3 col-sm-6';
    
    const cardDiv = document.createElement('div');
    cardDiv.className = `card stat-card border-${colorClass} shadow-sm h-100`;
    
    const cardBody = document.createElement('div');
    cardBody.className = 'card-body';
    
    cardBody.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold text-${colorClass} mb-1">${label}</h6>
                <h4 class="mb-0 fw-bold text-dark">${count}</h4>
            </div>
            <div class="rounded-circle stat-icon bg-${colorClass} p-3">
                <i class="${iconClass} text-white"></i>
            </div>
        </div>
    `;
    
    cardDiv.appendChild(cardBody);
    colDiv.appendChild(cardDiv);
    
    return colDiv;
}

/**
 * Get the icon class for an activity type
 * @param {string} type - Activity type
 * @returns {string} Font Awesome icon class
 */
function getIconForActivityType(type) {
    const iconMap = {
        'loginSuccess': 'fas fa-sign-in-alt',
        'loginFail': 'fas fa-user-times',
        'logout': 'fas fa-sign-out-alt',
        'error': 'fas fa-exclamation-triangle',
        'create': 'fas fa-plus-circle',
        'update': 'fas fa-edit',
        'delete': 'fas fa-trash-alt',
        'callPaper': 'fas fa-file-alt'
    };
    
    return iconMap[type] || 'fas fa-question-circle';
}

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
