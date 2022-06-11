<?php
/**
 * @package llorix-one-lite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-single-page'); ?>>
	<header class="entry-header single-header">
		<?php the_title( '<h1 itemprop="headline" class="entry-title single-title">', '</h1>' ); ?>
		<div class="colored-line-left"></div>
		<div class="clearfix"></div>

		<div class="entry-meta single-entry-meta">

			<?php the_date("F j, Y"); ?> /
			<span itemscope itemprop="author" itemtype="http://schema.org/Person" class="entry-author post-author">
				<span  itemprop="name" class="entry-author author vcard">
					<a itemprop="url" class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' )); ?>" rel="author"><?php the_author(); ?> </a>
				</span>
			</span> /
			<a href="<?php comments_link(); ?>" class="post-comments">
				<?php comments_number( esc_html__('No comments','llorix-one-lite'), esc_html__('One comment','llorix-one-lite'), esc_html__('% comments','llorix-one-lite') ); ?>
			</a>

		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div itemprop="text" class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'llorix-one-lite' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php llorix_one_lite_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

<?php
	$author_first_name =  get_the_author_meta( 'first_name' );
	$author_last_name = get_the_author_meta( 'last_name' );
	$author_description = wp_kses_post( nl2br( get_the_author_meta('description') ) );
	if( !empty( $author_first_name ) || !empty( $author_last_name ) || !empty( $author_description ) ) {
		echo '<div class="author-details-wrap">';
		echo '<div class="content-inner-wrap">';
		echo '<div class="author-details-img-wrap">';
		echo get_avatar( get_the_author_meta( 'user_email' ), '100' );
		echo '</div>';
		$author_name = '';
		if ( ! empty( $author_first_name ) ) {
			$author_name .= sanitize_text_field( $author_first_name ) . ' ';
		}
		if ( ! empty( $author_last_name ) ) {
			$author_name .= sanitize_text_field( $author_last_name );
		}
		echo '<div class="author-details-title" itemprop="author">';
		if( $author_name!=='' ) {
			echo '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( $author_name ) . '">' . esc_html( $author_name ) . '</a>';
		}
		echo '</div>';
		if( !empty( $author_description ) ){
			echo '<div class="author-details-content">' . $author_description . '</div>';
		}
		echo '</div>';
		echo '</div>';
	}