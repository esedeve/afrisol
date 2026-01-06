<?php
/**
 * Template: Single Product
 */

if (!defined('ABSPATH')) {
    exit;
}

$product_id = get_the_ID();
$price = get_post_meta($product_id, '_afrisol_price', true);
$sale_price = get_post_meta($product_id, '_afrisol_sale_price', true);
$sku = get_post_meta($product_id, '_afrisol_sku', true);
$stock = get_post_meta($product_id, '_afrisol_stock', true);
$stock_status = get_post_meta($product_id, '_afrisol_stock_status', true) ?: 'instock';
$brand = get_post_meta($product_id, '_afrisol_brand', true);
$power_capacity = get_post_meta($product_id, '_afrisol_power_capacity', true);
$warranty = get_post_meta($product_id, '_afrisol_warranty', true);
$installment = get_post_meta($product_id, '_afrisol_installment', true);
$gallery = get_post_meta($product_id, '_afrisol_gallery', true);
$specifications = get_post_meta($product_id, '_afrisol_specifications', true);
$rating = get_post_meta($product_id, '_afrisol_average_rating', true) ?: 4;
$review_count = get_post_meta($product_id, '_afrisol_review_count', true) ?: 0;

$categories = get_the_terms($product_id, 'afrisol_product_cat');

// Get related products
$related_args = array(
    'post_type' => 'afrisol_product',
    'posts_per_page' => 4,
    'post__not_in' => array($product_id),
);
if ($categories) {
    $related_args['tax_query'] = array(
        array(
            'taxonomy' => 'afrisol_product_cat',
            'field' => 'term_id',
            'terms' => wp_list_pluck($categories, 'term_id')
        )
    );
}
$related_products = get_posts($related_args);

// Get reviews
$reviews_obj = new Afrisol_Reviews();
$reviews = $reviews_obj->get_product_reviews($product_id, 'approved');

get_header();
?>

