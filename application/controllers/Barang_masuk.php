<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Barang_masuk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_masuk_model');
        $this->load->library('form_validation');
        if ($this->session->userdata('id_user') == "") {
            redirect('app/login');
        } 
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'barang_masuk/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'barang_masuk/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'barang_masuk/index.html';
            $config['first_url'] = base_url() . 'barang_masuk/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Barang_masuk_model->total_rows($q);
        $barang_masuk = $this->Barang_masuk_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'barang_masuk_data' => $barang_masuk,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'konten' => 'barang_masuk/barang_masuk_list',
            'judul' => 'Data Barang Masuk',
        );
        $this->load->view('v_index', $data);
    }

    public function create() 
    {
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('barang_masuk/create_action'),
            'id_barang_masuk' => set_value('id_barang_masuk'),
            'kode_barang' => set_value('kode_barang'),
            'kode_supplier' => set_value('kode_supplier'),
            'jumlah' => set_value('jumlah'),
            'harga' => set_value('harga'),
            'tgl_masuk' => set_value('tgl_masuk'),

            'konten' => 'barang_masuk/barang_masuk_form',
            'judul' => 'Data Barang Masuk',
	    );
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        }else{
            $data = array(
                'kode_barang' => $this->input->post('kode_barang',TRUE),
                'kode_supplier' => $this->input->post('kode_supplier',TRUE),
                'jumlah' => $this->input->post('jumlah',TRUE),
                'tgl_masuk' => $this->input->post('tgl_masuk',TRUE),
                'harga' => str_replace(".", "", $this->input->post('harga',TRUE)),
            );

            $this->Barang_masuk_model->tmbhstok();
            $this->Barang_masuk_model->insert($data);

            $this->session->set_flashdata('message', 'Data Berhasil Di Tambahkan');
            redirect(site_url('barang_masuk/create'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Barang_masuk_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Edit Data',
                'action' => site_url('barang_masuk/update_action'),
                'id_barang_masuk' => set_value('id_barang_masuk', $row->id_barang_masuk),
                'kode_barang' => set_value('kode_barang', $row->kode_barang),
                'kode_supplier' => set_value('kode_supplier', $row->kode_supplier),
                'jumlah' => set_value('jumlah', $row->jumlah),
                'harga' => set_value('harga', $row->harga),
                'tgl_masuk' => set_value('tgl_masuk', $row->tgl_masuk),

                'konten' => 'barang_masuk/barang_masuk_form',
                'judul' => 'Data Barang Masuk',
            );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Data Tidak Ada');
            redirect(site_url('barang_masuk'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_barang_masuk', TRUE));
        }else{
            $data = array(
                'kode_barang' => $this->input->post('kode_barang',TRUE),
                'kode_supplier' => $this->input->post('kode_supplier',TRUE),
                'jumlah' => $this->input->post('jumlah',TRUE),
                'tgl_masuk' => $this->input->post('tgl_masuk',TRUE),
                'harga' => str_replace(".", "", $this->input->post('harga',TRUE)),
            );

            $this->Barang_masuk_model->tmbhstok();
            
            $this->Barang_masuk_model->update($this->input->post('id_barang_masuk', TRUE), $data);
            $this->session->set_flashdata('message', 'Edit Data Berhasil Di Simpan');
            redirect(site_url('barang_masuk'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Barang_masuk_model->get_by_id($id);

        if ($row) {
            $this->Barang_masuk_model->delete($id);
            $this->session->set_flashdata('message', 'Data Berhasil Di Hapus.');
            // redirect(site_url('barang_masuk'));
        } 
        // else {
        //     $this->session->set_flashdata('message', 'Record Not Found');
        //     redirect(site_url('barang_masuk'));
        // }
        echo json_encode($data);
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_barang', 'kode barang', 'trim|required');
	// $this->form_validation->set_rules('kode_supplier', 'kode supplier', 'trim|required');
    $this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required');
    $this->form_validation->set_rules('tgl_masuk', 'tgl_masuk', 'trim|required');

	$this->form_validation->set_rules('id_barang_masuk', 'id_barang_masuk', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}