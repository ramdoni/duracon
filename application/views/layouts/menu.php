<?php

$access = (Int)$this->session->userdata('access_id');
$menu = [];
// is sales admin
if($access == 2){
	$menu = [
		[
			'label' => 'Master Proses',
			'link' => '#',
			'icon' => 'fa-home',
			'items' => [
				[
					'label' => 'Quotation Order',
					'link' => 'employeeqo',
					'icon' => ''
				],
				[
					'label' => 'Sales Order',
					'link' => 'employeeso',
					'icon' => ''
				]	
			]
		],
		[
			'label' => 'Master Data',
			'link' => '#',
			'icon' => 'fa-edit',
			'items' => [
				[
					'label' => 'Kategori Produk',
					'link' => 'spesifikasi',
					'icon' => ''
				],	
				[
					'label' => 'Products',
					'link' => 'products',
					'icon' => ''
				],	
				[
					'label' => 'Customer',
					'link' => 'customer',
					'icon' => ''
				],	
				[
					'label' => 'Area Kirim',
					'link' => 'area',
					'icon' => ''
				],
			]
		]
	]; 
}

// is Manager
if($access == 5){
	
	$po = $this->db->query("SELECT * FROM quotation_order where position=4 or position=3")->num_rows();
	$so = $this->db->query("SELECT * FROM sales_order where position=4 or position=3")->num_rows();
	$sik = $this->db->query("SELECT * FROM surat_izin_kirim where position=2")->num_rows();

	$menu = [
		[
			'label' => 'Master Proses',
			'link' => '#',
			'icon' => 'fa-home',
			'items' => [
				[
					'label' => 'Quotation Order <span class="label label-danger pull-right">'. $po.'</span>',
					'link' => 'managerqo',
					'icon' => ''
				],
				[
					'label' => 'Sales Order <span class="label label-danger pull-right">'. $so.'</span>',
					'link' => 'managerso',
					'icon' => ''
				],	
				[
					'label' => 'Target Sales',
					'link' => 'managertarget',
					'icon' => ''
				],
				[
					'label' => 'Surat Izin Kirim <span class="label label-danger pull-right">'. $sik.'</span>',
					'link' => 'managersik',
					'icon' => ''
				],
				[
					'label' => 'Surat Jalan',
					'link' => 'managersj',
					'icon' => ''
				]	
			]
		]
	]; 
}

// is Produksi / Pabrik
if($access == 7){

	$menu = [
		[
			'label' => 'Master Proses',
			'link' => '#',
			'icon' => 'fa-home',
			'items' => [
				[
					'label' => 'Produk',
					'link' => 'datastok',
					'icon' => ''
				],
				[
					'label' => 'Tulangan',
					'link' => 'tulangan',
					'icon' => ''
				],
				[
					'label' => 'Jadwal Produksi Pengecoran',
					'link' => 'pabrikjadwalproduksi',
					'icon' => ''
				],
				[
					'label' => 'Jadwal Produksi Tulangan',
					'link' => 'pabrikjadwaltulangan',
					'icon' => ''
				],
				[
					'label' => 'Report Produksi Pengecoran',
					'link' => 'reportjadwalproduksi',
					'icon' => ''
				],
			]
		]
	]; 
}

// is administrator
if($access == 1){
	$menu = [
		[
			'label' => 'Master Proses',
			'link' => '#',
			'icon' => 'fa-home',
			'items' => [
				[
					'label' => 'Quotation Order',
					'link' => 'employeeqo',
					'icon' => ''
				],
				[
					'label' => 'Sales Order',
					'link' => 'employeeso',
					'icon' => ''
				],
				[
					'label' => 'Surat Izin Kirim',
					'link' => 'sik',
					'icon' => ''
				],
				[
					'label' => 'Surat Jalan',
					'link' => 'suratjalan',
					'icon' => ''
				]	
			]
		],
		[
			'label' => 'Master Data',
			'link' => '#',
			'icon' => 'fa-edit',
			'items' => [
				[
					'label' => 'Spesifikasi Produk',
					'link' => 'spesifikasi',
					'icon' => ''
				],	
				[
					'label' => 'Products',
					'link' => 'products',
					'icon' => ''
				],	
				[
					'label' => 'Customer',
					'link' => 'customer',
					'icon' => ''
				],
				[
					'label' => 'Area Kirim',
					'link' => 'area',
					'icon' => ''
				],
			]
		],

		[
			'label' => 'User Management',
			'link' => '#',
			'icon' => 'fa-user',
			'items' => [
				[
					'label' => 'User List',
					'link' => 'user',
					'icon' => ''
				],
				[
					'label' => 'Group List',
					'link' => 'usergroup',
					'icon' => ''
				]
			]
		]
	]; 
}

// is Sales
if($access == 3)
{	
	$sales_id = $this->session->userdata('employee_id');

	$po = $this->db->query("SELECT * FROM quotation_order where position=2 and sales_id={$sales_id}")->num_rows();
	$so = $this->db->query("SELECT * FROM sales_order so inner join quotation_order qo on qo.id=so.quotation_order_id where so.position=2 and qo.sales_id={$sales_id}")->num_rows();
	$dispensasi = $this->db->get_where('dispensasi', ['status' => 0, 'sales_id' => $this->session->userdata('user_id')])->num_rows();

	$menu = [
		[
			'label' => 'Master Proses',
			'link' => '#',
			'icon' => 'fa-home',
			'items' => [
				[
					'label' => 'Quotation Order <span class="label label-danger pull-right">'. $po.'</span>',
					'link' => 'salesqo',
					'icon' => ''
				],
				[
					'label' => 'Sales Order <span class="label label-danger pull-right">'. $so.'</span>',
					'link' => 'salesso',
					'icon' => ''
				],
				[
					'label' => 'Pengajuan Dispensasi <span class="label label-danger pull-right">'. $dispensasi.'</span>',
					'link' => 'salesdispensasi',
					'icon' => ''
				],
				[
					'label' => 'Data Stok',
					'link' => 'salesso/stockproduct',
					'icon' => ''
				],	
			],
		],
		[
			'label' => 'Target Kuartal',
			'link' => 'salestarget',
			'icon' => 'fa-bar-chart'
		]
	]; 
}

