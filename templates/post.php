<div class="<?php post_class(); ?>">
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php if($show_meta && $show_date): ?>
    <?php echo date_i18n( 'd F Y'); ?>
    <?php endif; ?>
    <?php if($show_excerpt): ?>
        <?php the_excerpt();?>
    <?php endif; ?>
</div>