<?php
/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CUSTO Theme Options
 * @version 1.0.0
 */
class Custo {

	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'custo_options';

	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'custo_option_metabox';

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {
		// Set our title
		$this->title = __( 'Site Options', 'custo' );
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
	}


	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_theme_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
		// Include CMB CSS in the head to avoid FOUT
		add_action( "admin_print_styles-{$this->options_page}", array( 'cmb2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CUSTO
	 * @since  0.1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap custo-options-page <?php echo $this->key; ?>">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

			<?php
	            $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
	        ?>
         
	        <h2 class="nav-tab-wrapper">
	            <a href="?page=custo_options&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General Options</a>
	            <a href="?page=custo_options&tab=frontpage" class="nav-tab <?php echo $active_tab == 'frontpage' ? 'nav-tab-active' : ''; ?>">Frontpage Options</a>
	            <a href="?page=custo_options&tab=contact" class="nav-tab <?php echo $active_tab == 'contact' ? 'nav-tab-active' : ''; ?>">Contact Options</a>
	            <a href="?page=custo_options&tab=footer" class="nav-tab <?php echo $active_tab == 'footer' ? 'nav-tab-active' : ''; ?>">Footer Options</a>
	        </h2>
			<?php
			if( $active_tab == 'general' ) {
				 echo '<h3>General Settings</h3>';
				 cmb2_metabox_form( 'general_option_metabox', $this->key, array( 'cmb_styles' => true ) );
			} 

			elseif( $active_tab == 'frontpage' ) {
				 echo '<h3>Frontpage Settings</h3>';
				 cmb2_metabox_form( 'frontpage_option_metabox', $this->key, array( 'cmb_styles' => true ) );
			} 

			elseif( $active_tab == 'contact' ) {
				 echo '<h3>Contact Us Settings</h3>';
				 cmb2_metabox_form( 'contact_option_metabox', $this->key, array( 'cmb_styles' => true ) );
			} 

			else {
				echo '<h3>Footer Settings</h3>';
				cmb2_metabox_form( 'footer_option_metabox', $this->key, array( 'cmb_styles' => true ) );
			} ?>
		</div>
		<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  1.0.0
	 */
	function add_options_page_metabox() {

		/************************
		* General options
		*************************/
		$cmb_gm = new_cmb2_box( array(
			'title'   => __( 'General Setting', 'custo' ),
			'id'      => 'general_option_metabox',
			'hookup'  => false,
			'show_names' => true,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		$cmb_gm->add_field( array(
			'name' => __( 'Logo', 'custo' ),
			'desc' => __( 'Upload an image or enter a URL.', 'custo' ),
			'id'   => 'logo',
			'type' => 'file',
		) );

		$cmb_gm->add_field( array(
			'name' => __( 'Favicon', 'custo' ),
			'desc' => __( 'Upload an image or enter a URL.', 'custo' ),
			'id'   => 'favicon',
			'type' => 'file',
		) );


		$cmb_gm->add_field( array(
			'name'    => __( 'Background Color', 'custo' ),
			'desc'    => __( 'Select theme bg color', 'custo' ),
			'id'      => 'bg_color',
			'type'    => 'colorpicker',
			'default' => '#ffffff',
		) );

		$cmb_gm->add_field( array(
			'name'    => __( 'Content Background Color', 'custo' ),
			'desc'    => __( 'Select Content Background Color', 'custo' ),
			'id'      => 'content_bg_color',
			'type'    => 'colorpicker',
			'default' => '#ffffff',
		) );

		$cmb_gm->add_field( array(
			'name' => __( 'Headquarters', 'custo' ),
			'desc' => __( 'Enter Headquarters address', 'custo' ),
			'id'   => 'headquarter_address',
			'type'    => 'wysiwyg',
			'options' => array( 'textarea_rows' => 5, ),
		) );


		/************************
		* Front page options
		*************************/
		$cmb_home = new_cmb2_box( array(
			'title'   => __( 'Front page Setting', 'custo' ),
			'id'      => 'frontpage_option_metabox',
			'hookup'  => false,
			'show_names' => true,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		$cmb_home->add_field( array(
			'name' => __( 'Custom Agency URL', 'custo' ),
			'desc' => __( 'Enter Custom Agency URL', 'custo' ),
			'id'   => 'agency_url',
			'type' => 'text',
		) );

		$cmb_home->add_field( array(
			'name' => __( 'Custom Labs URL', 'custo' ),
			'desc' => __( 'Enter Custom Labs URL', 'custo' ),
			'id'   => 'labs_url',
			'type' => 'text',
		) );

		$cmb_home->add_field( array(
			'name' => __( 'Custom Services URL', 'custo' ),
			'desc' => __( 'Enter Custom Services URL', 'custo' ),
			'id'   => 'service_url',
			'type' => 'text',
		) );

		$cmb_home->add_field( array(
			'name' => __( 'Clients Served', 'custo' ),
			'desc' => __( 'Enter Clients Served Number', 'custo' ),
			'id'   => 'client_serve_no',
			'type' => 'text_small',
		) );

		$cmb_home->add_field( array(
			'name' => __( 'Active Campaigns', 'custo' ),
			'desc' => __( 'Enter Active Campaigns Number', 'custo' ),
			'id'   => 'active_campaign_no',
			'type' => 'text_small',
		) );

		$cmb_home->add_field( array(
			'name' => __( 'Employees', 'custo' ),
			'desc' => __( 'Enter Employees Number', 'custo' ),
			'id'   => 'employee_no',
			'type' => 'text_small',
		) );

		$cmb_home->add_field( array(
			'name' => __( 'Industries Explored', 'custo' ),
			'desc' => __( 'Enter Industries Explored Number', 'custo' ),
			'id'   => 'industry_explore_no',
			'type' => 'text_small',
		) );



		/**************************
		*Contact us options
		***************************/
		$cmb_contact = new_cmb2_box( array(
			'title'   => __( 'Contact Us Setting', 'custo' ),
			'id'      => 'contact_option_metabox',
			'hookup'  => false,
			'show_names' => true,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		$cmb_contact->add_field( array(
			'name' => __( 'Latitude', 'custo' ),
			'desc' => __( 'Enter Latitude for google map', 'custo' ),
			'id'   => 'latitude',
			'type' => 'text_small',

		) );

		$cmb_contact->add_field( array(
			'name' => __( 'Longitude', 'custo' ),
			'desc' => __( 'Enter Longitude for google map', 'custo' ),
			'id'   => 'longitude',
			'type' => 'text_small',

		) );

		$cmb_contact->add_field( array(
			'name' => __( 'Marker Address', 'custo' ),
			'desc' => __( 'Enter Marker Address', 'custo' ),
			'id'   => 'marker_address',
			'type' => 'text',

		) );

		$cmb_contact->add_field( array(
			'name' => __( 'Headquarters', 'custo' ),
			'desc' => __( 'Enter Headquarters address', 'custo' ),
			'id'   => 'contact_address',
			'type'    => 'wysiwyg',
			'options' => array( 'textarea_rows' => 5, ),
		) );



		
		/**************************
		*Footer options
		***************************/
		$cmb_footer = new_cmb2_box( array(
			'title'   => __( 'Footer Setting', 'custo' ),
			'id'      => 'footer_option_metabox',
			'hookup'  => false,
			'show_names' => true,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		$cmb_footer->add_field( array(
			'name' => __( 'Copyright Text', 'custo' ),
			'desc' => __( 'Enter Copyright text', 'custo' ),
			'id'   => 'copyright',
			'type' => 'text',
			'default' => '© Blueliner Marketing Agency',
		) );


	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  1.0.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}

		throw new Exception( 'Invalid property: ' . $field );
	}

}
