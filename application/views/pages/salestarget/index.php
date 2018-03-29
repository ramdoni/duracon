<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Target Sales</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="table-responsive">
          <table  id="datatable-buttons" class="table table-striped table-bordered">
          	<thead>
          		<tr>
          			<th>No</th>
          			<th>Tahun</th>
          			<th>Quartal I</th>
          			<th>Quartal II</th>
          			<th>Quartal III</th>
          			<th>Quartal IV</th>
          		</tr>
          	</thead>
            <tbody>
            	<?php foreach($data as $key => $item):?>
            		<tr>
            			<td><?=($key+1)?></td>
            			<td><?=$item['tahun']?></td>
            			<td><?=number_format($item['quartal_1'])?></td>
            			<td><?=number_format($item['quartal_2'])?></td>
            			<td><?=number_format($item['quartal_3'])?></td>
            			<td><?=number_format($item['quartal_4'])?></td>
            		</tr>
            	<?php endforeach;?> 
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>