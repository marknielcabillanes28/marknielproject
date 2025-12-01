<!DOCTYPE html>
<html>
<head>
    <title>My Purchases</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f4f4f4;}
        h1 { text-align: center; margin-bottom: 30px; }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #5563DE; color: #fff; }
        a.button {
            padding: 6px 12px;
            background: #5563DE;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        a.button:hover { background: #3b46b0; }
        .logout {
            background: red;
        }
        .logout:hover { background: darkred; }
        .empty {
            text-align: center;
            padding: 20px;
            color: #555;
            background: white;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h1>My Purchases</h1>
        <div>
            <a class="button" href="<?= base_url('/electronics') ?>">← Back to Inventory</a>
            <a class="button logout" href="<?= base_url('/auth/logout') ?>">Logout</a>
        </div>
    </div>

    <?php if (!empty($purchases)): ?>
    <table>
        <tr>
            <th>Item Name</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Quantity Purchased</th>
            <th>Date</th>
        </tr>
        <?php foreach($purchases as $purchase): ?>
        <tr>
            <td><?= $purchase['name'] ?></td>
            <td><?= $purchase['brand'] ?></td>
            <td><?= $purchase['model'] ?></td>
            <td><?= $purchase['quantity'] ?></td>
            <td><?= date('F j, Y, g:i a', strtotime($purchase['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <div class="empty">
            <p>You haven’t made any purchases yet.</p>
        </div>
    <?php endif; ?>
</body>
</html>
