<?php
include_once '../actions/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);

    // First delete related cart entries
    $stmt1 = $conn->prepare("DELETE FROM cart WHERE menu_item_id = ?");
    $stmt1->bind_param('i', $id);
    $stmt1->execute();
    $stmt1->close();

    // Now delete the menu item
    $stmt2 = $conn->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt2->bind_param('i', $id);

    if ($stmt2->execute()) {
        $stmt2->close();
        header('Location: ../admin/dashboard.php');
        exit();
    } else {
        echo "<script>alert('Failed to delete'); window.location = '../admin/dashboard.php';</script>";
        exit();
    }
}
?>
