<!DOCTYPE html>
<html>
<head>
    <title>Electronics Inventory</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f4f4f4;}
        h1 { text-align: center; }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #5563DE; color: #fff; }
        a.button {
            padding: 6px 12px;
            background: #5563DE;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 5px;
        }
        a.button:hover { background: #3b46b0; }
        .logout {
            background: red;
        }
        .logout:hover {
            background: darkred;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h1>Electronics Inventory</h1>
        <a class="button logout" href="<?= base_url('/auth/logout') ?>">Logout</a>
    </div>

    <a class="button" href="<?= base_url('/electronics/create') ?>">Add New Electronics</a>

    <table>
        <tr>
            <th>Name</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach($electronics as $item): ?>
        <tr>
            <td><?= $item['name'] ?></td>
            <td><?= $item['brand'] ?></td>
            <td><?= $item['model'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= $item['status'] ?></td>
            <td>
                <a class="button" href="<?= base_url('/electronics/edit/' . $item['id']) ?>">Edit</a>
                <a class="button" href="<?= base_url('/electronics/delete/' . $item['id']) ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
