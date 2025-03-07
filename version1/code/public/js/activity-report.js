// Global function for initializing activity report
function initializeActivityReport(activities, config) {
    console.log('Initializing Activity Report');
    console.log('Activities:', activities);
    console.log('Config:', config);

    const allActivities = activities;
    let filteredActivities = [];
    const activityTypeConfig = config;

    const btnGenerateReport = document.getElementById('btnGenerateReport');
    const btnExportPDF = document.getElementById('btnExportPDF');
    const btnExportExcel = document.getElementById('btnExportExcel');
    const btnPreviewGraph = document.getElementById('btnPreviewGraph');
    const btnDownloadImage = document.getElementById('btnDownloadImage');

    function generateReport() {
        const startDate = document.getElementById('dateRangeStart').value;
        const endDate = document.getElementById('dateRangeEnd').value;
        
        const selectedActivityTypes = Array.from(
            document.querySelectorAll('input[name="activityType[]"]:checked')
        ).map(checkbox => checkbox.value);

        console.log('Selected Date Range:', startDate, '-', endDate);
        console.log('Selected Activity Types:', selectedActivityTypes);

        if (selectedActivityTypes.length === 0) {
            alert('กรุณาเลือกประเภทกิจกรรมอย่างน้อย 1 รายการ');
            return;
        }

        // Assuming these functions are defined in their respective module files
        filteredActivities = filterActivities(allActivities, startDate, endDate, selectedActivityTypes);

        console.log('Filtered Activities:', filteredActivities);

        if (filteredActivities.length === 0) {
            alert('ไม่พบข้อมูลกิจกรรมในช่วงเวลาที่กำหนด');
            return;
        }

        const reportContent = document.getElementById('reportContent');
        if (reportContent) {
            reportContent.style.display = 'block';
        }

        try {
            createStatsSummary(filteredActivities, activityTypeConfig);
            createActivityChart(filteredActivities, activityTypeConfig);
            createActivityTable(filteredActivities, activityTypeConfig);
            createPagination(filteredActivities.length, createActivityTable, filteredActivities);
        } catch (error) {
            console.error('Error generating report:', error);
            alert('เกิดข้อผิดพลาดในการสร้างรายงาน: ' + error.message);
        }
    }

    // Attach event listeners
    if (btnGenerateReport) {
        btnGenerateReport.addEventListener('click', generateReport);
    }

    if (btnExportPDF) {
        btnExportPDF.addEventListener('click', () => {
            if (typeof exportAsPDF === 'function') {
                exportAsPDF(filteredActivities, activityTypeConfig);
            } else {
                console.error('exportAsPDF function not found');
            }
        });
    }

    if (btnExportExcel) {
        btnExportExcel.addEventListener('click', () => {
            if (typeof exportAsExcel === 'function') {
                exportAsExcel(filteredActivities, activityTypeConfig);
            } else {
                console.error('exportAsExcel function not found');
            }
        });
    }

    // Expose function globally for pagination
    window.changePage = (page) => {
        if (typeof changePage === 'function') {
            changePage(page, createActivityTable, filteredActivities);
        } else {
            console.error('changePage function not found');
        }
    };
}
