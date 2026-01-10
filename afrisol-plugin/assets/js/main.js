/**
 * Afrisol - Main JavaScript
 * Solar Solutions for a Sustainable Africa
 */

(function($) {
    'use strict';

    // Initialize when DOM is ready
    $(document).ready(function() {
        Afrisol.init();
    });

    // Global Afrisol object
    window.Afrisol = {
        init: function() {
            this.initHeader();
            this.initHeroSlider();
            this.initScrollAnimations();
            this.initScrollToTop();
            this.initMobileMenu();
            this.initDropdowns();
            this.initTabs();
            this.initAccordion();
            this.initModal();
            this.initLazyLoading();
            this.initPWAPrompt();
            this.initQuantitySelectors();
            this.initProductActions();
            this.initFilters();
            this.initTooltips();
        },

        // Header functionality
        initHeader: function() {
            const header = document.querySelector('.afrisol-header');
            if (!header) return;

            let lastScroll = 0;
            const scrollThreshold = 100;

            window.addEventListener('scroll', function() {
                const currentScroll = window.pageYOffset;

                // Add/remove scrolled class
                if (currentScroll > scrollThreshold) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }

                lastScroll = currentScroll;
            });
        },

        // Hero Slider
        initHeroSlider: function() {
            const heroSlider = document.querySelector('.afrisol-hero-slider .swiper');
            if (!heroSlider) return;

            new Swiper(heroSlider, {
                loop: true,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.afrisol-hero-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.afrisol-hero-next',
                    prevEl: '.afrisol-hero-prev',
                },
                on: {
                    slideChange: function() {
                        // Animate content on slide change
                        const activeSlide = this.slides[this.activeIndex];
                        const content = activeSlide.querySelector('.afrisol-hero-content');
                        if (content) {
                            content.classList.remove('animated');
                            setTimeout(() => content.classList.add('animated'), 100);
                        }
                    }
                }
            });
        },

        // Scroll animations
        initScrollAnimations: function() {
            const animatedElements = document.querySelectorAll('.afrisol-animate');
            if (!animatedElements.length) return;

            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            animatedElements.forEach(el => observer.observe(el));
        },

        // Scroll to top button
        initScrollToTop: function() {
            const scrollBtn = document.getElementById('afrisol-scroll-top');
            if (!scrollBtn) return;

            const progressBar = scrollBtn.querySelector('.afrisol-scroll-progress-bar');
            const circumference = 2 * Math.PI * 46; // 2 * PI * radius (46)

            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                const scrollPercent = scrollTop / docHeight;

                // Show/hide button
                if (scrollTop > 300) {
                    scrollBtn.classList.add('visible');
                } else {
                    scrollBtn.classList.remove('visible');
                }

                // Update progress ring
                if (progressBar) {
                    const offset = circumference - (scrollPercent * circumference);
                    progressBar.style.strokeDashoffset = offset;
                }
            });

            scrollBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        },

        // Mobile menu
        initMobileMenu: function() {
            const menuToggle = document.getElementById('afrisol-menu-toggle');
            const nav = document.getElementById('afrisol-nav');
            if (!menuToggle || !nav) return;

            menuToggle.addEventListener('click', function() {
                this.classList.toggle('active');
                nav.classList.toggle('active');
                document.body.classList.toggle('menu-open');
            });

            // Close menu on outside click
            document.addEventListener('click', function(e) {
                if (!nav.contains(e.target) && !menuToggle.contains(e.target)) {
                    menuToggle.classList.remove('active');
                    nav.classList.remove('active');
                    document.body.classList.remove('menu-open');
                }
            });
        },

        // Dropdown menus
        initDropdowns: function() {
            const dropdownParents = document.querySelectorAll('.afrisol-nav-item.has-dropdown');
            
            dropdownParents.forEach(parent => {
                const link = parent.querySelector('.afrisol-nav-link');
                
                // Mobile: toggle on click
                if (window.innerWidth <= 992) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        parent.classList.toggle('open');
                    });
                }
            });
        },

        // Tabs
        initTabs: function() {
            const tabContainers = document.querySelectorAll('.afrisol-tabs');
            
            tabContainers.forEach(container => {
                const tabs = container.querySelectorAll('.afrisol-tab');
                const tabContents = container.parentElement.querySelectorAll('.afrisol-tab-content');
                
                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        const target = this.dataset.tab;
                        
                        // Remove active class from all tabs and contents
                        tabs.forEach(t => t.classList.remove('active'));
                        tabContents.forEach(c => c.classList.remove('active'));
                        
                        // Add active class to clicked tab and corresponding content
                        this.classList.add('active');
                        const targetContent = container.parentElement.querySelector(`[data-tab-content="${target}"]`);
                        if (targetContent) {
                            targetContent.classList.add('active');
                        }
                    });
                });
            });
        },

        // Accordion/FAQ
        initAccordion: function() {
            const accordionItems = document.querySelectorAll('.afrisol-faq-item, .afrisol-qa-item');
            
            accordionItems.forEach(item => {
                const question = item.querySelector('.afrisol-faq-question, .afrisol-question');
                if (!question) return;
                
                question.addEventListener('click', function() {
                    const isOpen = item.classList.contains('open');
                    
                    // Close all items
                    accordionItems.forEach(i => i.classList.remove('open'));
                    
                    // Toggle clicked item
                    if (!isOpen) {
                        item.classList.add('open');
                    }
                });
            });
        },

        // Modal
        initModal: function() {
            // Open modal
            document.querySelectorAll('[data-modal]').forEach(trigger => {
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    const modalId = this.dataset.modal;
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                });
            });

            // Close modal
            document.querySelectorAll('.afrisol-modal-close, .afrisol-modal-overlay').forEach(closer => {
                closer.addEventListener('click', function(e) {
                    if (e.target === this) {
                        const modal = this.closest('.afrisol-modal-overlay');
                        if (modal) {
                            modal.classList.remove('active');
                            document.body.style.overflow = '';
                        }
                    }
                });
            });

            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.afrisol-modal-overlay.active').forEach(modal => {
                        modal.classList.remove('active');
                        document.body.style.overflow = '';
                    });
                }
            });
        },

        // Lazy loading images
        initLazyLoading: function() {
            const lazyImages = document.querySelectorAll('.afrisol-lazy');
            if (!lazyImages.length) return;

            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            if (img.dataset.srcset) {
                                img.srcset = img.dataset.srcset;
                            }
                            img.classList.add('loaded');
                            imageObserver.unobserve(img);
                        }
                    });
                });

                lazyImages.forEach(img => imageObserver.observe(img));
            } else {
                // Fallback for older browsers
                lazyImages.forEach(img => {
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                });
            }
        },

        // PWA Install Prompt
        initPWAPrompt: function() {
            let deferredPrompt;
            const pwaPrompt = document.getElementById('pwaInstallPrompt');
            const installBtn = document.getElementById('pwaInstallBtn');
            const dismissBtn = document.getElementById('pwaDismissBtn');

            if (!pwaPrompt) return;

            // Check if already installed or dismissed
            if (localStorage.getItem('afrisol_pwa_dismissed')) {
                return;
            }

            // Listen for beforeinstallprompt
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;
                
                // Show prompt after 5 seconds
                setTimeout(() => {
                    pwaPrompt.style.display = 'block';
                }, 5000);
            });

            // Install button click
            if (installBtn) {
                installBtn.addEventListener('click', async () => {
                    if (!deferredPrompt) return;
                    
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    
                    if (outcome === 'accepted') {
                        console.log('PWA installed');
                    }
                    
                    deferredPrompt = null;
                    pwaPrompt.style.display = 'none';
                });
            }

            // Dismiss button click
            if (dismissBtn) {
                dismissBtn.addEventListener('click', () => {
                    pwaPrompt.style.display = 'none';
                    localStorage.setItem('afrisol_pwa_dismissed', 'true');
                });
            }
        },

        // Quantity selectors
        initQuantitySelectors: function() {
            document.querySelectorAll('.afrisol-quantity').forEach(qty => {
                const minusBtn = qty.querySelector('.afrisol-quantity-btn:first-child');
                const plusBtn = qty.querySelector('.afrisol-quantity-btn:last-child');
                const input = qty.querySelector('.afrisol-quantity-input');
                
                if (!input) return;

                if (minusBtn) {
                    minusBtn.addEventListener('click', () => {
                        const currentVal = parseInt(input.value) || 1;
                        if (currentVal > 1) {
                            input.value = currentVal - 1;
                            input.dispatchEvent(new Event('change'));
                        }
                    });
                }

                if (plusBtn) {
                    plusBtn.addEventListener('click', () => {
                        const currentVal = parseInt(input.value) || 1;
                        const max = parseInt(input.max) || 999;
                        if (currentVal < max) {
                            input.value = currentVal + 1;
                            input.dispatchEvent(new Event('change'));
                        }
                    });
                }
            });
        },

        // Product actions (add to cart, wishlist, etc.)
        initProductActions: function() {
            const self = this;
            
            // Add to cart
            document.querySelectorAll('.afrisol-add-to-cart').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    const quantity = this.closest('.afrisol-product-card, .afrisol-product-details')?.querySelector('.afrisol-quantity-input')?.value || 1;
                    
                    self.addToCart(productId, quantity);
                });
            });

            // Add to wishlist
            document.querySelectorAll('.afrisol-add-to-wishlist').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    self.toggleWishlist(productId, this);
                });
            });

            // Quick view
            document.querySelectorAll('.afrisol-quick-view').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    self.openQuickView(productId);
                });
            });

            // Compare
            document.querySelectorAll('.afrisol-add-to-compare').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    self.toggleCompare(productId, this);
                });
            });
        },

        // Add to cart function
        addToCart: function(productId, quantity) {
            const btn = document.querySelector(`.afrisol-add-to-cart[data-product-id="${productId}"]`);
            if (btn) {
                btn.classList.add('loading');
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }

            $.ajax({
                url: afrisol_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'afrisol_add_to_cart',
                    product_id: productId,
                    quantity: quantity,
                    nonce: afrisol_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Update cart count
                        const cartCount = document.querySelector('.afrisol-cart-count');
                        if (cartCount) {
                            cartCount.textContent = response.data.cart_count;
                            cartCount.classList.add('bounce');
                            setTimeout(() => cartCount.classList.remove('bounce'), 300);
                        }
                        
                        // Show success message
                        Afrisol.showNotification('Product added to cart!', 'success');
                        
                        if (btn) {
                            btn.innerHTML = '<i class="fas fa-check"></i> Added';
                            setTimeout(() => {
                                btn.classList.remove('loading');
                                btn.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
                            }, 2000);
                        }
                    } else {
                        Afrisol.showNotification(response.data.message || 'Error adding to cart', 'error');
                        if (btn) {
                            btn.classList.remove('loading');
                            btn.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
                        }
                    }
                },
                error: function() {
                    Afrisol.showNotification('Error adding to cart', 'error');
                    if (btn) {
                        btn.classList.remove('loading');
                        btn.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
                    }
                }
            });
        },

        // Toggle wishlist
        toggleWishlist: function(productId, btn) {
            $.ajax({
                url: afrisol_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'afrisol_toggle_wishlist',
                    product_id: productId,
                    nonce: afrisol_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        if (response.data.added) {
                            btn.classList.add('active');
                            btn.innerHTML = '<i class="fas fa-heart"></i>';
                            Afrisol.showNotification('Added to wishlist!', 'success');
                        } else {
                            btn.classList.remove('active');
                            btn.innerHTML = '<i class="far fa-heart"></i>';
                            Afrisol.showNotification('Removed from wishlist', 'success');
                        }
                    }
                }
            });
        },

        // Open quick view
        openQuickView: function(productId) {
            const modal = document.getElementById('quickViewModal');
            const content = modal?.querySelector('.afrisol-quickview-content');
            
            if (!modal || !content) return;

            content.innerHTML = '<div class="afrisol-flex-center" style="height:300px"><div class="afrisol-spinner"></div></div>';
            modal.classList.add('active');

            $.ajax({
                url: afrisol_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'afrisol_get_product_quickview',
                    product_id: productId,
                    nonce: afrisol_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        content.innerHTML = response.data.html;
                        Afrisol.initQuantitySelectors();
                        Afrisol.initProductActions();
                    }
                }
            });
        },

        // Toggle compare
        toggleCompare: function(productId, btn) {
            let compareList = JSON.parse(localStorage.getItem('afrisol_compare') || '[]');
            const index = compareList.indexOf(productId);

            if (index > -1) {
                compareList.splice(index, 1);
                btn.classList.remove('active');
                Afrisol.showNotification('Removed from compare', 'success');
            } else {
                if (compareList.length >= 4) {
                    Afrisol.showNotification('You can only compare up to 4 products', 'warning');
                    return;
                }
                compareList.push(productId);
                btn.classList.add('active');
                Afrisol.showNotification('Added to compare', 'success');
            }

            localStorage.setItem('afrisol_compare', JSON.stringify(compareList));
            this.updateCompareBar(compareList);
        },

        // Update compare bar
        updateCompareBar: function(compareList) {
            const compareBar = document.querySelector('.afrisol-compare-bar');
            if (!compareBar) return;

            if (compareList.length > 0) {
                compareBar.classList.add('visible');
                // Update compare bar content via AJAX if needed
            } else {
                compareBar.classList.remove('visible');
            }
        },

        // Product filters
        initFilters: function() {
            const filterForm = document.getElementById('productFilters');
            if (!filterForm) return;

            // Price range slider
            const priceMin = filterForm.querySelector('#priceMin');
            const priceMax = filterForm.querySelector('#priceMax');
            const minSlider = filterForm.querySelector('#priceMinSlider');
            const maxSlider = filterForm.querySelector('#priceMaxSlider');

            if (minSlider && maxSlider) {
                minSlider.addEventListener('input', () => {
                    priceMin.value = minSlider.value;
                });
                maxSlider.addEventListener('input', () => {
                    priceMax.value = maxSlider.value;
                });
            }

            // Filter checkboxes
            filterForm.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    this.applyFilters();
                });
            });

            // Sort select
            const sortSelect = document.querySelector('.afrisol-sort-select');
            if (sortSelect) {
                sortSelect.addEventListener('change', () => {
                    this.applyFilters();
                });
            }

            // View toggle
            document.querySelectorAll('.afrisol-view-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const view = this.dataset.view;
                    const grid = document.querySelector('.afrisol-products-grid');
                    
                    document.querySelectorAll('.afrisol-view-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    if (grid) {
                        grid.classList.remove('list-view', 'grid-view');
                        grid.classList.add(view + '-view');
                    }
                });
            });
        },

        // Apply filters
        applyFilters: function() {
            const filterForm = document.getElementById('productFilters');
            const productsGrid = document.querySelector('.afrisol-products-grid');
            if (!filterForm || !productsGrid) return;

            // Show loading
            productsGrid.classList.add('loading');

            const formData = new FormData(filterForm);
            formData.append('action', 'afrisol_filter_products');
            formData.append('nonce', afrisol_ajax.nonce);

            // Add sort value
            const sortSelect = document.querySelector('.afrisol-sort-select');
            if (sortSelect) {
                formData.append('sort', sortSelect.value);
            }

            $.ajax({
                url: afrisol_ajax.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        productsGrid.innerHTML = response.data.html;
                        
                        // Update count
                        const countEl = document.querySelector('.afrisol-products-count strong');
                        if (countEl) {
                            countEl.textContent = response.data.count;
                        }
                        
                        // Reinitialize product actions
                        Afrisol.initProductActions();
                    }
                    productsGrid.classList.remove('loading');
                },
                error: function() {
                    productsGrid.classList.remove('loading');
                }
            });
        },

        // Tooltips
        initTooltips: function() {
            document.querySelectorAll('[data-tooltip]').forEach(el => {
                el.classList.add('afrisol-tooltip');
            });
        },

        // Show notification
        showNotification: function(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `afrisol-notification afrisol-notification-${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
                <span>${message}</span>
            `;

            // Add notification styles if not exists
            if (!document.getElementById('afrisol-notification-styles')) {
                const styles = document.createElement('style');
                styles.id = 'afrisol-notification-styles';
                styles.textContent = `
                    .afrisol-notification {
                        position: fixed;
                        top: 100px;
                        right: 20px;
                        padding: 1rem 1.5rem;
                        border-radius: 8px;
                        display: flex;
                        align-items: center;
                        gap: 0.75rem;
                        font-weight: 500;
                        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                        z-index: 10000;
                        animation: slideInRight 0.3s ease-out;
                    }
                    .afrisol-notification-success { background: #E8F5E9; color: #2E7D32; }
                    .afrisol-notification-error { background: #FFEBEE; color: #C62828; }
                    .afrisol-notification-warning { background: #FFF3E0; color: #E65100; }
                    .afrisol-notification-info { background: #E3F2FD; color: #1565C0; }
                    @keyframes slideInRight {
                        from { transform: translateX(100%); opacity: 0; }
                        to { transform: translateX(0); opacity: 1; }
                    }
                `;
                document.head.appendChild(styles);
            }

            document.body.appendChild(notification);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideInRight 0.3s ease-out reverse';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        },

        // Format price
        formatPrice: function(price) {
            return new Intl.NumberFormat('en-NG', {
                style: 'currency',
                currency: 'NGN',
                minimumFractionDigits: 0
            }).format(price);
        }
    };

})(jQuery);