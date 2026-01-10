<?php
/**
 * Template: Book Repair Page
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="afrisol-repair-page afrisol-quote-page">
    <div class="afrisol-container">
        <div class="afrisol-breadcrumb">
            <a href="<?php echo esc_url(home_url()); ?>">Home</a>
            <span class="afrisol-breadcrumb-separator">/</span>
            <a href="<?php echo esc_url(home_url('/services')); ?>">Services</a>
            <span class="afrisol-breadcrumb-separator">/</span>
            <span class="afrisol-breadcrumb-current">Book Repair</span>
        </div>
        
        <div class="afrisol-quote-card">
            <div class="afrisol-calculator-header" style="background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);">
                <h1><i class="fas fa-tools"></i> Book a Repair Service</h1>
                <p>Fill out the form below and our technicians will get back to you</p>
            </div>
            
            <div class="afrisol-quote-body">
                <form id="afrisolRepairForm">
                    <!-- Equipment Information -->
                    <div class="afrisol-form-section">
                        <h3><i class="fas fa-cog"></i> Equipment Information</h3>
                        
                        <div class="afrisol-form-row">
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Equipment Type *</label>
                                <select name="equipment_type" class="afrisol-form-select" required>
                                    <option value="">Select Equipment Type</option>
                                    <optgroup label="Solar Power">
                                        <option value="solar_panel">Solar Panel</option>
                                        <option value="inverter">Inverter</option>
                                        <option value="battery">Battery</option>
                                        <option value="charge_controller">Charge Controller</option>
                                    </optgroup>
                                    <optgroup label="Security Systems">
                                        <option value="cctv">CCTV Camera</option>
                                        <option value="dvr_nvr">DVR/NVR</option>
                                        <option value="access_control">Access Control System</option>
                                        <option value="intercom">Intercom</option>
                                        <option value="alarm">Alarm System</option>
                                        <option value="electric_fence">Electric Fence</option>
                                    </optgroup>
                                    <optgroup label="Lighting">
                                        <option value="street_light">Street Light</option>
                                        <option value="flood_light">Flood Light</option>
                                        <option value="sensor_light">Sensor Light</option>
                                    </optgroup>
                                    <optgroup label="Electric Vehicles">
                                        <option value="e_scooter">Electric Scooter</option>
                                        <option value="e_bike">Electric Bike</option>
                                        <option value="tricycle">Electric Tricycle</option>
                                    </optgroup>
                                    <optgroup label="Other">
                                        <option value="water_heater">Solar Water Heater</option>
                                        <option value="networking">Networking Equipment</option>
                                        <option value="other">Other</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Brand & Model *</label>
                                <input type="text" name="brand_model" class="afrisol-form-input" placeholder="e.g., Luminous 5kVA Inverter" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Problem Description -->
                    <div class="afrisol-form-section">
                        <h3><i class="fas fa-exclamation-triangle"></i> Problem Description</h3>
                        
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-label">Describe the Problem *</label>
                            <textarea name="problem_description" class="afrisol-form-textarea" rows="4" required placeholder="Please describe the issue you're experiencing in detail. Include any error codes, unusual sounds, or behaviors."></textarea>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-label">Upload Photos/Videos (Optional)</label>
                            <div class="afrisol-file-upload">
                                <input type="file" name="media[]" multiple accept="image/*,video/*" id="repairMedia">
                                <label for="repairMedia" class="afrisol-file-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Click to upload or drag & drop</span>
                                    <small>Images and videos up to 10MB each</small>
                                </label>
                            </div>
                            <div class="afrisol-file-preview"></div>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-checkbox">
                                <input type="checkbox" name="warranty_status" value="1">
                                This equipment is still under warranty
                            </label>
                        </div>
                    </div>
                    
                    <!-- Service Preferences -->
                    <div class="afrisol-form-section">
                        <h3><i class="fas fa-truck"></i> Service Preferences</h3>
                        
                        <div class="afrisol-form-row">
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Preferred Service Type *</label>
                                <select name="service_type" class="afrisol-form-select" required>
                                    <option value="onsite">On-site Service (Technician comes to you)</option>
                                    <option value="dropoff">Drop-off at Service Center</option>
                                    <option value="pickup">Arrange Pickup</option>
                                </select>
                            </div>
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Urgency Level *</label>
                                <select name="urgency" class="afrisol-form-select" required>
                                    <option value="normal">Normal (Within 48 hours)</option>
                                    <option value="high">High (Within 24 hours)</option>
                                    <option value="urgent">Urgent (Same Day - Extra charges may apply)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="afrisol-form-section">
                        <h3><i class="fas fa-user"></i> Contact Information</h3>
                        
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
                        
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-label">Service Address *</label>
                            <textarea name="service_address" class="afrisol-form-textarea" rows="3" required placeholder="Full address for on-site service or pickup"></textarea>
                        </div>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label class="afrisol-form-checkbox">
                            <input type="checkbox" name="agree_terms" required>
                            I agree to the <a href="/terms" target="_blank">Terms of Service</a> and understand that a diagnostic fee may apply
                        </label>
                    </div>
                    
                    <button type="submit" class="afrisol-btn afrisol-btn-secondary afrisol-btn-lg">
                        <i class="fas fa-paper-plane"></i> Submit Repair Request
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Service Info -->
        <div class="afrisol-repair-info afrisol-mt-4">
            <div class="afrisol-grid afrisol-grid-3">
                <div class="afrisol-info-card">
                    <i class="fas fa-clock"></i>
                    <h4>Fast Response</h4>
                    <p>We respond to all repair requests within 24 hours</p>
                </div>
                <div class="afrisol-info-card">
                    <i class="fas fa-tools"></i>
                    <h4>Expert Technicians</h4>
                    <p>Certified professionals with years of experience</p>
                </div>
                <div class="afrisol-info-card">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Warranty on Repairs</h4>
                    <p>90-day warranty on all repair services</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.afrisol-form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--afrisol-gray-light);
}

.afrisol-form-section:last-of-type {
    border-bottom: none;
}

.afrisol-form-section h3 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    color: var(--afrisol-primary);
}

.afrisol-form-section h3 i {
    font-size: 1.25rem;
}

.afrisol-file-upload {
    position: relative;
}

.afrisol-file-upload input[type="file"] {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.afrisol-file-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 2rem;
    border: 2px dashed var(--afrisol-gray-light);
    border-radius: var(--radius-md);
    text-align: center;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.afrisol-file-label:hover {
    border-color: var(--afrisol-primary);
    background: rgba(27, 94, 32, 0.05);
}

.afrisol-file-label i {
    font-size: 2rem;
    color: var(--afrisol-secondary);
}

.afrisol-file-label small {
    color: var(--afrisol-gray);
    font-size: 0.8rem;
}

.afrisol-file-preview {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 1rem;
}

.afrisol-file-preview .preview-thumb {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: var(--radius-sm);
    border: 2px solid var(--afrisol-gray-light);
}

.afrisol-repair-info {
    margin-top: 3rem;
}

.afrisol-info-card {
    text-align: center;
    padding: 2rem;
    background: var(--afrisol-white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
}

.afrisol-info-card i {
    font-size: 2.5rem;
    color: var(--afrisol-secondary);
    margin-bottom: 1rem;
}

.afrisol-info-card h4 {
    margin-bottom: 0.5rem;
}

.afrisol-info-card p {
    color: var(--afrisol-gray);
    font-size: 0.9rem;
    margin: 0;
}
</style>