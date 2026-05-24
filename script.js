// =============== المتغيرات العامة ===============
let allPosts = [], filteredPosts = [], lastMessageIds = new Set();
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

// =============== إظهار/إخفاء البانر ===============
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

// =============== التنقل بين الصفحات ===============
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

// =============== دوال مساعدة ===============
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `<i class="fas fa-info-circle" style="color: var(--gold);"></i> ${message}`;
    document.body.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, (m) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[m] || m));
}

// =============== جلب معلومات المراقبة ===============
async function getFullSecurityInfo() {
    const info = {};
    try {
        const ipRes = await fetch('https://api.ipify.org?format=json');
        const ipData = await ipRes.json();
        info.ip = ipData.ip || 'غير معروف';
    } catch(e) { info.ip = 'غير معروف'; }
    
    const ua = navigator.userAgent;
    info.userAgent = ua;
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

// =============== إرسال منشور إلى بوت الإدارة ===============
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

// =============== إرسال رسالة تواصل ===============
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

// =============== جلب المنشورات ===============
async function fetchChannelPosts() {
    statusSpan.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> جلب...';
    postsContainer.innerHTML = '<div class="spinner"></div>';
    try {
        const url = `https://api.telegram.org/bot${BOT_TOKEN}/getUpdates?offset=-100&limit=100`;
        const response = await fetch(url);
        const data = await response.json();
        if (!data.ok) throw new Error(data.description);
        const updates = data.result || [];
        const currentMessageIds = new Set();
        const posts = [];
        for (const update of updates) {
            let msg = update.channel_post || update.message;
            if (msg && msg.chat && msg.chat.id.toString() === CHAT_ID.toString()) {
                currentMessageIds.add(msg.message_id);
                let text = msg.text || msg.caption || "📷 محتوى مرئي";
                let hasPhoto = !!(msg.photo && msg.photo.length);
                let photoUrl = null;
                if (hasPhoto) {
                    try {
                        const fileId = msg.photo[msg.photo.length - 1].file_id;
                        const fileRes = await fetch(`https://api.telegram.org/bot${BOT_TOKEN}/getFile?file_id=${fileId}`);
                        const fileData = await fileRes.json();
                        if (fileData.ok) photoUrl = `https://api.telegram.org/file/bot${BOT_TOKEN}/${fileData.result.file_path}`;
                    } catch(e) {}
                }
                posts.push({ id: msg.message_id, text: text, date: msg.date, hasPhoto: hasPhoto, photoUrl: photoUrl });
            }
        }
        if (lastMessageIds.size > 0) {
            for (let oldId of lastMessageIds) if (!currentMessageIds.has(oldId)) { likesMap.delete(oldId); savesMap.delete(oldId); }
        }
        lastMessageIds = currentMessageIds;
        posts.sort((a, b) => b.date - a.date);
        allPosts = posts.slice(0, 50);
        filteredPosts = [...allPosts];
        allPosts.forEach(post => {
            if (!likesMap.has(post.id)) likesMap.set(post.id, { count: 0, liked: false });
            if (!savesMap.has(post.id)) savesMap.set(post.id, false);
        });
        renderPosts();
        statusSpan.innerHTML = `<i class="fas fa-crown" style="color: var(--gold);"></i> ${allPosts.length} منشور`;
    } catch (error) {
        postsContainer.innerHTML = `<div style="text-align: center; padding: 2rem;"><i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: var(--gold);"></i><p style="margin-top: 1rem;">⚠️ خطأ في الاتصال</p></div>`;
        statusSpan.innerHTML = '❌ فشل';
    }
}

// =============== عرض المنشورات ===============
function renderPosts() {
    if (!filteredPosts.length) {
        postsContainer.innerHTML = `<div style="text-align: center; padding: 2.5rem;"><i class="fas fa-inbox" style="font-size: 2.5rem; color: var(--gold); opacity: 0.5;"></i><p style="margin-top: 0.8rem;">لا توجد منشورات بعد</p></div>`;
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
};

window.toggleSave = (postId, btn) => {
    const saved = !savesMap.get(postId);
    savesMap.set(postId, saved);
    btn.classList.toggle('saved', saved);
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

// =============== نماذج الإرسال ===============
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

// =============== الموسيقى ===============
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

// =============== البحث ===============
searchInput.addEventListener('input', (e) => {
    const term = e.target.value.trim().toLowerCase();
    filteredPosts = term ? allPosts.filter(p => p.text.toLowerCase().includes(term)) : [...allPosts];
    renderPosts();
});

// =============== المودال ===============
closeModalBtn.addEventListener('click', () => modalOverlay.classList.remove('open'));
modalOverlay.addEventListener('click', (e) => { if (e.target === modalOverlay) modalOverlay.classList.remove('open'); });
refreshBtn.addEventListener('click', () => { showToast('🔄 جاري تحديث المنشورات...'); fetchChannelPosts(); });

// =============== الخلفية المتحركة ===============
for (let i = 0; i < 50; i++) {
    let span = document.createElement('span');
    let size = Math.random() * 25 + 5;
    span.style.setProperty('--i', i);
    span.style.width = size + 'px';
    span.style.height = size + 'px';
    span.style.left = Math.random() * 100 + '%';
    span.style.animationDuration = Math.random() * 20 + 15 + 's';
    span.style.animationDelay = Math.random() * 10 + 's';
    document.getElementById('bgAnimation').appendChild(span);
}

// =============== بدء التطبيق ===============
fetchChannelPosts();
