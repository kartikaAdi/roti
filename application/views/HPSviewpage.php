
		
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
				  	<label class="form-control">ID Produksi</label>
				</div>
			 	 <div class="col-sm-2">
				  	<select class='form-control' name="id_produksi">
					  <?php
					  foreach ($list_produksi as $prod) {
						  if($prod == $id_produksi)
							echo '<option selected value="'.$prod[0].'">'.$prod[0].'</option>';
							else
							echo '<option value="'.$prod[0].'">'.$prod[0].'</option>';
					  }
					?>
					</select>
				</div>
				<div class="col-sm-8">
					<button type="submit" class="btn btn-success" >Hitung HPS</button> 
				</div>
			  </div>
			</form>
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
							<tr style="border-bottom:2px solid black">
								<td colspan=2>Total Produksi</td>
								<td class="text-right"><?php 
								$jml_prod = 0;
								foreach($list_produksi as $prod){
									if($prod[0]==$id_produksi){
										echo $prod[1];
										$jml_prod = $prod[1];
									}
								}
								?> Buah</td>
							</tr>
							<tr>
								<td colspan=2>Biaya Bahan Baku</td>
								<td class="text-right"></td>
							</tr>
							<?php foreach($list_data[0] as $row){?>
							<tr>
								<td></td>
								<td><?= $row->nama_bahan ?></td>
								<td class="text-right"><?php echo "Rp " . number_format($row->h_beli*$row->jumlah,2,',','.'); ?></td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan=2>Biaya Tenaga Kerja</td>
								<td class="text-right"></td>
							</tr>
							<?php foreach($list_data[1] as $row){?>
							<tr>
								<td></td>
								<td><?= $row->nama_kariyawan ?></td>
								<td class="text-right"><?php echo "Rp " . number_format($row->gaji_kariyawan*$row->jam_kerja,2,',','.'); ?></td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan=2>Biaya Overhead Tetap</td>
								<td class="text-right"></td>
							</tr>
							<?php foreach($list_data[2] as $row){?>
							<tr>
								<td></td>
								<td><?= $row->nama_overhead ?></td>
								<td class="text-right"><?php echo "Rp " . number_format($row->harga,2,',','.'); ?></td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan=2>Biaya Overhead Variabel</td>
								<td class="text-right"></td>
							</tr>
							<?php foreach($list_data[3] as $row){?>
							<tr>
								<td></td>
								<td><?= $row->nama_overhead ?></td>
								<td class="text-right"><?php echo "Rp " . number_format($row->harga,2,',','.'); ?></td>
							</tr>
							<?php } ?>
							<tr style="border-top: 2px solid black">
								<td colspan=2>Harga Pokok Satuan </td>
								<?php if($jml_prod > 0){?>
								<td class="text-right"><?php echo "Rp " . number_format(($data[0]+$data[1]+$data[2]+$data[3])/$jml_prod,2,',','.'); ?></td>
								<?php }else{ ?>
								<td class="text-right"><?php echo "Rp " . number_format($jml_prod,2,',','.'); ?></td>
								<?php } ?>
							</tr>
							
						</tbody>
			
				</table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


