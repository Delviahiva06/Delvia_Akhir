<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kamar_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'tb_kamar';
    }

    // Get all kamar
    public function get_all() {
        return $this->db->order_by('nomor', 'ASC')->get($this->table)->result();
    }

    // Get kamar by ID
    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    // Get kamar by nomor
    public function get_by_nomor($nomor) {
        return $this->db->where('nomor', $nomor)->get($this->table)->row();
    }

    // Get kamar kosong
    public function get_kosong() {
        return $this->db->where('status', 'kosong')->order_by('nomor', 'ASC')->get($this->table)->result();
    }

    // Get kamar terisi
    public function get_terisi() {
        return $this->db->where('status', 'terisi')->order_by('nomor', 'ASC')->get($this->table)->result();
    }

    // Insert new kamar
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // Update kamar
    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // Delete kamar
    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }

    // Check if nomor exists
    public function nomor_exists($nomor, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->where('nomor', $nomor)->get($this->table)->num_rows() > 0;
    }

    // Update status kamar
    public function update_status($id, $status) {
        return $this->db->where('id', $id)->update($this->table, ['status' => $status]);
    }

    // Get kamar with penghuni info
    public function get_with_penghuni() {
        $this->db->select('k.*, p.nama as nama_penghuni, p.no_hp, kp.tgl_masuk, kp.status as status_penghuni')
                 ->from($this->table . ' k')
                 ->join('tb_kmr_penghuni kp', 'k.id = kp.id_kamar', 'left')
                 ->join('tb_penghuni p', 'kp.id_penghuni = p.id', 'left')
                 ->where('kp.status', 'aktif')
                 ->or_where('kp.status IS NULL')
                 ->order_by('k.nomor', 'ASC');
        return $this->db->get()->result();
    }

    // Get kamar yang terlambat bayar
    public function get_terlambat_bayar() {
        $this->db->select('k.nomor, k.harga, p.nama as nama_penghuni, t.tgl_jatuh_tempo, t.jml_tagihan')
                 ->from($this->table . ' k')
                 ->join('tb_kmr_penghuni kp', 'k.id = kp.id_kamar')
                 ->join('tb_penghuni p', 'kp.id_penghuni = p.id')
                 ->join('tb_tagihan t', 'kp.id = t.id_kmr_penghuni')
                 ->where('kp.status', 'aktif')
                 ->where('t.status !=', 'lunas')
                 ->where('t.tgl_jatuh_tempo <', date('Y-m-d'))
                 ->order_by('t.tgl_jatuh_tempo', 'ASC');
        return $this->db->get()->result();
    }
} 