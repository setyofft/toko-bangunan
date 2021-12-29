<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Merk_barang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Merk_barang_model');
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
            $config['base_url'] = base_url() . 'merk_barang/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'merk_barang/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'merk_barang/index.html';
            $config['first_url'] = base_url() . 'merk_barang/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Merk_barang_model->total_rows($q);
        $merk_barang = $this->Merk_barang_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'merk_barang_data' => $merk_barang,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'konten' => 'merk_barang/merk_barang_list',
            'judul' => 'Merk Barang',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Merk_barang_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_merk' => $row->id_merk,
		'merk_barang' => $row->merk_barang,
	    );
            $this->load->view('merk_barang/merk_barang_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('merk_barang'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('merk_barang/create_action'),
            'id_merk' => set_value('id_merk'),
            'merk_barang' => set_value('merk_barang'),
            'konten' => 'merk_barang/merk_barang_form',
            'judul' => 'Merk Barang',
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
		'merk_barang' => $this->input->post('merk_barang',TRUE),
	    );

            $this->Merk_barang_model->insert($data);
            $this->session->set_flashdata('message', 'Data Berhasil Di Tambahkan');
            redirect(site_url('merk_barang'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Merk_barang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('merk_barang/update_action'),
		'id_merk' => set_value('id_merk', $row->id_merk),
		'merk_barang' => set_value('merk_barang', $row->merk_barang),
        'konten' => 'merk_barang/merk_barang_form',
            'judul' => 'Merk Barang',
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Data Tidak Ada');
            redirect(site_url('merk_barang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_merk', TRUE));
        } else {
            $data = array(
		'merk_barang' => $this->input->post('merk_barang',TRUE),
	    );

            $this->Merk_barang_model->update($this->input->post('id_merk', TRUE), $data);
            $this->session->set_flashdata('message', 'Edit Data Berhasil Di Simpan');
            redirect(site_url('merk_barang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Merk_barang_model->get_by_id($id);

        if ($row) {
            $this->Merk_barang_model->delete($id);
            $this->session->set_flashdata('message', 'Data Berhasil Di Hapus.');
            // redirect(site_url('merk_barang'));
        } 
        // else {
        //     $this->session->set_flashdata('message', 'Record Not Found');
        //     redirect(site_url('merk_barang'));
        // }
        echo json_encode($data);
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('merk_barang', 'merk barang', 'trim|required');

	$this->form_validation->set_rules('id_merk', 'id_merk', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
