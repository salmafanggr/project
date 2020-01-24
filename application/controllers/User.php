<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('./application/third_party/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $id = $_SESSION['id'];
        $data['tittle'] = 'Presensi Guru';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['absen'] = $this->db->query("SELECT * FROM absen WHERE user_id=$id")->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['tittle'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $nip = $this->input->post('nip');
            $jurusan = $this->input->post('jurusan');
            $alamat = $this->input->post('alamat');
            $email = $this->input->post('email');
            $gender = $this->input->post('gender');
            $pendidikan = $this->input->post('pendidikan');
            $skills = $this->input->post('skills');
            $motto = $this->input->post('motto');


            //cek nek ono gambar
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '5000';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {

                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }



                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->set('jurusan', $jurusan);
            $this->db->set('alamat', $alamat);
            $this->db->set('gender', $gender);
            $this->db->set('pendidikan', $pendidikan);
            $this->db->set('skills', $skills);
            $this->db->set('motto', $motto);
            $this->db->where('nip', $nip);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success" role="alert">
            You profile has been update
              </div>'
            );
            redirect('user/myprofile');
        }
    }

    public function changePw()
    {
        $data['tittle'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();


        $this->form_validation->set_rules(
            'currentpw',
            'Current Password',
            'required|trim'
        );
        $this->form_validation->set_rules(
            'newpw1',
            'New Password',
            'required|trim|min_length[3]|matches[newpw2]'
        );
        $this->form_validation->set_rules(
            'newpw2',
            'Confirm Password',
            'required|trim|min_length[3]|matches[newpw1]'
        );


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepw', $data);
            $this->load->view('templates/footer');
        } else {
            $currentpw = $this->input->post('currentpw');
            $newpw = $this->input->post('newpw1');
            if (!password_verify($currentpw, $data['user']['password'])) {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">
            Wrong current password
              </div>'
                );
                redirect('user/changepw');
            } else {
                if ($currentpw == $newpw) {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger" role="alert">
                New Password cannot be the same as current password!
                  </div>'
                    );
                    redirect('user/changepw');
                } else {
                    //password ok

                    $password_hash = password_hash($newpw, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success" role="alert">
                        Password Changed              
                        </div>'
                    );
                    redirect('user/changepw');
                }
            }
        }
    }
    public function myprofile()
    {
        $data['tittle'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/myprofile', $data);
        $this->load->view('templates/footer');
    }

    //absen
    public function masuk()
    {
        $tgl_now = date('Y-m-d');
        $id = $_SESSION['id'];
        $nama = $_SESSION['name'];
        $jurusan = $_SESSION['jurusan'];
        $check = $this->db->query("SELECT waktu_masuk=$tgl_now FROM absen WHERE nama='$nama' AND DATE(waktu_masuk) = CURRENT_DATE()")->num_rows();
        if($check == 0){
            $data = [
                'user_id' => $id,
                'nama' => $nama,
                'jurusan' => $jurusan,
                'waktu_masuk' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('absen', $data);
            $this->session->set_flashdata(
				'message',
				'<div class="alert alert-success" role="alert">
			Kamu Berhasil Absen Masuk
			  </div>'
            );
            redirect('user');
        }
    }

    public function izin()
    {
        $keterangan = $this->input->post('keterangan');
        $alasan = $this->input->post('alasan');
        $tgl_now = date('Y-m-d');
        $id = $_SESSION['id'];
        $nama = $_SESSION['name'];
        $jurusan = $_SESSION['jurusan'];
        $check = $this->db->query("SELECT nama='$nama' FROM absen WHERE waktu_izin IS NULL AND user_id=$id AND DATE(waktu_masuk) = CURRENT_DATE()")->num_rows();
        if($check == 0){
            $data = [
                'user_id' => $id,
                'nama' => $nama,
                'jurusan' => $jurusan,
                'waktu_izin' => date('Y-m-d H:i:s'),
                'keterangan' => $keterangan,
                'alasan' => $alasan
            ];
            $this->db->insert('absen', $data);
            $this->session->set_flashdata(
				'message',
				'<div class="alert alert-success" role="alert">
			Kamu Berhasil Absen
			  </div>'
            );
            redirect('user');
        }
    }
    
    public function keluar()
    {
        $tgl_now = date('Y-m-d');
        //$id = $_SESSION['id'];
        $nama = $_SESSION['name'];
        $check = $this->db->query("SELECT waktu_keluar=$tgl_now, id FROM absen WHERE nama='$nama' AND DATE(waktu_masuk) = CURRENT_DATE()");
        if($check->num_rows() == 1){
            $data = [
                'nama' => $nama,
                'waktu_keluar' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id', $check->row()->id);
            $this->db->update('absen', $data);
            $this->session->set_flashdata(
				'message',
				'<div class="alert alert-success" role="alert">
			Kamu Telah Absen Pulang
			  </div>'
            );
            redirect('user');
        }
    }

    public function export()
     {
          $filename = $_SESSION['name'];

          $absen = $this->user_model->getAll_by_user()->result();

          $spreadsheet = new Spreadsheet;

          $spreadsheet->setActiveSheetIndex(0)
                      ->setCellValue('A1', 'No')
                      ->setCellValue('B1', 'Nama')
                      ->setCellValue('C1', 'Jurusan')
                      ->setCellValue('D1', 'Jam Masuk')
                      ->setCellValue('E1', 'Jam Keluar')
                      ->setCellValue('F1', 'Jam Izin')
                      ->setCellValue('G1', 'Keterangan')
                      ->setCellValue('H1', 'Alasan');

          $kolom = 2;
          $nomor = 1;
          foreach($absen as $absensi) {

               $spreadsheet->setActiveSheetIndex(0)
                           ->setCellValue('A' . $kolom, $nomor)
                           ->setCellValue('B' . $kolom, $absensi->nama)
                           ->setCellValue('C' . $kolom, $absensi->jurusan)
                           ->setCellValue('D' . $kolom, $absensi->waktu_masuk)
                           ->setCellValue('E' . $kolom, $absensi->waktu_keluar)
                           ->setCellValue('F' . $kolom, $absensi->waktu_izin)
                           ->setCellValue('G' . $kolom, $absensi->keterangan)
                           ->setCellValue('H' . $kolom, $absensi->alasan);

               $kolom++;
               $nomor++;

          }

          $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Presensi-'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
     }

     public function exportall()
     {
          $filename = $_SESSION['name'];

          $absen = $this->user_model->getAll()->result();

          $spreadsheet = new Spreadsheet;

          $spreadsheet->setActiveSheetIndex(0)
                      ->setCellValue('A1', 'No')
                      ->setCellValue('B1', 'Nama')
                      ->setCellValue('C1', 'Jurusan')
                      ->setCellValue('D1', 'Jam Masuk')
                      ->setCellValue('E1', 'Jam Keluar')
                      ->setCellValue('F1', 'Jam Izin')
                      ->setCellValue('G1', 'Keterangan')
                      ->setCellValue('H1', 'Alasan');

          $kolom = 2;
          $nomor = 1;
          foreach($absen as $absensi) {

               $spreadsheet->setActiveSheetIndex(0)
                           ->setCellValue('A' . $kolom, $nomor)
                           ->setCellValue('B' . $kolom, $absensi->nama)
                           ->setCellValue('C' . $kolom, $absensi->jurusan)
                           ->setCellValue('D' . $kolom, $absensi->waktu_masuk)
                           ->setCellValue('E' . $kolom, $absensi->waktu_keluar)
                           ->setCellValue('F' . $kolom, $absensi->waktu_izin)
                           ->setCellValue('G' . $kolom, $absensi->keterangan)
                           ->setCellValue('H' . $kolom, $absensi->alasan);

               $kolom++;
               $nomor++;

          }

          $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Presensi-'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
     }
}
