<?php
/*
Template Name: goods
*/
?>

<?php get_header(); ?>

<main id="site-content">
	<div class="top_title">
		<h2>新商品<br><span>new item</span></h2>
	</div>

	<?php if ( is_archive() || is_search() ) : ?>

		<header class="archive-header archive-header-mobile bg-color-black color-gray">

			<div class="section-inner">

				<?php

				// Store the output, since we're outputting the archive header twice (desktop version and mobile version)
				ob_start(); ?>

				<h6 class="subheading"><?php echo griddist_get_archive_title_prefix(); ?></h6>

				<div class="archive-header-inner">
				
					<h3 class="archive-title color-white hanging-quotes"><?php the_archive_title(); ?></h3>

					<?php if ( is_search() ) :

						global $wp_query; ?>

						<div class="archive-description">
							<p><?php

							// Translators: %s = the number of results
							printf( _nx( 'Found %s result matching your search.', 'Found %s results matching your search.',$wp_query->found_posts, '%s = number of results', 'griddist' ), $wp_query->found_posts ); ?></p>
						</div><!-- .archive-description -->

					<?php elseif ( get_the_archive_description() ) : ?>

						<div class="archive-description">
							<?php the_archive_description(); ?>
						</div><!-- .archive-description -->

					<?php endif; ?>
				
				</div><!-- .archive-header-inner -->

				<?php

				$archive_header_contents = ob_get_clean();

				echo $archive_header_contents;

				?>

			</div><!-- .section-inner -->

		</header><!-- .archive-header -->

	<?php endif; ?>

	<div class="section-inner">

		<div class="posts load-more-target" id="posts">

			<div class="grid-sizer"></div>

			<?php if ( is_archive() || is_search() ) : ?>

				<div class="preview archive-header archive-header-desktop">

					<div class="preview-wrapper bg-color-black color-gray">

						<div class="preview-inner">

							<?php echo $archive_header_contents; ?>

						</div><!-- .preview-inner -->

					</div><!-- .preview -->

				</div><!-- .archive-header -->

				<?php
			endif;


			// ①ページネーションに現在のページ位置を知らせるのに必要
			$paged = (int) get_query_var('paged');

			$args = array(
			// get_option('posts_per_page') ← で管理画面で設定した、記事一覧で表示するページ数を取得
			'posts_per_page' => get_option('posts_per_page'),
			// (int) get_query_var('paged') ← で取得した、$pagedを挿入
			'paged' => $paged,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_type' => 'goods',
			'post_status' => 'publish'
			);

			// ②記事一覧のMaxページ数を取得するのに必要
			$the_query = new WP_Query($args);



			if ( $the_query->have_posts() ) :

				while ( $the_query->have_posts() ) : $the_query->the_post();

					get_template_part( 'inc/post-feed', get_post_type() );

				endwhile;

			endif;
			// 記事一覧のループ終わり
			wp_reset_postdata();

			?>

        </div><!-- .posts -->
		<div class="heght50"></div>
		<?php 
			// ページネーション
			$page_arg = array(
				'current' => max( 1, $paged ),
				'total' => $the_query->max_num_pages,
			);
			
			echo paginate_links($page_arg);
		 ?>

    </div><!-- .section-inner -->

</main><!-- #site-content -->



<?php get_footer(); ?>
