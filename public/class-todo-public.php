<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/Pacjonek
 * @since      1.0.0
 *
 * @package    Todo
 * @subpackage Todo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Todo
 * @subpackage Todo/public
 * @author     Patryk Rajba <pacjonek@gmail.com>
 */
class Todo_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Todo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Todo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/todo-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Todo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Todo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/todo-init.js', array( 'jquery' ), $this->version, false );
		$admin_ajax_url = admin_url( 'admin-ajax.php', is_ssl() ? 'https://' : 'http://' );  
		wp_localize_script( $this->plugin_name, 'ajaxOptions', array('adminAjaxUrl' => $admin_ajax_url) );  
	}

	public function register_todo_shortcode(){
		add_shortcode( 'todo', array($this, 'todo_logged_in_shortcode'));
	}

	public function todo_logged_in_shortcode(){
		if(is_user_logged_in() && !is_admin()){
			$this->show_todo();
		}
	}
	public function show_todo(){
		add_action( 'wp_enqueue_scripts', $this, 'enqueue_styles' );
		require(plugin_dir_path( __FILE__ ) . '/partials/todo-public-display.php');
	}
	public function get_todo_tasks() {
		$tasks = get_user_meta(get_current_user_id(),'todo_tasks', true);
		if($tasks) echo json_encode($tasks);
		exit;
	}
	public function update_todo_tasks() {
		if(isset($_POST['data'])){
			$tasks = $_POST['data'];
			update_user_meta(get_current_user_id(), 'todo_tasks', $tasks);
			exit;
		}
	}
}
