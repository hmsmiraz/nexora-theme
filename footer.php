<!-- FOOTER -->
<footer id="site-footer">
  <div class="footer-grid">
    <div class="footer-brand">
      <div class="logo">
        <?php if ( has_custom_logo() ) :
            the_custom_logo();
        else : ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php bloginfo( 'name' ); ?>
            </a>
        <?php endif; ?>
      </div>
      <p><?php echo esc_html( get_theme_mod( 'footer_description', 'The most powerful WordPress theme and plugin suite for creators, designers, and agencies.' ) ); ?></p>
    </div>

    <div class="footer-col">
      <h5><?php esc_html_e( 'Product', 'nexora' ); ?></h5>
      <a href="#features"><?php esc_html_e( 'Features', 'nexora' ); ?></a>
      <a href="#"><?php esc_html_e( 'Templates', 'nexora' ); ?></a>
      <a href="#pricing"><?php esc_html_e( 'Pricing', 'nexora' ); ?></a>
      <a href="#"><?php esc_html_e( 'Changelog', 'nexora' ); ?></a>
    </div>

    <div class="footer-col">
      <h5><?php esc_html_e( 'Company', 'nexora' ); ?></h5>
      <a href="#"><?php esc_html_e( 'About', 'nexora' ); ?></a>
      <a href="#"><?php esc_html_e( 'Blog', 'nexora' ); ?></a>
      <a href="#"><?php esc_html_e( 'Careers', 'nexora' ); ?></a>
      <a href="#"><?php esc_html_e( 'Press', 'nexora' ); ?></a>
    </div>

    <div class="footer-col">
      <h5><?php esc_html_e( 'Support', 'nexora' ); ?></h5>
      <a href="#"><?php esc_html_e( 'Documentation', 'nexora' ); ?></a>
      <a href="#"><?php esc_html_e( 'Tutorials', 'nexora' ); ?></a>
      <a href="#"><?php esc_html_e( 'Community', 'nexora' ); ?></a>
      <a href="#"><?php esc_html_e( 'Contact', 'nexora' ); ?></a>
    </div>
  </div>

  <div class="footer-bottom">
    <p><?php echo esc_html( get_theme_mod( 'footer_copyright', '© 2025 Nexora. All rights reserved.' ) ); ?></p>
    <p>
      <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy Policy', 'nexora' ); ?></a>
      &nbsp;·&nbsp;
      <a href="#"><?php esc_html_e( 'Terms of Service', 'nexora' ); ?></a>
    </p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
