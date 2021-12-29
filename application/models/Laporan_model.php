<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan_model extends CI_Model
{

    function barang_masuk($id_jns_brg, $tgl_dari, $tgl_sampai, $kode_barang){
        $this->db->select('a.tgl_masuk as tgl,b.kode_barang,b.nama_barang,
        b.harga,b.stok,a.jumlah, a.harga as hrg_perubahan');
        $this->db->join('barang b','a.kode_barang=b.kode_barang');
        if($id_jns_brg!=''){
            $this->db->where('b.id_jenis', $id_jns_brg);
        }
        if($kode_barang!=''){
            $this->db->or_where('b.kode_barang',$kode_barang);
        }
        if($tgl_dari!='' && $tgl_sampai!=''){
            $this->db->where('tgl_masuk BETWEEN "'. date('Y-m-d', strtotime($tgl_dari)). '" and "'. date('Y-m-d', strtotime($tgl_sampai)).'"');
        }
        return $this->db->get('barang_masuk a')->result_array();
    }

    function barang_keluar($id_jns_brg, $tgl_dari, $tgl_sampai, $kode_barang){
        $this->db->select('a.tgl_keluar as tgl,b.kode_barang,b.nama_barang,
        b.harga,b.stok,a.jumlah, c.nama_pembeli, c.nohp_pembeli, c.alamat as alamtpem, a.harga_satuan, a.tot_harga, c.ket');
        $this->db->join('barang b','a.kode_barang=b.kode_barang');
        $this->db->join('transaksi c','a.id_transaksi=c.id_transaksi');
        if($id_jns_brg!=''){
            $this->db->where('b.id_jenis',$id_jns_brg);
        }
        if($kode_barang!=''){
            $this->db->or_where('b.kode_barang',$kode_barang);
        }
        if($tgl_dari!='' && $tgl_sampai!=''){
            $this->db->where('tgl_keluar BETWEEN "'. date('Y-m-d', strtotime($tgl_dari)). '" and "'. date('Y-m-d', strtotime($tgl_sampai)).'"');
        }
        return $this->db->get('barang_keluar a')->result_array();
    }



    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get jenis
    function by_jenis($limit, $start = 0)
    {
        $idjns = $this->input->get('id_jenis', TRUE);

        $this->db->where('id_jenis', $idjns);
        $this->db->order_by($this->id, $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function by_jenis_tot()
    {
        $idjns = $this->input->get('id_jenis', TRUE);

        $this->db->where('id_jenis', $idjns);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_barang', $q);
        $this->db->or_like('kode_barang', $q);
        $this->db->or_like('nama_barang', $q);
        $this->db->or_like('harga', $q);
        $this->db->or_like('stok', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_barang', $q);
        $this->db->or_like('kode_barang', $q);
        $this->db->or_like('nama_barang', $q);
        $this->db->or_like('harga', $q);
        $this->db->or_like('stok', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
        return true;
    }

}