<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
	public function index()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		}
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == false) {
			$data['tittle'] = 'Login';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		} else {
			//validasinya success
			$this->_login();
		}
	}

	private function _login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		//jika user ada
		if ($user) {

			if ($user['is_confirm'] == 1) {
				if ($user['is_active'] == 1) {
					//cek password
					if (password_verify($password, $user['password'])) {
						$data = [
							'id' => $user['id'],
							'name' => $user['name'],
							'email' => $user['email'],
							'gender' => $user['gender'],
							'jurusan' => $user['jurusan'],
							'role_id' => $user['role_id']
						];
						$this->session->set_userdata($data);

						if ($user['role_id'] == 1) {
							redirect('admin');
						} else {
							redirect('user');
						}
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
							Wrong password!
						</div>');
						redirect('auth');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
					This Email has not been activated!
					</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
				This Email has not been activated by admin!
				</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Email is not registered!
			</div>');
			redirect('auth');
		}
	}




	public function registration()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		}
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('nip', 'Nip', 'required|trim|is_unique[user.nip]', [
			'is_unique' => 'This NIP has already registered!'
		]);
		$this->form_validation->set_rules('gender', 'Gender');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
			'is_unique' => 'This email has already registered!'
		]);
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
			'matches' => 'Password dont match!',
			'min_length' => 'Password too short!'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

		if ($this->form_validation->run() == false) {
			$data['tittle'] = 'Register';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/registration');
			$this->load->view('templates/auth_footer');
		} else {
			$email = $this->input->post('email', true);
			$data = [
				'name' => htmlspecialchars($this->input->post('name', true)),
				'nip' => htmlspecialchars($this->input->post('nip', true)),
				'gender' => htmlspecialchars($this->input->post('gender', true)),
				'email' => htmlspecialchars($email),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => 0,
				'date_created' => time()
			];

			//siapkan token
			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' 		=> $email,
				'token' 		=> $token,
				'date_created'  => time()
			];


			$this->db->insert('user', $data);
			$this->db->insert('user_token', $user_token);

			$this->_sendEmail($token, 'verify');


			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your account has been created. Please Activate your account
		  </div>');
			redirect('auth');
		}
	}


	private function _sendEmail($token, $type)
	{
		$this->load->library('email');

		$config = array();
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.googlemail.com';
		$config['smtp_user'] = 'kikikpahlevi@gmail.com';
		$config['smtp_pass'] = 'surabaya12';
		$config['smtp_port'] = 465;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);

		$this->email->set_newline("\r\n");
		$this->email->from('kikikpahlevi@gmail.com', 'Kikik Pahlevi');
		$this->email->to($this->input->post('email'));

		if ($type == 'verify') {

			$this->email->subject('Account Verification');
			$this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
		} else if ($type == 'forgot') {
			$this->email->subject('Reset Password');
			$this->email->message('Click this link to reset your account : <a href="' . base_url() . 'auth/resetpw?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
		}


		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		if ($user) {

			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

			if ($user_token) {
				$this->db->set('is_active', 1);
				$this->db->where('email', $email);
				$this->db->update('user');

				$this->db->delete('user_token', ['email' => $email]);

				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-success" role="alert">
					' . $email . ' has been activated! Please Login
				  </div>'
				);
				redirect('auth');
			} else {
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger" role="alert">
				Account activation failed! Token invalid 
				  </div>'
				);
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-danger" role="alert">
			Account activation failed! Wrong email
			  </div>'
			);
			redirect('auth');
		}
	}



	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');

		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success" role="alert">
		You have been logged out
		  </div>'
		);
		redirect('auth');
	}

	public function blocked()
	{
		$this->load->view('auth/blocked');
	}

	public function forgotpw()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == false) {
			$data['tittle'] = 'Forgot Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/forgotpw');
			$this->load->view('templates/auth_footer');
		} else {
			$email  = $this->input->post('email');
			$user	= $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

			if ($user) {

				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];

				$this->db->insert('user_token', $user_token);
				$this->_sendEmail($token, 'forgot');

				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-success" role="alert">
				Please Check Your Email to reset your password bruhhh
				  </div>'
				);
				redirect('auth/forgotpw');
			} else {
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger" role="alert">
				Email is not registered or activated Broo
				  </div>'
				);
				redirect('auth/forgotpw');
			}
		}
	}


	public function resetPw()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

			if ($user_token) {
				$this->session->set_userdata('reset_email', $email);
				$this->changePw();
			} else {
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger" role="alert">
				Reset Password Gagal! Token Salah sayang
				  </div>'
				);
				//redirect('auth');
			}
		} else {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-danger" role="alert">
			Reset Password Gagal! Emailmu Salah sayang
			  </div>'
			);
			//redirect('auth');
		}
	}

	public function changePw()
	{

		if (!$this->session->userdata('reset_email')) {
			redirect('auth');
		}


		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
			'matches' => 'Password dont match!',
			'min_length' => 'Password too short!'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
		if ($this->form_validation->run() == false) {
			$data['tittle'] = 'Change Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/changepw');
			$this->load->view('templates/auth_footer');
		} else {
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
			$email	  = $this->session->userdata('reset_email');

			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('user');

			$this->session->unset_userdata('reset_email');

			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-success" role="alert">
			Password Berhasil diganti ciyeeeee
			  </div>'
			);
			redirect('auth');
		}
	}
}
