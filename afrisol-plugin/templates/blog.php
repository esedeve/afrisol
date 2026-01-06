<?php
/**
 * Template: Blog / Resources Page
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get blog categories
$categories = get_terms(array(
    'taxonomy' => 'category',
    'hide_empty' => true
));

// Get posts
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 9,
    'paged' => $paged
);

if ($category) {
    $args['category_name'] = $category;
}

if ($search) {
    $args['s'] = $search;
}

$posts = new WP_Query($args);

// Get featured posts
$featured = get_posts(array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'meta_key' => '_afrisol_featured',
    'meta_value' => '1'
));
?>

<div class="afrisol-blog-page">
    <!-- Page Header -->
    <div class="afrisol-page-header" style="background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);">
        <div class="afrisol-container">
            <h1 class="afrisol-sparkle-text">Resources & Blog</h1>
            <p>Expert tips, guides, and industry news on solar energy and security</p>
            <div class="afrisol-breadcrumb">
                <a href="<?php echo esc_url(home_url()); ?>">Home</a>
                <span class="afrisol-breadcrumb-separator">/</span>
                <span class="afrisol-breadcrumb-current">Blog</span>
            </div>
        </div>
    </div>
    
    <div class="afrisol-section">
        <div class="afrisol-container">
            <!-- Featured Posts -->
            <?php if ($featured && !$search && !$category) : ?>
            <section class="afrisol-featured-posts afrisol-mb-4">
                <h2 class="afrisol-section-title">Featured Articles</h2>
                <div class="afrisol-grid afrisol-grid-3">
                    <?php foreach ($featured as $post) : setup_postdata($post); ?>
                    <article class="afrisol-blog-card featured">
                        <div class="blog-card-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </a>
                            <?php else : ?>
                                <div class="blog-image-placeholder">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            <?php endif; ?>
                            <span class="featured-badge">Featured</span>
                        </div>
                        <div class="blog-card-content">
                            <?php 
                            $post_categories = get_the_category();
                            if ($post_categories) : ?>
                                <a href="?category=<?php echo esc_attr($post_categories[0]->slug); ?>" class="blog-category"><?php echo esc_html($post_categories[0]->name); ?></a>
                            <?php endif; ?>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            <div class="blog-meta">
                                <span><i class="far fa-calendar"></i> <?php echo get_the_date(); ?></span>
                                <span><i class="far fa-clock"></i> <?php echo afrisol_reading_time(get_the_content()); ?> min read</span>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; wp_reset_postdata(); ?>
                </div>
            </section>
            <?php endif; ?>
            
            <!-- Blog Layout -->
            <div class="afrisol-blog-layout">
                <!-- Main Content -->
                <main class="afrisol-blog-main">
                    <?php if ($search || $category) : ?>
                    <div class="afrisol-search-results-header">
                        <?php if ($search) : ?>
                            <h2>Search Results for: "<?php echo esc_html($search); ?>"</h2>
                        <?php elseif ($category) : ?>
                            <h2>Category: <?php echo esc_html(ucwords(str_replace('-', ' ', $category))); ?></h2>
                        <?php endif; ?>
                        <a href="<?php echo esc_url(home_url('/blog')); ?>" class="afrisol-btn afrisol-btn-outline afrisol-btn-sm">
                            <i class="fas fa-times"></i> Clear Filter
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($posts->have_posts()) : ?>
                    <div class="afrisol-blog-grid">
                        <?php while ($posts->have_posts()) : $posts->the_post(); ?>
                        <article class="afrisol-blog-card">
                            <div class="blog-card-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                <?php else : ?>
                                    <div class="blog-image-placeholder">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="blog-card-content">
                                <?php 
                                $post_categories = get_the_category();
                                if ($post_categories) : ?>
                                    <a href="?category=<?php echo esc_attr($post_categories[0]->slug); ?>" class="blog-category"><?php echo esc_html($post_categories[0]->name); ?></a>
                                <?php endif; ?>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                <div class="blog-meta">
                                    <span><i class="far fa-calendar"></i> <?php echo get_the_date(); ?></span>
                                </div>
                            </div>
                        </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($posts->max_num_pages > 1) : ?>
                    <div class="afrisol-pagination">
                        <?php
                        echo paginate_links(array(
                            'total' => $posts->max_num_pages,
                            'current' => $paged,
                            'prev_text' => '<i class="fas fa-chevron-left"></i>',
                            'next_text' => '<i class="fas fa-chevron-right"></i>',
                        ));
                        ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php wp_reset_postdata(); else : ?>
                    <div class="afrisol-no-results">
                        <i class="fas fa-search"></i>
                        <h3>No articles found</h3>
                        <p>Try adjusting your search or browse our categories.</p>
                        <a href="<?php echo esc_url(home_url('/blog')); ?>" class="afrisol-btn afrisol-btn-primary">View All Articles</a>
                    </div>
                    <?php endif; ?>
                </main>
                
                <!-- Sidebar -->
                <aside class="afrisol-blog-sidebar">
                    <!-- Search -->
                    <div class="afrisol-sidebar-widget">
                        <h4>Search</h4>
                        <form action="" method="get" class="afrisol-search-form">
                            <input type="text" name="s" class="afrisol-form-input" placeholder="Search articles..." value="<?php echo esc_attr($search); ?>">
                            <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-sm">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Categories -->
                    <div class="afrisol-sidebar-widget">
                        <h4>Categories</h4>
                        <ul class="afrisol-category-list">
                            <li class="<?php echo !$category ? 'active' : ''; ?>">
                                <a href="<?php echo esc_url(home_url('/blog')); ?>">All Articles</a>
                            </li>
                            <?php foreach ($categories as $cat) : ?>
                            <li class="<?php echo $category === $cat->slug ? 'active' : ''; ?>">
                                <a href="?category=<?php echo esc_attr($cat->slug); ?>">
                                    <?php echo esc_html($cat->name); ?>
                                    <span class="count"><?php echo $cat->count; ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <!-- Popular Topics -->
                    <div class="afrisol-sidebar-widget">
                        <h4>Popular Topics</h4>
                        <div class="afrisol-tag-cloud">
                            <a href="?s=solar+panels" class="afrisol-tag">Solar Panels</a>
                            <a href="?s=inverter" class="afrisol-tag">Inverters</a>
                            <a href="?s=battery" class="afrisol-tag">Batteries</a>
                            <a href="?s=installation" class="afrisol-tag">Installation</a>
                            <a href="?s=maintenance" class="afrisol-tag">Maintenance</a>
                            <a href="?s=cctv" class="afrisol-tag">CCTV</a>
                            <a href="?s=energy+saving" class="afrisol-tag">Energy Saving</a>
                            <a href="?s=guide" class="afrisol-tag">Guides</a>
                        </div>
                    </div>
                    
                    <!-- Newsletter -->
                    <div class="afrisol-sidebar-widget newsletter-widget">
                        <div class="newsletter-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Subscribe to Our Newsletter</h4>
                        <p>Get the latest articles, tips, and promotions delivered to your inbox.</p>
                        <form class="afrisol-newsletter-form">
                            <input type="email" name="email" class="afrisol-form-input" placeholder="Your email address" required>
                            <button type="submit" class="afrisol-btn afrisol-btn-primary afrisol-btn-block">Subscribe</button>
                        </form>
                    </div>
                    
                    <!-- CTA -->
                    <div class="afrisol-sidebar-widget cta-widget">
                        <h4>Ready to Go Solar?</h4>
                        <p>Get a free quote and start saving on your energy bills today.</p>
                        <a href="<?php echo esc_url(home_url('/get-quote')); ?>" class="afrisol-btn afrisol-btn-secondary afrisol-btn-block">
                            <i class="fas fa-file-invoice"></i> Get Free Quote
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>

<?php
// Helper function for reading time
function afrisol_reading_time($content) {
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    return max(1, $reading_time);
}
?>

<style>
.afrisol-featured-posts .afrisol-blog-card {
    position: relative;
}

.featured-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: var(--afrisol-secondary);
    color: #fff;
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 600;
}

.afrisol-blog-layout {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 3rem;
}

.afrisol-blog-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
}

.afrisol-blog-card {
    background: var(--afrisol-white);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all var(--transition-fast);
}

.afrisol-blog-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.blog-card-image {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.blog-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-normal);
}

.afrisol-blog-card:hover .blog-card-image img {
    transform: scale(1.05);
}

.blog-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--afrisol-gray-light);
}

.blog-image-placeholder i {
    font-size: 3rem;
    color: #ddd;
}

.blog-card-content {
    padding: 1.5rem;
}

.blog-category {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--afrisol-secondary);
    margin-bottom: 0.5rem;
}

.blog-card-content h3 {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.blog-card-content h3 a {
    color: var(--afrisol-black);
}

.blog-card-content h3 a:hover {
    color: var(--afrisol-primary);
}

.blog-card-content p {
    font-size: 0.9rem;
    color: var(--afrisol-gray);
    margin-bottom: 1rem;
}

.blog-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.8rem;
    color: var(--afrisol-gray);
}

.blog-meta i {
    margin-right: 0.25rem;
}

/* Sidebar */
.afrisol-sidebar-widget {
    background: var(--afrisol-white);
    padding: 1.5rem;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    margin-bottom: 1.5rem;
}

