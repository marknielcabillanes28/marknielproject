<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #f4f6fc;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #5563DE, #3641a5);
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
            position: fixed;
            height: 100%;
            box-shadow: 2px 0 10px rgba(0,0,0,0.2);
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
            font-weight: bold;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 12px 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            display: block;
            transition: background 0.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255,255,255,0.2);
        }

        .sidebar .logout {
            margin-top: auto;
            background: #e74c3c;
            text-align: center;
        }

        .sidebar .logout:hover {
            background: #c0392b;
        }

        /* Main content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 40px;
        }

        .main-content h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .content-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .content-box p {
            font-size: 16px;
            color: #555;
        }

        .username {
            font-weight: bold;
            color: #222;
        }

        /* Alert box */
        .alert.success {
            background: #e0f7e9;
            color: #1b5e20;
            padding: 15px;
            border-radius: 8px;
            border-left: 6px solid #43a047;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert.danger {
            background: #fdecea;
            color: #c0392b;
            padding: 15px;
            border-radius: 8px;
            border-left: 6px solid #e74c3c;
            margin-bottom: 20px;
            font-weight: 500;
        }

        /* Toggle Switch */
        .toggle-container {
            margin-top: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #43a047;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .status-label {
            font-weight: 600;
            color: #333;
        }
    </style>
</head>
<body>

    <!-- ✅ Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="<?= base_url('/admin/dashboard') ?>" class="active">🏠 Dashboard</a>
        <a href="<?= base_url('/electronics') ?>">📦 Manage Electronics</a>
        <a href="<?= base_url('/admin/users') ?>">👥 All Users</a>
        <a href="<?= base_url('/admin/reports') ?>">📈 Reports</a>
        <a href="<?= base_url('/admin/activity-logs') ?>">📊 Activity Logs</a>
        <a href="<?= base_url('/auth/logout') ?>" class="logout">🚪 Logout</a>
    </div>

    <!-- ✅ Main Content -->
    <div class="main-content">

        <!-- ✅ Flash Message -->
        <?php if(session()->getFlashdata('status')): ?>
            <div class="alert <?= (strpos(session()->getFlashdata('status'), 'ENABLED') !== false) ? 'danger' : 'success' ?>">
                <?= session()->getFlashdata('status') ?>
            </div>
        <?php endif; ?>

        <h1>Welcome, <span class="username"><?= session('username') ?></span> 👋</h1>

        <div class="content-box">
            <p>This is your admin dashboard. From here, you can manage electronics, view data, and monitor system activities.</p>

            <!-- ✅ Maintenance Toggle Section -->
            <div class="toggle-container">
                <label class="switch">
                    <input type="checkbox" id="maintenanceSwitch" <?= ($maintenance_mode === 'on') ? 'checked' : '' ?>>
                    <span class="slider"></span>
                </label>
                <span class="status-label" id="statusLabel">
                    <?= ($maintenance_mode === 'on') ? '🛠 Maintenance ON' : '✅ Maintenance OFF' ?>
                </span>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('maintenanceSwitch').addEventListener('change', function() {
            window.location.href = '<?= base_url('/admin/toggle-maintenance') ?>';
        });
    </script>

</body>
</html>
