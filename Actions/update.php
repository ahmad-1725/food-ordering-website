<?php 

include('connect.php');

if (isset($_POST['update_dish'])) {
    $id = $_POST['id']; // Assuming you're sending the dish ID for update
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $query = $conn->prepare("UPDATE menu_items SET title = ?, description = ?, price = ? WHERE id = ?");
    $query->bind_param("ssii", $title, $description, $price, $id);

    $res = $query->execute();
    
    if (!$res) {
        die("SOMETHING WENT WRONG: " . $conn->error);
    }

    header('Location: ../admin/dashboard.php');
    exit();
}else{
    echo "<script>alert('Failed to Update.'); window.location='../admin/dashboard.php'; </script> ";
}

?>
