(function () {
  "use strict";

  const preloader = document.getElementById("preloader");
  const hero = document.getElementById("hero");
  const nav = document.getElementById("nav");
  const menuBtn = document.getElementById("menuBtn");
  const mobileMenu = document.getElementById("mobileMenu");

  window.addEventListener("load", function () {
    window.setTimeout(function () {
      if (preloader) {
        preloader.classList.add("hidden");
      }
    }, 2200);
  });

  if (nav && hero) {
    window.addEventListener("scroll", function () {
      const scrollY = window.scrollY;
      const heroHeight = hero.offsetHeight;

      if (scrollY > heroHeight * 0.5) {
        nav.classList.add("visible");
        nav.classList.add("scrolled");
      } else {
        nav.classList.remove("visible");
        nav.classList.remove("scrolled");
      }
    }, { passive: true });
  }

  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener("click", function () {
      menuBtn.classList.toggle("active");
      mobileMenu.classList.toggle("open");
      document.body.style.overflow = mobileMenu.classList.contains("open") ? "hidden" : "";
    });

    mobileMenu.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        menuBtn.classList.remove("active");
        mobileMenu.classList.remove("open");
        document.body.style.overflow = "";
      });
    });
  }

  const reveals = document.querySelectorAll(".reveal");

  if (reveals.length) {
    const revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
          revealObserver.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.15,
      rootMargin: "0px 0px -60px 0px"
    });

    reveals.forEach(function (element) {
      revealObserver.observe(element);
    });
  }

  const counters = document.querySelectorAll(".stat-count");

  if (counters.length) {
    const counterObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) {
          return;
        }

        const element = entry.target;
        const target = parseInt(element.dataset.target || "0", 10);
        let current = 0;
        const duration = 2000;
        const increment = target / (duration / 16);

        function updateCounter() {
          current += increment;

          if (current >= target) {
            element.textContent = String(target);
          } else {
            element.textContent = String(Math.floor(current));
            window.requestAnimationFrame(updateCounter);
          }
        }

        updateCounter();
        counterObserver.unobserve(element);
      });
    }, { threshold: 0.5 });

    counters.forEach(function (element) {
      counterObserver.observe(element);
    });
  }

  const track = document.getElementById("worksTrack");
  const dotsContainer = document.getElementById("worksDots");
  const prevBtn = document.getElementById("worksPrev");
  const nextBtn = document.getElementById("worksNext");

  if (track && dotsContainer && prevBtn && nextBtn) {
    const cards = track.querySelectorAll(".work-card");
    let currentIndex = 0;
    let isDragging = false;
    let startX = 0;

    cards.forEach(function (_, index) {
      const dot = document.createElement("div");
      dot.className = "works-dot" + (index === 0 ? " active" : "");
      dot.addEventListener("click", function () {
        goToSlide(index);
      });
      dotsContainer.appendChild(dot);
    });

    function getCardWidth() {
      const card = cards[0];
      const style = window.getComputedStyle(track);
      const gap = parseInt(style.gap, 10) || 40;
      return card.offsetWidth + gap;
    }

    function goToSlide(index) {
      if (!cards.length) {
        return;
      }

      if (index < 0) {
        index = 0;
      }

      if (index >= cards.length) {
        index = cards.length - 1;
      }

      currentIndex = index;

      const cardWidth = getCardWidth();
      const trackWidth = track.parentElement.offsetWidth;
      const offset = trackWidth / 2 - cards[currentIndex].offsetWidth / 2;
      const translateX = -(currentIndex * cardWidth) + offset;

      track.style.transform = "translateX(" + translateX + "px)";

      cards.forEach(function (card, cardIndex) {
        card.classList.toggle("active", cardIndex === currentIndex);
      });

      dotsContainer.querySelectorAll(".works-dot").forEach(function (dot, dotIndex) {
        dot.classList.toggle("active", dotIndex === currentIndex);
      });
    }

    prevBtn.addEventListener("click", function () {
      goToSlide(currentIndex - 1);
    });

    nextBtn.addEventListener("click", function () {
      goToSlide(currentIndex + 1);
    });

    let dragStartTranslate = 0;

    function getCurrentTranslate() {
      const matrix = window.getComputedStyle(track).transform;
      if (!matrix || matrix === "none") return 0;
      const values = matrix.match(/matrix.*\((.+)\)/);
      return values ? parseFloat(values[1].split(", ")[4]) : 0;
    }

    track.addEventListener("mousedown", function (event) {
      isDragging = true;
      startX = event.pageX;
      dragStartTranslate = getCurrentTranslate();
      track.style.transition = "none";
      track.style.cursor = "grabbing";
    });

    track.addEventListener("mousemove", function (event) {
      if (!isDragging) {
        return;
      }
      event.preventDefault();
      const diff = event.pageX - startX;
      track.style.transform = "translateX(" + (dragStartTranslate + diff) + "px)";
    });

    track.addEventListener("mouseup", function (event) {
      if (!isDragging) {
        return;
      }

      isDragging = false;
      track.style.cursor = "grab";
      track.style.transition = "transform 0.7s cubic-bezier(0.22, 1, 0.36, 1)";
      const diff = event.pageX - startX;

      if (Math.abs(diff) > 50) {
        if (diff < 0) {
          goToSlide(currentIndex + 1);
        } else {
          goToSlide(currentIndex - 1);
        }
      } else {
        goToSlide(currentIndex);
      }
    });

    track.addEventListener("mouseleave", function () {
      if (!isDragging) {
        return;
      }

      isDragging = false;
      track.style.cursor = "grab";
      track.style.transition = "transform 0.7s cubic-bezier(0.22, 1, 0.36, 1)";
      goToSlide(currentIndex);
    });

    let touchStartX = 0;

    track.addEventListener("touchstart", function (event) {
      touchStartX = event.touches[0].pageX;
      track.style.transition = "none";
    }, { passive: true });

    track.addEventListener("touchend", function (event) {
      track.style.transition = "transform 0.7s cubic-bezier(0.22, 1, 0.36, 1)";
      const diff = event.changedTouches[0].pageX - touchStartX;

      if (Math.abs(diff) > 40) {
        if (diff < 0) {
          goToSlide(currentIndex + 1);
        } else {
          goToSlide(currentIndex - 1);
        }
      } else {
        goToSlide(currentIndex);
      }
    }, { passive: true });

    window.setTimeout(function () {
      goToSlide(0);
    }, 100);

    window.addEventListener("resize", function () {
      goToSlide(currentIndex);
    });
  }

  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener("click", function (event) {
      const href = this.getAttribute("href");

      if (!href || href === "#") {
        return;
      }

      const target = document.querySelector(href);

      if (!target) {
        return;
      }

      event.preventDefault();
      const offset = 72;
      const top = target.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top: top, behavior: "smooth" });
    });
  });

  window.addEventListener("beforeunload", function () {
    if (animFrame) {
      window.cancelAnimationFrame(animFrame);
    }
  });
})();
