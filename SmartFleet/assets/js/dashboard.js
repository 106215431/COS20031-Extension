
new Chart(document.getElementById("vehicleChart"), {

    type: "bar",

    data: {

        labels: dashboardData.vehicleLabels,

        datasets: [{
            label: "Vehicles",
            data: dashboardData.vehicleCounts

        }]

    },
    options: {
    plugins: {
        legend: {
            display: false
        }
    },
    scales: {
    y: {
        beginAtZero: true,
        ticks: {
            stepSize: 1,
            precision: 0
        }
    }
}
}

});

new Chart(document.getElementById("statusChart"), {

    type: 'pie',

    data: {

        labels: dashboardData.statusLabels,

        datasets: [{

            data: dashboardData.statusCounts

        }]

    },

    options: {

        responsive: true,
         maintainAspectRatio:false,

        plugins: {

            legend: {

                position: 'bottom'

            }

        }

    }

});

new Chart(document.getElementById("severityChart"),{

    type:'bar',

    data:{

        labels:dashboardData.severityLabels,

        datasets:[{

            label:"Events",

            data:dashboardData.severityCounts

        }]

    },

    options:{

        indexAxis:'y',

        responsive:true,
         maintainAspectRatio:false,

        plugins:{
            legend:{
                display:false
            }
        },

        scales:{
            x:{
                beginAtZero:true,
                ticks:{
                    precision:0
                }
            }
        }

    }

});

new Chart(document.getElementById("driverStatusChart"),{

    type:'doughnut',

    data:{

        labels:dashboardData.driverLabels,

        datasets:[{

            data:dashboardData.driverCounts

        }]

    },

    options:{

        responsive:true,
         maintainAspectRatio:false,

        plugins:{
            legend:{
                position:'bottom'
            }
        }

    }

});

new Chart(document.getElementById("loginTrendChart"),{

    type:"line",

    data:{

        labels:dashboardData.trendDates,

        datasets:[

        {

            label:"Successful Logins",

            data:dashboardData.trendSuccess,

            tension:.35

        },

        {

            label:"Failed Logins",

            data:dashboardData.trendFailed,

            tension:.35

        }

        ]

    },

    options:{

        responsive:true,

        maintainAspectRatio:false,

        scales:{

            y:{

                beginAtZero:true,

                ticks:{

                    precision:0

                }

            }

        }

    }

});



