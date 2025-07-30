<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Upload File</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5">
    <div class="card shadow-sm p-4 rounded-4">
      <h3 class="text-center mb-4 text-primary">Upload Your Products</h3>

      <form action="ServerUplaod.php" method="post" enctype="multipart/form-data">
        
        <!-- Item Category Dropdown -->
        <div class="mb-3">
          <label for="category" class="form-label">Select Item Category:</label>
          <select class="form-select" id="category" name="category" required>
            <option value="" disabled selected>Choose a category</option>
            <option value="Laptops">Laptops</option>
            <option value="TV & Fridge">TV & Fridge</option>
            <option value="Electronics">Electronics</option>
            <option value="Accessories">Accessories</option>
          </select>
        </div>

        <!-- Item Name Input -->
        <div class="mb-3">
          <label for="item_name" class="form-label">Item Name:</label>
          <input type="text" class="form-control" id="item_name" name="item_name" placeholder="e.g., HP Pavilion" required>
        </div>

        <!-- Model Input -->
        <div class="mb-3">
          <label for="model" class="form-label">Model:</label>
          <input type="text" class="form-control" id="model" name="model" placeholder="e.g., 15-eg2009TU" required>
        </div>

        <!-- Price Input -->
        <div class="mb-3">
          <label for="price" class="form-label">Price (in ₹):</label>
          <input type="number" class="form-control" id="price" name="price" min="0" required>
        </div>

        <!-- Description Textarea -->
        <div class="mb-3">
          <label for="description" class="form-label">Description:</label>
          <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter item details..." required></textarea>
        </div>

        <!-- File Upload Input -->
        <div class="mb-3">
          <label for="file" class="form-label">Select file to upload:</label>
          <input class="form-control" type="file" name="file" id="file" required>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
          <button type="submit" name="submit" class="btn btn-primary px-4">Upload</button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
