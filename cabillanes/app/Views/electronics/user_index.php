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
        a.button, button.button {
            padding: 6px 12px;
            background: #5563DE;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 5px;
            border: none;
            cursor: pointer;
        }
        a.button:hover, button.button:hover { background: #3b46b0; }
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
      
        <a class="button" href="<?= base_url('/electronics/my-purchases') ?>">My Purchases</a>
    </div>

    <table>
        <tr>
            <th>Name</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach($electronics as $item): ?>
        <tr>
            <td><?= $item['name'] ?></td>
            <td><?= $item['brand'] ?></td>
            <td><?= $item['model'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= $item['status'] ?></td>
            <td>
                <?php if ($item['quantity'] > 0): ?>
                <form method="post" action="<?= base_url('/electronics/buy/' . $item['id']) ?>" style="display:inline;">
                    <input type="number" name="buy_quantity" min="1" max="<?= $item['quantity'] ?>" value="1" required>
                    <button class="button" type="submit">Buy</button>
                </form>
                <?php else: ?>
                <span style="color:red;">Out of Stock</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
