<?php
/**
 * Logus Toolbox Portfolio.
 *
 * @since   0.0.0
 * @package Logus_Toolbox
 */

require_once dirname( __FILE__ ) . '/../vendor/cpt-core/CPT_Core.php';

/**
 * Logus Toolbox Portfolio post type class.
 *
 * @since 1.0.0
 *
 */
class LT_Portfolio extends CPT_Core {
	/**
	 * Parent plugin class.
	 *
	 * @var Logus_Toolbox
	 * @since  0.0.0
	 */
	protected $plugin = null;

	/**
	 * Constructor.
	 *
	 * Register Custom Post Types.
	 *
	 * @since  0.0.0
	 *
	 * @param  Logus_Toolbox $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		// Register this cpt.
		parent::__construct(
			array(
				esc_html__( 'Portfolio', 'logus-toolbox' ),
				esc_html__( 'Portfolios', 'logus-toolbox' ),
				'lt-portfolio',
			),
			array(
				'supports' => array(
					'title',
					'editor',
					'thumbnail',
				),
				'menu_icon' => 'dashicons-schedule', 
				'public'    => true,
				'has_archive' 	=> true,
				'rewrite' 	=> array(
						'slug' 	=> 'proyectos',
				),
			)
		);
	}


	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {
	}

	/**
	 * Registers admin columns to display. Hooked in via CPT_Core.
	 *
	 * @since  0.0.0
	 *
	 * @param  array $columns Array of registered column names/labels.
	 * @return array          Modified array.
	 */
	public function columns( $columns ) {
		$new_column = array();
		return array_merge( $new_column, $columns );
	}

	/**
	 * Handles admin column display. Hooked in via CPT_Core.
	 *
	 * @since  0.0.0
	 *
	 * @param array   $column   Column currently being rendered.
	 * @param integer $post_id  ID of post to display column for.
	 */
	public function columns_display( $column, $post_id ) {
		switch ( $column ) {
		}
	}
}