<div class="afrisol-single-product">
    <div class="afrisol-container">
        <div class="afrisol-breadcrumb">
            <a href="<?php echo esc_url(home_url()); ?>">Home</a>
            <span class="afrisol-breadcrumb-separator">/</span>
            <a href="<?php echo esc_url(home_url('/products')); ?>">Products</a>
            <span class="afrisol-breadcrumb-separator">/</span>
            <?php if ($categories) : ?>
                <a href="<?php echo get_term_link($categories[0]); ?>"><?php echo esc_html($categories[0]->name); ?></a>
                <span class="afrisol-breadcrumb-separator">/</span>
            <?php endif; ?>
            <span class="afrisol-breadcrumb-current"><?php the_title(); ?></span>
        </div>
        
        <!-- Product Main Section -->
        <div class="afrisol-product-main">
            <!-- Product Gallery -->
            <div class="afrisol-product-gallery">
                <div class="gallery-main">
                    <?php if (has_post_thumbnail()) : ?>
                        <img src="<?php echo get_the_post_thumbnail_url($product_id, 'large'); ?>" alt="<?php the_title(); ?>" id="mainProductImage" data-zoom-image="<?php echo get_the_post_thumbnail_url($product_id, 'full'); ?>">
                    <?php else : ?>
                        <div class="gallery-placeholder">
                            <i class="fas fa-image"></i>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($sale_price && $sale_price < $price) : 
                        $discount = round((($price - $sale_price) / $price) * 100);
                    ?>
                        <span class="afrisol-product-badge sale">-<?php echo $discount; ?>%</span>
                    <?php endif; ?>
                </div>
                
                <?php if ($gallery) : 
                    $gallery_ids = explode(',', $gallery);
                ?>
                <div class="gallery-thumbs">
                    <div class="gallery-thumb active" data-image="<?php echo get_the_post_thumbnail_url($product_id, 'large'); ?>">
                        <?php the_post_thumbnail('thumbnail'); ?>
                    </div>
                    <?php foreach ($gallery_ids as $image_id) : ?>
                        <div class="gallery-thumb" data-image="<?php echo wp_get_attachment_image_url($image_id, 'large'); ?>">
                            <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Product Info -->
            <div class="afrisol-product-info-section">
                <?php if ($categories) : ?>
                    <span class="afrisol-product-category"><?php echo esc_html($categories[0]->name); ?></span>
                <?php endif; ?>
                
                <h1 class="afrisol-product-single-title"><?php the_title(); ?></h1>
                
                <div class="afrisol-product-meta">
                    <?php if ($brand) : ?>
                        <span class="meta-item"><strong>Brand:</strong> <?php echo esc_html($brand); ?></span>
                    <?php endif; ?>
                    <?php if ($sku) : ?>
                        <span class="meta-item"><strong>SKU:</strong> <?php echo esc_html($sku); ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="afrisol-product-rating-row">
                    <div class="stars">
                        <?php for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                        } ?>
                    </div>
                    <span class="rating-text"><?php echo number_format($rating, 1); ?> (<?php echo $review_count; ?> reviews)</span>
                </div>
                
                <div class="afrisol-product-price-section">
                    <?php if ($sale_price && $sale_price < $price) : ?>
                        <span class="original-price">₦<?php echo number_format($price); ?></span>
                        <span class="current-price">₦<?php echo number_format($sale_price); ?></span>
                        <span class="save-badge">Save ₦<?php echo number_format($price - $sale_price); ?></span>
                    <?php else : ?>
                        <span class="current-price">₦<?php echo number_format($price); ?></span>
                    <?php endif; ?>
                </div>
                
                <?php if ($installment) : ?>
                <div class="afrisol-installment-info">
                    <i class="fas fa-credit-card"></i>
                    <span><?php echo esc_html($installment); ?></span>
                </div>
                <?php endif; ?>
                
                <div class="afrisol-stock-status <?php echo esc_attr($stock_status); ?>">
                    <?php if ($stock_status === 'instock') : ?>
                        <i class="fas fa-check-circle"></i> In Stock <?php if ($stock) : ?>(<?php echo $stock; ?> available)<?php endif; ?>
                    <?php elseif ($stock_status === 'lowstock') : ?>
                        <i class="fas fa-exclamation-circle"></i> Low Stock - Only <?php echo $stock; ?> left!
                    <?php else : ?>
                        <i class="fas fa-times-circle"></i> Out of Stock
                    <?php endif; ?>
                </div>
                
                <div class="afrisol-product-excerpt">
                    <?php the_excerpt(); ?>
                </div>
                
                <?php if ($stock_status !== 'outofstock') : ?>
                <div class="afrisol-add-to-cart-section">
                    <div class="afrisol-quantity-selector">
                        <label>Quantity:</label>
                        <div class="afrisol-quantity">
                            <button type="button" class="afrisol-quantity-btn">-</button>
                            <input type="number" class="afrisol-quantity-input" value="1" min="1" max="<?php echo $stock ?: 99; ?>" id="productQty">
                            <button type="button" class="afrisol-quantity-btn">+</button>
                        </div>
                    </div>
                    
                    <div class="afrisol-product-actions">
                        <button class="afrisol-btn afrisol-btn-primary afrisol-btn-lg afrisol-add-to-cart" data-product-id="<?php echo $product_id; ?>">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <button class="afrisol-btn afrisol-btn-secondary afrisol-btn-lg afrisol-buy-now" data-product-id="<?php echo $product_id; ?>">
                            <i class="fas fa-bolt"></i> Buy Now
                        </button>
                    </div>
                    
                    <a href="<?php echo esc_url(home_url('/get-quote')); ?>" class="afrisol-btn afrisol-btn-outline afrisol-btn-block">
                        <i class="fas fa-tools"></i> Request Installation Quote
                    </a>
                </div>
                <?php else : ?>
                <div class="afrisol-out-of-stock-section">
                    <p>This product is currently out of stock. Enter your email to be notified when it's back in stock.</p>
                    <form class="afrisol-notify-form" data-product-id="<?php echo $product_id; ?>">
                        <input type="email" name="email" class="afrisol-form-input" placeholder="Your email address" required>
                        <button type="submit" class="afrisol-btn afrisol-btn-primary">Notify Me</button>
                    </form>
                </div>
                <?php endif; ?>
                
                <div class="afrisol-product-extras">
                    <button class="extra-btn afrisol-add-to-wishlist" data-product-id="<?php echo $product_id; ?>">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                    <button class="extra-btn afrisol-add-to-compare" data-product-id="<?php echo $product_id; ?>">
                        <i class="fas fa-exchange-alt"></i> Compare
                    </button>
                    <button class="extra-btn afrisol-share-product">
                        <i class="fas fa-share-alt"></i> Share
                    </button>
                </div>
                
                <?php if ($warranty) : ?>
                <div class="afrisol-warranty-info">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <strong>Warranty</strong>
                        <span><?php echo esc_html($warranty); ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Product Tabs -->
        <div class="afrisol-product-tabs afrisol-mt-4">
            <div class="tab-headers">
                <button class="tab-header active" data-tab="description">Description</button>
                <button class="tab-header" data-tab="specifications">Specifications</button>
                <button class="tab-header" data-tab="reviews">Reviews (<?php echo $review_count; ?>)</button>
                <button class="tab-header" data-tab="qa">Q&A</button>
            </div>
            
            <div class="tab-content active" id="tab-description">
                <div class="afrisol-product-description">
                    <?php the_content(); ?>
                </div>
            </div>
            
            <div class="tab-content" id="tab-specifications">
                <?php if ($specifications) : ?>
                    <table class="afrisol-specs-table">
                        <?php 
                        $specs = json_decode($specifications, true);
                        if ($specs) :
                            foreach ($specs as $spec) : ?>
                                <tr>
                                    <th><?php echo esc_html($spec['name']); ?></th>
                                    <td><?php echo esc_html($spec['value']); ?></td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                    </table>
                <?php else : ?>
                    <table class="afrisol-specs-table">
                        <?php if ($brand) : ?>
                            <tr><th>Brand</th><td><?php echo esc_html($brand); ?></td></tr>
                        <?php endif; ?>
                        <?php if ($power_capacity) : ?>
                            <tr><th>Power Capacity</th><td><?php echo esc_html($power_capacity); ?></td></tr>
                        <?php endif; ?>
                        <?php if ($warranty) : ?>
                            <tr><th>Warranty</th><td><?php echo esc_html($warranty); ?></td></tr>
                        <?php endif; ?>
                        <?php if ($sku) : ?>
                            <tr><th>SKU</th><td><?php echo esc_html($sku); ?></td></tr>
                        <?php endif; ?>
                    </table>
                <?php endif; ?>
            </div>
            
            <div class="tab-content" id="tab-reviews">
                <div class="afrisol-reviews-section">
                    <div class="reviews-summary">
                        <div class="rating-big">
                            <span class="rating-number"><?php echo number_format($rating, 1); ?></span>
                            <div class="rating-stars">
                                <?php for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                                } ?>
                            </div>
                            <span class="rating-count"><?php echo $review_count; ?> reviews</span>
                        </div>
                    </div>
                    
                    <?php if ($reviews) : ?>
                    <div class="reviews-list">
                        <?php foreach ($reviews as $review) : ?>
                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-avatar">
                                    <?php echo strtoupper(substr($review->reviewer_name, 0, 1)); ?>
                                </div>
                                <div class="reviewer-info">
                                    <strong><?php echo esc_html($review->reviewer_name); ?></strong>
                                    <span class="review-date"><?php echo date('M j, Y', strtotime($review->created_at)); ?></span>
                                </div>
                                <div class="review-rating">
                                    <?php for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $review->rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                                    } ?>
                                </div>
                            </div>
                            <div class="review-content">
                                <?php echo esc_html($review->review_text); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="write-review-section">
                        <h4>Write a Review</h4>
                        <form id="productReviewForm" data-product-id="<?php echo $product_id; ?>">
                            <div class="afrisol-form-row">
                                <div class="afrisol-form-group">
                                    <label class="afrisol-form-label">Your Name *</label>
                                    <input type="text" name="reviewer_name" class="afrisol-form-input" required>
                                </div>
                                <div class="afrisol-form-group">
                                    <label class="afrisol-form-label">Email *</label>
                                    <input type="email" name="reviewer_email" class="afrisol-form-input" required>
                                </div>
                            </div>
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Rating *</label>
                                <div class="star-rating-input">
                                    <?php for ($i = 5; $i >= 1; $i--) : ?>
                                        <input type="radio" name="rating" value="<?php echo $i; ?>" id="star<?php echo $i; ?>" required>
                                        <label for="star<?php echo $i; ?>"><i class="fas fa-star"></i></label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="afrisol-form-group">
                                <label class="afrisol-form-label">Your Review *</label>
                                <textarea name="review_text" class="afrisol-form-textarea" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="afrisol-btn afrisol-btn-primary">Submit Review</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="tab-content" id="tab-qa">
                <div class="afrisol-qa-section">
                    <p class="afrisol-text-gray">Have a question about this product? Ask below!</p>
                    <form class="afrisol-qa-form">
                        <div class="afrisol-form-group">
                            <textarea name="question" class="afrisol-form-textarea" rows="3" placeholder="Type your question here..."></textarea>
                        </div>
                        <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-sm">Ask Question</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        <?php if ($related_products) : ?>
        <section class="afrisol-related-products afrisol-mt-4">
            <h2 class="afrisol-section-title">Related Products</h2>
            <div class="afrisol-grid afrisol-grid-4">
                <?php foreach ($related_products as $product) : 
                    $rel_price = get_post_meta($product->ID, '_afrisol_price', true);
                    $rel_sale_price = get_post_meta($product->ID, '_afrisol_sale_price', true);
                ?>
                <div class="afrisol-product-card">
                    <div class="afrisol-product-image">
                        <a href="<?php echo get_permalink($product->ID); ?>">
                            <?php if (has_post_thumbnail($product->ID)) : ?>
                                <?php echo get_the_post_thumbnail($product->ID, 'medium'); ?>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="afrisol-product-info">
                        <h4 class="afrisol-product-title">
                            <a href="<?php echo get_permalink($product->ID); ?>"><?php echo esc_html($product->post_title); ?></a>
                        </h4>
                        <div class="afrisol-product-price">
                            <?php if ($rel_sale_price && $rel_sale_price < $rel_price) : ?>
                                <span class="original">₦<?php echo number_format($rel_price); ?></span>
                                <span class="current">₦<?php echo number_format($rel_sale_price); ?></span>
                            <?php else : ?>
                                <span class="current">₦<?php echo number_format($rel_price); ?></span>
                            <?php endif; ?>
                        </div>
                        <button class="afrisol-btn afrisol-btn-primary afrisol-btn-sm afrisol-add-to-cart" data-product-id="<?php echo $product->ID; ?>">
                            <i class="fas fa-shopping-cart"></i> Add
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</div>

