<?php
// index.php - Homepage: list items with Edit/Delete options
// Includes database connection and shared header/footer.
require_once 'db.php';
include 'header.php';

// Fetch items from the database
// We check if the connection is successful first. If the table doesn't exist, this might fail gracefully or show an error.
$result = $mysqli->query("SELECT id, name, description, price FROM items ORDER BY id DESC");
?>
<section>
  <h2>Items List</h2>
  <div style="margin-bottom: 16px;">
      <a href="add.php" class="btn">+ Add New Item</a>
  </div>
  
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
        <tr><td colspan="5" class="empty">No items found in the database. <a href="add.php">Add one now!</a></td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</section>
<?php include 'footer.php'; ?>
