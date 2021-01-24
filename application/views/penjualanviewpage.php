
		
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
					
					  <button class="btn btn-success btn-flat">
						<i class="fa fa-plus"></i>&nbsp; Add new data
					</button>
					</a>
				
					</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
				<table class="table table-hover datatable compact" >
				
				<?php
					if(!empty($render))
					{
					?>
						<thead>
							<tr>
								<th class="text-center">No.</th>
							<?php
							foreach($tableHeader as $row)
							{
							?> 
								<th class="text-center"><?= $row?></th>
							<?php
							}
							?>
								<th class="text-center">Option</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						
						foreach($render->result() as $row)
						{ 			
						$ist="";
						if(isset($statusVar))
							$ist=$statusVar;
						?>
							<tr>
								<td class="text-center"><?= $i?>.</td>
								<?php
								$pid=$row->$primaryKey;
								?>
									<td class="text-center"><?= $row->$primaryKey?></td>
									<td class="text-center"><?= $row->tgl_penjualan?></td>
									<td><?= $row->nama_barang?></td>
									<td class="text-right"><?= $row->pcs ?></td>
									<td class="text-right"><?= "Rp " . number_format($row->harga_per_pcs,2,',','.')?></td>
									<td class="text-right"><?= "Rp " . number_format($row->pcs*$row->harga_per_pcs,2,',','.')?></td>
								<td class="text-center">
								
							
							
								<a data-toggle="tooltip" title="Edit Data" href="<?= site_url();?><?= $saveLink;?>/<?= $pid;?>"><i class="fa fa-cog fa-fw fa-lg"></i></a>
							
								
							
								<a data-toggle="tooltip" title="Delete Data" href="<?= site_url();?><?= $deleteLink;?>/<?= $pid;?>"><i class="fa fa-trash fa-fw fa-lg"></i></a>
							
								</td>
							</tr>
							
						<?php
						$i++;
						}
						?>
						</tbody>
					<?php
					}
					?>
			
				</table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


