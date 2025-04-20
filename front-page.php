<?php get_header(); ?>

<!-- Hero Section -->
<section class="hero" style="background-image: url('https://images.unsplash.com/photo-1560448204-603b3fc33ddc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
    <div class="container">
        <div class="hero__content">
            <h1 class="hero__title"><?php the_field('title_heading'); ?></h1>
            <p class="hero__subtitle"><?php the_field('desc_title'); ?></p>
            <a href="products.html" class="btn btn--primary"><?php the_field('home_btn_heading_left'); ?></a>
            <a href="about.html" class="btn btn--secondary"><?php the_field('home_btn_heading_right'); ?></a>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="section">
    <div class="container">
        <h2 class="section__title">Các sản phẩm nổi bật</h2>
        <p class="section__subtitle">khám phá những món đồ nội thất phổ biến nhất của chúng tôi, được thiết kế hướng đến sự sang trọng.</p>

        <div class="products">
            <div class="product-card">
                <img src="https://tamlongcraft.com/watermark/product/540x540x1/upload/product/snapedit1704025766802-4137.png" alt="Elegance Sofa" class="product-card__image">
                <div class="product-card__content">
                    <div class="product-card__category">Storage</div>
                    <h3 class="product-card__title">Chậu hoa decor trang trí</h3>
                    <div class="product-card__price">100,000 VNĐ</div>
                    <p class="product-card__description">Chậu cây là vật dụng không thể thiếu trong trang trí nhà cửa. Chậu cây Tam Long không chỉ giúp tô điểm cho không gian sống thêm sinh động, tươi mát mà còn mang lại nhiều lợi ích cho sức khỏe và tinh thần. Có rất nhiều loại chậu cây với nhiều kiểu dáng, chất liệu khác nhau. Tùy theo sở thích và nhu cầu của mình, bạn có thể lựa chọn loại chậu cây phù hợp.</p>
                    <a href="product-detail.html" class="btn btn--dark">Chi tiết</a>
                </div>
            </div>

            <div class="product-card">
                <img src="https://tamlongcraft.com/watermark/product/540x540x1/upload/product/pn08-9581.png" alt="Monarch Dining Table" class="product-card__image">
                <div class="product-card__content">
                    <div class="product-card__category">Ngoại thất</div>
                    <h3 class="product-card__title">Ghế trứng treo PN08</h3>
                    <div class="product-card__price">100,000 VNĐ</div>
                    <p class="product-card__description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur quae quaerat dicta sequi cumque fugit accusantium, consectetur excepturi asperiores rem velit ipsam eligendi a voluptates eos quos, reiciendis dolorum error.</p>
                    <a href="product-detail.html" class="btn btn--dark">Chi tiết</a>
                </div>
            </div>

            <div class="product-card">
                <img src="https://tamlongcraft.com/watermark/product/540x540x1/upload/product/bench-7379.jpg" alt="Serenity Bed Frame" class="product-card__image">
                <div class="product-card__content">
                    <div class="product-card__category">Nội thất</div>
                    <h3 class="product-card__title">Bàn console vuông caro</h3>
                    <div class="product-card__price">100,000 VNĐ</div>
                    <p class="product-card__description">Chúng tôi cung cấp bàn console vuông caro với thiết kế hiện đại và chất lượng cao.</p>
                    <a href="product-detail.html" class="btn btn--dark">Chi tiết</a>
                </div>
            </div>
        </div>

        <div class="section__action">
            <a href="products.html" class="btn btn--primary">Xem tất cả sản phẩm</a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="section section--alt">
    <div class="container">
        <h2 class="section__title">Danh mục để bạn lựa chọn</h2>
        <p class="section__subtitle">Tìm những món đồ độc quyền cho mọi không gian trong ngôi nhà của bạn.</p>

        <div class="categories">
            <a href="products.html" class="category">
                <div class="category__image" style="background-image: url('https://images.unsplash.com/photo-1594026112284-02bb6f3352fe?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                    <div class="category__content">
                        <h3 class="category__title">Sản phẩm mới</h3>
                    </div>
                </div>
            </a>

            <a href="products.html" class="category">
                <div class="category__image" style="background-image: url('https://images.unsplash.com/photo-1618220179428-22790b461013?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                    <div class="category__content">
                        <h3 class="category__title">Storage</h3>
                    </div>
                </div>
            </a>

            <a href="products.html" class="category">
                <div class="category__image" style="background-image: url('https://images.unsplash.com/photo-1594026112284-02bb6f3352fe?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                    <div class="category__content">
                        <h3 class="category__title">Ngoại thất</h3>
                    </div>
                </div>
            </a>

            <a href="products.html" class="category">
                <div class="category__image" style="background-image: url('https://images.unsplash.com/photo-1588046130717-0eb0c9a3ba15?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
                    <div class="category__content">
                        <h3 class="category__title">Nội thất</h3>
                    </div>
                </div>
            </a>


        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="section">
    <div class="container">
        <h2 class="section__title">Tại sao bạn nên chọn TamLongCraft</h2>
        <p class="section__subtitle">Chúng tôi cam kết mang đến sự xuất sắc trong mọi khía cạnh.</p>

        <div class="features">
            <div class="feature">
                <div class="feature__icon">
                    <i class="fas fa-medal"></i>
                </div>
                <h3 class="feature__title">Chất lượng cao cấp</h3>
                <p class="feature__description">Tất cả các sản phẩm của chúng tôi được chế tác từ những vật liệu tốt nhất, đảm bảo độ bền và sang trọng.</p>
            </div>

            <div class="feature">
                <div class="feature__icon">
                    <i class="fas fa-pencil-ruler"></i>
                </div>
                <h3 class="feature__title">Tay nghề chuyên nghiệp</h3>
                <p class="feature__description">Nội thất của chúng tôi được chế tác tỉ mỉ bởi những nghệ nhân có nhiều năm kinh nghiệm.</p>
            </div>

            <div class="feature">
                <div class="feature__icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h3 class="feature__title">Miễn phí giao hàng</h3>
                <p class="feature__description">Miễn phí giao hàng</p>
            </div>

            <div class="feature">
                <div class="feature__icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="feature__title">Bảo hành 10 năm</h3>
                <p class="feature__description">Yên tâm với chính sách bảo hành toàn diện của chúng tôi, bao gồm tất cả các lỗi sản xuất.</p>
            </div>
        </div>
    </div>
