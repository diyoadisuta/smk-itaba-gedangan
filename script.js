const menuButton = document.querySelector('.menu-toggle');
const menu = document.querySelector('#main-nav');
const header = document.querySelector('.site-header');

/* ---------- Mobile menu ---------- */
function setMenuOpen(isOpen) {
  menuButton?.setAttribute('aria-expanded', String(isOpen));
  menuButton?.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
  menu?.classList.toggle('open', isOpen);
}

menuButton?.addEventListener('click', () => {
  setMenuOpen(menuButton.getAttribute('aria-expanded') !== 'true');
});

menu?.querySelectorAll('a').forEach((link) => {
  link.addEventListener('click', () => setMenuOpen(false));
});

document.addEventListener('click', (event) => {
  if (menu?.classList.contains('open') && !menu.contains(event.target) && !menuButton?.contains(event.target)) {
    setMenuOpen(false);
  }
});

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') setMenuOpen(false);
});

window.addEventListener('resize', () => {
  if (window.innerWidth > 980) setMenuOpen(false);
});

/* ---------- Header shadow on scroll ---------- */
const onScroll = () => header?.classList.toggle('scrolled', window.scrollY > 8);
onScroll();
window.addEventListener('scroll', onScroll, { passive: true });

/* ---------- Scroll reveal ---------- */
const revealItems = document.querySelectorAll('.reveal');
if ('IntersectionObserver' in window) {
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  revealItems.forEach((item) => revealObserver.observe(item));
} else {
  revealItems.forEach((item) => item.classList.add('in'));
}

/* ---------- Sub-navigation active state (SPMB) ---------- */
const subnavLinks = document.querySelectorAll('.subnav a[href^="#"]');
if (subnavLinks.length && 'IntersectionObserver' in window) {
  const sections = [...subnavLinks].map((link) => document.querySelector(link.getAttribute('href'))).filter(Boolean);
  const setActive = (id) => {
    subnavLinks.forEach((link) => link.classList.toggle('active', link.getAttribute('href') === `#${id}`));
  };
  const sectionObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) setActive(entry.target.id);
    });
  }, { rootMargin: '-45% 0px -50% 0px' });
  sections.forEach((section) => sectionObserver.observe(section));
}

/* ---------- Current year ---------- */
document.querySelector('#year')?.replaceChildren(String(new Date().getFullYear()));

/* ---------- Instagram Gallery Filter ---------- */
const filterButtons = document.querySelectorAll('.filter-btn');
const galleryItems = document.querySelectorAll('.gallery-item');
filterButtons.forEach(btn => {
  btn.addEventListener('click', () => {
    filterButtons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const filter = btn.getAttribute('data-filter');
    galleryItems.forEach(item => {
      const cat = item.getAttribute('data-category');
      if (filter === 'all' || cat === filter) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    });
  });
});

/* ---------- Auto-process Instagram Embeds on Load ---------- */
function processInstagramEmbeds() {
  if (window.instgrm && window.instgrm.Embeds) {
    try {
      window.instgrm.Embeds.process();
    } catch (e) {
      console.warn('Instagram embed process:', e);
    }
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', processInstagramEmbeds);
} else {
  processInstagramEmbeds();
}
window.addEventListener('load', () => {
  processInstagramEmbeds();
  setTimeout(processInstagramEmbeds, 600);
  setTimeout(processInstagramEmbeds, 1800);
});

/* ---------- Manual Embed Accordion Toggle ---------- */
const toggleManualBtn = document.getElementById('toggle-manual-embed');
const manualPanel = document.getElementById('manual-embed-panel');
toggleManualBtn?.addEventListener('click', () => {
  const isOpen = manualPanel?.classList.toggle('open');
  toggleManualBtn.classList.toggle('active', isOpen);
  toggleManualBtn.setAttribute('aria-expanded', String(isOpen));
});

/* ---------- Live Instagram Embedder ---------- */
const embedInput = document.getElementById('ig-url-input');
const embedBtn = document.getElementById('btn-embed-ig');
const embedTarget = document.getElementById('ig-embed-target');

function renderInstagramEmbed(url) {
  if (!url || !embedTarget) return;
  const match = url.match(/https?:\/\/(?:www\.)?instagram\.com\/(?:p|reel|tv)\/([A-Za-z0-9_-]+)/);
  if (!match) {
    alert('Masukkan link postingan Instagram yang valid (contoh: https://www.instagram.com/p/C_xyz123/)');
    return;
  }
  const cleanUrl = `https://www.instagram.com/p/${match[1]}/`;
  embedTarget.innerHTML = `
    <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="${cleanUrl}?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="background:#FFF; border:0; border-radius:12px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: auto; max-width:540px; min-width:326px; padding:0; width:99.375%;">
      <div style="padding:16px; text-align:center;">
        <a href="${cleanUrl}" target="_blank" style="color:#0f3b2e; font-family:sans-serif; font-size:14px; font-weight:bold; text-decoration:none;">Memuat postingan Instagram @smkitabagedangan...</a>
      </div>
    </blockquote>
  `;
  if (window.instgrm) {
    window.instgrm.Embeds.process();
  } else {
    const s = document.createElement('script');
    s.async = true;
    s.src = 'https://www.instagram.com/embed.js';
    document.body.appendChild(s);
  }
}

embedBtn?.addEventListener('click', () => {
  renderInstagramEmbed(embedInput?.value.trim());
});

embedInput?.addEventListener('keydown', (e) => {
  if (e.key === 'Enter') {
    renderInstagramEmbed(embedInput.value.trim());
  }
});
