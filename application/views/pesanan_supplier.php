<div class="row">
	
	<div class="col-md-4"></div>
	<div class="col-md-4"></div><br><br><br>
	<div class="col-md-12">
		<table class="table table-bordered" style="margin-bottom: 10px" id="example">
			<thead>
				<tr>
					<th>No.</th>
					<th>Kode Transaksi</th>
					<th>Tanggal Transaksi</th>
					<th>Total Bayar</th>
					<th>Pilihan</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$id = $this->session->userdata('id_user');
				$sql = $this->db->query("SELECT t.kode_transaksi, t.tgl_transaksi, t.total_harga FROM transaksi as t, detail_transaksi as d, barang as b where t.kode_transaksi=d.kode_transaksi and d.kode_barang=b.kode_barang and b.kode_supplier='$id' group by t.kode_transaksi order by t.kode_transaksi");
				$no = 1;
				foreach ($sql->result() as $row) {
				 ?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $row->kode_transaksi; ?></td>
					
					<td><?php echo $row->tgl_transaksi; ?></td>
					<td><?php echo number_format($row->total_harga); ?></td>
					<td>
						<a href="app/detail_penjualan/<?php echo $row->kode_transaksi ?>" class="btn btn-info btn-sm">detail</a>
						<a href="app/hapus_penjualan/<?php echo $row->kode_transaksi ?>" class="btn btn-danger btn-sm" onclick="javasciprt: return confirm('Are You Sure ?')">hapus</a>
						<a href="app/cetak_penjualan/<?php echo $row->kode_transaksi ?>" target="_blank" class="btn btn-success btn-sm">cetak</a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>