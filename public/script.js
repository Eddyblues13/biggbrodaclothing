document.addEventListener("DOMContentLoaded", () => {
  // Enhanced navbar toggler animation
  const navbarToggler = document.querySelector(".navbar-toggler")
  const navbarCollapse = document.querySelector(".navbar-collapse")
  const navbar = document.querySelector(".navbar")
  const body = document.body

  // Search functionality
  const searchTriggers = document.querySelectorAll(".search-trigger")
  const searchOverlay = document.getElementById("searchOverlay")
  const searchClose = document.getElementById("searchClose")
  const searchInput = document.getElementById("searchInput")
  const suggestionTags = document.querySelectorAll(".suggestion-tag")
  const suggestionLinks = document.querySelectorAll(".suggestion-link")

  // Navbar scroll behavior variables
  let lastScrollTop = 0
  let scrollTimeout
  let isScrolling = false

  navbarToggler.addEventListener("click", function () {
    const isExpanded = this.getAttribute("aria-expanded") === "true"

    // Toggle menu open class for additional styling
    navbar.classList.toggle("menu-open", !isExpanded)

    // Prevent body scroll when menu is open
    body.classList.toggle("menu-open", !isExpanded)

    // Add haptic feedback on mobile devices
    if (navigator.vibrate) {
      navigator.vibrate(50)
    }
  })

  // Search overlay functionality
  searchTriggers.forEach((trigger) => {
    trigger.addEventListener("click", (e) => {
      e.preventDefault()
      openSearchOverlay()
    })
  })

  searchClose.addEventListener("click", closeSearchOverlay)

  // Close search overlay when clicking outside
  searchOverlay.addEventListener("click", (e) => {
    if (e.target === searchOverlay) {
      closeSearchOverlay()
    }
  })

  // Close search overlay with Escape key
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && searchOverlay.classList.contains("active")) {
      closeSearchOverlay()
    }
  })

  // Search suggestion interactions
  suggestionTags.forEach((tag) => {
    tag.addEventListener("click", function () {
      searchInput.value = this.textContent
      searchInput.focus()
    })
  })

  suggestionLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault()
      // Here you would typically navigate to the category page
      console.log("Navigate to:", this.querySelector("span").textContent)
      closeSearchOverlay()
    })
  })

  // Search input functionality
  searchInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault()
      performSearch()
    }
  })

  document.querySelector(".search-submit").addEventListener("click", performSearch)

  function openSearchOverlay() {
    searchOverlay.classList.add("active")
    body.style.overflow = "hidden"

    // Focus on search input after animation
    setTimeout(() => {
      searchInput.focus()
    }, 200)

    // Add haptic feedback
    if (navigator.vibrate) {
      navigator.vibrate(50)
    }
  }

  function closeSearchOverlay() {
    searchOverlay.classList.remove("active")
    body.style.overflow = ""
    searchInput.value = ""
    searchInput.blur()
  }

  function performSearch() {
    const query = searchInput.value.trim()
    if (query) {
      console.log("Searching for:", query)
      // Here you would typically perform the actual search
      closeSearchOverlay()
    }
  }

  // Close menu when clicking outside
  document.addEventListener("click", (event) => {
    const isClickInsideNav = navbar.contains(event.target)
    const isMenuOpen = navbarCollapse.classList.contains("show")

    if (!isClickInsideNav && isMenuOpen) {
      navbarToggler.click()
    }
  })

  // Close menu when pressing escape key
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && navbarCollapse.classList.contains("show")) {
      navbarToggler.click()
    }
  })

  // Enhanced navbar scroll behavior for both desktop and mobile
  window.addEventListener("scroll", () => {
    const currentScrollTop = window.pageYOffset || document.documentElement.scrollTop

    // Don't hide navbar when mobile menu is open or search is active
    if (navbarCollapse.classList.contains("show") || searchOverlay.classList.contains("active")) {
      return
    }

    // Set scrolling state
    isScrolling = true
    navbar.classList.add("scrolling")

    // Clear existing timeout
    clearTimeout(scrollTimeout)

    // Apply scroll behavior to both desktop and mobile
    if (currentScrollTop > 50) {
      navbar.classList.add("scrolled")
    } else {
      navbar.classList.remove("scrolled")
    }

    // Hide navbar when scrolling down, show when scrolling up
    if (currentScrollTop > lastScrollTop && currentScrollTop > 80) {
      // Scrolling down - hide navbar
      navbar.classList.add("navbar-hidden")
    } else {
      // Scrolling up - show navbar
      navbar.classList.remove("navbar-hidden")
    }

    // Set timeout to detect when scrolling stops
    scrollTimeout = setTimeout(() => {
      isScrolling = false
      navbar.classList.remove("scrolling")
      navbar.classList.remove("navbar-hidden")
    }, 150)

    lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop
  })

  // Add smooth scroll behavior to mobile menu links
  const mobileNavLinks = document.querySelectorAll(".mobile-nav .nav-link")

  mobileNavLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      // Close mobile menu when a link is clicked
      if (navbarCollapse.classList.contains("show")) {
        navbarToggler.click()
      }

      // Add ripple effect
      const ripple = document.createElement("span")
      ripple.classList.add("ripple")
      this.appendChild(ripple)

      setTimeout(() => {
        ripple.remove()
      }, 600)
    })
  })

  // Add hover effect to product cards
  const productCards = document.querySelectorAll(".product-card")

  productCards.forEach((card) => {
    card.addEventListener("mouseenter", function () {
      this.querySelector(".product-image").style.opacity = "0.8"
    })

    card.addEventListener("mouseleave", function () {
      this.querySelector(".product-image").style.opacity = "1"
    })
  })

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault()

      const targetId = this.getAttribute("href")
      if (targetId === "#") return

      const targetElement = document.querySelector(targetId)
      if (targetElement) {
        window.scrollTo({
          top: targetElement.offsetTop - 100,
          behavior: "smooth",
        })
      }
    })
  })

  // Add loading animation for images
  const images = document.querySelectorAll("img")
  images.forEach((img) => {
    img.addEventListener("load", function () {
      this.style.opacity = "1"
    })
  })
})

 document.getElementById("year").textContent = new Date().getFullYear();

