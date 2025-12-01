<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>All Users</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        *{box-sizing:border-box;font-family:"Poppins",system-ui,Arial; margin:0;padding:0}
        body{background:#f4f6fc;padding:28px;color:#222}
        .wrap{max-width:1100px;margin:0 auto}
        .top{display:flex;align-items:center;gap:16px;margin-bottom:18px}
        .title{font-size:20px;color:#3b0ca5;font-weight:700}
        .sub{color:#8a88a8;font-size:13px}
        .card{background:#fff;padding:18px;border-radius:12px;box-shadow:0 6px 24px rgba(59,12,165,0.06)}
        table{width:100%;border-collapse:collapse;margin-top:12px}
        th,td{padding:10px 12px;border-bottom:1px solid #f1eefb;text-align:left;font-size:14px}
        th{color:#6f42c1;font-weight:700}
        tr:hover{background:linear-gradient(90deg,rgba(111,66,193,0.03),transparent)}
        .back{display:inline-block;margin-bottom:12px;padding:8px 12px;border-radius:8px;background:transparent;color:#6f42c1;border:1px solid rgba(111,66,193,0.12);text-decoration:none}
        .empty{padding:22px;text-align:center;color:#8a88a8}
    </style>
</head>
<body>
    <div class="wrap">
        <div class="top">
            <div>
                <div class="title">All Users</div>
                <div class="sub">List of registered users</div>
            </div>
            <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                <a class="back" href="<?= base_url('/admin/dashboard') ?>">← Back to Dashboard</a>
                <a class="back" href="<?= base_url('/admin/users/export') ?>" style="background:#6f42c1;color:#fff;border:0;padding:8px 12px;border-radius:8px;text-decoration:none">Export CSV</a>
            </div>
        </div>

        <div class="card">
            <?php if (empty($users)): ?>
                <div class="empty">No users found.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= esc($u['id']) ?></td>
                                <td><?= esc($u['username']) ?></td>
                                <td><?= esc($u['role'] ?? '') ?></td>
                                <td><?= esc($u['created_at'] ?? '—') ?></td>
                                <td>
                                    <a href="<?= base_url('/admin/users/edit/' . $u['id']) ?>" style="color:#6f42c1;text-decoration:none;margin-right:8px">Edit</a>
                                    <?php if ($u['id'] != session()->get('user_id')): ?>
                                        <form method="post" action="<?= base_url('/admin/users/delete/' . $u['id']) ?>" style="display:inline" onsubmit="return confirm('Delete this user?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" style="background:transparent;border:0;color:#e74c3c;cursor:pointer">Delete</button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color:#999;font-size:13px">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>