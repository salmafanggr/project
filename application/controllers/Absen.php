<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('./application/third_party/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Absen extends CI_Controller
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
        $data['tittle'] = 'Presensi List';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['absen'] = $this->db->query("SELECT * FROM absen WHERE user_id=$id")->result();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('absen/list', $data);
        $this->load->view('templates/footer');
    }

    public function masuk()
    {
        $tgl_now = date('Y-m-d');
        $id = $_SESSION['id'];
        $nama = $_SESSION['name'];
        $jurusan = $_SESSION['jurusan'];
        $check = $this->db->query("SELECT waktu_masuk=$tgl_now FROM absen WHERE nama='$nama'")->num_rows();
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
        $check = $this->db->query("SELECT nama='$nama' FROM absen WHERE waktu_izin IS NULL AND user_id=$id")->num_rows();
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
        $id = $_SESSION['id'];
        $nama = $_SESSION['name'];
        $check = $this->db->query("SELECT waktu_keluar=$tgl_now FROM absen WHERE nama='$nama'")->num_rows();
        if($check == 1){
            $data = [
                'nama' => $nama,
                'waktu_keluar' => date('Y-m-d H:i:s')
            ];
            $this->db->where('user_id', $id);
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
          $absen = $this->absen_model->getAll()->result();

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
        header('Content-Disposition: attachment;filename="Absensi.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
     }
}