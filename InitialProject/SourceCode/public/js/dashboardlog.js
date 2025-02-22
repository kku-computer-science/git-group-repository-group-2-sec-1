document.addEventListener("DOMContentLoaded", function () {
    const errorCountElement = document.getElementById("error-count");
    const errorDataJsonElement = document.getElementById("errorDataJson");
    const ctx = document.getElementById("errorChart").getContext("2d");
    const datePicker = document.getElementById("datePicker");

    // console.log(totalError);

    const errorCount = {}

    Object.keys(totalError).forEach(key => {
        errorType = JSON.parse(totalError[key]['details']).status;
        // console.log(errorType);

        if(!errorCount[errorType]) {
            errorCount[errorType] = 0;
        }

        errorCount[errorType]++;
    });

    function updateChart(errorCount) {
        // const groupedData = {};
        // filteredData.forEach(item => {
        //     if (!groupedData[item.type]) {
        //         groupedData[item.type] = 0;
        //     }
        //     groupedData[item.type] += item.count;
        // });

        const labels = Object.keys(errorCount);
        const values = Object.values(errorCount);
        // const totalErrors = values.reduce((sum, val) => sum + val, 0);

        if (errorCountElement) {
            errorCountElement.textContent = Object.keys(totalError).length + " errors";
        }

        errorChart.data.labels = labels;
        errorChart.data.datasets[0].data = values;

        const maxCount = Math.max(...values);
        errorChart.options.scales.y.suggestedMax = maxCount + 10;

        errorChart.options.scales.y.ticks = {
            beginAtZero: true,
            min: 0,
            max: maxCount + 10,
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
                    suggestedMin: 0,
                    suggestedMax: 10,
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

    function filterDataByDate() {
        // const selectedDate = datePicker.value;

        // if (!selectedDate) {
        //     alert("กรุณาเลือกวันที่");
        //     return;
        // }

        // const filteredData = errorLogs.filter((log) => log.date === selectedDate);
        updateChart(errorCount);
    }

    filterDataByDate();

    datePicker.addEventListener("change", filterDataByDate);
});
