/**
 * User Activity Report Main Script
 * This is the main script that initializes and coordinates the activity report functionality.
 * It imports functionality from the supporting utility files.
 */

// Global variables
let allActivities = [];
window.filteredActivities = window.filteredActivities || [];
window.activityTypeConfig = {}; // Make it accessible to other modules

/**
 * Initialize the activity report functionality
 * @param {Array} activities - The activity data from the server
 * @param {Object} typeConfig - Configuration for activity types
 */
function initializeActivityReport(activities, typeConfig) {
    // Store the data globally
    allActivities = activities;
    window.activityTypeConfig = typeConfig;

    // Set up event listeners
    setupEventListeners();

    // Check if URL has parameters to auto-load the report
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('dateRangeStart') || urlParams.has('activityType[]')) {
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
        
        // Generate the report
        generateReport();
    }
}

/**
 * Set up all event listeners for the page
 */
function setupEventListeners() {
    // Generate report button
    document.getElementById('btnGenerateReport').addEventListener('click', generateReport);
    
    // Export buttons
    document.getElementById('btnExportPDF').addEventListener('click', exportToPDF);
    document.getElementById('btnExportExcel').addEventListener('click', exportToExcel);
    
    // Graph preview button
    document.getElementById('btnPreviewGraph').addEventListener('click', showGraphPreview);
    
    // Download image button in modal
    document.getElementById('btnDownloadImage').addEventListener('click', downloadGraphImage);
}

/**
 * Generate the report based on selected filters
 */
function generateReport() {
    // Get filter values
    const startDate = document.getElementById('dateRangeStart').value;
    const endDate = document.getElementById('dateRangeEnd').value;
    const selectedActivityTypes = getSelectedActivityTypes();
    
    // Validate date range
    if (new Date(startDate) > new Date(endDate)) {
        alert('วันที่เริ่มต้นต้องมาก่อนวันที่สิ้นสุด');
        return;
    }
    
    // Filter activities
    filteredActivities = filterActivities(allActivities, startDate, endDate, selectedActivityTypes);
    
    // Pass filtered activities to the export utilities
    initExportUtilities(filteredActivities, window.activityTypeConfig);
    
    // Show report content
    document.getElementById('reportContent').style.display = 'block';
    
    // Update the URL with filter parameters
    updateURLParameters(startDate, endDate, selectedActivityTypes);
    
    // Generate report components
    generateStatsSummary(filteredActivities, window.activityTypeConfig);
    generateActivityChart(filteredActivities, window.activityTypeConfig);
    generateActivityTable(filteredActivities, window.activityTypeConfig, 1);
    
    // Scroll to report content
    document.getElementById('reportContent').scrollIntoView({ behavior: 'smooth' });
}

/**
 * Update URL parameters to reflect current filter settings
 * @param {string} startDate - Start date in YYYY-MM-DD format
 * @param {string} endDate - End date in YYYY-MM-DD format
 * @param {Array} activityTypes - Array of activity types to include
 */
function updateURLParameters(startDate, endDate, activityTypes) {
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
}