<style>
.afrisol-product-main {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    margin-top: 2rem;
}

.gallery-main {
    position: relative;
    border-radius: var(--radius-xl);
    overflow: hidden;
    background: var(--afrisol-gray-light);
}

.gallery-main img {
    width: 100%;
    height: auto;
    cursor: zoom-in;
}

.gallery-placeholder {
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.gallery-placeholder i {
    font-size: 5rem;
    color: #ddd;
}

.gallery-thumbs {
    display: flex;
    gap: 0.75rem;
    margin-top: 1rem;
}

.gallery-thumb {
    width: 80px;
    height: 80px;
    border-radius: var(--radius-md);
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all var(--transition-fast);
}

.gallery-thumb.active,
.gallery-thumb:hover {
    border-color: var(--afrisol-primary);
}

.gallery-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.afrisol-product-single-title {
    font-size: 2rem;
    margin: 0.5rem 0 1rem;
}

.afrisol-product-meta {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1rem;
}

.meta-item {
    font-size: 0.9rem;
    color: var(--afrisol-gray);
}

.afrisol-product-rating-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.afrisol-product-rating-row .stars i {
    color: #FFB800;
}

.rating-text {
    color: var(--afrisol-gray);
    font-size: 0.9rem;
}

.afrisol-product-price-section {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.original-price {
    text-decoration: line-through;
    color: var(--afrisol-gray);
    font-size: 1.25rem;
}

.current-price {
    font-size: 2rem;
    font-weight: 800;
    color: var(--afrisol-primary);
    font-family: var(--font-heading);
}

.save-badge {
    background: #FFECB3;
    color: #E65100;
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-full);
    font-size: 0.85rem;
    font-weight: 600;
}

.afrisol-installment-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: rgba(27, 94, 32, 0.1);
    border-radius: var(--radius-md);
    margin-bottom: 1rem;
    font-size: 0.9rem;
    color: var(--afrisol-primary);
}

