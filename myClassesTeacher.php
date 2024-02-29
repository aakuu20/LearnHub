<?php
include('connection.php');

header("Content-Type: application/json");
$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data["user_id"];

$query = $mysqli->prepare(
    "SELECT classes.*, `classes-enrollments`.role
    FROM classes
    JOIN `classes-enrollments` ON classes.class_id = `classes-enrollments`.class_id
    WHERE `classes-enrollments`.user_id = ? AND `classes-enrollments`.role = 'teacher'"
);

$query->bind_param('s', $user_id);
$query->execute();
$result = $query->get_result();
$classes = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($classes);
?>