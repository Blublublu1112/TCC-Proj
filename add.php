<?php
// add.php - Add a new item (Create)
// Shows a form and handles submission via POST.
require_once __DIR__ . '/db.php';
include __DIR__ . '/header.php';

// Handle form submit
$errors = [];
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

    // Insert if no errors
    if (!$errors) {
        // Check connection
        if (!isset($mysqli) || $mysqli->connect_errno) {
             $errors[] = "Database connection error. " . ($db_error ?? '');
        } else {
            $stmt = $mysqli->prepare("INSERT INTO items (name, description, price) VALUES (?, ?, ?)");
            if (!$stmt) {
                $errors[] = 'Database error (prepare): ' . $mysqli->error;
            } else {
                $stmt->bind_param('ssd', $name, $description, $price);
                if ($stmt->execute()) {
                    // Success: redirect to home
                    header('Location: index.php');
                    exit;
                } else {
                    $errors[] = 'Database error (insert): ' . $stmt->error;
                }
                $stmt->close();
            }
        }
    }
}
?>
<section>
  <h2>Add New Item</h2>
  
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

  <form method="post" action="add.php" class="form">
    <label>
      Name:
      <input type="text" name="name" required placeholder="Item Name">
    </label>
    
    <label>
      Description:
      <textarea name="description" rows="4" placeholder="Item Description"></textarea>
    </label>
    
    <label>
      Price ($):
      <input type="number" name="price" step="0.01" min="0" required placeholder="0.00">
    </label>
    
    <div class="actions">
      <button type="submit" class="btn">Save Item</button>
      <a href="index.php" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
  
</section>
<?php include __DIR__ . '/footer.php'; ?>
