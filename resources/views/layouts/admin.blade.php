<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    @include('partials.site-icons')
    <title>@yield('title', 'Administración') - aislagratis</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --admin-green: #1b5e20;
            --admin-green-dark: #123f1a;
            --admin-green-soft: #edf6ee;
            --admin-ink: #18231a;
            --admin-muted: #68756a;
            --admin-line: #dfe8df;
            --admin-paper: #ffffff;
            --admin-ground: #f1f5f0;
            --admin-shadow: 0 16px 40px rgba(22, 40, 28, .09);
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--admin-ground); color: var(--admin-ink); font: 14px/1.6 'Montserrat', sans-serif; }
        a { color: inherit; }
        .admin-topbar { background: #fff; border-bottom: 1px solid var(--admin-line); }
        .admin-topbar-inner { width: min(1500px, 100%); min-height: 76px; margin: auto; padding: 12px clamp(16px, 4vw, 56px); display: flex; align-items: center; justify-content: space-between; gap: 20px; }
        .admin-brand { display: inline-flex; align-items: center; gap: 11px; color: var(--admin-green); font-size: 1rem; font-weight: 800; letter-spacing: 1px; text-decoration: none; }
        .admin-brand-mark { width: 42px; height: 42px; display: block; object-fit: contain; border-radius: 12px; background: #fff; }
        .admin-account { display: flex; align-items: center; gap: 14px; }
        .admin-greeting { display: grid; line-height: 1.35; }
        .admin-greeting strong { font-size: .85rem; }
        .admin-greeting span { color: var(--admin-muted); font-size: .72rem; }
        .admin-logout { min-height: 40px; display: inline-flex; align-items: center; gap: 8px; border: 1px solid var(--admin-line); border-radius: 8px; padding: 0 14px; background: #fff; color: var(--admin-ink); font: inherit; font-size: .78rem; font-weight: 700; text-decoration: none; cursor: pointer; }
        .admin-logout:hover { border-color: var(--admin-green); color: var(--admin-green); }
        .admin-nav-wrap { background: #fff; border-bottom: 1px solid var(--admin-line); }
        .admin-nav { width: min(1500px, 100%); margin: auto; padding: 0 clamp(16px, 4vw, 56px); display: flex; gap: 4px; overflow-x: auto; scrollbar-width: thin; }
        .admin-nav a { flex: 0 0 auto; min-height: 48px; display: inline-flex; align-items: center; gap: 8px; padding: 0 13px; border-bottom: 2px solid transparent; color: var(--admin-muted); font-size: .76rem; font-weight: 700; text-decoration: none; white-space: nowrap; }
        .admin-nav a:hover, .admin-nav a.active { border-bottom-color: var(--admin-green); color: var(--admin-green); }
        .admin-main { width: min(1500px, 100%); margin: auto; padding: 28px clamp(16px, 4vw, 56px) 56px; }
        .admin-intro { min-height: 230px; display: grid; grid-template-columns: minmax(0, 1.15fr) minmax(300px, .85fr); margin-bottom: 26px; overflow: hidden; border-radius: 10px; background: #fff; box-shadow: var(--admin-shadow); }
        .admin-intro-copy { padding: clamp(25px, 4vw, 46px); align-self: center; }
        .admin-eyebrow { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 12px; color: var(--admin-green); font-size: .7rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
        .admin-intro h1 { margin: 0 0 10px; font-size: clamp(1.55rem, 2.4vw, 2.25rem); line-height: 1.2; font-weight: 800; }
        .admin-intro p { max-width: 590px; margin: 0; color: var(--admin-muted); font-size: .88rem; }
        .admin-intro-image { position: relative; min-height: 230px; background: var(--admin-green-dark); }
        .admin-intro-image img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
        .admin-intro-image::after { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, rgba(18,63,26,.05), rgba(18,63,26,.5)); }
        .admin-content { min-width: 0; }
        .admin-section-heading { display: flex; align-items: end; justify-content: space-between; gap: 16px; margin: 0 0 15px; }
        .admin-section-heading h2 { margin: 0; font-size: 1.05rem; font-weight: 800; }
        .admin-section-heading p { margin: 3px 0 0; color: var(--admin-muted); font-size: .78rem; }
        .admin-stats { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 12px; margin-bottom: 26px; }
        .admin-stat { min-height: 122px; padding: 17px; border: 1px solid var(--admin-line); border-radius: 8px; background: var(--admin-paper); }
        .admin-stat-top { display: flex; align-items: center; justify-content: space-between; gap: 8px; color: var(--admin-muted); font-size: .72rem; font-weight: 700; }
        .admin-stat-icon { width: 34px; height: 34px; display: grid; place-items: center; border-radius: 8px; background: var(--admin-green-soft); color: var(--admin-green); }
        .admin-stat-value { display: block; margin-top: 8px; font-size: 1.7rem; line-height: 1.2; font-weight: 800; }
        .admin-panel { margin-bottom: 22px; border: 1px solid var(--admin-line); border-radius: 8px; background: var(--admin-paper); overflow: hidden; }
        .admin-panel-head { min-height: 58px; display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px 18px; border-bottom: 1px solid var(--admin-line); }
        .admin-panel-head h2 { margin: 0; display: flex; align-items: center; gap: 9px; font-size: .9rem; font-weight: 800; }
        .admin-panel-body { padding: 18px; }
        .admin-next-appointment { display: flex; align-items: center; gap: 17px; }
        .admin-next-appointment-date { width: 61px; min-height: 68px; display: grid; flex: 0 0 61px; align-content: center; justify-items: center; border: 1px solid var(--admin-line); border-radius: 14px; background: var(--admin-green-soft); color: var(--admin-green); line-height: 1.15; }
        .admin-next-appointment-date span { font-size: .56rem; font-weight: 750; text-transform: uppercase; }
        .admin-next-appointment-date strong { margin: 3px 0; font-size: 1.35rem; }
        .admin-next-appointment-details { display: grid; flex: 1; gap: 5px; min-width: 0; }
        .admin-next-appointment-details>strong { font-size: .84rem; }
        .admin-next-appointment-details>span { overflow-wrap: anywhere; color: var(--admin-muted); font-size: .69rem; }
        .admin-next-appointment-details i { width: 14px; color: var(--admin-green); text-align: center; }
        .admin-table-wrap { overflow-x: auto; }
        .admin-table { width: 100%; border-collapse: collapse; font-size: .78rem; }
        .admin-table th { padding: 11px 14px; background: #f7faf7; color: var(--admin-muted); text-align: left; font-size: .66rem; font-weight: 800; letter-spacing: .5px; text-transform: uppercase; white-space: nowrap; }
        .admin-table td { padding: 12px 14px; border-top: 1px solid #edf1ed; vertical-align: middle; }
        .admin-table tbody tr:hover { background: #fbfdfb; }
        .admin-button { min-height: 38px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: 1px solid var(--admin-line); border-radius: 7px; padding: 0 13px; background: #fff; color: var(--admin-ink); font: inherit; font-size: .75rem; font-weight: 700; text-decoration: none; cursor: pointer; }
        .admin-button:hover { border-color: var(--admin-green); color: var(--admin-green); }
        .admin-button-primary { border-color: var(--admin-green); background: var(--admin-green); color: #fff; }
        .admin-button-primary:hover { background: var(--admin-green-dark); color: #fff; }
        .admin-button-danger { color: #a3342d; }
        .admin-badge { display: inline-flex; align-items: center; border-radius: 20px; padding: 4px 9px; background: #edf6ee; color: var(--admin-green); font-size: .68rem; font-weight: 700; white-space: nowrap; }
        .admin-badge-neutral { background: #f0f2f0; color: #59635a; }
        .admin-badge-warning { background: #fff4dc; color: #855b06; }
        .admin-badge-danger { background: #fff0ee; color: #a3342d; }
        .admin-alert { margin: 0 0 18px; border: 1px solid var(--admin-line); border-radius: 8px; padding: 12px 15px; background: #fff; font-size: .82rem; }
        .admin-alert-success { border-color: #b9dbbd; background: #edf6ee; color: var(--admin-green-dark); }
        .admin-alert-error { border-color: #f3c5c0; background: #fff0ee; color: #a3342d; }
        .admin-form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .admin-field { display: grid; gap: 6px; }
        .admin-field-full { grid-column: 1 / -1; }
        .admin-field label { color: var(--admin-ink); font-size: .74rem; font-weight: 700; }
        .admin-field input, .admin-field select, .admin-field textarea { width: 100%; min-height: 42px; border: 1px solid var(--admin-line); border-radius: 7px; padding: 9px 11px; background: #fff; color: var(--admin-ink); font: inherit; font-size: .8rem; }
        .admin-field textarea { min-height: 110px; resize: vertical; }
        .admin-field input:focus, .admin-field select:focus, .admin-field textarea:focus { outline: 3px solid rgba(27,94,32,.12); border-color: var(--admin-green); }
        .admin-toolbar { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; }
        .admin-filters { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
        .admin-filters input, .admin-filters select { min-height: 38px; border: 1px solid var(--admin-line); border-radius: 7px; padding: 0 10px; background: #fff; font: inherit; font-size: .74rem; }
        .admin-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 7px; }
        .admin-empty { padding: 35px 18px; color: var(--admin-muted); text-align: center; }
        .admin-empty i { display: block; margin-bottom: 9px; color: #91a493; font-size: 1.5rem; }
        .admin-flash { margin-bottom: 18px; }
        .admin-login-link { color: var(--admin-green); font-weight: 700; }
        .admin-auth-error { color: #a3342d; font-size: .72rem; }
        .admin-check { display: inline-flex; align-items: center; gap: 7px; font-size: .78rem; }
        .admin-inline-form { display: inline-flex; align-items: center; gap: 6px; }
        .admin-inline-form select { min-height: 34px; border: 1px solid var(--admin-line); border-radius: 6px; padding: 0 8px; background: #fff; font: inherit; font-size: .7rem; }
        .admin-pager { padding: 15px 18px; border-top: 1px solid var(--admin-line); }
        @media (max-width: 1100px) { .admin-stats { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        @media (max-width: 760px) {
            .admin-topbar-inner { min-height: 66px; }
            .admin-greeting { display: none; }
            .admin-main { padding-top: 18px; }
            .admin-intro { grid-template-columns: 1fr; }
            .admin-intro-image { min-height: 150px; grid-row: 1; }
            .admin-intro-copy { padding: 24px; }
            .admin-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 9px; }
            .admin-stat { min-height: 110px; padding: 13px; }
            .admin-stat-value { font-size: 1.45rem; }
            .admin-form-grid { grid-template-columns: 1fr; }
            .admin-field-full { grid-column: auto; }
            .admin-next-appointment { align-items: flex-start; flex-wrap: wrap; }
            .admin-next-appointment>.admin-badge { margin-left: 78px; }
        }
        @media (max-width: 420px) { .admin-brand { font-size: .83rem; } .admin-brand-mark { width: 36px; height: 36px; } .admin-logout { padding: 0 10px; } .admin-stats { grid-template-columns: 1fr 1fr; } }
    </style>
    @stack('styles')
    @vite('resources/css/public/site-theme.css')
    <style>
        .site-admin { --sidebar-width:clamp(228px,16vw,295px); }
        .site-admin.admin-role-sales { --admin-green:#3d7180; --admin-green-dark:#24434c; --admin-green-soft:#eaf3f4; --admin-ground:#eff4f4; --admin-line:#dce7e8; }
        .site-admin.admin-role-technician { --admin-green:#9a6b27; --admin-green-dark:#5c421f; --admin-green-soft:#f7f0e2; --admin-ground:#f6f3eb; --admin-line:#e9e1d1; }
        .site-admin.admin-role-customer { --admin-green:#487e78; --admin-green-dark:#284b49; --admin-green-soft:#eaf3f1; --admin-ground:#f0f5f3; --admin-line:#dce8e4; }
        .site-admin { min-height:100vh; background:var(--admin-ground); }
        .admin-sidebar { position:fixed; z-index:1200; inset:0 auto 0 0; display:flex; width:var(--sidebar-width); flex-direction:column; gap:0; padding:21px 10px 13px; overflow:hidden; background:var(--admin-green-dark); color:#f5f7f3; box-shadow:8px 0 30px rgba(24,38,28,.08); transition:width .24s ease,transform .24s ease; }
        .admin-sidebar .admin-brand { min-height:48px; display:flex; justify-content:flex-start; gap:9px; margin:0 4px 27px; color:#fff; font-size:.86rem; letter-spacing:.04em; }
        .admin-sidebar .admin-brand-mark { width:37px; height:37px; flex:0 0 37px; border-radius:12px; }
        .admin-brand-name { overflow:hidden; text-overflow:ellipsis; }
        .admin-sidebar-caption { margin:0 10px 9px; color:rgba(255,255,255,.52); font-size:.5rem; font-weight:800; letter-spacing:.12em; white-space:nowrap; }
        .admin-nav { display:grid; align-content:start; gap:5px; min-height:0; padding:0 2px 12px; overflow-x:hidden; overflow-y:auto; scrollbar-color:rgba(255,255,255,.22) transparent; scrollbar-width:thin; }
        .admin-nav a { position:relative; min-width:0; min-height:42px; display:flex; flex:0 0 auto; align-items:center; gap:10px; padding:8px 10px; border:0; border-radius:11px; color:rgba(255,255,255,.73); font-size:.63rem; font-weight:650; line-height:1.35; text-decoration:none; white-space:normal; transition:background .16s ease,color .16s ease,transform .16s ease; }
        .admin-nav a>i { width:17px; flex:0 0 17px; color:rgba(255,255,255,.7); font-size:.79rem; text-align:center; }
        .admin-nav a>span { min-width:0; overflow-wrap:anywhere; }
        .admin-nav a:hover { transform:translateX(2px); background:rgba(255,255,255,.08); color:#fff; }
        .admin-nav a.active { background:rgba(255,255,255,.15); color:#fff; box-shadow:inset 3px 0 #c6d9c8; }
        .admin-nav a.active>i { color:#d5e5d6; }
        .admin-sidebar-account { display:grid; grid-template-columns:31px minmax(0,1fr); align-items:center; gap:8px; margin-top:auto; padding:12px 4px 0; border-top:1px solid rgba(255,255,255,.15); }
        .admin-account-avatar,.admin-topbar-avatar { width:31px; height:31px; display:grid; place-items:center; border-radius:50%; background:rgba(255,255,255,.18); color:#fff; font-size:.72rem; font-weight:800; text-transform:uppercase; }
        .admin-sidebar-user { display:grid; min-width:0; gap:1px; }
        .admin-sidebar-user strong { overflow:hidden; color:#fff; font-size:.57rem; text-overflow:ellipsis; white-space:nowrap; }
        .admin-sidebar-user small { overflow:hidden; color:rgba(255,255,255,.63); font-size:.49rem; text-overflow:ellipsis; white-space:nowrap; }
        .admin-sidebar-account form { grid-column:1/-1; }
        .admin-sidebar .admin-logout { width:100%; min-height:34px; justify-content:flex-start; border:0; border-radius:9px; padding:0 9px; background:rgba(255,255,255,.08); color:#fff; font-size:.62rem; }
        .admin-sidebar .admin-logout:hover { border:0; background:rgba(255,255,255,.16); color:#fff; }
        .admin-workspace { width:calc(100% - var(--sidebar-width)); min-height:100vh; margin-left:var(--sidebar-width); transition:width .24s ease,margin-left .24s ease; }
        .admin-topbar { position:sticky; z-index:1000; top:0; background:rgba(249,250,247,.9); border-bottom:1px solid rgba(220,224,216,.85); backdrop-filter:blur(16px); }
        .admin-topbar-inner { width:100%; min-height:68px; margin:0; padding:10px clamp(16px,2.4vw,36px); }
        .admin-menu-toggle { min-height:39px; display:inline-flex; align-items:center; gap:9px; border:1px solid #e1e4dc; border-radius:11px; padding:0 13px; background:#fff; color:#3e493f; font:inherit; font-size:.71rem; font-weight:750; cursor:pointer; transition:border-color .16s ease,color .16s ease,background .16s ease; }
        .admin-menu-toggle:hover { border-color:var(--admin-green); color:var(--admin-green); }
        .admin-menu-toggle i { color:var(--admin-green); font-size:.82rem; }
        .admin-account { gap:10px; }
        .admin-greeting { text-align:right; }
        .admin-greeting strong { font-size:.72rem; }
        .admin-greeting span { font-size:.61rem; }
        .admin-topbar-avatar { background:var(--admin-green-soft); color:var(--admin-green); }
        .admin-main { width:100%; max-width:none; margin:0; padding:27px clamp(16px,2.4vw,38px) 55px; }
        .admin-sidebar-backdrop { display:none; }
        .site-admin.sidebar-collapsed { --sidebar-width:80px; }
        .sidebar-collapsed .admin-sidebar { padding-right:8px; padding-left:8px; }
        .sidebar-collapsed .admin-sidebar .admin-brand { justify-content:center; margin-right:0; margin-left:0; }
        .sidebar-collapsed .admin-brand-name,.sidebar-collapsed .admin-sidebar-caption,.sidebar-collapsed .admin-nav a>span,.sidebar-collapsed .admin-sidebar-user,.sidebar-collapsed .admin-sidebar-account form .admin-logout span { display:none; }
        .sidebar-collapsed .admin-nav a { justify-content:center; padding:8px 4px; }
        .sidebar-collapsed .admin-nav a>i { width:auto; flex-basis:auto; font-size:.9rem; }
        .sidebar-collapsed .admin-sidebar-account { grid-template-columns:1fr; justify-items:center; }
        .sidebar-collapsed .admin-sidebar-account form { width:100%; }
        .sidebar-collapsed .admin-sidebar .admin-logout { justify-content:center; padding:0; }
        .sidebar-collapsed .admin-sidebar-account form .admin-logout i { margin:0; }
        .site-admin .admin-intro { min-height:218px; border:1px solid rgba(220,224,216,.9); border-radius:20px; box-shadow:0 9px 28px rgba(31,43,33,.06); }
        .site-admin .admin-intro-copy { padding:clamp(24px,3.2vw,40px); }
        .site-admin .admin-intro h1 { letter-spacing:-.04em; }
        .site-admin .admin-intro-image { background:var(--admin-green-dark); }
        .site-admin .admin-intro-image::after { background:linear-gradient(90deg,rgba(18,63,26,.04),rgba(18,63,26,.43)); }
        .site-admin .admin-stats { gap:13px; margin-bottom:22px; }
        .site-admin .admin-stat { border-color:rgba(220,224,216,.9); border-radius:17px; box-shadow:0 6px 20px rgba(31,43,33,.04); transition:transform .18s ease,box-shadow .18s ease; }
        .site-admin .admin-stat:hover { transform:translateY(-2px); box-shadow:0 10px 24px rgba(31,43,33,.075); }
        .site-admin .admin-panel { margin-bottom:20px; border-color:rgba(220,224,216,.9); border-radius:17px; box-shadow:0 7px 22px rgba(31,43,33,.045); }
        .site-admin .admin-panel-head { min-height:61px; padding:13px 19px; background:linear-gradient(180deg,#fff,#fbfcf9); }
        .site-admin .admin-panel-head h2 { font-size:.88rem; letter-spacing:-.015em; }
        .site-admin .admin-panel-body { padding:19px; }
        .site-admin .admin-table { font-size:.75rem; }
        .site-admin .admin-table th { padding:12px 14px; background:#f6f7f3; }
        .site-admin .admin-table td { padding:13px 14px; }
        .site-admin .admin-table tbody tr { transition:background .15s ease; }
        .site-admin .admin-table tbody tr:hover { background:#f8faf6; }
        .site-admin .admin-button { border-radius:10px; transition:transform .15s ease,border-color .15s ease,background .15s ease; }
        .site-admin .admin-button:hover { transform:translateY(-1px); }
        .site-admin .admin-button-primary { border-color:var(--admin-green); background:var(--admin-green); }
        .site-admin .admin-button-primary:hover { border-color:var(--admin-green-dark); background:var(--admin-green-dark); color:#fff; }
        .site-admin .admin-badge { background:var(--admin-green-soft); color:var(--admin-green); }
        .site-admin .admin-badge-neutral { background:#f0f2f0; color:#59635a; }
        .site-admin .admin-field input,.site-admin .admin-field select,.site-admin .admin-field textarea,
        .site-admin .admin-filters input,.site-admin .admin-filters select,.site-admin .admin-inline-form select { border-radius:10px; }
        .site-admin .admin-field input:focus,.site-admin .admin-field select:focus,.site-admin .admin-field textarea:focus { outline-color:rgba(27,94,32,.14); border-color:var(--admin-green); }
        .site-admin .admin-alert { border-radius:13px; }
        body.site-admin .admin-workspace { min-height:100vh; background:#e9eae5; color:#242a24; }
        body.site-admin .admin-workspace :is(.admin-intro,.admin-stat,.admin-panel) {
            border:1px solid #dedfd8;
            border-radius:19px;
            background:#fbfbf8;
            box-shadow:0 8px 26px rgba(34,42,34,.055);
        }
        body.site-admin .admin-workspace .admin-intro { margin-bottom:19px; }
        body.site-admin .admin-workspace .admin-intro-copy { padding:clamp(24px,3vw,38px); }
        body.site-admin .admin-workspace .admin-intro h1,
        body.site-admin .admin-workspace .admin-section-heading h2,
        body.site-admin .admin-workspace .admin-panel-head h2,
        body.site-admin .admin-workspace .admin-stat-value { color:#252b25; }
        body.site-admin .admin-workspace .admin-intro p,
        body.site-admin .admin-workspace .admin-section-heading p { color:#7e867d; }
        body.site-admin .admin-workspace .admin-eyebrow,
        body.site-admin .admin-workspace .admin-login-link { color:var(--admin-green); }
        body.site-admin .admin-workspace .admin-intro-image::after { background:linear-gradient(90deg,rgba(18,38,25,.03),rgba(18,38,25,.42)); }
        body.site-admin .admin-workspace .admin-stat { min-height:126px; padding:17px 18px; }
        body.site-admin .admin-workspace .admin-stat-top { color:#818880; }
        body.site-admin .admin-workspace .admin-stat-icon { border-radius:11px; background:var(--admin-green-soft); color:var(--admin-green); }
        body.site-admin .admin-workspace .admin-panel-head { border-color:#ebebe5; background:linear-gradient(180deg,#fff,#fafaf7); }
        body.site-admin .admin-workspace .admin-panel-body { color:#343b34; }
        body.site-admin .admin-workspace .admin-table { color:#343b34; }
        body.site-admin .admin-workspace .admin-table th { background:#f2f3ee; color:#7b837a; }
        body.site-admin .admin-workspace .admin-table td { border-color:#ecece6; }
        body.site-admin .admin-workspace .admin-table tbody tr:hover { background:#f6f7f2; }
        body.site-admin .admin-workspace :is(.admin-field input,.admin-field select,.admin-field textarea,.admin-filters input,.admin-filters select,.admin-inline-form select) {
            border-color:#dfe1da;
            background:#fff;
            color:#273027;
        }
        body.site-admin .admin-workspace :is(.admin-field label,.admin-check) { color:#3e463f; }
        body.site-admin .admin-workspace :is(.admin-field input,.admin-field select,.admin-field textarea):focus { border-color:var(--admin-green); }
        body.site-admin .admin-workspace .admin-button:not(.admin-button-primary) {
            border-color:#dfe1da;
            background:#fff;
            color:#404940;
        }
        body.site-admin .admin-workspace .admin-button:not(.admin-button-primary):hover { border-color:var(--admin-green); color:var(--admin-green); }
        body.site-admin .admin-workspace .admin-button-primary { color:#fff; }
        body.site-admin .admin-workspace :is(.admin-badge,.admin-badge:not(.admin-badge-neutral):not(.admin-badge-warning):not(.admin-badge-danger)) {
            background:var(--admin-green-soft);
            color:var(--admin-green);
        }
        body.site-admin .admin-workspace .admin-empty { color:#818880; }
        body.site-admin .admin-workspace .admin-pager { border-color:#ebebe5; }
        body.site-admin .admin-workspace .admin-main a:not(.admin-button) { color:var(--admin-green); }
        body.site-admin .admin-workspace .admin-table a { color:var(--admin-green); }
        body.site-admin .admin-workspace .lead-detail-page { color:#252c26; }
        body.site-admin .admin-workspace .lead-detail-hero {
            border-color:#dedfd8;
            background:radial-gradient(ellipse at 85% 20%,rgba(151,177,150,.22),transparent 40%),linear-gradient(125deg,#fff 15%,#f4f5ef 100%);
            box-shadow:0 10px 28px rgba(34,42,34,.055);
        }
        body.site-admin .admin-workspace .lead-detail-hero h1,
        body.site-admin .admin-workspace .lead-detail-card-heading h2,
        body.site-admin .admin-workspace .lead-detail-answer dd,
        body.site-admin .admin-workspace .lead-detail-property-item dd,
        body.site-admin .admin-workspace .lead-detail-address strong { color:#252c26; }
        body.site-admin .admin-workspace .lead-detail-quick-card,
        body.site-admin .admin-workspace .lead-detail-card { border-color:#dedfd8; background:#fbfbf8; box-shadow:0 7px 22px rgba(34,42,34,.045); }
        @media(max-width:1000px) and (min-width:761px) {
            .site-admin { --sidebar-width:94px; }
            .admin-sidebar .admin-brand { justify-content:center; margin-right:0; margin-left:0; }
            .admin-brand-name,.admin-sidebar-caption,.admin-nav a>span,.admin-sidebar-user,.admin-sidebar-account form .admin-logout span { display:none; }
            .admin-nav a { justify-content:center; padding-right:4px; padding-left:4px; }
            .admin-nav a>i { width:auto; flex-basis:auto; font-size:.9rem; }
            .admin-sidebar-account { grid-template-columns:1fr; justify-items:center; }
            .admin-sidebar-account form { width:100%; }
            .admin-sidebar .admin-logout { justify-content:center; padding:0; }
        }
        @media(max-width:760px) {
            .site-admin { --sidebar-width:min(310px,86vw); }
            .admin-sidebar { width:var(--sidebar-width); padding:22px 15px 14px; transform:translateX(-105%); }
            .sidebar-open .admin-sidebar { transform:translateX(0); }
            .admin-sidebar .admin-brand { justify-content:flex-start; margin-right:4px; margin-left:4px; }
            .admin-brand-name,.admin-sidebar-caption,.admin-nav a>span,.admin-sidebar-user,.admin-sidebar-account form .admin-logout span { display:initial; }
            .admin-sidebar-caption { display:block; }
            .admin-nav a { justify-content:flex-start; padding:9px 11px; }
            .admin-nav a>i { width:17px; flex-basis:17px; }
            .admin-sidebar-account { grid-template-columns:31px minmax(0,1fr); justify-items:initial; }
            .admin-sidebar-account form { width:auto; }
            .admin-sidebar .admin-logout { justify-content:flex-start; padding:0 9px; }
            .admin-sidebar-account form .admin-logout span { display:inline; }
            .admin-workspace,.sidebar-collapsed .admin-workspace { width:100%; margin-left:0; }
            .admin-sidebar-backdrop { position:fixed; z-index:1100; inset:0; display:block; width:100%; height:100%; border:0; background:rgba(19,27,21,.45); opacity:0; pointer-events:none; transition:opacity .2s ease; }
            .sidebar-open .admin-sidebar-backdrop { opacity:1; pointer-events:auto; }
            .admin-topbar-inner { min-height:62px; }
            .admin-menu-toggle { min-height:37px; }
            .admin-main { padding:19px 15px 42px; }
            .admin-greeting { display:grid; }
        }
        @media(max-width:420px) {
            .admin-topbar-inner { padding-right:13px; padding-left:13px; }
            .admin-menu-toggle { gap:7px; padding:0 10px; }
            .admin-greeting strong { max-width:130px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
            .admin-account { gap:7px; }
        }
        @media(prefers-reduced-motion:reduce) {
            .admin-sidebar,.admin-workspace,.admin-sidebar-backdrop,.admin-nav a,.admin-button,.admin-stat { transition:none; }
        }
    </style>
</head>
<body class="site-admin admin-role-{{ auth()->user()->role->value }}">
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Menú principal">
        <a class="admin-brand" href="{{ auth()->user()->isCustomer() ? route('customer.dashboard') : (auth()->user()->isTechnician() ? route('admin.appointments.index') : route('admin.dashboard')) }}">
            <img class="admin-brand-mark" src="{{ asset('icons/icon-192.png') }}?v={{ filemtime(public_path('icons/icon-192.png')) }}" alt="" aria-hidden="true" width="42" height="42">
            <span class="admin-brand-name">aislagratis</span>
        </a>
        <span class="admin-sidebar-caption">MENÚ PRINCIPAL</span>
        <nav class="admin-nav" aria-label="Navegación de administración">
            @if(auth()->user()->isCustomer())
                <a href="{{ route('customer.dashboard') }}" title="Resumen" aria-label="Resumen" @class(['active' => request()->routeIs('customer.dashboard')])><i class="fa-solid fa-chart-line"></i><span>Resumen</span></a>
                <a href="{{ route('customer.leads.index') }}" title="Mis solicitudes" aria-label="Mis solicitudes" @class(['active' => request()->routeIs('customer.leads.*')])><i class="fa-solid fa-inbox"></i><span>Mis solicitudes</span></a>
                <a href="{{ route('customer.installations.index') }}" title="Instalaciones" aria-label="Instalaciones" @class(['active' => request()->routeIs('customer.installations.*')])><i class="fa-solid fa-screwdriver-wrench"></i><span>Instalaciones</span></a>
                <a href="{{ route('customer.properties.index') }}" title="Inmuebles" aria-label="Inmuebles" @class(['active' => request()->routeIs('customer.properties.*')])><i class="fa-solid fa-house"></i><span>Inmuebles</span></a>
                <a href="{{ route('customer.reviews.index') }}" title="Opiniones" aria-label="Opiniones" @class(['active' => request()->routeIs('customer.reviews.*')])><i class="fa-solid fa-star"></i><span>Opiniones</span></a>
                <a href="{{ route('customer.profile.edit') }}" title="Mi perfil" aria-label="Mi perfil" @class(['active' => request()->routeIs('customer.profile.*')])><i class="fa-solid fa-user-gear"></i><span>Mi perfil</span></a>
            @else
                @unless(auth()->user()->isTechnician())<a href="{{ route('admin.dashboard') }}" title="Resumen" aria-label="Resumen" @class(['active' => request()->routeIs('admin.dashboard')])><i class="fa-solid fa-chart-line"></i><span>Resumen</span></a>@endunless
                @unless(auth()->user()->isTechnician())<a href="{{ route('admin.leads.index') }}" title="Solicitudes" aria-label="Solicitudes" @class(['active' => request()->routeIs('admin.leads.*')])><i class="fa-solid fa-inbox"></i><span>Solicitudes</span></a>@endunless
                <a href="{{ route('admin.appointments.index') }}" title="{{ auth()->user()->isTechnician() ? 'Mis citas' : 'Citas' }}" aria-label="{{ auth()->user()->isTechnician() ? 'Mis citas' : 'Citas' }}" @class(['active' => request()->routeIs('admin.appointments.*')])><i class="fa-solid fa-calendar-check"></i><span>{{ auth()->user()->isTechnician() ? 'Mis citas' : 'Citas' }}</span></a>
                @unless(auth()->user()->isTechnician())<a href="{{ route('admin.installations.index') }}" title="Instalaciones" aria-label="Instalaciones" @class(['active' => request()->routeIs('admin.installations.*')])><i class="fa-solid fa-screwdriver-wrench"></i><span>Instalaciones</span></a>@endunless
                @if(auth()->user()->role->value === 'admin')
                    <a href="{{ route('admin.users.index') }}" title="Usuarios" aria-label="Usuarios" @class(['active' => request()->routeIs('admin.users.*')])><i class="fa-solid fa-users"></i><span>Usuarios</span></a>
                    <a href="{{ route('admin.services.index') }}" title="Servicios" aria-label="Servicios" @class(['active' => request()->routeIs('admin.services.*')])><i class="fa-solid fa-bolt"></i><span>Servicios</span></a>
                    <a href="{{ route('admin.coverage-areas.index') }}" title="Cobertura" aria-label="Cobertura" @class(['active' => request()->routeIs('admin.coverage-areas.*')])><i class="fa-solid fa-map-location-dot"></i><span>Cobertura</span></a>
                    <a href="{{ route('admin.faqs.index') }}" title="Preguntas" aria-label="Preguntas" @class(['active' => request()->routeIs('admin.faqs.*')])><i class="fa-solid fa-circle-question"></i><span>Preguntas</span></a>
                    <a href="{{ route('admin.partners.index') }}" title="Partners" aria-label="Partners" @class(['active' => request()->routeIs('admin.partners.*')])><i class="fa-solid fa-handshake"></i><span>Partners</span></a>
                    <a href="{{ route('admin.reports.index') }}" title="Informes" aria-label="Informes" @class(['active' => request()->routeIs('admin.reports.*')])><i class="fa-solid fa-chart-pie"></i><span>Informes</span></a>
                    <a href="{{ route('admin.cookie-consents.index') }}" title="Cookies" aria-label="Cookies" @class(['active' => request()->routeIs('admin.cookie-consents.*')])><i class="fa-solid fa-cookie-bite"></i><span>Cookies</span></a>
                @endif
                <a href="{{ route('admin.notifications.index') }}" title="Avisos" aria-label="Avisos" @class(['active' => request()->routeIs('admin.notifications.*')])><i class="fa-solid fa-bell"></i><span>Avisos</span></a>
            @endif
        </nav>
        <div class="admin-sidebar-account">
            <span class="admin-account-avatar">{{ mb_substr(auth()->user()->first_name, 0, 1) }}</span>
            <span class="admin-sidebar-user"><strong>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</strong><small>{{ match(auth()->user()->role->value) { 'admin' => 'Administración', 'sales' => 'Equipo comercial', 'technician' => 'Equipo técnico', default => 'Área de cliente' } }}</small></span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="admin-logout" type="submit" title="Salir" aria-label="Cerrar sesión"><i class="fa-solid fa-arrow-right-from-bracket"></i><span>Salir</span></button>
            </form>
        </div>
    </aside>
    <button class="admin-sidebar-backdrop" type="button" aria-label="Cerrar menú" tabindex="-1"></button>
    <div class="admin-workspace">
        <header class="admin-topbar">
            <div class="admin-topbar-inner">
                <button class="admin-menu-toggle" type="button" aria-controls="adminSidebar" aria-expanded="true" aria-label="Cerrar menú">
                    <i class="fa-solid fa-bars" aria-hidden="true"></i><span>Menu</span>
                </button>
                <div class="admin-account">
                    <div class="admin-greeting">
                        <strong>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</strong>
                        <span>{{ match(auth()->user()->role->value) { 'admin' => 'Administración', 'sales' => 'Equipo comercial', 'technician' => 'Equipo técnico', default => 'Área de cliente' } }}</span>
                    </div>
                    <span class="admin-topbar-avatar">{{ mb_substr(auth()->user()->first_name, 0, 1) }}</span>
                </div>
            </div>
        </header>
        <main class="admin-main">
            @if(session('success')) <div class="admin-alert admin-alert-success admin-flash" role="status">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="admin-alert admin-alert-error admin-flash" role="alert">{{ session('error') }}</div> @endif
            @if($errors->any())
                <div class="admin-alert admin-alert-error admin-flash" role="alert">
                    <strong>Revisa los datos:</strong>
                    <ul style="margin:6px 0 0;padding-left:20px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    <script>
        (() => {
            const body = document.body;
            const toggle = document.querySelector('.admin-menu-toggle');
            const backdrop = document.querySelector('.admin-sidebar-backdrop');
            const sidebarLinks = document.querySelectorAll('.admin-nav a');
            const mobileQuery = window.matchMedia('(max-width: 760px)');

            if (!toggle || !backdrop) return;

            const setExpanded = (expanded) => {
                body.classList.toggle('sidebar-open', expanded && mobileQuery.matches);
                body.classList.toggle('sidebar-collapsed', !expanded && !mobileQuery.matches);
                toggle.setAttribute('aria-expanded', String(expanded));
                toggle.setAttribute('aria-label', expanded ? 'Cerrar menú' : 'Abrir menú');
            };

            setExpanded(!mobileQuery.matches);

            toggle.addEventListener('click', () => {
                const isOpen = mobileQuery.matches
                    ? body.classList.contains('sidebar-open')
                    : !body.classList.contains('sidebar-collapsed');
                setExpanded(!isOpen);
            });

            backdrop.addEventListener('click', () => setExpanded(false));
            sidebarLinks.forEach((link) => link.addEventListener('click', () => {
                if (mobileQuery.matches) setExpanded(false);
            }));

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && body.classList.contains('sidebar-open')) {
                    setExpanded(false);
                    toggle.focus();
                }
            });

            mobileQuery.addEventListener('change', (event) => {
                body.classList.remove('sidebar-open', 'sidebar-collapsed');
                toggle.setAttribute('aria-expanded', String(!event.matches));
                toggle.setAttribute('aria-label', event.matches ? 'Abrir menú' : 'Cerrar menú');
            });
        })();
    </script>
</body>
</html>