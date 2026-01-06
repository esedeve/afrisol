<?php
/**
 * Template: Contact Page
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get contact information
$phone = get_option('afrisol_phone', '+234 XXX XXX XXXX');
$email = get_option('afrisol_email', 'info@afrisol.com');
$whatsapp = get_option('afrisol_whatsapp', '+234 XXX XXX XXXX');
$address = get_option('afrisol_address', 'Suite 15C, Al-Noor Shopping Complex, Al-Noor Mosque, Ahmadu Bello Way Wuse 2, Abuja.');
$business_hours = get_option('afrisol_business_hours', 'Mon-Fri: 8AM-6PM, Sat: 9AM-4PM');

// Get FAQs
$faqs = get_posts(array(
    'post_type' => 'afrisol_faq',
    'posts_per_page' => 8,
    'orderby' => 'menu_order',
    'order' => 'ASC'
));
?>

<div class="afrisol-contact-page">
    <!-- Page Header -->
    <div class="afrisol-page-header" style="background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);">
        <div class="afrisol-container">
            <h1 class="afrisol-sparkle-text">Contact Us</h1>
            <p>We're here to help you power your future with clean energy</p>
            <div class="afrisol-breadcrumb">
                <a href="<?php echo esc_url(home_url()); ?>">Home</a>
                <span class="afrisol-breadcrumb-separator">/</span>
                <span class="afrisol-breadcrumb-current">Contact</span>
            </div>
        </div>
    </div>
    
    <div class="afrisol-section">
        <div class="afrisol-container">
            <!-- Contact Methods -->
            <div class="afrisol-contact-methods">
                <div class="afrisol-grid afrisol-grid-4">
                    <div class="afrisol-contact-method-card afrisol-animate">
                        <div class="method-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h4>Call Us</h4>
                        <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>" class="method-value"><?php echo esc_html($phone); ?></a>
                        <p>Mon-Fri: 8AM-6PM</p>
                    </div>
                    <div class="afrisol-contact-method-card afrisol-animate afrisol-animate-delay-1">
                        <div class="method-icon" style="background: #25D366;">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h4>WhatsApp</h4>
                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $whatsapp); ?>" target="_blank" class="method-value"><?php echo esc_html($whatsapp); ?></a>
                        <p>Chat with us instantly</p>
                    </div>
                    <div class="afrisol-contact-method-card afrisol-animate afrisol-animate-delay-2">
                        <div class="method-icon" style="background: var(--afrisol-secondary);">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email Us</h4>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="method-value"><?php echo esc_html($email); ?></a>
                        <p>We respond within 24 hours</p>
                    </div>
                    <div class="afrisol-contact-method-card afrisol-animate afrisol-animate-delay-3">
                        <div class="method-icon" style="background: #EA4335;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Visit Us</h4>
                        <span class="method-value" style="font-size: 0.9rem;">Wuse 2, Abuja</span>
                        <p><?php echo esc_html($business_hours); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form and Map -->
            <div class="afrisol-contact-main afrisol-mt-4">
                <div class="afrisol-contact-grid">
                    <!-- Contact Form -->
                    <div class="afrisol-contact-form-section afrisol-animate">
                        <h2>Send Us a Message</h2>
                        <p class="afrisol-text-gray afrisol-mb-3">Have a question or need assistance? Fill out the form below and we'll get back to you as soon as possible.</p>
                        
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
                                        <option value="Quote Request">Quote Request</option>
                                        <option value="Technical Support">Technical Support</option>
                                        <option value="Partnership">Partnership Opportunity</option>
                                        <option value="Feedback">Feedback</option>
                                        <option value="Complaint">Complaint</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Message *</label>
                                <textarea name="message" class="afrisol-form-textarea" rows="5" required placeholder="How can we help you?"></textarea>
                            </div>
                            
                            <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-lg">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </form>
                    </div>
                    
                    <!-- Map Section -->
                    <div class="afrisol-map-section afrisol-animate">
                        <h2>Our Location</h2>
                        <p class="afrisol-text-gray afrisol-mb-3"><?php echo esc_html($address); ?></p>
                        
                        <div class="afrisol-map-wrapper">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.0273!2d7.4731!3d9.0600!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwMDMnMzYuMCJOIDfCsDI4JzIzLjIiRQ!5e0!3m2!1sen!2sng!4v1234567890"
                                width="100%" 
                                height="350" 
                                style="border:0; border-radius: var(--radius-lg);" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        
                        <a href="https://maps.google.com/?q=<?php echo urlencode($address); ?>" target="_blank" class="afrisol-btn afrisol-btn-outline afrisol-mt-2">
                            <i class="fas fa-directions"></i> Get Directions
                        </a>
                        
                        <div class="afrisol-business-hours afrisol-mt-3">
                            <h4><i class="fas fa-clock"></i> Business Hours</h4>
                            <ul>
                                <li><span>Monday - Friday</span> <span>8:00 AM - 6:00 PM</span></li>
                                <li><span>Saturday</span> <span>9:00 AM - 4:00 PM</span></li>
                                <li><span>Sunday</span> <span>Closed</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Section -->
            <section class="afrisol-faq-section afrisol-mt-4">
                <h2 class="afrisol-section-title afrisol-sparkle-text">Frequently Asked Questions</h2>
                <p class="afrisol-section-subtitle">Find quick answers to common questions</p>
                
                <div class="afrisol-faq-grid">
                    <?php if ($faqs) : foreach ($faqs as $faq) : ?>
                    <div class="afrisol-faq-item">
                        <button class="afrisol-faq-question" type="button">
                            <span><?php echo esc_html($faq->post_title); ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="afrisol-faq-answer">
                            <?php echo wpautop($faq->post_content); ?>
                        </div>
                    </div>
                    <?php endforeach; else : ?>
                    <!-- Default FAQs -->
                    <div class="afrisol-faq-item">
                        <button class="afrisol-faq-question" type="button">
                            <span>How long does a solar installation take?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="afrisol-faq-answer">
                            <p>A typical residential installation takes 1-3 days depending on system size. Commercial installations may take 1-4 weeks.</p>
                        </div>
                    </div>
                    <div class="afrisol-faq-item">
                        <button class="afrisol-faq-question" type="button">
                            <span>What warranty do you offer?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="afrisol-faq-answer">
                            <p>We offer comprehensive warranties: up to 25 years on solar panels, 10 years on inverters, and 2-5 years on batteries.</p>
                        </div>
                    </div>
                    <div class="afrisol-faq-item">
                        <button class="afrisol-faq-question" type="button">
                            <span>Do you offer financing options?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="afrisol-faq-answer">
                            <p>Yes! We offer flexible payment plans including up to 12-month installment options. Contact us for details.</p>
                        </div>
                    </div>
                    <div class="afrisol-faq-item">
                        <button class="afrisol-faq-question" type="button">
                            <span>What areas do you service?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="afrisol-faq-answer">
                            <p>We primarily serve Abuja and surrounding areas, with delivery available nationwide. Contact us for service availability in your location.</p>
                        </div>
                    </div>
                    <div class="afrisol-faq-item">
                        <button class="afrisol-faq-question" type="button">
                            <span>How do I know what solar system size I need?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="afrisol-faq-answer">
                            <p>Use our <a href="<?php echo esc_url(home_url('/solar-calculator')); ?>">Solar Calculator</a> for an estimate, or schedule a free site assessment for expert recommendations.</p>
                        </div>
                    </div>
                    <div class="afrisol-faq-item">
                        <button class="afrisol-faq-question" type="button">
                            <span>Do you offer maintenance services?</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="afrisol-faq-answer">
                            <p>Yes, we offer regular maintenance packages and on-demand repair services for all our products. Book a repair <a href="<?php echo esc_url(home_url('/book-repair')); ?>">here</a>.</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </section>
            
            <!-- Quick Links -->
            <section class="afrisol-quick-links afrisol-mt-4">
                <h3>Quick Links</h3>
                <div class="quick-links-grid">
                    <a href="<?php echo esc_url(home_url('/get-quote')); ?>" class="quick-link-card">
                        <i class="fas fa-file-invoice"></i>
                        <span>Get Free Quote</span>
                    </a>
                    <a href="<?php echo esc_url(home_url('/solar-calculator')); ?>" class="quick-link-card">
                        <i class="fas fa-calculator"></i>
                        <span>Solar Calculator</span>
                    </a>
                    <a href="<?php echo esc_url(home_url('/book-repair')); ?>" class="quick-link-card">
                        <i class="fas fa-tools"></i>
                        <span>Book Repair</span>
                    </a>
                    <a href="<?php echo esc_url(home_url('/products')); ?>" class="quick-link-card">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Shop Products</span>
                    </a>
                </div>
            </section>
        </div>
    </div>
</div>

<style>
.afrisol-contact-methods {
    margin-top: -4rem;
    position: relative;
    z-index: 10;
}

.afrisol-contact-method-card {
    background: var(--afrisol-white);
    padding: 2rem;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    text-align: center;
}

.method-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--afrisol-primary);
    border-radius: var(--radius-lg);
}

.method-icon i {
    font-size: 1.5rem;
    color: #fff;
}

.afrisol-contact-method-card h4 {
    margin-bottom: 0.5rem;
}

.method-value {
    display: block;
    color: var(--afrisol-primary);
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.afrisol-contact-method-card p {
    font-size: 0.85rem;
    color: var(--afrisol-gray);
    margin: 0;
}

.afrisol-contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
}

.afrisol-contact-form-section,
.afrisol-map-section {
    background: var(--afrisol-white);
    padding: 2rem;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
}

.afrisol-business-hours {
    background: var(--afrisol-gray-light);
    padding: 1.5rem;
    border-radius: var(--radius-lg);
}

.afrisol-business-hours h4 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    color: var(--afrisol-primary);
}

.afrisol-business-hours ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.afrisol-business-hours li {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.afrisol-business-hours li:last-child {
    border-bottom: none;
}

.afrisol-faq-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.afrisol-faq-item {
    background: var(--afrisol-white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.afrisol-faq-question {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
    background: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
    text-align: left;
    transition: all var(--transition-fast);
}

.afrisol-faq-question:hover {
    background: var(--afrisol-gray-light);
}

.afrisol-faq-question i {
    transition: transform var(--transition-fast);
}

.afrisol-faq-item.active .afrisol-faq-question i {
    transform: rotate(180deg);
}

.afrisol-faq-answer {
    display: none;
    padding: 0 1.25rem 1.25rem;
    color: var(--afrisol-gray);
}

.afrisol-faq-item.active .afrisol-faq-answer {
    display: block;
}

.afrisol-faq-answer a {
    color: var(--afrisol-primary);
    text-decoration: underline;
}

.afrisol-quick-links {
    text-align: center;
}

.afrisol-quick-links h3 {
    margin-bottom: 1.5rem;
}

.quick-links-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.quick-link-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    padding: 1.5rem;
    background: var(--afrisol-gray-light);
    border-radius: var(--radius-lg);
    transition: all var(--transition-fast);
}

.quick-link-card:hover {
    background: var(--afrisol-primary);
    color: #fff;
    transform: translateY(-3px);
}

.quick-link-card i {
    font-size: 1.5rem;
    color: var(--afrisol-primary);
    transition: color var(--transition-fast);
}

.quick-link-card:hover i {
    color: #fff;
}

.quick-link-card span {
    font-weight: 600;
}

@media (max-width: 1024px) {
    .afrisol-contact-grid {
        grid-template-columns: 1fr;
    }
    
    .afrisol-faq-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .afrisol-contact-methods {
        margin-top: -2rem;
    }
    
    .afrisol-contact-methods .afrisol-grid-4 {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .quick-links-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Accordion
    const faqItems = document.querySelectorAll('.afrisol-faq-item');
    
    faqItems.forEach(function(item) {
        const question = item.querySelector('.afrisol-faq-question');
        
        question.addEventListener('click', function() {
            const isActive = item.classList.contains('active');
            
            // Close all other items
            faqItems.forEach(function(otherItem) {
                otherItem.classList.remove('active');
            });
            
            // Toggle current item
            if (!isActive) {
                item.classList.add('active');
            }
        });
    });
});
</script>
