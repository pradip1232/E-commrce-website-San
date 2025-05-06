<?php
include "db_con.php";

// Read form values
$rate = floatval($_POST['taxRate']);
$start = $_POST['startDate'];
$end = $_POST['endDate'];

// Insert into DB
$stmt = $conn->prepare("INSERT INTO tax_rates (rate, start_date, end_date) VALUES (?, ?, ?)");
$stmt->bind_param("dss", $rate, $start, $end);

if ($stmt->execute()) {
  echo "Tax Rate added successfully.";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
