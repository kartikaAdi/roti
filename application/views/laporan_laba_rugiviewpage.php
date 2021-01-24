
		
		<section class="content-header" style="color:white">
          <h1>
            <?= $pageTitle?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?= site_url();?>admin" style="color:white"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li><a href="<?= site_url();?><?= $breadcrumbLink?>" style="color:white"><?= $breadcrumbTitle?></a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">
				  	
					<a href="<?= site_url();?><?= $saveLink?>">
					
					  <!-- <button class="btn btn-success btn-flat">
						<i class="fa fa-plus"></i>&nbsp; Add new data
					</button> -->
					</a>
				
					</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
				<form class="form-horizontal" class="form-control" id="formfield" enctype="multipart/form-data" data-toggle="validator" role="form" method="GET" action="" >
			
								  
			  
			  <div class="form-group">
			  <div class="col-sm-2">
				  	<label class="form-control">Periode</label>
				</div>
				<div class="col-sm-2">
				  	<select class='form-control' name="bulan">
					  <?php
					  $bulan_terpilih = [];
					  $list_bulan = [['Januari','01'],['Februari','02'],['Maret','03'],['April','04'],['Mei','05'],['Juni','06'],['Juli','07'],['Agustus','08'],['September','09'],['Oktober','10'],['November','11'],['Desember','12']];
					  foreach ($list_bulan as $bln) {
						  if($bln[1] == $bulan){
							echo '<option selected value="'.$bln[1].'">'.$bln[0].'</option>';
							$bulan_terpilih = $bln;
						  }
							else
							echo '<option value="'.$bln[1].'">'.$bln[0].'</option>';
					  }
					?>
					</select>
				</div>
			 	 <div class="col-sm-2">
				  	<select class='form-control' name="tahun">
					  <?php
					  $list_tahun = ['2020','2021'];
					  $tahun_terpilih = 0;
					  foreach ($list_tahun as $thn) {
						  if($thn == $tahun){
							  $tahun_terpilih = $tahun;
							echo '<option selected value="'.$thn.'">'.$thn.'</option>';
						  }
							else
							echo '<option value="'.$thn.'">'.$thn.'</option>';
					  }
					?>
					</select>
				</div>
				<div class="col-sm-6">
					<button type="submit" class="btn btn-success" >Hitung Laba Rugi</button> 
				</div>
			  </div>
			</form>
			
			<canvas style="background-color:white" id="myChart" width="400" height="400"></canvas>
				<table class="table table-bordered " style="background-color:white" >
				
				<?php
					?>
						<thead>
							<tr>
								<!-- <th class="text-center">No.</th> -->
							
								<!-- <th class="text-center">Option</th> -->
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="2">Hasil Penjualan</td><td></td>
							</tr>
							<tr>
								<td></td>
								<td>Penjualan</td>
								<td class="text-right"><?php echo "Rp " . number_format($data[4],2,',','.'); ?></td>
							</tr>
							<tr>
								<td colspan="2">Harga Pokok Produksi/Penjualan</td>
								<td class="text-right"></td>
							</tr>
							<tr>
								<td></td>
								<td>Biaya Bahan Baku</td>
								<td class="text-right"><?php echo "Rp " . number_format($data[0],2,',','.'); ?></td>
							</tr>
							<tr>
								<td></td>
								<td>Biaya Tenaga Kerja</td>
								<td class="text-right"><?php echo "Rp " . number_format($data[1],2,',','.'); ?></td>
							</tr>
							<tr>
								<td></td>
								<td>Biaya Overhead Tetap</td>
								<td class="text-right"><?php echo "Rp " . number_format($data[2],2,',','.'); ?></td>
							</tr>
							<tr>
								<td></td>
								<td>Biaya Overhead Variabel</td>
								<td class="text-right"><?php echo "Rp " . number_format($data[3],2,',','.'); ?></td>
							</tr>
							<tr style="border-top: 2px solid">
								<?php if ($data[4]-$data[0]-$data[1]-$data[2]-$data[3] < 0) {?>
									<td colspan="2">Rugi</td>
								<?php } else {?>
									<td colspan="2">Laba</td>
								<?php }?>
								<td class="text-right"><?php echo "Rp " . number_format($data[4]-$data[0]-$data[1]-$data[2]-$data[3],2,',','.'); ?></td>
							</tr>
							
						</tbody>
			
				</table>
				<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
				<script>
				var ctx = document.getElementById('myChart').getContext('2d');
				var myChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: ["BBB", "BTK", "BOPV", "BOPT", "Penjualan", "Laba/Rugi"],
						datasets: [{
							label:'Data Laporan',
							data: [<?= $data[0]?>, <?= $data[1]?>, <?= $data[2]?>, <?= $data[3]?>, <?= $data[4]?>, <?=$data[4]-$data[0]-$data[1]-$data[2]-$data[3]?>],
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							],
							borderColor: [
								'rgba(255, 99, 132, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						title: {
							display: true,
							text: 'Bulan <?= $bulan_terpilih[0] ?> Tahun <?= $tahun_terpilih ?>'
						}
					}
				});
				</script>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


