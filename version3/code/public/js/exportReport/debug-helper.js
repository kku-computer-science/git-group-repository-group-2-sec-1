/**
 * Debug Helper for Chart
 * ไฟล์นี้ช่วยในการตรวจสอบและแก้ไขปัญหาการแสดงผลกราฟ
 */

// เพิ่มเมื่อหน้าเว็บโหลดเสร็จ
document.addEventListener('DOMContentLoaded', function() {
    console.log('Debug Helper: Page loaded');
    
    // ตรวจสอบว่า Chart.js ถูกโหลดหรือไม่
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded. Attempting to load it dynamically.');
        
        // พยายามโหลด Chart.js แบบอัตโนมัติ
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js';
        script.onload = function() {
            console.log('Chart.js loaded successfully');
        };
        script.onerror = function() {
            console.error('Failed to load Chart.js');
        };
        document.head.appendChild(script);
    } else {
        console.log('Chart.js is already loaded');
    }
    
    // เพิ่มปุ่มดีบักที่มุมขวาล่างของหน้าจอ
    const debugBtn = document.createElement('button');
    debugBtn.textContent = 'Debug Chart';
    debugBtn.style.position = 'fixed';
    debugBtn.style.bottom = '20px';
    debugBtn.style.right = '20px';
    debugBtn.style.zIndex = '9999';
    debugBtn.style.padding = '8px 16px';
    debugBtn.style.backgroundColor = '#007bff';
    debugBtn.style.color = 'white';
    debugBtn.style.border = 'none';
    debugBtn.style.borderRadius = '4px';
    debugBtn.style.cursor = 'pointer';
    
    debugBtn.addEventListener('click', function() {
        console.log('Debug button clicked, running diagnostics...');
        
        // ตรวจสอบ DOM elements
        console.log('Checking DOM elements:');
        const elements = [
            'reportContent',
            'chartPreviewContainer',
            'activityChart',
            'statsContainer',
            'activityTableBody',
            'btnGenerateReport'
        ];
        
        elements.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                console.log(`- ${id}: Found, display=${window.getComputedStyle(element).display}`);
            } else {
                console.error(`- ${id}: Not found`);
            }
        });
        
        // ตรวจสอบข้อมูลกิจกรรม
        console.log('Checking activity data:');
        if (typeof window.activities !== 'undefined') {
            console.log('- Global activities:', typeof window.activities, Array.isArray(window.activities) ? window.activities.length : 'not array');
        } else {
            console.error('- Global activities: undefined');
        }
        
        if (typeof allActivities !== 'undefined') {
            console.log('- Local allActivities:', typeof allActivities, Array.isArray(allActivities) ? allActivities.length : 'not array');
        } else {
            console.error('- Local allActivities: undefined');
        }
        
        if (typeof window.filteredActivities !== 'undefined') {
            console.log('- Filtered activities:', typeof window.filteredActivities, Array.isArray(window.filteredActivities) ? window.filteredActivities.length : 'not array');
        } else {
            console.error('- Filtered activities: undefined');
        }
        
        // ตรวจสอบข้อมูลประเภทกิจกรรม
        console.log('Checking activity type config:');
        if (typeof window.activityTypeConfig !== 'undefined') {
            console.log('- Activity type config:', window.activityTypeConfig);
        } else {
            console.error('- Activity type config: undefined');
        }
        
        // ตรวจสอบ Chart.js
        console.log('Checking Chart.js:');
        if (typeof Chart !== 'undefined') {
            console.log('- Chart.js is loaded');
            if (Chart.instances) {
                console.log('- Chart instances:', Object.keys(Chart.instances).length);
                Object.values(Chart.instances).forEach((chart, i) => {
                    console.log(`  * Chart ${i}:`, chart.canvas.id);
                });
            } else {
                console.log('- No chart instances found');
            }
        } else {
            console.error('- Chart.js is not loaded');
        }
        
        // ลองแก้ไขปัญหากราฟไม่แสดง
        console.log('Attempting to fix chart rendering issues...');
        
        // 1. ทำให้ container แสดงผล
        const chartContainer = document.getElementById('chartPreviewContainer');
        if (chartContainer) {
            chartContainer.style.display = 'block';
            console.log('- Made chart container visible');
        }
        
        // 2. ให้ canvas มีขนาดที่ชัดเจน
        const canvas = document.getElementById('activityChart');
        if (canvas) {
            canvas.style.display = 'block';
            canvas.style.height = '350px';
            canvas.style.width = '100%';
            console.log('- Set canvas dimensions');
        }
        
        // 3. ทำการสร้างกราฟใหม่ถ้ามีข้อมูล
        if (typeof generateActivityChart === 'function' && 
            Array.isArray(window.filteredActivities) && 
            window.filteredActivities.length > 0 &&
            typeof window.activityTypeConfig === 'object') {
            
            console.log('- Regenerating chart...');
            generateActivityChart(window.filteredActivities, window.activityTypeConfig);
            
            // 4. บังคับให้ Chart.js อัพเดท
            setTimeout(() => {
                if (typeof Chart !== 'undefined' && Chart.instances) {
                    Object.values(Chart.instances).forEach(chart => {
                        try {
                            chart.update();
                            console.log('- Chart updated successfully');
                        } catch (error) {
                            console.error('- Error updating chart:', error);
                        }
                    });
                }
            }, 100);
        }
        
        console.log('Debug diagnostics complete');
    });
    
    document.body.appendChild(debugBtn);
    
    // เพิ่ม CSS เพื่อแก้ไขปัญหาการแสดงผล
    const fixStyle = document.createElement('style');
    fixStyle.textContent = `
        #chartPreviewContainer {
            min-height: 350px;
            background-color: white;
            padding: 10px;
            border-radius: 4px;
            position: relative;
            display: block !important;
        }
        
        #activityChart {
            display: block !important;
            height: 350px !important;
            width: 100% !important;
            position: relative;
            z-index: 5;
        }
    `;
    document.head.appendChild(fixStyle);
    
    // ตรวจสอบการแสดงผลอัตโนมัติหลังจากหน้าโหลดเสร็จ
    setTimeout(function() {
        const reportContent = document.getElementById('reportContent');
        const chartContainer = document.getElementById('chartPreviewContainer');
        const canvas = document.getElementById('activityChart');
        
        if (reportContent && reportContent.style.display !== 'none' && canvas) {
            console.log('Auto-fixing chart after page load...');
            
            // ทำให้ chart container แสดงผล
            if (chartContainer) {
                chartContainer.style.display = 'block';
            }
            
            // ทำให้ canvas มีขนาดที่ชัดเจน
            canvas.style.display = 'block';
            canvas.style.height = '350px';
            canvas.style.width = '100%';
            
            // บังคับให้ Chart.js อัพเดท
            if (typeof Chart !== 'undefined' && Chart.instances) {
                Object.values(Chart.instances).forEach(chart => {
                    try {
                        chart.update();
                    } catch (error) {
                        console.error('Error auto-updating chart:', error);
                    }
                });
            }
        }
    }, 1500);
});
