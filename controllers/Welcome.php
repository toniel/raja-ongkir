<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('home');
	}
	public function get_provinsi()
	{
		$provinces = $this->rajaongkir->province();
		$this->output->set_content_type('application/json')->set_output($provinces);
		// echo json_encode($provinces);
	}

	public function cities()
	{
		$cities = $this->rajaongkir->city();
		$this->output->set_content_type('application/json')->set_output($cities);
	}

	public function city($id_provinsi)
	{
		$city = $this->rajaongkir->city($id_provinsi);
		$this->output->set_content_type('application/json')->set_output($city);
	}

	public function cek_ongkir($origin,$destination,$weight,$courier)
	{
		$ongkir = $this->rajaongkir->cost($origin,$destination,$weight,$courier);
		$this->output->set_content_type('application/json')->set_output($ongkir);
		// echo $ongkir;

	}
}
