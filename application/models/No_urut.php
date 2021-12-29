<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class No_urut extends CI_Model
{

    function buat_kode_barang()   {    
      $this->db->select('RIGHT(barang.id_barang,4) as kode', FALSE);
      $this->db->order_by('id_barang','DESC');    
      $this->db->limit(1);     
      $query = $this->db->get('barang');      //cek dulu apakah ada sudah ada kode di tabel.    
      if($query->num_rows() <> 0){       
       //jika kode ternyata sudah ada.      
       $data = $query->row();      
       $kode = intval($data->kode) + 1;     
      }
      else{       
       //jika kode belum ada      
       $kode = 1;     
      }
      $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);    
      $kodejadi = "BRG".$kodemax;     
      return $kodejadi;  
     }

     function buat_kode_penjualan()   {    
      $this->db->select('RIGHT(transaksi.id_transaksi,5) as kode', FALSE);
      $this->db->order_by('id_transaksi','DESC');    
      $this->db->limit(1);     
      $query = $this->db->get('transaksi');      //cek dulu apakah ada sudah ada kode di tabel.    
      if($query->num_rows() <> 0){       
       //jika kode ternyata sudah ada.      
       $data = $query->row();      
       $kode = intval($data->kode) + 1;     
      }
      else{       
       //jika kode belum ada      
       $kode = 1;     
      }
      $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT);    
      $kodejadi = "TR".$kodemax;     
      return $kodejadi;  
     }

     function buat_kode_warna()   {    
        $this->db->select('RIGHT(material_Warna.id_warna,4) as kode', FALSE);
        $this->db->order_by('id_warna','DESC');    
        $this->db->limit(1);     
        $query = $this->db->get('material_Warna');  
        if($query->num_rows() <> 0){       
           
         $data = $query->row();      
         $kode = intval($data->kode) + 1;     
        }
        else{         
         $kode = 1;     
        }
        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);    
        $kodejadi = "WRN".$kodemax;     
        return $kodejadi;  
    }

    function buat_kode_supplier()   {    
        $this->db->select('RIGHT(supplier.id_supplier,4) as kode', FALSE);
        $this->db->order_by('id_supplier','DESC');    
        $this->db->limit(1);     
        $query = $this->db->get('supplier');  
        if($query->num_rows() <> 0){       
           
         $data = $query->row();      
         $kode = intval($data->kode) + 1;     
        }
        else{         
         $kode = 1;     
        }
        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);    
        $kodejadi = "SP".$kodemax;     
        return $kodejadi;  
    }

    function buat_kode_transaksi()   {    
        $this->db->select('RIGHT(a.id_transaksi,4) as kode', FALSE);
        $this->db->order_by('a.id_transaksi','DESC');    
        $this->db->limit(1);     
        $query = $this->db->get('transaksi a');  
        if($query->num_rows() <> 0){       
           
         $data = $query->row();      
         $kode = intval($data->kode) + 1;     
        }
        else{         
         $kode = 1;     
        }
        $kodemax = str_pad($kode, 7, "0", STR_PAD_LEFT);    
        $kodejadi = "TR".$kodemax;     
        return $kodejadi;  
    }

}
