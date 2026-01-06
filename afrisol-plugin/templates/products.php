<?php
/**
 * Template: Products Page
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get filter parameters
$category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$brand = isset($_GET['brand']) ? sanitize_text_field($_GET['brand']) : '';
$sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'date';
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// Build query args
$args = array(
    'post_type' => 'afrisol_product',
    'posts_per_page' => 12,
    'paged' => $paged
);

// Category filter
if ($category) {
    $args['tax_query'][] = array(
        'taxonomy' => 'afrisol_product_cat',
        'field' => 'slug',
        'terms' => $category
    );
}

// Sort
switch ($sort) {
    case 'price_low':
        $args['meta_key'] = '_afrisol_price';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'ASC';
        break;
    case 'price_high':
        $args['meta_key'] = '_afrisol_price';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
        break;
    case 'popularity':
        $args['meta_key'] = '_afrisol_sales_count';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
        break;
    case 'rating':
        $args['meta_key'] = '_afrisol_average_rating';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
        break;
    default:
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
}

$products = new WP_Query($args);

// Get categories
$categories = get_terms(array(
    'taxonomy' => 'afrisol_product_cat',
    'hide_empty' => true,
    'parent' => 0
));

// Get brands
$brands = get_terms(array(
    'taxonomy' => 'afrisol_brand',
    'hide_empty' => true
));
?>

<div class="afrisol-products-page">
    <!-- Page Header -->
    <div class="afrisol-products-header">
        <div class="afrisol-container">
            <h1>Our Products</h1>
            <p>Quality solar power systems, security solutions, and electric mobility</p>
            <div class="afrisol-breadcrumb">
                <a href="<?php echo home_url(); ?>">Home</a>
                <span class="afrisol-breadcrumb-separator">/</span>
                <span class="afrisol-breadcrumb-current">Products</span>
            </div>
        </div>
    </div>
    
    <div class="afrisol-section">
        <div class="afrisol-container">
            <div class="afrisol-products-layout">
                <!-- Sidebar Filters -->
                <aside class="afrisol-sidebar">
                    <form id="productFilters">
                        <!-- Categories -->
                        <div class="afrisol-filter-section">
                            <h3 class="afrisol-filter-title">Categories</h3>
                            <ul class="afrisol-filter-list">
                                <?php if ($categories) : foreach ($categories as $cat) : ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="category[]" value="<?php echo esc_attr($cat->slug); ?>" <?php checked($category, $cat->slug); ?>>
                                            <?php echo esc_html($cat->name); ?>
                                            <span class="afrisol-filter-count"><?php echo $cat->count; ?></span>
                                        </label>
                                        <?php 
                                        // Get child categories
                                        $children = get_terms(array(
                                            'taxonomy' => 'afrisol_product_cat',
                                            'hide_empty' => true,
                                            'parent' => $cat->term_id
                                        ));
                                        if ($children) : ?>
                                            <ul class="afrisol-filter-sublist">
                                                <?php foreach ($children as $child) : ?>
                                                    <li>
                                                        <label>
                                                            <input type="checkbox" name="category[]" value="<?php echo esc_attr($child->slug); ?>">
                                                            <?php echo esc_html($child->name); ?>
                                                            <span class="afrisol-filter-count"><?php echo $child->count; ?></span>
                                                        </label>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; endif; ?>
                            </ul>
                        </div>
                        
                        <!-- Price Range -->
                        <div class="afrisol-filter-section">
                            <h3 class="afrisol-filter-title">Price Range</h3>
                            <div class="afrisol-price-range">
                                <div class="afrisol-range-inputs">
                                    <input type="number" id="priceMin" name="price_min" placeholder="Min" class="afrisol-form-input">
                                    <input type="number" id="priceMax" name="price_max" placeholder="Max" class="afrisol-form-input">
                                </div>
                                <button type="button" class="afrisol-btn afrisol-btn-outline afrisol-btn-sm afrisol-btn-block" onclick="Afrisol.applyFilters()">Apply</button>
                            </div>
                        </div>
                        
                        <!-- Brands -->
                        <?php if ($brands) : ?>
                        <div class="afrisol-filter-section">
                            <h3 class="afrisol-filter-title">Brands</h3>
                            <ul class="afrisol-filter-list">
                                <?php foreach ($brands as $brand_item) : ?>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="brand[]" value="<?php echo esc_attr($brand_item->slug); ?>">
                                            <?php echo esc_html($brand_item->name); ?>
                                            <span class="afrisol-filter-count"><?php echo $brand_item->count; ?></span>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Stock Status -->
                        <div class="afrisol-filter-section">
                            <h3 class="afrisol-filter-title">Availability</h3>
                            <ul class="afrisol-filter-list">
                                <li>
                                    <label>
                                        <input type="checkbox" name="in_stock" value="1">
                                        In Stock Only
                                    </label>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Rating Filter -->
                        <div class="afrisol-filter-section">
                            <h3 class="afrisol-filter-title">Rating</h3>
                            <ul class="afrisol-filter-list">
                                <?php for ($r = 4; $r >= 1; $r--) : ?>
                                <li>
                                    <label>
                                        <input type="checkbox" name="rating[]" value="<?php echo $r; ?>">
                                        <?php for ($s = 1; $s <= 5; $s++) : ?>
                                            <i class="fas fa-star<?php echo $s <= $r ? '' : ' star-empty'; ?>" style="color: <?php echo $s <= $r ? '#FF9800' : '#ddd'; ?>;"></i>
                                        <?php endfor; ?>
                                        & Up
                                    </label>
                                </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </form>
                </aside>
                
                <!-- Products Grid -->
                <div class="afrisol-products-main">
                    <!-- Toolbar -->
                    <div class="afrisol-products-toolbar">
                        <div class="afrisol-products-count">
                            Showing <strong><?php echo $products->found_posts; ?></strong> products
                        </div>
                        <div class="afrisol-toolbar-actions">
                            <select class="afrisol-sort-select">
                                <option value="date" <?php selected($sort, 'date'); ?>>Newest</option>
                                <option value="price_low" <?php selected($sort, 'price_low'); ?>>Price: Low to High</option>
                                <option value="price_high" <?php selected($sort, 'price_high'); ?>>Price: High to Low</option>
                                <option value="popularity" <?php selected($sort, 'popularity'); ?>>Popularity</option>
                                <option value="rating" <?php selected($sort, 'rating'); ?>>Rating</option>
                            </select>
                            <div class="afrisol-view-toggle">
                                <button class="afrisol-view-btn active" data-view="grid"><i class="fas fa-th"></i></button>
                                <button class="afrisol-view-btn" data-view="list"><i class="fas fa-list"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Products Grid -->
                    <div class="afrisol-products-grid">
                        <?php if ($products->have_posts()) : while ($products->have_posts()) : $products->the_post(); 
                            $product_id = get_the_ID();
                            $price = get_post_meta($product_id, '_afrisol_price', true);
                            $sale_price = get_post_meta($product_id, '_afrisol_sale_price', true);
                            $stock_status = get_post_meta($product_id, '_afrisol_stock_status', true) ?: 'instock';
                            $categories_list = get_the_terms($product_id, 'afrisol_product_cat');
                            $rating = get_post_meta($product_id, '_afrisol_average_rating', true) ?: 4;
                            $review_count = get_post_meta($product_id, '_afrisol_review_count', true) ?: 0;
                        ?>
                            <div class="afrisol-product-card">
                                <div class="afrisol-product-badges">
                                    <?php if ($sale_price && $sale_price < $price) : 
                                        $discount = round((($price - $sale_price) / $price) * 100);
                                    ?>
                                        <span class="afrisol-product-badge sale">-<?php echo $discount; ?>%</span>
                                    <?php endif; ?>
                                    <?php if ($stock_status === 'outofstock') : ?>
                                        <span class="afrisol-product-badge" style="background: #757575;">Out of Stock</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="afrisol-product-actions">
                                    <button class="afrisol-product-action-btn afrisol-add-to-wishlist" data-product-id="<?php echo $product_id; ?>" data-tooltip="Add to Wishlist">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button class="afrisol-product-action-btn afrisol-quick-view" data-product-id="<?php echo $product_id; ?>" data-tooltip="Quick View">
                                        <i class="far fa-eye"></i>
                                    </button>
                                    <button class="afrisol-product-action-btn afrisol-add-to-compare" data-product-id="<?php echo $product_id; ?>" data-tooltip="Compare">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                </div>
                                
                                <div class="afrisol-product-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('medium'); ?>
                                        <?php else : ?>
                                            <div style="background: #f5f5f5; height: 100%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-image" style="font-size: 3rem; color: #ddd;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                </div>
                                
                                <div class="afrisol-product-info">
                                    <?php if ($categories_list) : ?>
                                        <span class="afrisol-product-category"><?php echo esc_html($categories_list[0]->name); ?></span>
                                    <?php endif; ?>
                                    
                                    <h4 class="afrisol-product-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                    
                                    <div class="afrisol-product-rating">
                                        <span class="stars">
                                            <?php for ($i = 1; $i <= 5; $i++) {
                                                echo $i <= $rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                                            } ?>
                                        </span>
                                        <span class="count">(<?php echo $review_count; ?>)</span>
                                    </div>
                                    
                                    <div class="afrisol-product-price">
                                        <?php if ($sale_price && $sale_price < $price) : ?>
                                            <span class="original">₦<?php echo number_format($price); ?></span>
                                            <span class="current">₦<?php echo number_format($sale_price); ?></span>
                                        <?php else : ?>
                                            <span class="current">₦<?php echo number_format($price); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="afrisol-product-footer">
                                        <?php if ($stock_status !== 'outofstock') : ?>
                                            <button class="afrisol-btn afrisol-btn-primary afrisol-btn-sm afrisol-add-to-cart" data-product-id="<?php echo $product_id; ?>">
                                                <i class="fas fa-shopping-cart"></i> Add to Cart
                                            </button>
                                        <?php else : ?>
                                            <button class="afrisol-btn afrisol-btn-outline afrisol-btn-sm" data-modal="notifyModal" data-product-id="<?php echo $product_id; ?>">
                                                <i class="fas fa-bell"></i> Notify Me
                                            </button>
                                        <?php endif; ?>
                                        <a href="<?php the_permalink(); ?>" class="afrisol-btn afrisol-btn-outline afrisol-btn-sm">Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; else : ?>
                            <div class="afrisol-no-products" style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                                <i class="fas fa-box-open" style="font-size: 4rem; color: #ddd; margin-bottom: 1rem;"></i>
                                <p>No products found matching your criteria.</p>
                                <a href="<?php echo home_url('/products'); ?>" class="afrisol-btn afrisol-btn-primary">View All Products</a>
                            </div>
                        <?php endif; wp_reset_postdata(); ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($products->max_num_pages > 1) : ?>
                    <div class="afrisol-pagination">
                        <?php
                        echo paginate_links(array(
                            'total' => $products->max_num_pages,
                            'current' => $paged,
                            'prev_text' => '<i class="fas fa-chevron-left"></i>',
                            'next_text' => '<i class="fas fa-chevron-right"></i>',
                        ));
                        ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Compare Bar -->
<div class="afrisol-compare-bar">
    <div class="afrisol-container">
        <div class="afrisol-compare-inner">
            <div class="afrisol-compare-items">
                <!-- Items populated by JavaScript -->
            </div>
            <div class="afrisol-compare-actions">
                <button class="afrisol-btn afrisol-btn-primary afrisol-btn-sm" onclick="window.location.href='/compare'">Compare Now</button>
                <button class="afrisol-btn afrisol-btn-outline afrisol-btn-sm" onclick="Afrisol.clearCompare()">Clear All</button>
            </div>
        </div>
    </div>
</div>

<!-- Quick View Modal -->
<div class="afrisol-modal-overlay" id="quickViewModal">
    <div class="afrisol-modal afrisol-quickview-modal">
        <button class="afrisol-modal-close"><i class="fas fa-times"></i></button>
        <div class="afrisol-quickview-content">
            <!-- Loaded via AJAX -->
        </div>
    </div>
</div>

<!-- Notify Me Modal -->
<div class="afrisol-modal-overlay" id="notifyModal">
    <div class="afrisol-modal" style="max-width: 400px;">
        <button class="afrisol-modal-close"><i class="fas fa-times"></i></button>
        <div class="afrisol-modal-content" style="padding: 2rem; text-align: center;">
            <i class="fas fa-bell" style="font-size: 3rem; color: var(--afrisol-secondary); margin-bottom: 1rem;"></i>
            <h3>Notify Me When Available</h3>
            <p class="afrisol-text-gray">Enter your email and we'll let you know when this product is back in stock.</p>
            <form class="afrisol-notify-form" data-product-id="">
                <div class="afrisol-form-group">
                    <input type="email" name="email" class="afrisol-form-input" placeholder="Your email address" required>
                </div>
                <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-block">Notify Me</button>
            </form>
        </div>
    </div>
</div>
