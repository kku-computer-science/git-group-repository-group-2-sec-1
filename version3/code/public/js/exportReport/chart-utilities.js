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
    try {
        if (window.DEBUG) console.log('Generating chart with', activities.length, 'activities');
        
        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (!activities || activities.length === 0) {
            console.warn('No activities to display in chart');
            const chartCanvas = document.getElementById('activityChart');
            if (chartCanvas && chartCanvas.getContext) {
                const ctx = chartCanvas.getContext('2d');
                ctx.clearRect(0, 0, chartCanvas.width, chartCanvas.height);
                ctx.font = '16px Arial';
                ctx.textAlign = 'center';
                ctx.fillStyle = '#666';
                ctx.fillText('ไม่พบข้อมูลกิจกรรมในช่วงเวลาที่เลือก', chartCanvas.width / 2, chartCanvas.height / 2);
            }
            return null;
        }
        
        // ตรวจสอบว่า Chart.js ถูกโหลดหรือไม่
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded');
            alert('ไม่สามารถโหลด Chart.js ได้ กรุณารีเฟรชหน้าและลองใหม่อีกครั้ง');
            return null;
        }
        
        // จัดกลุ่มข้อมูลตามวันที่และประเภท
        const groupedData = groupActivitiesByDateAndType(activities, activityTypeConfig);
        
        if (window.DEBUG) console.log('Grouped chart data:', groupedData);
        
        // หา canvas element
        const chartCanvas = document.getElementById('activityChart');
        if (!chartCanvas) {
            console.error('Chart canvas element not found');
            return null;
        }
        
        // ทำให้ canvas มองเห็นและมีขนาด
        chartCanvas.style.display = 'block';
        if (!chartCanvas.style.height) {
            chartCanvas.style.height = '350px';
        }
        
        const ctx = chartCanvas.getContext('2d');
        
        // ลบ chart เดิมถ้ามีอยู่
        if (activityChart) {
            activityChart.destroy();
        }
        
        // สร้าง chart ใหม่
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
        
        if (window.DEBUG) console.log('Chart created successfully');
        
        // กระตุ้นให้ chart แสดงผล
        setTimeout(() => {
            if (typeof forceChartRender === 'function') {
                forceChartRender();
            }
        }, 100);
        
        return activityChart;
    } catch (error) {
        console.error('Error generating chart:', error);
        alert('เกิดข้อผิดพลาดในการสร้างกราฟ: ' + error.message);
        return null;
    }
}

/**
 * Group activities by date and type for charting
 * @param {Array} activities - Activities to group
 * @param {Object} activityTypeConfig - Configuration for activity types
 * @returns {Object} Object with dates array and datasets array
 */
function groupActivitiesByDateAndType(activities, activityTypeConfig) {
    try {
        // ตรวจสอบข้อมูลที่ได้รับ
        if (!Array.isArray(activities)) {
            console.error('Activities must be an array');
            return { dates: [], datasets: [] };
        }
        
        if (!activityTypeConfig || typeof activityTypeConfig !== 'object') {
            console.error('Activity type config must be an object');
            return { dates: [], datasets: [] };
        }
        
        // เรียงลำดับตามวันที่
        const sortedActivities = [...activities].sort((a, b) => {
            return new Date(a.timestamp) - new Date(b.timestamp);
        });
        
        // หาวันที่ที่ไม่ซ้ำกัน
        const dateMap = {};
        
        sortedActivities.forEach(activity => {
            // ข้ามกิจกรรมที่ไม่มี timestamp
            if (!activity.timestamp) {
                console.warn('Activity without timestamp found:', activity);
                return;
            }
            
            const date = new Date(activity.timestamp).toISOString().split('T')[0];
            if (!dateMap[date]) {
                dateMap[date] = {};
                Object.keys(activityTypeConfig).forEach(type => {
                    dateMap[date][type] = 0;
                });
            }
            
            // เพิ่มจำนวนตามประเภทและวันที่
            if (activity.type && dateMap[date][activity.type] !== undefined) {
                dateMap[date][activity.type]++;
            }
        });
        
        // แปลงเป็น array สำหรับ Chart.js
        const dates = Object.keys(dateMap).sort();
        
        // สร้าง datasets
        const datasets = [];
        Object.keys(activityTypeConfig).forEach(type => {
            // ตรวจสอบว่าประเภทนี้มีอยู่ในข้อมูลหรือไม่
            const exists = sortedActivities.some(activity => activity.type === type);
            
            if (exists) {
                const config = activityTypeConfig[type] || { label: type, color: 'rgba(0,0,0,0.5)' };
                datasets.push({
                    label: config.label || type,
                    data: dates.map(date => dateMap[date][type] || 0),
                    backgroundColor: config.color || 'rgba(0,0,0,0.5)',
                    borderColor: config.color ? config.color.replace('0.7', '1.0') : 'rgba(0,0,0,1.0)',
                    borderWidth: 1
                });
            }
        });
        
        if (window.DEBUG) {
            console.log('Grouped data:', { 
                dateCount: dates.length, 
                datasetCount: datasets.length 
            });
        }
        
        return { dates, datasets };
    } catch (error) {
        console.error('Error grouping activities by date and type:', error);
        return { dates: [], datasets: [] };
    }
}

/**
 * Get the icon class for an activity type
 * @param {string} type - Activity type
 * @returns {string} Font Awesome icon class
 */
function getIconForActivityType(type) {
    const iconMap = {
        'Login': 'fas fa-sign-in-alt',
        'Login Failed': 'fas fa-user-times',
        'Logout': 'fas fa-sign-out-alt',
        'Error': 'fas fa-exclamation-triangle',
        'Create': 'fas fa-plus-circle',
        'Update': 'fas fa-edit',
        'Delete': 'fas fa-trash-alt',
        'Call Paper': 'fas fa-file-alt'
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
        'Login': 'success',
        'Login Failed': 'danger',
        'Logout': 'primary',
        'Error': 'warning',
        'Create': 'purple',
        'Update': 'info',
        'Delete': 'orange',
        'Call Paper': 'blue'
    };
    
    return colorMap[type] || 'secondary';
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
 * Generate statistics summary cards
 * @param {Array} activities - Filtered activities to summarize
 * @param {Object} activityTypeConfig - Configuration for activity types
 * @returns {Object} Stats data by activity type
 */
function generateStatsSummary(activities, activityTypeConfig) {
    try {
        const statsContainer = document.getElementById('statsContainer');
        if (!statsContainer) {
            console.error('Stats container not found');
            return {};
        }
        
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
    } catch (error) {
        console.error('Error generating stats summary:', error);
        return {};
    }
}
