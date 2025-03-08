/**
 * Main Activity Report Initialization Script
 * This script loads all necessary modules and initializes the report system.
 */

// Debug flag - ใช้สำหรับแสดง log
window.DEBUG = true;
// Load necessary modules
document.addEventListener("DOMContentLoaded", function () {
    if (DEBUG) console.log("DOM loaded, checking for activity data...");

    // ตรวจสอบว่า Chart.js ถูกโหลดหรือไม่
    if (typeof Chart === "undefined") {
        console.error(
            "Chart.js is not loaded. Make sure Chart.js is included before this script."
        );
    }

    // แปลง JSON string เป็น Object (ถ้าจำเป็น)
    try {
        if (typeof window.activities === "string") {
            window.activities = JSON.parse(window.activities);
            if (DEBUG) console.log("Parsed activities from JSON string");
        }

        if (typeof window.activityTypeConfig === "string") {
            window.activityTypeConfig = JSON.parse(window.activityTypeConfig);
            if (DEBUG)
                console.log("Parsed activityTypeConfig from JSON string");
        }
    } catch (error) {
        console.error("Error parsing JSON data:", error);
    }

    // ตรวจสอบว่าตัวแปร global มีอยู่หรือไม่
    if (
        typeof window.activities !== "undefined" &&
        typeof window.activityTypeConfig !== "undefined"
    ) {
        if (DEBUG) {
            console.log(
                "Activity data found:",
                window.activities.length,
                "records"
            );
            console.log(
                "Activity types found:",
                Object.keys(window.activityTypeConfig).length,
                "types"
            );
        }

        // รอให้ DOM พร้อมก่อนเริ่มต้นการทำงาน
        setTimeout(() => {
            initializeActivityReport(
                window.activities,
                window.activityTypeConfig
            );

            // ตรวจสอบ URL parameters เพื่อโหลดรายงานอัตโนมัติ
            const urlParams = new URLSearchParams(window.location.search);
            if (
                urlParams.has("dateRangeStart") ||
                urlParams.has("activityType[]")
            ) {
                if (DEBUG)
                    console.log("URL parameters found, auto-loading report...");

                // แสดง report content
                const reportContent = document.getElementById("reportContent");
                if (reportContent) {
                    reportContent.style.display = "block";
                }

                // บังคับให้ generateReport ทำงาน
                setTimeout(() => {
                    const btnGenerateReport =
                        document.getElementById("btnGenerateReport");
                    if (btnGenerateReport) {
                        btnGenerateReport.click();
                    }
                }, 300);
            }
        }, 100);
    } else {
        console.error("Could not initialize report: required data is missing");
    }
});

// ฟังก์ชันเพิ่มเติมเพื่อแก้ไขปัญหากราฟไม่แสดง
function forceChartRender() {
    if (DEBUG) console.log("Force rendering chart...");

    const chartCanvas = document.getElementById("activityChart");
    if (!chartCanvas) {
        console.error("Chart canvas not found");
        return;
    }

    // ทำให้ chart container แสดงผล
    const chartContainer = document.getElementById("chartPreviewContainer");
    if (chartContainer) {
        chartContainer.style.display = "block";
    }

    // แก้ไขปัญหา Chart.js ไม่ render
    if (typeof Chart !== "undefined") {
        if (DEBUG) console.log("Found Chart.js, checking for instances...");

        if (Chart.instances) {
            Object.values(Chart.instances).forEach((chart) => {
                try {
                    if (chart.canvas.id === "activityChart") {
                        chart.resize();
                        chart.update();
                        if (DEBUG)
                            console.log(
                                "Chart resized and updated successfully"
                            );
                    }
                } catch (error) {
                    console.error("Error resizing chart:", error);
                }
            });
        }
    }

    // Hack: ซ่อนและแสดง canvas เพื่อบังคับให้มีการ redraw
    const originalDisplay = chartCanvas.style.display;
    chartCanvas.style.display = "none";
    setTimeout(() => {
        chartCanvas.style.display = originalDisplay || "block";
        if (DEBUG) console.log("Chart visibility toggled to force redraw");
    }, 10);
}

// เพิ่ม CSS แบบ inline เพื่อแก้ไขการแสดงผลของกราฟ
(function addCustomStyles() {
    const style = document.createElement("style");
    style.textContent = `
        #chartPreviewContainer {
            min-height: 350px;
            background-color: white;
            display: block !important;
            position: relative;
        }
        
        #activityChart {
            display: block !important;
            height: 350px !important;
            width: 100% !important;
        }
    `;
    document.head.appendChild(style);
})();

// ตั้งเวลาเพื่อตรวจสอบและแก้ไขปัญหาการแสดงผลของกราฟ
setTimeout(function () {
    const reportContent = document.getElementById("reportContent");
    if (reportContent && reportContent.style.display !== "none") {
        forceChartRender();
    }
}, 1000);
