<div class="page-container">
    <h1 class="page-title">Sản phẩm Vinamilk</h1>

    <?php if (empty($products)): ?>
        <div class="empty-state">
            <p class="empty-state-text">Chưa có sản phẩm nào.</p>
        </div>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <?php
                        $imagePath = "/shop_vinamilk/uploads/" . htmlspecialchars($product['image']);
                        if (file_exists(__DIR__ . '/../uploads/' . $product['image'])):
                        ?>
                            <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                        <?php else: ?>
                            <div class="product-image-placeholder">
                                <span class="placeholder-text">Không có ảnh</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="product-info">
                        <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>

                        <p class="product-type"><?php echo htmlspecialchars($product['type']); ?></p>

                        <p class="product-price"><?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>

                        <p class="product-description-short">
                            <?php
                            $desc = htmlspecialchars($product['description']);
                            echo mb_strlen($desc) > 100 ? mb_substr($desc, 0, 100) . '...' : $desc;
                            ?>
                        </p>

                        <a href="/shop_vinamilk/index.php?controller=product&action=show&id=<?php echo $product['id']; ?>" class="btn-primary">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>