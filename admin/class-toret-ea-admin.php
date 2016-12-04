<?php
/**
 * @package   Toret Email Attachments
 * @author    Vladislav Musílek
 * @license   GPL-2.0+
 * @link      http://toret.cz
 * @copyright 2016 Toret.cz
 */
 
class Toret_EA_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		$plugin = Toret_EA::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

    	/**
    	 *  Output fix
    	 */              
    	add_action('admin_init', array( $this, 'output_buffer' ) );

    	add_action('woocommerce_product_write_panel_tabs', array( $this, 'email_attachments_tab' ) );
    	add_action('woocommerce_product_write_panels', array( $this, 'woo_add_email_attachments_tab' ) );
    	add_action('woocommerce_process_product_meta', array( $this, 'woo_add_email_attachments_tab_fields_save' ) );
    
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {
		if( !empty( $_GET['page'] ) && $_GET['page'] == 'toret-email-attachments' ){
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Toret_EA::VERSION );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		$display = false;
		if( !empty( $_GET['page'] ) && $_GET['page'] == 'toret-email-attachments' ){ $display = true; }
		if( !empty( $_GET['post'] ) && get_post_type( $_GET['post'] ) == 'product' ){ $display = true; }

		if( $display == true ){
			wp_enqueue_media();
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), Toret_EA::VERSION );
		}
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

	if (!defined('TORETMENU')) {
     
     	add_menu_page(
			__( 'Toret plugins', $this->plugin_slug ),
			__( 'Toret plugins', $this->plugin_slug ),
			'manage_options',
			'toret-plugins',
			array( $this, 'display_toret_plugins_admin_page' )
		);
     
     	define( 'TORETMENU', true );
  	}
  
  
  	
	add_submenu_page(
			'toret-plugins',
      		__( 'Email attachments', $this->plugin_slug ),
			__( 'Email attachments', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

  /**
	 * Render the settings page for all plugins
	 *
	 * @since    1.0.0
	 */
	public function display_toret_plugins_admin_page() {
		include_once( 'views/toret.php' );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	 
  
  	/**
	 * Headers allready sent fix
	 * 
	 * @since    1.0.0        
	 */
	public function output_buffer() {
		ob_start();
	}



	/**
	 * Save options
	 * 
	 * @since    1.0.0        
	 */
	public function save_options() {
		if ( ! isset( $_POST['_wpnonce'] ) )
				return;
		if ( ! wp_verify_nonce( $_POST['_wpnonce'], $this->plugin_slug . '-admin' ) )
				return;

			$setting = array();
  			if(!empty($_POST['email-attachment-first-cs'])){
    			$setting['email-attachment-first-cs'] = sanitize_text_field($_POST['email-attachment-first-cs']);
  			}
  			if(!empty($_POST['email-attachment-second-cs'])){
    			$setting['email-attachment-second-cs'] = sanitize_text_field($_POST['email-attachment-second-cs']);
  			}
  			if(!empty($_POST['email-attachment-first-sk'])){
    			$setting['email-attachment-first-sk'] = sanitize_text_field($_POST['email-attachment-first-sk']);
  			}
  			if(!empty($_POST['email-attachment-second-sk'])){
    			$setting['email-attachment-second-sk'] = sanitize_text_field($_POST['email-attachment-second-sk']);
  			}
  			if(!empty($_POST['email-attachment-first-en'])){
    			$setting['email-attachment-first-en'] = sanitize_text_field($_POST['email-attachment-first-en']);
  			}
  			if(!empty($_POST['email-attachment-second-en'])){
    			$setting['email-attachment-second-en'] = sanitize_text_field($_POST['email-attachment-second-en']);
  			}
  			
    
  		update_option('toret-ea-option', $setting);

	}


	/**
  	 * Custom Tabs for product 
	 *
  	 */
  	public function email_attachments_tab() {
  		?>
    		<li class="info_tabea"><a href="#info_tab_ea"><?php _e('Přílohy k emailu', $this->plugin_slug ); ?></a></li>
  		<?php
  	}    

	/**
  	 * Custom Tabs html 
	 *
  	 */ 
	public function woo_add_email_attachments_tab() {
    	$html = '<div id="info_tab_ea" class="panel woocommerce_options_panel">';
    	global $post;
    	$fields = array(
    		'product-email-attachment-cs' => __('Příloha pro český jazyk', $this->plugin_slug ),
    		'product-email-attachment-sk' => __('Příloha pro slovenský jazyk', $this->plugin_slug ),
    		'product-email-attachment-en' => __('Příloha pro ostatní jazyky (EN)', $this->plugin_slug )
    	);

    	$html .= '<div style="width:100%">';
   		foreach( $fields as $key => $label ){

   			$value = get_post_meta( $post->ID, $key, true );
   			if( empty( $value ) ){ $value = ''; }

   			$html .= '<p class="form-field">';
          	$html .= '<label for="'.$key.'">'.$label.'</label>';
          	$html .= '<input type="text" class="'.$key.'" id="'.$key.'" data-id="'.$key.'" name="'.$key.'" value="' . esc_attr( $value ) . '" />';
      		$html .= '<input type="button" class="btn btn-info btn-mini insert-media" value="'.__('Nahrej přílohu',$this->plugin_slug).'" style="width:auto;margin-left:10px;" />';     
      		$html .= '</p>';
      	}  
      	$html .= '</div>';  

	   
    	$html .= '</div>';
    	
    	echo $html;
  	}  
	
	/**
  	 * Save product data
  	 *
  	 * @since    1.0.0   
  	 */        
  	public function woo_add_email_attachments_tab_fields_save( $post_id ){
	
  		$fields = array(
        	'product-email-attachment-cs',
        	'product-email-attachment-sk',
        	'product-email-attachment-en'
  		);
  
  
    	foreach($fields as $item){
          	if( !empty( $_POST[$item] ) ){
		        update_post_meta( $post_id, $item, esc_attr( $_POST[$item] ) );        
          	}else{
            	delete_post_meta( $post_id, $item );
          	} 
   
    	}  
    }  

}
