<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SignIn extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('m_kontenweb');
		$this->load->model('user');
		$this->load->model('m_users');
		$this->load->helper('url');
	}

  public function index()
  {
		if($this->session->userdata('status') != "login")
		{
			$data['setting'] = $this->m_kontenweb->tampil_data_public()->result();
	    $this->load->view('signin', $data);
		}
		else {
			redirect("/");
		}
  }

	public function do_login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => md5($password),
			'type' => 'Member',
			'status' => 1
			);
		$cek = $this->user->cek_login("users",$where)->num_rows();
		if($cek > 0)
		{
			$dataku = $this->user->cek_login("users",$where);
			foreach ($dataku->result() as $dat)
			{
					$ful = 	$dat->name;
					$tgl =  $dat->tgl_daftar;
					$posisi =  $dat->position;
					$img =  $dat->image;
					$idku =  $dat->id_user;
					$role = $dat->type;
			}
			$data_session = array(
				'nama' => $username,
				'status' => "login",
				'fullname' => $ful,
				'membersince' => $tgl,
				'posisi' => $posisi,
				'gambar' => $img,
				'id_user' => $idku,
				'type' => $role
				);
			$this->session->set_userdata($data_session);
			redirect("/");
		}else{
				redirect("signin");
		}
	}

	public function do_logout(){
		$this->session->sess_destroy();
		redirect('/');
	}


	public function activasiview()
	{
		if($this->session->userdata('status') != "login")
		{
			$data['setting'] = $this->m_kontenweb->tampil_data_public()->result();
			$this->load->view('activation', $data);
		}
		else {
			redirect("/");
		}
	}

	public function do_activ(){
		$code = $this->input->post('aktifkan');
		date_default_timezone_set("Asia/Jakarta");
		$date = date('Y-m-d H:i:s');

		$where = array(
			'keyact' => $code,
			'status' => 0
			);

		$datakuaktif = $this->user->cek_aktif("users",$where);
		foreach ($datakuaktif->result() as $data)
		{
				$idaktif =  $data->id_user;
				$kodeaktif =  $data->keyact;
		}

		if($code == $kodeaktif)
		{

			$data = array(
				'status'	=> 1,
				'updated_at'  => $date
			);

			$where = array(
				'id_user' => $idaktif
			);

			$this->m_users->update_data($where,$data,'users');
			redirect('signin');
		}else{
				redirect("activation/member");
		}
	}
}
