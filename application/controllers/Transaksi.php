<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi extends CI_Controller
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
            'konten' => 'kasir/kasir',
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

}

