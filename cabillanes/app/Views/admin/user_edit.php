
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit User</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        *{box-sizing:border-box;font-family:"Poppins",system-ui,Arial;margin:0;padding:0}
        body{background:#f6f4fb;padding:28px;color:#222}
        .wrap{max-width:700px;margin:0 auto}
        .card{background:#fff;padding:18px;border-radius:12px;box-shadow:0 10px 30px rgba(59,12,165,0.06)}
        label{display:block;margin-bottom:8px;font-weight:600;color:#4b2fa8}
        input, select{width:100%;padding:10px;border-radius:8px;border:1px solid #ece9f8;margin-bottom:12px}
        .row{display:flex;gap:12px}
        .actions{display:flex;gap:8px;justify-content:flex-end;margin-top:8px}
        .btn{padding:9px 12px;border-radius:8px;border:0;background:#7b3ff2;color:#fff;text-decoration:none}
        .btn.secondary{background:transparent;color:#6f42c1;border:1px solid rgba(111,66,193,0.12)}
    </style>
</head>
<body>
    <div class="wrap">
        <div style="margin-bottom:12px">
            <a class="btn secondary" href="<?= base_url('/admin/users') ?>">← Back</a>
        </div>

        <div class="card">
            <h2 style="color:#3b0ca5;margin-bottom:6px">Edit User</h2>
            <?php if(session()->getFlashdata('error')): ?>
                <div style="background:#fdecea;color:#c0392b;padding:10px;border-radius:8px;margin-bottom:10px"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <form method="post" action="<?= base_url('/admin/users/update/' . $user['id']) ?>">
                <?= csrf_field() ?>
                <label>Username</label>
                <input type="text" name="username" value="<?= esc(old('username', $user['username'])) ?>" required>

                <label>Role</label>
                <select name="role">
                    <option value="user" <?= ($user['role'] === 'user') ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                </select>

                <label>New Password (leave blank to keep current)</label>
                <input type="password" name="password" value="">

                <div class="actions">
                    <button type="submit" class="btn">Save</button>
                    <a class="btn secondary" href="<?= base_url('/admin/users') ?>">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>