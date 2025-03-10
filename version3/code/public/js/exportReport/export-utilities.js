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
function generateTableHTML(data) {
    let table = `
        <style>
            @media print {
                @page { size: A4; margin: 10mm; }
                body { margin: 0; padding: 0; }
            }
            .report-table {
                width: 716px;
                border-collapse: collapse;
                font-family: Arial, sans-serif;
            }
            .report-table th, .report-table td {
                border: 1px solid #000;
                padding: 4px;
                vertical-align: top;
            }
            .report-table th {
                background: #f0f0f0;
                font-weight: bold;
            }
            .details-column {
                max-width: 200px;
                word-break: break-all;
                overflow-wrap: break-word;
                word-wrap: break-word;
                hyphens: auto;
            }
        </style>
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 20%; font-size: 10pt;">วันที่และเวลา</th>
                    <th style="width: 15%; font-size: 10pt;">ผู้ใช้</th>
                    <th style="width: 15%; font-size: 10pt;">IP Address</th>
                    <th style="width: 15%; font-size: 10pt;">ประเภทกิจกรรม</th>
                    <th style="width: 35%; font-size: 10pt;">รายละเอียด</th>
                </tr>
            </thead>
            <tbody>`;

    data.forEach((activity, index) => {
        console.log(`Row ${index}:`, activity); // ตรวจสอบข้อมูล
        table += `
            <tr>
                <td style="font-size: 7pt;">${activity.timestamp || '-'}</td>
                <td style="font-size: 7pt;">${activity.username || '-'}</td>
                <td style="font-size: 7pt;">${activity.ipAddress || '-'}</td>
                <td style="font-size: 7pt;">${activity.type || '-'}</td>
                <td class="details-column" style="font-size: 7pt;">${activity.details || '-'}</td>
            </tr>`;
    });

    table += `</tbody></table>`;
    return table;
}

function exportToPDF() {
    const startDate = document.getElementById('dateRangeStart').value;
    const endDate = document.getElementById('dateRangeEnd').value;
    const filename = `user-activity-report-${startDate}-to-${endDate}.pdf`;
    const chart = document.getElementById('activityChart');
    const summaryData = generateExcelSummaryData();
    
    showLoading('กำลังสร้างไฟล์ PDF...');

    const tempContainer = document.createElement('div');

    const chartImagePromise = new Promise((resolve) => {
        if (chart.tagName === 'CANVAS') {
            const chartImage = chart.toDataURL('image/png');
            resolve(`<div class="chart-container"><img src="${chartImage}" style="max-width: 716px; height: 250px;" /></div>`);
        } else {
            // หากไม่ใช่ canvas ให้ใช้ HTML เดิม
            resolve(`<div class="chart-container">${chart.outerHTML}</div>`);
        }
    });

    chartImagePromise.then((chartHTML) => {
        console.log('Filtered Activities:', filteredActivities);
        const tableHTML = generateTableHTML(filteredActivities);
        
        let summaryTableHTML = '<table class="summary-table"><tbody>';
        summaryData.forEach(row => {
            summaryTableHTML += '<tr>';
            row.forEach(cell => {
                summaryTableHTML += `<td>${cell}</td>`;
            });
            summaryTableHTML += '</tr>';
        });
        summaryTableHTML += '</tbody></table>';

        // รวม chart และ table เข้าด้วยกัน
        tempContainer.innerHTML = `${summaryTableHTML}<br/><br/>${chartHTML}<br/><br/>${tableHTML}`;
        tempContainer.style = "font-family: 'TH Sarabun New', sans-serif;";

        const options = {
            margin: [10, 10, 10, 10],
            filename: filename,
            image: { type: 'jpeg', quality: 0.95 },
            html2canvas: { 
                scale: 3,
                useCORS: true,
                width: 716,
                scrollY: 0,
                windowHeight: 2000 // ปรับตามความสูงที่ต้องการ
            },
            jsPDF: { 
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait',
                putOnlyUsedFonts: true,
                compress: true
            },
            pagebreak: { 
                mode: ['avoid-all', 'css', 'legacy'],
                avoid: 'tr',
                before: '.report-table tr:nth-child(30)'
            }
        };

        html2pdf().from(tempContainer).set(options).save()
            .then(() => {
                document.body.removeChild(tempContainer);
                hideLoading();
            })
            .catch(err => {
                console.error('PDF generation error:', err);
                document.body.removeChild(tempContainer);
                hideLoading();
                alert('เกิดข้อผิดพลาดในการสร้างไฟล์ PDF');
            });
    });
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
