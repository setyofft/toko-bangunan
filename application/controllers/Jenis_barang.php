<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jenis_barang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Jenis_barang_model');
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
            $config['base_url'] = base_url() . 'jenis_barang/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'jenis_barang/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'jenis_barang/index.html';
            $config['first_url'] = base_url() . 'jenis_barang/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Jenis_barang_model->total_rows($q);
        $jenis_barang = $this->Jenis_barang_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'jenis_barang_data' => $jenis_barang,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'konten' => 'jenis_barang/jenis_barang_list',
            'judul' => 'Jenis Barang',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Jenis_barang_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_jenis' => $row->id_jenis,
                'jenis_barang' => $row->jenis_barang,
            );
            $this->load->view('jenis_barang/jenis_barang_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jenis_barang'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('jenis_barang/create_action'),
            'id_jenis' => set_value('id_jenis'),
            'jenis_barang' => set_value('jenis_barang'),
            'konten' => 'jenis_barang/jenis_barang_form',
            'judul' => 'Jenis Barang',
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
                'jenis_barang' => $this->input->post('jenis_barang',TRUE),
            );

            $this->Jenis_barang_model->insert($data);
            $this->session->set_flashdata('message', 'Data Berhasil Di Tambahkan');
            redirect(site_url('jenis_barang'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Jenis_barang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Edit Data',
                'action' => site_url('jenis_barang/update_action'),
                'id_jenis' => set_value('id_jenis', $row->id_jenis),
                'jenis_barang' => set_value('jenis_barang', $row->jenis_barang),
                'konten' => 'jenis_barang/jenis_barang_form',
                'judul' => 'Jenis Barang',
            );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Data Tidak Ada');
            redirect(site_url('jenis_barang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_jenis', TRUE));
        } else {
            $data = array(
                'jenis_barang' => $this->input->post('jenis_barang',TRUE),
            );

            $this->Jenis_barang_model->update($this->input->post('id_jenis', TRUE), $data);
            $this->session->set_flashdata('message', 'Edit Data Berhasil Di Simpan');
            redirect(site_url('jenis_barang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Jenis_barang_model->get_by_id($id);

        if ($row) {
            $this->Jenis_barang_model->delete($id);
            $this->session->set_flashdata('message', 'Data Berhasil Di Hapus.');
            // redirect(site_url('jenis_barang'));
        } 
        // else {
        //     $this->session->set_flashdata('message', 'Record Not Found');
        //     redirect(site_url('jenis_barang'));
        // }
        echo json_encode($data);
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('jenis_barang', 'jenis barang', 'trim|required');

	$this->form_validation->set_rules('id_jenis', 'id_jenis', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

