<?php
/**
 * Template: About Us Page
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get team members
$team_members = get_posts(array(
    'post_type' => 'afrisol_team',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
));
?>

<div class="afrisol-about-page">
    <!-- Hero Section -->
    <div class="afrisol-about-hero">
        <div class="afrisol-container">
            <div class="afrisol-about-hero-content">
                <span class="afrisol-subtitle">About Us</span>
                <h1 class="afrisol-sparkle-text">Solar Solutions for a<br>Sustainable Africa</h1>
                <p>Powering homes, businesses, and communities with clean, renewable energy since 2018.</p>
            </div>
        </div>
    </div>
    
    <div class="afrisol-section">
        <div class="afrisol-container">
            <!-- Company Story -->
            <section class="afrisol-story-section">
                <div class="afrisol-story-grid">
                    <div class="afrisol-story-content afrisol-animate">
                        <h2 class="afrisol-sparkle-text">Our Story</h2>
                        <p class="afrisol-lead">Afrisol was founded with a simple yet powerful vision: to make clean, reliable energy accessible to every home and business in Africa.</p>
                        <p>In a continent blessed with abundant sunshine, we saw an opportunity to transform how Africans power their lives. From our humble beginnings in Abuja, we've grown to become a trusted partner for thousands of families and businesses seeking energy independence.</p>
                        <p>Today, we offer comprehensive solutions including solar power systems, security equipment, and electric mobility options, all backed by expert installation and dedicated customer support.</p>
                        
                        <div class="afrisol-mission-vision">
                            <div class="mission-card">
                                <div class="card-icon">
                                    <i class="fas fa-bullseye"></i>
                                </div>
                                <div class="card-content">
                                    <h4>Our Mission</h4>
                                    <p>To accelerate Africa's transition to clean energy by providing affordable, reliable, and innovative solar solutions.</p>
                                </div>
                            </div>
                            <div class="mission-card">
                                <div class="card-icon" style="background: var(--afrisol-secondary);">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="card-content">
                                    <h4>Our Vision</h4>
                                    <p>A sustainable Africa where every home and business has access to clean, affordable energy.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="afrisol-story-image afrisol-animate">
                        <div class="story-image-wrapper">
                            <div class="story-image-placeholder">
                                <i class="fas fa-sun"></i>
                            </div>
                        </div>
                        <div class="story-stats-badge">
                            <span class="stats-number">5+</span>
                            <span class="stats-label">Years of Excellence</span>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Impact Statistics -->
            <section class="afrisol-impact-section afrisol-mt-4">
                <h2 class="afrisol-section-title afrisol-sparkle-text">Our Impact</h2>
                <p class="afrisol-section-subtitle">Making a difference, one installation at a time</p>
                
                <div class="afrisol-impact-grid">
                    <div class="afrisol-impact-card afrisol-animate">
                        <div class="impact-icon">
                            <i class="fas fa-solar-panel"></i>
                        </div>
                        <div class="impact-number" data-count="500">500+</div>
                        <div class="impact-label">Solar Installations</div>
                    </div>
                    <div class="afrisol-impact-card afrisol-animate afrisol-animate-delay-1">
                        <div class="impact-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="impact-number" data-count="2000">2,000+</div>
                        <div class="impact-label">Happy Customers</div>
                    </div>
                    <div class="afrisol-impact-card afrisol-animate afrisol-animate-delay-2">
                        <div class="impact-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="impact-number" data-count="1500">1,500</div>
                        <div class="impact-label">MWh Generated</div>
                    </div>
                    <div class="afrisol-impact-card afrisol-animate afrisol-animate-delay-3">
                        <div class="impact-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div class="impact-number" data-count="750">750</div>
                        <div class="impact-label">Tons CO2 Saved</div>
                    </div>
                </div>
            </section>
            
            <!-- Values -->
            <section class="afrisol-values-section afrisol-mt-4">
                <h2 class="afrisol-section-title afrisol-sparkle-text">Our Values</h2>
                
                <div class="afrisol-grid afrisol-grid-4">
                    <div class="afrisol-value-card afrisol-animate">
                        <div class="value-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4>Quality</h4>
                        <p>We source only the best equipment from trusted global manufacturers.</p>
                    </div>
                    <div class="afrisol-value-card afrisol-animate afrisol-animate-delay-1">
                        <div class="value-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Integrity</h4>
                        <p>We operate with transparency and honesty in every interaction.</p>
                    </div>
                    <div class="afrisol-value-card afrisol-animate afrisol-animate-delay-2">
                        <div class="value-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h4>Innovation</h4>
                        <p>We continuously embrace new technologies to serve you better.</p>
                    </div>
                    <div class="afrisol-value-card afrisol-animate afrisol-animate-delay-3">
                        <div class="value-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4>Sustainability</h4>
                        <p>We're committed to building a greener future for Africa.</p>
                    </div>
                </div>
            </section>
            
            <!-- Team Section -->
            <?php if ($team_members) : ?>
            <section class="afrisol-team-section afrisol-mt-4">
                <h2 class="afrisol-section-title afrisol-sparkle-text">Meet Our Team</h2>
                <p class="afrisol-section-subtitle">The experts behind Afrisol's success</p>
                
                <div class="afrisol-team-grid">
                    <?php foreach ($team_members as $member) : 
                        $position = get_post_meta($member->ID, '_afrisol_position', true);
                        $linkedin = get_post_meta($member->ID, '_afrisol_linkedin', true);
                        $twitter = get_post_meta($member->ID, '_afrisol_twitter', true);
                    ?>
                    <div class="afrisol-team-card afrisol-animate">
                        <div class="team-photo">
                            <?php if (has_post_thumbnail($member->ID)) : ?>
                                <?php echo get_the_post_thumbnail($member->ID, 'medium'); ?>
                            <?php else : ?>
                                <div class="team-photo-placeholder">
                                    <?php echo strtoupper(substr($member->post_title, 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="team-info">
                            <h4><?php echo esc_html($member->post_title); ?></h4>
                            <?php if ($position) : ?>
                                <span class="team-position"><?php echo esc_html($position); ?></span>
                            <?php endif; ?>
                            <?php if ($member->post_content) : ?>
                                <p><?php echo wp_trim_words($member->post_content, 20); ?></p>
                            <?php endif; ?>
                            <div class="team-social">
                                <?php if ($linkedin) : ?>
                                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
                                <?php endif; ?>
                                <?php if ($twitter) : ?>
                                    <a href="<?php echo esc_url($twitter); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
            
            <!-- Certifications -->
            <section class="afrisol-certifications-section afrisol-mt-4">
                <h2 class="afrisol-section-title afrisol-sparkle-text">Certifications & Partnerships</h2>
                
                <div class="afrisol-certifications-grid">
                    <div class="certification-badge">
                        <i class="fas fa-certificate"></i>
                        <span>ISO 9001 Certified</span>
                    </div>
                    <div class="certification-badge">
                        <i class="fas fa-solar-panel"></i>
                        <span>Solar Energy Society</span>
                    </div>
                    <div class="certification-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Security Standards Board</span>
                    </div>
                    <div class="certification-badge">
                        <i class="fas fa-leaf"></i>
                        <span>Green Energy Initiative</span>
                    </div>
                </div>
            </section>
            
            <!-- CTA Section -->
            <section class="afrisol-about-cta afrisol-mt-4">
                <div class="afrisol-cta-card">
                    <h2>Ready to Go Solar?</h2>
                    <p>Join thousands of satisfied customers powering their homes with clean energy</p>
                    <div class="afrisol-cta-buttons">
                        <a href="<?php echo home_url('/get-quote'); ?>" class="afrisol-btn afrisol-btn-secondary afrisol-btn-lg">
                            <i class="fas fa-file-invoice"></i> Get Free Quote
                        </a>
                        <a href="<?php echo home_url('/contact'); ?>" class="afrisol-btn afrisol-btn-outline-white afrisol-btn-lg">
                            <i class="fas fa-phone-alt"></i> Contact Us
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<style>
.afrisol-about-hero {
    background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
    color: #fff;
    padding: 5rem 0;
    text-align: center;
}

.afrisol-subtitle {
    display: inline-block;
    background: rgba(255,255,255,0.15);
    padding: 0.5rem 1.5rem;
    border-radius: var(--radius-full);
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.afrisol-about-hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.afrisol-about-hero p {
    font-size: 1.2rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

.afrisol-story-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}

.afrisol-lead {
    font-size: 1.2rem;
    color: var(--afrisol-primary);
    font-weight: 500;
    margin-bottom: 1.5rem;
}

.afrisol-mission-vision {
    display: grid;
    gap: 1rem;
    margin-top: 2rem;
}

.mission-card {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--afrisol-gray-light);
    border-radius: var(--radius-lg);
}

.card-icon {
    width: 50px;
    height: 50px;
    min-width: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--afrisol-primary);
    color: #fff;
    border-radius: var(--radius-md);
    font-size: 1.25rem;
}

.card-content h4 {
    margin-bottom: 0.5rem;
}

.card-content p {
    font-size: 0.9rem;
    color: var(--afrisol-gray);
    margin: 0;
}

.afrisol-story-image {
    position: relative;
}

.story-image-wrapper {
    border-radius: var(--radius-xl);
    overflow: hidden;
    position: relative;
}

.story-image-placeholder {
    height: 400px;
    background: linear-gradient(135deg, var(--afrisol-primary) 0%, var(--afrisol-primary-light) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.story-image-placeholder i {
    font-size: 6rem;
    color: rgba(255,255,255,0.2);
}

.story-stats-badge {
    position: absolute;
    bottom: -20px;
    right: -20px;
    background: var(--afrisol-secondary);
    color: #fff;
    padding: 1.5rem 2rem;
    border-radius: var(--radius-lg);
    text-align: center;
    box-shadow: var(--shadow-lg);
}

.stats-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 800;
    font-family: var(--font-heading);
}

.stats-label {
    font-size: 0.85rem;
}

.afrisol-impact-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
}

.afrisol-impact-card {
    text-align: center;
    padding: 2rem;
    background: var(--afrisol-white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
}

.impact-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--afrisol-primary) 0%, var(--afrisol-primary-light) 100%);
    border-radius: 50%;
}

.impact-icon i {
    font-size: 1.75rem;
    color: #fff;
}

.impact-number {
    font-size: 2.5rem;
    font-weight: 800;
    font-family: var(--font-heading);
    color: var(--afrisol-primary);
}

.impact-label {
    color: var(--afrisol-gray);
    font-size: 0.9rem;
}

.afrisol-value-card {
    text-align: center;
    padding: 2rem;
    background: var(--afrisol-white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    transition: all var(--transition-fast);
}

.afrisol-value-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.value-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(27, 94, 32, 0.1);
    border-radius: var(--radius-lg);
}

.value-icon i {
    font-size: 1.5rem;
    color: var(--afrisol-primary);
}

.afrisol-value-card h4 {
    margin-bottom: 0.5rem;
}

.afrisol-value-card p {
    font-size: 0.9rem;
    color: var(--afrisol-gray);
    margin: 0;
}

.afrisol-team-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
}

.afrisol-team-card {
    background: var(--afrisol-white);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    text-align: center;
}

.team-photo {
    height: 200px;
    overflow: hidden;
}

.team-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.team-photo-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--afrisol-primary) 0%, var(--afrisol-primary-light) 100%);
    color: #fff;
    font-size: 4rem;
    font-weight: 700;
}

.team-info {
    padding: 1.5rem;
}

.team-info h4 {
    margin-bottom: 0.25rem;
}

.team-position {
    display: block;
    color: var(--afrisol-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
}

.team-info p {
    font-size: 0.85rem;
    color: var(--afrisol-gray);
}

.team-social {
    display: flex;
    justify-content: center;
    gap: 0.75rem;
    margin-top: 1rem;
}

.team-social a {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--afrisol-gray-light);
    border-radius: 50%;
    color: var(--afrisol-gray);
    transition: all var(--transition-fast);
}

.team-social a:hover {
    background: var(--afrisol-primary);
    color: #fff;
}

.afrisol-certifications-grid {
    display: flex;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;
}

.certification-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    padding: 2rem;
    background: var(--afrisol-gray-light);
    border-radius: var(--radius-lg);
    min-width: 180px;
}

.certification-badge i {
    font-size: 2rem;
    color: var(--afrisol-primary);
}

.certification-badge span {
    font-weight: 600;
    text-align: center;
}

.afrisol-about-cta .afrisol-cta-card {
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, var(--afrisol-primary) 0%, var(--afrisol-primary-dark) 100%);
    color: #fff;
    border-radius: var(--radius-xl);
}

@media (max-width: 1024px) {
    .afrisol-story-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .afrisol-impact-grid,
    .afrisol-team-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .afrisol-about-hero h1 {
        font-size: 2rem;
    }
    
    .afrisol-impact-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .afrisol-team-grid {
        grid-template-columns: 1fr;
    }
    
    .afrisol-certifications-grid {
        gap: 1rem;
    }
    
    .certification-badge {
        min-width: 140px;
        padding: 1.5rem;
    }
}
</style>
