<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'tb_tagihan';
    }

    // Get all tagihan
    public function get_all() {
        $this->db->select('t.*, k.nomor as nomor_kamar, p.nama as nama_penghuni, kp.tgl_masuk')
                 ->from($this->table . ' t')
                 ->join('tb_kmr_penghuni kp', 't.id_kmr_penghuni = kp.id')
                 ->join('tb_kamar k', 'kp.id_kamar = k.id')
                 ->join('tb_penghuni p', 'kp.id_penghuni = p.id')
                 ->order_by('t.bulan DESC, t.tahun DESC');
        return $this->db->get()->result();
    }

    // Get tagihan by ID
    public function get_by_id($id) {
        $this->db->select('t.*, k.nomor as nomor_kamar, p.nama as nama_penghuni, kp.tgl_masuk')
                 ->from($this->table . ' t')
                 ->join('tb_kmr_penghuni kp', 't.id_kmr_penghuni = kp.id')
                 ->join('tb_kamar k', 'kp.id_kamar = k.id')
                 ->join('tb_penghuni p', 'kp.id_penghuni = p.id')
                 ->where('t.id', $id);
        return $this->db->get()->row();
    }

    // Get tagihan by bulan dan tahun
    public function get_by_bulan_tahun($bulan, $tahun) {
        $this->db->select('t.*, k.nomor as nomor_kamar, p.nama as nama_penghuni, kp.tgl_masuk')
                 ->from($this->table . ' t')
                 ->join('tb_kmr_penghuni kp', 't.id_kmr_penghuni = kp.id')
                 ->join('tb_kamar k', 'kp.id_kamar = k.id')
                 ->join('tb_penghuni p', 'kp.id_penghuni = p.id')
                 ->where('t.bulan', $bulan)
                 ->where('t.tahun', $tahun)
                 ->order_by('k.nomor', 'ASC');
        return $this->db->get()->result();
    }

    // Get tagihan by status
    public function get_by_status($status) {
        $this->db->select('t.*, k.nomor as nomor_kamar, p.nama as nama_penghuni, kp.tgl_masuk')
                 ->from($this->table . ' t')
                 ->join('tb_kmr_penghuni kp', 't.id_kmr_penghuni = kp.id')
                 ->join('tb_kamar k', 'kp.id_kamar = k.id')
                 ->join('tb_penghuni p', 'kp.id_penghuni = p.id')
                 ->where('t.status', $status)
                 ->order_by('t.tgl_jatuh_tempo', 'ASC');
        return $this->db->get()->result();
    }

    // Get tagihan terlambat
    public function get_terlambat() {
        $this->db->select('t.*, k.nomor as nomor_kamar, p.nama as nama_penghuni, kp.tgl_masuk')
                 ->from($this->table . ' t')
                 ->join('tb_kmr_penghuni kp', 't.id_kmr_penghuni = kp.id')
                 ->join('tb_kamar k', 'kp.id_kamar = k.id')
                 ->join('tb_penghuni p', 'kp.id_penghuni = p.id')
                 ->where('t.status !=', 'lunas')
                 ->where('t.tgl_jatuh_tempo <', date('Y-m-d'))
                 ->order_by('t.tgl_jatuh_tempo', 'ASC');
        return $this->db->get()->result();
    }

    // Insert new tagihan
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // Update tagihan
    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // Delete tagihan
    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }

    // Generate tagihan untuk bulan tertentu
    public function generate_tagihan($bulan, $tahun) {
        // Get semua penghuni aktif
        $this->db->select('kp.id as id_kmr_penghuni, k.harga as harga_kamar, bb.total_barang')
                 ->from('tb_kmr_penghuni kp')
                 ->join('tb_kamar k', 'kp.id_kamar = k.id')
                 ->join('tb_penghuni p', 'kp.id_penghuni = p.id')
                 ->join('(SELECT id_penghuni, SUM(b.harga) as total_barang 
                         FROM tb_brng_bawaan bb 
                         JOIN tb_barang b ON bb.id_barang = b.id 
                         GROUP BY id_penghuni) bb', 'p.id = bb.id_penghuni', 'left')
                 ->where('kp.status', 'aktif')
                 ->where('p.tgl_keluar IS NULL');
        
        $penghuni_aktif = $this->db->get()->result();
        
        $inserted = 0;
        foreach ($penghuni_aktif as $penghuni) {
            // Check if tagihan already exists
            $exists = $this->db->where('id_kmr_penghuni', $penghuni->id_kmr_penghuni)
                              ->where('bulan', $bulan)
                              ->where('tahun', $tahun)
                              ->get($this->table)
                              ->num_rows();
            
            if ($exists == 0) {
                $total_barang = $penghuni->total_barang ?: 0;
                $jml_tagihan = $penghuni->harga_kamar + $total_barang;
                
                $data = [
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'id_kmr_penghuni' => $penghuni->id_kmr_penghuni,
                    'jml_tagihan' => $jml_tagihan,
                    'status' => 'belum_bayar',
                    'tgl_jatuh_tempo' => date('Y-m-d', strtotime("$tahun-$bulan-10"))
                ];
                
                $this->db->insert($this->table, $data);
                $inserted++;
            }
        }
        
        return $inserted;
    }

    // Update status tagihan berdasarkan pembayaran
    public function update_status_by_pembayaran($id_tagihan) {
        $this->db->select('t.jml_tagihan, COALESCE(SUM(b.jml_bayar), 0) as total_bayar')
                 ->from($this->table . ' t')
                 ->join('tb_bayar b', 't.id = b.id_tagihan', 'left')
                 ->where('t.id', $id_tagihan)
                 ->group_by('t.id');
        
        $result = $this->db->get()->row();
        
        if ($result) {
            $status = 'belum_bayar';
            if ($result->total_bayar >= $result->jml_tagihan) {
                $status = 'lunas';
            } elseif ($result->total_bayar > 0) {
                $status = 'cicil';
            }
            
            return $this->db->where('id', $id_tagihan)->update($this->table, ['status' => $status]);
        }
        
        return false;
    }
} 