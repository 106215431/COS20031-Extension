<?php
include "includes/navbar.php";
include "includes/auth.php";
include "includes/db.php";
include "includes/header.php";
$result = $conn->query("SELECT COUNT(*) AS total FROM Vehicle");
$vehicleCount = $result->fetch_assoc()['total'];
$result = $conn->query("SELECT COUNT(*) AS total FROM Driver");
$driverCount = $result->fetch_assoc()['total'];
$result = $conn->query("SELECT COUNT(*) AS total FROM Mechanic");
$mechanicCount = $result->fetch_assoc()['total'];
$result = $conn->query("SELECT COUNT(*) AS total FROM SafetyEvent");
$safetyCount = $result->fetch_assoc()['total'];
$sql = "
SELECT
    Depot.DepotName,
    COUNT(Vehicle.VIN) AS TotalVehicles
FROM Depot
LEFT JOIN Vehicle
ON Depot.DepotID = Vehicle.DepotID
GROUP BY Depot.DepotID, Depot.DepotName
ORDER BY Depot.DepotName;
";
$result = $conn->query($sql);
$depotNames = [];
$vehicleTotals = [];
while($row = $result->fetch_assoc())
{
    $depotNames[] = $row['DepotName'];
    $vehicleTotals[] = $row['TotalVehicles'];
}
$sql = "
SELECT
    Status,
    COUNT(*) AS Total
FROM Vehicle
GROUP BY Status
ORDER BY Status;
";
$result = $conn->query($sql);
$statusLabels = [];
$statusTotals = [];
while ($row = $result->fetch_assoc())
{
    $statusLabels[] = $row['Status'];
    $statusTotals[] = $row['Total'];
}
$sql = "
SELECT Severity,
COUNT(*) AS Total
FROM SafetyEvent
GROUP BY Severity;
";
$result = $conn->query($sql);
$severityLabels = [];
$severityTotals = [];
while($row = $result->fetch_assoc())
{
    $severityLabels[] = $row['Severity'];
    $severityTotals[] = $row['Total'];
}
$sql = "
SELECT
EmploymentStatus,
COUNT(*) AS Total
FROM Driver
GROUP BY EmploymentStatus;
";
$result = $conn->query($sql);
$driverStatus = [];
$driverTotals = [];
while($row = $result->fetch_assoc())
{
    $driverStatus[] = $row['EmploymentStatus'];
    $driverTotals[] = $row['Total'];
}
$sql = "
SELECT
    Username,
    IPAddress,
    Status,
    AttemptTime
FROM SecurityLog
ORDER BY AttemptTime DESC
LIMIT 10;
";
$loginLogs = $conn->query($sql);
$result = $conn->query("
SELECT COUNT(*) AS Total
FROM SecurityLog
WHERE Status='FAILED'
AND AttemptTime >= NOW() - INTERVAL 10 MINUTE
");
$failedAttempts = $result->fetch_assoc()['Total'];
$sql = "
SELECT
    DATE(AttemptTime) AS LoginDate,
    SUM(CASE WHEN Status='SUCCESS' THEN 1 ELSE 0 END) AS SuccessCount,
    SUM(CASE WHEN Status='FAILED' THEN 1 ELSE 0 END) AS FailedCount
FROM SecurityLog
GROUP BY DATE(AttemptTime)
ORDER BY LoginDate DESC
LIMIT 7;
";
$result = $conn->query($sql);
$dates = [];
$success = [];
$failed = [];
$temp = [];
while($row = $result->fetch_assoc())
{
    $temp[] = $row;
}
$temp = array_reverse($temp);
foreach($temp as $row)
{
    $dates[] = date("M d", strtotime($row["LoginDate"]));
    $success[] = $row["SuccessCount"];
    $failed[] = $row["FailedCount"];
}
?>
<div class="container mt-4">
<h2>
Welcome,
<?= $_SESSION["user"] ?>
</h2>
<p class="text-muted">
Powered by The Unemployed™
</p>
<div class="row mt-4">
<div class="col-md-3">
<div class="card text-bg-primary">
<div class="card-body">
<h5>
<i class="bi bi-truck"></i>
Vehicles
</h5>
<h2><?= $vehicleCount ?></h2>
</div>
</div>
</div>
<div class="col-md-3">
<div class="card text-bg-success">
<div class="card-body">
<h5>
<i class="bi-person-badge"></i>    
Drivers</h5>
<h2><?= $driverCount ?></h2>
</div>
</div>
</div>
<div class="col-md-3">
<div class="card text-bg-warning">
<div class="card-body">
<h5>
<i class="bi-tools"></i>Mechanics</h5>
<h2><?= $mechanicCount ?></h2>
</div>
</div>
</div>
<div class="col-md-3">
<div class="card text-bg-danger">
<div class="card-body">
<h5>
<i class="bi-exclamation-triangle"></i>Safety Events</h5>
<h2><?= $safetyCount ?></h2>
</div>
</div>
</div>
</div>
<hr>
<h3>General</h3>
<div class="card">
<div class="card-body">
<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card shadow-sm chart-card dashboard-card">
    <div class="card-header">
        Vehicles by Depot
    </div>
    <div class="card-body">
        <canvas id="vehicleChart"></canvas>
    </div>
</div>
    </div>
    <div class="col-lg-4">
    <div class="card shadow-sm chart-card dashboard-card">
        <div class="card-header">
            Vehicle Status Distribution
        </div>
        <div class="card-body">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>
</div>
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card shadow-sm chart-card dashboard-card">
            <div class="card-header">
                Safety Incident Severity
            </div>
            <div class="card-body">
                <canvas id="severityChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm chart-card dashboard-card">
            <div class="card-header">
                Driver Workforce Status
            </div>
            <div class="card-body">
                <canvas id="driverStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<hr class="my-4">
    <h2>
        SecOps
    </h2>
<div class="card">
<div class="card-body">
<div class="card shadow-sm dashboard-card mt-4">
    <div class="card-header">
        Recent Login Activity
    </div>
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Status</th>
                    <th>IP Address</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
            <?php while($log = $loginLogs->fetch_assoc()): ?>
                <tr class="<?= $log['Status']=='FAILED'
                                ? 'table-danger'
                                : 'table-success' ?>">
                    <td>
                        <?= htmlspecialchars($log['Username']) ?>
                    </td>
                    <td>
                        <?php if($log['Status']=="SUCCESS"): ?>
                            <span class="badge bg-success">
                                Success
                            </span>
                        <?php else: ?>
                            <span class="badge bg-danger">
                                Failed
                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($log['IPAddress']) ?>
                    </td>
                    <td>
                        <?= $log['AttemptTime'] ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="card shadow-sm dashboard-card mt-4">
    <div class="card-header">
        Authentication Trends
    </div>
    <div class="card-body">
        <canvas id="loginTrendChart"></canvas>
    </div>
</div>
</div>
</div>
<?php include "includes/footer.php"; ?>