/**
 * Export Utilities
 * Functions for exporting reports to PDF and Excel
 */

// Global variables for export context
let filteredActivities = [];
let activityTypeConfig = {};

/**
 * Initialize export utilities with required data
 * @param {Array} activities - Filtered activities data
 * @param {Object} typeConfig - Activity type configuration
 */
function initExportUtilities(activities, typeConfig) {
    filteredActivities = activities;
    activityTypeConfig = typeConfig;
}

/**
 * Export the report as PDF
 */
function exportToPDF() {
    // Get date range for filename
    const startDate = document.getElementById('dateRangeStart').value;
    const endDate = document.getElementById('dateRangeEnd').value;
    const filename = `user-activity-report-${startDate}-to-${endDate}.pdf`;
    
    // Show loading indicator
    showLoading('กำลังสร้างไฟล์ PDF...');
    
    // Use timeout to allow loading indicator to show
    setTimeout(() => {
        try {
            // Get the report content
            const content = document.getElementById('t');
            
            // Generate PDF options
            const options = {
                margin: 10,
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            
            // Generate PDF
            html2pdf().from(content).set(options).save()
                .then(() => {
                    hideLoading();
                })
                .catch(err => {
                    console.error('PDF generation error:', err);
                    hideLoading();
                    alert('เกิดข้อผิดพลาดในการสร้างไฟล์ PDF');
                });reportConten
        } catch (error) {
            console.error('PDF export error:', error);
            hideLoading();
            alert('เกิดข้อผิดพลาดในการสร้างไฟล์ PDF');
        }
    }, 100);
}

function exportToExcel() {
    // Get date range for filename
    const startDate = document.getElementById('dateRangeStart').value;
    const endDate = document.getElementById('dateRangeEnd').value;
    const filename = `user-activity-report-${startDate}-to-${endDate}.xlsx`;
    
    // Show loading indicator
    showLoading('กำลังสร้างไฟล์ Excel...');
    
    // Get visitor count first, then create Excel
    getVisitorCount()
        .then(visitorCount => {
            try {
                // Create a new workbook
                const wb = XLSX.utils.book_new();
                
                // Add summary sheet
                const summaryData = generateExcelSummaryData(visitorCount);
                const summaryWs = XLSX.utils.aoa_to_sheet(summaryData);
                XLSX.utils.book_append_sheet(wb, summaryWs, 'Summary');
                
                // Add details sheet
                const detailsData = generateExcelDetailsData();
                const detailsWs = XLSX.utils.aoa_to_sheet(detailsData);
                XLSX.utils.book_append_sheet(wb, detailsWs, 'Activity Details');
                
                // Save the workbook
                XLSX.writeFile(wb, filename);
                
                // Hide loading indicator
                hideLoading();
            } catch (error) {
                console.error('Excel export error:', error);
                hideLoading();
                alert('เกิดข้อผิดพลาดในการสร้างไฟล์ Excel');
            }
        })
        .catch(error => {
            console.error('Error getting visitor count for Excel:', error);
            // Fallback to export without visitor count
            try {
                // Create Excel without visitor count
                const wb = XLSX.utils.book_new();
                
                // Add summary sheet without visitors
                const summaryData = generateExcelSummaryData(0);
                const summaryWs = XLSX.utils.aoa_to_sheet(summaryData);
                XLSX.utils.book_append_sheet(wb, summaryWs, 'Summary');
                
                // Add details sheet
                const detailsData = generateExcelDetailsData();
                const detailsWs = XLSX.utils.aoa_to_sheet(detailsData);
                XLSX.utils.book_append_sheet(wb, detailsWs, 'Activity Details');
                
                // Save the workbook
                XLSX.writeFile(wb, filename);
                
                hideLoading();
            } catch (error) {
                console.error('Excel export error:', error);
                hideLoading();
                alert('เกิดข้อผิดพลาดในการสร้างไฟล์ Excel');
            }
        });
}

/**
 * Generate summary data for Excel export
 * @param {number} visitorCount - Number of visitors
 * @returns {Array} Array of arrays for Excel data
 */
function generateExcelSummaryData() {
    const data = [];
    
    // Add title
    data.push(['รายงานกิจกรรมผู้ใช้งานในระบบ']);
    data.push([]);
    
    // Add date range
    const startDate = document.getElementById('dateRangeStart').value;
    const endDate = document.getElementById('dateRangeEnd').value;
    data.push(['ช่วงวันที่:', `${startDate} ถึง ${endDate}`]);
    data.push([]);
    
    // Add activity counts
    data.push(['ประเภทกิจกรรม', 'จำนวน']);
    
    // Get visitor count
    const visitorCount = window.visitorCount || 0;
    
    // Add visitor row
    data.push(['ผู้เข้าชม', visitorCount]);
    
    // Count activities by type
    const typeCounts = {};
    Object.keys(activityTypeConfig).forEach(type => {
        typeCounts[type] = 0;
    });
    
    filteredActivities.forEach(activity => {
        if (typeCounts.hasOwnProperty(activity.type)) {
            typeCounts[activity.type]++;
        }
    });
    
    // Add rows for each activity type
    Object.keys(activityTypeConfig).forEach(type => {
        if (typeCounts[type] > 0) {
            data.push([activityTypeConfig[type].label, typeCounts[type]]);
        }
    });
    
    // Add total (with visitors)
    data.push(['รวมทั้งหมด', filteredActivities.length + visitorCount]);
    
    return data;
}
/**
 * Generate details data for Excel export
 * @returns {Array} Array of arrays for Excel data
 */
function generateExcelDetailsData() {
    const data = [];
    
    // Add headers
    data.push(['วันที่และเวลา', 'ชื่อผู้ใช้', 'IP Address', 'ประเภทกิจกรรม', 'รายละเอียด', 'อุปกรณ์', 'เบราว์เซอร์']);
    
    // Add activity rows
    filteredActivities.forEach(activity => {
        // Format date
        const date = new Date(activity.timestamp);
        const formattedDate = date.toLocaleString('th-TH');
        
        // Get activity type label
        const typeConfig = activityTypeConfig[activity.type];
        const typeLabel = typeConfig ? typeConfig.label : activity.type;
        
        // Add row
        data.push([
            formattedDate,
            activity.username,
            activity.ipAddress,
            typeLabel,
            activity.details,
            activity.device,
            activity.browser
        ]);
    });
    
    return data;
}

/**
 * Download the graph as an image
 */
function downloadGraphImage() {
    const graphImage = document.getElementById('graphImage');
    
    // Create a temporary link element
    const downloadLink = document.createElement('a');
    downloadLink.href = graphImage.src;
    
    // Set filename
    const dateStr = new Date().toISOString().split('T')[0];
    downloadLink.download = `activity-report-${dateStr}.png`;
    
    // Trigger download
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

/**
 * Show the graph preview in a modal
 */
function showGraphPreview() {
    // Get the canvas
    const canvas = document.getElementById('activityChart');
    
    // Convert chart to image
    const image = canvas.toDataURL('image/png');
    
    // Set the image source
    document.getElementById('graphImage').src = image;
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    modal.show();
}

/**
 * Show loading indicator
 * @param {string} message - Loading message to display
 */
function showLoading(message) {
    // Check if loading overlay already exists
    if (document.getElementById('loadingOverlay')) {
        return;
    }
    
    // Create loading overlay
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.className = 'loading-overlay';
    
    // Create loading spinner and message
    overlay.innerHTML = `
        <div class="loading-content">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="loading-message">${message}</div>
        </div>
    `;
    
    // Add to document
    document.body.appendChild(overlay);
}

/**
 * Hide loading indicator
 */
function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        document.body.removeChild(overlay);
    }
}
