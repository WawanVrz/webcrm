<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardAdminController extends CI_Controller {

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

	 public function __construct(){
		parent::__construct();

		$this->load->model('user');
		$this->load->model('m_users');
		$this->load->model('m_transaksi');
		$this->load->helper('url');

		if($this->session->userdata('status') != "login"){
			redirect("panel/admin");
		}
	}

	public function index()
	{
		$this->load->view('admin/dashboardadmin');
	}

	public function profileuser()
	{
		$this->load->view('admin/ProfileUser');
	}

	public function editprofileuser()
	{
		$this->load->view('admin/EditProfileUser');
	}

	public function ubahpassword($id)
	{
		$where = array('id_user' => $id);
		$data['user_data'] = $this->user->edit_data($where,'users')->result();
		$this->load->view('admin/changepassword',$data);
	}

	function update(){
		$id = $this->input->post('id');
		$pass1 = $this->input->post('newpass');
		$pass2 = $this->input->post('confirm');

		if($pass1 == $pass2)
		{
			$data = array(
				'password' 	=> md5($pass1)
			);

			$where = array(
				'id_user' => $id
			);

			$this->user->update_data($where,$data,'users');
			redirect('panel/admin');
		}else {
				redirect('dashboard/admin/profile');
		}
	}

	function update_profile(){
		$config['upload_path'] = './assets/dashboard/dist/img/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10000'; //in kb
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$this->upload->initialize($config);

		$id = $this->input->post('id');
		$fulname = $this->input->post('fullname');
		$telp = $this->input->post('phone');
		$email = $this->input->post('email');
		$add = $this->input->post('posisi');
		date_default_timezone_set("Asia/Jakarta");
		$date = date('Y-m-d H:i:s');
		$this->upload->do_upload('image');
		$imagepp = $this->upload->data('file_name');

		if($imagepp == "")
		{
			$data = array(
				'name'				=> $fulname,
				'position' 			=> $add,
				'phone'					=> $telp,
				'email'  			  => $email,
				'updated_at'  => $date
			);
			$where = array(
				'id_user' => $id
			);
			$this->m_users->update_data($where,$data,'users');
			redirect('panel/auth/logout');
		}else{
			$data = array(
				'name'				=> $fulname,
				'position' 			=> $add,
				'phone'					=> $telp,
				'email'  			  => $email,
				'image'  			=> $this->upload->data('file_name'),
				'updated_at'  => $date
			);
			$where = array(
				'id_user' => $id
			);
			$this->m_users->update_data($where,$data,'users');
			redirect('panel/auth/logout');
		}
	}
}
