<?php
/**
 * Template: Cart Page
 */

if (!defined('ABSPATH')) {
    exit;
}

$cart = new Afrisol_Cart();
$items = $cart->get_items();
$subtotal = $cart->get_subtotal();
$tax = $cart->get_tax();
$total = $cart->get_total();
?>

<div class="afrisol-cart-page">
    <div class="afrisol-container">
        <div class="afrisol-breadcrumb">
            <a href="<?php echo home_url(); ?>">Home</a>
            <span class="afrisol-breadcrumb-separator">/</span>
            <span class="afrisol-breadcrumb-current">Shopping Cart</span>
        </div>
        
        <h1 class="afrisol-page-title">Shopping Cart</h1>
        
        <?php if (!empty($items)) : ?>
        <div class="afrisol-cart-layout">
            <!-- Cart Items -->
            <div class="afrisol-cart-items">
                <div class="afrisol-cart-header">
                    <span class="cart-col-product">Product</span>
                    <span class="cart-col-price">Price</span>
                    <span class="cart-col-quantity">Quantity</span>
                    <span class="cart-col-total">Total</span>
                </div>
                
                <?php foreach ($items as $item) : ?>
                <div class="afrisol-cart-item" data-item-id="<?php echo esc_attr($item->id); ?>">
                    <div class="afrisol-cart-item-image">
                        <?php if ($item->image) : ?>
                            <img src="<?php echo esc_url($item->image); ?>" alt="<?php echo esc_attr($item->product_name); ?>">
                        <?php else : ?>
                            <div style="background: #f5f5f5; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="color: #ddd;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="afrisol-cart-item-info">
                        <h4 class="afrisol-cart-item-title">
                            <a href="<?php echo get_permalink($item->product_id); ?>"><?php echo esc_html($item->product_name); ?></a>
                        </h4>
                        <div class="afrisol-cart-item-meta">
                            <?php 
                            $sku = get_post_meta($item->product_id, '_afrisol_sku', true);
                            if ($sku) : ?>
                                <span class="sku">SKU: <?php echo esc_html($sku); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="afrisol-cart-item-actions">
                            <button class="afrisol-cart-remove"><i class="fas fa-trash"></i> Remove</button>
                            <button class="afrisol-cart-save"><i class="far fa-heart"></i> Save for Later</button>
                        </div>
                    </div>
                    
                    <div class="afrisol-cart-item-price">
                        <?php if ($item->sale_price && $item->sale_price < $item->price) : ?>
                            <span class="original-price">₦<?php echo number_format($item->price); ?></span>
                        <?php endif; ?>
                        <span class="current-price">₦<?php echo number_format($item->final_price); ?></span>
                    </div>
                    
                    <div class="afrisol-cart-item-quantity">
                        <div class="afrisol-quantity">
                            <button type="button" class="afrisol-quantity-btn">-</button>
                            <input type="number" class="afrisol-quantity-input" value="<?php echo esc_attr($item->quantity); ?>" min="1" max="99">
                            <button type="button" class="afrisol-quantity-btn">+</button>
                        </div>
                    </div>
                    
                    <div class="afrisol-cart-item-total">
                        <span class="afrisol-cart-item-total-price">₦<?php echo number_format($item->total); ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="afrisol-cart-actions">
                    <a href="<?php echo home_url('/products'); ?>" class="afrisol-btn afrisol-btn-outline">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                    <button class="afrisol-btn afrisol-btn-outline" onclick="window.location.reload()">
                        <i class="fas fa-sync-alt"></i> Update Cart
                    </button>
                </div>
            </div>
            
            <!-- Cart Summary -->
            <div class="afrisol-cart-summary">
                <h3>Order Summary</h3>
                
                <div class="afrisol-summary-row">
                    <span>Subtotal</span>
                    <span class="afrisol-subtotal-value">₦<?php echo number_format($subtotal); ?></span>
                </div>
                
                <div class="afrisol-summary-row afrisol-discount-row" style="display: none;">
                    <span>Discount</span>
                    <span class="afrisol-discount-value">-₦0</span>
                </div>
                
                <div class="afrisol-summary-row">
                    <span>VAT (7.5%)</span>
                    <span class="afrisol-tax-value">₦<?php echo number_format($tax); ?></span>
                </div>
                
                <div class="afrisol-summary-row">
                    <span>Shipping</span>
                    <span>Calculated at checkout</span>
                </div>
                
                <div class="afrisol-summary-row total">
                    <span>Total</span>
                    <span class="afrisol-total-value">₦<?php echo number_format($total); ?></span>
                </div>
                
                <form class="afrisol-coupon-form">
                    <input type="text" class="afrisol-form-input" placeholder="Coupon code">
                    <button type="submit" class="afrisol-btn afrisol-btn-outline afrisol-btn-sm">Apply</button>
                </form>
                
                <a href="<?php echo home_url('/checkout'); ?>" class="afrisol-btn afrisol-btn-primary afrisol-checkout-btn">
                    <i class="fas fa-lock"></i> Proceed to Checkout
                </a>
                
                <div class="afrisol-payment-icons">
                    <p style="font-size: 0.8rem; color: #666; margin-bottom: 0.5rem;">Secure Payment:</p>
                    <i class="fab fa-cc-visa" style="font-size: 1.5rem; color: #1a1f71;"></i>
                    <i class="fab fa-cc-mastercard" style="font-size: 1.5rem; color: #eb001b;"></i>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0b/Paystack_Logo.png/200px-Paystack_Logo.png" alt="Paystack" style="height: 20px; vertical-align: middle;">
                </div>
                
                <div class="afrisol-delivery-estimate">
                    <i class="fas fa-truck"></i>
                    <span>Estimated delivery: 3-5 business days</span>
                </div>
            </div>
        </div>
        
        <!-- Cart Recommendations -->
        <div class="afrisol-cart-recommendations">
            <h3 class="afrisol-section-title">You May Also Like</h3>
            <div class="afrisol-products-slider">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php
                        $recommended = get_posts(array(
                            'post_type' => 'afrisol_product',
                            'posts_per_page' => 8,
                            'orderby' => 'rand',
                            'post__not_in' => array_map(function($item) { return $item->product_id; }, $items)
                        ));
                        
                        foreach ($recommended as $product) :
                            $price = get_post_meta($product->ID, '_afrisol_price', true);
                            $sale_price = get_post_meta($product->ID, '_afrisol_sale_price', true);
                        ?>
                        <div class="swiper-slide">
                            <div class="afrisol-product-card">
                                <div class="afrisol-product-image">
                                    <?php if (has_post_thumbnail($product->ID)) : ?>
                                        <?php echo get_the_post_thumbnail($product->ID, 'medium'); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="afrisol-product-info">
                                    <h4 class="afrisol-product-title">
                                        <a href="<?php echo get_permalink($product->ID); ?>"><?php echo esc_html($product->post_title); ?></a>
                                    </h4>
                                    <div class="afrisol-product-price">
                                        <?php if ($sale_price && $sale_price < $price) : ?>
                                            <span class="original">₦<?php echo number_format($price); ?></span>
                                            <span class="current">₦<?php echo number_format($sale_price); ?></span>
                                        <?php else : ?>
                                            <span class="current">₦<?php echo number_format($price); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <button class="afrisol-btn afrisol-btn-primary afrisol-btn-sm afrisol-add-to-cart" data-product-id="<?php echo $product->ID; ?>">
                                        <i class="fas fa-shopping-cart"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button class="swiper-button-prev"></button>
                <button class="swiper-button-next"></button>
            </div>
        </div>
        
        <?php else : ?>
        <!-- Empty Cart -->
        <div class="afrisol-empty-cart" style="text-align: center; padding: 4rem 2rem;">
            <i class="fas fa-shopping-cart" style="font-size: 5rem; color: #ddd; margin-bottom: 1.5rem;"></i>
            <h2>Your cart is empty</h2>
            <p style="color: #666; margin-bottom: 2rem;">Looks like you haven't added any products to your cart yet.</p>
            <a href="<?php echo home_url('/products'); ?>" class="afrisol-btn afrisol-btn-primary afrisol-btn-lg">
                <i class="fas fa-shopping-bag"></i> Start Shopping
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.afrisol-cart-header {
    display: none;
}

