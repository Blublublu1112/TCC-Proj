<?php
// edit.php - Edit an existing item (Update)
require_once 'db.php';
include 'header.php';

// Get ID from URL
$id = $_GET['id'] ?? '';
if ($id === '' || !ctype_digit($id)) {
    echo '<section><div class="alert">Invalid item ID. <a href="index.php">Go Back</a></div></section>';
    include 'footer.php';
    exit;
}

$errors = [];
// Fetch existing item data to pre-fill the form
$stmt = $mysqli->prepare("SELECT id, name, description, price FROM items WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();
$stmt->close();

if (!$item) {
    echo '<section><div class="alert">Item not found. <a href="index.php">Go Back</a></div></section>';
    include 'footer.php';
    exit;
}

// Handle form submission (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');

    // Validation
    if ($name === '') {
        $errors[] = 'Name is required.';
    }
    if ($price === '' || !is_numeric($price)) {
        $errors[] = 'Valid price is required.';
    }

    // Update if no errors
    if (!$errors) {
        $stmt = $mysqli->prepare("UPDATE items SET name = ?, description = ?, price = ? WHERE id = ?");
        if (!$stmt) {
            $errors[] = 'Database error (prepare): ' . $mysqli->error;
        } else {
            $stmt->bind_param('ssdi', $name, $description, $price, $id);
            if ($stmt->execute()) {
                // Success: redirect to home
                header('Location: index.php');
                exit;
            } else {
                $errors[] = 'Database error (update): ' . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>
<section>
  <h2>Edit Item</h2>

  <?php if ($errors): ?>
    <div class="alert">
      <strong>Error:</strong>
      <ul style="margin: 0; padding-left: 20px;">
        <?php foreach ($errors as $e): ?>
          <li><?php echo htmlspecialchars($e); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" action="edit.php?id=<?php echo htmlspecialchars($id); ?>" class="form">
    <label>
      Name:
      <input type="text" name="name" value="<?php echo htmlspecialchars($item['name']); ?>" required>
    </label>
    
    <label>
      Description:
      <textarea name="description" rows="4"><?php echo htmlspecialchars($item['description']); ?></textarea>
    </label>
    
    <label>
      Price ($):
      <input type="number" name="price" step="0.01" min="0" value="<?php echo htmlspecialchars($item['price']); ?>" required>
    </label>
    
    <div class="actions">
      <button type="submit" class="btn">Update Item</button>
      <a href="index.php" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</section>
<?php include 'footer.php'; ?>
