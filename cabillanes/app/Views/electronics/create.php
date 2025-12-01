<!DOCTYPE html>
<html>
<head>
    <title>Add Electronics</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; justify-content: center; padding: 50px;}
        form { background: #fff; padding: 20px; border-radius: 10px; width: 400px; box-shadow: 0 0 10px #aaa;}
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc; }
        button { margin-top: 15px; padding: 10px; width: 100%; background: #5563DE; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #3b46b0; }
    </style>
</head>
<body>
    <form method="post" action="<?= base_url('/electronics/store') ?>">
        <h2>Add New Electronics</h2>
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Brand:</label>
        <input type="text" name="brand" required>

        <label>Model:</label>
        <input type="text" name="model">

        <label>Quantity:</label>
        <input type="number" name="quantity" required>

        <label>Status:</label>
        <select name="status">
            <option value="Available">Available</option>
            <option value="Sold">Sold</option>
            <option value="Reserved">Reserved</option>
        </select>

        <button type="submit">Save Electronics</button>
    </form>
</body>
</html>
