<?php
include 'db_connect.php';

$service_id = $_GET['service_id'];
$sql = "SELECT * FROM tbl_services WHERE service_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $service_id);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();
$stmt->close();
$conn->close();

echo json_encode($service);
?>