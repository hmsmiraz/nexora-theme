<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- NAV -->
<nav id="site-nav">
  <div class="logo">
    <?php if ( has_custom_logo() ) :
        the_custom_logo();
    else : ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php bloginfo( 'name' ); ?>
        </a>
    <?php endif; ?>
  </div>

  <?php
  wp_nav_menu( [
      'theme_location' => 'primary',
      'container'      => false,
      'menu_class'     => 'nav-menu',
      'fallback_cb'    => function() {
          echo '<ul class="nav-menu">
              <li><a href="#features">Features</a></li>
              <li><a href="#how">How it works</a></li>
              <li><a href="#testimonials">Reviews</a></li>
              <li><a href="#pricing">Pricing</a></li>
          </ul>';
      },
  ] );
  ?>

  <button class="nav-cta" onclick="window.location='#pricing'">
      <?php esc_html_e( 'Get Started Free', 'nexora' ); ?>
  </button>

  <button class="nav-toggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'nexora' ); ?>">
      <span></span><span></span><span></span>
  </button>
</nav>
