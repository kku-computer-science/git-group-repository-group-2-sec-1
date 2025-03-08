/**
 * User Activity Report Main Script
 * This is the main script that initializes and coordinates the activity report functionality.
 * It imports functionality from the supporting utility files.
 */

// Global variables
let allActivities = [];
window.filteredActivities = window.filteredActivities || [];
window.activityTypeConfig = {}; // Make it accessible to other modules
// ใช้ window.DEBUG แทนการประกาศ DEBUG ใหม่

/**
 * Initialize the activity report functionality
 * @param {Array} activities - The activity data from the server
 * @param {Object} typeConfig - Configuration for activity types
 */
function initializeActivityReport(activities, typeConfig) {
    try {
        if (window.DEBUG) console.log('Initializing activity report with', activities.length, 'activities');
        
        // แปลง JSON string เป็น Object ถ้าจำเป็น
        if (typeof activities === 'string') {
            try {
                activities = JSON.parse(activities);
                if (window.DEBUG) console.log('Parsed activities from JSON string');
            } catch (error) {
                console.error('Error parsing activities JSON:', error);
            }
        }
        
        if (typeof typeConfig === 'string') {
            try {
                typeConfig = JSON.parse(typeConfig);
                if (window.DEBUG) console.log('Parsed typeConfig from JSON string');
            } catch (error) {
                console.error('Error parsing typeConfig JSON:', error);
            }
        }
        
        // ตรวจสอบว่า activityTypeConfig มีข้อมูลหรือไม่
        if (!typeConfig || Object.keys(typeConfig).length === 0) {
            console.warn('Activity type config is empty, using default config');
            
            // กำหนดค่าเริ่มต้นสำหรับประเภทกิจกรรม
            typeConfig = {
                "loginSuccess": {"color": "rgba(46, 204, 113, 0.7)", "label": "Login Success"},
                "loginFail": {"color": "rgba(231, 76, 60, 0.7)", "label": "Login Failed"},
                "logout": {"color": "rgba(52, 152, 219, 0.7)", "label": "Logout"},
                "error": {"color": "rgba(243, 156, 18, 0.7)", "label": "Error"},
                "create": {"color": "rgba(155, 89, 182, 0.7)", "label": "Create"},
                "update": {"color": "rgba(26, 188, 156, 0.7)", "label": "Update"},
                "delete": {"color": "rgba(211, 84, 0, 0.7)", "label": "Delete"},
                "callPaper": {"color": "rgba(41, 128, 185, 0.7)", "label": "Call Paper"}
            };
        }
        
        // Store the data globally
        allActivities = activities;
        window.activityTypeConfig = typeConfig;
        
        if (window.DEBUG) {
            console.log('Stored data globally:');
            console.log('- Activities:', allActivities.length);
            console.log('- Activity types:', Object.keys(window.activityTypeConfig).length);
        }
        
        // Set up event listeners
        setupEventListeners();
        
        // Check if URL has parameters to auto-load the report
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('dateRangeStart') || urlParams.has('activityType[]')) {
            if (window.DEBUG) console.log('URL parameters found, loading report');
            
            // Get values from URL parameters
            const startDate = urlParams.get('dateRangeStart') || document.getElementById('dateRangeStart').value;
            const endDate = urlParams.get('dateRangeEnd') || document.getElementById('dateRangeEnd').value;
            
            // Get selected activity types
            const activityTypesFromUrl = urlParams.getAll('activityType[]');
            const activityCheckboxes = document.querySelectorAll('input[name="activityType[]"]');
            
            // Set checkboxes based on URL parameters if they exist
            if (activityTypesFromUrl.length > 0) {
                activityCheckboxes.forEach(checkbox => {
                    checkbox.checked = activityTypesFromUrl.includes(checkbox.value);
                });
            }
            
            // Set date range values
            document.getElementById('dateRangeStart').value = startDate;
            document.getElementById('dateRangeEnd').value = endDate;
            
            // Generate the report with a delay to ensure DOM is ready
            setTimeout(() => {
                generateReport();
            }, 300);
        }
    } catch (error) {
        console.error('Error initializing activity report:', error);
    }
}

/**
 * Set up all event listeners for the page
 */
function setupEventListeners() {
    try {
        if (window.DEBUG) console.log('Setting up event listeners');
        
        // Generate report button
        const btnGenerateReport = document.getElementById('btnGenerateReport');
        if (btnGenerateReport) {
            btnGenerateReport.addEventListener('click', function() {
                generateReport();
                
                // Force chart render after a delay
                setTimeout(() => {
                    if (typeof forceChartRender === 'function') {
                        forceChartRender();
                    }
                }, 500);
            });
            
            if (window.DEBUG) console.log('Added click listener to generate report button');
        } else {
            console.error('Generate report button not found');
        }
        
        // Export buttons
        const btnExportPDF = document.getElementById('btnExportPDF');
        if (btnExportPDF) {
            btnExportPDF.addEventListener('click', exportToPDF);
            if (window.DEBUG) console.log('Added click listener to export PDF button');
        }
        
        const btnExportExcel = document.getElementById('btnExportExcel');
        if (btnExportExcel) {
            btnExportExcel.addEventListener('click', exportToExcel);
            if (window.DEBUG) console.log('Added click listener to export Excel button');
        }
        
        // Graph preview button
        const btnPreviewGraph = document.getElementById('btnPreviewGraph');
        if (btnPreviewGraph) {
            btnPreviewGraph.addEventListener('click', showGraphPreview);
            if (window.DEBUG) console.log('Added click listener to preview graph button');
        }
        
        // Download image button in modal
        const btnDownloadImage = document.getElementById('btnDownloadImage');
        if (btnDownloadImage) {
            btnDownloadImage.addEventListener('click', downloadGraphImage);
            if (window.DEBUG) console.log('Added click listener to download image button');
        }
    } catch (error) {
        console.error('Error setting up event listeners:', error);
    }
}

