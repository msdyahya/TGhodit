// بيانات التوكن والمعرف (للتجربة فقط)
const BOT_TOKEN = "8901733084:AAH9icgp3Q7krjOomq0jiVU5VQh0zcPkY_g";
const CHAT_ID = "-1003712252984";

let showImages = true; // عرض الصور افتراضياً

// إنشاء الخلفية المتحركة
function createAnimatedBackground() {
    const bgContainer = document.getElementById('bgAnimation');
    if (!bgContainer) return;
    
    for (let i = 0; i < 50; i++) {
        let span = document.createElement('span');
        let size = Math.random() * 30 + 5;
        span.style.width = size + 'px';
        span.style.height = size + 'px';
        span.style.left = Math.random() * 100 + '%';
        span.style.animationDuration = Math.random() * 20 + 10 + 's';
        span.style.animationDelay = Math.random() * 10 + 's';
        bgContainer.appendChild(span);
    }
}

// عناصر التحكم
const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebarToggle');
const refreshBtn = document.getElementById('refreshButton');
const statusSpan = document.getElementById('statusMessage');
const postsContainer = document.getElementById('postsContainer');

// فتح/غلق الشريط الجانبي على الموبايل
function initSidebarToggle() {
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });
    }
    
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768 && sidebar && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });
}

// التحكم في عرض الصور من الشريط الجانبي
function initViewControls() {
    document.querySelectorAll('.sidebar-item[data-view]').forEach(item => {
        item.addEventListener('click', () => {
            document.querySelectorAll('.sidebar-item[data-view]').forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            const view = item.getAttribute('data-view');
            showImages = (view === 'media');
            fetchChannelPosts();
        });
    });
}

// القنوات المميزة (تأثير توضيحي)
function initChannelControls() {
    document.querySelectorAll('.sidebar-item[data-channel]').forEach(item => {
        item.addEventListener('click', () => {
            document.querySelectorAll('.sidebar-item[data-channel]').forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            // هنا يمكن إضافة منطق تغيير القناة
            statusSpan.innerHTML = `<i class="fas fa-exchange-alt"></i> تم التبديل إلى ${item.querySelector('span')?.innerText || 'قناة جديدة'}`;
            setTimeout(() => {
                if (statusSpan.innerHTML.includes('تم التبديل')) {
                    fetchChannelPosts();
                }
            }, 500);
        });
    });
}

// مصدر القنوات
function initSourceControls() {
    document.querySelectorAll('.source-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.source-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            // تأثير توضيحي لتبديل المصدر
            statusSpan.innerHTML = `<i class="fas fa-sync-alt"></i> تبديل المصدر...`;
            setTimeout(() => fetchChannelPosts(), 300);
        });
    });
}

// جلب المنشورات من تيليغرام
async function fetchChannelPosts() {
    if (statusSpan) {
        statusSpan.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> جلب البيانات...';
    }
    
    if (postsContainer) {
        postsContainer.innerHTML = `<div class="empty-state"><div class="spinner"></div><p>جاري تحميل المنشورات...</p></div>`;
    }
    
    try {
        const url = `https://api.telegram.org/bot${BOT_TOKEN}/getUpdates?chat_id=${CHAT_ID}&limit=25`;
        const response = await fetch(url);
        const data = await response.json();
        
        if (!data.ok) {
            throw new Error(data.description || "خطأ في الاتصال");
        }
        
        const updates = data.result;
        if (!updates || updates.length === 0) {
            if (postsContainer) {
                postsContainer.innerHTML = `<div class="empty-state">
                    <i class="fas fa-inbox" style="font-size: 2rem; color: #E2B13B;"></i>
                    <p style="margin-top: 10px;">لا توجد منشورات بعد.<br>أنشر في قناتك ثم اضغط تحديث</p>
                </div>`;
            }
            if (statusSpan) {
                statusSpan.innerHTML = '✅ متصل · لا توجد منشورات';
            }
            return;
        }
        
        let posts = [];
        for (let update of updates) {
            let msg = update.channel_post || update.message;
            if (msg && msg.chat && (msg.chat.id == CHAT_ID || msg.chat.id.toString() === CHAT_ID.toString())) {
                let text = msg.text || msg.caption || "";
                let photoFileId = null;
                let hasPhoto = false;
                
                if (msg.photo && msg.photo.length > 0) {
                    hasPhoto = true;
                    photoFileId = msg.photo[msg.photo.length - 1].file_id;
                }
                
                posts.push({
                    text: text || (hasPhoto ? "📷 صورة" : "(بدون محتوى نصي)"),
                    date: msg.date,
                    message_id: msg.message_id,
                    hasPhoto: hasPhoto,
                    photoFileId: photoFileId,
                    hasMedia: !!(msg.photo || msg.video || msg.document)
                });
            }
        }
        
        posts.sort((a, b) => b.date - a.date);
        const recentPosts = posts.slice(0, 12);
        
        if (recentPosts.length === 0) {
            if (postsContainer) {
                postsContainer.innerHTML = `<div class="empty-state"><i class="fas fa-comment-slash"></i><p>لا توجد رسائل نصية في القناة</p></div>`;
            }
            if (statusSpan) {
                statusSpan.innerHTML = '📭 لا توجد منشورات نصية';
            }
            return;
        }
        
        await renderPosts(recentPosts);
        if (statusSpan) {
            statusSpan.innerHTML = `<i class="fas fa-crown" style="color:#E2B13B"></i> تم جلب ${recentPosts.length} منشور`;
        }
    } catch (error) {
        console.error(error);
        if (postsContainer) {
            postsContainer.innerHTML = `<div class="empty-state">
                <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: #E2B13B;"></i>
                <p>خطأ: ${error.message}<br><span style="font-size: 0.75rem;">تأكد من التوكن وصلاحيات البوت</span></p>
            </div>`;
        }
        if (statusSpan) {
            statusSpan.innerHTML = '❌ فشل الاتصال';
        }
    }
}

