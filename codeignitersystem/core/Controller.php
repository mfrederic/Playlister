<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;
	protected $layout = 'default';
	protected $data;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();

		$this->initialize_data();
		
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}

	public function initialize_data() {
		$this->data = array(
			'title' => 'My Playlister',
			'menu' => $this->partial('layout/menu'),
			'player' => $this->partial('layout/player'),
			'loadedplaylist' => '',
			'stylesheet' => array('general',
				'fontello',
				'font-awesome',
				'jquery-ui.min',
				'jquery-ui.structure.min',
				'dropzone'),
			'scripts' => array('jquery',
				'jquery-ui.min',
				'dropzone',
				'alerter',
				'jplayer/jquery.jplayer.min',
				'jplayer/add-on/jplayer.playlist.min',
				'scripts',
				'ajaxNavigation',
				'jquery.dataTables',
				'dataTable'),
			'lastfm_api' => $this->config->item('lastfm_api'),
			'loadedplaylist' => $this->partial('player/loadplaylist'),
			'checker_url_for_dropzone' => site_url('upload/check')
		);
	}

	public function render($view_name, $data='') {
		if($this->input->get('partial')) {
			echo $this->partial($view_name, $data);
			return true;
		}
		$data['content'] = $this->load->view($view_name, $data, true);
		$this->load->view('layout/' . $this->layout, $data);
	}

	public function partial($view_name, $data='') {
		return $this->load->view($view_name, $data, true);
	}

	public function process_data($text) {
	    $re = '%# Collapse ws everywhere but in blacklisted elements.
	        (?>             # Match all whitespans other than single space.
	          [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
	        | \s{2,}        # or two or more consecutive-any-whitespace.
	        ) # Note: The remaining regex consumes no text at all...
	        (?=             # Ensure we are not in a blacklist tag.
	          (?:           # Begin (unnecessary) group.
	            (?:         # Zero or more of...
	              [^<]++    # Either one or more non-"<"
	            | <         # or a < starting a non-blacklist tag.
	              (?!/?(?:textarea|pre)\b)
	            )*+         # (This could be "unroll-the-loop"ified.)
	          )             # End (unnecessary) group.
	          (?:           # Begin alternation group.
	            <           # Either a blacklist start tag.
	            (?>textarea|pre)\b
	          | \z          # or end of file.
	          )             # End alternation group.
	        )  # If we made it here, we are not in a blacklist tag.
	        %ix';
	    $text = preg_replace($re, " ", $text);
	    return $text;
	}
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */