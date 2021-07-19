 <?php do_action( 'arun_main_wrap_inner_end' ); ?>
</div>
<!-- #main -->

<?php do_action( 'arun_before_footer' ); ?>

<footer id="footer" class="<?php echo apply_filters( 'arun_footer_class', '' );?>">

	<?php do_action( 'arun_before_footer_menu' ); ?>

	<?php if (has_nav_menu('bottom')) : ?>
	<div class="<?php echo apply_filters( 'arun_footer_menu_class', 'footer-menu maxwidth' );?>">
		<?php 
		wp_nav_menu( array(
				'theme_location' => 'bottom',
				'menu_id' => 'footer-menu',
				'depth' => 1,
				'container' => false,
				'items_wrap' => '<ul class="footmenu clearfix">%3$s</ul>'
			)); 
		?>
	</div>
	<?php endif; ?>

	<?php do_action( 'arun_before_footer_copyrights' ); ?>
    <?php if ( apply_filters( 'arun_footer_copyrights_enabled', true ) ) : ?>
	<div class="<?php echo apply_filters( 'arun_footer_copyrights_class', 'copyrights maxwidth grid' );?>">
		<div class="<?php echo apply_filters( 'arun_footer_copytext_class', 'copytext col6' );?>">
			<p id="copy">
				<!--noindex--><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="nofollow"><?php bloginfo('name'); ?></a><!--/noindex--> &copy; <?php echo date("Y",time()); ?>
				<br/>
				<span class="copyright-text"><?php echo arun_get_theme_option('copyright_text'); ?></span>
				<?php if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '<br>' );
				} ?>
			</p>
		</div>

		<div class="<?php echo apply_filters( 'arun_footer_themeby_class', 'themeby col6 tr' );?>">
			<p id="designedby">
				<?php _e('Theme by', 'arun'); ?>
				<!--noindex--><a href="<?php echo ARUN_THEME_URI; ?>" target="_blank" rel="external nofollow"><?php _e('arun@erssmail.com ', ''); ?></a><!--/noindex-->
			</p>
			<?php $counters = arun_get_theme_option('footer_counters'); ?>
			<div class="footer-counter"><?php echo wp_specialchars_decode( $counters, ENT_QUOTES ); ?></div>
		</div>
	</div>
    <?php endif; ?>
	<?php do_action( 'arun_after_footer_copyrights' ); ?>

</footer>
<?php do_action( 'arun_after_footer' ); ?>


</div> 
<!-- .wrapper -->

<a id="toTop">&#10148;</a>

<?php wp_footer(); ?>

</body>
</html>