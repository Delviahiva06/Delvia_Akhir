<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kamar_model');
        $this->load->model('Tagihan_model');
        $this->load->model('Penghuni_model');
    }

    public function index() {
        $data['title'] = 'Sistem Manajemen Kos';
        
        // Get kamar kosong
        $data['kamar_kosong'] = $this->Kamar_model->get_kosong();
        
        // Get kamar yang akan bayar (7 hari ke depan)
        $data['akan_bayar'] = $this->Penghuni_model->get_yang_akan_bayar(7);
        
        // Get kamar terlambat bayar
        $data['terlambat_bayar'] = $this->Kamar_model->get_terlambat_bayar();
        
        // Get statistik
        $data['total_kamar'] = count($this->Kamar_model->get_all());
        $data['kamar_terisi'] = count($this->Kamar_model->get_terisi());
        $data['kamar_kosong_count'] = count($data['kamar_kosong']);
        $data['total_penghuni'] = count($this->Penghuni_model->get_active());
        
        $this->load->view('templates/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('templates/footer');
    }

    public function kamar_kosong() {
        $data['title'] = 'Kamar Kosong';
        $data['kamar_kosong'] = $this->Kamar_model->get_kosong();
        
        $this->load->view('templates/header', $data);
        $this->load->view('home/kamar_kosong', $data);
        $this->load->view('templates/footer');
    }

    public function akan_bayar() {
        $data['title'] = 'Penghuni yang Akan Bayar';
        $data['akan_bayar'] = $this->Penghuni_model->get_yang_akan_bayar(7);
        
        $this->load->view('templates/header', $data);
        $this->load->view('home/akan_bayar', $data);
        $this->load->view('templates/footer');
    }

    public function terlambat_bayar() {
        $data['title'] = 'Penghuni Terlambat Bayar';
        $data['terlambat_bayar'] = $this->Kamar_model->get_terlambat_bayar();
        
        $this->load->view('templates/header', $data);
        $this->load->view('home/terlambat_bayar', $data);
        $this->load->view('templates/footer');
    }

    public function tentang() {
        $data['title'] = 'Tentang Kami';
        
        $this->load->view('templates/header', $data);
        $this->load->view('home/tentang', $data);
        $this->load->view('templates/footer');
    }

    public function kontak() {
        $data['title'] = 'Kontak Kami';
        
        $this->load->view('templates/header', $data);
        $this->load->view('home/kontak', $data);
        $this->load->view('templates/footer');
    }
} 