// عرض المنشورات
async function renderPosts(posts) {
    if (!postsContainer) return;
    
    postsContainer.innerHTML = '';
    const grid = document.createElement('div');
    grid.className = 'posts-grid';
    
    for (let post of posts) {
        const card = document.createElement('div');
        card.className = 'post-card';
        
        const postDate = new Date(post.date * 1000);
        const formattedDate = postDate.toLocaleString('ar-EG', {
            year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
        
        let imageHtml = '';
        if (showImages && post.hasPhoto && post.photoFileId) {
            try {
                const fileInfoUrl = `https://api.telegram.org/bot${BOT_TOKEN}/getFile?file_id=${post.photoFileId}`;
                const fileRes = await fetch(fileInfoUrl);
                const fileData = await fileRes.json();
                if (fileData.ok && fileData.result.file_path) {
                    const directImageUrl = `https://api.telegram.org/file/bot${BOT_TOKEN}/${fileData.result.file_path}`;
                    imageHtml = `<div class="post-image"><img src="${directImageUrl}" alt="صورة من القناة" loading="lazy" onclick="window.open('${directImageUrl}','_blank')"></div>`;
                } else {
                    imageHtml = `<div class="media-tag"><i class="fas fa-image"></i> صورة (تعذر التحميل)</div>`;
                }
            } catch(e) {
                imageHtml = `<div class="media-tag"><i class="fas fa-image"></i> صورة غير متاحة</div>`;
            }
        } else if (showImages && post.hasMedia && !post.hasPhoto) {
            imageHtml = `<div class="media-tag"><i class="fas fa-paperclip"></i> مرفق (فيديو/مستند)</div>`;
        }
        
        card.innerHTML = `
            <div class="post-header">
                <div class="telegram-icon"><i class="fab fa-telegram-plane"></i></div>
                <div class="post-meta">
                    <div class="channel-name"><i class="fas fa-crown"></i> القناة الذهبية</div>
                    <div class="post-date">${formattedDate}</div>
                </div>
                <div class="msg-id"><i class="fas fa-hashtag"></i> ${post.message_id}</div>
            </div>
            <div class="post-message">${escapeHtml(post.text)}</div>
            ${imageHtml}
        `;
        grid.appendChild(card);
    }
    
    postsContainer.appendChild(grid);
}

// دالة لتشفير النص ومنع XSS
function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// تهيئة حدث التحديث
function initRefreshButton() {
    if (refreshBtn) {
        refreshBtn.addEventListener('click', () => {
            fetchChannelPosts();
        });
    }
}

// تهيئة جميع الوظائف عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', () => {
    createAnimatedBackground();
    initSidebarToggle();
    initViewControls();
    initChannelControls();
    initSourceControls();
    initRefreshButton();
    fetchChannelPosts();
});
