<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SignUp extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('model_select');
		$this->load->model('m_kontenweb');
		$this->load->model('m_users');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
	}

  public function index()
  {
				if($this->session->userdata('status') != "login")
				{
					$data['provinsi']=$this->model_select->provinsi();
					$data['setting'] = $this->m_kontenweb->tampil_data_public()->result();

				  $this->load->library(array('recaptcha', 'form_validation'));
	        $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback_get_response_captcha');
	        $this->form_validation->set_message('required', '%s harus diisi');
	        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	        if($this->form_validation->run() == TRUE)
	        {
	        	redirect('signin');
	        }
	        else
	        {
	        	$data['recaptcha_html'] = $this->recaptcha->render();
	        	$this->load->view('signup', $data);
	        }
				}
				else {
					redirect("/");
				}
  }

	public function mailtemp()
	{
			$this->load->view('mailtemplateregys');
	}

	public function ambil_data()
	{
			$modul=$this->input->post('modul');
			$id=$this->input->post('id');
			if($modul=="kabupaten")
			{
				echo $this->model_select->kabupaten($id);
			}
			else if($modul=="kecamatan"){

			}
			else if($modul=="kelurahan"){

			}
	 }

	 public function tambah_aksi()
	 {
 		$config['upload_path'] = './assets/dashboard/dist/img/';
 		$config['allowed_types'] = 'gif|jpg|png';
 		$config['max_size']	= '10000'; //in kb
 		$this->upload->initialize($config);
 		$fname = $this->input->post('first');
		$lname = $this->input->post('last');
		$telp = $this->input->post('telp');
		$email = $this->input->post('email');
		$add = $this->input->post('address');
		$prov= $this->input->post('prov');
		$city = $this->input->post('kota');
		$org = $this->input->post('org');
 		$username = $this->input->post('username');
 		$pass = md5($this->input->post('pass'));
 		date_default_timezone_set("Asia/Jakarta");
 		$date = date('Y-m-d H:i:s');
		$fullname = "$fname $lname";
		$activation = time();

		$this->load->library(array('recaptcha', 'form_validation'));
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');
		$this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback_get_response_captcha');
		$this->form_validation->set_message('required', '%s harus diisi');
		$this->form_validation->set_message('valid_email', 'Alamat %s tidak valid');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		$where = array(
			'username' => $username,
			);
		$cek = $this->m_users->cek_datauser("users",$where)->num_rows();

		if($cek > 0)
		{
			if($fulname != "" && $username != "")
			{
				$data_session = array(
					'validasidata' => "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						<i class='icon fa fa-ban'></i> Username Sudah Ada Yang Menggunakan </div>",
					);
				$this->session->set_userdata($data_session);
				redirect("signup");
			}else {
				redirect("signup");
			}
		}else {
				$url = $_SERVER['HTTP_REFERER'];
				$config = Array(
		      'protocol' => 'sendmail',
		      'mailpath' => '/usr/sbin/sendmail',
		      'mailtype' => 'html',
		      'charset' => 'iso-8859-1',
		      'wordwrap' => TRUE
		    );

		    $this->load->library('email', $config);
		    $this->email->set_newline("\r\n");
		    $this->email->from('info.syantikara@wcsstudio.id', 'RPCB Syantikara');
		    $this->email->to($email); //email tujuan. Isikan dengan emailmu!
				$this->email->cc('info.syantikara@wcsstudio.id', 'RPCB Syantikara');
		    $this->email->subject('Selamat Datang di RPCB Syantikara');
				$data = array(
							   'Email'=> $email,
		             'UserName'=> $username,
								 'Fullname'=> $fullname,
								 'Activ'	=> $activation,
								 'Password'	=> $this->input->post('pass'),
								 'DateRegister'=> $date
		    );
				$body = $this->load->view('mailtemplateregys.php',$data,TRUE);
		    $this->email->message($body);

				if($this->email->send())
				{
						if ( !$this->upload->do_upload('image'))
						{
							if($this->form_validation->run() == TRUE)
							{
								$data_user = array(
											'name'				=> $fullname,
											'username' 		=> $username,
											'password'		=> $pass,
											'type'  			=> "Member",
											'status'			=> 0,
											'position'  	=> "Member",
											'id_provinsi' => $prov,
											'id_city' 			=> $city,
											'address' 			=> $add,
											'phone'					=> $telp,
											'email'  			  => $email,
											'organization'	=> $org,
											'tgl_daftar'  => $date,
											'created_at'  => $date,
											'updated_at'  => $date,
											'keyact'			=> $activation,
											'image'  			=> 'nopp.jpg'
											);
								 $this->m_users->input_data($data_user,'users');
								 redirect('activation/member');
							 }
							 else {
								$data['recaptcha_html'] = $this->recaptcha->render();
								redirect('signup',$data);
							 }
						}
						else
						{
							if($this->form_validation->run() == TRUE)
							{
						 		$data_user = array(
						 					'name'				=> $fullname,
						 					'username' 		=> $username,
						 					'password'		=> $pass,
						 					'type'  			=> "Member",
						 					'status'			=> 0,
						 					'position'  	=> "Member",
											'id_provinsi' => $prov,
											'id_city' 			=> $city,
											'address' 			=> $add,
											'phone'					=> $telp,
											'email'  			  => $email,
											'organization'	=> $org,
						 					'tgl_daftar'  => $date,
						 					'created_at'  => $date,
						 					'updated_at'  => $date,
											'keyact'			=> $activation,
						 					'image'  			=> $this->upload->data('file_name')
						 					);
								 $this->m_users->input_data($data_user,'users');
								 redirect('activation/member');
							 }
							 else {
							 	$data['recaptcha_html'] = $this->recaptcha->render();
								redirect('signup',$data);
							 }
						}
					}
					else
					{
						show_error($this->email->print_debugger());
					}
			}
 	}

	public function get_response_captcha($string)
  {
        $this->load->library('recaptcha');
        $response = $this->recaptcha->verifyResponse($string);
        if ($response['success'])
				{
            return true;
        } else {
            $this->form_validation->set_message('get_response_captcha', '%s harus diisi');
            return false;
        }
    }

}
