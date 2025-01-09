<?php
include 'db.php';

// Cek apakah ID diberikan dan valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data buku berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found!";
        exit;
    }
} else {
    echo "Invalid book ID!";
    exit;
}

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];

    // Update data buku di database
    $stmt = $conn->prepare("UPDATE books SET title = ?, author = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $author, $id);

    if ($stmt->execute()) {
        header("Location: index.php?message=Book updated successfully");
        exit;
    } else {
        echo "Error updating book: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        input, button {
            padding: 10px;
            margin: 10px 0;
            width: calc(100% - 22px);
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Book</h1>
        <form action="" method="POST">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($book['title']) ?>" required>
            <label for="author">Author</label>
            <input type="text" name="author" id="author" value="<?= htmlspecialchars($book['author']) ?>" required>
            <button type="submit">Update Book</button>
        </form>
    </div>
</body>
</html>
