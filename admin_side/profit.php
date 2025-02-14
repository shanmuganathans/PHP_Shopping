<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root@123";
$db_name = "register";

$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get Daily Profit
$daily_sql = "SELECT DATE(order_date) AS date, SUM(total_amount) AS daily_profit FROM orders GROUP BY DATE(order_date)";
$daily_result = $conn->query($daily_sql);

// Get Monthly Profit
$monthly_sql = "SELECT YEAR(order_date) AS year, MONTH(order_date) AS month, SUM(total_amount) AS monthly_profit FROM orders GROUP BY YEAR(order_date), MONTH(order_date)";
$monthly_result = $conn->query($monthly_sql);

// Get Yearly Profit
$yearly_sql = "SELECT YEAR(order_date) AS year, SUM(total_amount) AS yearly_profit FROM orders GROUP BY YEAR(order_date)";
$yearly_result = $conn->query($yearly_sql);

// Get Total Profit
$total_sql = "SELECT SUM(total_amount) AS total_profit FROM orders";
$total_result = $conn->query($total_sql);
$total_profit = $total_result->fetch_assoc()['total_profit'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit Report</title>
    <link rel="stylesheet" href="profit.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Profit Report</h1>

        <!-- Daily Profit -->
        <h3>Daily Profit</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Profit (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $daily_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td>₹ <?php echo number_format($row['daily_profit'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Monthly Profit -->
        <h3>Monthly Profit</h3>
        <table>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Profit (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $monthly_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['year']); ?></td>
                        <td><?php echo htmlspecialchars(date("F", mktime(0, 0, 0, $row['month'], 10))); ?></td>
                        <td>₹ <?php echo number_format($row['monthly_profit'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Yearly Profit -->
        <h3>Yearly Profit</h3>
        <table>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Profit (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $yearly_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['year']); ?></td>
                        <td>₹ <?php echo number_format($row['yearly_profit'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Total Profit -->
        <h2>Total Profit: ₹ <?php echo number_format($total_profit, 2); ?></h2>

        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>

    <?php
    // Close database connection
    $conn->close();
    ?>
</body>
</html>
