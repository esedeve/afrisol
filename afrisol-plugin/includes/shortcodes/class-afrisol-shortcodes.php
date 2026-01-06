<?php
/**
 * Afrisol Shortcodes Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Afrisol_Shortcodes {

    public function __construct() {
        // Header and Footer shortcodes
        add_shortcode('afrisol_header', array($this, 'site_header'));
        add_shortcode('afrisol_footer', array($this, 'site_footer'));
        
        // Landing page shortcodes
        add_shortcode('afrisol_hero', array($this, 'hero_slider'));
        add_shortcode('afrisol_trust_indicators', array($this, 'trust_indicators'));
        add_shortcode('afrisol_services', array($this, 'services_section'));
        add_shortcode('afrisol_why_choose', array($this, 'why_choose_section'));
        add_shortcode('afrisol_featured_products', array($this, 'featured_products'));
        add_shortcode('afrisol_testimonials', array($this, 'testimonials'));
        add_shortcode('afrisol_map', array($this, 'map_section'));
        add_shortcode('afrisol_contact_form', array($this, 'contact_form'));
        
        // Page shortcodes
        add_shortcode('afrisol_products', array($this, 'products_page'));
        add_shortcode('afrisol_cart', array($this, 'cart_page'));
        add_shortcode('afrisol_checkout', array($this, 'checkout_page'));
        add_shortcode('afrisol_customer_portal', array($this, 'customer_portal'));
        add_shortcode('afrisol_solar_calculator', array($this, 'solar_calculator'));
        add_shortcode('afrisol_quote_form', array($this, 'quote_form'));
        add_shortcode('afrisol_repair_form', array($this, 'repair_form'));
        
        // Combined landing page shortcode
        add_shortcode('afrisol_landing_page', array($this, 'landing_page'));
    }

    /**
     * Site Header
     */
    public function site_header($atts) {
        $logo_url = AFRISOL_PLUGIN_URL . 'assets/images/logo.svg';
        $cart_count = 0;
        if (class_exists('Afrisol_Cart')) {
            $cart = new Afrisol_Cart();
            $cart_count = $cart->get_cart_count();
        }
        
        ob_start();
        ?>
        <header class="afrisol-header" id="afrisol-header">
            <div class="afrisol-container">
                <div class="afrisol-header-inner">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="afrisol-logo">
                        <img src="<?php echo esc_url($logo_url); ?>" alt="Afrisol - Solar Solutions">
                    </a>
                    
                    <nav class="afrisol-nav" id="afrisol-nav">
                        <ul class="afrisol-nav-menu">
                            <li class="afrisol-nav-item">
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="afrisol-nav-link">Home</a>
                            </li>
                            <li class="afrisol-nav-item has-dropdown">
                                <a href="<?php echo esc_url(home_url('/afrisol/products')); ?>" class="afrisol-nav-link">
                                    Products <i class="fas fa-chevron-down"></i>
                                </a>
                                <div class="afrisol-dropdown">
                                    <a href="<?php echo esc_url(home_url('/afrisol/products?cat=solar-power')); ?>" class="afrisol-dropdown-item">Solar Power Systems</a>
                                    <a href="<?php echo esc_url(home_url('/afrisol/products?cat=lighting')); ?>" class="afrisol-dropdown-item">Lighting Solutions</a>
                                    <a href="<?php echo esc_url(home_url('/afrisol/products?cat=security')); ?>" class="afrisol-dropdown-item">Security Systems</a>
                                    <a href="<?php echo esc_url(home_url('/afrisol/products?cat=mobility')); ?>" class="afrisol-dropdown-item">Solar Mobility</a>
                                    <a href="<?php echo esc_url(home_url('/afrisol/products?cat=water-heating')); ?>" class="afrisol-dropdown-item">Water Heating</a>
                                    <a href="<?php echo esc_url(home_url('/afrisol/products?cat=networking')); ?>" class="afrisol-dropdown-item">Networking</a>
                                </div>
                            </li>
                            <li class="afrisol-nav-item has-dropdown">
                                <a href="<?php echo esc_url(home_url('/afrisol/services')); ?>" class="afrisol-nav-link">
                                    Services <i class="fas fa-chevron-down"></i>
                                </a>
                                <div class="afrisol-dropdown">
                                    <a href="<?php echo esc_url(home_url('/afrisol/services#installation')); ?>" class="afrisol-dropdown-item">Installation Services</a>
                                    <a href="<?php echo esc_url(home_url('/afrisol/services#repair')); ?>" class="afrisol-dropdown-item">Repair & Maintenance</a>
                                    <a href="<?php echo esc_url(home_url('/afrisol/solar-calculator')); ?>" class="afrisol-dropdown-item">Solar Calculator</a>
                                </div>
                            </li>
                            <li class="afrisol-nav-item">
                                <a href="<?php echo esc_url(home_url('/afrisol/about')); ?>" class="afrisol-nav-link">About</a>
                            </li>
                            <li class="afrisol-nav-item">
                                <a href="<?php echo esc_url(home_url('/afrisol/blog')); ?>" class="afrisol-nav-link">Blog</a>
                            </li>
                            <li class="afrisol-nav-item">
                                <a href="<?php echo esc_url(home_url('/afrisol/contact')); ?>" class="afrisol-nav-link">Contact</a>
                            </li>
                        </ul>
                    </nav>
                    
                    <div class="afrisol-header-actions">
                        <a href="<?php echo esc_url(home_url('/afrisol/cart')); ?>" class="afrisol-header-icon" title="Cart">
                            <i class="fas fa-shopping-cart"></i>
                            <?php if ($cart_count > 0) : ?>
                                <span class="badge"><?php echo esc_html($cart_count); ?></span>
                            <?php endif; ?>
                        </a>
                        <?php if (is_user_logged_in()) : ?>
                            <a href="<?php echo esc_url(home_url('/afrisol/portal')); ?>" class="afrisol-header-icon" title="My Account">
                                <i class="fas fa-user"></i>
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo esc_url(home_url('/afrisol/get-quote')); ?>" class="afrisol-btn afrisol-btn-primary afrisol-btn-sm">
                            Get Quote
                        </a>
                        <button class="afrisol-menu-toggle" id="afrisol-menu-toggle" aria-label="Toggle Menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <?php
        return ob_get_clean();
    }

    /**
     * Site Footer
     */
    public function site_footer($atts) {
        $logo_url = AFRISOL_PLUGIN_URL . 'assets/images/logo-white.svg';
        $phone = get_option('afrisol_phone', '+234 XXX XXX XXXX');
        $email = get_option('afrisol_email', 'info@afrisol.com');
        $whatsapp = get_option('afrisol_whatsapp', '+234 XXX XXX XXXX');
        $address = get_option('afrisol_address', 'Suite 15C, Al-Noor Shopping Complex, Ahmadu Bello Way Wuse 2, Abuja.');
        $facebook = get_option('afrisol_facebook', 'https://facebook.com/afrisol');
        $instagram = get_option('afrisol_instagram', 'https://instagram.com/afrisol');
        $tiktok = get_option('afrisol_tiktok', 'https://tiktok.com/@afrisol');
        
        ob_start();
        ?>
        <footer class="afrisol-footer">
            <div class="afrisol-container">
                <div class="afrisol-footer-grid">
                    <div class="afrisol-footer-about">
                        <img src="<?php echo esc_url($logo_url); ?>" alt="Afrisol" class="afrisol-footer-logo">
                        <p>Powering Africa's future with sustainable solar energy solutions. From residential to commercial installations, we provide reliable clean energy systems.</p>
                        <div class="afrisol-footer-social">
                            <a href="<?php echo esc_url($facebook); ?>" class="afrisol-social-link" target="_blank" rel="noopener" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="<?php echo esc_url($instagram); ?>" class="afrisol-social-link" target="_blank" rel="noopener" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="<?php echo esc_url($tiktok); ?>" class="afrisol-social-link" target="_blank" rel="noopener" title="TikTok">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="afrisol-footer-links-col">
                        <h4 class="afrisol-footer-title">Quick Links</h4>
                        <ul class="afrisol-footer-links">
                            <li><a href="<?php echo esc_url(home_url('/afrisol/products')); ?>">Products</a></li>
                            <li><a href="<?php echo esc_url(home_url('/afrisol/services')); ?>">Services</a></li>
                            <li><a href="<?php echo esc_url(home_url('/afrisol/solar-calculator')); ?>">Solar Calculator</a></li>
                            <li><a href="<?php echo esc_url(home_url('/afrisol/get-quote')); ?>">Get a Quote</a></li>
                            <li><a href="<?php echo esc_url(home_url('/afrisol/book-repair')); ?>">Book Repair</a></li>
                        </ul>
                    </div>
                    
                    <div class="afrisol-footer-links-col">
                        <h4 class="afrisol-footer-title">Company</h4>
                        <ul class="afrisol-footer-links">
                            <li><a href="<?php echo esc_url(home_url('/afrisol/about')); ?>">About Us</a></li>
                            <li><a href="<?php echo esc_url(home_url('/afrisol/blog')); ?>">Blog</a></li>
                            <li><a href="<?php echo esc_url(home_url('/afrisol/contact')); ?>">Contact</a></li>
                            <li><a href="<?php echo esc_url(home_url('/afrisol/portal')); ?>">Customer Portal</a></li>
                        </ul>
                    </div>
                    
                    <div class="afrisol-footer-contact-col">
                        <h4 class="afrisol-footer-title">Contact Info</h4>
                        <ul class="afrisol-footer-contact">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo esc_html($address); ?></span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                            </li>
                            <li>
                                <i class="fab fa-whatsapp"></i>
                                <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" target="_blank" rel="noopener"><?php echo esc_html($whatsapp); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="afrisol-footer-bottom">
                    <p>&copy; <?php echo esc_html(date('Y')); ?> Afrisol. All rights reserved.</p>
                    <div class="afrisol-footer-bottom-links">
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
        
        <!-- WhatsApp Widget -->
        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" class="afrisol-whatsapp-widget" target="_blank" rel="noopener" title="Chat on WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
        
        <!-- Scroll to Top -->
        <button class="afrisol-scroll-top" id="afrisol-scroll-top" title="Scroll to Top">
            <svg class="afrisol-scroll-progress" viewBox="0 0 100 100">
                <circle class="afrisol-scroll-progress-bg" cx="50" cy="50" r="46"></circle>
                <circle class="afrisol-scroll-progress-bar" cx="50" cy="50" r="46"></circle>
            </svg>
            <i class="fas fa-arrow-up"></i>
        </button>
        <?php
        return ob_get_clean();
    }

    /**
     * Complete Landing Page - All sections combined
     */
    public function landing_page($atts) {
        ob_start();
        
        // Header
        echo $this->site_header($atts);
        
        // Hero Slider
        echo $this->hero_slider($atts);
        
        // Trust Indicators
        echo $this->trust_indicators($atts);
        
        // Services Section
        echo $this->services_section($atts);
        
        // Why Choose Us
        echo $this->why_choose_section($atts);
        
        // Featured Products
        echo $this->featured_products($atts);
        
        // Testimonials
        echo $this->testimonials($atts);
        
        // Map Section
        echo $this->map_section($atts);
        
        // Contact Form
        echo $this->contact_form($atts);
        
        // Footer
        echo $this->site_footer($atts);
        
        return ob_get_clean();
    }

    /**
     * Hero Slider
     */
    public function hero_slider($atts) {
        $slides = get_posts(array(
            'post_type' => 'afrisol_slider',
            'posts_per_page' => -1,
            'meta_key' => '_afrisol_slider_order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        ));

        ob_start();
        ?>
        <section class="afrisol-hero">
            <div class="afrisol-hero-slider">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php if ($slides) : foreach ($slides as $slide) : 
                            $subtitle = get_post_meta($slide->ID, '_afrisol_slider_subtitle', true);
                            $cta_text = get_post_meta($slide->ID, '_afrisol_slider_cta_text', true);
                            $cta_link = get_post_meta($slide->ID, '_afrisol_slider_cta_link', true);
                        ?>
                            <div class="swiper-slide afrisol-hero-slide">
                                <div class="afrisol-hero-bg">
                                    <?php if (has_post_thumbnail($slide->ID)) : ?>
                                        <?php echo get_the_post_thumbnail($slide->ID, 'full'); ?>
                                    <?php else : ?>
                                        <div style="background: linear-gradient(135deg, #1B5E20, #2E7D32); width: 100%; height: 100%;"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="afrisol-container">
                                    <div class="afrisol-hero-content">
                                        <?php if ($subtitle) : ?>
                                            <span class="afrisol-hero-subtitle"><?php echo esc_html($subtitle); ?></span>
                                        <?php endif; ?>
                                        <h1 class="afrisol-hero-title afrisol-sparkle-text"><?php echo esc_html($slide->post_title); ?></h1>
                                        <div class="afrisol-hero-buttons">
                                            <a href="<?php echo esc_url(home_url('/get-quote')); ?>" class="afrisol-btn afrisol-btn-secondary">
                                                <i class="fas fa-file-invoice"></i> Get Free Quote
                                            </a>
                                            <a href="<?php echo esc_url(home_url('/products')); ?>" class="afrisol-btn afrisol-btn-outline-white">
                                                <i class="fas fa-shopping-bag"></i> Shop Products
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; else : ?>
                            <div class="swiper-slide afrisol-hero-slide">
                                <div class="afrisol-hero-bg">
                                    <div style="background: linear-gradient(135deg, #1B5E20, #2E7D32); width: 100%; height: 100%;"></div>
                                </div>
                                <div class="afrisol-container">
                                    <div class="afrisol-hero-content">
                                        <span class="afrisol-hero-subtitle">Solar Solutions for Africa</span>
                                        <h1 class="afrisol-hero-title afrisol-sparkle-text">Power Your Future with <span class="highlight">Clean Energy</span></h1>
                                        <p class="afrisol-hero-desc">Reliable solar power systems, security solutions, and electric mobility for homes and businesses across Africa.</p>
                                        <div class="afrisol-hero-buttons">
                                            <a href="<?php echo esc_url(home_url('/get-quote')); ?>" class="afrisol-btn afrisol-btn-secondary">
                                                <i class="fas fa-file-invoice"></i> Get Free Quote
                                            </a>
                                            <a href="<?php echo esc_url(home_url('/products')); ?>" class="afrisol-btn afrisol-btn-outline-white">
                                                <i class="fas fa-shopping-bag"></i> Shop Products
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="afrisol-hero-pagination swiper-pagination"></div>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /**
     * Trust Indicators
     */
    public function trust_indicators($atts) {
        ob_start();
        ?>
        <section class="afrisol-trust-section">
            <div class="afrisol-container">
                <div class="afrisol-trust-grid">
                    <div class="afrisol-trust-item afrisol-animate">
                        <div class="afrisol-trust-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="afrisol-trust-content">
                            <h4>Fast Delivery</h4>
                            <p>Nationwide delivery within 3-5 days</p>
                        </div>
                    </div>
                    <div class="afrisol-trust-item afrisol-animate afrisol-animate-delay-1">
                        <div class="afrisol-trust-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="afrisol-trust-content">
                            <h4>Warranty Protection</h4>
                            <p>Up to 25 years on solar panels</p>
                        </div>
                    </div>
                    <div class="afrisol-trust-item afrisol-animate afrisol-animate-delay-2">
                        <div class="afrisol-trust-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="afrisol-trust-content">
                            <h4>Expert Installation</h4>
                            <p>Certified technicians at your service</p>
                        </div>
                    </div>
                    <div class="afrisol-trust-item afrisol-animate afrisol-animate-delay-3">
                        <div class="afrisol-trust-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="afrisol-trust-content">
                            <h4>24/7 Support</h4>
                            <p>Always here to help you</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /**
     * Services Section
     */
    public function services_section($atts) {
        $atts = shortcode_atts(array(
            'limit' => 3
        ), $atts);

        ob_start();
        ?>
        <section class="afrisol-section afrisol-services-section">
            <div class="afrisol-container">
                <div class="afrisol-section-header">
                    <h2 class="afrisol-sparkle-text">Our Services</h2>
                    <p>Comprehensive solar and security solutions for your home and business</p>
                </div>
                
                <div class="afrisol-grid afrisol-grid-3">
                    <div class="afrisol-service-card afrisol-animate">
                        <div class="afrisol-service-icon">
                            <i class="fas fa-solar-panel"></i>
                        </div>
                        <h3>Solar Energy Solutions</h3>
                        <p>Complete solar power systems including panels, inverters, and batteries for homes and businesses.</p>
                        <ul class="afrisol-service-features">
                            <li><i class="fas fa-check"></i> Solar Panels Installation</li>
                            <li><i class="fas fa-check"></i> Inverter Systems</li>
                            <li><i class="fas fa-check"></i> Battery Storage</li>
                            <li><i class="fas fa-check"></i> Complete Solar Kits</li>
                        </ul>
                        <a href="<?php echo home_url('/services'); ?>" class="afrisol-btn afrisol-btn-outline afrisol-btn-sm">Learn More</a>
                    </div>
                    
                    <div class="afrisol-service-card afrisol-animate afrisol-animate-delay-1">
                        <div class="afrisol-service-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Security & Surveillance</h3>
                        <p>Advanced security systems to protect your property with cutting-edge technology.</p>
                        <ul class="afrisol-service-features">
                            <li><i class="fas fa-check"></i> CCTV Cameras</li>
                            <li><i class="fas fa-check"></i> AI-Powered Cameras</li>
                            <li><i class="fas fa-check"></i> Access Control Systems</li>
                            <li><i class="fas fa-check"></i> Electric Fence & Alarms</li>
                        </ul>
                        <a href="<?php echo home_url('/services'); ?>" class="afrisol-btn afrisol-btn-outline afrisol-btn-sm">Learn More</a>
                    </div>
                    
                    <div class="afrisol-service-card afrisol-animate afrisol-animate-delay-2">
                        <div class="afrisol-service-icon">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <h3>Solar Mobility</h3>
                        <p>Eco-friendly electric vehicles powered by clean energy for sustainable transportation.</p>
                        <ul class="afrisol-service-features">
                            <li><i class="fas fa-check"></i> Electric Scooters</li>
                            <li><i class="fas fa-check"></i> Electric Bikes</li>
                            <li><i class="fas fa-check"></i> Tricycles</li>
                            <li><i class="fas fa-check"></i> Electric Vehicles</li>
                        </ul>
                        <a href="<?php echo home_url('/services'); ?>" class="afrisol-btn afrisol-btn-outline afrisol-btn-sm">Learn More</a>
                    </div>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /**
     * Why Choose Us Section
     */
    public function why_choose_section($atts) {
        ob_start();
        ?>
        <section class="afrisol-section afrisol-why-section">
            <div class="afrisol-container">
                <div class="afrisol-why-grid">
                    <div class="afrisol-why-image afrisol-animate">
                        <div class="afrisol-why-image-wrapper">
                            <img src="<?php echo AFRISOL_PLUGIN_URL; ?>assets/images/why-choose.jpg" alt="Why Choose Afrisol" 
                                 onerror="this.style.background='linear-gradient(135deg, #1B5E20, #2E7D32)'; this.style.display='block'; this.style.height='400px';">
                        </div>
                        <div class="afrisol-why-stats">
                            <div class="afrisol-why-stats-number">500+</div>
                            <div class="afrisol-why-stats-label">Installations Completed</div>
                        </div>
                    </div>
                    
                    <div class="afrisol-why-content afrisol-animate">
                        <h2 class="afrisol-sparkle-text">Why Choose Afrisol?</h2>
                        <p>We are committed to delivering premium solar solutions that power Africa's sustainable future. With years of experience and a dedicated team, we ensure quality, reliability, and customer satisfaction.</p>
                        
                        <ul class="afrisol-why-list">
                            <li class="afrisol-why-item">
                                <div class="afrisol-why-item-icon">
                                    <i class="fas fa-award"></i>
                                </div>
                                <div class="afrisol-why-item-content">
                                    <h4>Quality Products</h4>
                                    <p>We source only the best equipment from trusted global manufacturers.</p>
                                </div>
                            </li>
                            <li class="afrisol-why-item">
                                <div class="afrisol-why-item-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="afrisol-why-item-content">
                                    <h4>Expert Team</h4>
                                    <p>Our certified technicians ensure professional installation and support.</p>
                                </div>
                            </li>
                            <li class="afrisol-why-item">
                                <div class="afrisol-why-item-icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <div class="afrisol-why-item-content">
                                    <h4>Affordable Financing</h4>
                                    <p>Flexible payment plans to make solar accessible to everyone.</p>
                                </div>
                            </li>
                            <li class="afrisol-why-item">
                                <div class="afrisol-why-item-icon">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <div class="afrisol-why-item-content">
                                    <h4>Sustainable Impact</h4>
                                    <p>Join us in building a greener future for Africa.</p>
                                </div>
                            </li>
                        </ul>
                        
                        <a href="<?php echo home_url('/about'); ?>" class="afrisol-btn afrisol-btn-primary">Learn More About Us</a>
                    </div>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /**
     * Featured Products
     */
    public function featured_products($atts) {
        $atts = shortcode_atts(array(
            'limit' => 8
        ), $atts);

        $products = get_posts(array(
            'post_type' => 'afrisol_product',
            'posts_per_page' => $atts['limit'],
            'meta_query' => array(
                array(
                    'key' => '_afrisol_featured',
                    'value' => '1'
                )
            )
        ));

        // If no featured products, get latest products
        if (empty($products)) {
            $products = get_posts(array(
                'post_type' => 'afrisol_product',
                'posts_per_page' => $atts['limit']
            ));
        }

        ob_start();
        ?>
        <section class="afrisol-section afrisol-products-section">
            <div class="afrisol-container">
                <div class="afrisol-section-header">
                    <h2 class="afrisol-sparkle-text">Featured Products</h2>
                    <p>Best-selling solar solutions and security equipment</p>
                </div>
                
                <div class="afrisol-grid afrisol-grid-4">
                    <?php if ($products) : foreach ($products as $product) : 
                        $price = get_post_meta($product->ID, '_afrisol_price', true);
                        $sale_price = get_post_meta($product->ID, '_afrisol_sale_price', true);
                        $stock_status = get_post_meta($product->ID, '_afrisol_stock_status', true);
                        $categories = get_the_terms($product->ID, 'afrisol_product_cat');
                    ?>
                        <div class="afrisol-product-card afrisol-animate">
                            <div class="afrisol-product-badges">
                                <?php if ($sale_price && $sale_price < $price) : ?>
                                    <span class="afrisol-product-badge sale">Sale</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="afrisol-product-actions">
                                <button class="afrisol-product-action-btn afrisol-add-to-wishlist" data-product-id="<?php echo $product->ID; ?>" data-tooltip="Add to Wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="afrisol-product-action-btn afrisol-quick-view" data-product-id="<?php echo $product->ID; ?>" data-tooltip="Quick View">
                                    <i class="far fa-eye"></i>
                                </button>
                                <button class="afrisol-product-action-btn afrisol-add-to-compare" data-product-id="<?php echo $product->ID; ?>" data-tooltip="Compare">
                                    <i class="fas fa-exchange-alt"></i>
                                </button>
                            </div>
                            
                            <div class="afrisol-product-image">
                                <?php if (has_post_thumbnail($product->ID)) : ?>
                                    <?php echo get_the_post_thumbnail($product->ID, 'medium'); ?>
                                <?php else : ?>
                                    <div style="background: #f5f5f5; height: 100%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image" style="font-size: 3rem; color: #ddd;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="afrisol-product-info">
                                <?php if ($categories) : ?>
                                    <span class="afrisol-product-category"><?php echo esc_html($categories[0]->name); ?></span>
                                <?php endif; ?>
                                
                                <h4 class="afrisol-product-title">
                                    <a href="<?php echo get_permalink($product->ID); ?>"><?php echo esc_html($product->post_title); ?></a>
                                </h4>
                                
                                <div class="afrisol-product-rating">
                                    <span class="stars">
                                        <?php 
                                        $rating = get_post_meta($product->ID, '_afrisol_average_rating', true) ?: 4;
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo $i <= $rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                                        }
                                        ?>
                                    </span>
                                    <span class="count">(<?php echo get_post_meta($product->ID, '_afrisol_review_count', true) ?: 0; ?>)</span>
                                </div>
                                
                                <div class="afrisol-product-price">
                                    <?php if ($sale_price && $sale_price < $price) : ?>
                                        <span class="original">₦<?php echo number_format($price); ?></span>
                                        <span class="current">₦<?php echo number_format($sale_price); ?></span>
                                    <?php else : ?>
                                        <span class="current">₦<?php echo number_format($price); ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="afrisol-product-footer">
                                    <button class="afrisol-btn afrisol-btn-primary afrisol-btn-sm afrisol-add-to-cart" data-product-id="<?php echo $product->ID; ?>">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                    <a href="<?php echo get_permalink($product->ID); ?>" class="afrisol-btn afrisol-btn-outline afrisol-btn-sm">
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; else : ?>
                        <div class="afrisol-no-products" style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                            <p>No products found. Add products in the WordPress admin.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="afrisol-text-center afrisol-mt-4">
                    <a href="<?php echo home_url('/products'); ?>" class="afrisol-btn afrisol-btn-primary">View All Products</a>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /**
     * Testimonials
     */
    public function testimonials($atts) {
        $testimonials = get_posts(array(
            'post_type' => 'afrisol_testimonial',
            'posts_per_page' => 6
        ));

        ob_start();
        ?>
        <section class="afrisol-section afrisol-testimonials-section">
            <div class="afrisol-container">
                <div class="afrisol-section-header">
                    <h2 class="afrisol-sparkle-text">What Our Customers Say</h2>
                    <p>Real feedback from satisfied customers across Africa</p>
                </div>
                
                <div class="afrisol-testimonials-slider">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php if ($testimonials) : foreach ($testimonials as $testimonial) : 
                                $rating = get_post_meta($testimonial->ID, '_afrisol_rating', true) ?: 5;
                                $location = get_post_meta($testimonial->ID, '_afrisol_location', true);
                                $designation = get_post_meta($testimonial->ID, '_afrisol_designation', true);
                            ?>
                                <div class="swiper-slide">
                                    <div class="afrisol-testimonial-card">
                                        <div class="afrisol-testimonial-stars">
                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                <i class="fas fa-star<?php echo $i <= $rating ? '' : '-o'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <p class="afrisol-testimonial-text"><?php echo esc_html($testimonial->post_content); ?></p>
                                        <div class="afrisol-testimonial-author">
                                            <div class="afrisol-testimonial-avatar">
                                                <?php if (has_post_thumbnail($testimonial->ID)) : ?>
                                                    <?php echo get_the_post_thumbnail($testimonial->ID, 'thumbnail'); ?>
                                                <?php else : ?>
                                                    <div style="background: #FF9800; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold;">
                                                        <?php echo strtoupper(substr($testimonial->post_title, 0, 1)); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="afrisol-testimonial-info">
                                                <h4><?php echo esc_html($testimonial->post_title); ?></h4>
                                                <?php if ($location) : ?>
                                                    <div class="afrisol-testimonial-location">
                                                        <i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="afrisol-google-badge">
                                                    <img src="https://www.google.com/favicon.ico" alt="Google"> Verified Review
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; else : ?>
                                <!-- Default testimonials -->
                                <div class="swiper-slide">
                                    <div class="afrisol-testimonial-card">
                                        <div class="afrisol-testimonial-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <p class="afrisol-testimonial-text">"Afrisol transformed our home with their solar installation. We now enjoy uninterrupted power and have significantly reduced our electricity bills. Highly recommend their services!"</p>
                                        <div class="afrisol-testimonial-author">
                                            <div class="afrisol-testimonial-avatar">
                                                <div style="background: #FF9800; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold;">A</div>
                                            </div>
                                            <div class="afrisol-testimonial-info">
                                                <h4>Adebayo Johnson</h4>
                                                <div class="afrisol-testimonial-location">
                                                    <i class="fas fa-map-marker-alt"></i> Lagos, Nigeria
                                                </div>
                                                <div class="afrisol-google-badge">
                                                    <img src="https://www.google.com/favicon.ico" alt="Google"> Verified Review
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="afrisol-testimonials-pagination swiper-pagination"></div>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /**
     * Map Section
     */
    public function map_section($atts) {
        $address = get_option('afrisol_address', 'Suite 15C, Al-Noor Shopping Complex, Al-Noor Mosque, Ahmadu Bello Way Wuse 2, Abuja.');
        $phone = get_option('afrisol_phone', '+234 XXX XXX XXXX');
        $email = get_option('afrisol_email', 'info@afrisol.com');
        $hours = get_option('afrisol_business_hours', 'Mon-Fri: 8AM-6PM, Sat: 9AM-4PM');

        ob_start();
        ?>
        <section class="afrisol-section afrisol-map-section">
            <div class="afrisol-container">
                <div class="afrisol-map-grid">
                    <div class="afrisol-map-info afrisol-animate">
                        <h3>Visit Our Location</h3>
                        <ul class="afrisol-contact-details">
                            <li class="afrisol-contact-item">
                                <div class="afrisol-contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="afrisol-contact-text">
                                    <h4>Address</h4>
                                    <p><?php echo esc_html($address); ?></p>
                                </div>
                            </li>
                            <li class="afrisol-contact-item">
                                <div class="afrisol-contact-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="afrisol-contact-text">
                                    <h4>Phone</h4>
                                    <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>"><?php echo esc_html($phone); ?></a>
                                </div>
                            </li>
                            <li class="afrisol-contact-item">
                                <div class="afrisol-contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="afrisol-contact-text">
                                    <h4>Email</h4>
                                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                                </div>
                            </li>
                            <li class="afrisol-contact-item">
                                <div class="afrisol-contact-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="afrisol-contact-text">
                                    <h4>Business Hours</h4>
                                    <p><?php echo esc_html($hours); ?></p>
                                </div>
                            </li>
                        </ul>
                        <a href="https://maps.google.com/?q=<?php echo urlencode($address); ?>" target="_blank" class="afrisol-btn afrisol-btn-primary">
                            <i class="fas fa-directions"></i> Get Directions
                        </a>
                    </div>
                    
                    <div class="afrisol-map-wrapper afrisol-animate">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.0273!2d7.4731!3d9.0600!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwMDMnMzYuMCJOIDfCsDI4JzIzLjIiRQ!5e0!3m2!1sen!2sng!4v1234567890"
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /**
     * Contact Form
     */
    public function contact_form($atts) {
        ob_start();
        ?>
        <section class="afrisol-section afrisol-contact-section">
            <div class="afrisol-container">
                <div class="afrisol-section-header">
                    <h2 class="afrisol-sparkle-text">Get In Touch</h2>
                    <p>Have questions? We'd love to hear from you!</p>
                </div>
                
                <div class="afrisol-contact-grid">
                    <div class="afrisol-contact-form-wrapper afrisol-animate">
                        <h3>Send Us a Message</h3>
                        <form id="afrisolContactForm" class="afrisol-contact-form">
                            <div class="afrisol-form-row">
                                <div class="afrisol-form-group">
                                    <label class="afrisol-form-label">Your Name *</label>
                                    <input type="text" name="name" class="afrisol-form-input" required>
                                </div>
                                <div class="afrisol-form-group">
                                    <label class="afrisol-form-label">Email Address *</label>
                                    <input type="email" name="email" class="afrisol-form-input" required>
                                </div>
                            </div>
                            <div class="afrisol-form-row">
                                <div class="afrisol-form-group">
                                    <label class="afrisol-form-label">Phone Number</label>
                                    <input type="tel" name="phone" class="afrisol-form-input">
                                </div>
                                <div class="afrisol-form-group">
                                    <label class="afrisol-form-label">Subject *</label>
                                    <select name="subject" class="afrisol-form-select" required>
                                        <option value="">Select Subject</option>
                                        <option value="General Inquiry">General Inquiry</option>
                                        <option value="Product Information">Product Information</option>
                                        <option value="Service Request">Service Request</option>
                                        <option value="Support">Support</option>
                                        <option value="Feedback">Feedback</option>
                                        <option value="Complaint">Complaint</option>
                                    </select>
                                </div>
                            </div>
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Message *</label>
                                <textarea name="message" class="afrisol-form-textarea" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-lg">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </form>
                    </div>
                    
                    <div class="afrisol-contact-info-wrapper afrisol-animate">
                        <div class="afrisol-info-card">
                            <div class="afrisol-info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="afrisol-info-content">
                                <h4>Call Us</h4>
                                <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', get_option('afrisol_phone')); ?>"><?php echo esc_html(get_option('afrisol_phone')); ?></a>
                            </div>
                        </div>
                        
                        <div class="afrisol-info-card">
                            <div class="afrisol-info-icon">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div class="afrisol-info-content">
                                <h4>WhatsApp</h4>
                                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', get_option('afrisol_whatsapp')); ?>" target="_blank"><?php echo esc_html(get_option('afrisol_whatsapp')); ?></a>
                            </div>
                        </div>
                        
                        <div class="afrisol-info-card">
                            <div class="afrisol-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="afrisol-info-content">
                                <h4>Email Us</h4>
                                <a href="mailto:<?php echo esc_attr(get_option('afrisol_email')); ?>"><?php echo esc_html(get_option('afrisol_email')); ?></a>
                            </div>
                        </div>
                        
                        <div class="afrisol-info-card">
                            <div class="afrisol-info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="afrisol-info-content">
                                <h4>Visit Us</h4>
                                <p><?php echo esc_html(get_option('afrisol_address')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /**
     * Products Page
     */
    public function products_page($atts) {
        ob_start();
        include AFRISOL_PLUGIN_DIR . 'templates/products.php';
        return ob_get_clean();
    }

    /**
     * Cart Page
     */
    public function cart_page($atts) {
        ob_start();
        include AFRISOL_PLUGIN_DIR . 'templates/cart.php';
        return ob_get_clean();
    }

    /**
     * Checkout Page
     */
    public function checkout_page($atts) {
        ob_start();
        include AFRISOL_PLUGIN_DIR . 'templates/checkout.php';
        return ob_get_clean();
    }

    /**
     * Customer Portal
     */
    public function customer_portal($atts) {
        ob_start();
        include AFRISOL_PLUGIN_DIR . 'templates/customer-portal.php';
        return ob_get_clean();
    }

    /**
     * Solar Calculator
     */
    public function solar_calculator($atts) {
        ob_start();
        include AFRISOL_PLUGIN_DIR . 'templates/solar-calculator.php';
        return ob_get_clean();
    }

    /**
     * Quote Form
     */
    public function quote_form($atts) {
        ob_start();
        include AFRISOL_PLUGIN_DIR . 'templates/get-quote.php';
        return ob_get_clean();
    }

    /**
     * Repair Form
     */
    public function repair_form($atts) {
        ob_start();
        include AFRISOL_PLUGIN_DIR . 'templates/book-repair.php';
        return ob_get_clean();
    }
}

// Initialize shortcodes
new Afrisol_Shortcodes();
