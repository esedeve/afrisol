<?php
/**
 * Template: Solar Calculator
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="afrisol-calculator-page">
    <div class="afrisol-container">
        <div class="afrisol-breadcrumb">
            <a href="<?php echo esc_url(home_url()); ?>">Home</a>
            <span class="afrisol-breadcrumb-separator">/</span>
            <span class="afrisol-breadcrumb-current">Solar Calculator</span>
        </div>
        
        <div class="afrisol-calculator-card" id="afrisolSolarCalculator">
            <div class="afrisol-calculator-header">
                <h1><i class="fas fa-calculator"></i> Solar Savings Calculator</h1>
                <p>Find out how much you can save with solar power</p>
            </div>
            
            <div class="afrisol-calculator-body">
                <!-- Step 1: Property Type -->
                <div class="afrisol-calculator-step active" data-step="1">
                    <h3 class="afrisol-step-title">Step 1: Select Property Type</h3>
                    
                    <div class="afrisol-grid afrisol-grid-3">
                        <div class="afrisol-property-option selected" data-type="home">
                            <i class="fas fa-home"></i>
                            <h4>Residential</h4>
                            <p>Home / Apartment</p>
                        </div>
                        <div class="afrisol-property-option" data-type="business">
                            <i class="fas fa-building"></i>
                            <h4>Commercial</h4>
                            <p>Office / Shop</p>
                        </div>
                        <div class="afrisol-property-option" data-type="industrial">
                            <i class="fas fa-industry"></i>
                            <h4>Industrial</h4>
                            <p>Factory / Warehouse</p>
                        </div>
                    </div>
                    
                    <div class="afrisol-form-group afrisol-mt-3">
                        <label class="afrisol-form-label">Location</label>
                        <input type="text" name="location" class="afrisol-form-input" placeholder="Enter your city or state">
                    </div>
                    
                    <div class="afrisol-text-right afrisol-mt-3">
                        <button type="button" class="afrisol-btn afrisol-btn-primary afrisol-calc-next">
                            Next <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 2: Energy Consumption -->
                <div class="afrisol-calculator-step" data-step="2">
                    <h3 class="afrisol-step-title">Step 2: Energy Consumption</h3>
                    
                    <div class="afrisol-tabs">
                        <button class="afrisol-tab active" data-tab="bill">Monthly Bill</button>
                        <button class="afrisol-tab" data-tab="appliances">Appliances</button>
                    </div>
                    
                    <div class="afrisol-tab-content active" data-tab-content="bill">
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-label">Average Monthly Electricity Bill (₦)</label>
                            <input type="number" name="monthly_bill" class="afrisol-form-input" placeholder="e.g., 50000">
                            <p class="afrisol-text-gray" style="font-size: 0.875rem; margin-top: 0.5rem;">
                                Enter your average monthly electricity bill for accurate calculation.
                            </p>
                        </div>
                    </div>
                    
                    <div class="afrisol-tab-content" data-tab-content="appliances">
                        <p class="afrisol-mb-2">Select the appliances you use daily:</p>
                        <div class="afrisol-appliance-list">
                            <div class="afrisol-appliance-item">
                                <label>
                                    <input type="checkbox" data-appliance="AC" data-watts="1500">
                                    <i class="fas fa-snowflake"></i> Air Conditioner (1.5HP)
                                </label>
                                <input type="number" class="afrisol-form-input afrisol-appliance-qty" value="1" min="1" max="10" placeholder="Qty">
                            </div>
                            <div class="afrisol-appliance-item">
                                <label>
                                    <input type="checkbox" data-appliance="Fridge" data-watts="150">
                                    <i class="fas fa-box"></i> Refrigerator
                                </label>
                                <input type="number" class="afrisol-form-input afrisol-appliance-qty" value="1" min="1" max="10" placeholder="Qty">
                            </div>
                            <div class="afrisol-appliance-item">
                                <label>
                                    <input type="checkbox" data-appliance="TV" data-watts="100">
                                    <i class="fas fa-tv"></i> Television
                                </label>
                                <input type="number" class="afrisol-form-input afrisol-appliance-qty" value="1" min="1" max="10" placeholder="Qty">
                            </div>
                            <div class="afrisol-appliance-item">
                                <label>
                                    <input type="checkbox" data-appliance="Lights" data-watts="60">
                                    <i class="fas fa-lightbulb"></i> LED Lights (x10)
                                </label>
                                <input type="number" class="afrisol-form-input afrisol-appliance-qty" value="10" min="1" max="50" placeholder="Qty">
                            </div>
                            <div class="afrisol-appliance-item">
                                <label>
                                    <input type="checkbox" data-appliance="Fan" data-watts="75">
                                    <i class="fas fa-fan"></i> Ceiling Fan
                                </label>
                                <input type="number" class="afrisol-form-input afrisol-appliance-qty" value="3" min="1" max="20" placeholder="Qty">
                            </div>
                            <div class="afrisol-appliance-item">
                                <label>
                                    <input type="checkbox" data-appliance="Washer" data-watts="500">
                                    <i class="fas fa-tshirt"></i> Washing Machine
                                </label>
                                <input type="number" class="afrisol-form-input afrisol-appliance-qty" value="1" min="1" max="5" placeholder="Qty">
                            </div>
                            <div class="afrisol-appliance-item">
                                <label>
                                    <input type="checkbox" data-appliance="Pump" data-watts="750">
                                    <i class="fas fa-water"></i> Water Pump
                                </label>
                                <input type="number" class="afrisol-form-input afrisol-appliance-qty" value="1" min="1" max="5" placeholder="Qty">
                            </div>
                            <div class="afrisol-appliance-item">
                                <label>
                                    <input type="checkbox" data-appliance="Computer" data-watts="200">
                                    <i class="fas fa-desktop"></i> Computer
                                </label>
                                <input type="number" class="afrisol-form-input afrisol-appliance-qty" value="1" min="1" max="10" placeholder="Qty">
                            </div>
                        </div>
                    </div>
                    
                    <div class="afrisol-flex-between afrisol-mt-3">
                        <button type="button" class="afrisol-btn afrisol-btn-outline afrisol-calc-prev">
                            <i class="fas fa-arrow-left"></i> Previous
                        </button>
                        <button type="button" class="afrisol-btn afrisol-btn-primary afrisol-calc-next">
                            Next <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 3: Roof Details -->
                <div class="afrisol-calculator-step" data-step="3">
                    <h3 class="afrisol-step-title">Step 3: Installation Details</h3>
                    
                    <div class="afrisol-form-group">
                        <label class="afrisol-form-label">Roof Type</label>
                        <select name="roof_type" class="afrisol-form-select">
                            <option value="">Select Roof Type</option>
                            <option value="flat">Flat Roof</option>
                            <option value="sloped">Sloped Roof</option>
                            <option value="metal">Metal Roof</option>
                            <option value="tile">Tile Roof</option>
                            <option value="ground">Ground Mount</option>
                        </select>
                    </div>
                    
                    <div class="afrisol-form-group">
                        <label class="afrisol-form-label">Available Roof Space (sqm) - Approximate</label>
                        <input type="number" name="roof_space" class="afrisol-form-input" placeholder="e.g., 50">
                    </div>
                    
                    <div class="afrisol-flex-between afrisol-mt-3">
                        <button type="button" class="afrisol-btn afrisol-btn-outline afrisol-calc-prev">
                            <i class="fas fa-arrow-left"></i> Previous
                        </button>
                        <button type="button" class="afrisol-btn afrisol-btn-primary afrisol-calculate-btn">
                            <i class="fas fa-calculator"></i> Calculate My Savings
                        </button>
                    </div>
                </div>
                
                <!-- Results -->
                <div class="afrisol-calculator-results" style="display: none;">
                    <!-- Results will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
