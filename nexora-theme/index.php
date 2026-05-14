<?php
/**
 * Nexora fallback index template.
 * WordPress requires this file. The main landing page
 * is handled by front-page.php when a static front page is set.
 */
get_header();
?>

<main style="padding: 140px 6% 80px; text-align: center;">
  <h1 style="font-family: var(--font-head); font-size: 2.5rem; margin-bottom: 1rem;">
    <?php bloginfo( 'name' ); ?>
  </h1>
  <p style="color: var(--muted); margin-bottom: 2rem;">
    <?php bloginfo( 'description' ); ?>
  </p>
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article>
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <?php the_excerpt(); ?>
    </article>
  <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
