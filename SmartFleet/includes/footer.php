<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
const popoverTriggerList = document.querySelectorAll(
    '[data-bs-toggle="popover"]'
);

const popoverList = [...popoverTriggerList].map(
    el => new bootstrap.Popover(el)
);
</script>

<script>
    const dashboardData = {

    vehicleLabels: <?= json_encode($depotNames) ?>,
    vehicleCounts: <?= json_encode($vehicleTotals) ?>,

    statusLabels: <?= json_encode($statusLabels) ?>,
    statusCounts: <?= json_encode($statusTotals) ?>,

    severityLabels: <?= json_encode($severityLabels) ?>,
    severityCounts: <?= json_encode($severityTotals) ?>,

    driverLabels: <?= json_encode($driverStatus) ?>,
    driverCounts: <?= json_encode($driverTotals) ?>,

    trendDates: <?= json_encode($dates) ?>,
    trendSuccess: <?= json_encode($success) ?>,
    trendFailed: <?= json_encode($failed) ?>

};
</script>

<script src="/SmartFleet/assets/js/dashboard.js"></script>
</body>

</html>