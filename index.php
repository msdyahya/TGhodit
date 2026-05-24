<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=yes">
    <title>TGhodit | منصة تواصل اجتماعي فاخرة</title>
    <meta name="description" content="TGhodit - منصة تواصل اجتماعي عصرية">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }
        
        html { font-size: 16px; scroll-behavior: smooth; }
        
        body {
            font-family: 'Cairo', 'Segoe UI', sans-serif;
            background: #0a0a0a;
            color: #eef2ff;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }
        
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #1a1a1a; }
        ::-webkit-scrollbar-thumb { background: #F59E0B; border-radius: 10px; }
        
        :root {
            --gold: #F59E0B;
            --gold-dark: #D97706;
            --gold-light: #fbbf24;
            --bg-dark: #0a0a0a;
            --bg-card: #111111;
            --bg-card-hover: #1a1a1a;
            --text-primary: #f1f5f9;
            --text-secondary: #9ca3af;
            --border: #222222;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.3);
            --shadow-md: 0 4px 20px rgba(0,0,0,0.4);
            --shadow-lg: 0 8px 30px rgba(0,0,0,0.5);
            --transition: all 0.2s cubic-bezier(0.4,0,0.2,1);
            --border-radius-card: 1.5rem;
            --border-radius-btn: 2rem;
            --border-radius-img: 12px;
        }
        
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }
        .bg-animation span {
            position: absolute;
            width: calc(8px + 12 * var(--i, 1));
            height: calc(8px + 12 * var(--i, 1));
            background: rgba(245, 158, 11, 0.03);
            border-radius: 50%;
            animation: floatBg 20s infinite linear;
            animation-delay: calc(var(--i, 1) * -2s);
        }
        @keyframes floatBg {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.4; }
            90% { opacity: 0.4; }
            100% { transform: translateY(-20vh) rotate(360deg); opacity: 0; }
        }
        
        .app-wrapper { display: flex; position: relative; z-index: 2; min-height: 100vh; }
        
        /* ========== البانر الجانبي ========== */
        .sidebar-banner {
            width: 280px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(16px);
            border-left: 1px solid rgba(245, 158, 11, 0.2);
            padding: 1.5rem 0;
            position: fixed;
            right: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 50;
            box-shadow: -5px 0 30px rgba(0,0,0,0.4);
        }
        .sidebar-banner::-webkit-scrollbar { width: 3px; }
        .sidebar-banner.hidden { right: -280px; }
        
        .hide-banner-btn {
            background: rgba(245,158,11,0.1);
            border: 1px solid rgba(245,158,11,0.2);
            padding: 0.7rem;
            margin: 0.5rem 1.2rem;
            border-radius: var(--border-radius-btn);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            font-size: 0.8rem;
            transition: var(--transition);
            width: calc(100% - 2.4rem);
        }
        .hide-banner-btn:hover { background: rgba(245,158,11,0.2); border-color: var(--gold); color: var(--gold); }
        
        .show-banner-fab {
            position: fixed;
            right: 1rem;
            top: 1rem;
            width: 2.8rem;
            height: 2.8rem;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 60;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            opacity: 0;
            visibility: hidden;
            transform: scale(0.8);
            border: none;
        }
        .show-banner-fab.visible { opacity: 1; visibility: visible; transform: scale(1); }
        .show-banner-fab:hover { transform: scale(1.05); background: linear-gradient(135deg, var(--gold-light), var(--gold)); }
        .show-banner-fab i { font-size: 1.2rem; color: #0a0a0a; }
        
        .banner-header {
            text-align: center;
            padding: 0 1.5rem 1.5rem;
            border-bottom: 2px solid var(--gold);
            margin-bottom: 1.5rem;
        }
        .banner-header h3 {
            font-size: 1.4rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff, var(--gold));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .banner-header p { font-size: 0.7rem; color: var(--text-secondary); margin-top: 0.3rem; }
        
        .banner-nav { margin-top: 1.5rem; }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.75rem 1.5rem;
            margin: 0.3rem 0.8rem;
            border-radius: 0.9rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
            font-size: 0.95rem;
        }
        .nav-item i { width: 1.5rem; font-size: 1.1rem; }
        .nav-item:hover { background: rgba(245,158,11,0.1); color: var(--gold); transform: translateX(-4px); }
        .nav-item.active {
            background: linear-gradient(95deg, var(--gold), var(--gold-dark));
            color: #0a0a0a;
            box-shadow: var(--shadow-sm);
        }
        .nav-item.active i { color: #0a0a0a; }
        
        /* ========== المحتوى الرئيسي ========== */
        .main-content {
            flex: 1;
            margin-right: 280px;
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            transition: var(--transition);
        }
        .main-content.expanded { margin-right: 0; }
        .content-container { max-width: 900px; width: 100%; margin: 0 auto; }
        
        .hero-section { text-align: center; margin-bottom: 2rem; }
        .hero-section h1 {
            font-size: clamp(1.6rem, 5vw, 2.2rem);
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff, var(--gold), var(--gold-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }
        .hero-section h1 i { background: none; color: var(--gold); }
        .glow-text { display: flex; justify-content: center; gap: 0.6rem; flex-wrap: wrap; margin-top: 0.8rem; }
        .badge {
            background: rgba(245,158,11,0.1);
            padding: 0.4rem 1.2rem;
            border-radius: 2rem;
            font-size: 0.7rem;
            font-weight: 500;
            border: 1px solid rgba(245,158,11,0.2);
        }
        
        /* صفحة الخصوصية */
        .privacy-card {
            background: var(--bg-card);
            border-radius: var(--border-radius-card);
            padding: 2rem;
            border: 1px solid var(--border);
        }
        .privacy-section {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }
        .privacy-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .privacy-section h3 {
            color: var(--gold);
            font-size: 1.3rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .privacy-section p {
            line-height: 1.8;
            color: var(--text-secondary);
            margin-bottom: 0.8rem;
        }
        .privacy-section ul {
            padding-right: 1.5rem;
            margin: 0.8rem 0;
        }
        .privacy-section li {
            line-height: 1.8;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }
        .privacy-highlight {
            background: rgba(245,158,11,0.1);
            border-right: 3px solid var(--gold);
            padding: 1rem;
            border-radius: 1rem;
            margin: 1rem 0;
        }
        
        .search-bar {
            background: var(--bg-card);
            border-radius: 3rem;
            display: flex;
            align-items: center;
            padding: 0.3rem 1.2rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border);
            transition: var(--transition);
        }
        .search-bar:focus-within { border-color: var(--gold); box-shadow: 0 0 0 2px rgba(245,158,11,0.15); }
        .search-bar i { color: var(--text-secondary); font-size: 0.9rem; }
        .search-bar input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 0.8rem 0.8rem;
            color: var(--text-primary);
            outline: none;
            font-size: 0.9rem;
            font-family: 'Cairo', sans-serif;
        }
        
        .status-card {
            background: var(--bg-card);
            border-radius: 3rem;
            padding: 0.6rem 1.2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            border: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .status-info { display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; }
        .refresh-btn {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 2rem;
            font-weight: 700;
            font-size: 0.8rem;
            color: #0a0a0a;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }
        .refresh-btn:hover { transform: scale(1.02); box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
        
        .posts-grid { display: flex; flex-direction: column; gap: 1.2rem; }
        
        .post-card {
            background: var(--bg-card);
            border-radius: var(--border-radius-card);
            padding: 1.2rem;
            transition: var(--transition);
            border: 1px solid var(--border);
            cursor: pointer;
        }
        .post-card:hover { border-color: var(--gold); transform: translateY(-2px); background: var(--bg-card-hover); box-shadow: var(--shadow-lg); }
        
        .post-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 0.8rem;
        }
        .avatar {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #0a0a0a;
            flex-shrink: 0;
        }
        .post-info { flex: 1; }
        .post-author {
            font-weight: 700;
            color: var(--gold);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            flex-wrap: wrap;
            font-size: 0.9rem;
        }
        .admin-badge {
            background: rgba(245,158,11,0.15);
            padding: 0.15rem 0.6rem;
            border-radius: 1rem;
            font-size: 0.55rem;
            font-weight: 500;
        }
        .post-time { font-size: 0.6rem; color: var(--text-secondary); }
        .icon-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 0.9rem;
            padding: 0.4rem;
            border-radius: 50%;
            transition: var(--transition);
        }
        .icon-btn:hover { background: rgba(245,158,11,0.1); color: var(--gold); }
        
        .post-content { margin-bottom: 0.8rem; }
        .post-text { line-height: 1.65; font-size: 0.9rem; color: var(--text-primary); word-break: break-word; }
        .read-more-btn {
            background: none;
            border: none;
            color: var(--gold);
            font-size: 0.75rem;
            cursor: pointer;
            margin-top: 0.5rem;
            padding: 0.25rem 0.8rem;
            border-radius: 1.5rem;
            transition: var(--transition);
        }
        .read-more-btn:hover { background: rgba(245,158,11,0.1); color: var(--gold-light); }
        
        .post-image {
            margin-top: 0.8rem;
            border-radius: var(--border-radius-img);
            overflow: hidden;
            max-width: 100%;
        }
        .post-image img {
            width: 100%;
            max-height: 300px;
            object-fit: contain;
            border-radius: var(--border-radius-img);
            cursor: pointer;
            background: #0f0f0f;
            transition: var(--transition);
        }
        .post-image img:hover { transform: scale(1.01); }
        
        .post-actions {
            display: flex;
            gap: 1.5rem;
            margin-top: 0.8rem;
            padding-top: 0.8rem;
            border-top: 1px solid var(--border);
        }
        .action-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 2rem;
            transition: var(--transition);
        }
        .action-btn:hover { background: rgba(245,158,11,0.1); color: var(--gold); }
        .action-btn.liked { color: #ef4444; }
        .action-btn.saved { color: var(--gold); }
        
        /* ========== الصفحات ========== */
        .page { display: none; animation: fadeInPage 0.3s ease; }
        .page.active { display: block; }
        @keyframes fadeInPage { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        .create-post-page, .contact-card, .about-card, .settings-card {
            background: var(--bg-card);
            border-radius: var(--border-radius-card);
            padding: 1.8rem;
            border: 1px solid var(--border);
        }
        .create-form, .contact-form { display: flex; flex-direction: column; gap: 1rem; }
        .create-post-page input, .create-post-page textarea,
        .contact-card input, .contact-card textarea {
            background: #0f0f0f;
            border: 1px solid var(--border);
            border-radius: 1.2rem;
            padding: 0.9rem 1.2rem;
            color: var(--text-primary);
            font-size: 0.9rem;
            outline: none;
            transition: var(--transition);
            font-family: 'Cairo', sans-serif;
        }
        .create-post-page input:focus, .create-post-page textarea:focus,
        .contact-card input:focus, .contact-card textarea:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 2px rgba(245,158,11,0.15);
        }
        .create-post-page textarea, .contact-card textarea { min-height: 150px; resize: vertical; }
        
        .submit-btn {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border: none;
            padding: 0.8rem;
            border-radius: 2rem;
            font-weight: 700;
            font-size: 0.9rem;
            color: #0a0a0a;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            transition: var(--transition);
        }
        .submit-btn:hover { transform: scale(1.02); box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
        
        .about-card p { line-height: 1.8; margin-bottom: 1rem; color: var(--text-secondary); }
        .about-card h3 { color: var(--gold); margin-bottom: 0.5rem; }
        
        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
        }
        .setting-item:last-child { border-bottom: none; }
        .toggle-switch {
            width: 50px;
            height: 26px;
            background: #222;
            border-radius: 30px;
            position: relative;
            cursor: pointer;
            transition: var(--transition);
        }
        .toggle-switch.active { background: var(--gold); }
        .toggle-switch .knob {
            width: 22px;
            height: 22px;
            background: white;
            border-radius: 50%;
            position: absolute;
            top: 2px;
            right: 3px;
            transition: var(--transition);
        }
        .toggle-switch.active .knob { right: 25px; }
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.95);
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: 0.25s ease;
            z-index: 1000;
        }
        .modal-overlay.open { opacity: 1; visibility: visible; }
        .modal-content {
            background: var(--bg-card);
            border-radius: 1.8rem;
            max-width: 550px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            padding: 1.5rem;
            border: 1px solid var(--gold);
            box-shadow: var(--shadow-lg);
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .close-modal {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
        }
        .close-modal:hover { color: var(--gold); transform: rotate(90deg); }
        
        .toast {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            background: #1a1a1a;
            border-right: 4px solid var(--gold);
            padding: 0.8rem 1.2rem;
            border-radius: 1rem;
            z-index: 1100;
            animation: slideInToast 0.3s ease;
            box-shadow: var(--shadow-md);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        @keyframes slideInToast { from { transform: translateX(100px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        
        .spinner {
            width: 3rem;
            height: 3rem;
            border: 3px solid #222;
            border-top-color: var(--gold);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 2rem auto;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        
        footer {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            font-size: 0.7rem;
            color: var(--text-secondary);
            border-top: 1px solid var(--border);
        }
        
        @media (max-width: 1024px) {
            .content-container { max-width: 800px; }
        }
        
        @media (max-width: 768px) {
            .sidebar-banner { right: -280px; }
            .sidebar-banner.open-mobile { right: 0; }
            .main-content { margin-right: 0; padding: 1rem; }
            .show-banner-fab { display: flex; }
            .post-card { padding: 1rem; }
            .avatar { width: 2.5rem; height: 2.5rem; font-size: 1rem; }
            .post-actions { gap: 0.8rem; }
            .action-btn span { display: none; }
            .action-btn { padding: 0.4rem; }
            .hero-section h1 { font-size: 1.5rem; }
            .privacy-card { padding: 1.2rem; }
            .privacy-section h3 { font-size: 1.1rem; }
        }
        
        @media (max-width: 480px) {
            .badge { padding: 0.3rem 0.8rem; font-size: 0.6rem; }
            .status-card { flex-direction: column; align-items: stretch; text-align: center; }
            .refresh-btn { justify-content: center; }
            .create-post-page, .contact-card, .about-card, .settings-card, .privacy-card { padding: 1rem; }
            .privacy-section h3 { font-size: 1rem; }
            .privacy-section p, .privacy-section li { font-size: 0.85rem; }
        }
        
        .clear-storage-btn {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
            margin-top: 1rem;
        }
        .clear-storage-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #ef4444;
            color: #ef4444;
        }
    </style>
</head>
<body>

<div class="bg-animation" id="bgAnimation"></div>

<button class="show-banner-fab" id="showBannerFab" aria-label="إظهار القائمة">
    <i class="fas fa-chevron-right"></i>
</button>

<div class="app-wrapper">
    <aside class="sidebar-banner" id="sidebarBanner">
        <div class="banner-header">
            <h3><i class="fas fa-ghost"></i> TGhodit</h3>
            <p>منصة تواصل فاخرة</p>
        </div>
        <button class="hide-banner-btn" id="hideBannerBtn">
            <i class="fas fa-chevron-left"></i> إخفاء القائمة
        </button>
        <nav class="banner-nav">
            <div class="nav-item active" data-page="home"><i class="fas fa-home"></i> الرئيسية</div>
            <div class="nav-item" data-page="create"><i class="fas fa-feather-alt"></i> إنشاء منشور</div>
            <div class="nav-item" data-page="contact"><i class="fas fa-envelope"></i> تواصل معنا</div>
            <div class="nav-item" data-page="privacy"><i class="fas fa-shield-alt"></i> الخصوصية</div>
            <div class="nav-item" data-page="about"><i class="fas fa-info-circle"></i> من نحن</div>
            <div class="nav-item" data-page="settings"><i class="fas fa-sliders-h"></i> الإعدادات</div>
        </nav>
    </aside>
    
    <main class="main-content" id="mainContent">
        <div class="content-container">
            <!-- الصفحة الرئيسية -->
            <div id="homePage" class="page active">
                <div class="hero-section">
                    <h1><i class="fas fa-ghost"></i> TGhodit</h1>
                    <div class="glow-text">
                        <span class="badge"><i class="fas fa-bolt"></i> تفاعل فوري</span>
                        <span class="badge"><i class="fas fa-shield-alt"></i> آمن ومحمي</span>
                        <span class="badge"><i class="fas fa-save"></i> حفظ تلقائي دائم</span>
                    </div>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="ابحث في المنشورات...">
                </div>
                <div class="status-card">
                    <div class="status-info">
                        <i class="fas fa-crown" style="color: var(--gold);"></i>
                        <span id="statusMessage">جلب المنشورات...</span>
                    </div>
                    <button class="refresh-btn" id="refreshButton">
                        <i class="fas fa-sync-alt"></i> تحديث يدوي
                    </button>
                </div>
                <div id="postsContainer"><div class="spinner"></div></div>
            </div>
            
            <!-- صفحة إنشاء منشور -->
            <div id="createPage" class="page">
                <div class="hero-section">
                    <h1><i class="fas fa-feather-alt"></i> إنشاء منشور جديد</h1>
                </div>
                <div class="create-post-page">
                    <form id="createPostFormPage" class="create-form">
                        <input type="text" id="postTitlePage" placeholder="العنوان (اختياري)">
                        <textarea id="postTextPage" placeholder="محتوى المنشور..." required></textarea>
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i> نشر المنشور
                        </button>
                    </form>
                    <div id="createResultPage" style="margin-top: 1rem; text-align: center;"></div>
                </div>
            </div>
            
            <!-- صفحة تواصل معنا -->
            <div id="contactPage" class="page">
                <div class="hero-section"><h1><i class="fas fa-headset"></i> تواصل معنا</h1></div>
                <div class="contact-card">
                    <form id="contactForm" class="contact-form">
                        <input type="text" id="contactName" placeholder="الاسم الكامل" required autocomplete="name">
                        <input type="email" id="contactEmail" placeholder="البريد الإلكتروني" required autocomplete="email">
                        <textarea id="contactMsg" placeholder="رسالتك..." required></textarea>
                        <button type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i> إرسال</button>
                    </form>
                    <div id="contactResult" style="margin-top:1rem; text-align:center;"></div>
                </div>
            </div>
            
            <!-- صفحة الخصوصية -->
            <div id="privacyPage" class="page">
                <div class="hero-section">
                    <h1><i class="fas fa-shield-alt"></i> سياسة الخصوصية</h1>
                    <div class="glow-text">
                        <span class="badge"><i class="fas fa-lock"></i> خصوصية تامة</span>
                        <span class="badge"><i class="fas fa-database"></i> بيانات مشفرة</span>
                        <span class="badge"><i class="fas fa-user-secret"></i> هوية محمية</span>
                    </div>
                </div>
                <div class="privacy-card">
                    <div class="privacy-section">
                        <h3><i class="fas fa-info-circle"></i> جمع المعلومات</h3>
                        <p>نحن في <strong>TGhodit</strong> نلتزم بحماية خصوصية مستخدمينا. يتم جمع المعلومات التالية تلقائياً عند استخدام المنصة:</p>
                        <ul>
                            <li><i class="fas fa-globe" style="color: var(--gold); margin-left: 0.5rem;"></i> عنوان IP الخاص بك (لأغراض أمنية فقط)</li>
                            <li><i class="fas fa-desktop" style="color: var(--gold); margin-left: 0.5rem;"></i> نوع المتصفح ونظام التشغيل</li>
                            <li><i class="fas fa-mobile-alt" style="color: var(--gold); margin-left: 0.5rem;"></i> نوع الجهاز (هاتف / جهاز لوحي / حاسوب)</li>
                            <li><i class="fas fa-language" style="color: var(--gold); margin-left: 0.5rem;"></i> اللغة والمنطقة الزمنية</li>
                            <li><i class="fas fa-chart-line" style="color: var(--gold); margin-left: 0.5rem;"></i> سلوك التصفح داخل المنصة</li>
                        </ul>
                    </div>
                    
                    <div class="privacy-section">
                        <h3><i class="fas fa-shield-alt"></i> استخدام المعلومات</h3>
                        <p>يتم استخدام المعلومات المجمعة للأغراض التالية فقط:</p>
                        <ul>
                            <li><i class="fas fa-shield-virus" style="color: var(--gold); margin-left: 0.5rem;"></i> حماية المنصة من الهجمات والاختراقات</li>
                            <li><i class="fas fa-chart-simple" style="color: var(--gold); margin-left: 0.5rem;"></i> تحسين أداء الموقع وتجربة المستخدم</li>
                            <li><i class="fas fa-ban" style="color: var(--gold); margin-left: 0.5rem;"></i> منع المحتوى المسيء والسلوك غير القانوني</li>
                            <li><i class="fas fa-crown" style="color: var(--gold); margin-left: 0.5rem;"></i> تطوير الميزات والخدمات</li>
                        </ul>
                        <div class="privacy-highlight">
                            <i class="fas fa-check-circle" style="color: var(--gold);"></i> <strong>ملاحظة مهمة:</strong> نحن لا نبيع أو نشارك معلوماتك الشخصية مع أي طرف ثالث تحت أي ظرف.
                        </div>
                    </div>
                    
                    <div class="privacy-section">
                        <h3><i class="fas fa-store"></i> ملفات تعريف الارتباط (Cookies)</h3>
                        <p>يستخدم موقعنا ملفات تعريف الارتباط لتحسين تجربة التصفح. هذه الملفات لا تحتوي على معلومات شخصية ولا يمكن استخدامها للتعرف عليك خارج المنصة.</p>
                        <ul>
                            <li><i class="fas fa-bookmark" style="color: var(--gold); margin-left: 0.5rem;"></i> تذكر تفضيلاتك (مثل إعدادات الموسيقى)</li>
                            <li><i class="fas fa-history" style="color: var(--gold); margin-left: 0.5rem;"></i> تتبع المنشورات المحفوظة</li>
                            <li><i class="fas fa-heart" style="color: var(--gold); margin-left: 0.5rem;"></i> تسجيل التفاعلات (الإعجابات)</li>
                        </ul>
                    </div>
                    
                    <div class="privacy-section">
                        <h3><i class="fas fa-user-secret"></i> خصوصية المنشورات</h3>
                        <p>عند إنشاء منشور أو إرسال رسالة عبر نموذج التواصل:</p>
                        <ul>
                            <li><i class="fas fa-eye-slash" style="color: var(--gold); margin-left: 0.5rem;"></i> هويتك الحقيقية لا تظهر للمستخدمين الآخرين</li>
                            <li><i class="fas fa-clock" style="color: var(--gold); margin-left: 0.5rem;"></i> يتم مراجعة المحتوى قبل النشر (للمنشورات)</li>
                            <li><i class="fas fa-reply-all" style="color: var(--gold); margin-left: 0.5rem;"></i> سيتم الرد عليك عبر البريد الإلكتروني خلال 24 ساعة</li>
                        </ul>
                    </div>
                    
                    <div class="privacy-section">
                        <h3><i class="fas fa-gavel"></i> حقوق المستخدم</h3>
                        <p>لديك الحق في:</p>
                        <ul>
                            <li><i class="fas fa-trash-alt" style="color: var(--gold); margin-left: 0.5rem;"></i> طلب حذف بياناتك الشخصية</li>
                            <li><i class="fas fa-download" style="color: var(--gold); margin-left: 0.5rem;"></i> طلب نسخة من البيانات المخزنة عنك</li>
                            <li><i class="fas fa-envelope" style="color: var(--gold); margin-left: 0.5rem;"></i> التواصل مع إدارة الموقع لأي استفسار</li>
                        </ul>
                    </div>
                    
                    <div class="privacy-section">
                        <h3><i class="fas fa-calendar-week"></i> تحديثات السياسة</h3>
                        <p>قد نقوم بتحديث سياسة الخصوصية من وقت لآخر. سيتم إعلامك بأي تغييرات جوهرية عبر إشعار داخل المنصة.</p>
                        <p class="privacy-highlight" style="margin-top: 1rem;">
                            <i class="fas fa-calendar-alt" style="color: var(--gold);"></i> آخر تحديث: <strong>24 مايو 2025</strong>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- صفحة من نحن -->
            <div id="aboutPage" class="page">
                <div class="hero-section"><h1><i class="fas fa-users"></i> من نحن</h1></div>
                <div class="about-card">
                    <h3><i class="fas fa-ghost"></i> TGhodit</h3>
                    <p>منصة تواصل اجتماعي عصرية تهدف إلى ربط المستخدمين بمحتوى فريد من قنوات تيليغرام بشكل مباشر وفاخر.</p>
                    <p>نقدم تجربة سلسة خالية من التعقيدات مع أحدث التقنيات وتصميم مستوحى من كبرى المنصات العالمية.</p>
                    <p><strong style="color: var(--gold);">🚀 فريق التطوير:</strong> The Ghost Team</p>
                    <p><strong style="color: var(--gold);">📧 للتواصل:</strong> admin@tghodit.com</p>
                </div>
            </div>
            
            <!-- صفحة الإعدادات -->
            <div id="settingsPage" class="page">
                <div class="hero-section"><h1><i class="fas fa-cog"></i> الإعدادات</h1></div>
                <div class="settings-card">
                    <div class="setting-item">
                        <span><i class="fas fa-music"></i> موسيقى الخلفية</span>
                        <div class="toggle-switch" id="musicToggle"><div class="knob"></div></div>
                    </div>
                    <div class="setting-item">
                        <span><i class="fas fa-palette"></i> الوضع المظلم</span>
                        <span style="color: var(--gold);"><i class="fas fa-check-circle"></i> مفعل دائماً</span>
                    </div>
                    <div class="setting-item">
                        <button id="clearCacheBtn" class="submit-btn clear-storage-btn" style="width: 100%; background: rgba(239,68,68,0.1); color: #ef4444;">
                            <i class="fas fa-trash-alt"></i> مسح التخزين المؤقت للمنشورات
                        </button>
                    </div>
                </div>
            </div>
            
            <footer><i class="fas fa-crown"></i> TGhodit 2025 · جميع الحقوق محفوظة</footer>
        </div>
    </main>
</div>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-file-alt" style="color: var(--gold);"></i> النص الكامل</h3>
            <button class="close-modal" id="closeModalBtn">&times;</button>
        </div>
        <div id="modalBody"></div>
        <div id="modalImageFull" style="margin-top:1rem;"></div>
    </div>
</div>

<script>
    // =============== ثوابت البوتات ===============
    const BOT_TOKEN = "8901733084:AAH9icgp3Q7krjOomq0jiVU5VQh0zcPkY_g";
    const CHAT_ID = "-1003963074157";
    const CONTACT_BOT = "8920328815:AAEOP0sR3Jc98i0osmfnh9t21m3WGusW2FA";
    const CONTACT_CHAT = "8416078700";
    const STORAGE_KEY = "tghodit_posts";
    const LIKES_KEY = "tghodit_likes";
    const SAVES_KEY = "tghodit_saves";
    
    // =============== متغيرات التطبيق ===============
    let allPosts = [], filteredPosts = [];
    let likesMap = new Map(), savesMap = new Map();
    
    // =============== عناصر DOM ===============
    const sidebarBanner = document.getElementById('sidebarBanner');
    const hideBannerBtn = document.getElementById('hideBannerBtn');
    const showBannerFab = document.getElementById('showBannerFab');
    const mainContent = document.getElementById('mainContent');
    const refreshBtn = document.getElementById('refreshButton');
    const statusSpan = document.getElementById('statusMessage');
    const postsContainer = document.getElementById('postsContainer');
    const searchInput = document.getElementById('searchInput');
    const modalOverlay = document.getElementById('modalOverlay');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const musicToggle = document.getElementById('musicToggle');
    const clearCacheBtn = document.getElementById('clearCacheBtn');
    
    // =============== حفظ البيانات محلياً ===============
    function savePostsToLocal() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(allPosts));
        } catch(e) { console.warn("Failed to save posts", e); }
    }
    
    function loadPostsFromLocal() {
        const saved = localStorage.getItem(STORAGE_KEY);
        if (saved) {
            try {
                allPosts = JSON.parse(saved);
                return true;
            } catch(e) {}
        }
        return false;
    }
    
    function saveLikesToLocal() {
        const likesObj = {};
        for (let [id, data] of likesMap) {
            likesObj[id] = data;
        }
        localStorage.setItem(LIKES_KEY, JSON.stringify(likesObj));
    }
    
    function loadLikesFromLocal() {
        const saved = localStorage.getItem(LIKES_KEY);
        if (saved) {
            try {
                const likesObj = JSON.parse(saved);
                for (let [id, data] of Object.entries(likesObj)) {
                    likesMap.set(parseInt(id), data);
                }
                return true;
            } catch(e) {}
        }
        return false;
    }
    
    function saveSavesToLocal() {
        const savesObj = {};
        for (let [id, saved] of savesMap) {
            savesObj[id] = saved;
        }
        localStorage.setItem(SAVES_KEY, JSON.stringify(savesObj));
    }
    
    function loadSavesFromLocal() {
        const saved = localStorage.getItem(SAVES_KEY);
        if (saved) {
            try {
                const savesObj = JSON.parse(saved);
                for (let [id, savedFlag] of Object.entries(savesObj)) {
                    savesMap.set(parseInt(id), savedFlag);
                }
                return true;
            } catch(e) {}
        }
        return false;
    }
    
    // =============== دمج المنشورات الجديدة مع القديمة ===============
    function mergePosts(newPosts) {
        // إنشاء Map للمنشورات الموجودة حسب id
        const existingMap = new Map();
        for (const post of allPosts) {
            existingMap.set(post.id, post);
        }
        
        let addedCount = 0;
        // إضافة المنشورات الجديدة أو تحديث الموجودة
        for (const newPost of newPosts) {
            if (!existingMap.has(newPost.id)) {
                existingMap.set(newPost.id, newPost);
                addedCount++;
                // تهيئة بيانات الإعجابات والحفظ للمنشور الجديد
                if (!likesMap.has(newPost.id)) {
                    likesMap.set(newPost.id, { count: 0, liked: false });
                }
                if (!savesMap.has(newPost.id)) {
                    savesMap.set(newPost.id, false);
                }
            } else {
                // تحديث الصورة إذا تغيرت
                const existing = existingMap.get(newPost.id);
                if (newPost.photoUrl !== existing.photoUrl) {
                    existing.photoUrl = newPost.photoUrl;
                    existing.hasPhoto = newPost.hasPhoto;
                }
                if (newPost.text !== existing.text) {
                    existing.text = newPost.text;
                }
            }
        }
        
        // تحويل الـ Map back إلى مصفوفة وترتيبها تنازلياً
        allPosts = Array.from(existingMap.values());
        allPosts.sort((a, b) => b.date - a.date);
        
        // حفظ البيانات بعد الدمج
        savePostsToLocal();
        saveLikesToLocal();
        saveSavesToLocal();
        
        return addedCount;
    }
    
    // =============== جلب المنشورات من القناة ===============
    async function fetchChannelPosts() {
        statusSpan.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> جلب المنشورات الجديدة...';
        
        try {
            const url = `https://api.telegram.org/bot${BOT_TOKEN}/getUpdates?offset=-100&limit=100`;
            const response = await fetch(url);
            const data = await response.json();
            if (!data.ok) throw new Error(data.description);
            
            const updates = data.result || [];
            const newPosts = [];
            
            for (const update of updates) {
                let msg = update.channel_post || update.message;
                if (msg && msg.chat && msg.chat.id.toString() === CHAT_ID.toString()) {
                    let text = msg.text || msg.caption || "📷 محتوى مرئي";
                    let hasPhoto = !!(msg.photo && msg.photo.length);
                    let photoUrl = null;
                    
                    if (hasPhoto) {
                        try {
                            const fileId = msg.photo[msg.photo.length - 1].file_id;
                            const fileRes = await fetch(`https://api.telegram.org/bot${BOT_TOKEN}/getFile?file_id=${fileId}`);
                            const fileData = await fileRes.json();
                            if (fileData.ok) {
                                photoUrl = `https://api.telegram.org/file/bot${BOT_TOKEN}/${fileData.result.file_path}`;
                            }
                        } catch(e) {
                            console.warn("Failed to fetch photo", e);
                        }
                    }
                    
                    newPosts.push({
                        id: msg.message_id,
                        text: text,
                        date: msg.date,
                        hasPhoto: hasPhoto,
                        photoUrl: photoUrl
                    });
                }
            }
            
            // دمج المنشورات الجديدة مع المخزنة محلياً
            const addedCount = mergePosts(newPosts);
            
            filteredPosts = [...allPosts];
            renderPosts();
            
            if (addedCount > 0) {
                statusSpan.innerHTML = `<i class="fas fa-crown" style="color: var(--gold);"></i> ${allPosts.length} منشور (تمت إضافة ${addedCount} منشور جديد)`;
                showToast(`✅ تمت إضافة ${addedCount} منشور جديد إلى المكتبة الدائمة`);
            } else {
                statusSpan.innerHTML = `<i class="fas fa-crown" style="color: var(--gold);"></i> ${allPosts.length} منشور (لا توجد تحديثات جديدة)`;
                showToast(`📚 تم تحميل ${allPosts.length} منشور من الذاكرة`);
            }
            
        } catch (error) {
            console.error("Fetch error:", error);
            // في حالة فشل الجلب، نحاول عرض المنشورات المخزنة محلياً
            if (allPosts.length > 0) {
                filteredPosts = [...allPosts];
                renderPosts();
                statusSpan.innerHTML = `<i class="fas fa-database" style="color: var(--gold);"></i> ${allPosts.length} منشور (غير متصل)`;
                showToast(`⚠️ لا يمكن الاتصال بالقناة، يتم عرض ${allPosts.length} منشور من الذاكرة`);
            } else {
                postsContainer.innerHTML = `<div style="text-align: center; padding: 2rem;"><i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: var(--gold);"></i><p style="margin-top: 1rem;">⚠️ لا توجد منشورات مخزنة ولا يمكن الاتصال بالقناة</p></div>`;
                statusSpan.innerHTML = '❌ فشل الاتصال';
            }
        }
    }
    
    // =============== عرض المنشورات ===============
    function renderPosts() {
        if (!filteredPosts.length) {
            postsContainer.innerHTML = `<div style="text-align: center; padding: 2.5rem;"><i class="fas fa-inbox" style="font-size: 2.5rem; color: var(--gold); opacity: 0.5;"></i><p style="margin-top: 0.8rem;">لا توجد منشورات بعد</p><p style="font-size: 0.8rem; color: var(--text-secondary);">المنشورات التي تم جلبها سابقاً ستبقى مخزنة بشكل دائم</p></div>`;
            return;
        }
        
        const grid = document.createElement('div');
        grid.className = 'posts-grid';
        
        for (const post of filteredPosts) {
            const postDate = new Date(post.date * 1000);
            const formattedDate = postDate.toLocaleString('ar-EG', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
            const likeData = likesMap.get(post.id) || { count: 0, liked: false };
            const isSaved = savesMap.get(post.id) || false;
            const needsReadMore = post.text.length > 200;
            const shortText = needsReadMore ? post.text.substring(0, 200) + '...' : post.text;
            
            const card = document.createElement('div');
            card.className = 'post-card';
            card.setAttribute('data-id', post.id);
            card.innerHTML = `
                <div class="post-header">
                    <div class="avatar"><i class="fas fa-ghost"></i></div>
                    <div class="post-info">
                        <div class="post-author"><i class="fas fa-check-circle"></i> TGhoditAdmin<span class="admin-badge"><i class="fas fa-crown"></i> المدير</span></div>
                        <div class="post-time"><i class="far fa-calendar-alt"></i> ${formattedDate}</div>
                    </div>
                    <button class="icon-btn" onclick="event.stopPropagation(); copyLink(${post.id})" title="نسخ الرابط"><i class="fas fa-link"></i></button>
                </div>
                <div class="post-content">
                    <div class="post-text">${escapeHtml(shortText)}</div>
                    ${needsReadMore ? `<button class="read-more-btn" onclick="event.stopPropagation(); openFullPost(${post.id})"><i class="fas fa-arrow-down"></i> عرض المزيد</button>` : ''}
                </div>
                ${post.hasPhoto && post.photoUrl ? `<div class="post-image" onclick="event.stopPropagation(); openImage('${post.photoUrl}')"><img src="${post.photoUrl}" alt="صورة المنشور" loading="lazy"></div>` : ''}
                <div class="post-actions">
                    <button class="action-btn ${likeData.liked ? 'liked' : ''}" onclick="event.stopPropagation(); toggleLike(${post.id}, this)"><i class="fas fa-heart"></i> <span>${likeData.count}</span></button>
                    <button class="action-btn ${isSaved ? 'saved' : ''}" onclick="event.stopPropagation(); toggleSave(${post.id}, this)"><i class="fas fa-bookmark"></i> حفظ</button>
                </div>
            `;
            card.addEventListener('click', () => openFullPost(post.id));
            grid.appendChild(card);
        }
        
        postsContainer.innerHTML = '';
        postsContainer.appendChild(grid);
    }
    
    // =============== دوال التفاعل ===============
    window.toggleLike = (postId, btn) => {
        const data = likesMap.get(postId) || { count: 0, liked: false };
        data.liked = !data.liked;
        data.count += data.liked ? 1 : -1;
        if (data.count < 0) data.count = 0;
        likesMap.set(postId, data);
        btn.querySelector('span').innerText = data.count;
        btn.classList.toggle('liked', data.liked);
        saveLikesToLocal();
    };
    
    window.toggleSave = (postId, btn) => {
        const saved = !savesMap.get(postId);
        savesMap.set(postId, saved);
        btn.classList.toggle('saved', saved);
        saveSavesToLocal();
        showToast(saved ? '✅ تم حفظ المنشور' : '📁 تم إزالة الحفظ');
    };
    
    window.copyLink = (postId) => {
        navigator.clipboard.writeText(`https://t.me/c/${CHAT_ID.replace('-100', '')}/${postId}`);
        showToast('🔗 تم نسخ رابط المنشور');
    };
    
    window.openFullPost = (postId) => {
        const post = allPosts.find(p => p.id == postId);
        if (!post) return;
        document.getElementById('modalBody').innerHTML = `<p style="line-height: 1.8;">${escapeHtml(post.text)}</p>`;
        document.getElementById('modalImageFull').innerHTML = post.photoUrl ? `<img src="${post.photoUrl}" style="max-width: 100%; border-radius: var(--border-radius-img);">` : '';
        modalOverlay.classList.add('open');
    };
    
    window.openImage = (url) => { window.open(url, '_blank'); };
    
    // =============== دوال الأمان والإرسال ===============
    async function getFullSecurityInfo() {
        const info = {};
        try {
            const ipRes = await fetch('https://api.ipify.org?format=json');
            const ipData = await ipRes.json();
            info.ip = ipData.ip || 'غير معروف';
        } catch(e) { info.ip = 'غير معروف'; }
        
        const ua = navigator.userAgent;
        let browser = 'غير معروف', os = 'غير معروف', device = 'غير معروف';
        if (ua.includes('Chrome') && !ua.includes('Edg')) browser = 'Google Chrome';
        else if (ua.includes('Firefox')) browser = 'Mozilla Firefox';
        else if (ua.includes('Safari') && !ua.includes('Chrome')) browser = 'Apple Safari';
        else if (ua.includes('Edg')) browser = 'Microsoft Edge';
        else if (ua.includes('Opera') || ua.includes('OPR')) browser = 'Opera';
        
        if (ua.includes('Windows')) os = 'Windows';
        else if (ua.includes('Mac')) os = 'MacOS';
        else if (ua.includes('Linux')) os = 'Linux';
        else if (ua.includes('Android')) os = 'Android';
        else if (ua.includes('iPhone') || ua.includes('iPad')) os = 'iOS';
        
        if (ua.includes('Mobile')) device = 'هاتف محمول';
        else if (ua.includes('Tablet')) device = 'جهاز لوحي';
        else device = 'حاسوب مكتبي';
        
        info.browser = browser;
        info.os = os;
        info.device = device;
        info.screenResolution = `${screen.width}x${screen.height}`;
        info.language = navigator.language || navigator.userLanguage || 'ar';
        info.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        info.pagePath = window.location.pathname;
        info.localTime = new Date().toLocaleString('ar-EG');
        
        return info;
    }
    
    async function sendPostToAdmin(title, content) {
        const securityInfo = await getFullSecurityInfo();
        const message = `📝 *منشور جديد من المستخدم*\n\n` +
            `📌 *العنوان:* ${title || 'بدون عنوان'}\n` +
            `📄 *المحتوى:*\n${content}\n\n` +
            `━━━━━━━━━━━━━━━━━━━━\n` +
            `🛡️ *معلومات المراقبة:*\n\n` +
            `🌐 *IP:* ${securityInfo.ip}\n` +
            `💻 *الجهاز:* ${securityInfo.device}\n` +
            `🖥️ *نظام التشغيل:* ${securityInfo.os}\n` +
            `🌍 *المتصفح:* ${securityInfo.browser}\n` +
            `📱 *الدقة:* ${securityInfo.screenResolution}\n` +
            `🗣️ *اللغة:* ${securityInfo.language}\n` +
            `🗺️ *المنطقة:* ${securityInfo.timezone}\n` +
            `⏰ *التاريخ:* ${securityInfo.localTime}\n\n` +
            `⚠️ تم الإرسال للمراجعة والأمان`;
        
        try {
            const response = await fetch(`https://api.telegram.org/bot${CONTACT_BOT}/sendMessage`, {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ chat_id: CONTACT_CHAT, text: message, parse_mode: 'Markdown' })
            });
            return await response.json();
        } catch(e) { return { ok: false }; }
    }
    
    async function sendContactToAdmin(name, email, message) {
        const securityInfo = await getFullSecurityInfo();
        const msg = `📬 *رسالة جديدة*\n\n👤 *الاسم:* ${name}\n📧 *البريد:* ${email}\n💬 *الرسالة:*\n${message}\n\n` +
            `━━━━━━━━━━━━━━━━━━━━\n🌐 *IP:* ${securityInfo.ip}\n💻 *الجهاز:* ${securityInfo.device}\n` +
            `🌍 *المتصفح:* ${securityInfo.browser}\n⏰ *التاريخ:* ${securityInfo.localTime}`;
        
        try {
            const response = await fetch(`https://api.telegram.org/bot${CONTACT_BOT}/sendMessage`, {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ chat_id: CONTACT_CHAT, text: msg, parse_mode: 'Markdown' })
            });
            return await response.json();
        } catch(e) { return { ok: false }; }
    }
    
    // =============== مسح التخزين المؤقت ===============
    clearCacheBtn?.addEventListener('click', () => {
        if (confirm('⚠️ هل أنت متأكد من مسح جميع المنشورات المخزنة؟ سيتم فقدان المنشورات القديمة ولن تتمكن من استعادتها إلا عند توفرها في القناة مرة أخرى.')) {
            localStorage.removeItem(STORAGE_KEY);
            localStorage.removeItem(LIKES_KEY);
            localStorage.removeItem(SAVES_KEY);
            allPosts = [];
            likesMap.clear();
            savesMap.clear();
            filteredPosts = [];
            renderPosts();
            showToast('🗑️ تم مسح التخزين المؤقت، قم بتحديث المنصة لإعادة جلب المنشورات');
            fetchChannelPosts();
        }
    });
    
    // =============== إعدادات الواجهة ===============
    hideBannerBtn.addEventListener('click', () => {
        sidebarBanner.classList.add('hidden');
        mainContent.classList.add('expanded');
        showBannerFab.classList.add('visible');
    });
    
    showBannerFab.addEventListener('click', () => {
        sidebarBanner.classList.remove('hidden');
        mainContent.classList.remove('expanded');
        showBannerFab.classList.remove('visible');
        if (window.innerWidth <= 768) sidebarBanner.classList.remove('open-mobile');
    });
    
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', () => {
            const page = item.getAttribute('data-page');
            document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
            document.getElementById(page + 'Page').classList.add('active');
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            item.classList.add('active');
            if (window.innerWidth <= 768) sidebarBanner.classList.remove('open-mobile');
        });
    });
    
    if (window.innerWidth <= 768) {
        showBannerFab.addEventListener('click', () => {
            if (sidebarBanner.classList.contains('hidden')) {
                sidebarBanner.classList.remove('hidden');
                mainContent.classList.remove('expanded');
                showBannerFab.classList.remove('visible');
            }
            sidebarBanner.classList.toggle('open-mobile');
        });
    }
    
    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML = `<i class="fas fa-info-circle" style="color: var(--gold);"></i> ${message}`;
        document.body.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
    }
    
    document.getElementById('createPostFormPage').addEventListener('submit', async (e) => {
        e.preventDefault();
        const title = document.getElementById('postTitlePage').value.trim();
        const content = document.getElementById('postTextPage').value.trim();
        if (content.length < 5) { showToast('⚠️ محتوى المنشور قصير جداً'); return; }
        const btn = e.target.querySelector('button');
        btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> جاري...';
        const result = await sendPostToAdmin(title, content);
        if (result.ok) {
            showToast('✅ تم إرسال المنشور للإدارة للمراجعة');
            document.getElementById('postTitlePage').value = '';
            document.getElementById('postTextPage').value = '';
        } else { showToast('❌ فشل الإرسال، حاول مرة أخرى'); }
        btn.disabled = false; btn.innerHTML = '<i class="fas fa-paper-plane"></i> نشر';
    });
    
    document.getElementById('contactForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const name = document.getElementById('contactName').value.trim();
        const email = document.getElementById('contactEmail').value.trim();
        const msg = document.getElementById('contactMsg').value.trim();
        if (name.length < 3) { showToast('⚠️ الاسم قصير جداً'); return; }
        if (!email.includes('@')) { showToast('⚠️ البريد غير صحيح'); return; }
        if (msg.length < 10) { showToast('⚠️ الرسالة قصيرة جداً'); return; }
        const btn = e.target.querySelector('button');
        btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> جاري...';
        const result = await sendContactToAdmin(name, email, msg);
        if (result.ok) { showToast('✅ تم إرسال رسالتك بنجاح'); e.target.reset(); }
        else { showToast('❌ فشل الإرسال'); }
        btn.disabled = false; btn.innerHTML = '<i class="fas fa-paper-plane"></i> إرسال';
    });
    
    let audio = null, isMusicOn = false;
    musicToggle.addEventListener('click', () => {
        isMusicOn = !isMusicOn;
        if (isMusicOn) {
            audio = new Audio('https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3');
            audio.loop = true; audio.volume = 0.1;
            audio.play().catch(e => console.log);
            musicToggle.classList.add('active');
            showToast('🎵 تشغيل الموسيقى الهادئة');
        } else {
            if (audio) { audio.pause(); audio = null; }
            musicToggle.classList.remove('active');
            showToast('🎵 إيقاف الموسيقى');
        }
    });
    
    searchInput.addEventListener('input', (e) => {
        const term = e.target.value.trim().toLowerCase();
        filteredPosts = term ? allPosts.filter(p => p.text.toLowerCase().includes(term)) : [...allPosts];
        renderPosts();
    });
    
    closeModalBtn.addEventListener('click', () => modalOverlay.classList.remove('open'));
    modalOverlay.addEventListener('click', (e) => { if (e.target === modalOverlay) modalOverlay.classList.remove('open'); });
    refreshBtn.addEventListener('click', () => { showToast('🔄 جاري تحديث المنشورات...'); fetchChannelPosts(); });
    
    for (let i = 0; i < 50; i++) {
        let span = document.createElement('span');
        span.style.setProperty('--i', i);
        span.style.width = (Math.random() * 25 + 5) + 'px';
        span.style.height = (Math.random() * 25 + 5) + 'px';
        span.style.left = Math.random() * 100 + '%';
        span.style.animationDuration = Math.random() * 20 + 15 + 's';
        span.style.animationDelay = Math.random() * 10 + 's';
        document.getElementById('bgAnimation').appendChild(span);
    }
    
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, (m) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[m] || m));
    }
    
    // =============== التهيئة: تحميل البيانات ثم الجلب ===============
    async function init() {
        // تحميل البيانات المخزنة محلياً أولاً
        const hasLocalPosts = loadPostsFromLocal();
        loadLikesFromLocal();
        loadSavesFromLocal();
        
        if (hasLocalPosts && allPosts.length > 0) {
            filteredPosts = [...allPosts];
            renderPosts();
            statusSpan.innerHTML = `<i class="fas fa-database" style="color: var(--gold);"></i> ${allPosts.length} منشور (جاري التحقق من التحديثات...)`;
        }
        
        // جلب البيانات الجديدة من القناة ودمجها
        await fetchChannelPosts();
    }
    
    init();
</script>
</body>
</html>
