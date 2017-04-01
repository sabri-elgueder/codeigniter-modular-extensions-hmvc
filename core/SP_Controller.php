<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SP_Controller extends CI_Controller {

	protected $viewPath;

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		if(isset($_GET['profiler'])) {
			$this->output->enable_profiler(TRUE);
		}

		$this->data['body_class'] = '';
	}

	protected function view($view, $data){
		$this->load->view( $this->viewPath . '/' . $view, $data);
	}

	public function show404($message = ""){
		die($message . ": Error 404");
	}
}
