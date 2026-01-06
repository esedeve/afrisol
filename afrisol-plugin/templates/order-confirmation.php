<?php
/**
 * Template: Order Confirmation
 */

if (!defined('ABSPATH')) {
    exit;
}

$order_number = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : '';
$orders = new Afrisol_Orders();
$order = $orders->get_by_number($order_number);
?>

<div class="afrisol-confirmation-page">
    <div class="afrisol-container">
        <?php if ($order) : ?>
        <div class="afrisol-confirmation-card">
            <div class="confirmation-icon">
                <i class="fas fa-check"></i>
            </div>
            
            <h1>Thank You for Your Order!</h1>
            <p class="confirmation-subtitle">Your order has been successfully placed and is being processed.</p>
            
            <div class="order-number-badge">
                <span>Order Number:</span>
                <strong><?php echo esc_html($order->order_number); ?></strong>
            </div>
            
            <div class="confirmation-details">
                <div class="detail-row">
                    <span>Order Date:</span>
                    <span><?php echo date('F j, Y, g:i a', strtotime($order->created_at)); ?></span>
                </div>
                <div class="detail-row">
                    <span>Payment Status:</span>
                    <span class="status-badge <?php echo esc_attr($order->payment_status); ?>">
                        <?php echo ucfirst($order->payment_status); ?>
                    </span>
                </div>
                <div class="detail-row">
                    <span>Order Status:</span>
                    <span class="status-badge <?php echo esc_attr($order->status); ?>">
                        <?php echo ucfirst($order->status); ?>
                    </span>
                </div>
                <div class="detail-row total">
                    <span>Total Amount:</span>
                    <span>₦<?php echo number_format($order->total, 2); ?></span>
                </div>
            </div>
            
            <div class="confirmation-email-notice">
                <i class="fas fa-envelope"></i>
                <p>A confirmation email has been sent to <strong><?php echo esc_html($order->customer_email); ?></strong> with your order details.</p>
            </div>
            
            <?php if ($order->items) : ?>
            <div class="order-items-summary">
                <h3>Order Summary</h3>
                <div class="order-items-list">
                    <?php foreach ($order->items as $item) : ?>
                    <div class="order-item">
                        <span class="item-name"><?php echo esc_html($item->product_name); ?></span>
                        <span class="item-qty">× <?php echo $item->quantity; ?></span>
                        <span class="item-price">₦<?php echo number_format($item->total); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="order-totals">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <span>₦<?php echo number_format($order->subtotal); ?></span>
                    </div>
                    <div class="total-row">
                        <span>VAT</span>
                        <span>₦<?php echo number_format($order->tax); ?></span>
                    </div>
                    <?php if ($order->shipping > 0) : ?>
                    <div class="total-row">
                        <span>Shipping</span>
                        <span>₦<?php echo number_format($order->shipping); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="total-row final">
                        <span>Total</span>
                        <span>₦<?php echo number_format($order->total); ?></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="confirmation-shipping">
                <h3>Shipping Address</h3>
                <p><?php echo nl2br(esc_html($order->shipping_address)); ?></p>
            </div>
            
            <div class="confirmation-next-steps">
                <h3>What Happens Next?</h3>
                <div class="steps-timeline">
                    <div class="timeline-step completed">
                        <div class="step-icon"><i class="fas fa-check"></i></div>
                        <div class="step-content">
                            <strong>Order Placed</strong>
                            <span>Your order has been received</span>
                        </div>
                    </div>
                    <div class="timeline-step <?php echo $order->status !== 'pending' ? 'completed' : ''; ?>">
                        <div class="step-icon"><i class="fas fa-cog"></i></div>
                        <div class="step-content">
                            <strong>Processing</strong>
                            <span>We're preparing your order</span>
                        </div>
                    </div>
                    <div class="timeline-step <?php echo in_array($order->status, array('shipped', 'delivered')) ? 'completed' : ''; ?>">
                        <div class="step-icon"><i class="fas fa-truck"></i></div>
                        <div class="step-content">
                            <strong>Shipped</strong>
                            <span>Your order is on its way</span>
                        </div>
                    </div>
                    <div class="timeline-step <?php echo $order->status === 'delivered' ? 'completed' : ''; ?>">
                        <div class="step-icon"><i class="fas fa-home"></i></div>
                        <div class="step-content">
                            <strong>Delivered</strong>
                            <span>Enjoy your products!</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="confirmation-actions">
                <a href="<?php echo esc_url(home_url('/my-account?tab=orders')); ?>" class="afrisol-btn afrisol-btn-primary">
                    <i class="fas fa-receipt"></i> View Order Details
                </a>
                <a href="<?php echo esc_url(home_url('/products')); ?>" class="afrisol-btn afrisol-btn-outline">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
            </div>
            
            <div class="confirmation-support">
                <p>Need help? Contact our support team:</p>
                <div class="support-links">
                    <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', get_option('afrisol_phone')); ?>">
                        <i class="fas fa-phone"></i> <?php echo get_option('afrisol_phone'); ?>
                    </a>
                    <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', get_option('afrisol_whatsapp')); ?>">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="mailto:<?php echo get_option('afrisol_email'); ?>">
                        <i class="fas fa-envelope"></i> Email
                    </a>
                </div>
            </div>
        </div>
        
        <?php else : ?>
        <div class="afrisol-error-card">
            <i class="fas fa-exclamation-triangle"></i>
            <h2>Order Not Found</h2>
            <p>We couldn't find an order with that number. Please check your order number and try again.</p>
            <a href="<?php echo esc_url(home_url('/products')); ?>" class="afrisol-btn afrisol-btn-primary">Browse Products</a>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.afrisol-confirmation-page {
    padding: 3rem 0;
}

