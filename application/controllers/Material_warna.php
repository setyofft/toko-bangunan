<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material_warna extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Material_warna_model');
        $this->load->model('No_urut');
        $this->load->library('form_validation');
        if ($this->session->userdata('level') == "") {
            redirect('app/login');
        } 
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'material_warna/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'material_warna/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'material_warna/index.html';
            $config['first_url'] = base_url() . 'material_warna/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Material_warna_model->total_rows($q);
        $material_warna = $this->Material_warna_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'material_warna_data' => $material_warna,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'konten' => 'material_warna/material_warna_list',
            'judul' => 'Material Warna',
        );
        $this->load->view('v_index', $data);
    }

    public function create() 
    {
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('material_warna/create_action'),
            'id_Warna' => set_value('id_warna'),
            'kode_warna' => $this->No_urut->buat_kode_warna(),
            'warna' => set_value('warna'),
            
            'konten' => 'material_warna/material_warna_form',
            'judul' => 'Data Material Warna',
	    );
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

        $data = array(
            'kode_warna' => $this->input->post('kode_warna',TRUE),
            'warna' => $this->input->post('warna',TRUE),
	    );

        $this->Material_warna_model->insert($data);
        $this->session->set_flashdata('message', 'Data Berhasil Di Tambahkan');
        redirect(site_url('material_warna'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Material_warna_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Edit Data',
                'action' => site_url('material_warna/update_action'),
                'id_warna' => set_value('id_warna', $row->id_warna),
                'kode_warna' => set_value('kode_warna', $row->kode_warna),
                'warna' => set_value('warna', $row->warna),
                
                'konten' => 'material_warna/material_warna_form',
                'judul' => 'Data Material Warna',
	        );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Edit Data Berhasil Di Simpan');
            redirect(site_url('material_warna'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_barang', TRUE));
        } else {
            $data = array(
                'kode_warna' => $this->input->post('kode_warna',TRUE),
                'warna' => $this->input->post('warna',TRUE),
            );

            $this->Material_warna_model->update($this->input->post('id_warna', TRUE), $data);
            $this->session->set_flashdata('message', 'Edit Data Berhasil Di Simpan');
            redirect(site_url('material_warna'));           
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Material_warna_model->get_by_id($id);

        if ($row) {
            $data = $this->Material_warna_model->delete($id);
            $this->session->set_flashdata('message', 'Data Berhasil Di Hapus.');
        } 
        echo json_encode($data);
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('warna', 'warna', 'trim|required');

	$this->form_validation->set_rules('id_warna', 'id_warna', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

