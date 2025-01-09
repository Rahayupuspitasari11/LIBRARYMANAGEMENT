<?php
include 'db.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Book deleted successfully!'); window.location='index.php';</script>";
    } else {
        echo "Error deleting book: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>