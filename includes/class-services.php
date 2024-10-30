<?php
/**
 * Logus Toolbox Services.
 *
 * @since   0.0.0
 * @package Logus_Toolbox
 */

require_once dirname( __FILE__ ) . '/../vendor/cpt-core/CPT_Core.php';

/**
 * Logus Toolbox Services post type class.
 *
 * @since 0.0.0
 */
class LT_Services extends CPT_Core {
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
				esc_html__( 'Service', 'logus-toolbox' ),
				esc_html__( 'Services', 'logus-toolbox' ),
				'lt-services',
			),
			array(
				'supports'  => array(
					'title',
					'editor',
					'thumbnail',
				),
				'menu_icon' => 'dashicons-clipboard',
				'public'    => true,
				'rewrite'   => array(
					'slug' => 'servicios',
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
	}*/


	/**
	 * Add services metabox
	 *
	 * @since  1.0.0
	 */
	public function add_meta_box() {

		add_meta_box(
			'logus_services_metabox',
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
	 * @since  1.0.0
	 */
	public function render_meta_box_content( $post ) {

		wp_nonce_field( 'logus-toolbox-services', 'logus-toolbox-services-nonce' );

		$icon = get_post_meta( $post->ID, 'logus-service-icon', true );
		$link = get_post_meta( $post->ID, 'logus-service-link', true );

		?>

		<?php /* poster */ ?>
		<p>
			<strong><?php esc_html_e( 'Featured Image', 'logus-toolbox' ); ?></strong>
		</p>
		<p>			
			<span style="text-decoration: none" class="dashicons dashicons-editor-help"></span>			
			<?php esc_html_e( 'To set a image to this service page, use the "Featured Image" picker.', 'logus-toolbox' ); ?>
		</p>

		
		<?php /* service-icon */ ?>
		<!--
		<p>			
			<strong><label for="logus-service-icon"><?php esc_html_e( 'Icon', 'logus-toolbox' ); ?></label></strong>
		</p>
		<p class="description">
			<?php esc_html_e( 'Set a foundation icon to this service page.', 'logus-toolbox' ); ?>
		</p>
		<p>			
			<input type="text" id="logus-service-icon" name="logus-service-icon" value="<?php echo esc_html( $icon ); ?>">
		</p>



		<?php /* service-link */ ?>
		<p>
			<strong><label for="logus-service-link"><?php esc_html_e( 'Link', 'logus-toolbox' ); ?></label></strong>
		</p>
		<p class="description">			
			<?php esc_html_e( 'Default is set to blank.', 'logus-toolbox' ); ?>
		</p>
		<p>			
			<input type="text" id="logus-service-link" name="logus-service-link" value="<?php echo esc_url( $link ); ?>">
		</p>

		<?php /* credits */ ?>
		<hr>
		<p>
			<em>
				<a target="_blank" href="https://superadmin.es/logus">Log&uuml;s Theme</a>&nbsp;<?php esc_html_e( 'by', 'logus-toolbox' ); ?><a target="_blank" href="https://superadmin.es"> SuperAdmin</a>
			</em>
		</p> -->
		<?php
	}


	/**
	 * Save meta box changes
	 *
	 * @since  0.0.0
	 */
	public function save_postdata( $post_id ) {

		if ( ! isset( $_POST['logus-toolbox-services-nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['logus-toolbox-services-nonce'];

		if ( ! wp_verify_nonce( $nonce, 'logus-toolbox-services' ) ) {
			return $post_id;
		}

		if ( $this->post_type != $_POST['post_type'] ) {
			return $post_id;
		}

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}

		$icon = isset( $_POST['logus-service-icon'] ) ? sanitize_text_field( wp_unslash( $_POST['logus-service-icon'] ) ) : false;
		$link = isset( $_POST['logus-service-link'] ) ? esc_url_raw( wp_unslash( $_POST['logus-service-link'] ) ) : false;

		update_post_meta( $post_id, 'logus-service-link', $link );
		update_post_meta( $post_id, 'logus-service-icon', $icon );
	}

}
