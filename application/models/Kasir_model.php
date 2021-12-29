<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kasir_model extends CI_Model
{

    public $table = 'barang';
    public $id = 'id_barang';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
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
    
    // insert data
    function addtransaksi()
    {
        $keybrg = $this->input->post('keybrg', TRUE);
        $kd_brg = $this->input->post('kd_brg', TRUE);
        $banyak = $this->input->post('banyak', TRUE);
        $harga = $this->input->post('harga', TRUE);
        $harga_satuan = $this->input->post('harga_satuan', TRUE);
        $totbyr = $this->input->post('totbyr', TRUE);
        $bayar = $this->input->post('bayar', TRUE);
        $sisa = $this->input->post('sisa', TRUE);
        $diskon = $this->input->post('diskon', TRUE);
        $nmpembeli = $this->input->post('nmpembeli', TRUE);
        $nohp = $this->input->post('nohp', TRUE);
        $alamat = $this->input->post('alamat', TRUE);
        $ket = $this->input->post('ket', TRUE);
        $tgl_keluar = date('Y-m-d');
        $stok = 0;

        $data = array(
            'kode_transaksi' => $keybrg,
            'tgl_transaksi' => $tgl_keluar,
            'total_harga' => $totbyr,
            'bayar' => $bayar,
            'sisa' => $sisa,
            'diskon' => $diskon,
            'nama_pembeli' => $nmpembeli,
            'nohp_pembeli' => $nohp,
            'alamat' => $alamat,
            'ket' => $ket
        );
        $ins = $this->db->insert('transaksi', $data);
        $id = $this->db->insert_id($ins);

        if($ins){
            for ($i=0;$i < count($kd_brg);$i++) {
                $brgkeuar = array(
                    'kode_barang' => $kd_brg[$i],
                    'tgl_keluar' => $tgl_keluar,
                    'harga_satuan' => $harga_satuan[$i],
                    'jumlah' => $banyak[$i],
                    'tot_harga' => $harga[$i],
                    'id_transaksi' => $id
                );
                $sql = $this->db->insert('barang_keluar', $brgkeuar);
                if($sql){
                    $this->db->select('stok');
                    $this->db->where('kode_barang', $kd_brg[$i]);
                    $barang = $this->db->get('barang')->row();
                    $valstok = $barang->stok;
                    $stok = intval($valstok) - intval($banyak[$i]);   
                    $update = array(
                        'stok' => $stok
                    );
                    $this->db->where('kode_barang', $kd_brg[$i]);
                    $this->db->update('barang', $update);
                }
            }
        }
        
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