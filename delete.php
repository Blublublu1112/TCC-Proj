<?php
// delete.php - Delete an item (Delete)
// Acceps ID via GET, performs delete, and redirects.
require_once 'db.php';

$id = $_GET['id'] ?? '';

if ($id !== '' && ctype_digit($id)) {
    // ID is valid, proceed to delete
    $stmt = $mysqli->prepare("DELETE FROM items WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Redirect to home after delete (whether successful or not)
header('Location: index.php');
exit;