.afrisol-stock-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.afrisol-stock-status.instock {
    color: var(--afrisol-primary);
}

.afrisol-stock-status.lowstock {
    color: #E65100;
}

.afrisol-stock-status.outofstock {
    color: #C62828;
}

.afrisol-product-excerpt {
    margin-bottom: 1.5rem;
    color: var(--afrisol-gray);
}

.afrisol-quantity-selector {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.afrisol-product-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.afrisol-product-extras {
    display: flex;
    gap: 1rem;
    padding: 1rem 0;
    border-top: 1px solid var(--afrisol-gray-light);
    border-bottom: 1px solid var(--afrisol-gray-light);
    margin: 1.5rem 0;
}

.extra-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--afrisol-gray);
    transition: color var(--transition-fast);
}

.extra-btn:hover {
    color: var(--afrisol-primary);
}

.afrisol-warranty-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(27, 94, 32, 0.05);
    border-radius: var(--radius-md);
}

.afrisol-warranty-info i {
    font-size: 1.5rem;
    color: var(--afrisol-primary);
}

.afrisol-warranty-info strong {
    display: block;
    font-size: 0.85rem;
    color: var(--afrisol-gray);
}

/* Tabs */
.afrisol-product-tabs {
    background: var(--afrisol-white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

.tab-headers {
    display: flex;
    border-bottom: 2px solid var(--afrisol-gray-light);
}

.tab-header {
    flex: 1;
    padding: 1.25rem 1rem;
    background: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
    color: var(--afrisol-gray);
    transition: all var(--transition-fast);
    position: relative;
}

.tab-header:hover {
    color: var(--afrisol-primary);
}

.tab-header.active {
    color: var(--afrisol-primary);
}

.tab-header.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 2px;
    background: var(--afrisol-primary);
}

.tab-content {
    display: none;
    padding: 2rem;
}

.tab-content.active {
    display: block;
}

.afrisol-specs-table {
    width: 100%;
    border-collapse: collapse;
}

.afrisol-specs-table th,
.afrisol-specs-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid var(--afrisol-gray-light);
}

