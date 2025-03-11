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
function generateTableData(data) {
    return data.map(activity => [
        activity.timestamp || '-',
        activity.username || '-',
        activity.ipAddress || '-',
        activity.type || '-',
        activity.details || '-'
    ]);
}

function exportToPDF() {
    const startDate = document.getElementById('dateRangeStart').value;
    const endDate = document.getElementById('dateRangeEnd').value;
    const filename = `user-activity-report-${startDate}-to-${endDate}.pdf`;
    const chart = document.getElementById('activityChart');
    const summaryData = generateExcelSummaryData();

    showLoading('กำลังสร้างไฟล์ PDF...');
    
    // ใช้ตัวแปร thSarabunNewBase64 ที่ประกาศไว้ในไฟล์ font-data.js 
    // ตัวแปรนี้จะสามารถเข้าถึงได้เพราะเราได้โหลดไฟล์ font-data.js ก่อนหน้านี้ในไฟล์ HTML
    
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        unit: 'mm',
        format: 'a4',
        orientation: 'portrait'
    });
    
    try {
        doc.addFileToVFS('THSarabunNew.ttf', thSarabunNewBase64);
        doc.addFont('THSarabunNew.ttf', 'THSarabunNew', 'normal');
        doc.setFont('THSarabunNew');
    } catch (e) {
        console.error('Font loading error:', e);
        doc.setFont('helvetica'); // ใช้ฟอนต์สำรองถ้ามีปัญหา
    }

    console.log(summaryData);
    // console.log(summaryData.slice(2));

    const filteredSummaryData = summaryData.filter(row => Array.isArray(row) && row.length > 0);

    // Header
    doc.setFontSize(16);
    doc.text('รายงานกิจกรรมผู้ใช้', 10, 20);
    

    // Summary Table
    doc.autoTable({
        head: [summaryData[2]],
        body: filteredSummaryData.slice(2),
        startY: 30,
        margin: { left: 10, right: 10 },
        styles: { font: 'THSarabunNew', fontSize: 7 },
        headStyles: { fillColor: [240, 240, 240], textColor: [0, 0, 0] },
        theme: 'striped'
    });
    
    // Chart
    let chartAdded = false;
    
    if (chart && chart.tagName === 'CANVAS') {
        try {
            const chartImage = chart.toDataURL('image/png');
            const pdfWidth = doc.internal.pageSize.getWidth() - 20;
            const chartHeight = 70; // กำหนดความสูงคงที่
            
            doc.addImage(
                chartImage, 
                'PNG', 
                10, 
                doc.lastAutoTable.finalY + 10, 
                pdfWidth, 
                chartHeight
            );
            
            chartAdded = true;
        } catch (e) {
            console.error('Chart image error:', e);
        }
    }
    
    // Report Table
    const tableData = generateTableData(filteredActivities);
    doc.autoTable({
        head: [['วันที่และเวลา', 'ผู้ใช้', 'IP Address', 'ประเภทกิจกรรม', 'รายละเอียด']],
        body: tableData,
        startY: chartAdded ? doc.lastAutoTable.finalY + 80 : doc.lastAutoTable.finalY + 10,
        margin: { left: 10, right: 10 },
        styles: { font: 'THSarabunNew', fontSize: 7, cellPadding: 1 },
        headStyles: { fillColor: [240, 240, 240], textColor: [0, 0, 0], fontSize: 10 },
        columnStyles: {
            0: { cellWidth: 40 },
            1: { cellWidth: 30 },
            2: { cellWidth: 30 },
            3: { cellWidth: 30 },
            4: { cellWidth: 60 }
        },
        theme: 'striped',
        pageBreak: 'auto'
    });
    
    doc.save(filename);
    hideLoading();
}

/**
 * Export the report as Excel
 */
async function exportToExcel() {
    const startDate = document.getElementById('dateRangeStart').value;
    const endDate = document.getElementById('dateRangeEnd').value;
    const filename = `user-activity-report-${startDate}-to-${endDate}.xlsx`;

    showLoading('กำลังสร้างไฟล์ Excel...');

    try {
        // Get visitor count with fallback to 0 if failed
        const visitorCount = await getVisitorCount().catch(err => {
            console.error('Error getting visitor count:', err);
            return 0;
        });

        const workbook = new window.ExcelJS.Workbook();
        const summarySheet = workbook.addWorksheet('Summary');
        const detailsSheet = workbook.addWorksheet('Activity Details');

        // Generate and add data to sheets
        const summaryData = generateExcelSummaryData(visitorCount);
        summarySheet.addRows(summaryData);

        const detailsData = generateExcelDetailsData();
        detailsSheet.addRows(detailsData);

        // Add chart image if available
        const imageBase64 = await getCanvasImageBase64('activityChart');
        if (imageBase64) {
            const imageId = workbook.addImage({
                base64: imageBase64,
                extension: 'png',
            });
            summarySheet.addImage(imageId, {
                tl: { col: 1, row: summaryData.length + 2 },
                ext: { width: 1000, height: 400 },
            });
        }

        // Save the file
        const buffer = await workbook.xlsx.writeBuffer();
        window.saveAs(
            new Blob([buffer], { 
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' 
            }), 
            filename
        );

    } catch (error) {
        console.error('Excel export error:', error);
        alert('เกิดข้อผิดพลาดในการสร้างไฟล์ Excel');
    } finally {
        hideLoading();
    }
}

/**
 * แปลง <canvas> เป็น Base64
 */
async function getCanvasImageBase64(canvasId) {
    return new Promise((resolve) => {
        const canvas = document.getElementById(canvasId);
        if (canvas) {
            resolve(canvas.toDataURL('image/png'));
        } else {
            resolve('');
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
