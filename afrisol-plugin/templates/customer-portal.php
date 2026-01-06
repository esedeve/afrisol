<?php
/**
 * Template: Customer Portal / Dashboard
 */

if (!defined('ABSPATH')) {
    exit;
}

// Check if user is logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url(home_url('/my-account')));
    exit;
}

$current_user = wp_get_current_user();
$user_id = get_current_user_id();

// Get user data
$orders = new Afrisol_Orders();
$user_orders = $orders->get_user_orders($user_id, 5);

$wishlist = new Afrisol_Wishlist();
$wishlist_items = $wishlist->get_items($user_id);

$loyalty = new Afrisol_Loyalty();
$points = $loyalty->get_points($user_id);

// Determine active tab
$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'dashboard';
?>

<div class="afrisol-portal-page">
    <div class="afrisol-container">
        <div class="afrisol-portal-layout">
            <!-- Sidebar -->
            <aside class="afrisol-portal-sidebar">
                <div class="afrisol-portal-user">
                    <div class="afrisol-portal-avatar">
                        <?php echo get_avatar($user_id, 60); ?>
                    </div>
                    <div class="afrisol-portal-name">
                        <h4><?php echo esc_html($current_user->display_name); ?></h4>
                        <p><?php echo esc_html($current_user->user_email); ?></p>
                    </div>
                </div>
                
                <nav>
                    <ul class="afrisol-portal-menu">
                        <li>
                            <a href="?tab=dashboard" class="<?php echo $active_tab === 'dashboard' ? 'active' : ''; ?>">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="?tab=orders" class="<?php echo $active_tab === 'orders' ? 'active' : ''; ?>">
                                <i class="fas fa-shopping-bag"></i> My Orders
                            </a>
                        </li>
                        <li>
                            <a href="?tab=wishlist" class="<?php echo $active_tab === 'wishlist' ? 'active' : ''; ?>">
                                <i class="fas fa-heart"></i> Wishlist
                            </a>
                        </li>
                        <li>
                            <a href="?tab=installations" class="<?php echo $active_tab === 'installations' ? 'active' : ''; ?>">
                                <i class="fas fa-calendar-alt"></i> Installations
                            </a>
                        </li>
                        <li>
                            <a href="?tab=repairs" class="<?php echo $active_tab === 'repairs' ? 'active' : ''; ?>">
                                <i class="fas fa-tools"></i> Repair Tickets
                            </a>
                        </li>
                        <li>
                            <a href="?tab=warranty" class="<?php echo $active_tab === 'warranty' ? 'active' : ''; ?>">
                                <i class="fas fa-shield-alt"></i> Warranties
                            </a>
                        </li>
                        <li>
                            <a href="?tab=loyalty" class="<?php echo $active_tab === 'loyalty' ? 'active' : ''; ?>">
                                <i class="fas fa-gift"></i> Rewards
                            </a>
                        </li>
                        <li>
                            <a href="?tab=referrals" class="<?php echo $active_tab === 'referrals' ? 'active' : ''; ?>">
                                <i class="fas fa-users"></i> Referrals
                            </a>
                        </li>
                        <li>
                            <a href="?tab=settings" class="<?php echo $active_tab === 'settings' ? 'active' : ''; ?>">
                                <i class="fas fa-cog"></i> Account Settings
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo wp_logout_url(home_url()); ?>">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>
            
            <!-- Main Content -->
            <main class="afrisol-portal-content">
                <?php if ($active_tab === 'dashboard') : ?>
                <!-- Dashboard -->
                <h2>Welcome back, <?php echo esc_html($current_user->first_name ?: $current_user->display_name); ?>!</h2>
                
                <div class="afrisol-dashboard-stats">
                    <div class="afrisol-stat-card">
                        <div class="afrisol-stat-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="afrisol-stat-content">
                            <h3><?php echo count($user_orders); ?></h3>
                            <p>Total Orders</p>
                        </div>
                    </div>
                    <div class="afrisol-stat-card">
                        <div class="afrisol-stat-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="afrisol-stat-content">
                            <h3><?php echo count($wishlist_items); ?></h3>
                            <p>Wishlist Items</p>
                        </div>
                    </div>
                    <div class="afrisol-stat-card">
                        <div class="afrisol-stat-icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div class="afrisol-stat-content">
                            <h3><?php echo number_format($points); ?></h3>
                            <p>Reward Points</p>
                        </div>
                    </div>
                    <div class="afrisol-stat-card">
                        <div class="afrisol-stat-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="afrisol-stat-content">
                            <h3>0</h3>
                            <p>Active Warranties</p>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders -->
                <div class="afrisol-portal-section">
                    <div class="afrisol-section-header-flex">
                        <h3>Recent Orders</h3>
                        <a href="?tab=orders" class="afrisol-link">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                    
                    <?php if ($user_orders) : ?>
                    <table class="afrisol-orders-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user_orders as $order) : ?>
                            <tr>
                                <td><strong><?php echo esc_html($order->order_number); ?></strong></td>
                                <td><?php echo date('M j, Y', strtotime($order->created_at)); ?></td>
                                <td><span class="afrisol-order-status <?php echo esc_attr($order->status); ?>"><?php echo ucfirst($order->status); ?></span></td>
                                <td>₦<?php echo number_format($order->total); ?></td>
                                <td><a href="?tab=orders&order=<?php echo $order->id; ?>" class="afrisol-btn afrisol-btn-outline afrisol-btn-sm">View</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else : ?>
                    <div class="afrisol-empty-state">
                        <i class="fas fa-shopping-bag"></i>
                        <p>No orders yet</p>
                        <a href="<?php echo home_url('/products'); ?>" class="afrisol-btn afrisol-btn-primary afrisol-btn-sm">Start Shopping</a>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Quick Actions -->
                <div class="afrisol-quick-actions">
                    <h3>Quick Actions</h3>
                    <div class="afrisol-action-cards">
                        <a href="<?php echo home_url('/solar-calculator'); ?>" class="afrisol-action-card">
                            <i class="fas fa-calculator"></i>
                            <span>Solar Calculator</span>
                        </a>
                        <a href="<?php echo home_url('/get-quote'); ?>" class="afrisol-action-card">
                            <i class="fas fa-file-invoice"></i>
                            <span>Get Quote</span>
                        </a>
                        <a href="<?php echo home_url('/book-repair'); ?>" class="afrisol-action-card">
                            <i class="fas fa-tools"></i>
                            <span>Book Repair</span>
                        </a>
                        <a href="<?php echo home_url('/contact'); ?>" class="afrisol-action-card">
                            <i class="fas fa-headset"></i>
                            <span>Contact Support</span>
                        </a>
                    </div>
                </div>
                
                <?php elseif ($active_tab === 'orders') : ?>
                <!-- Orders Tab -->
                <h2>My Orders</h2>
                
                <?php 
                $all_orders = $orders->get_user_orders($user_id, 50);
                if ($all_orders) : ?>
                <table class="afrisol-orders-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_orders as $order) : ?>
                        <tr>
                            <td><strong><?php echo esc_html($order->order_number); ?></strong></td>
                            <td><?php echo date('M j, Y', strtotime($order->created_at)); ?></td>
                            <td><span class="afrisol-order-status <?php echo esc_attr($order->status); ?>"><?php echo ucfirst($order->status); ?></span></td>
                            <td><span class="afrisol-payment-status <?php echo esc_attr($order->payment_status); ?>"><?php echo ucfirst($order->payment_status); ?></span></td>
                            <td>₦<?php echo number_format($order->total); ?></td>
                            <td>
                                <a href="?tab=orders&order=<?php echo $order->id; ?>" class="afrisol-btn afrisol-btn-outline afrisol-btn-sm">View</a>
                                <?php if ($order->payment_status === 'completed') : ?>
                                <a href="#" class="afrisol-btn afrisol-btn-outline afrisol-btn-sm"><i class="fas fa-download"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else : ?>
                <div class="afrisol-empty-state">
                    <i class="fas fa-shopping-bag"></i>
                    <h3>No orders yet</h3>
                    <p>When you make a purchase, your orders will appear here.</p>
                    <a href="<?php echo home_url('/products'); ?>" class="afrisol-btn afrisol-btn-primary">Start Shopping</a>
                </div>
                <?php endif; ?>
                
                <?php elseif ($active_tab === 'wishlist') : ?>
                <!-- Wishlist Tab -->
                <h2>My Wishlist</h2>
                
                <?php if ($wishlist_items) : ?>
                <div class="afrisol-wishlist-grid">
                    <?php foreach ($wishlist_items as $item) : 
                        $product = get_post($item->product_id);
                        if (!$product) continue;
                        $price = get_post_meta($item->product_id, '_afrisol_price', true);
                        $stock_status = get_post_meta($item->product_id, '_afrisol_stock_status', true);
                    ?>
                    <div class="afrisol-wishlist-item">
                        <div class="wishlist-item-image">
                            <?php echo get_the_post_thumbnail($item->product_id, 'thumbnail'); ?>
                        </div>
                        <div class="wishlist-item-info">
                            <h4><a href="<?php echo get_permalink($item->product_id); ?>"><?php echo esc_html($product->post_title); ?></a></h4>
                            <span class="wishlist-item-price">₦<?php echo number_format($price); ?></span>
                            <span class="stock-<?php echo $stock_status; ?>"><?php echo $stock_status === 'instock' ? 'In Stock' : 'Out of Stock'; ?></span>
                        </div>
                        <div class="wishlist-item-actions">
                            <?php if ($stock_status === 'instock') : ?>
                            <button class="afrisol-btn afrisol-btn-primary afrisol-btn-sm afrisol-add-to-cart" data-product-id="<?php echo $item->product_id; ?>">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                            <?php endif; ?>
                            <button class="afrisol-btn afrisol-btn-outline afrisol-btn-sm afrisol-remove-wishlist" data-product-id="<?php echo $item->product_id; ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else : ?>
                <div class="afrisol-empty-state">
                    <i class="fas fa-heart"></i>
                    <h3>Your wishlist is empty</h3>
                    <p>Save items you love by clicking the heart icon on products.</p>
                    <a href="<?php echo home_url('/products'); ?>" class="afrisol-btn afrisol-btn-primary">Browse Products</a>
                </div>
                <?php endif; ?>
                
                <?php elseif ($active_tab === 'loyalty') : ?>
                <!-- Loyalty Tab -->
                <h2>Reward Points</h2>
                
                <div class="afrisol-loyalty-card">
                    <div class="loyalty-points">
                        <span class="points-value"><?php echo number_format($points); ?></span>
                        <span class="points-label">Available Points</span>
                    </div>
                    <div class="loyalty-info">
                        <p>Earn 1 point for every ₦1,000 spent</p>
                        <p>100 points = ₦1,000 discount</p>
                    </div>
                </div>
                
                <div class="afrisol-portal-section">
                    <h3>How to Earn Points</h3>
                    <ul class="afrisol-earn-points">
                        <li><i class="fas fa-shopping-cart"></i> <strong>Shop:</strong> Earn 1 point per ₦1,000 spent</li>
                        <li><i class="fas fa-user-plus"></i> <strong>Refer:</strong> Earn 500 points per successful referral</li>
                        <li><i class="fas fa-star"></i> <strong>Review:</strong> Earn 50 points per verified review</li>
                        <li><i class="fas fa-birthday-cake"></i> <strong>Birthday:</strong> Get double points during your birthday month</li>
                    </ul>
                </div>
                
                <?php elseif ($active_tab === 'settings') : ?>
                <!-- Account Settings Tab -->
                <h2>Account Settings</h2>
                
                <form class="afrisol-settings-form" method="post">
                    <div class="afrisol-form-section">
                        <h3>Personal Information</h3>
                        <div class="afrisol-form-row">
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">First Name</label>
                                <input type="text" name="first_name" class="afrisol-form-input" value="<?php echo esc_attr($current_user->first_name); ?>">
                            </div>
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Last Name</label>
                                <input type="text" name="last_name" class="afrisol-form-input" value="<?php echo esc_attr($current_user->last_name); ?>">
                            </div>
                        </div>
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-label">Email Address</label>
                            <input type="email" name="email" class="afrisol-form-input" value="<?php echo esc_attr($current_user->user_email); ?>">
                        </div>
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-label">Phone Number</label>
                            <input type="tel" name="phone" class="afrisol-form-input" value="<?php echo esc_attr(get_user_meta($user_id, 'phone', true)); ?>">
                        </div>
                    </div>
                    
                    <div class="afrisol-form-section">
                        <h3>Change Password</h3>
                        <div class="afrisol-form-group">
                            <label class="afrisol-form-label">Current Password</label>
                            <input type="password" name="current_password" class="afrisol-form-input">
                        </div>
                        <div class="afrisol-form-row">
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">New Password</label>
                                <input type="password" name="new_password" class="afrisol-form-input">
                            </div>
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="afrisol-form-input">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="afrisol-btn afrisol-btn-primary">Save Changes</button>
                </form>
                
                <?php endif; ?>
            </main>
        </div>
    </div>
