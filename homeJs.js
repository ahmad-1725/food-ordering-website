// Scroll reveal functionality
document.addEventListener('DOMContentLoaded', function() {
  // Start the slideshow when the page loads
  startSlideshow();
  
  // Initialize scroll reveal
  initScrollReveal();
  
  // Setup event listeners for the cart and navigation
  setupEventListeners();
});

// Slideshow functionality
let currentSlide = 1;
const totalSlides = 4;
const slideInterval = 4000; // Change image every 4 seconds

function startSlideshow() {
  setInterval(() => {
    changeSlide(currentSlide + 1 > totalSlides ? 1 : currentSlide + 1);
  }, slideInterval);
}

function changeSlide(slideNumber) {
  // Hide all slides
  document.querySelectorAll('.slideshow-slide').forEach(slide => {
    slide.classList.remove('active');
  });
  
  // Remove active class from all indicators
  document.querySelectorAll('.indicator').forEach(indicator => {
    indicator.classList.remove('active');
  });
  
  // Show the selected slide
  document.getElementById('slide' + slideNumber).classList.add('active');
  
  // Update the active indicator
  document.querySelector(`.indicator[data-slide="slide${slideNumber}"]`).classList.add('active');
  
  // Update current slide number
  currentSlide = slideNumber;
}


// Event listeners for cart and navigation
function setupEventListeners() {
  // Cart functionality
  document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
      alert('Item added to cart!');
      updateCartNumber();
    });
  });
  var totalItems = 0;
  function updateCartNumber(){
    totalItems += 1;
    document.querySelector('.cart-number').textContent = totalItems;
  }

  // Navigation menu functionality
  document.querySelectorAll('#nav-list li').forEach(item => {
    item.addEventListener('click', function() {
      document.querySelectorAll('#nav-list li').forEach(li => {
        li.classList.remove('active');
      });
      if(!this.classList.contains('active') && !this.textContent.includes('Cart')) {
        this.classList.add('active');
      }
    });
  });
}
// Scroll reveal functionality
function initScrollReveal() {
  // Get all elements with reveal class
  const revealElements = document.querySelectorAll('.reveal');
  
  // Create observer options
  const observerOptions = {
    root: null, // relative to viewport
    rootMargin: '0px', // no margin
    threshold: 0.15 // trigger when 15% of the element is visible
  };
  
  // Create intersection observer
  const revealObserver = new IntersectionObserver(function(entries, observer) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('active');
        observer.unobserve(entry.target); // Stop observing once revealed
      }
    });
  }, observerOptions);
  
  // Observe each reveal element
  revealElements.forEach(element => {
    revealObserver.observe(element);
    
    // Add initial state class for animation starting point
    if (element.classList.contains('reveal-left')) {
      element.style.transform = 'translateX(-50px)';
      element.style.opacity = '0';
    } else if (element.classList.contains('reveal-right')) {
      element.style.transform = 'translateX(50px)';
      element.style.opacity = '0';
    } else if (element.classList.contains('reveal-bottom')) {
      element.style.transform = 'translateY(50px)';
      element.style.opacity = '0';
    } else if (element.classList.contains('reveal-top')) {
      element.style.transform = 'translateY(-50px)';
      element.style.opacity = '0';
    } else {
      element.style.opacity = '0';
    }
    
    // Add transition
    element.style.transition = 'all 0.8s ease';
    
    // Add delay for elements with reveal-slow class
    if (element.classList.contains('reveal-slow')) {
      element.style.transitionDelay = '0.3s';
    }
  });
}

// CSS helper for reveal animations
(function addCssForReveal() {
  const style = document.createElement('style');
  style.textContent = `
    .reveal {
      visibility: visible;
    }
    
    .reveal.active {
      opacity: 1 !important;
      transform: translate(0, 0) !important;
    }
    
    @media (prefers-reduced-motion: reduce) {
      .reveal {
        transition: none !important;
        opacity: 1 !important;
        transform: none !important;
      }
    }
  `;
  document.head.appendChild(style);
})();