@media (min-width: 768px) {
    .afrisol-cart-header {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 1rem;
        padding: 1rem;
        background: var(--afrisol-gray-light);
        border-radius: var(--radius-md);
        margin-bottom: 1rem;
        font-weight: 600;
        font-size: 0.875rem;
    }
}

.afrisol-cart-item {
    display: grid;
    grid-template-columns: 100px 1fr;
    gap: 1rem;
    padding: 1.5rem 0;
    border-bottom: 1px solid var(--afrisol-gray-light);
}

@media (min-width: 768px) {
    .afrisol-cart-item {
        grid-template-columns: 100px 1.5fr 1fr 1fr 1fr;
        align-items: center;
    }
}

.afrisol-cart-item-price .original-price {
    text-decoration: line-through;
    color: var(--afrisol-gray);
    font-size: 0.875rem;
    display: block;
}

.afrisol-cart-item-price .current-price {
    font-weight: 600;
    color: var(--afrisol-primary);
}

.afrisol-cart-actions {
    display: flex;
    justify-content: space-between;
    padding: 1.5rem 0;
    flex-wrap: wrap;
    gap: 1rem;
}

.afrisol-payment-icons {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--afrisol-gray-light);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.afrisol-delivery-estimate {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 1rem;
    padding: 0.75rem;
    background: rgba(27, 94, 32, 0.1);
    border-radius: var(--radius-md);
    font-size: 0.875rem;
    color: var(--afrisol-primary);
}
</style>