.afrisol-confirmation-card {
    max-width: 700px;
    margin: 0 auto;
    background: var(--afrisol-white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    padding: 3rem;
    text-align: center;
}

.confirmation-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--afrisol-primary) 0%, var(--afrisol-primary-light) 100%);
    border-radius: 50%;
    animation: scaleIn 0.5s ease;
}

@keyframes scaleIn {
    from { transform: scale(0); }
    to { transform: scale(1); }
}

.confirmation-icon i {
    font-size: 3rem;
    color: #fff;
}

.afrisol-confirmation-card h1 {
    margin-bottom: 0.5rem;
    color: var(--afrisol-primary);
}

.confirmation-subtitle {
    color: var(--afrisol-gray);
    margin-bottom: 2rem;
}

.order-number-badge {
    display: inline-flex;
    flex-direction: column;
    gap: 0.25rem;
    padding: 1rem 2rem;
    background: rgba(27, 94, 32, 0.1);
    border-radius: var(--radius-lg);
    margin-bottom: 2rem;
}

.order-number-badge strong {
    font-size: 1.5rem;
    color: var(--afrisol-primary);
    font-family: var(--font-heading);
}

.confirmation-details {
    text-align: left;
    padding: 1.5rem;
    background: var(--afrisol-gray-light);
    border-radius: var(--radius-lg);
    margin-bottom: 2rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row.total {
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--afrisol-primary);
    border-top: 2px solid var(--afrisol-primary);
    margin-top: 0.5rem;
    padding-top: 1rem;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-full);
    font-size: 0.85rem;
    font-weight: 600;
}

.status-badge.completed,
.status-badge.delivered {
    background: rgba(27, 94, 32, 0.15);
    color: var(--afrisol-primary);
}

.status-badge.pending,
.status-badge.processing {
    background: rgba(255, 152, 0, 0.15);
    color: var(--afrisol-secondary-dark);
}

.confirmation-email-notice {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(27, 94, 32, 0.05);
    border-radius: var(--radius-md);
    margin-bottom: 2rem;
    text-align: left;
}

.confirmation-email-notice i {
    font-size: 1.5rem;
    color: var(--afrisol-primary);
}

.confirmation-email-notice p {
    margin: 0;
    font-size: 0.9rem;
}

.order-items-summary {
    text-align: left;
    margin-bottom: 2rem;
    padding: 1.5rem;
    border: 1px solid var(--afrisol-gray-light);
    border-radius: var(--radius-lg);
}

.order-items-summary h3 {
    margin-bottom: 1rem;
    font-size: 1rem;
}

.order-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--afrisol-gray-light);
}

.item-name {
    flex: 1;
}

.item-qty {
    margin-right: 1rem;
    color: var(--afrisol-gray);
}

.item-price {
    font-weight: 600;
}

.order-totals {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 2px solid var(--afrisol-gray-light);
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
}

.total-row.final {
    font-weight: 700;
    font-size: 1.1rem;
    border-top: 1px solid var(--afrisol-gray-light);
    padding-top: 0.75rem;
    margin-top: 0.5rem;
}

.confirmation-shipping {
    text-align: left;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--afrisol-gray-light);
    border-radius: var(--radius-lg);
}

.confirmation-shipping h3 {
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.confirmation-next-steps {
    margin-bottom: 2rem;
}

.confirmation-next-steps h3 {
    margin-bottom: 1.5rem;
    font-size: 1rem;
}

.steps-timeline {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.5rem;
    position: relative;
}

.steps-timeline::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 50px;
    right: 50px;
    height: 2px;
    background: var(--afrisol-gray-light);
}

.timeline-step {
    text-align: center;
    position: relative;
}

.step-icon {
    width: 40px;
    height: 40px;
    margin: 0 auto 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--afrisol-gray-light);
    color: var(--afrisol-gray);
    border-radius: 50%;
    position: relative;
    z-index: 1;
}

.timeline-step.completed .step-icon {
    background: var(--afrisol-primary);
    color: #fff;
}

.step-content strong {
    display: block;
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
}

.step-content span {
    font-size: 0.75rem;
    color: var(--afrisol-gray);
}

.confirmation-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.confirmation-support {
    padding-top: 2rem;
    border-top: 1px solid var(--afrisol-gray-light);
}

.confirmation-support p {
    margin-bottom: 0.75rem;
    color: var(--afrisol-gray);
}

.support-links {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
}

.support-links a {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--afrisol-primary);
    font-weight: 500;
}

.support-links a:hover {
    color: var(--afrisol-secondary);
}

.afrisol-error-card {
    max-width: 500px;
    margin: 0 auto;
    background: var(--afrisol-white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    padding: 3rem;
    text-align: center;
}

.afrisol-error-card i {
    font-size: 4rem;
    color: #E65100;
    margin-bottom: 1rem;
}

.afrisol-error-card h2 {
    margin-bottom: 0.5rem;
}

.afrisol-error-card p {
    color: var(--afrisol-gray);
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .afrisol-confirmation-card {
        padding: 2rem 1.5rem;
    }
    
    .steps-timeline {
        grid-template-columns: 1fr;
        text-align: left;
    }
    
    .steps-timeline::before {
        display: none;
    }
    
    .timeline-step {
        display: flex;
        gap: 1rem;
        text-align: left;
    }
    
    .step-icon {
        margin: 0;
        min-width: 40px;
    }
    
    .step-content {
        flex: 1;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--afrisol-gray-light);
    }
    
    .confirmation-actions {
        flex-direction: column;
    }
    
    .support-links {
        flex-wrap: wrap;
    }
}
</style>