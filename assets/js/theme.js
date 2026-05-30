(function () {
	"use strict";

	var header     = document.getElementById("masthead");
	var toggle     = document.getElementById("menuToggle");
	var mobileMenu = document.getElementById("mobileMenu");

	// Scroll: add is-scrolled to header
	if (header) {
		function updateHeader() {
			header.classList.toggle("is-scrolled", window.scrollY > 12);
		}
		updateHeader();
		window.addEventListener("scroll", updateHeader, { passive: true });
	}

	// Hamburger toggle → mobile overlay
	if (toggle && mobileMenu) {
		toggle.addEventListener("click", function () {
			var isOpen = mobileMenu.classList.toggle("is-open");
			toggle.classList.toggle("is-active", isOpen);
			toggle.setAttribute("aria-expanded", String(isOpen));
			mobileMenu.setAttribute("aria-hidden", String(!isOpen));
			document.body.style.overflow = isOpen ? "hidden" : "";
		});

		mobileMenu.addEventListener("click", function (e) {
			if (e.target.closest("a")) {
				mobileMenu.classList.remove("is-open");
				toggle.classList.remove("is-active");
				toggle.setAttribute("aria-expanded", "false");
				mobileMenu.setAttribute("aria-hidden", "true");
				document.body.style.overflow = "";
			}
		});

		document.addEventListener("keydown", function (e) {
			if (e.key === "Escape" && mobileMenu.classList.contains("is-open")) {
				mobileMenu.classList.remove("is-open");
				toggle.classList.remove("is-active");
				toggle.setAttribute("aria-expanded", "false");
				mobileMenu.setAttribute("aria-hidden", "true");
				document.body.style.overflow = "";
				toggle.focus();
			}
		});
	}
	// Animated stat counters
	var counters = document.querySelectorAll(".stat-count");
	if (counters.length) {
		var counterObserver = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) return;
				var el     = entry.target;
				var target = parseInt(el.dataset.target || "0", 10);
				var current = 0;
				var increment = target / (2000 / 16);
				function tick() {
					current += increment;
					if (current >= target) {
						el.textContent = String(target);
					} else {
						el.textContent = String(Math.floor(current));
						window.requestAnimationFrame(tick);
					}
				}
				tick();
				counterObserver.unobserve(el);
			});
		}, { threshold: 0.5 });
		counters.forEach(function (el) { counterObserver.observe(el); });
	}
})();
