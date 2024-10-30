<?php
/**
 * Logus Toolbox Brands.
 *
 * @since   0.0.0
 * @package Logus_Toolbox
 */

require_once dirname( __FILE__ ) . '/../vendor/cpt-core/CPT_Core.php';

/**
 * Logus Toolbox Brands post type class.
 *
 * @since 0.0.0
 */
class LT_Brands extends CPT_Core {
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
				esc_html__( 'Brand', 'logus-toolbox' ),
				esc_html__( 'Brands', 'logus-toolbox' ),
				'lt-brands',
			),
			array(
				'supports'  => array(
					'title',
					'editor',
					'thumbnail',
				),
				'menu_icon' => 'dashicons-awards',
				'public'    => true,
				'rewrite'   => array(
					'slug' => 'marcas',
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

		// add metabox.
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );

		// save_post metadata.
		add_action( 'save_post', array( $this, 'save_postdata' ) );
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
	 *
	public function columns_display( $column, $post_id ) {
		switch ( $column ) {
		}
	} */


	/**
	 * Add brands metabox
	 *
	 * @since  1.0.0
	 */
	public function add_meta_box() {

		add_meta_box(
			'logus_brands_metabox',
			__( 'Logus - Help and Tools', 'logus-toolbox' ),
			array( $this, 'render_meta_box_content' ),
			$this->post_type,
			'advanced',
			'high'
		);
	}

	/**
	 * Render meta box content
	 *
	 * @since  0.0.0
	 */
	public function render_meta_box_content( $post ) {

		wp_nonce_field( 'logus-toolbox-brands', 'logus-toolbox-brands-nonce' );

		$link = get_post_meta( $post->ID, 'logus-brand-link', true );

		?>

		<?php /* poster */ ?>
		<p>
			<strong><?php esc_html_e( 'Featured Image', 'logus-toolbox' ); ?></strong>
		</p>
		<p>			
			<span style="text-decoration: none" class="dashicons dashicons-editor-help"></span>
			<?php esc_html_e( 'To set an logo or brand image, use the "Featured Image" picker.', 'logus-toolbox' ); ?>
		</p>
		

		<?php /* brands-link */ ?>
		<p>
			<strong><label for="logus-brand-link"><?php esc_html_e( 'Link', 'logus-toolbox' ); ?></label></strong>
		</p>
		<p class="description">
			<?php esc_html_e( 'Link to company page.', 'logus-toolbox' ); ?>
		</p>
		<p>			
			<input type="text" id="logus-brand-link" name="logus-brand-link" value="<?php echo esc_url( $link ); ?>">
		</p>

		<?php /* credits */ ?>
		<hr>
		<p>
			<em>
				<a target="_blank" href="https://superadmin.es/logus">Log&uuml;s Theme</a>&nbsp;<?php esc_html_e( 'by', 'logus-toolbox' ); ?><a target="_blank" href="https://superadmin.es"> SuperAdmin</a>
			</em>
		</p>
		<?php
	}


	/**
	 * Save meta box changes
	 *
	 * @since  0.0.0
	 */
	public function save_postdata( $post_id ) {

		if ( ! isset( $_POST['logus-toolbox-brands-nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['logus-toolbox-brands-nonce'];

		if ( ! wp_verify_nonce( $nonce, 'logus-toolbox-brands' ) ) {
			return $post_id;
		}

		if ( $this->post_type != $_POST['post_type'] ) {
			return $post_id;
		}

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}

		$link = isset( $_POST['logus-brand-link'] ) ? esc_url_raw( $_POST['logus-brand-link'] ) : false;
		update_post_meta( $post_id, 'logus-brand-link', $link );
	}
}
