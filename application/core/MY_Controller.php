<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

	public function __construct(){


		$route = $this->router->fetch_class();

		
	}

	public function load_page($page, $data = array()){
		$this->load->view('includes/admin/head',$data);
		$this->load->view('includes/admin/header',$data);
		$this->load->view('includes/admin/sidebar',$data);
		$this->load->view($page, $data);
		$this->load->view('includes/admin/footer',$data);
	}

	public function load_investor_page($page,$data = array()){
		$this->load->view('includes/investor/head',$data);
		$this->load->view('includes/investor/nav',$data);
		$this->load->view($page,$data);
		$this->load->view('includes/investor/footer',$data);
	}

	public function load_login_page($page,$data = array(), $component =""){
		$this->load->view('includes/guest/head',$data);
		$this->load->view($page,$data);
		$this->load->view('includes/guest/footer',$data);
	}
	public function load_admin_page($page,$data = array(), $component =""){
		$this->load->view('includes/admin/header',$data);
		$this->load->view($page,$data);
		$this->load->view('includes/admin/footer',$data);
	}

	public function load_cbmc_page($page,$data = array(), $component =""){
		$this->load->view('includes/cbmc/header',$data);
		$this->load->view($page,$data);
		$this->load->view('includes/admin/footer',$data);
	}

	public function load_subsidiary_page($page,$data = array(), $component =""){
		$this->load->view('includes/subsidiary/header',$data);
		$this->load->view($page,$data);
		$this->load->view('includes/subsidiary/footer',$data);
	}

	

}
