
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reports — Purple Theme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root{
            --purple-1:#3b0ca5;
            --purple-2:#6f42c1;
            --purple-3:#a687e8;
            --bg:#f6f4fb;
            --card:#ffffff;
            --muted:#8a88a8;
            --accent:#7b3ff2;
            --success:#2ecc71;
        }
        *{box-sizing:border-box;font-family:Inter, "Poppins", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;}
        body{margin:0;background:linear-gradient(180deg,var(--bg),#efeafc);padding:28px;color:#222}
        .wrap{max-width:1200px;margin:0 auto}
        header{display:flex;align-items:center;gap:16px;margin-bottom:20px}
        .brand{
            display:flex;align-items:center;gap:12px;
        }
        .logo{
            width:56px;height:56px;border-radius:12px;
            background:linear-gradient(135deg,var(--purple-1),var(--purple-2));
            display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:20px;box-shadow:0 6px 18px rgba(107,63,201,0.18)
        }
        h1{font-size:20px;margin:0;color:var(--purple-1)}
        .sub{color:var(--muted);font-size:13px}
        .card{background:var(--card);border-radius:14px;padding:18px;box-shadow:0 6px 30px rgba(85,63,132,0.06);margin-bottom:18px}
        .controls{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
        .controls form{display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin:0}
        input[type="date"]{padding:8px 10px;border-radius:8px;border:1px solid #ece9f8;background:#fff;font-size:14px}
        .btn{
            display:inline-flex;align-items:center;gap:8px;padding:9px 12px;border-radius:10px;border:0;background:var(--accent);color:#fff;font-weight:600;cursor:pointer;text-decoration:none;
            box-shadow:0 6px 18px rgba(123,63,242,0.18)
        }
        .btn.ghost{background:transparent;color:var(--purple-2);border:1px solid rgba(123,63,242,0.12);box-shadow:none}
        .summary{display:flex;gap:16px;flex-wrap:wrap;align-items:center;margin-top:12px}
        .stat{background:linear-gradient(180deg,#fff,#fbf9ff);padding:12px 14px;border-radius:10px;border:1px solid rgba(124,85,236,0.06);font-weight:600;color:var(--purple-1)}
        table{width:100%;border-collapse:collapse;margin-top:14px;font-size:14px}
        th,td{padding:10px 12px;text-align:left;border-bottom:1px solid #f1eefb}
        th{background:linear-gradient(90deg,rgba(123,63,242,0.06),transparent);color:var(--purple-2);font-weight:700}
        tbody tr:hover{background:linear-gradient(90deg,rgba(123,63,242,0.03),transparent)}
        .empty{padding:28px;text-align:center;color:var(--muted);font-size:15px}
        .small{font-size:13px;color:var(--muted)}
        @media (max-width:900px){
            th,td{padding:10px 8px;font-size:13px}
            .controls{flex-direction:column;align-items:flex-start}
        }
    </style>
</head>
<body>
    <div class="wrap">
        <header>
            <div class="brand">
                <div class="logo">RP</div>
                <div>
                    <h1>Reports</h1>
                    <div class="sub">Overview of recent purchases and exports</div>
                </div>
            </div>
            <div style="margin-left:auto" class="small">Theme: Purple • Preset</div>
        </header>

        <div class="card">
            <div class="controls">
                <form method="get" action="<?= esc(current_url()) ?>">
                    <label class="small">Start
                        <input type="date" name="start_date" value="<?= esc($start_date ?? '') ?>">
                    </label>
                    <label class="small">End
                        <input type="date" name="end_date" value="<?= esc($end_date ?? '') ?>">
                    </label>
                    <button type="submit" class="btn">Filter</button>
                    <a class="btn ghost" href="<?= base_url('/admin/reports/export') . (($start_date || $end_date) ? ('?start_date=' . urlencode($start_date) . '&end_date=' . urlencode($end_date)) : '') ?>">
                        Export CSV
                    </a>
                </form>
            </div>

            <div class="summary">
                <div class="stat">Transactions: <?= esc($total_transactions ?? 0) ?></div>
                <div class="stat">Items sold: <?= esc($total_items_sold ?? 0) ?></div>
                <div class="small" style="margin-left:auto">Generated: <?= date('Y-m-d H:i') ?></div>
            </div>

            <div style="margin-top:12px">
                <?php if (empty($reports)): ?>
                    <div class="empty">No records found for the selected period.</div>
                <?php else: ?>
                    <div class="card" style="padding:0;overflow:auto">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Buyer</th>
                                    <th>Item</th>
                                    <th>Brand</th>
                                    <th>Quantity</th>
                                    <th>Purchased At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reports as $r): ?>
                                    <tr>
                                        <td><?= esc($r['id'] ?? '') ?></td>
                                        <td><?= esc($r['buyer'] ?? '—') ?></td>
                                        <td><?= esc($r['electronic_name'] ?? '—') ?></td>
                                        <td><?= esc($r['electronic_brand'] ?? '—') ?></td>
                                        <td><?= esc($r['quantity'] ?? 0) ?></td>
                                        <td><?= esc($r['created_at'] ?? '—') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <footer style="text-align:center;color:var(--muted);font-size:13px;margin-top:10px">
            © <?= date('Y') ?> — Reports
        </footer>
    </div>
</body>
</html>