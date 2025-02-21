document.addEventListener("DOMContentLoaded", function () {
    // Mock data
    const errorStats = {
        labels: [
            'Error 400 (Bad Request)',
            'Error 401 (Unauthorized)',
            'Error 403 (Forbidden)',
            'Error 404 (Not Found)',
            'Error 418 (I\'m a teapot)',
            'Error 500 (Server Error)',
            'Error 503 (Service Unavailable)'
        ],
        values: [15, 8, 12, 25, 1, 10, 5],
        totalErrors: 61
    };

    // อัปเดตจำนวน error ในหน้า HTML
    const errorCountElement = document.getElementById('error-count');
    if (errorCountElement) {
        errorCountElement.textContent = errorStats.totalErrors + ' errors';
    } else {
        console.error('Element with id "error-count" not found');
    }

    // แสดงข้อมูล errorStats ในรูปแบบ JSON
    const errorDataJsonElement = document.getElementById('errorDataJson');
    if (errorDataJsonElement) {
        errorDataJsonElement.textContent = JSON.stringify(errorStats);
    } else {
        console.error('Element with id "errorDataJson" not found');
    }

    console.log(errorStats); // ตรวจสอบข้อมูลใน Console

    const ctx = document.getElementById("errorChart").getContext("2d");
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(13, 110, 253, 0.8)');
    gradient.addColorStop(1, 'rgba(13, 110, 253, 0.2)');

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: errorStats.labels, // ใช้ labels จาก mock data
            datasets: [{
                label: "จำนวน Error แต่ละประเภท",
                data: errorStats.values, // ใช้ values จาก mock data
                backgroundColor: gradient,
                borderColor: '#0d6efd',
                borderWidth: 1,
                borderRadius: 8,
                maxBarThickness: 50
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
});
