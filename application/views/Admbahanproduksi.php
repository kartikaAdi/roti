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
		<form class="form-horizontal" id="formfield" enctype="multipart/form-data" data-toggle="validator" role="form" method="POST" action="<?= site_url();?><?= $saveLink;?>" >
		
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">
					<span><?= $pageTitle?></span>
					</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
				
			
			<?php
				if(!empty($formLabel))
				{
				?>
				
						<?php
						$i=0;
						foreach($formLabel as $row)
						{
						?> 
							  <div class="form-group ">
								<label for="inputEmail3" class="col-sm-2 control-label"><?= $row ?></label>														
								<div class="col-sm-10">
								  <?= $formTxt[$i] ?>
									<div class="help-block with-errors"></div>
								</div>
							  </div>
						<?php
						$i++;
						}
						?>
				<?php
				}
				?>
								  
			  
			
	
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
       
	   <!-- detail produksi -->
	   
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">
					<span><?= $pageTitle?></span>
					</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
			
			<?php
				if(!empty($formLabelDetail))
				{
				?>
				
						<?php
						$i=0;
						foreach($formLabelDetail as $row)
						{
						?> 
							  <div class="form-group ">
								<label for="inputEmail3" class="col-sm-2 control-label"><?= $row ?></label>														
								<div class="col-sm-10">
								  <?= $formTxtDetail[$i] ?>
									<div class="help-block with-errors"></div>
								</div>
							  </div>
						<?php
						$i++;
						}
						?>
				<?php
				}
				?>
								  
			  
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-success" >Submit</button> 
				 	  <!--  <button type="submit"  name="btn" id="submitBtn" data-toggle="modal" data-target="#confirm-submit"   class="btn btn-success"  />Submit</button>-->
				</div>
			  </div>
			
			
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
       
	   
			</form>
	   </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