.afrisol-specs-table th {
    width: 200px;
    background: var(--afrisol-gray-light);
    font-weight: 600;
}

/* Reviews */
.reviews-summary {
    text-align: center;
    padding: 2rem;
    background: var(--afrisol-gray-light);
    border-radius: var(--radius-lg);
    margin-bottom: 2rem;
}

.rating-big .rating-number {
    display: block;
    font-size: 3rem;
    font-weight: 800;
    color: var(--afrisol-primary);
}

.rating-big .rating-stars i {
    color: #FFB800;
    font-size: 1.5rem;
}

.review-item {
    padding: 1.5rem 0;
    border-bottom: 1px solid var(--afrisol-gray-light);
}

.review-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.reviewer-avatar {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--afrisol-primary);
    color: #fff;
    border-radius: 50%;
    font-weight: 700;
}

.reviewer-info strong {
    display: block;
}

.review-date {
    font-size: 0.85rem;
    color: var(--afrisol-gray);
}

.review-rating {
    margin-left: auto;
}

.review-rating i {
    color: #FFB800;
}

.star-rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.star-rating-input input {
    display: none;
}

.star-rating-input label {
    cursor: pointer;
    font-size: 1.5rem;
    color: #ddd;
    padding: 0 0.1rem;
}

.star-rating-input input:checked ~ label,
.star-rating-input label:hover,
.star-rating-input label:hover ~ label {
    color: #FFB800;
}

@media (max-width: 1024px) {
    .afrisol-product-main {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .tab-headers {
        flex-wrap: wrap;
    }
    
    .tab-header {
        flex: 1 1 50%;
    }
    
    .afrisol-product-actions {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery thumbnails
    const thumbs = document.querySelectorAll('.gallery-thumb');
    const mainImage = document.getElementById('mainProductImage');
    
    if (thumbs.length && mainImage) {
        thumbs.forEach(function(thumb) {
            thumb.addEventListener('click', function() {
                thumbs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                mainImage.src = this.dataset.image;
            });
        });
    }
    
    // Tabs
    const tabHeaders = document.querySelectorAll('.tab-header');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabHeaders.forEach(function(header) {
        header.addEventListener('click', function() {
            const tab = this.dataset.tab;
            
            tabHeaders.forEach(h => h.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            this.classList.add('active');
            document.getElementById('tab-' + tab).classList.add('active');
        });
    });
});
</script>

<?php get_footer(); ?>
