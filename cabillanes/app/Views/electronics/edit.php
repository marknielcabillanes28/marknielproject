<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Electronic</title>

    <!-- ✅ BOOTSTRAP 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Edit Electronic Item</h4>
                    </div>

                    <div class="card-body">
                        <form method="post" action="<?= base_url('/electronics/update/' . $electronic['id']) ?>">

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="<?= $electronic['name'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Brand</label>
                                <input type="text" name="brand" class="form-control" value="<?= $electronic['brand'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Model</label>
                                <input type="text" name="model" class="form-control" value="<?= $electronic['model'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="<?= $electronic['quantity'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="Available" <?= $electronic['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                                    <option value="Out of Stock" <?= $electronic['status'] == 'Out of Stock' ? 'selected' : '' ?>>Out of Stock</option>
                                    <option value="Maintenance" <?= $electronic['status'] == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Update Item</button>
                        </form>
                    </div>

                    <div class="card-footer text-center">
                        <a href="<?= base_url('/electronics') ?>" class="btn btn-secondary w-100">Back to List</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ✅ BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