.afrisol-sidebar-widget h4 {
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--afrisol-primary);
}

.afrisol-search-form {
    display: flex;
    gap: 0.5rem;
}

.afrisol-search-form input {
    flex: 1;
}

.afrisol-category-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.afrisol-category-list li {
    border-bottom: 1px solid var(--afrisol-gray-light);
}

.afrisol-category-list li:last-child {
    border-bottom: none;
}

.afrisol-category-list a {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    color: var(--afrisol-black);
    transition: color var(--transition-fast);
}

.afrisol-category-list a:hover,
.afrisol-category-list li.active a {
    color: var(--afrisol-primary);
}

.afrisol-category-list .count {
    background: var(--afrisol-gray-light);
    padding: 0.1rem 0.5rem;
    border-radius: var(--radius-full);
    font-size: 0.8rem;
}

.afrisol-tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.afrisol-tag {
    display: inline-block;
    padding: 0.4rem 0.75rem;
    background: var(--afrisol-gray-light);
    border-radius: var(--radius-full);
    font-size: 0.85rem;
    color: var(--afrisol-black);
    transition: all var(--transition-fast);
}

.afrisol-tag:hover {
    background: var(--afrisol-primary);
    color: #fff;
}

.newsletter-widget {
    background: linear-gradient(135deg, var(--afrisol-primary) 0%, var(--afrisol-primary-light) 100%);
    color: #fff;
    text-align: center;
}

.newsletter-widget h4 {
    color: #fff;
    border-bottom-color: rgba(255,255,255,0.3);
}

.newsletter-widget p {
    opacity: 0.9;
    margin-bottom: 1rem;
}

.newsletter-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
}

.newsletter-icon i {
    font-size: 1.5rem;
}

.cta-widget {
    background: var(--afrisol-secondary);
    color: #fff;
    text-align: center;
}

.cta-widget h4 {
    color: #fff;
    border-bottom: none;
}

.afrisol-search-results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--afrisol-gray-light);
}

.afrisol-no-results {
    text-align: center;
    padding: 4rem 2rem;
}

.afrisol-no-results i {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 1rem;
}

.afrisol-no-results h3 {
    margin-bottom: 0.5rem;
}

.afrisol-no-results p {
    color: var(--afrisol-gray);
    margin-bottom: 1.5rem;
}

@media (max-width: 1024px) {
    .afrisol-blog-layout {
        grid-template-columns: 1fr;
    }
    
    .afrisol-blog-sidebar {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    .afrisol-blog-grid {
        grid-template-columns: 1fr;
    }
    
    .afrisol-blog-sidebar {
        grid-template-columns: 1fr;
    }
}
</style>