<?php
/**
 * Template: Checkout Page
 */

if (!defined('ABSPATH')) {
    exit;
}

$cart = new Afrisol_Cart();
$items = $cart->get_items();
$subtotal = $cart->get_subtotal();
$tax = $cart->get_tax();
$total = $cart->get_total();

// Redirect to cart if empty
if (empty($items)) {
    wp_redirect(home_url('/cart'));
    exit;
}

$current_user = wp_get_current_user();
?>

<div class="afrisol-checkout-page">
    <div class="afrisol-container">
        <div class="afrisol-breadcrumb">
            <a href="<?php echo home_url(); ?>">Home</a>
            <span class="afrisol-breadcrumb-separator">/</span>
            <a href="<?php echo home_url('/cart'); ?>">Cart</a>
            <span class="afrisol-breadcrumb-separator">/</span>
            <span class="afrisol-breadcrumb-current">Checkout</span>
        </div>
        
        <h1 class="afrisol-page-title">Checkout</h1>
        
        <form id="afrisolCheckoutForm" data-total="<?php echo esc_attr($total); ?>">
            <div class="afrisol-cart-layout">
                <!-- Checkout Steps -->
                <div class="afrisol-checkout-steps">
                    <!-- Step 1: Cart Review -->
                    <div class="afrisol-checkout-step active" data-step="1">
                        <h3><span class="step-number">1</span> Review Your Order</h3>
                        
                        <div class="afrisol-checkout-items">
                            <?php foreach ($items as $item) : ?>
                            <div class="afrisol-checkout-item">
                                <div class="checkout-item-image">
                                    <?php if ($item->image) : ?>
                                        <img src="<?php echo esc_url($item->image); ?>" alt="">
                                    <?php endif; ?>
                                    <span class="checkout-item-qty"><?php echo $item->quantity; ?></span>
                                </div>
                                <div class="checkout-item-info">
                                    <h4><?php echo esc_html($item->product_name); ?></h4>
                                    <span class="checkout-item-price">₦<?php echo number_format($item->final_price); ?> × <?php echo $item->quantity; ?></span>
                                </div>
                                <div class="checkout-item-total">
                                    ₦<?php echo number_format($item->total); ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="afrisol-text-right afrisol-mt-3">
                            <button type="button" class="afrisol-btn afrisol-btn-primary afrisol-checkout-next">
                                Continue to Delivery <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Delivery Information -->
                    <div class="afrisol-checkout-step" data-step="2">
                        <h3><span class="step-number">2</span> Delivery Information</h3>
                        
                        <div class="afrisol-delivery-options afrisol-mb-3">
                            <label class="afrisol-radio-card">
                                <input type="radio" name="delivery_method" value="delivery" checked>
                                <div class="radio-card-content">
                                    <i class="fas fa-truck"></i>
                                    <div>
                                        <strong>Home Delivery</strong>
                                        <p>Delivered to your doorstep</p>
                                    </div>
                                </div>
                            </label>
                            <label class="afrisol-radio-card">
                                <input type="radio" name="delivery_method" value="pickup">
                                <div class="radio-card-content">
                                    <i class="fas fa-store"></i>
                                    <div>
                                        <strong>Store Pickup</strong>
                                        <p>Pick up from our store in Abuja</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div class="afrisol-delivery-address">
                            <div class="afrisol-form-row">
                                <div class="afrisol-form-group">
                                    <label class="afrisol-form-label">Full Name *</label>
                                    <input type="text" name="customer_name" class="afrisol-form-input" value="<?php echo esc_attr($current_user->display_name); ?>" required>
                                </div>
                                <div class="afrisol-form-group">
                                    <label class="afrisol-form-label">Email Address *</label>
                                    <input type="email" name="email" class="afrisol-form-input" value="<?php echo esc_attr($current_user->user_email); ?>" required>
                                </div>
                            </div>
                            
                            <div class="afrisol-form-row">
                                <div class="afrisol-form-group">
                                    <label class="afrisol-form-label">Phone Number *</label>
                                    <input type="tel" name="phone" class="afrisol-form-input" required>
                                </div>
                                <div class="afrisol-form-group">
                                    <label class="afrisol-form-label">State *</label>
                                    <select name="state" class="afrisol-form-select" required>
                                        <option value="">Select State</option>
                                        <option value="Abia">Abia</option>
                                        <option value="Adamawa">Adamawa</option>
                                        <option value="Akwa Ibom">Akwa Ibom</option>
                                        <option value="Anambra">Anambra</option>
                                        <option value="Bauchi">Bauchi</option>
                                        <option value="Bayelsa">Bayelsa</option>
                                        <option value="Benue">Benue</option>
                                        <option value="Borno">Borno</option>
                                        <option value="Cross River">Cross River</option>
                                        <option value="Delta">Delta</option>
                                        <option value="Ebonyi">Ebonyi</option>
                                        <option value="Edo">Edo</option>
                                        <option value="Ekiti">Ekiti</option>
                                        <option value="Enugu">Enugu</option>
                                        <option value="FCT" selected>FCT - Abuja</option>
                                        <option value="Gombe">Gombe</option>
                                        <option value="Imo">Imo</option>
                                        <option value="Jigawa">Jigawa</option>
                                        <option value="Kaduna">Kaduna</option>
                                        <option value="Kano">Kano</option>
                                        <option value="Katsina">Katsina</option>
                                        <option value="Kebbi">Kebbi</option>
                                        <option value="Kogi">Kogi</option>
                                        <option value="Kwara">Kwara</option>
                                        <option value="Lagos">Lagos</option>
                                        <option value="Nasarawa">Nasarawa</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Ogun">Ogun</option>
                                        <option value="Ondo">Ondo</option>
                                        <option value="Osun">Osun</option>
                                        <option value="Oyo">Oyo</option>
                                        <option value="Plateau">Plateau</option>
                                        <option value="Rivers">Rivers</option>
                                        <option value="Sokoto">Sokoto</option>
                                        <option value="Taraba">Taraba</option>
                                        <option value="Yobe">Yobe</option>
                                        <option value="Zamfara">Zamfara</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Delivery Address *</label>
                                <textarea name="shipping_address" class="afrisol-form-textarea" rows="3" required placeholder="Street address, building number, landmark"></textarea>
                            </div>
                            
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-checkbox">
                                    <input type="checkbox" name="same_billing" checked>
                                    Billing address same as delivery address
                                </label>
                            </div>
                        </div>
                        
                        <div class="afrisol-flex-between afrisol-mt-3">
                            <button type="button" class="afrisol-btn afrisol-btn-outline afrisol-checkout-prev">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="afrisol-btn afrisol-btn-primary afrisol-checkout-next">
                                Continue <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 3: Installation -->
                    <div class="afrisol-checkout-step" data-step="3">
                        <h3><span class="step-number">3</span> Installation Service</h3>
                        
                        <p class="afrisol-text-gray afrisol-mb-3">Do you need professional installation for your products?</p>
                        
                        <div class="afrisol-delivery-options afrisol-mb-3">
                            <label class="afrisol-radio-card">
                                <input type="radio" name="installation_required" value="no" checked>
                                <div class="radio-card-content">
                                    <i class="fas fa-times-circle"></i>
                                    <div>
                                        <strong>No Installation Needed</strong>
                                        <p>I'll handle the installation myself</p>
                                    </div>
                                </div>
                            </label>
                            <label class="afrisol-radio-card">
                                <input type="radio" name="installation_required" value="yes">
                                <div class="radio-card-content">
                                    <i class="fas fa-tools"></i>
                                    <div>
                                        <strong>Yes, Schedule Installation</strong>
                                        <p>Our team will contact you to schedule</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div class="afrisol-installation-schedule" style="display: none;">
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Preferred Installation Date</label>
                                <input type="date" name="installation_date" class="afrisol-form-input" min="<?php echo date('Y-m-d', strtotime('+5 days')); ?>">
                            </div>
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Preferred Time</label>
                                <select name="installation_time" class="afrisol-form-select">
                                    <option value="morning">Morning (9AM - 12PM)</option>
                                    <option value="afternoon">Afternoon (12PM - 4PM)</option>
                                </select>
                            </div>
                            <div class="afrisol-info-box">
                                <i class="fas fa-info-circle"></i>
                                <span>Installation pricing will be confirmed after site assessment. Our team will contact you within 24 hours.</span>
                            </div>
                        </div>
                        
                        <div class="afrisol-flex-between afrisol-mt-3">
                            <button type="button" class="afrisol-btn afrisol-btn-outline afrisol-checkout-prev">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="afrisol-btn afrisol-btn-primary afrisol-checkout-next">
                                Continue to Payment <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 4: Payment -->
                    <div class="afrisol-checkout-step" data-step="4">
                        <h3><span class="step-number">4</span> Payment Method</h3>
                        
                        <div class="afrisol-payment-methods">
                            <label class="afrisol-radio-card selected">
                                <input type="radio" name="payment_method" value="paystack" checked>
                                <div class="radio-card-content">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0b/Paystack_Logo.png/200px-Paystack_Logo.png" alt="Paystack" style="height: 24px;">
                                    <div>
                                        <strong>Pay with Paystack</strong>
                                        <p>Card, Bank Transfer, USSD</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div class="afrisol-payment-info afrisol-mt-3">
                            <div class="afrisol-info-box">
                                <i class="fas fa-lock"></i>
                                <span>Your payment information is secure. We use industry-standard encryption to protect your data.</span>
                            </div>
                        </div>
                        
                        <div class="afrisol-form-group afrisol-mt-3">
                            <label class="afrisol-form-label">Order Notes (Optional)</label>
                            <textarea name="notes" class="afrisol-form-textarea" rows="3" placeholder="Special instructions for delivery or installation"></textarea>
                        </div>
                        
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-checkbox">
                                <input type="checkbox" name="terms" required>
                                I agree to the <a href="/terms" target="_blank">Terms & Conditions</a> and <a href="/privacy" target="_blank">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <div class="afrisol-flex-between afrisol-mt-3">
                            <button type="button" class="afrisol-btn afrisol-btn-outline afrisol-checkout-prev">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                            <button type="button" class="afrisol-btn afrisol-btn-primary afrisol-btn-lg afrisol-pay-btn">
                                <i class="fas fa-lock"></i> Pay ₦<?php echo number_format($total); ?>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary Sidebar -->
                <div class="afrisol-cart-summary">
                    <h3>Order Summary</h3>
                    
                    <div class="afrisol-checkout-items-mini">
                        <?php foreach ($items as $item) : ?>
                        <div class="checkout-item-mini">
                            <span><?php echo esc_html($item->product_name); ?> × <?php echo $item->quantity; ?></span>
                            <span>₦<?php echo number_format($item->total); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="afrisol-summary-row">
                        <span>Subtotal</span>
                        <span>₦<?php echo number_format($subtotal); ?></span>
                    </div>
                    
                    <div class="afrisol-summary-row">
                        <span>VAT (7.5%)</span>
                        <span>₦<?php echo number_format($tax); ?></span>
                    </div>
                    
                    <div class="afrisol-summary-row">
                        <span>Shipping</span>
                        <span class="shipping-cost">Calculated</span>
                    </div>
                    
                    <div class="afrisol-summary-row total">
                        <span>Total</span>
                        <span>₦<?php echo number_format($total); ?></span>
                    </div>
                    
                    <div class="afrisol-secure-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure Checkout</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.afrisol-checkout-steps {
    background: var(--afrisol-white);
    border-radius: var(--radius-xl);
    padding: var(--spacing-xl);
    box-shadow: var(--shadow-md);
}