</div>

<style>
.afrisol-section-header-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.afrisol-link {
    color: var(--afrisol-primary);
    font-weight: 500;
}

.afrisol-empty-state {
    text-align: center;
    padding: 3rem;
}

.afrisol-empty-state i {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 1rem;
}

.afrisol-empty-state h3 {
    margin-bottom: 0.5rem;
}

.afrisol-empty-state p {
    color: var(--afrisol-gray);
    margin-bottom: 1rem;
}

.afrisol-quick-actions {
    margin-top: 2rem;
}

.afrisol-action-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-top: 1rem;
}

.afrisol-action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1.5rem;
    background: var(--afrisol-gray-light);
    border-radius: var(--radius-lg);
    text-align: center;
    transition: all var(--transition-fast);
}

.afrisol-action-card:hover {
    background: rgba(27, 94, 32, 0.1);
    transform: translateY(-3px);
}

.afrisol-action-card i {
    font-size: 1.5rem;
    color: var(--afrisol-primary);
}

.afrisol-action-card span {
    font-weight: 500;
    color: var(--afrisol-black);
}

.afrisol-wishlist-grid {
    display: grid;
    gap: 1rem;
}

.afrisol-wishlist-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--afrisol-gray-light);
    border-radius: var(--radius-md);
}

.wishlist-item-image {
    width: 80px;
    height: 80px;
    border-radius: var(--radius-sm);
    overflow: hidden;
}

.wishlist-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.wishlist-item-info {
    flex: 1;
}

.wishlist-item-info h4 {
    margin-bottom: 0.25rem;
}

.wishlist-item-price {
    font-weight: 600;
    color: var(--afrisol-primary);
    margin-right: 0.5rem;
}

.wishlist-item-actions {
    display: flex;
    gap: 0.5rem;
}

.afrisol-loyalty-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 2rem;
    background: linear-gradient(135deg, var(--afrisol-primary) 0%, var(--afrisol-primary-light) 100%);
    color: var(--afrisol-white);
    border-radius: var(--radius-xl);
    margin-bottom: 2rem;
}

.loyalty-points {
    text-align: center;
}

.points-value {
    display: block;
    font-size: 3rem;
    font-weight: 800;
}

.points-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.afrisol-earn-points {
    list-style: none;
    padding: 0;
}

.afrisol-earn-points li {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid var(--afrisol-gray-light);
}

.afrisol-earn-points li i {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(27, 94, 32, 0.1);
    color: var(--afrisol-primary);
    border-radius: 50%;
}

.afrisol-form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--afrisol-gray-light);
}

.afrisol-form-section h3 {
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .afrisol-action-cards {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .afrisol-loyalty-card {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
}
</style>
