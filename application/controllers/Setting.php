<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Setting_model');
        $this->load->library('form_validation');
        if ($this->session->userdata('level') == "") {
            redirect('app/login');
        } 
    }

    public function index()
    {
        $row = $this->Setting_model->get_all();
        $data = array(
            'action' => site_url('setting/setSetting'),
            'id_setting' => set_value('id_setting', $row->id_setting),
            'nm_usaha' => set_value('nm_usaha', $row->nm_usaha),
            'notelp' => set_value('notelp', $row->notelp),
            'fax' => set_value('fax', $row->fax),
            'alamat' => set_value('alamat', $row->alamat),
            'button' => 'Simpan',
            'konten' => 'setting/setting',
            'judul' => 'Setting Aplikasi',
        );
        $this->load->view('v_index', $data);
    }
    
    public function setSetting() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nm_usaha' => $this->input->post('nm_usaha',TRUE),
                'notelp' => $this->input->post('notelp',TRUE),
                'fax' => $this->input->post('fax',TRUE),
                'alamat' => $this->input->post('alamat',TRUE),
            );

            $this->Setting_model->update($this->input->post('id_setting', TRUE), $data);
            $this->session->set_flashdata('message', 'Edit Data Berhasil Di Simpan');
            redirect(site_url('setting'));
        }
    }

    public function create() 
    {
        $row = $this->Setting_model->get_all();
        $data = array(
            'action' => site_url('setting/setSetting'),
            'id_setting' => set_value('id_setting', $row->id_setting),
            'nm_usaha' => set_value('nm_usaha', $row->nm_usaha),
            'notelp' => set_value('notelp', $row->notelp),
            'fax' => set_value('fax', $row->fax),
            'alamat' => set_value('alamat', $row->alamat),
            'button' => 'Simpan',
            'konten' => 'setting/setting',
            'judul' => 'Setting Aplikasi',
        );
        $this->load->view('v_index', $data);
    }
    
    public function _rules() 
    {
        $this->form_validation->set_rules('nm_usaha', 'nm_usaha', 'trim|required');
        $this->form_validation->set_rules('notelp', 'notelp', 'trim|required');
        $this->form_validation->set_rules('fax', 'fax', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');

        $this->form_validation->set_rules('id_setting', 'id_setting', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}