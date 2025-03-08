/**
 * Main Activity Report Initialization Script
 * This script loads all necessary modules and initializes the report system.
 */

// Load necessary modules
document.addEventListener('DOMContentLoaded', function() {
    // ตรวจสอบว่าตัวแปร global มีอยู่หรือไม่
    if (typeof window.activities !== 'undefined' && typeof window.activityTypeConfig !== 'undefined') {
        initializeActivityReport(window.activities, window.activityTypeConfig);
    } else {
        console.error('Could not initialize report: required data is missing');
    }
});
