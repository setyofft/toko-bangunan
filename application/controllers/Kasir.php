<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kasir extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kasir_model');
        $this->load->model('No_urut');
        $this->load->library('form_validation');
        if ($this->session->userdata('level') == "") {
            redirect('app/login');
        } 
    }

    public function index()
    {
        $barang = $this->Kasir_model->get_all();
        $nourut = $this->No_urut->buat_kode_transaksi();
        $data = array(
            'barang' => $barang,
            'nourut' => $nourut,
            'konten' => 'kasir/view_kasir',
            'judul' => 'Sistem Kasir',
        );
        $this->load->view('v_index', $data);
    }
    
    public function getId() 
    {
        $id = $this->input->post('id', TRUE);
        $data = $this->Kasir_model->get_by_id($id);
        echo json_encode($data);
    }

    public function addtransaksi(){
        $data = $this->Kasir_model->addtransaksi();    
        echo json_encode($data);
    }

    public function batalId() 
    {
        $id = $this->input->post('id', TRUE);
        $this->db->where('id_barang', $id);
        $sql = $this->db->delete('barang');
        if($sql){
            $data['sukses'] = 1;
        }else{
            $data['error'] = 0;
        }
        echo json_encode($data);
    }

    public function list_transaksi_now(){
        $tgl = date('Y-m-d');
        $this->db->where('tgl_transaksi', $tgl); 
        $this->db->or_where('ket !=', 'Lunas');
        $this->db->order_by('id_transaksi','DESC');
        $sql = $this->db->get('transaksi')->result_array();
        echo json_encode($sql);
    }

    public function detail_nota(){
        $id = $this->input->post('id', TRUE);

        $this->db->select('a.*, b.*');
        $this->db->join('view_transaksi b','a.id_transaksi=b.id_transaksi');
        $this->db->where('a.id_transaksi', $id);
        $this->db->order_by('a.id_transaksi','DESC');
        $sql = $this->db->get('transaksi a')->result_array();
        echo json_encode($sql);
    }

    public function lunasi(){
        $id = $this->input->post('id', TRUE);
        $sql = '';
        $que = $this->db->query("select sisa, bayar from transaksi where id_transaksi=".$id)->row_array();
        if($que){
            $sisa = abs($que['sisa']);
            $bayar = abs($que['bayar']);

            $hsl = $bayar + $sisa;
            $field = array(
                'sisa' => 0,
                'bayar' => $hsl,
                'ket' => 'Lunas'
            );
            $this->db->where('id_transaksi', $id);
            $sql = $this->db->update('transaksi', $field);
        }
        echo json_encode($sql);
    }

}

