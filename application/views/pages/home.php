<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
      	<p style="text-align: center;"><img src="<?=site_url()?>assets/images/logo.jpg" style="width: 50%;" /></p>

      	<br />
      	<br />
      	<div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
              <div class="count"><a href="<?=site_url()?>user"><?=$this->db->get_where('user', ['active'=>1])->num_rows()?></a></div>
              <span class="count_bottom"><i class="green">Active</i> User</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Quotation Order</span>
              <div class="count"><a href="<?=site_url()?>employeeqo"><?=$this->db->get('quotation_order')->num_rows()?></a></div>
              <span class="count_bottom">Progress, Complete </span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Sales Order</span>
              <div class="count"><a href="<?=site_url()?>employeeso"><?=$this->db->get('sales_order')->num_rows()?></a></div>
              <span class="count_bottom">Progress , Complete</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-flag"></i> Company</span>
              <div class="count"><a href="<?=site_url()?>customer"><?=$this->db->get('customer')->num_rows()?></a></div>
              <span class="count_bottom"><i class="green">All </i> Company</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-bar-chart"></i> Proyek</span>
              <div class="count">
              	<?php 
	              	$this->db->group_by('proyek');
	              	echo $this->db->get('quotation_order')->num_rows();
              	?>
              	</div>
            </div>
          </div>
      </div>
    </div>
</div>