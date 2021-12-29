<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model');
        $this->load->library('form_validation');
        if ($this->session->userdata('level') == "") {
            redirect('app/login');
        } 
    }

    public function index()
    {
        $data = array(
            'konten' => 'laporan/laporan',
            'judul' => 'Data Laporan',
        );
        $this->load->view('v_index', $data);
    }

    public function load_transaksi(){
        $jns_transaksi =$this->input->post('jns_tran',TRUE);
        $id_jns_brg =$this->input->post('id_jns_brg',TRUE);
        $kode_barang =$this->input->post('kode_barang',TRUE);
        $tgl_dari =$this->input->post('tgl_dari',TRUE);
        $tgl_sampai =$this->input->post('tgl_sampai',TRUE);

        if($jns_transaksi=='barang_masuk'){
            $data = $this->Laporan_model->barang_masuk($id_jns_brg, $tgl_dari, $tgl_sampai, $kode_barang);
        }else if($jns_transaksi=='barang_keluar'){
            $data = $this->Laporan_model->barang_keluar($id_jns_brg, $tgl_dari, $tgl_sampai, $kode_barang);
        }

        echo json_encode($data);
    }

    
	public function export_pdf(){
        $mpdf = new \Mpdf\Mpdf();

		$jns_transaksi = $this->uri->segment(3);
        $id_jns_brg = $this->uri->segment(4);
        $tgl_dari = $this->uri->segment(5);
        $tgl_sampai = $this->uri->segment(6);
        $kode_barang = $this->uri->segment(7);
        
        if($jns_transaksi=='barang_masuk'){
            $jdl = 'Transaksi Masuk';

            $this->db->select('a.tgl_masuk as tgl,b.kode_barang,b.nama_barang,
            b.harga,b.stok,a.jumlah, a.harga as hrg_perubahan');
            $this->db->join('barang b','a.kode_barang=b.kode_barang');
            if($id_jns_brg!='kosong'){
                $this->db->where('b.id_jenis', $id_jns_brg);
            }
            if($kode_barang!='kosong'){
                $this->db->or_where('b.kode_barang',$kode_barang);
            }
            if($tgl_dari!='kosong' && $tgl_sampai!='kosong'){
                $this->db->where('tgl_masuk BETWEEN "'. date('Y-m-d', strtotime($tgl_dari)). '" and "'. date('Y-m-d', strtotime($tgl_sampai)).'"');
            }
            $que =  $this->db->get('barang_masuk a')->result_array();             
        }else if($jns_transaksi=='barang_keluar'){
            $jdl = 'Transaksi Keluar';

            $this->db->select('a.tgl_keluar as tgl,b.kode_barang,b.nama_barang,
            b.harga,b.stok,a.jumlah');
            $this->db->join('barang b','a.kode_barang=b.kode_barang');
            if($id_jns_brg!='kosong'){
                $this->db->where('b.id_jenis',$id_jns_brg);
            }
            if($kode_barang!='kosong'){
                $this->db->or_where('b.kode_barang',$kode_barang);
            }
            if($tgl_dari!='kosong' && $tgl_sampai!='kosong'){
                $this->db->where('tgl_keluar BETWEEN "'. date('Y-m-d', strtotime($tgl_dari)). '" and "'. date('Y-m-d', strtotime($tgl_sampai)).'"');
            }
            $que =  $this->db->get('barang_keluar a')->result_array(); 
        }

        $ttl = 'Laporan '.$jdl.' Dari '.$tgl_dari.' Sampai '.$tgl_sampai;
        $mpdf->SetTitle('Laporan '.$jdl.' Dari '.date('d-m-Y', strtotime($tgl_dari)).' Sampai '.date('d-m-Y', strtotime($tgl_sampai)));
        
        // design
        $html .='<body style="font-family: monospace; font-size: 10pt;">';
        $html .='<h3 align="center" style="margin:5px">'.strtoupper('Laporan '.$jdl).'</h3>';
        $html .='<h3 align="center" style="margin:5px">'.strtoupper('tb a perkasa').'</h3>';
        
        $html .='<table style="margin-top:20px">';
        $html .='<tr>
                    <td><b>Tanggal</b> :</td>
                    <td>'.date('d-m-Y', strtotime($tgl_dari)).' sampai '.date('d-m-Y', strtotime($tgl_sampai)).'</td>
                </tr>';
        $html .='</table>';
        
        $html .='<table style="margin-top:10px;width:100%">';
        if($jns_transaksi=='barang_masuk'){
            $html .='<tr style="background:#4FC1E9;">
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">No</th>
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">Nama Barang</th>
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">Stok</th>
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">Stok Masuk</th>
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">Harga</th>
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">Perubahan Harga</th>
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">Tanggal Masuk</th>
            </tr>';
        }else if($jns_transaksi=='barang_keluar'){
            $html .='<tr style="background:#4FC1E9;">
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">No</th>
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">Nama Barang</th>
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">Stok</th>
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">Jumlah keluar</th>
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">Harga</th>
                <th style="color:#fff;border:1px solid #4FC1E9;padding:10px">Tanggal Keluar</th>
            </tr>';
        }

        $no=1;
        $jumstok=0;
        $stok=0;
        $tothrg = 0;
        $allhrg = 0;
        $hrg_r=0;
        foreach($que as $valmsk){
            $jumstok += intval($valmsk['stok']);
            $stok += intval($valmsk['jumlah']);
            $tothrg += intval($valmsk['harga']);
            $allhrg += intval($valmsk['harga']) * intval($valmsk['jumlah']);
            $hrg_r += intval($valmsk['hrg_perubahan']);
            if($jns_transaksi=='barang_masuk'){
                $html .='<tr>
                    <td style="padding:10px;text-align:center;border-right:1px solid #000;border-bottom:1px solid #000">'.$no++.'</td>
                    <td style="padding:10px;text-align:left;border-right:1px solid #000;border-bottom:1px solid #000"><b>'.$valmsk['kode_barang'].'</b><br/>'.$valmsk['nama_barang'].'</td>
                    <td style="padding:10px;text-align:center;border-right:1px solid #000;border-bottom:1px solid #000">'.$valmsk['stok'].'</td>
                    <td style="padding:10px;text-align:center;border-right:1px solid #000;border-bottom:1px solid #000">'.$valmsk['jumlah'].'</td>
                    <td style="padding:10px;width:120px;text-align:right;border-right:1px solid #000;border-bottom:1px solid #000">> '.number_format($valmsk['harga'],0,',','.').'<br/>'.number_format(intval($valmsk['harga'])*intval($valmsk['jumlah']),0,',','.').'</td>
                    <td style="padding:10px;text-align:right;border-right:1px solid #000;border-bottom:1px solid #000">'.$valmsk['hrg_perubahan'].'</td>
                    <td style="padding:10px;text-align:center;border-bottom:1px solid #000">'.$valmsk['tgl'].'</td>
                </tr>';
            }else if($jns_transaksi=='barang_keluar'){
                $html .='<tr>
                    <td style="padding:10px;text-align:center;border-right:1px solid #000;border-bottom:1px solid #000">'.$no++.'</td>
                    <td style="padding:10px;text-align:left;border-right:1px solid #000;border-bottom:1px solid #000"><b>'.$valmsk['kode_barang'].'</b><br/>'.$valmsk['nama_barang'].'</td>
                    <td style="padding:10px;text-align:center;border-right:1px solid #000;border-bottom:1px solid #000">'.$valmsk['stok'].'</td>
                    <td style="padding:10px;text-align:center;border-right:1px solid #000;border-bottom:1px solid #000">'.$valmsk['jumlah'].'</td>
                    <td style="padding:10px;width:200px;text-align:right;border-right:1px solid #000;border-bottom:1px solid #000">> '.number_format($valmsk['harga'],0,',','.').'<br/>'.number_format(intval($valmsk['harga'])*intval($valmsk['jumlah']),0,',','.').'</td>
                    <td style="padding:10px;text-align:center;border-bottom:1px solid #000">'.$valmsk['tgl'].'</td>
                </tr>';
            }
        }

        if($jns_transaksi=='barang_masuk'){
            $html .='<tr>
                <td colspan="2" style="border-right:1px solid #000;border-bottom:1px solid #000"><b>Total</b></td>
                <td style="padding:10px;text-align:center;border-right:1px solid #000;border-bottom:1px solid #000">'.$jumstok.'</td>
                <td style="padding:10px;text-align:center;border-right:1px solid #000;border-bottom:1px solid #000">'.$stok.'</td>
                <td style="padding:10px;text-align:right;border-right:1px solid #000;border-bottom:1px solid #000">> '.number_format($tothrg,0,',','.').'<br/>'.number_format($allhrg,0,',','.').'</td>
                <td style="padding:10px;text-align:right;border-right:1px solid #000;border-bottom:1px solid #000">'.number_format($hrg_r,0,',','.').'</td>
                <td style="padding:10px;border-bottom:1px solid #000"></td>
            </tr>';
        }else if($jns_transaksi=='barang_keluar'){
            $html .='<tr>
                <td colspan="2" style="border-right:1px solid #000;border-bottom:1px solid #000"><b>Total</b></td>
                <td style="padding:10px;text-align:center;border-right:1px solid #000;border-bottom:1px solid #000">'.$jumstok.'</td>
                <td style="padding:10px;text-align:center;border-right:1px solid #000;border-bottom:1px solid #000">'.$stok.'</td>
                <td style="padding:10px;text-align:right;border-right:1px solid #000;border-bottom:1px solid #000">> '.number_format($tothrg,0,',','.').'<br/>'.number_format($allhrg,0,',','.').'</td>
                <td style="padding:10px;border-bottom:1px solid #000"></td>
            </tr>';
        }
        
        $html .='</table>';
        $html .='</body>';
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        // $mpdf->Output('./data/'.$ttl.'.pdf','F');
	}

}

