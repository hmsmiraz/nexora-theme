<?php get_header(); ?>

<!-- HERO -->
<section class="hero" id="home">
  <div class="badge">
    <span class="badge-dot"></span>
    <?php echo nexora_mod( 'hero_badge_text', 'Built on WordPress — Powered by Blocks' ); ?>
  </div>

  <h1>
    <span class="gradient-text"><?php echo nexora_mod( 'hero_title_line1', 'Build stunning websites' ); ?></span><br>
    <?php echo nexora_mod( 'hero_title_line2', 'without writing code.' ); ?>
  </h1>

  <p class="hero-sub">
    <?php echo nexora_mod( 'hero_subtitle', 'Nexora is the WordPress theme and plugin suite that transforms the block editor into a full no-code design studio.' ); ?>
  </p>

  <div class="hero-actions">
    <a href="<?php echo esc_url( get_theme_mod( 'hero_btn1_url', '#pricing' ) ); ?>" class="btn-primary">
      <?php echo nexora_mod( 'hero_btn1_text', 'Start for free →' ); ?>
    </a>
    <a href="<?php echo esc_url( get_theme_mod( 'hero_btn2_url', '#how' ) ); ?>" class="btn-ghost">
      <?php echo nexora_mod( 'hero_btn2_text', 'See live demo' ); ?>
    </a>
  </div>

  <div class="hero-stats">
    <div class="stat-item">
      <div class="stat-num"><?php echo nexora_mod( 'hero_stat1_num', '50K+' ); ?></div>
      <div class="stat-label"><?php echo nexora_mod( 'hero_stat1_label', 'Active websites' ); ?></div>
    </div>
    <div class="stat-item">
      <div class="stat-num"><?php echo nexora_mod( 'hero_stat2_num', '4.9★' ); ?></div>
      <div class="stat-label"><?php echo nexora_mod( 'hero_stat2_label', 'Average rating' ); ?></div>
    </div>
    <div class="stat-item">
      <div class="stat-num"><?php echo nexora_mod( 'hero_stat3_num', '200+' ); ?></div>
      <div class="stat-label"><?php echo nexora_mod( 'hero_stat3_label', 'Starter templates' ); ?></div>
    </div>
    <div class="stat-item">
      <div class="stat-num">24/7</div>
      <div class="stat-label"><?php esc_html_e( 'Expert support', 'nexora' ); ?></div>
    </div>
  </div>
</section>

<!-- MARQUEE BANNER -->
<div class="marquee-wrap">
  <div class="marquee-track">
    <?php
    $marquee_items = [
        __( 'WordPress 6.5 Ready', 'nexora' ),
        __( 'Full Site Editing', 'nexora' ),
        __( 'WooCommerce Compatible', 'nexora' ),
        __( 'GDPR Compliant', 'nexora' ),
        __( 'SEO Optimized', 'nexora' ),
        __( 'Lightning Fast', 'nexora' ),
        __( 'One-Click Install', 'nexora' ),
    ];
    // duplicate for seamless loop
    $all_items = array_merge( $marquee_items, $marquee_items );
    foreach ( $all_items as $item ) :
    ?>
      <span><?php echo esc_html( $item ); ?></span><span>·</span>
    <?php endforeach; ?>
  </div>
</div>

<!-- FEATURES -->
<section id="features">
  <div class="features-head">
    <div class="section-label"><?php esc_html_e( 'Features', 'nexora' ); ?></div>
    <div class="section-title"><?php esc_html_e( 'Everything your WordPress site needs', 'nexora' ); ?></div>
    <p class="section-sub"><?php esc_html_e( 'From blazing-fast performance to pixel-perfect design controls — Nexora gives you the power to build anything.', 'nexora' ); ?></p>
  </div>

  <div class="features-grid">
    <?php foreach ( nexora_get_features() as $feature ) : ?>
    <div class="feature-card">
      <div class="feature-icon"><?php echo esc_html( $feature['icon'] ); ?></div>
      <h3><?php echo esc_html( $feature['title'] ); ?></h3>
      <p><?php echo wp_kses_post( $feature['desc'] ); ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- HOW IT WORKS -->
