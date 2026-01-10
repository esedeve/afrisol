<?php
/**
 * Template: Get Quote (Multi-step form)
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="afrisol-quote-page">
    <div class="afrisol-container">
        <div class="afrisol-breadcrumb">
            <a href="<?php echo esc_url(home_url()); ?>">Home</a>
            <span class="afrisol-breadcrumb-separator">/</span>
            <span class="afrisol-breadcrumb-current">Get Quote</span>
        </div>
        
        <div class="afrisol-quote-card">
            <form id="afrisolQuoteForm">
                <input type="hidden" name="service_type" value="">
                
                <!-- Progress Indicators -->
                <div class="afrisol-quote-progress">
                    <div class="afrisol-quote-step-indicator active">
                        <span class="afrisol-step-number">1</span>
                        <span class="afrisol-step-label">Service</span>
                    </div>
                    <div class="afrisol-quote-step-indicator">
                        <span class="afrisol-step-number">2</span>
                        <span class="afrisol-step-label">Category</span>
                    </div>
                    <div class="afrisol-quote-step-indicator">
                        <span class="afrisol-step-number">3</span>
                        <span class="afrisol-step-label">Details</span>
                    </div>
                    <div class="afrisol-quote-step-indicator">
                        <span class="afrisol-step-number">4</span>
                        <span class="afrisol-step-label">Contact</span>
                    </div>
                    <div class="afrisol-quote-step-indicator">
                        <span class="afrisol-step-number">5</span>
                        <span class="afrisol-step-label">Confirm</span>
                    </div>
                </div>
                
                <div class="afrisol-quote-body">
                    <!-- Step 1: Service Type -->
                    <div class="afrisol-quote-step active" data-step="1">
                        <h2>What type of service do you need?</h2>
                        <p class="afrisol-text-gray afrisol-mb-3">Select the option that best describes your needs</p>
                        
                        <div class="afrisol-service-type-options">
                            <div class="afrisol-service-type-option" data-type="installation">
                                <i class="fas fa-tools"></i>
                                <h4>New Installation</h4>
                                <p>Solar panels, security systems, etc.</p>
                            </div>
                            <div class="afrisol-service-type-option" data-type="purchase">
                                <i class="fas fa-shopping-cart"></i>
                                <h4>Product Purchase</h4>
                                <p>Buy equipment only</p>
                            </div>
                            <div class="afrisol-service-type-option" data-type="repair">
                                <i class="fas fa-wrench"></i>
                                <h4>Repair Service</h4>
                                <p>Fix existing equipment</p>
                            </div>
                        </div>
                        
                        <div class="afrisol-text-right afrisol-mt-3">
                            <button type="button" class="afrisol-btn afrisol-btn-primary afrisol-quote-next">
                                Continue <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Category Selection -->
                    <div class="afrisol-quote-step" data-step="2">
                        <h2>Select Category</h2>
                        <p class="afrisol-text-gray afrisol-mb-3">Choose the category that matches your needs</p>
                        
                        <div class="afrisol-form-group">
                            <select name="category" class="afrisol-form-select" required>
                                <option value="">Select a category...</option>
                                <optgroup label="Solar Power Systems">
                                    <option value="solar_panels">Solar Panels</option>
                                    <option value="inverters">Inverters</option>
                                    <option value="batteries">Batteries</option>
                                    <option value="complete_kit">Complete Solar Kit</option>
                                </optgroup>
                                <optgroup label="Security Systems">
                                    <option value="cctv">CCTV Cameras</option>
                                    <option value="ai_cameras">AI Cameras</option>
                                    <option value="access_control">Access Control</option>
                                    <option value="intercoms">Intercoms</option>
                                    <option value="electric_fence">Electric Fence</option>
                                    <option value="alarms">Alarms</option>
                                </optgroup>
                                <optgroup label="Lighting">
                                    <option value="street_lights">Street Lights</option>
                                    <option value="flood_lights">Flood Lights</option>
                                    <option value="sensor_lights">Sensor Lights</option>
                                </optgroup>
                                <optgroup label="Solar Mobility">
                                    <option value="scooters">Electric Scooters</option>
                                    <option value="bikes">Electric Bikes</option>
                                    <option value="tricycles">Tricycles</option>
                                    <option value="vehicles">Electric Vehicles</option>
                                </optgroup>
                                <optgroup label="Other">
                                    <option value="water_heater">Solar Water Heater</option>
                                    <option value="networking">Networking Equipment</option>
                                    <option value="other">Other</option>
                                </optgroup>
                            </select>
                        </div>
                        
                        <div class="afrisol-flex-between afrisol-mt-3">
                            <button type="button" class="afrisol-btn afrisol-btn-outline afrisol-quote-prev">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="afrisol-btn afrisol-btn-primary afrisol-quote-next">
                                Continue <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 3: Project Details -->
                    <div class="afrisol-quote-step" data-step="3">
                        <h2>Project Details</h2>
                        <p class="afrisol-text-gray afrisol-mb-3">Tell us more about your project</p>
                        
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-label">Project Location / Address *</label>
                            <textarea name="location" class="afrisol-form-textarea" rows="3" required placeholder="Enter the full address where the installation/service is needed"></textarea>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-label">Project Description</label>
                            <textarea name="project_details" class="afrisol-form-textarea" rows="4" placeholder="Describe your requirements, current setup (if any), specific needs, etc."></textarea>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-label">Budget Range</label>
                            <select name="budget_range" class="afrisol-form-select">
                                <option value="">Select budget range</option>
                                <option value="under_500k">Under ₦500,000</option>
                                <option value="500k_1m">₦500,000 - ₦1,000,000</option>
                                <option value="1m_3m">₦1,000,000 - ₦3,000,000</option>
                                <option value="3m_5m">₦3,000,000 - ₦5,000,000</option>
                                <option value="5m_10m">₦5,000,000 - ₦10,000,000</option>
                                <option value="above_10m">Above ₦10,000,000</option>
                            </select>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-label">Upload Photos (Optional)</label>
                            <input type="file" name="photos[]" class="afrisol-form-input" multiple accept="image/*">
                            <p class="afrisol-text-gray" style="font-size: 0.8rem; margin-top: 0.5rem;">
                                Upload photos of your property, roof, or current equipment
                            </p>
                        </div>
                        
                        <div class="afrisol-flex-between afrisol-mt-3">
                            <button type="button" class="afrisol-btn afrisol-btn-outline afrisol-quote-prev">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="afrisol-btn afrisol-btn-primary afrisol-quote-next">
                                Continue <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 4: Contact Information -->
                    <div class="afrisol-quote-step" data-step="4">
                        <h2>Contact Information</h2>
                        <p class="afrisol-text-gray afrisol-mb-3">How can we reach you?</p>
                        
                        <div class="afrisol-form-row">
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Full Name *</label>
                                <input type="text" name="customer_name" class="afrisol-form-input" required>
                            </div>
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Email Address *</label>
                                <input type="email" name="customer_email" class="afrisol-form-input" required>
                            </div>
                        </div>
                        
                        <div class="afrisol-form-row">
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Phone Number *</label>
                                <input type="tel" name="customer_phone" class="afrisol-form-input" required>
                            </div>
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">WhatsApp Number</label>
                                <input type="tel" name="customer_whatsapp" class="afrisol-form-input" placeholder="If different from phone">
                            </div>
                        </div>
                        
                        <div class="afrisol-form-row">
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Preferred Contact Method</label>
                                <select name="preferred_contact" class="afrisol-form-select">
                                    <option value="phone">Phone Call</option>
                                    <option value="whatsapp">WhatsApp</option>
                                    <option value="email">Email</option>
                                </select>
                            </div>
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Best Time to Call</label>
                                <select name="best_time" class="afrisol-form-select">
                                    <option value="">Any time</option>
                                    <option value="morning">Morning (9AM - 12PM)</option>
                                    <option value="afternoon">Afternoon (12PM - 4PM)</option>
                                    <option value="evening">Evening (4PM - 7PM)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="afrisol-flex-between afrisol-mt-3">
                            <button type="button" class="afrisol-btn afrisol-btn-outline afrisol-quote-prev">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="afrisol-btn afrisol-btn-primary afrisol-quote-next">
                                Review & Submit <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 5: Summary & Submit -->
                    <div class="afrisol-quote-step" data-step="5">
                        <h2>Review Your Request</h2>
                        <p class="afrisol-text-gray afrisol-mb-3">Please verify your information before submitting</p>
                        
                        <div class="afrisol-quote-summary">
                            <div class="afrisol-card afrisol-mb-2">
                                <h4><i class="fas fa-clipboard-list"></i> Request Summary</h4>
                                <div id="quoteSummary">
                                    <!-- Populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-checkbox">
                                <input type="checkbox" name="agree_terms" required>
                                I agree to be contacted regarding this quote request
                            </label>
                        </div>
                        
                        <div class="afrisol-flex-between afrisol-mt-3">
                            <button type="button" class="afrisol-btn afrisol-btn-outline afrisol-quote-prev">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="submit" class="afrisol-btn afrisol-btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit Request
                            </button>
                        </div>
                    </div>
                    
                    <!-- Thank You Step -->
                    <div class="afrisol-quote-step afrisol-quote-thankyou" data-step="6">
                        <div class="afrisol-thankyou-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <h2>Thank You!</h2>
                        <p class="afrisol-mb-3">Your quote request has been submitted successfully.</p>
                        
                        <div class="afrisol-confirmation-number">
                            <!-- Quote number populated by JavaScript -->
                        </div>
                        
                        <p class="afrisol-text-gray afrisol-mb-3">
                            Our team will review your request and contact you within <strong>24-48 hours</strong>.
                        </p>
                        
                        <div class="afrisol-mb-3">
                            <a href="#" class="afrisol-btn afrisol-btn-outline afrisol-btn-sm">
                                <i class="fas fa-download"></i> Download Company Brochure
                            </a>
                        </div>
                        
                        <div class="afrisol-social-follow">
                            <p class="afrisol-text-gray afrisol-mb-2">Follow us on social media:</p>
                            <div class="afrisol-footer-social">
                                <a href="<?php echo esc_url(get_option('afrisol_facebook')); ?>" target="_blank" class="afrisol-social-link"><i class="fab fa-facebook-f"></i></a>
                                <a href="<?php echo esc_url(get_option('afrisol_instagram')); ?>" target="_blank" class="afrisol-social-link"><i class="fab fa-instagram"></i></a>
                                <a href="<?php echo esc_url(get_option('afrisol_tiktok')); ?>" target="_blank" class="afrisol-social-link"><i class="fab fa-tiktok"></i></a>
                            </div>
                        </div>
                        
                        <a href="<?php echo esc_url(home_url()); ?>" class="afrisol-btn afrisol-btn-primary afrisol-mt-3">
                            <i class="fas fa-home"></i> Return to Homepage
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php get_footer(); ?>