.afrisol-checkout-step {
    display: none;
}

.afrisol-checkout-step.active {
    display: block;
}

.afrisol-checkout-step h3 {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.step-number {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--afrisol-primary);
    color: var(--afrisol-white);
    border-radius: 50%;
    font-size: 0.9rem;
}

.afrisol-checkout-items {
    border: 1px solid var(--afrisol-gray-light);
    border-radius: var(--radius-md);
    overflow: hidden;
}

.afrisol-checkout-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid var(--afrisol-gray-light);
}

.afrisol-checkout-item:last-child {
    border-bottom: none;
}

.checkout-item-image {
    width: 60px;
    height: 60px;
    border-radius: var(--radius-sm);
    overflow: hidden;
    position: relative;
}

.checkout-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.checkout-item-qty {
    position: absolute;
    top: -8px;
    right: -8px;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--afrisol-primary);
    color: var(--afrisol-white);
    border-radius: 50%;
    font-size: 0.7rem;
    font-weight: 700;
}

.checkout-item-info {
    flex: 1;
}

.checkout-item-info h4 {
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.checkout-item-price {
    font-size: 0.85rem;
    color: var(--afrisol-gray);
}

.checkout-item-total {
    font-weight: 600;
    color: var(--afrisol-primary);
}

.afrisol-delivery-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.afrisol-radio-card {
    display: block;
    cursor: pointer;
}

.afrisol-radio-card input {
    display: none;
}

.radio-card-content {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    border: 2px solid var(--afrisol-gray-light);
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
}

.afrisol-radio-card input:checked + .radio-card-content {
    border-color: var(--afrisol-primary);
    background: rgba(27, 94, 32, 0.05);
}

.radio-card-content i {
    font-size: 1.5rem;
    color: var(--afrisol-primary);
}

.radio-card-content strong {
    display: block;
    margin-bottom: 0.25rem;
}

.radio-card-content p {
    font-size: 0.85rem;
    color: var(--afrisol-gray);
    margin: 0;
}

.afrisol-info-box {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem;
    background: rgba(27, 94, 32, 0.05);
    border-radius: var(--radius-md);
    font-size: 0.9rem;
}

.afrisol-info-box i {
    color: var(--afrisol-primary);
    margin-top: 0.2rem;
}

.afrisol-checkout-items-mini {
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--afrisol-gray-light);
}

.checkout-item-mini {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    padding: 0.5rem 0;
}

.afrisol-secure-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
    padding: 0.75rem;
    background: rgba(27, 94, 32, 0.1);
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    color: var(--afrisol-primary);
    font-weight: 600;
}

@media (max-width: 768px) {
    .afrisol-delivery-options {
        grid-template-columns: 1fr;
    }
}
</style>

<script src="https://js.paystack.co/v1/inline.js"></script>
