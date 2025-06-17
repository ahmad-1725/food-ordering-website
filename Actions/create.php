<?php 
include_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $image = trim($_POST['image']);

    $stmt = $conn->prepare("INSERT INTO menu_items(title, description, price,img) VALUES (?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssis", $title, $description, $price,$image);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Dish created successfully'); window.location = '../dashboard/index.php';</script>";
        } else {
            echo "<script>alert('No rows affected. Please try again.'); window.location = '../dashboard/publish.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Insert query failed!'); window.location = '../dashboard/publish.php';</script>";
    }
}
?>
