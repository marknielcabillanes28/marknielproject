
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>User Dashboard</title>
    <style>
        :root{
            --bg:#f6f4fb;
            --purple-1:#3b0ca5;
            --purple-2:#6f42c1;
            --muted:#777;
            --card:#fff;
        }
        *{box-sizing:border-box;font-family:Inter, "Poppins", Arial, sans-serif}
        body{margin:0;background:linear-gradient(180deg,var(--bg),#efeafc);min-height:100vh;display:flex}
        /* Sidebar */
        .sidebar{
            width:240px;background:linear-gradient(180deg,var(--purple-2),var(--purple-1));color:#fff;padding:22px;display:flex;flex-direction:column;gap:18px;position:fixed;left:0;top:0;bottom:0
        }
        .brand{display:flex;align-items:center;gap:12px}
        .logo{width:48px;height:48px;border-radius:10px;background:rgba(255,255,255,0.12);display:flex;align-items:center;justify-content:center;font-weight:700}
        .brand h2{font-size:16px;margin:0}
        .nav{display:flex;flex-direction:column;gap:8px;margin-top:8px}
        .nav a{color:#fff;text-decoration:none;padding:10px;border-radius:8px;display:block;transition:background .18s}
        .nav a:hover,.nav a.active{background:rgba(255,255,255,0.08)}
        .profile{margin-top:auto;font-size:14px;color:rgba(255,255,255,0.85)}
        .logout{background:#ff6b6b;padding:10px 12px;border-radius:8px;text-align:center;color:#fff;text-decoration:none;display:block;margin-top:12px}

        /* Main content */
        .main{margin-left:240px;padding:28px;flex:1;min-height:100vh}
        .top{display:flex;align-items:center;gap:12px}
        .greet h1{margin:0;color:var(--purple-1);font-size:20px}
        .greet p{margin:6px 0 0;color:var(--muted);font-size:14px}
        .actions{margin-left:auto;display:flex;gap:10px;align-items:center}
        .btn{background:var(--purple-2);color:#fff;padding:9px 12px;border-radius:10px;text-decoration:none;font-weight:600;box-shadow:0 6px 18px rgba(111,66,193,0.12)}
        .btn.ghost{background:transparent;color:var(--purple-2);border:1px solid rgba(111,66,193,0.12)}
        .card{background:var(--card);padding:18px;border-radius:12px;margin-top:18px;box-shadow:0 10px 30px rgba(59,12,165,0.04)}
        .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:12px}
        .stat{padding:14px;border-radius:10px;background:linear-gradient(180deg,#fff,#fbf9ff);font-weight:700;color:var(--purple-1)}
        @media (max-width:900px){
            .sidebar{position:relative;width:100%;height:auto;flex-direction:row;align-items:center;padding:12px;gap:10px}
            .main{margin-left:0;padding:16px}
            .grid{grid-template-columns:1fr;align-items:stretch}
            .profile{display:none}
        }
    </style>
</head>
<body>
    <aside class="sidebar" role="navigation" aria-label="Main sidebar">
        <div class="brand">
            <div class="logo">U</div>
            <div>
                <h2>My Account</h2>
                <div style="font-size:12px;opacity:.95">User Panel</div>
            </div>
        </div>

        <nav class="nav" role="menu">
            <a href="<?= base_url('/user/dashboard') ?>" class="active">🏠 Dashboard</a>
            <a href="<?= base_url('/electronics') ?>">📦 View Electronics</a>
            <a href="<?= base_url('/electronics/my-purchases') ?>">🧾 My Purchases</a>
            <a href="<?= base_url('/auth/logout') ?>" class="logout">🚪 Logout</a>
        </nav>

        <div class="profile">
            Signed in as<br>
            <strong><?= esc(session('username')) ?></strong>
        </div>
    </aside>

    <main class="main">
        <div class="top">
            <div class="greet">
                <h1>Welcome, <?= esc(session('username')) ?> 👋</h1>
                <p>Quick actions and recent activity</p>
            </div>

            <div class="actions">
                <a class="btn" href="<?= base_url('/electronics') ?>">Browse Items</a>
                <a class="btn ghost" href="<?= base_url('/electronics/my-purchases') ?>">My Purchases</a>
            </div>
        </div>

       

        <section class="card" style="margin-top:14px">
            <h3 style="margin:0 0 8px;color:var(--purple-2)">Recent activity</h3>
            <p style="color:var(--muted)">No recent activity available.</p>
        </section>
    </main>

    <script>
        // small enhancement: add 'active' to current link based on path
        (function(){
            try {
                var links = document.querySelectorAll('.nav a');
                var path = location.pathname.replace(/\/$/, '');
                links.forEach(function(a){
                    if (a.getAttribute('href') === path) {
                        a.classList.add('active');
                    } else {
                        a.classList.remove('active');
                    }
                });
            } catch(e){}
        })();
    </script>
</body>
</html>
