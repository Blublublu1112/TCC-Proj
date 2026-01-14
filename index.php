<?php
// index.php - Homepage: list items with Edit/Delete options
// Includes database connection and shared header/footer.
require_once __DIR__ . '/db.php';
include __DIR__ . '/header.php';

// Fetch items from the database
$result = null;
$error_msg = '';

if (isset($mysqli) && !$mysqli->connect_errno) {
    // Check if table exists first to avoid crash
    $table_check = $mysqli->query("SHOW TABLES LIKE 'items'");
    if ($table_check && $table_check->num_rows > 0) {
        $result = $mysqli->query("SELECT id, name, description, price FROM items ORDER BY id DESC");
        if (!$result) {
            $error_msg = "Error fetching items: " . $mysqli->error;
        }
    } else {
        $error_msg = "Table 'items' does not exist. Please run database.sql.";
    }
} else {
    $error_msg = "Database connection missing. " . ($db_error ?? '');
}
?>
<section>
  <h2>Items List</h2>
  <div style="margin-bottom: 16px;">
      <a href="add.php" class="btn">+ Add New Item</a>
  </div>
  
  <?php if ($error_msg): ?>
    <div class="alert">
        <strong>System Notice:</strong> <?php echo htmlspecialchars($error_msg); ?>
    </div>
  <?php endif; ?>

  <table class="items-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price ($)</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo nl2br(htmlspecialchars($row['description'])); ?></td>
            <td><?php echo number_format((float)$row['price'], 2); ?></td>
            <td>
              <a class="btn btn-secondary" href="edit.php?id=<?php echo urlencode($row['id']); ?>">Edit</a>
              <a class="btn btn-danger" href="delete.php?id=<?php echo urlencode($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5" class="empty">No items found. <?php if (!$error_msg) echo '<a href="add.php">Add one now!</a>'; ?></td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</section>
<?php include __DIR__ . '/footer.php'; ?>
