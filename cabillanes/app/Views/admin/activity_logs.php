<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs - Admin Panel</title>
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

        /* Alert styles */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert.success {
            background: #e0f7e9;
            color: #1b5e20;
            border-left: 6px solid #43a047;
        }

        .alert.danger {
            background: #fdecea;
            color: #c0392b;
            border-left: 6px solid #e74c3c;
        }

        /* Table styles */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .table-header {
            background: #5563DE;
            color: white;
            padding: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        /* Status badges */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #e8f5e8;
            color: #2d5a2d;
        }

        .status-blocked {
            background-color: #fdecea;
            color: #c0392b;
        }

        .status-inactive {
            background-color: #f0f0f0;
            color: #666;
        }

        /* Action buttons */
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
            margin: 2px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-block {
            background-color: #e74c3c;
            color: white;
        }

        .btn-block:hover {
            background-color: #c0392b;
        }

        .btn-unblock {
            background-color: #27ae60;
            color: white;
        }

        .btn-unblock:hover {
            background-color: #229954;
        }

        .btn-delete {
            background-color: #8e44ad;
            color: white;
        }

        .btn-delete:hover {
            background-color: #7d3c98;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #666;
        }

        .empty-state i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="<?= base_url('/admin/dashboard') ?>">🏠 Dashboard</a>
        <a href="<?= base_url('/electronics') ?>">📦 Manage Electronics</a>
        <a href="<?= base_url('/admin/activity-logs') ?>" class="active">📊 Activity Logs</a>
        <a href="<?= base_url('/auth/logout') ?>" class="logout">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Flash Messages -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert success">
                ✅ <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert danger">
                ❌ <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <h1>📊 Activity Logs</h1>

        <!-- IP Range Blocking Section -->
        <div class="table-container" style="margin-bottom: 30px;">
            <div class="table-header">
                🚫 IP Range Blocking
            </div>
            <div style="padding: 20px;">
                <form id="ipBlockForm" style="display: grid; grid-template-columns: 1fr 1fr 2fr auto; gap: 10px; align-items: end;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">From IP Address</label>
                        <input type="text" id="from_ip" name="from_ip" placeholder="192.168.1.1" 
                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">To IP Address</label>
                        <input type="text" id="to_ip" name="to_ip" placeholder="192.168.1.255" 
                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">Reason (Optional)</label>
                        <input type="text" id="reason" name="reason" placeholder="Suspicious activity" 
                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    <button type="submit" class="btn" 
                            style="background-color: #e74c3c; color: white; padding: 10px 20px; height: 42px;">
                        🚫 Block IP Range
                    </button>
                </form>

                <div id="ipBlockMessage" style="margin-top: 15px; display: none;"></div>

                <!-- Blocked IPs Table -->
                <div style="margin-top: 30px;">
                    <h3 style="margin-bottom: 15px; color: #333;">Blocked IP Ranges</h3>
                    <?php if (!empty($ipBlocks)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>From IP</th>
                                    <th>To IP</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="ipBlocksTableBody">
                                <?php foreach ($ipBlocks as $block): ?>
                                    <tr id="ipblock-<?= $block['id'] ?>">
                                        <td><?= $block['id'] ?></td>
                                        <td><strong><?= esc($block['from_ip']) ?></strong></td>
                                        <td><strong><?= esc($block['to_ip']) ?></strong></td>
                                        <td><?= esc($block['reason'] ?: 'N/A') ?></td>
                                        <td>
                                            <span class="status-badge status-<?= $block['status'] ?>">
                                                <?= ucfirst($block['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= esc($block['created_by']) ?></td>
                                        <td><?= date('M j, Y g:i A', strtotime($block['created_at'])) ?></td>
                                        <td>
                                            <?php if ($block['status'] === 'active'): ?>
                                                <button onclick="unblockIpRange(<?= $block['id'] ?>)" 
                                                        class="btn btn-unblock">
                                                    ✅ Unblock
                                                </button>
                                            <?php endif; ?>
                                            <button onclick="deleteIpBlock(<?= $block['id'] ?>)" 
                                                    class="btn btn-delete">
                                                🗑️ Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p style="color: #666; padding: 20px; text-align: center; background: #f8f9fa; border-radius: 8px;">
                            No IP ranges have been blocked yet.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                User Activity Monitoring
            </div>

            <?php if (!empty($logs)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>IP Address</th>
                            <th>MAC Address</th>
                            <th>Action</th>
                            <th>Status</th>
                            <th>Date & Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?= $log['id'] ?></td>
                                <td><strong><?= esc($log['name']) ?></strong></td>
                                <td><?= esc($log['ip_address']) ?></td>
                                <td><?= esc($log['mac_address']) ?></td>
                                <td><?= ucfirst(esc($log['action'])) ?></td>
                                <td>
                                    <span class="status-badge status-<?= $log['status'] ?>">
                                        <?= ucfirst($log['status']) ?>
                                    </span>
                                </td>
                                <td><?= date('M j, Y g:i A', strtotime($log['created_at'])) ?></td>
                                <td>
                                    <?php if ($log['status'] === 'active'): ?>
                                        <a href="<?= base_url('/admin/activity-logs/block/' . $log['id']) ?>" 
                                           class="btn btn-block"
                                           onclick="return confirm('Are you sure you want to block this user?')">
                                            🚫 Block
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('/admin/activity-logs/unblock/' . $log['id']) ?>" 
                                           class="btn btn-unblock"
                                           onclick="return confirm('Are you sure you want to unblock this user?')">
                                            ✅ Unblock
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="<?= base_url('/admin/activity-logs/delete/' . $log['id']) ?>" 
                                       class="btn btn-delete"
                                       onclick="return confirm('Are you sure you want to delete this log entry?')">
                                        🗑️ Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <div style="font-size: 48px; margin-bottom: 20px;">📝</div>
                    <h3>No Activity Logs Found</h3>
                    <p>No user activity has been recorded yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Handle IP Block Form Submission
        document.getElementById('ipBlockForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messageDiv = document.getElementById('ipBlockMessage');
            
            fetch('<?= base_url('/admin/activity-logs/block-ip-range') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                messageDiv.style.display = 'block';
                if (data.success) {
                    messageDiv.className = 'alert success';
                    messageDiv.innerHTML = '✅ ' + data.message;
                    // Reset form
                    document.getElementById('ipBlockForm').reset();
                    // Reload page after 1 second
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    messageDiv.className = 'alert danger';
                    messageDiv.innerHTML = '❌ ' + data.message;
                }
            })
            .catch(error => {
                messageDiv.style.display = 'block';
                messageDiv.className = 'alert danger';
                messageDiv.innerHTML = '❌ An error occurred: ' + error;
            });
        });

        // Unblock IP Range
        function unblockIpRange(id) {
            if (!confirm('Are you sure you want to unblock this IP range?')) {
                return;
            }

            fetch('<?= base_url('/admin/activity-logs/unblock-ip-range/') ?>' + id, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ ' + data.message);
                }
            })
            .catch(error => {
                alert('❌ An error occurred: ' + error);
            });
        }

        // Delete IP Block
        function deleteIpBlock(id) {
            if (!confirm('Are you sure you want to delete this IP block?')) {
                return;
            }

            fetch('<?= base_url('/admin/activity-logs/delete-ip-block/') ?>' + id, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    document.getElementById('ipblock-' + id).remove();
                } else {
                    alert('❌ ' + data.message);
                }
            })
            .catch(error => {
                alert('❌ An error occurred: ' + error);
            });
        }
    </script>

</body>
</html>