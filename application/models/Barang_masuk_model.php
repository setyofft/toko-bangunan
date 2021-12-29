<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Barang_masuk_model extends CI_Model
{

    public $table = 'barang_masuk';
    public $id = 'id_barang_masuk';
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

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->select('a.*, b.*, a.harga as hrg');
        $this->db->join('barang b', 'a.kode_barang=b.kode_barang');
        $this->db->order_by('a.'.$this->id, $this->order);
        $this->db->like('a.id_barang_masuk', $q);
        $this->db->or_like('a.kode_barang', $q);
        $this->db->or_like('a.kode_supplier', $q);
        $this->db->or_like('b.nama_barang', $q);
        $this->db->or_like('a.jumlah', $q);
        $this->db->or_like('a.harga', $q);
        $this->db->from($this->table.' a');
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('a.*, b.*, a.harga as hrg');
        $this->db->join('barang b', 'a.kode_barang=b.kode_barang');
        $this->db->order_by('a.'.$this->id, $this->order);
        $this->db->like('a.id_barang_masuk', $q);
        $this->db->or_like('a.kode_barang', $q);
        $this->db->or_like('a.kode_supplier', $q);
        $this->db->or_like('b.nama_barang', $q);
        $this->db->or_like('a.jumlah', $q);
        $this->db->or_like('a.harga', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table.' a')->result();
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
        $ambil=0;
        $this->db->where('id_barang_masuk', $id);
        $que = $this->db->get('barang_masuk');
        if($que->num_rows() <> 0){       
            $data = $que->row();
            $jml = $data->jumlah;
            $kodebrg = $data->kode_barang;

            $this->db->where('kode_barang', $kodebrg);
            $que1 = $this->db->get('barang');
            if($que1->num_rows() <> 0){ 
                $data1 = $que1->row();
                $stok = $data1->stok;
                $ambil = intval($stok) - intval($jml); 
            }
            $array =  array(
                'stok' => $ambil,
            );

            $this->db->where('kode_barang', $kodebrg);
            $this->db->update('barang', $array);
        }
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function tmbhstok()
    {   
        $kdbrg =  $this->input->post('kode_barang',TRUE);
        $jml = $this->input->post('jumlah',TRUE);
        $jml_awl = $this->input->post('jml_awal', TRUE);
        $ambil=0;
        $val=0;
        $sts='';

        if($jml_awl!=''){
            if(intval($jml) >= intval($jml_awl)){
                $sts = 'lbh';
                $val = intval($jml) - intval($jml_awl);
            }else if(intval($jml) <= intval($jml_awl)){
                $sts = 'krg';
                $val = intval($jml_awl) - intval($jml);
            }
        }

        $this->db->where('kode_barang', $kdbrg);
        $que = $this->db->get('barang');
        if($que->num_rows() <> 0){       
            $data = $que->row();
            if($sts =='krg'){
                $ambil = intval($data->stok) - intval($val); 
            }else if($sts == 'lbh'){
                $ambil = intval($data->stok) + intval($val); 
            }else{
                $ambil = intval($data->stok) + intval($jml);
            }          
        }

        if($this->input->post('harga',TRUE) == 0){
            $array =  array(
                'stok' => $ambil,
            );
        }else{
            $array =  array(
                'stok' => $ambil,
                'harga' => str_replace(".", "", $this->input->post('harga',TRUE)),
            );
        }
  
        $this->db->where('kode_barang', $kdbrg);
        $this->db->update('barang', $array);
    }

}
