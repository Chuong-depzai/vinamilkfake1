<style>
    /* Hero Banner */
    .hero-banner {
        position: relative;
        height: 600px;
        background: linear-gradient(135deg, #0033a0 0%, #005ce6 100%);
        overflow: hidden;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
        height: 100%;
        display: flex;
        align-items: center;
    }

    .hero-text {
        max-width: 600px;
        color: white;
    }

    .hero-title {
        font-size: 56px;
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 20px;
        margin-bottom: 30px;
        opacity: 0.95;
    }

    .hero-btn {
        display: inline-block;
        padding: 15px 40px;
        background: #ff6b00;
        color: white;
        border-radius: 50px;
        font-size: 18px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .hero-btn:hover {
        background: #e55d00;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(255, 107, 0, 0.3);
    }

    .hero-image {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 50%;
        height: 100%;
        background: url('https://www.vinamilk.com.vn/static/0.15.36/images/hero-family.png') no-repeat center;
        background-size: contain;
    }

    /* Category Section */
    .category-section {
        padding: 80px 20px;
        background: white;
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title {
        font-size: 42px;
        color: #0033a0;
        font-weight: 800;
        margin-bottom: 15px;
    }

    .section-subtitle {
        font-size: 18px;
        color: #666;
    }

    .category-grid {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
    }

    .category-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid #f0f0f0;
    }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        border-color: #0033a0;
    }

    .category-icon {
        font-size: 64px;
        margin-bottom: 20px;
    }

    .category-name {
        font-size: 20px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .category-count {
        font-size: 14px;
        color: #999;
    }

    /* Featured Products */
    .featured-section {
        padding: 80px 20px;
        background: #fafafa;
    }

    .product-grid-home {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
    }

    .product-card-home {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .product-card-home:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-color: #0033a0;
    }

    .product-image-home {
        width: 100%;
        height: 250px;
        object-fit: cover;
        background: #f9f9f9;
        padding: 20px;
    }

    .product-info-home {
        padding: 25px;
    }

    .product-category {
        font-size: 12px;
        color: #0033a0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .product-name-home {
        font-size: 18px;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
        line-height: 1.4;
        min-height: 50px;
    }

    .product-price-home {
        font-size: 24px;
        color: #ff6b00;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .product-actions {
        display: flex;
        gap: 10px;
    }

    .btn-view-detail {
        flex: 1;
        padding: 12px;
        background: #0033a0;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-view-detail:hover {
        background: #002780;
    }

    .btn-add-cart {
        padding: 12px 20px;
        background: #ff6b00;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
        background: #e55d00;
    }

    /* Banner CTA */
    .banner-cta {
        padding: 80px 20px;
        background: linear-gradient(135deg, #0033a0 0%, #005ce6 100%);
        text-align: center;
        color: white;
    }

    .banner-cta-title {
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .banner-cta-text {
        font-size: 20px;
        margin-bottom: 40px;
        opacity: 0.95;
    }

    .banner-cta-btn {
        display: inline-block;
        padding: 18px 50px;
        background: white;
        color: #0033a0;
        border-radius: 50px;
        font-size: 18px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .banner-cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
    }

    /* Responsive */
    @media (max-width: 1024px) {

        .category-grid,
        .product-grid-home {
            grid-template-columns: repeat(2, 1fr);
        }

        .hero-title {
            font-size: 42px;
        }
    }

    @media (max-width: 768px) {

        .category-grid,
        .product-grid-home {
            grid-template-columns: 1fr;
        }

        .hero-banner {
            height: 500px;
        }

        .hero-title {
            font-size: 32px;
        }

        .hero-image {
            opacity: 0.3;
        }
    }
</style>

<!-- Hero Banner -->
<section class="hero-banner">
    <div class="hero-content">
        <div class="hero-text">
            <h1 class="hero-title">Dinh dưỡng cho mọi nhà</h1>
            <p class="hero-subtitle">
                Sản phẩm chất lượng cao từ Vinamilk - Thương hiệu được tin dùng hàng đầu Việt Nam
            </p>
            <a href="index.php?controller=product" class="hero-btn">
                Khám phá ngay →
            </a>
        </div>
        <div class="hero-image"></div>
    </div>
</section>

<!-- Categories -->
<section class="category-section">
    <div class="section-header">
        <h2 class="section-title">Danh mục sản phẩm</h2>
        <p class="section-subtitle">Khám phá các dòng sản phẩm đa dạng của Vinamilk</p>
    </div>

    <div class="category-grid">
        <a href="index.php?controller=product&type=infant" class="category-card">
            <div class="category-icon">🍼</div>
            <h3 class="category-name">Sữa bột trẻ em</h3>
            <p class="category-count">15+ sản phẩm</p>
        </a>

        <a href="index.php?controller=product&type=fresh" class="category-card">
            <div class="category-icon">🥛</div>
            <h3 class="category-name">Sữa tươi</h3>
            <p class="category-count">23+ sản phẩm</p>
        </a>

        <a href="index.php?controller=product&type=yogurt" class="category-card">
            <div class="category-icon">🥄</div>
            <h3 class="category-name">Sữa chua</h3>
            <p class="category-count">18+ sản phẩm</p>
        </a>

        <a href="index.php?controller=product&type=other" class="category-card">
            <div class="category-icon">🧀</div>
            <h3 class="category-name">Sản phẩm khác</h3>
            <p class="category-count">30+ sản phẩm</p>
        </a>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-section">
    <div class="section-header">
        <h2 class="section-title">Sản phẩm nổi bật</h2>
        <p class="section-subtitle">Những sản phẩm được yêu thích nhất</p>
    </div>

    <div class="product-grid-home">
        <?php
        // Lấy 8 sản phẩm đầu tiên
        $featuredProducts = array_slice($products, 0, 8);
        foreach ($featuredProducts as $product):
        ?>
            <div class="product-card-home">
                <a href="index.php?controller=product&action=show&id=<?php echo $product['id']; ?>">
                    <?php if (!empty($product['image']) && file_exists(__DIR__ . '/../uploads/' . $product['image'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>"
                            alt="<?php echo htmlspecialchars($product['name']); ?>"
                            class="product-image-home">
                    <?php else: ?>
                        <div class="product-image-home" style="display: flex; align-items: center; justify-content: center; background: #f0f0f0;">
                            <span style="color: #999;">Không có ảnh</span>
                        </div>
                    <?php endif; ?>
                </a>

                <div class="product-info-home">
                    <div class="product-category"><?php echo htmlspecialchars($product['type']); ?></div>
                    <h3 class="product-name-home">
                        <a href="index.php?controller=product&action=show&id=<?php echo $product['id']; ?>">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </a>
                    </h3>
                    <div class="product-price-home">
                        <?php echo number_format($product['price'], 0, ',', '.'); ?> ₫
                    </div>

                    <div class="product-actions">
                        <a href="index.php?controller=product&action=show&id=<?php echo $product['id']; ?>"
                            class="btn-view-detail">
                            Xem chi tiết
                        </a>
                        <form method="POST" action="index.php?controller=cart&action=add" style="display: inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-add-cart">🛒</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 50px;">
        <a href="index.php?controller=product" class="hero-btn">
            Xem tất cả sản phẩm →
        </a>
    </div>
</section>

<!-- CTA Banner -->
<section class="banner-cta">
    <h2 class="banner-cta-title">Tham gia chương trình khách hàng thân thiết</h2>
    <p class="banner-cta-text">Nhận ưu đãi độc quyền và tích điểm đổi quà hấp dẫn</p>
    <a href="index.php?controller=auth&action=showRegister" class="banner-cta-btn">
        Đăng ký ngay
    </a>
</section>