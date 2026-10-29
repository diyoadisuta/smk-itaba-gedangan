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

/* ---------- Gallery & Prestasi Filters ---------- */
document.querySelectorAll('[data-filter-group]').forEach((group) => {
  const groupName = group.getAttribute('data-filter-group');
  const itemsContainer = document.querySelector(`[data-filter-items="${groupName}"]`);
  if (!itemsContainer) return;
  const filterBtns = group.querySelectorAll('.filter-btn');
  const items = itemsContainer.querySelectorAll('[data-category]');

  filterBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      filterBtns.forEach((b) => {
        b.classList.remove('active');
        b.setAttribute('aria-pressed', 'false');
      });
      btn.classList.add('active');
      btn.setAttribute('aria-pressed', 'true');

      const filter = btn.getAttribute('data-filter');
      items.forEach((item) => {
        const cat = item.getAttribute('data-category');
        if (filter === 'all' || cat === filter) {
          item.classList.remove('is-hidden');
        } else {
          item.classList.add('is-hidden');
        }
      });
    });
  });
});

/* ---------- YouTube Facade (Click to Play) ---------- */
document.querySelectorAll('.video-facade[data-yt]').forEach((facade) => {
  facade.addEventListener('click', (e) => {
    e.preventDefault();
    const ytId = facade.getAttribute('data-yt');
    const title = facade.getAttribute('data-title') || 'Video YouTube';
    const frame = document.createElement('div');
    frame.className = 'video-frame';
    frame.innerHTML = `<iframe src="https://www.youtube-nocookie.com/embed/${ytId}?autoplay=1&rel=0" title="${title}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
    facade.replaceWith(frame);
  });
});

/* ---------- Lightbox ---------- */
const lightbox = document.getElementById('lightbox');
if (lightbox) {
  const lbImg = document.getElementById('lightbox-img');
  const lbCap = document.getElementById('lightbox-cap');
  const prevBtn = lightbox.querySelector('[data-lb="prev"]');
  const nextBtn = lightbox.querySelector('[data-lb="next"]');
  const closeBtn = lightbox.querySelector('[data-lb="close"]');

  let currentGroup = '';
  let currentIndex = -1;
  let activeTriggers = [];

  function getVisibleTriggers(group) {
    return Array.from(document.querySelectorAll(`[data-lightbox="${group}"]`)).filter(
      (el) => !el.closest('.is-hidden')
    );
  }

  function showLightboxIndex(index) {
    if (!activeTriggers.length || index < 0 || index >= activeTriggers.length) return;
    currentIndex = index;
    const trigger = activeTriggers[currentIndex];
    const src = trigger.getAttribute('data-src') || trigger.querySelector('img')?.src;
    const cap = trigger.getAttribute('data-caption') || trigger.querySelector('img')?.alt || '';

    if (lbImg) {
      lbImg.src = src;
      lbImg.alt = cap;
    }
    if (lbCap) {
      lbCap.innerHTML = cap;
    }

    if (prevBtn) prevBtn.hidden = activeTriggers.length <= 1;
    if (nextBtn) nextBtn.hidden = activeTriggers.length <= 1;
  }

  function openLightbox(trigger) {
    currentGroup = trigger.getAttribute('data-lightbox') || '';
    activeTriggers = getVisibleTriggers(currentGroup);
    const idx = activeTriggers.indexOf(trigger);
    showLightboxIndex(idx >= 0 ? idx : 0);
    if (typeof lightbox.showModal === 'function') {
      lightbox.showModal();
    } else {
      lightbox.setAttribute('open', '');
    }
  }

  function closeLightbox() {
    if (typeof lightbox.close === 'function') {
      lightbox.close();
    } else {
      lightbox.removeAttribute('open');
    }
  }

  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('[data-lightbox]');
    if (trigger) {
      e.preventDefault();
      openLightbox(trigger);
    }
  });

  prevBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    if (currentIndex > 0) {
      showLightboxIndex(currentIndex - 1);
    } else {
      showLightboxIndex(activeTriggers.length - 1);
    }
  });

  nextBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    if (currentIndex < activeTriggers.length - 1) {
      showLightboxIndex(currentIndex + 1);
    } else {
      showLightboxIndex(0);
    }
  });

  closeBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    closeLightbox();
  });

  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) {
      closeLightbox();
    }
  });

  document.addEventListener('keydown', (e) => {
    if (!lightbox.open) return;
    if (e.key === 'ArrowLeft') {
      prevBtn?.click();
    } else if (e.key === 'ArrowRight') {
      nextBtn?.click();
    }
  });
}
