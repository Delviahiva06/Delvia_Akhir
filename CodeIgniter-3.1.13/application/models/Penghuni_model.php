<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penghuni_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'tb_penghuni';
    }

    // Get all penghuni
    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    // Get penghuni by ID
    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    // Get active penghuni (yang belum keluar)
    public function get_active() {
        return $this->db->where('tgl_keluar IS NULL')->get($this->table)->result();
    }

    // Get penghuni by KTP
    public function get_by_ktp($no_ktp) {
        return $this->db->where('no_ktp', $no_ktp)->get($this->table)->row();
    }

    // Insert new penghuni
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // Update penghuni
    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // Delete penghuni
    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }

    // Check if KTP exists
    public function ktp_exists($no_ktp, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->where('no_ktp', $no_ktp)->get($this->table)->num_rows() > 0;
    }

    // Get penghuni with kamar info
    public function get_with_kamar() {
        $this->db->select('p.*, k.nomor as nomor_kamar, k.harga as harga_kamar, kp.tgl_masuk as tgl_masuk_kamar, kp.status as status_kamar')
                 ->from($this->table . ' p')
                 ->join('tb_kmr_penghuni kp', 'p.id = kp.id_penghuni', 'left')
                 ->join('tb_kamar k', 'kp.id_kamar = k.id', 'left')
                 ->where('p.tgl_keluar IS NULL')
                 ->order_by('p.nama', 'ASC');
        return $this->db->get()->result();
    }

    // Get penghuni yang akan bayar (berdasarkan tanggal masuk)
    public function get_yang_akan_bayar($hari = 7) {
        $this->db->select('p.*, k.nomor as nomor_kamar, kp.tgl_masuk as tgl_masuk_kamar')
                 ->from($this->table . ' p')
                 ->join('tb_kmr_penghuni kp', 'p.id = kp.id_penghuni', 'left')
                 ->join('tb_kamar k', 'kp.id_kamar = k.id', 'left')
                 ->where('p.tgl_keluar IS NULL')
                 ->where('kp.status', 'aktif')
                 ->where('DATE_ADD(kp.tgl_masuk, INTERVAL 1 MONTH) <=', date('Y-m-d', strtotime("+$hari days")))
                 ->order_by('kp.tgl_masuk', 'ASC');
        return $this->db->get()->result();
    }
} 