/**
 * Generate the report based on selected filters
 */
function generateReport() {
    try {
        if (window.DEBUG) console.log('Generating report...');
        
        // Show loading indicator if available
        if (typeof showLoading === 'function') {
            showLoading('กำลังสร้างรายงาน...');
        }
        
        // Get filter values
        const startDate = document.getElementById('dateRangeStart').value;
        const endDate = document.getElementById('dateRangeEnd').value;
        const selectedActivityTypes = getSelectedActivityTypes();
        
        if (window.DEBUG) {
            console.log('Filter values:');
            console.log('- Start date:', startDate);
            console.log('- End date:', endDate);
            console.log('- Selected activity types:', selectedActivityTypes);
        }
        
        // Validate date range
        if (new Date(startDate) > new Date(endDate)) {
            if (typeof hideLoading === 'function') {
                hideLoading();
            }
            alert('วันที่เริ่มต้นต้องมาก่อนวันที่สิ้นสุด');
            return;
        }
        
        // Filter activities
        try {
            window.filteredActivities = filterActivities(allActivities, startDate, endDate, selectedActivityTypes);
            
            if (window.DEBUG) console.log('Filtered activities:', window.filteredActivities.length);
            
            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if (!window.filteredActivities || window.filteredActivities.length === 0) {
                console.warn('No activities found for the selected filters');
                if (typeof hideLoading === 'function') {
                    hideLoading();
                }
                alert('ไม่พบข้อมูลกิจกรรมในช่วงเวลาที่เลือก');
                return;
            }
        } catch (error) {
            console.error('Error filtering activities:', error);
            if (typeof hideLoading === 'function') {
                hideLoading();
            }
            alert('เกิดข้อผิดพลาดในการกรองข้อมูล: ' + error.message);
            return;
        }
        
        // Pass filtered activities to the export utilities
        if (typeof initExportUtilities === 'function') {
            initExportUtilities(window.filteredActivities, window.activityTypeConfig);
        }
        
        // Show report content
        const reportContent = document.getElementById('reportContent');
        if (reportContent) {
            reportContent.style.display = 'block';
        }
        
        // Update the URL with filter parameters
        updateURLParameters(startDate, endDate, selectedActivityTypes);
        
        // Generate report components with sequential timing
        setTimeout(() => {
            // Generate stats summary
            if (window.DEBUG) console.log('Generating stats summary...');
            generateStatsSummary(window.filteredActivities, window.activityTypeConfig);
            
            setTimeout(() => {
                // Generate activity chart
                if (window.DEBUG) console.log('Generating activity chart...');
                
                // Ensure the chart container is visible
                const chartContainer = document.getElementById('chartPreviewContainer');
                if (chartContainer) {
                    chartContainer.style.display = 'block';
                }
                
                generateActivityChart(window.filteredActivities, window.activityTypeConfig);
                
                setTimeout(() => {
                    // Generate activity table
                    if (window.DEBUG) console.log('Generating activity table...');
                    generateActivityTable(window.filteredActivities, window.activityTypeConfig, 1);
                    
                    // Scroll to report content
                    if (reportContent) {
                        reportContent.scrollIntoView({ behavior: 'smooth' });
                    }
                    
                    // Force chart render
                    if (typeof forceChartRender === 'function') {
                        setTimeout(forceChartRender, 200);
                    }
                    
                    // Hide loading indicator
                    if (typeof hideLoading === 'function') {
                        hideLoading();
                    }
                }, 100);
            }, 100);
        }, 100);
    } catch (error) {
        console.error('Error generating report:', error);
        
        // Hide loading indicator
        if (typeof hideLoading === 'function') {
            hideLoading();
        }
        
        alert('เกิดข้อผิดพลาดในการสร้างรายงาน: ' + error.message);
    }
}

/**
 * Update URL parameters to reflect current filter settings
 * @param {string} startDate - Start date in YYYY-MM-DD format
 * @param {string} endDate - End date in YYYY-MM-DD format
 * @param {Array} activityTypes - Array of activity types to include
 */
function updateURLParameters(startDate, endDate, activityTypes) {
    try {
        const url = new URL(window.location.href);
        url.searchParams.set('dateRangeStart', startDate);
        url.searchParams.set('dateRangeEnd', endDate);
        
        // Remove all existing activity type parameters
        url.searchParams.delete('activityType[]');
        
        // Add selected activity types
        activityTypes.forEach(type => {
            url.searchParams.append('activityType[]', type);
        });
        
        // Update URL without reloading the page
        window.history.pushState({}, '', url);
        
        if (window.DEBUG) console.log('URL parameters updated');
    } catch (error) {
        console.error('Error updating URL parameters:', error);
    }
}