<section id="how">
  <div class="how-grid">
    <div>
      <div class="section-label"><?php esc_html_e( 'How it works', 'nexora' ); ?></div>
      <div class="section-title"><?php esc_html_e( 'Launch your site in three simple steps', 'nexora' ); ?></div>
      <p class="section-sub"><?php esc_html_e( 'Install Nexora, pick a template, and go live. We handle the hard parts so you can focus on your content.', 'nexora' ); ?></p>

      <div class="steps">
        <?php
        $steps = [
            [ 'num' => '01', 'title' => __( 'Install the plugin', 'nexora' ),       'desc' => __( 'Upload Nexora to WordPress or install directly from the plugin directory — one click and you\'re ready.', 'nexora' ) ],
            [ 'num' => '02', 'title' => __( 'Choose a template', 'nexora' ),         'desc' => __( 'Browse 200+ professionally designed starter templates. Import any template with a single click.', 'nexora' ) ],
            [ 'num' => '03', 'title' => __( 'Customize & publish', 'nexora' ),       'desc' => __( 'Edit text, swap images, tweak colors — then hit publish. Your beautiful site is now live.', 'nexora' ) ],
        ];
        foreach ( $steps as $step ) : ?>
        <div class="step">
          <div class="step-num"><?php echo esc_html( $step['num'] ); ?></div>
          <div>
            <h4><?php echo esc_html( $step['title'] ); ?></h4>
            <p><?php echo esc_html( $step['desc'] ); ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="how-visual">
      <div class="mock-browser">
        <div class="mock-bar">
          <div class="dot dot-r"></div>
          <div class="dot dot-y"></div>
          <div class="dot dot-g"></div>
          <div class="mock-url"><?php echo esc_html( str_replace( [ 'https://', 'http://' ], '', home_url() ) ); ?></div>
        </div>
        <div class="mock-body">
          <div class="mock-hero-block">
            <div class="mock-h"></div>
            <div class="mock-h sm"></div>
            <div class="mock-h sm"></div>
            <div class="mock-h btn"></div>
          </div>
          <div class="mock-cards">
            <?php for ( $i = 0; $i < 3; $i++ ) : ?>
            <div class="mock-card">
              <div class="mock-card-top"></div>
              <div class="mock-card-line"></div>
              <div class="mock-card-line short"></div>
            </div>
            <?php endfor; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section id="testimonials">
  <div class="testi-head">
    <div class="section-label"><?php esc_html_e( 'Testimonials', 'nexora' ); ?></div>
    <div class="section-title"><?php esc_html_e( 'Loved by creators worldwide', 'nexora' ); ?></div>
  </div>

  <div class="testi-grid">
    <?php foreach ( nexora_get_testimonials() as $t ) : ?>
    <div class="testi-card">
      <div class="stars">★★★★★</div>
      <p class="testi-text"><?php echo esc_html( $t['text'] ); ?></p>
      <div class="testi-author">
        <div class="avatar"><?php echo esc_html( $t['initials'] ); ?></div>
        <div>
          <div class="author-name"><?php echo esc_html( $t['name'] ); ?></div>
          <div class="author-role"><?php echo esc_html( $t['role'] ); ?></div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- PRICING -->
<section id="pricing">
  <div class="pricing-head">
    <div class="section-label"><?php esc_html_e( 'Pricing', 'nexora' ); ?></div>
    <div class="section-title"><?php esc_html_e( 'Simple, transparent pricing', 'nexora' ); ?></div>
    <p class="section-sub"><?php esc_html_e( 'No surprise fees. Cancel anytime. Start for free.', 'nexora' ); ?></p>
  </div>

  <div class="pricing-grid">
    <?php foreach ( nexora_get_pricing() as $plan ) :
      $card_class = $plan['featured'] ? 'price-card featured' : 'price-card';
    ?>
    <div class="<?php echo esc_attr( $card_class ); ?>">
      <?php if ( $plan['featured'] ) : ?>
        <div class="price-badge"><?php esc_html_e( 'Most popular', 'nexora' ); ?></div>
      <?php endif; ?>

      <div class="price-name"><?php echo esc_html( $plan['name'] ); ?></div>
      <div class="price-amount">
        <sup>$</sup><?php echo esc_html( $plan['price'] ); ?>
      </div>
      <div class="price-period"><?php echo esc_html( $plan['period'] ); ?></div>

      <ul class="price-features">
        <?php foreach ( $plan['features'] as $feature ) : ?>
          <li><?php echo esc_html( trim( $feature ) ); ?></li>
        <?php endforeach; ?>
      </ul>

      <?php $btn_class = ( $plan['btn_style'] === 'primary' ) ? 'btn-primary' : 'btn-ghost'; ?>
      <a href="#" class="<?php echo esc_attr( $btn_class ); ?>" style="width:100%;display:block;text-align:center;text-decoration:none;">
        <?php echo esc_html( $plan['btn_text'] ); ?>
      </a>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- CTA -->
<section id="cta">
  <div class="cta-box">
    <h2><?php echo nexora_mod( 'cta_title', 'Ready to build something beautiful?' ); ?></h2>
    <p><?php echo nexora_mod( 'cta_subtitle', 'Join 50,000+ creators who already use Nexora to build stunning WordPress sites — no coding required.' ); ?></p>
    <div class="cta-actions">
      <a href="#pricing" class="btn-primary"><?php echo nexora_mod( 'cta_btn1', 'Start for free →' ); ?></a>
      <a href="#" class="btn-ghost"><?php echo nexora_mod( 'cta_btn2', 'View all templates' ); ?></a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