</section>

<!-- Latest Articles -->
<section class="section section--alt">
    <div class="container">
        <h2 class="section__title">Gốc cảm hứng</h2>
        <p class="section__subtitle">Khám phá những xu hướng và mẹo mới nhất từ các chuyên gia thiết kế của chúng tôi.</p>

        <div class="articles">
            <div class="article-card">
            <img src="https://images.unsplash.com/photo-1616137422495-1e9e46e2aa77?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Thiết kế phòng khách mơ ước của bạn" class="article-card__image">
            <div class="article-card__content">
                <div class="article-card__date">10 Tháng 4, 2025</div>
                <h3 class="article-card__title">Thiết kế phòng khách mơ ước của bạn</h3>
                <p class="article-card__excerpt">Tìm hiểu cách tạo ra một không gian sống sang trọng kết hợp giữa sự thoải mái và phong cách cao cấp.</p>
                <a href="article-detail.html" class="btn btn--dark">Xem thêm</a>
            </div>
            </div>

            <div class="article-card">
            <img src="https://images.unsplash.com/photo-1589459072535-550f4fae08d2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Xu hướng màu sắc năm 2025" class="article-card__image">
            <div class="article-card__content">
                <div class="article-card__date">5 Tháng 4, 2025</div>
                <h3 class="article-card__title">Xu hướng màu sắc năm 2025</h3>
                <p class="article-card__excerpt">Khám phá các bảng màu đang thống trị thiết kế nội thất cao cấp trong năm nay.</p>
                <a href="article-detail.html" class="btn btn--dark">Xem thêm</a>
            </div>
            </div>

            <div class="article-card">
            <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Nghệ thuật kết hợp chất liệu" class="article-card__image">
            <div class="article-card__content">
                <div class="article-card__date">28 Tháng 3, 2025</div>
                <h3 class="article-card__title">Nghệ thuật kết hợp chất liệu</h3>
                <p class="article-card__excerpt">Tìm hiểu cách kết hợp các vật liệu và chất liệu khác nhau để tạo nên một không gian nội thất tinh tế.</p>
                <a href="article-detail.html" class="btn btn--dark">Xem thêm</a>
            </div>
            </div>
        </div>

        <div class="section__action">
            <a href="articles.html" class="btn btn--primary">Xem tất cả bài viết</a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="section">
    <div class="container">
        <h2 class="section__title">Khách hàng nói gì về chúng tôi</h2>
        <p class="section__subtitle">Lắng nghe từ những khách hàng đã biến đổi ngôi nhà của họ với TamLongCraft.</p>

        <div class="testimonials">
            <div class="testimonial">
                <div class="testimonial__quote">
                    <i class="fas fa-quote-left"></i>
                </div>
                <p class="testimonial__text">Chất lượng và sự tinh xảo của từng sản phẩm tôi mua từ TamLongCraft đã vượt xa mong đợi của tôi. Sự chú ý đến từng chi tiết của họ thật đáng kinh ngạc.</p>
                <div class="testimonial__author">
                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Sarah Johnson" class="testimonial__author-image">
                    <div class="testimonial__author-info">
                        <h4 class="testimonial__author-name">Lê Trần Tấn Tài</h4>
                        <p class="testimonial__author-title">Nhà thiết kế nội thất</p>
                    </div>
                </div>
            </div>

            <div class="testimonial">
                <div class="testimonial__quote">
                    <i class="fas fa-quote-left"></i>
                </div>
                <p class="testimonial__text">Không chỉ nội thất của họ đẹp, mà dịch vụ khách hàng cũng rất tuyệt vời. Đội ngũ giao hàng rất chuyên nghiệp và đảm bảo mọi thứ hoàn hảo.</p>
                <div class="testimonial__author">
                    <img src="https://images.unsplash.com/photo-1566492031773-4f4e44671857?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Lê Trần Tấn Tài" class="testimonial__author-image">
                    <div class="testimonial__author-info">
                        <h4 class="testimonial__author-name">Lê Trần Tấn Tài</h4>
                        <p class="testimonial__author-title">Chủ nhà</p>
                    </div>
                </div>
            </div>

            <div class="testimonial">
                <div class="testimonial__quote">
                    <i class="fas fa-quote-left"></i>
                </div>
                <p class="testimonial__text">Tôi đã trang trí toàn bộ ngôi nhà của mình bằng các sản phẩm từ TamLongCraft. Thiết kế vượt thời gian và chất lượng vượt trội khiến chúng đáng giá từng đồng.</p>
                <div class="testimonial__author">
                    <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Lê Trần Tấn Tài" class="testimonial__author-image">
                    <div class="testimonial__author-info">
                        <h4 class="testimonial__author-name">Lê Trần Tấn Tài</h4>
                        <p class="testimonial__author-title">Nhà phát triển bất động sản</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bản tin -->
<section class="section section--newsletter" style="background-image: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
    <div class="container">
        <div class="newsletter">
            <h2 class="newsletter__title">Tham gia danh sách gửi thư của chúng tôi</h2>
            <p class="newsletter__subtitle">Đăng ký để nhận các ưu đãi độc quyền, mẹo thiết kế và thông báo sản phẩm mới.</p>
            <form class="newsletter__form">
                <input type="email" placeholder="Địa chỉ email của bạn" class="newsletter__input" required>
                <button type="submit" class="btn btn--primary newsletter__btn">Đăng ký</button>
            </form>
        </div>
    </div>
</section>

<!-- Footer -->
<?php get_footer(); ?>