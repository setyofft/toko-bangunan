<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Barang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model');
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
            $config['base_url'] = base_url() . 'barang/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'barang/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'barang/index.html';
            $config['first_url'] = base_url() . 'barang/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Barang_model->total_rows($q);
        $barang = $this->Barang_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'barang_data' => $barang,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'konten' => 'barang/barang_list',
            'judul' => 'Data Barang',
        );
        $this->load->view('v_index', $data);
    }

    public function create() 
    {
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('barang/create_action'),
            'id_barang' => set_value('id_barang'),
            'kode_barang' => $this->No_urut->buat_kode_barang(),
            'nama_barang' => set_value('nama_barang'),
            'harga' => set_value('harga'),
            'stok' => set_value('stok'),
            'id_jenis' => set_value('id_jenis'),
            'id_merk' => set_value('id_merk'),
            'id_warna' => set_value('id_warna'),
            'kode_supplier' => set_value('kode_supplier'),
            'berat' => set_value('berat'),
            'keterangan' => set_value('keterangan'),
            'ukuran' => set_value('ukuran'),

            'konten' => 'barang/barang_form',
            'judul' => 'Data Barang',
	    );
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

        // $nmfile = "barang_".time();
        // $config['upload_path'] = './image/barang';
        // $config['allowed_types'] = 'jpg|png';
        // $config['max_size'] = '20000';
        // $config['file_name'] = $nmfile;

        // $this->load->library('upload', $config);
        // $this->upload->do_upload('foto_barang');
        // $result1 = $this->upload->data();
        // $result = array('gambar'=>$result1);
        // $dfile = $result['gambar']['file_name'];

            $data = array(
                'kode_barang' => $this->input->post('kode_barang',TRUE),
                'nama_barang' => $this->input->post('nama_barang',TRUE),
                'harga' => str_replace(".", "", $this->input->post('harga',TRUE)),
                'stok' => $this->input->post('stok',TRUE),
                'id_jenis' => $this->input->post('id_jenis',TRUE),
                'id_merk' => $this->input->post('id_merk',TRUE),
                'id_warna' => $this->input->post('id_warna',TRUE),
                'kode_supplier' => $this->input->post('kode_supplier',TRUE),
                'berat' => $this->input->post('berat',TRUE),
                'keterangan' => $this->input->post('keterangan',TRUE),
                'ukuran' => $this->input->post('ukuran',TRUE),
            );

            $this->Barang_model->insert($data);
            $this->session->set_flashdata('message', 'Data Berhasil Di Tambahkan');
            redirect(site_url('barang/create'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Barang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Edit Data',
                'action' => site_url('barang/update_action'),
                'id_barang' => set_value('id_barang', $row->id_barang),
                'kode_barang' => set_value('kode_barang', $row->kode_barang),
                'nama_barang' => set_value('nama_barang', $row->nama_barang),
                'harga' => set_value('harga', $row->harga),
                'stok' => set_value('stok', $row->stok),
                'id_jenis' => set_value('id_jenis', $row->id_jenis),
                'id_merk' => set_value('id_merk', $row->id_merk),
                'id_warna' => set_value('id_warna', $row->id_warna),
                'kode_supplier' => set_value('kode_supplier', $row->kode_supplier),
                'berat' => set_value('berat', $row->berat),
                'keterangan' => set_value('keterangan', $row->keterangan),
                'ukuran' => set_value('ukuran', $row->ukuran),

                'konten' => 'barang/barang_form',
                'judul' => 'Data Barang',
            );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Data Tidak Ada');
            redirect(site_url('barang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_barang', TRUE));
        } else {
            $data = array(
                'kode_barang' => $this->input->post('kode_barang',TRUE),
                'nama_barang' => $this->input->post('nama_barang',TRUE),
                'harga' => str_replace(".", "", $this->input->post('harga',TRUE)),
                'stok' => $this->input->post('stok',TRUE),
                'id_jenis' => $this->input->post('id_jenis',TRUE),
                'id_merk' => $this->input->post('id_merk',TRUE),
                'id_warna' => $this->input->post('id_warna',TRUE),
                'kode_supplier' => $this->input->post('kode_supplier',TRUE),
                'berat' => $this->input->post('berat',TRUE),
                'ukuran' => $this->input->post('ukuran',TRUE),
                'keterangan' => $this->input->post('keterangan',TRUE),
             );

            $this->Barang_model->update($this->input->post('id_barang', TRUE), $data);
            $this->session->set_flashdata('message', 'Edit Data Berhasil Di Simpan');
            redirect(site_url('barang'));           
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Barang_model->get_by_id($id);

        if ($row) {
            $data = $this->Barang_model->delete($id);
            $this->session->set_flashdata('message', 'Data Berhasil Di Hapus.');
        } 
        echo json_encode($data);
    }

    public function Byjnsbrg() 
    {
        $idjns = $this->input->post('jns_brg', TRUE);

        $this->db->where('id_jenis', $idjns);
        $data = $this->db->get('barang')->result();
        echo json_encode($data);
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_barang', 'kode barang', 'trim|required');
	$this->form_validation->set_rules('nama_barang', 'nama barang', 'trim|required');
	$this->form_validation->set_rules('harga', 'harga', 'trim|required');
	$this->form_validation->set_rules('stok', 'stok', 'trim|required');

	$this->form_validation->set_rules('id_barang', 'id_barang', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

