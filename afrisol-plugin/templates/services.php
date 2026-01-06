<?php
/**
 * Template: Services Page
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get service categories
$service_categories = get_terms(array(
    'taxonomy' => 'afrisol_service_cat',
    'hide_empty' => true
));

// Get all services
$services = get_posts(array(
    'post_type' => 'afrisol_service',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
));
?>

<div class="afrisol-services-page">
    <!-- Page Header -->
    <div class="afrisol-page-header" style="background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);">
        <div class="afrisol-container">
            <h1 class="afrisol-sparkle-text">Our Services</h1>
            <p>Professional solar, security, and maintenance solutions for homes and businesses</p>
            <div class="afrisol-breadcrumb">
                <a href="<?php echo esc_url(home_url()); ?>">Home</a>
                <span class="afrisol-breadcrumb-separator">/</span>
                <span class="afrisol-breadcrumb-current">Services</span>
            </div>
        </div>
    </div>
    
    <div class="afrisol-section">
        <div class="afrisol-container">
            <!-- Service Categories Overview -->
            <div class="afrisol-service-categories">
                <div class="afrisol-grid afrisol-grid-2">
                    <!-- Installation Services -->
                    <div class="afrisol-service-category-card afrisol-animate">
                        <div class="category-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="category-content">
                            <h2>Installation Services</h2>
                            <p>Professional installation by certified technicians</p>
                            <ul class="category-list">
                                <li><i class="fas fa-check"></i> Residential Solar Installation</li>
                                <li><i class="fas fa-check"></i> Commercial/Industrial Installation</li>
                                <li><i class="fas fa-check"></i> Security System Installation</li>
                                <li><i class="fas fa-check"></i> Network Setup</li>
                            </ul>
                            <a href="#installation" class="afrisol-btn afrisol-btn-primary afrisol-btn-sm">Learn More</a>
                        </div>
                    </div>
                    
                    <!-- Repair & Maintenance -->
                    <div class="afrisol-service-category-card afrisol-animate">
                        <div class="category-icon" style="background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <div class="category-content">
                            <h2>Repair & Maintenance</h2>
                            <p>Keep your systems running at peak performance</p>
                            <ul class="category-list">
                                <li><i class="fas fa-check"></i> Solar Panel Repair</li>
                                <li><i class="fas fa-check"></i> Inverter Repair</li>
                                <li><i class="fas fa-check"></i> Battery Replacement</li>
                                <li><i class="fas fa-check"></i> CCTV Maintenance</li>
                                <li><i class="fas fa-check"></i> Electric Vehicle Servicing</li>
                            </ul>
                            <a href="<?php echo esc_url(home_url('/book-repair')); ?>" class="afrisol-btn afrisol-btn-secondary afrisol-btn-sm">Book Repair</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Installation Services Detail -->
            <section class="afrisol-service-detail-section" id="installation">
                <h2 class="afrisol-section-title afrisol-sparkle-text">Installation Services</h2>
                
                <div class="afrisol-grid afrisol-grid-2">
                    <!-- Residential Solar -->
                    <div class="afrisol-service-detail-card">
                        <div class="service-image">
                            <div class="service-image-placeholder">
                                <i class="fas fa-home"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3><i class="fas fa-home"></i> Residential Solar Installation</h3>
                            <p>Complete solar power solutions for homes, from small apartments to large estates.</p>
                            
                            <div class="service-process">
                                <h4>Our Process</h4>
                                <div class="process-steps">
                                    <div class="process-step">
                                        <span class="step-number">1</span>
                                        <span class="step-text">Free Site Assessment</span>
                                    </div>
                                    <div class="process-step">
                                        <span class="step-number">2</span>
                                        <span class="step-text">Custom System Design</span>
                                    </div>
                                    <div class="process-step">
                                        <span class="step-number">3</span>
                                        <span class="step-text">Professional Installation</span>
                                    </div>
                                    <div class="process-step">
                                        <span class="step-number">4</span>
                                        <span class="step-text">Testing & Handover</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="service-info-row">
                                <div class="service-info-item">
                                    <i class="fas fa-clock"></i>
                                    <span>1-3 days</span>
                                </div>
                                <div class="service-info-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>2 Year Warranty</span>
                                </div>
                            </div>
                            
                            <a href="<?php echo esc_url(home_url('/get-quote')); ?>" class="afrisol-btn afrisol-btn-primary">Get Custom Quote</a>
                        </div>
                    </div>
                    
                    <!-- Commercial Solar -->
                    <div class="afrisol-service-detail-card">
                        <div class="service-image">
                            <div class="service-image-placeholder">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3><i class="fas fa-building"></i> Commercial/Industrial Installation</h3>
                            <p>Large-scale solar power systems for businesses, offices, factories, and industrial facilities.</p>
                            
                            <div class="service-process">
                                <h4>What's Included</h4>
                                <ul class="service-includes">
                                    <li><i class="fas fa-check"></i> Energy audit & assessment</li>
                                    <li><i class="fas fa-check"></i> Load analysis</li>
                                    <li><i class="fas fa-check"></i> Custom system design</li>
                                    <li><i class="fas fa-check"></i> Project management</li>
                                    <li><i class="fas fa-check"></i> Training for staff</li>
                                </ul>
                            </div>
                            
                            <div class="service-info-row">
                                <div class="service-info-item">
                                    <i class="fas fa-clock"></i>
                                    <span>1-4 weeks</span>
                                </div>
                                <div class="service-info-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>3 Year Warranty</span>
                                </div>
                            </div>
                            
                            <a href="<?php echo esc_url(home_url('/get-quote')); ?>" class="afrisol-btn afrisol-btn-primary">Request Consultation</a>
                        </div>
                    </div>
                    
                    <!-- Security Installation -->
                    <div class="afrisol-service-detail-card">
                        <div class="service-image">
                            <div class="service-image-placeholder">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3><i class="fas fa-shield-alt"></i> Security System Installation</h3>
                            <p>Comprehensive security solutions including CCTV, access control, alarms, and electric fencing.</p>
                            
                            <div class="service-process">
                                <h4>Security Products</h4>
                                <ul class="service-includes">
                                    <li><i class="fas fa-check"></i> CCTV Cameras & DVR/NVR</li>
                                    <li><i class="fas fa-check"></i> AI-Powered Cameras</li>
                                    <li><i class="fas fa-check"></i> Access Control Systems</li>
                                    <li><i class="fas fa-check"></i> Intercoms & Video Doorbells</li>
                                    <li><i class="fas fa-check"></i> Electric Fence & Alarms</li>
                                </ul>
                            </div>
                            
                            <div class="service-info-row">
                                <div class="service-info-item">
                                    <i class="fas fa-clock"></i>
                                    <span>1-2 days</span>
                                </div>
                                <div class="service-info-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>1 Year Warranty</span>
                                </div>
                            </div>
                            
                            <a href="<?php echo esc_url(home_url('/get-quote')); ?>" class="afrisol-btn afrisol-btn-primary">Get Security Quote</a>
                        </div>
                    </div>
                    
                    <!-- Network Setup -->
                    <div class="afrisol-service-detail-card">
                        <div class="service-image">
                            <div class="service-image-placeholder">
                                <i class="fas fa-network-wired"></i>
                            </div>
                        </div>
                        <div class="service-content">
                            <h3><i class="fas fa-network-wired"></i> Network Setup</h3>
                            <p>Professional networking solutions for homes and offices including Wi-Fi, structured cabling, and more.</p>
                            
                            <div class="service-process">
                                <h4>Services Include</h4>
                                <ul class="service-includes">
                                    <li><i class="fas fa-check"></i> Structured Cabling</li>
                                    <li><i class="fas fa-check"></i> Wi-Fi Network Setup</li>
                                    <li><i class="fas fa-check"></i> Router Configuration</li>
                                    <li><i class="fas fa-check"></i> Network Security Setup</li>
                                </ul>
                            </div>
                            
                            <div class="service-info-row">
                                <div class="service-info-item">
                                    <i class="fas fa-clock"></i>
                                    <span>1-3 days</span>
                                </div>
                                <div class="service-info-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>90-Day Support</span>
                                </div>
                            </div>
                            
                            <a href="<?php echo esc_url(home_url('/get-quote')); ?>" class="afrisol-btn afrisol-btn-primary">Get Quote</a>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Service Guarantee -->
            <section class="afrisol-service-guarantee afrisol-mt-4">
                <div class="afrisol-card">
                    <div class="guarantee-content">
                        <div class="guarantee-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div class="guarantee-text">
                            <h3>Our Service Guarantee</h3>
                            <p>We stand behind every installation with comprehensive warranties and ongoing support. If you're not satisfied, we'll make it right.</p>
                            <ul class="guarantee-features">
                                <li><i class="fas fa-check-circle"></i> 100% Satisfaction Guarantee</li>
                                <li><i class="fas fa-check-circle"></i> Certified Professional Technicians</li>
                                <li><i class="fas fa-check-circle"></i> Warranty on Parts & Labor</li>
                                <li><i class="fas fa-check-circle"></i> 24/7 Emergency Support</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- CTA Section -->
            <section class="afrisol-cta-section afrisol-mt-4">
                <div class="afrisol-cta-card">
                    <h2>Ready to Get Started?</h2>
                    <p>Contact us today for a free consultation and quote</p>
                    <div class="afrisol-cta-buttons">
                        <a href="<?php echo esc_url(home_url('/get-quote')); ?>" class="afrisol-btn afrisol-btn-secondary afrisol-btn-lg">
                            <i class="fas fa-file-invoice"></i> Get Free Quote
                        </a>
                        <a href="<?php echo esc_url(home_url('/solar-calculator')); ?>" class="afrisol-btn afrisol-btn-outline-white afrisol-btn-lg">
                            <i class="fas fa-calculator"></i> Solar Calculator
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<style>
.afrisol-page-header {
    padding: 4rem 0 3rem;
    color: #fff;
    text-align: center;
}

.afrisol-page-header h1 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

.afrisol-page-header p {
    opacity: 0.9;
    margin-bottom: 1rem;
}

.afrisol-page-header .afrisol-breadcrumb a {
    color: rgba(255,255,255,0.8);
}

.afrisol-page-header .afrisol-breadcrumb-separator {
    color: rgba(255,255,255,0.6);
}

.afrisol-service-category-card {
    display: flex;
    gap: 1.5rem;
    background: var(--afrisol-white);
    padding: 2rem;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
}

.category-icon {
    width: 80px;
    height: 80px;
    min-width: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--afrisol-primary) 0%, var(--afrisol-primary-light) 100%);
    border-radius: var(--radius-lg);
}

.category-icon i {
    font-size: 2rem;
    color: #fff;
}

.category-content h2 {
    margin-bottom: 0.5rem;
}

.category-content p {
    color: var(--afrisol-gray);
    margin-bottom: 1rem;
}

.category-list {
    list-style: none;
    padding: 0;
    margin-bottom: 1.5rem;
}

.category-list li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0;
    font-size: 0.95rem;
}

.category-list li i {
    color: var(--afrisol-primary);
}

.afrisol-service-detail-section {
    margin-top: 4rem;
}

.afrisol-service-detail-card {
    background: var(--afrisol-white);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
}

.service-image {
    height: 200px;
    background: var(--afrisol-gray-light);
}

.service-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--afrisol-primary) 0%, var(--afrisol-primary-light) 100%);
}

.service-image-placeholder i {
    font-size: 4rem;
    color: rgba(255,255,255,0.3);
}

.service-content {
    padding: 1.5rem;
}

.service-content h3 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.service-content h3 i {
    color: var(--afrisol-secondary);
}

.service-process {
    margin: 1.5rem 0;
}

.service-process h4 {
    font-size: 0.9rem;
    color: var(--afrisol-gray);
    margin-bottom: 1rem;
}

.process-steps {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.process-step {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--afrisol-gray-light);
    padding: 0.5rem 1rem;
    border-radius: var(--radius-full);
    font-size: 0.85rem;
}

.step-number {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--afrisol-primary);
    color: #fff;
    border-radius: 50%;
    font-size: 0.75rem;
    font-weight: 700;
}

.service-includes {
    list-style: none;
    padding: 0;
}

.service-includes li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0;
    font-size: 0.9rem;
}

.service-includes li i {
    color: var(--afrisol-primary);
}

.service-info-row {
    display: flex;
    gap: 1.5rem;
    margin: 1.5rem 0;
}

.service-info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: var(--afrisol-gray);
}

.service-info-item i {
    color: var(--afrisol-secondary);
}

.afrisol-service-guarantee .afrisol-card {
    background: linear-gradient(135deg, var(--afrisol-primary) 0%, var(--afrisol-primary-light) 100%);
    color: #fff;
    padding: 3rem;
}

.guarantee-content {
    display: flex;
    gap: 2rem;
    align-items: flex-start;
}

.guarantee-icon {
    width: 80px;
    height: 80px;
    min-width: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
}

.guarantee-icon i {
    font-size: 2.5rem;
    color: var(--afrisol-secondary);
}

.guarantee-features {
    list-style: none;
    padding: 0;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
    margin-top: 1rem;
}

.guarantee-features li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.guarantee-features li i {
    color: var(--afrisol-secondary);
}

.afrisol-cta-card {
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, var(--afrisol-primary) 0%, var(--afrisol-primary-dark) 100%);
    color: #fff;
    border-radius: var(--radius-xl);
}

.afrisol-cta-card h2 {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.afrisol-cta-card p {
    opacity: 0.9;
    margin-bottom: 2rem;
}

.afrisol-cta-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .afrisol-service-category-card {
        flex-direction: column;
        text-align: center;
    }
    
    .guarantee-content {
        flex-direction: column;
        text-align: center;
    }
    
    .guarantee-features {
        grid-template-columns: 1fr;
    }
}
</style>
