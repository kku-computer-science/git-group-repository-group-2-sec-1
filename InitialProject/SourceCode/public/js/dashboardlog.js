document.addEventListener("DOMContentLoaded", function () {
    const errorCountElement = document.getElementById("error-count");
    const ctx = document.getElementById("errorChart").getContext("2d");

    const datePicker = document.getElementById("datePicker");
    const selectedDate =
        "{{ session('selectedDate', now()->format('Y-m-d')) }}";
    datePicker.value = selectedDate;

    // โหลดค่าจาก localStorage ถ้ามี
    const savedDate = localStorage.getItem("selectedDate");
    if (savedDate) {
        datePicker.value = savedDate;
    } else {
        datePicker.value = new Date().toISOString().split("T")[0]; // ใช้วันที่ปัจจุบันถ้าไม่มีใน localStorage
    }

    const errorCount = {};

    Object.keys(totalError).forEach((key) => {
        errorType = JSON.parse(totalError[key]["details"]).status;
        // console.log(errorType);

        if (!errorCount[errorType]) {
            errorCount[errorType] = 0;
        }

        errorCount[errorType]++;
    });

    // function updateChart(errorCount) {

    //     const labels = Object.keys(errorCount);
    //     const values = Object.values(errorCount);
    //     // const totalErrors = values.reduce((sum, val) => sum + val, 0);

    //     if (errorCountElement) {
    //         errorCountElement.textContent =
    //             Object.keys(totalError).length + " errors";
    //     }

    //     errorChart.data.labels = labels;
    //     errorChart.data.datasets[0].data = values;

    //     const maxCount = Math.max(...values);
    //     errorChart.options.scales.y.suggestedMax = maxCount + 10;

    //     errorChart.options.scales.y.ticks = {
    //         beginAtZero: true,
    //         min: 0,
    //         max: maxCount + 10,
    //     };

    //     errorChart.update();
    // }

    
    

    // const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    // gradient.addColorStop(0, "rgba(13, 110, 253, 0.8)");
    // gradient.addColorStop(1, "rgba(13, 110, 253, 0.2)");

    // let errorChart = new Chart(ctx, {
    //     type: "bar",
    //     data: {
    //         labels: [],
    //         datasets: [
    //             {
    //                 label: "จำนวน Error แต่ละประเภท",
    //                 data: [],
    //                 backgroundColor: gradient,
    //                 borderColor: "#0d6efd",
    //                 borderWidth: 1,
    //                 borderRadius: 8,
    //                 maxBarThickness: 50,
    //             },
    //         ],
    //     },
    //     options: {
    //         responsive: true,
    //         maintainAspectRatio: false,
    //         plugins: {
    //             legend: { display: false },
    //             tooltip: {
    //                 backgroundColor: "rgba(0, 0, 0, 0.8)",
    //                 padding: 12,
    //                 titleFont: { size: 14, weight: "bold" },
    //                 bodyFont: { size: 13 },
    //             },
    //         },
    //         scales: {
    //             y: {
    //                 beginAtZero: true,
    //                 suggestedMin: 0, // ตั้งค่าขั้นต่ำที่แนะนำเป็น 0
    //                 suggestedMax: 10, // ตั้งค่าขั้นสูงที่แนะนำเริ่มต้นเป็น 10
    //                 grid: { drawBorder: false, color: "rgba(0, 0, 0, 0.1)" },
    //                 ticks: {
    //                     beginAtZero: true,
    //                     min: 0,
    //                     max: 10,
    //                     font: { size: 12 },
    //                 },
    //             },
    //             x: {
    //                 grid: { display: false },
    //                 ticks: { font: { size: 11 } },
    //             },
    //         },
    //     },
    // });

    function updateChart(errorCount) {
        const labels = Object.keys(errorCount);
        const values = Object.values(errorCount);
    
        if (errorCountElement) {
            errorCountElement.textContent =
                Object.keys(totalError).length + " errors";
        }
    
        errorChart.data.labels = labels;
        errorChart.data.datasets[0].data = values;
    
        const maxCount = Math.max(...values, 0); // ป้องกันกรณีไม่มี error
    
        errorChart.options.scales.y = {
            beginAtZero: true,
            suggestedMin: 0,
            suggestedMax: maxCount + 10,
            ticks: {
                stepSize: 1, // เพิ่มให้มี step ทีละ 1
                min: 0,
                max: maxCount + 10,
                callback: function (value) {
                    return Number.isInteger(value) ? value : null;
                },
            },
        };
    
        errorChart.update();
    }
    
    
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, "rgba(13, 110, 253, 0.8)");
    gradient.addColorStop(1, "rgba(13, 110, 253, 0.2)");

    let errorChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: [],
            datasets: [
                {
                    label: "จำนวน Error แต่ละประเภท",
                    data: [],
                    backgroundColor: gradient,
                    borderColor: "#0d6efd",
                    borderWidth: 1,
                    borderRadius: 8,
                    maxBarThickness: 50,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "rgba(0, 0, 0, 0.8)",
                    padding: 12,
                    titleFont: { size: 14, weight: "bold" },
                    bodyFont: { size: 13 },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMin: 0, // ตั้งค่าขั้นต่ำที่แนะนำเป็น 0
                    suggestedMax: 10, // ตั้งค่าขั้นสูงที่แนะนำเริ่มต้นเป็น 10
                    grid: { drawBorder: false, color: "rgba(0, 0, 0, 0.1)" },
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: 10,
                        font: { size: 12 },
                    },
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } },
                },
            },
        },
    });

    
    datePicker.addEventListener("change", filterDataByDate);

    function filterDataByDate() {
        const selectedDate = datePicker.value;
        if (!selectedDate) {
            alert("กรุณาเลือกวันที่");
            return;
        }

        // บันทึกค่า datePicker ลงใน localStorage
        localStorage.setItem("selectedDate", selectedDate);

        updateChart(errorCount);
    }



    window.redirectToLogs = function (event, baseUrl, activityType) {
        event.preventDefault();

        const selectedDate = document.getElementById("datePicker").value;

        if (!baseUrl) {
            console.error("Base URL is missing.");
            return;
        }

        const url = new URL(baseUrl);
        url.searchParams.set("start_date", selectedDate);
        url.searchParams.set("end_date", selectedDate);
        url.searchParams.set("search", "");
        url.searchParams.append("activity_type[]", activityType);

        window.location.href = url.toString();
    };
    filterDataByDate();

    datePicker.addEventListener("change", filterDataByDate);
});