/**
 * access menu for login marketing
 * @var integer
 */
if($access == 4){
	
	$menu = [
		[
			'label' => 'Master Proses',
			'link' => '#',
			'icon' => 'fa-home',
			'items' => [
				[
					'label' => 'Quotation Order',
					'link' => 'marketingquotation',
					'icon' => ''
				],
				[
					'label' => 'Sales Order',
					'link' => 'marketingsalesorder',
					'icon' => ''
				],
				[
					'label' => 'Surat Izin Kirim',
					'link' => 'marketingsik',
					'icon' => ''
				]
			],
		]
	]; 
}

// is Delivery
if($access == 8){

	$menu = [
		[
			'label' => 'Master Proses',
			'link' => '#',
			'icon' => 'fa-home',	
			'items' => [
				[
					'label' => 'Surat Izin Kirim',
					'link' => 'deliversik',
					'icon' => ''
				],
				[
					'label' => 'Surat Perintah Muat',
					'link' => 'deliveryspm',
					'icon' => ''
				],
				[
					'label' => 'Surat Jalan',
					'link' => 'deliverysj',
					'icon' => ''
				],

			]
		],
		[
			'label' => 'Master Data',
			'link' => '#',
			'icon' => 'fa-database',	
			'items' => [
				[
					'label' => 'Mobil dan Supir',
					'link' => 'mobil',
					'icon' => ''
				],
			]
		]
	]; 
}


// is AR Admin
if($access == 6){
	$po = $this->db->query("SELECT * FROM quotation_order where position=3")->num_rows();
	$so = $this->db->query("SELECT * FROM sales_order where position=3")->num_rows();
	$sik = $this->db->query("SELECT * FROM surat_izin_kirim where position=1")->num_rows();
	$tanda_terima = $this->db->get_where('tanda_terima', ['status' => 0])->num_rows();	

	$menu = [
		[
			'label' => 'Master Proses',
			'link' => '#',
			'icon' => 'fa-home',
			'items' => [
				[
					'label' => 'Sales Order',
					'link' => 'arso',
					'icon' => ''
				],
				// [
				// 	'label' => 'Surat Izin Kirim',
				// 	'link' => 'arsik',
				// 	'icon' => ''
				// ],
				[
					'label' => 'Invoice',
					'link' => 'invoice',
					'icon' => ''
				],
				[
					'label' => 'Surat Jalan',
					'link' => 'suratjalanar',
					'icon' => ''
				],
				[
					'label' => 'Tanda Terima  <span class="label label-danger pull-right">'. $tanda_terima.'</span>',
					'link' => 'tandaterima',
					'icon' => ''
				],
				[
					'label' => 'Pembayaran',
					'link' => 'inputpembayaran',
					'icon' => ''
				],	
			]
		]
	]; 
}

/**
 * AR Manager
 * @var [type]
 */
if($access == 10){

	$po = $this->db->query("SELECT * FROM quotation_order where position=3")->num_rows();
	$so = $this->db->query("SELECT * FROM sales_order where position=3")->num_rows();
	$sik = $this->db->query("SELECT * FROM surat_izin_kirim where position=1")->num_rows();
	$dispensasi = $this->db->get_where('dispensasi', ['status' => 0])->num_rows();	
	
	$menu = [
		[
			'label' => 'Master Proses',
			'link' => '#',
			'icon' => 'fa-home',
			'items' => [
				[
					'label' => 'Sales Order',
					'link' => 'arso',
					'icon' => ''
				],
				[
					'label' => 'Surat Izin Kirim <span class="label label-success pull-right">'. $sik.'</span>',
					'link' => 'arsik',
					'icon' => ''
				],
				[
					'label' => 'Invoice',
					'link' => 'invoice',
					'icon' => ''
				],
				[
					'label' => 'Tanda Terima',
					'link' => 'tandaterima',
					'icon' => ''
				],
				[
					'label' => 'Pengajuan Dispensasi  <span class="label label-danger pull-right">'. $dispensasi.'</span>',
					'link' => 'dispensasi',
					'icon' => ''
				],
			]
		]
	]; 

}

// is sales admin
if($access == 11){
	$menu = [
		[
			'label' => 'Master Data',
			'link' => '#',
			'icon' => 'fa-edit',
			'items' => [
				[
					'label' => 'Kategori Produk',
					'link' => 'spesifikasi',
					'icon' => ''
				],	
				[
					'label' => 'Products',
					'link' => 'products',
					'icon' => ''
				],	
			]
		]
	]; 
}

?>
<ul class="nav side-menu">
	<?php
		foreach($menu as $key => $value){
			echo '<li><a ';
			
			if($value['link'] != '#') echo ' href="'. site_url($value['link']) .'" ';

			echo '><i class="fa '. $value['icon'] .'"></i> '. $value['label'];

			if(isset($value['items'])) echo '<span class="fa fa-chevron-down"></span>';

			echo  ' </a>';

			if(isset($value['items'])){
    			echo '<ul class="nav child_menu">';
				foreach($value['items'] as $i){
      				echo '<li><a href="'. site_url($i['link']) .'">'. $i['label'] .'</a></li>';
				}
				echo '</ul>';
			}

			echo '</li>';
		}
	?>
</ul>
