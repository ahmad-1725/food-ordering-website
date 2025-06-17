  // Filter menu items based on category
  const filterButtons = document.querySelectorAll('.filter-btn');
  const categories = document.querySelectorAll('.category');
  // Fetch menu items from PHP backend
  fetch('http://localhost/backend.php?action=menu')
    .then(response => response.json())
    .then(data => {
      console.log('Menu loaded:', data); // Optional: debug
      populateMenu(data);
    })
    .catch(error => console.error('Error loading menu:', error));
  
  // Dynamically populate menu items into the page
  function populateMenu(items) {
    const categorySections = {};
  
    items.forEach(item => {
      const {
        id, title, chef, description,
        category, price, image
      } = item;
  
      // Group by category
      if (!categorySections[category]) {
        categorySections[category] = [];
      }
  
      categorySections[category].push(`
        <div class="menu-item">
          <img src="${image}" alt="${title}" class="item-image">
          <div class="item-content">
            <h3 class="item-title">${title}</h3>
            <p class="item-chef">By ${chef}</p>
            <p class="item-description">${description}</p>
            <div class="item-tags">
              <span class="tag">${category}</span>
            </div>
            <div class="item-rating">
              <div class="stars">
                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
              </div>
              <span class="reviews">(N/A reviews)</span>
            </div>
            <div class="item-meta">
              <span class="item-price">$${parseFloat(price).toFixed(2)}</span>
              <button class="add-to-cart" data-id="${id}">
                <i class="fas fa-plus"></i> Add to Cart
              </button>
            </div>
          </div>
        </div>
      `);
    });
  
    // Insert into DOM
    const container = document.querySelector('.menu-categories');
    container.innerHTML = ''; // Clear existing
  
    Object.entries(categorySections).forEach(([category, itemsHTML]) => {
      const section = `
        <div class="category reveal" data-category="${category.toLowerCase()}">
          <h2 class="category-title">${category}</h2>
          <div class="menu-items">
            ${itemsHTML.join('')}
          </div>
        </div>
      `;
      container.innerHTML += section;
    });
  
    attachCartListeners(); // Add listeners after DOM update
  }
  
  function attachCartListeners() {
    const buttons = document.querySelectorAll('.add-to-cart');
    buttons.forEach(button => {
      button.addEventListener('click', () => {
        const id = button.getAttribute('data-id');
  
        fetch('http://localhost/backend.php?action=add_to_cart', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            menu_item_id: id,
            quantity: 1
          })
        })
        .then(res => res.json())
        .then(data => {
          console.log(data.message);
          cartItems++;
          cartNumber.textContent = cartItems;
          button.style.transform = 'scale(1.1)';
          setTimeout(() => {
            button.style.transform = 'translateY(-2px)';
          }, 100);
        })
        .catch(err => console.error('Cart error:', err));
      });
    });
  }
  
  // Function to apply filter
  function applyFilter(filter) {
    // Show/hide categories based on filter
    categories.forEach(category => {
      if (filter === 'all' || category.getAttribute('data-category') === filter) {
        category.style.display = 'block';
      } else {
        category.style.display = 'none';
      }
    });
  }
  
  // Initialize with "all" filter active
  document.addEventListener('DOMContentLoaded', () => {
    // Show all categories on initial load
    applyFilter('all');
  });
  
  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      // Remove active class from all buttons
      filterButtons.forEach(btn => btn.classList.remove('active'));
      
      // Add active class to clicked button
      button.classList.add('active');
      
      const filter = button.getAttribute('data-filter');
      
      // Apply the selected filter
      applyFilter(filter);
    });
  });
  
  // Animation on scroll
  window.addEventListener('scroll', revealOnScroll);
  
  function revealOnScroll() {
    const reveals = document.querySelectorAll('.reveal');
    
    reveals.forEach(reveal => {
      const windowHeight = window.innerHeight;
      const revealTop = reveal.getBoundingClientRect().top;
      const revealPoint = 150;
      
      if (revealTop < windowHeight - revealPoint) {
        reveal.classList.add('active');
        
        // Add transition properties
        reveal.style.transition = 'all 1s ease-in-out';
      }
    });
  }
  
  // Initialize animations
  revealOnScroll();
  
  // Cart functionality
  const addToCartButtons = document.querySelectorAll('.add-to-cart');
  const cartNumber = document.querySelector('.cart-number');
  let cartItems = 0;
  
  addToCartButtons.forEach(button => {
    button.addEventListener('click', () => {
      cartItems++;
      cartNumber.textContent = cartItems;
      
      // Animation for button
      button.style.transform = 'scale(1.1)';
      setTimeout(() => {
        button.style.transform = 'translateY(-2px)';
      }, 100);
    });
  });
  document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', function () {
      const card = this.closest('.menu-item');
      const title = card.querySelector('.item-title').innerText;
      const chef = card.querySelector('.item-chef').innerText.replace('By ', '');
      const price = parseFloat(card.querySelector('.item-price').innerText.replace('$', ''));

      fetch('add_to_cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({
          title: title,
          chef: chef,
          price: price,
          quantity: 1
        })
      }).then(res => res.json()).then(data => {
        alert("Item added to cart!");
        console.log(data);
      });
    });
  });
  function updateCartCount() {
    fetch('php/get_cart.php')
      .then(res => res.json())
      .then(items => {
        const totalItems = items.reduce((acc, item) => acc + parseInt(item.quantity), 0);
        document.querySelectorAll('.cart-number').forEach(el => el.textContent = totalItems);
      });
  }
  
  document.addEventListener("DOMContentLoaded", () => {
    updateCartCount();
  
    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', function () {
        const card = this.closest('.menu-item');
        const title = card.querySelector('.item-title').innerText;
        const chef = card.querySelector('.item-chef').innerText.replace('By ', '');
        const price = parseFloat(card.querySelector('.item-price').innerText.replace('$', ''));
  
        fetch('php/add_to_cart.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({
            title: title,
            chef: chef,
            price: price,
            quantity: 1
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === "success") {
            updateCartCount();
          } else {
            alert("Add failed: " + data.message);
          }
        })
        .catch(err => console.error("Fetch error:", err));
      });
    });
  });