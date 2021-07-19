<?php


/* ==========================================================================
 *  customizer settings init
 * ========================================================================== */
/**
 * @param $wp_customize WP_Customize_Manager
 */
function arun_customizer_init( $wp_customize ) {

	$transport = 'postMessage';


	/* --------------  S I T E   T I T L E   ---------------- */

	// rename title setting
	$wp_customize->get_section( 'title_tagline' )->title = __( 'Site title', 'arun' );
	$wp_customize->remove_control( 'display_header_text' );


	// ----

	$wp_customize->add_setting( 'display_logo_and_title',
		array(
			'default'           => 'image',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'display_logo_and_title_control',
		array(
			'settings' => 'display_logo_and_title',
			'label'    => __( "Display logo image with site title", 'arun' ),
			'section'  => 'title_tagline',
			'type'     => 'select',
			'choices'  => array(
				'image'  => __( 'Only image, without text', 'arun' ),
				'top'    => __( 'Picture above the text', 'arun' ),
				'left'   => __( 'Picture to the left of text', 'arun' ),
				'right'  => __( 'Picture to the right of text', 'arun' ),
				'bottom' => __( 'Picture under the text', 'arun' ),
			)
		)
	);


	// ----

	if ( class_exists( 'Arun_Group_Title_Control' ) ) {
		$wp_customize->add_setting( ARUN_OPTION_NAME . '[group_site_title]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key'
		) );
		$wp_customize->add_control( new Arun_Group_Title_Control( $wp_customize, 'arun_group_site_title', array(
			'label'    => __( 'Site title', 'arun' ),
			'section'  => 'title_tagline',
			'priority' => 10,
			'settings' => ARUN_OPTION_NAME . '[group_site_title]',
		) ) );
	}

	// change title setting transport
	$wp_customize->get_setting( 'blogname' )->transport = $transport;
	$wp_customize->get_control( 'blogname' )->priority  = 11;

	$wp_customize->get_setting( 'header_textcolor' )->transport = $transport;
	$wp_customize->get_control( 'header_textcolor' )->section   = 'title_tagline';
	$wp_customize->get_control( 'header_textcolor' )->priority  = 11;

	// ----

	if ( class_exists( 'Arun_Group_Title_Control' ) ) {
		$wp_customize->add_setting( ARUN_OPTION_NAME . '[group_description_title]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new Arun_Group_Title_Control( $wp_customize, 'arun_group_description_title', array(
			'label'    => __( 'Description', 'arun' ),
			'section'  => 'title_tagline',
			'priority' => 12,
			'settings' => ARUN_OPTION_NAME . '[group_description_title]',
		) ) );
	}

	$wp_customize->get_setting( 'blogdescription' )->transport = $transport;
	$wp_customize->get_control( 'blogdescription' )->section   = 'title_tagline';
	$wp_customize->get_control( 'blogdescription' )->priority  = 13;

	// ---

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[title_position]',
		array(
			'type'              => 'option',
			'default'           => 'left',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'title_position_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[title_position]',
			'label'    => __( "Title position", 'arun' ),
			'section'  => 'title_tagline',
			'type'     => 'select',
			'choices'  => array(
				'left'   => __( "Left", 'arun' ),
				'right'  => __( "Right", 'arun' ),
				'center' => __( "Center", 'arun' )
			),
			'priority' => 11,
		)
	);

	if ( class_exists( 'Arun_Group_Title_Control' ) ) {
		$wp_customize->add_setting( 'group_blog_h1_title', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new Arun_Group_Title_Control( $wp_customize, 'arun_group_blog_h1_title', array(
			'label'    => __( 'Blog home page H1', 'arun' ),
			'section'  => 'title_tagline',
			'priority' => 11,
			'settings' => 'group_blog_h1_title',
			'active_callback' => 'arun_show_on_home_posts'
		) ) );
	}

	// ---

	$wp_customize->add_setting(
		'home_h1_type',
		array(
//			'type'              => 'option',
			'default'           => 'sitetitle',
			'sanitize_callback' => 'sanitize_key',
//			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'home_h1_type_control',
		array(
			'settings'    => 'home_h1_type',
			'label'       => __( "Home H1 position", 'arun' ),
			'description' => __( "This option not affect to other pages, for home blog page only.", 'arun' ),
			'section'     => 'title_tagline',
			'type'        => 'radio',
			'choices'     => array(
				'sitetitle'   => __( "Site title in header", 'arun' ),
				'customtitle' => __( "My custom title before posts", 'arun' ),
			),
			'active_callback' => 'arun_show_on_home_posts',
			'priority'    => 11,
		)
	);

	// ---

	$wp_customize->add_setting(
		'custom_home_h1',
		array(
//			'type'              => 'option',
			'default'           => get_bloginfo( 'sitetitle' ),
			'sanitize_callback' => 'sanitize_text_field',
//			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'custom_home_h1_control',
		array(
			'settings'        => 'custom_home_h1',
			'label'           => __( "Custom blog home H1", 'arun' ),
			'section'         => 'title_tagline',
			'type'            => 'text',
			'active_callback' => 'arun_custom_home_h1',
//			'choices'  => array(
//				'sitetitle'   => __( "Site title", 'arun' ),
//				'customtitle'  => __( "Custom title", 'arun' ),
//			),
			'priority'        => 11,
		)
	);
	// ---

	// site descriptions
	$wp_customize->add_setting( ARUN_OPTION_NAME . '[showsitedesc]', array(
		'type'              => 'option',
		'default'           => '1',
		'sanitize_callback' => 'sanitize_key',
//		'sanitize_callback' => 'arun_sanitize_checkbox',
		'transport'         => $transport
	) );
	$wp_customize->add_control( 'showsitedesc_control',
		array(
			'label'    => __( 'Show site description', 'arun' ),
			'settings' => ARUN_OPTION_NAME . '[showsitedesc]',
			'section'  => 'title_tagline',
			'type'     => 'checkbox',
			'priority' => 21,
		)
	);

	// ----

	if ( class_exists( 'Arun_Group_Title_Control' ) ) {
		$wp_customize->add_setting( ARUN_OPTION_NAME . '[group_other_title]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new Arun_Group_Title_Control( $wp_customize, 'arun_group_other_title', array(
			'label'    => __( 'Other', 'arun' ),
			'section'  => 'title_tagline',
			'priority' => 22,
			'settings' => ARUN_OPTION_NAME . '[group_other_title]',
		) ) );
	}


	/*----------  H E A D E R    I M A G E   ----------*/

	$wp_customize->get_section( 'header_image' )->priority = 30;

	// ---

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[header_image_position]',
		array(
			'type'              => 'option',
			'default'           => 'background_no_repeat',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( 'header_image_position_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[header_image_position]',
			'label'    => __( "How to display image", 'arun' ),
			'section'  => 'header_image',
			'type'     => 'radio',
			'choices'  => array(
				'before'               => __( "Image before site title", 'arun' ),
				'after'                => __( "Image after site title", 'arun' ),
				'background_no_repeat' => __( "Background without repeat", 'arun' ),
				'background_repeat'    => __( "Background with full repeat", 'arun' ),
				'background_repeat_x'  => __( "Background with horizontal repeat", 'arun' ),
				'background_repeat_y'  => __( "Background with vertical repeat", 'arun' ),
			),
		)
	);

	// ---

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[fix_header_height]',
		array(
			'type'              => 'option',
			'default'           => 0,
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'fix_header_height_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[fix_header_height]',
			'label'    => __( "Fit minimal header height to image height", 'arun' ),
			'section'  => 'header_image',
			'type'     => 'checkbox',
		)
	);

	// ---

	/*----------  C O L O R S   &&   B A C K G R O U N D  ----------*/

	$wp_customize->get_section( 'background_image' )->title = __( 'Background', 'arun' );

	$wp_customize->get_control( 'background_color' )->priority = 30;
	$wp_customize->get_control( 'background_image' )->priority = 30;

	$wp_customize->get_control( 'background_color' )->section = 'background_image';
	$wp_customize->remove_section( 'colors' );


	/*----------  L A Y O U T   ----------*/

	// content custom section
	$wp_customize->add_section(
		'layout',
		array(
			'title'       => __( 'Design', 'arun' ),
			'priority'    => 80,
			'description' => __( 'Main theme options', 'arun' )
		)
	);

	// ----
	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[maincolor]',
		array(
			'type'              => 'option',
			'default'           => '#936',
			'priority'          => 10,
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		ARUN_OPTION_NAME . '[maincolor]',
		array(
			'label'       => __( "Main color", 'arun' ),
			'description' => __( "Choose main color", 'arun' ),
			'section'     => 'layout',
			'settings'    => ARUN_OPTION_NAME . '[maincolor]',
		)
	) );

	// ----

	if ( class_exists( 'Arun_Group_Title_Control' ) ) {
		$wp_customize->add_setting( ARUN_OPTION_NAME . '[group_layout_title]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new Arun_Group_Title_Control( $wp_customize, 'arun_group_layout_title', array(
			'label'       => __( 'Layout', 'arun' ),
			'description' => __( 'Set up layout for site pages', 'arun' ),
			'section'     => 'layout',
			'settings'    => ARUN_OPTION_NAME . '[group_layout_title]',
		) ) );
	}

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[show_sidebar]',
		array(
			'type'              => 'option',
			'default'           => 0,
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'show_sidebar_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[show_sidebar]',
			'label'    => __( "Show sidebar on mobile", 'arun' ),
			'section'  => 'layout',
			'type'     => 'checkbox',
		)
	);

	// ----

	$wp_customize->add_setting( 'show_mobile_thumb',
		array(
			'default'           => 0,
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'show_mobile_thumb_control',
		array(
			'settings' => 'show_mobile_thumb',
			'label'    => __( "Show featured images on mobile", 'arun' ),
			'section'  => 'layout',
			'type'     => 'checkbox',
		)
	);

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[layout_home]',
		array(
			'type'              => 'option',
			'default'           => 'rightbar',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_home_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[layout_home]',
			'label'    => __( "Layout on Home", 'arun' ),
			'section'  => 'layout',
//			'active_callback' => 'is_home',
			'type'     => 'select',
			'choices'  => array(
				'rightbar' => __( "Rightbar", 'arun' ),
				'leftbar'  => __( "Leftbar", 'arun' ),
				'full'     => __( "Fullwidth Content", 'arun' ),
				'center'   => __( "Centered Content", 'arun' )
			),
		)
	);

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[layout_post]',
		array(
			'type'              => 'option',
			'default'           => 'rightbar',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_post_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[layout_post]',
			'label'    => __( "Layout on Post", 'arun' ),
			'section'  => 'layout',
			'type'     => 'select',
			'choices'  => array(
				'rightbar' => __( "Rightbar", 'arun' ),
				'leftbar'  => __( "Leftbar", 'arun' ),
				'full'     => __( "Fullwidth Content", 'arun' ),
				'center'   => __( "Centered Content", 'arun' )
			),
		)
	);

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[layout_page]',
		array(
			'type'              => 'option',
			'default'           => 'center',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_page_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[layout_page]',
			'label'    => __( "Layout on Page", 'arun' ),
			'section'  => 'layout',
//			'active_callback' => 'arun_is_page',
			'type'     => 'select',
			'choices'  => array(
				'rightbar' => __( "Rightbar", 'arun' ),
				'leftbar'  => __( "Leftbar", 'arun' ),
				'full'     => __( "Fullwidth Content", 'arun' ),
				'center'   => __( "Centered Content", 'arun' )
			),
		)
	);


	// ----

	$wp_customize->add_setting(
		'layout_search',
		array(
			'type'              => 'option',
			'default'           => 'center',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_search_control',
		array(
			'settings' => 'layout_search',
			'label'    => __( "Layout on Search results page", 'arun' ),
			'section'  => 'layout',
			'type'     => 'select',
			'choices'  => array(
				'rightbar' => __( "Rightbar", 'arun' ),
				'leftbar'  => __( "Leftbar", 'arun' ),
				'full'     => __( "Fullwidth Content", 'arun' ),
				'center'   => __( "Centered Content", 'arun' )
			),
		)
	);



	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[layout_default]',
		array(
			'type'              => 'option',
			'default'           => 'rightbar',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_default_control',
		array(
			'settings'    => ARUN_OPTION_NAME . '[layout_default]',
			'label'       => __( "Global layout", 'arun' ),
			'description' => __( "It is used when individual page layout is not set", 'arun' ),
			'section'     => 'layout',
			'type'        => 'select',
			'choices'     => array(
				'rightbar' => __( "Rightbar", 'arun' ),
				'leftbar'  => __( "Leftbar", 'arun' ),
				'full'     => __( "Fullwidth Content", 'arun' ),
				'center'   => __( "Centered Content", 'arun' )
			),
		)
	);

	// ----

	if ( function_exists( 'is_woocommerce' ) ) {


		if ( class_exists( 'Arun_Group_Title_Control' ) ) {
			$wp_customize->add_setting( 'group_woolayout_title', array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_key',
			) );
			$wp_customize->add_control( new Arun_Group_Title_Control( $wp_customize, 'arun_group_woolayout_title', array(
				'label'       => __( 'WooCommerce Layout', 'arun' ),
//				'description' => __( 'Set up layout for site pages', 'arun' ),
				'section'     => 'layout',
				'settings'    => 'group_woolayout_title',
			) ) );
		}

		// ---
		$wp_customize->add_setting(
			'layout_shop',
			array(
//				'type'              => 'option',
				'default'           => 'full',
				'sanitize_callback' => 'sanitize_key',
				'transport'         => $transport
			)
		);
		$wp_customize->add_control( 'layout_shop_control',
			array(
				'settings' => 'layout_shop',
				'label'    => __( "Layout on WooCommerce Shop page", 'arun' ),
				'section'  => 'layout',
				'type'     => 'select',
				'choices'  => array(
					'rightbar' => __( "Rightbar", 'arun' ),
					'leftbar'  => __( "Leftbar", 'arun' ),
					'full'     => __( "Fullwidth Content", 'arun' ),
					'center'   => __( "Centered Content", 'arun' )
				),
			)
		);

		// ---
		$wp_customize->add_setting(
			'layout_product',
			array(
//				'type'              => 'option',
				'default'           => 'rightbar',
				'sanitize_callback' => 'sanitize_key',
				'transport'         => $transport
			)
		);
		$wp_customize->add_control( 'layout_product_control',
			array(
				'settings' => 'layout_product',
				'label'    => __( "Layout on WooCommerce Product page", 'arun' ),
				'section'  => 'layout',
				'type'     => 'select',
				'choices'  => array(
					'rightbar' => __( "Rightbar", 'arun' ),
					'leftbar'  => __( "Leftbar", 'arun' ),
					'full'     => __( "Fullwidth Content", 'arun' ),
					'center'   => __( "Centered Content", 'arun' )
				),
			)
		);

		// ---
		$wp_customize->add_setting(
			'layout_product_cat',
			array(
//				'type'              => 'option',
				'default'           => 'rightbar',
				'sanitize_callback' => 'sanitize_key',
				'transport'         => $transport
			)
		);
		$wp_customize->add_control( 'layout_product_cat_control',
			array(
				'settings' => 'layout_product_cat',
				'label'    => __( "Layout on WooCommerce Product's category", 'arun' ),
				'section'  => 'layout',
				'type'     => 'select',
				'choices'  => array(
					'rightbar' => __( "Rightbar", 'arun' ),
					'leftbar'  => __( "Leftbar", 'arun' ),
					'full'     => __( "Fullwidth Content", 'arun' ),
					'center'   => __( "Centered Content", 'arun' )
				),
			)
		);


	}



	// ----

	if ( class_exists( 'Arun_Group_Title_Control' ) ) {
		$wp_customize->add_setting( ARUN_OPTION_NAME . '[group_other_layout]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key'
		) );
		$wp_customize->add_control( new Arun_Group_Title_Control( $wp_customize, 'arun_group_other_layout', array(
			'label'    => __( 'Other options', 'arun' ),
			'section'  => 'layout',
			'settings' => ARUN_OPTION_NAME . '[group_other_layout]',
		) ) );
	}

	// ----

	$wp_customize->add_setting( 'postmeta_list',
		array(
			'default'           => 'date_category_comments',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control(
		new Arun_Sortable_Checkboxes_WPCC(
			$wp_customize,
			'fx_share_services', /* control id */
			array(
				'settings'    => 'postmeta_list',
				'label'       => __( "Post meta", 'arun' ),
				'description' => __( "What meta information to display for posts", 'arun' ),
				'section'     => 'layout',
				'choices'     => array(
					'date'     => __( "Publication date", 'arun' ),
					'author'   => __( "Post author", 'arun' ),
					'category' => __( "Post categories", 'arun' ),
					'comments' => __( "Comments count", 'arun' ),
					'tags'     => __( "Post tags", 'arun' )
				),
			)
		)
	);

	// --------------------------------------------------------------------------------------

	/**
	 * @since 1.1.7 two sections (social and markup) moved to panel Single post options
	 *
	 */
	$wp_customize->add_panel( 'arun_single_options',
		array(
			'title'       => __( "Post", 'arun' ),
			'description' => __( "Set your custom options to displaying posts", 'arun' ),
			'priority'    => 81
		)
	);

	// -------  S O C I A L ------------------------------------------------------------------

	$wp_customize->add_section( 'social',
		array(
			'title'       => __( 'Social', 'arun' ),
			'description' => __( 'Social buttons', 'arun' ),
			'priority'    => 81,
			'panel'       => 'arun_single_options',
		)
	);

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[add_social_meta]',
		array(
			'type'              => 'option',
			'default'           => '0',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'add_social_meta_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[add_social_meta]',
			'label'    => __( "Add Open Graph tags to &lt;head&gt;", 'arun' ),
			'section'  => 'social',
			'type'     => 'checkbox',
		)
	);


	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[social_share]',
		array(
			'type'              => 'option',
			'default'           => 'custom',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'refresh'//$transport
		)
	);
	$wp_customize->add_control( 'social_share_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[social_share]',
			'label'    => __( "Social share buttons after post", 'arun' ),
			'section'  => 'social',
			'type'     => 'select',
			'choices'  => array(
				'hide'   => __( "Hide", 'arun' ),
				'custom' => __( "Custom theme buttons", 'arun' ),
				'yandex' => __( "Yandex Buttons", 'arun' ),
			),
		)
	);


	// -----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[title_before_socshare]',
		array(
			'type'              => 'option',
			'default'           => '',
			'sanitize_callback' => 'arun_sanitize_text',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'title_before_socshare_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[title_before_socshare]',
			'label'    => __( "Custom text before share buttons", 'arun' ),
			'section'  => 'social',
			'type'     => 'text',
		)
	);


	// ----

	$wp_customize->add_setting( 'hide_socshare_on_pages',
		array(
//			'type'              => 'option',
			'default'           => 0,
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'refresh', //$transport
		)
	);
	$wp_customize->add_control( 'hide_socshare_on_pages_control',
		array(
			'settings' => 'hide_socshare_on_pages',
			'label'    => __( "Hide share buttons on static pages", 'arun' ),
			'section'  => 'social',
			'type'     => 'checkbox',
		)
	);


	// --------  S T U C T U R E D   D A T A   --------------------------------------------------

	$wp_customize->add_section(
		'arun_structured_data',
		array(
			'title'    => __( 'Structured Data', 'arun' ),
			'priority' => 82,
			'panel'    => 'arun_single_options',
		)
	);

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[schema_mark]',
		array(
			'type'              => 'option',
			'default'           => '1',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'schema_mark_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[schema_mark]',
			'label'    => __( "Enable Schema.org mark up according CreativeWork->Article and Comment", 'arun' ),
			'section'  => 'arun_structured_data',
			'type'     => 'checkbox',
		)
	);

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[markup_telephone]',
		array(
			'type'              => 'option',
			'default'           => '(000) 000-000-00',
			'sanitize_callback' => 'arun_sanitize_text',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'markup_telephone_control',
		array(
			'settings'    => ARUN_OPTION_NAME . '[markup_telephone]',
			'label'       => __( "Phone", 'arun' ),
			'description' => __( "use in https://schema.org/Organization", 'arun' ),
			'section'     => 'arun_structured_data',
			'type'        => 'text',
		)
	);

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[markup_adress]',
		array(
			'type'              => 'option',
			'default'           => __( 'Russia', 'arun' ),
			'sanitize_callback' => 'arun_sanitize_text',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'markup_adress_control',
		array(
			'settings'    => ARUN_OPTION_NAME . '[markup_adress]',
			'label'       => __( "Address", 'arun' ),
			'description' => __( "use in https://schema.org/Organization", 'arun' ),
			'section'     => 'arun_structured_data',
			'type'        => 'text',
		)
	);


	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[markup_logo]',
		array(
			'type'              => 'option',
			'default'           => get_template_directory_uri() . '/img/logo.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'markup_logo_control',
		array(
			'settings'    => ARUN_OPTION_NAME . '[markup_logo]',
			'label'       => __( 'Publisher logo', 'arun' ),
			'description' => __( "use in https://schema.org/Organization", 'arun' ),
			'section'     => 'arun_structured_data',
		)
	) );


	// --------  Advertisement   C O D E S  --------------------------------------------------

	$wp_customize->add_section( 'arun_advertisement',
		array(
			'title'       => __( 'Advertisement', 'arun' ),
			'description' => __( 'Setup advertisement before and after post content', 'arun' ),
			'panel'       => 'arun_single_options',
		)
	);

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[before_content]',
		array(
			'type'              => 'option',
			'default'           => "<!-- " . __( "Code before single post content", "arun" ) . " -->",
			'sanitize_callback' => 'arun_sanitize_html',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'before_content_control',
		array(
			'settings'    => ARUN_OPTION_NAME . '[before_content]',
			'label'       => __( "Before content", 'arun' ),
			'description' => __( "Code before single post content", 'arun' ),
			'section'     => 'arun_advertisement',
			'type'        => 'textarea',
		)
	);

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[after_content]',
		array(
			'type'              => 'option',
			'default'           => "<!-- " . __( "Code after single post content", "arun" ) . " -->",
			'sanitize_callback' => 'arun_sanitize_html',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'after_content_control',
		array(
			'settings'    => ARUN_OPTION_NAME . '[after_content]',
			'label'       => __( "After content", 'arun' ),
			'description' => __( "Code after single post content", 'arun' ),
			'section'     => 'arun_advertisement',
			'type'        => 'textarea',
		)
	);


	// --------  C U S T O M   C O D E S  --------------------------------------------------

	$wp_customize->add_section( 'arun_custom_code',
		array(
			'title'       => __( 'Custom codes', 'arun' ),
			'description' => __( 'It helps you to setup custom scripts and styles', 'arun' ),
			'priority'    => 91,
		)
	);


	// ----

	if ( class_exists( 'Arun_Group_Title_Control' ) ) {
		$wp_customize->add_setting( ARUN_OPTION_NAME . '[group_global_code]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new Arun_Group_Title_Control( $wp_customize, 'arun_group_global_code', array(
			'label'    => __( 'Global settings', 'arun' ),
			'section'  => 'arun_custom_code',
			'settings' => ARUN_OPTION_NAME . '[group_global_code]',
		) ) );
	}

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[head_scripts]',
		array(
			'type'              => 'option',
			'default'           => '<!-- header html from theme option -->',
			'sanitize_callback' => 'arun_sanitize_html',
			'transport'         => 'refresh'//$transport
		)
	);
	$wp_customize->add_control( 'head_scripts_control',
		array(
			'settings'    => ARUN_OPTION_NAME . '[head_scripts]',
			'label'       => __( "Scripts in header", 'arun' ),
			'description' => __( "HTML code in &lt;head&gt; tag", 'arun' ),
			'section'     => 'arun_custom_code',
			'type'        => 'textarea',
		)
	);

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[footer_scripts]',
		array(
			'type'              => 'option',
			'default'           => '<!-- footer html from theme option -->',
			'sanitize_callback' => 'arun_sanitize_html',
			'transport'         => 'refresh'//$transport
		)
	);
	$wp_customize->add_control( 'footer_scripts_control',
		array(
			'settings'    => ARUN_OPTION_NAME . '[footer_scripts]',
			'label'       => __( "Scripts in site footer", 'arun' ),
			'description' => __( "HTML code before &lt;/body&gt; tag", 'arun' ),
			'section'     => 'arun_custom_code',
			'type'        => 'textarea',
		)
	);


	if ( class_exists( 'Arun_Group_Title_Control' ) ) {
		$wp_customize->add_setting( ARUN_OPTION_NAME . '[group_custom_css_code]', array(
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new Arun_Group_Title_Control( $wp_customize, 'arun_group_custom_css_code', array(
			'label'    => __( 'Custom CSS', 'arun' ),
			'section'  => 'arun_custom_code',
			'settings' => ARUN_OPTION_NAME . '[group_custom_css_code]',
		) ) );
	}

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[custom_styles]',
		array(
			'type'              => 'option',
			'default'           => '',
			'sanitize_callback' => 'arun_sanitize_textarea',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'custom_styles_control',
		array(
			'settings'    => ARUN_OPTION_NAME . '[custom_styles]',
			'label'       => __( "Custom styles", 'arun' ),
			'description' => __( "Add your custom CSS styles", 'arun' ),
			'section'     => 'arun_custom_code',
			'type'        => 'textarea',
		)
	);


	// ----------  F O O T E R  ----------


	$wp_customize->add_section(
		'arun_footer_text',
		array(
			'title'       => __( 'Footer', 'arun' ),
			'description' => __( 'Customize footer', 'arun' ),
			'priority'    => 92,
		)
	);

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[copyright_text]',
		array(
			'type'              => 'option',
			'default'           => __( 'All rights reserved', 'arun' ),
			'sanitize_callback' => 'arun_sanitize_text',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'copyright_text_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[copyright_text]',
			'label'    => __( "Copyright text", 'arun' ),
			'section'  => 'arun_footer_text',
			'type'     => 'text',
		)
	);

	// ----

	$wp_customize->add_setting(
		ARUN_OPTION_NAME . '[footer_counters]',
		array(
			'type'              => 'option',
			'default'           => '',
			'sanitize_callback' => 'arun_sanitize_html',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'footer_counters_control',
		array(
			'settings' => ARUN_OPTION_NAME . '[footer_counters]',
			'label'    => __( "Counters code", 'arun' ),
			'section'  => 'arun_footer_text',
			'type'     => 'textarea',
		)
	);


	// ----------  A D D I T I O N A L   C U S T O M   D E S I G N  ----------


	$wp_customize->add_section(
		'arun_additional_design',
		array(
			'title'       => __( 'Design skins for theme ARUN', 'arun' ),
			'description' => __( 'Get child theme with additional design!', 'arun' ),
			'priority'    => 2,
		)
	);

	// ----

	//
	$wp_customize->add_setting( 'arunchild_callmetomato', array(
		'type'              => 'option',
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'arun-callmetomato/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2017/01/callmetomato-mini.png" alt="callmetomato"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arunchild_magicsky',
		array( 'label' => 'CallMeTomato', 'section' => 'arun_additional_design', 'settings' => 'arunchild_magicsky', )
	) );


	// ----

	//
	$wp_customize->add_setting( 'arunchild_ukrainiansoul', array(
		'type'              => 'option',
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'arun-ukrainiansoul/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2017/01/ukrainiansoul-mini.png" alt="ukrainiansoul"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arunchild_ukrainiansoul',
		array( 'label'    => 'UkrainianSoul',
		       'section'  => 'arun_additional_design',
		       'settings' => 'arunchild_ukrainiansoul',
		)
	) );


	// ----

	//
	$wp_customize->add_setting( 'arunchild_businesscity', array(
		'type'              => 'option',
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'arun-businesscity/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2017/01/businesscity-mini.png" alt="businesscity"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arunchild_businesscity',
		array( 'label'    => 'BusinessCity',
		       'section'  => 'arun_additional_design',
		       'settings' => 'arunchild_businesscity',
		)
	) );


	// ----

	//
	$wp_customize->add_setting( 'arunchild_magicsky', array(
		'type'              => 'option',
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'arun-magicsky/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2017/01/magicsky-mini.png" alt="magicsky"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arunchild_magicsky',
		array( 'label' => 'MagicSky', 'section' => 'arun_additional_design', 'settings' => 'arunchild_magicsky', )
	) );


	// ----

	//
	$wp_customize->add_setting( 'arunchild_repairservice', array(
		'type'              => 'option',
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'arun-repairservice/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2017/01/repairservice-mini.png" alt="repairservice"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arunchild_repairservice',
		array( 'label'    => 'RepairService',
		       'section'  => 'arun_additional_design',
		       'settings' => 'arunchild_repairservice',
		)
	) );


	// ----

	//
	$wp_customize->add_setting( 'arunchild_theelegance', array(
		'type'              => 'option',
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'arun-theelegance/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2017/01/theelegance-mini.png" alt="theelegance"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arunchild_theelegance',
		array( 'label'    => 'TheElegance',
		       'section'  => 'arun_additional_design',
		       'settings' => 'arunchild_theelegance',
		)
	) );


	// ----

	//
	$wp_customize->add_setting( 'arunchild_lobelia', array(
		'type'              => 'option',
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'arun-lobelia/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2016/08/lobelia-mini.png" alt="lobelia"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arunchild_lobelia',
		array( 'label' => 'Lobelia', 'section' => 'arun_additional_design', 'settings' => 'arunchild_lobelia', )
	) );

	//
	$wp_customize->add_setting( 'arunchild_peachtheme', array(
		'type'              => 'option',
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'arun-peachtheme/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2016/08/peachtheme-mini.png" alt="peachtheme"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arunchild_peachtheme',
		array( 'label' => 'PeachTheme', 'section' => 'arun_additional_design', 'settings' => 'arunchild_peachtheme', )
	) );

	//
	$wp_customize->add_setting( 'arunchild_westcoasts', array(
		'type'              => 'option',
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'arun-westcoasts/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2016/08/westcoasts-mini.png" alt="westcoasts"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arunchild_westcoasts',
		array( 'label' => 'WestCoasts', 'section' => 'arun_additional_design', 'settings' => 'arunchild_westcoasts', )
	) );

	//
	$wp_customize->add_setting( 'arunchild_travelblog', array(
		'type'              => 'option',
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'arun-travelblog/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2016/08/travelblog-mini.png" alt="travelblog"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arunchild_travelblog',
		array( 'label' => 'TravelBlog', 'section' => 'arun_additional_design', 'settings' => 'arunchild_travelblog', )
	) );

	//
	$wp_customize->add_setting( 'arunchild_yellowdreams', array(
		'type'              => 'option',
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'arun-yellowdreams/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2016/08/yellowdreams-mini.png" alt="yellowdreams"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arunchild_yellowdreams',
		array(
			'label'    => 'YellowDreams',
			'section'  => 'arun_additional_design',
			'settings' => 'arunchild_yellowdreams',
		)
	) );

	//
	$wp_customize->add_setting( 'arunchild_luminous', array(
		'type'              => 'option',
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'arun-luminous/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2016/08/luminous-mini.png" alt="luminous"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arunchild_luminous',
		array( 'label' => 'Luminous', 'section' => 'arun_additional_design', 'settings' => 'arunchild_luminous', )
	) );


	// ----------  A D D I T I O N A L   C U S T O M   D E S I G N  ----------


	$wp_customize->add_section( 'arun_other_themes',
		array(
			'title'       => __( 'WP Puzzle Themes', 'arun' ),
			'description' => __( 'Choose great premium themes by WP Puzzle Shop!', 'arun' ),
			'priority'    => 1,
		)
	);

	//
	$wp_customize->add_setting( 'arun_other_simplepuzzle', array(
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'simple-puzzle/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2016/09/simplepuzzle-mini.png" alt="simplepuzzle"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arun_other_simplepuzzle',
		array( 'label' => 'SimplePuzzle', 'section' => 'arun_other_themes', 'settings' => 'arun_other_simplepuzzle', )
	) );

	//
	$wp_customize->add_setting( 'arun_other_fashionista', array(
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'fashionista/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2016/09/fashionista-mini.png" alt="fashionista"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arun_other_fashionista',
		array( 'label' => 'Fashionista', 'section' => 'arun_other_themes', 'settings' => 'arun_other_fashionista', )
	) );

	//
	$wp_customize->add_setting( 'arun_other_sunsetcafe', array(
		'sanitize_callback' => 'arun_sanitize_html',
		'default'           => '<a href="' . ARUN_THEME_URI . 'sunsetcafe/" target="_blank"><img src="' . ARUN_THEME_URI . 'wp-content/uploads/2016/09/sunsetcafe-mini.png" alt="sunsetcafe"></a>',
	) );
	$wp_customize->add_control( new Arun_Child_Design_WPCC( $wp_customize, 'arun_other_sunsetcafe',
		array( 'label' => 'SunsetCafe', 'section' => 'arun_other_themes', 'settings' => 'arun_other_sunsetcafe', )
	) );

}

add_action( 'customize_register', 'arun_customizer_init' );
