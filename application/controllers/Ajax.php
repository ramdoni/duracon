<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {


	/**
	 * Constructor
	 * @param	-
	 * @return 	-
	 **/
	function __construct()
	{
		parent::__construct();	
		if(!$this->session->userdata('username')):
			redirect('login');
		else:
			$this->data['username'] = $this->session->userdata('username');
			$this->data['user_id'] = $this->session->userdata('user_id');
			$this->data['user_level'] = $this->session->userdata('user_level');
			$this->data['menu_name'] = $this->uri->segment('2');
			$this->data['sub_name'] = $this->uri->segment('3');
		endif;
	}

	public function cekschedule()
	{
		$post = $this->input->post();

		if($post)
		{
			$schedule = $this->db->get_where('product_schedule', ['plan' => $post['plan'], 'bulan' => $post['bulan'], 'minggu' => $post['minggu']])->num_rows();
			if($schedule)
			{
				echo 'yes';
			}else{
				echo 'no';
			}
		}
	}

	/**
	 * [gethistorysuratjalan description]
	 * @return [type] [description]
	 */
	public function gethistorysuratjalan()
	{
		$post = $this->input->post();
		if($post)
		{
			$data = $this->db->get_where('surat_jalan_lock_history', ['surat_jalan_id' => $post['id']])->result_array();
			$data_temp = [];
			foreach($data as $k =>$i)
			{
				$data_temp[$k] = $i;
				$data_temp[$k]['tanggal']= date('d F Y', strtotime($i['date']));
			}
			echo json_encode($data_temp);
		}
	}

	/**
	 * [getcustomer description]
	 * @return [type] [description]
	 */
	public function getcustomer()
	{
		$post = $this->input->post();

		$data  = $this->db->query("SELECT c.*, u.name as sales, u.sales_code, u.kode_area FROM customer c LEFT JOIN user u on u.id=c.sales_id WHERE c.id={$post['id']}")->row_array();

		echo json_encode($data);
	}

	/**
	 * [getnominalinvoiceid description]
	 * @return [type] [description]
	 */
	public function getnominalinvoiceid()
	{
		$post = $this->input->post();

		if($post)
		{
			$item = $this->db->get_where('invoice', ['id' => $post['id'], 'status' => 0])->row_array();

			echo 'Rp. '. number_format($item['nominal'], 0, ',','.');
		}
	}
	/**
	 * [getinvoicebyso description]
	 * @return [type] [description]
	 */
	public function getinvoicebyso()
	{
		$post = $this->input->post();

		if($post)
		{
			$this->db->from('invoice');
			$this->db->where(['sales_order_id' => $post['id'], 'status' => 0]);
			
			$data = $this->db->get()->result_array();

			echo json_encode($data);
		}	
	}

	/**
	 * [getsalesorderbycustomer description]
	 * @return [type] [description]
	 */
	public function getsalesorderbycustomer()
	{
		$post = $this->input->post();
		if($post)
		{
			$data = [];

			$this->db->select('s.id, s.no_so');
			$this->db->from('sales_order as s');
			$this->db->join('quotation_order as q', 'q.id=s.quotation_order_id');
			$this->db->where(['q.customer_id' => $post['id']]);

			$data = $this->db->get()->result_array();

			echo json_encode($data);
		}
	}

	/**
	 * [getmobil description]
	 * @return [type] [description]
	 */
	public function getmobil()
	{
		$id = $this->input->post('id');

		$mobil = $this->db->get_where('mobil', ['id' => $id])->row_array();

		echo json_encode($mobil);
	}

	/**
	 * [getsupir description]
	 * @return [type] [description]
	 */
	public function getsupir()
	{
		$id = $this->input->post('id');

		$supir = $this->db->get_where('supir', ['id' => $id])->row_array();

		echo json_encode($supir);
	}

	/**
	 * [getsuratjalanbyinvoice description]
	 * @return [type] [description]
	 */
	public function getsuratjalanbyinvoice()
	{
		$id = $this->input->post('id');

		//$surat_jalan = $this->db->get_where('surat_jalan', ['invoice_id' => $id])->result_array();

		$surat_jalan = $this->db->query("
                        SELECT spmp.surat_perintah_muat_id, sj.*, p.kode, spmp.volume, m.nama_supir, m.no_telepon, m.kenek FROM surat_jalan sj 
                        inner join surat_perintah_muat spm on spm.id=sj.surat_perintah_muat_id
                        inner join surat_perintah_muat_product spmp on spmp.surat_perintah_muat_id=spm.id 
                        inner join surat_izin_kirim sik on sik.id=spm.surat_izin_kirim_id
                        inner join products p on p.id=spmp.product_id
                        inner join mobil m on m.id=spm.mobil_id
                        where sj.invoice_id={$id}
                        group by sj.id
                        ")->result_array();

		echo json_encode($surat_jalan);
	}

	/**
	 * [getdetailspm description]
	 * @return [type] [description]
	 */
	public function getdetailproductspm()
	{	
		$id = $this->input->post('id');

		$data = $this->db->query("SELECT s.*, p.kode FROM surat_izin_kirim_history s inner join products p on p.id=s.product_id where s.surat_izin_kirim_id={$id}")->result_array();
		$result = [];

		foreach($data as $key => $item)
		{
			$spm = $this->db->query("SELECT sum(spmp.volume) as volume FROM surat_perintah_muat spm inner join surat_perintah_muat_product spmp on spmp.surat_perintah_muat_id=spm.id where spmp.product_id={$item['product_id']} and spm.surat_izin_kirim_id={$item['surat_izin_kirim_id']} and (spm.status=0 or spm.status=1 or spm.status=2)")->row_array();

			$result[$key] = $item;
			$result[$key]['volume_sudah_terkirim'] = isset($spm['volume']) ? $spm['volume'] : 0;
		}

		echo json_encode($result);	
	}	

	/**
	 * [insertpekerjalembur description]
	 * @return [type] [description]
	 */
	public function insertpekerjalembur()
	{
		$post = $this->input->post();

		$item = $this->db->get_where('product_schedule_pekerja', ['product_schedule_id' => $post['product_schedule_id'], 'day' => $post['day'], 'shift' => $post['shift']])->num_rows();

		if($item > 0)
		{
			if(isset($post['lembur']))
				$param['lembur'] = $post['lembur'];
			else
				$param['pekerja'] = $post['pekerja'];
			
			$this->db->where(['product_schedule_id' => $post['product_schedule_id'], 'day' => $post['day'], 'shift' => $post['shift']]);
			$this->db->update('product_schedule_pekerja', $param);
		}else{

			$param['product_schedule_id'] 	= $post['product_schedule_id'];
			$param['day'] 					= $post['day'];
			$param['shift'] 				= $post['shift']; 

			if(isset($post['lembur']))
				$param['lembur'] = $post['lembur'];
			else
				$param['pekerja'] = $post['pekerja'];

			$this->db->insert('product_schedule_pekerja', $param);
		}
	}

	/**
	 * [insertpekerjalembur description]
	 * @return [type] [description]
	 */
	public function insertpekerjalemburtulangan()
	{
		$post = $this->input->post();

		$item = $this->db->get_where('tulangan_schedule_pekerja', ['tulangan_schedule_id' => $post['tulangan_schedule_id'], 'day' => $post['day'], 'shift' => $post['shift']])->num_rows();

		if($item > 0)
		{
			if(isset($post['lembur']))
				$param['lembur'] = $post['lembur'];
			else
				$param['pekerja'] = $post['pekerja'];
			
			$this->db->where(['tulangan_schedule_id' => $post['tulangan_schedule_id'], 'day' => $post['day'], 'shift' => $post['shift']]);
			$this->db->update('tulangan_schedule_pekerja', $param);
		}else{

			$param['tulangan_schedule_id'] 	= $post['tulangan_schedule_id'];
			$param['day'] 					= $post['day'];
			$param['shift'] 				= $post['shift']; 

			if(isset($post['lembur']))
				$param['lembur'] = $post['lembur'];
			else
				$param['pekerja'] = $post['pekerja'];

			$this->db->insert('tulangan_schedule_pekerja', $param);
		}
	}

	/**
	 * [submitplandaily description]
	 * @return [type] [description]
	 */
	public function submitplandaily()
	{
		$post = $this->input->post();

		$param['product_schedule_id']	= $post['product_schedule_id'];
		$param['day'] 					= $post['day'];
		$param['shift'] 				= $post['shift'];
		$param['product_id'] 			= $post['product_id'];
		$param[$post['type_input']]		= $post['volume'];
		$param['date']					= date('Y-m-d H:i:s');

		//cek input
		$item = $this->db->get_where('product_schedule_plan_lembar_kerja', ['day' => $post['day'], 'shift' => $post['shift'], 'product_id'=> $post['product_id'], 'product_schedule_id' => $post['product_schedule_id']])->num_rows();

		if($item > 0)
		{
			$this->db->where(['day' => $post['day'], 'shift' => $post['shift'], 'product_id'=> $post['product_id'], 'product_schedule_id' => $post['product_schedule_id']]);
			$this->db->update('product_schedule_plan_lembar_kerja', $param);
		}else{
			$this->db->insert('product_schedule_plan_lembar_kerja',$param);
		}
	}

	/**
	 * [submitplandailytulangan description]
	 * @return [type] [description]
	 */
	public function submitplandailytulangan()
	{
		$post = $this->input->post();

		$param['tulangan_schedule_id']	= $post['tulangan_schedule_id'];
		$param['day'] 					= $post['day'];
		$param['shift'] 				= $post['shift'];
		$param['tulangan_id'] 			= $post['tulangan_id'];
		$param[$post['type_input']]		= $post['volume'];
		$param['date']					= date('Y-m-d H:i:s');

		//cek input
		$item = $this->db->get_where('tulangan_schedule_plan_lembar_kerja', ['day' => $post['day'], 'shift' => $post['shift'], 'tulangan_id'=> $post['tulangan_id'], 'tulangan_schedule_id' => $post['tulangan_schedule_id']])->num_rows();

		if($item > 0)
		{
			$this->db->where(['day' => $post['day'], 'shift' => $post['shift'], 'tulangan_id'=> $post['tulangan_id'], 'tulangan_schedule_id' => $post['tulangan_schedule_id']]);
			$this->db->update('tulangan_schedule_plan_lembar_kerja', $param);
		}else{
			$this->db->insert('tulangan_schedule_plan_lembar_kerja',$param);
		}
	}

	/**
	 * [getscheduleplan description]
	 * @return [type] [description]
	 */
	public function getscheduleplan()
	{
		$post = $this->input->post();

		$schedule = $this->db->query("SELECT * FROM product_schedule WHERE plan={$post['id']} ORDER BY id DESC")->row_array();

		if(isset($schedule)){

			$schedule_product = $this->db->query("SELECT * FROM product_schedule_plan WHERE product_schedule_id ={$schedule['id']}")->result_array();

			$data = [];
			foreach($schedule_product as $key => $item)
			{
				$product = $this->db->get_where('products', ['id' => $item['product_id']])->row_array();
				$data[$key] = $item;
				$data[$key]['product'] = $product['kode'];
			}

			echo json_encode($data);
		}else{
			echo '';
		}
	}

	/**
	 * [getscheduleplan description]
	 * @return [type] [description]
	 */
	public function getscheduleplantulangan()
	{
		$post = $this->input->post();

		$schedule = $this->db->query("SELECT * FROM tulangan_schedule WHERE plan={$post['id']} ORDER BY id DESC")->row_array();

		if(isset($schedule)){

			$schedule_product = $this->db->query("SELECT * FROM tulangan_schedule_plan WHERE tulangan_schedule_id ={$schedule['id']}")->result_array();

			$data = [];
			foreach($schedule_product as $key => $item)
			{
				$product = $this->db->get_where('tulangan', ['id' => $item['tulangan_id']])->row_array();
				$data[$key] = $item;
				$data[$key]['product'] = $product['kode'];
			}

			echo json_encode($data);
		}else{
			echo '';
		}
	}

	/**
	 * [submitpembatalansik description]
	 * @return [type] [description]
	 */
	public function submitpembatalansik()
	{
		$post = $this->input->post();
		
		// update status surat izin kirim
		$this->db->where(['id' => $post['sik_id']]);
		$this->db->update('surat_izin_kirim', ['catatan' => $post['catatan'], 'position' => 4]);
		$this->db->flush_cache();

		$sik_data = $this->db->get_where('surat_izin_kirim_history', ['surat_izin_kirim_id' => $post['sik_id']])->result_array();
		foreach($sik_data as $item)
		{
			// update stok temporary 
			$this->db->query("UPDATE products SET stock_temporary=(stock_temporary - {$item['volume_yang_dikirim']}) WHERE id={$item['product_id']}");
		}
	}

	/**
	 * [submitpembatalanspm description]
	 * @return [type] [description]
	 */
	public function submitpembatalanspm()
	{
		$post = $this->input->post();
		
		$this->db->where(['id' => $post['spm_id']]);
		$this->db->update('surat_perintah_muat', ['catatan' => $post['catatan'], 'status' => 3]);
	}


	/**
	 * [getproduksik description]
	 * @return [type] [description]
	 */
	public function getproduksik()
	{
		$post = $this->input->post();

		$data = $this->db->get_where('surat_izin_kirim_history', ['surat_izin_kirim_id' => $post['sik_id'], 'product_id' => $post['product_id']])->row_array();

		echo json_encode($data);	
	}	

	/**
	 * [savelokasiname description]
	 * @return [type] [description]
	 */
	public function savelokasiname()
	{
		$post = $this->input->post();

		$this->db->where(['id' => $post['pk']]);
	
		$this->db->update('lokasi', ['name' => $post['value']]);
	}

	/**
	 * [getdetailsikterkirim description]
	 * @return [type] [description]
	 */
	
	public function getdetailsikterkirim()
	{
		$post = $this->input->post();

		$this->load->model('Suratizinkirimhistory_model');

		$data = $this->Suratizinkirimhistory_model->get_by_sik($post['id']);

		echo json_encode($data);	
	}

	/**
	 * [submitlembarkerja description]
	 * @return [type] [description]
	 */
	public function submitlembarkerja()
	{
		$product_schedule_id 		= $_POST['product_schedule_id'];
		$reject 					= $_POST['reject'];
		$day 						= $_POST['day'];
		$shift 						= $_POST['shift'];
		$finishing 					= $_POST['finishing'];
		$hasil_produksi 			= $_POST['hasil_produksi'];
		$product_id 				= $_POST['product_id'];
		$aktual_jumlah_pekerja 		= $_POST['aktual_jumlah_pekerja'];
		$jam_lembur 				= $_POST['jam_lembur'];
		$jumlah_pekerja 			= $_POST['jumlah_pekerja'];

		$cek = $this->db->query("SELECT * FROM product_schedule_plan_lembar_kerja WHERE product_schedule_id={$product_schedule_id} AND product_id={$product_id} AND shift={$shift} AND day={$day}")->num_rows();

		$param['date']		= date('Y-m-d H:i:s');
		$param['reject'] 	= $reject;
		$param['day'] 		= $day;
		$param['shift']		= $shift;
		$param['finishing'] = $finishing;
		$param['hasil_produksi'] = $hasil_produksi;
		$param['product_id']= $product_id;
		$param['aktual_jumlah_pekerja'] = $aktual_jumlah_pekerja;
		$param['jam_lembur'] = $jam_lembur;
		$param['jumlah_pekerja'] = $jumlah_pekerja;

		if( $cek == 0 )
		{	
			$param['product_schedule_id'] = $product_schedule_id;

			$this->db->insert('product_schedule_plan_lembar_kerja', $param);
		}
		else
		{
			$this->db->where(['product_schedule_id' => $product_schedule_id, 'product_id' => $product_id, 'shift' => $shift, 'day'=> $day]);
			$this->db->update('product_schedule_plan_lembar_kerja', $param);
		}
	}

	/**
	 * [submitlembarkerjatulangan description]
	 * @return [type] [description]
	 */
	public function submitlembarkerjatulangan()
	{
		$tulangan_schedule_id 		= $_POST['tulangan_schedule_id'];
		$reject 					= $_POST['reject'];
		$day 						= $_POST['day'];
		$shift 						= $_POST['shift'];
		$finishing 					= $_POST['finishing'];
		$hasil_produksi 			= $_POST['hasil_produksi'];
		$tulangan_id 				= $_POST['tulangan_id'];
		$aktual_jumlah_pekerja 		= $_POST['aktual_jumlah_pekerja'];
		$jam_lembur 				= $_POST['jam_lembur'];
		$jumlah_pekerja 			= $_POST['jumlah_pekerja'];

		$cek = $this->db->query("SELECT * FROM tulangan_schedule_plan_lembar_kerja WHERE tulangan_schedule_id={$tulangan_schedule_id} AND tulangan_id={$tulangan_id} AND shift={$shift} AND day={$day}")->num_rows();

		$param['date']		= date('Y-m-d H:i:s');
		$param['reject'] 	= $reject;
		$param['day'] 		= $day;
		$param['shift']		= $shift;
		$param['finishing'] = $finishing;
		$param['hasil_produksi'] = $hasil_produksi;
		$param['tulangan_id']= $tulangan_id;
		$param['aktual_jumlah_pekerja'] = $aktual_jumlah_pekerja;
		$param['jam_lembur'] = $jam_lembur;
		$param['jumlah_pekerja'] = $jumlah_pekerja;

		if( $cek == 0 )
		{	
			$param['tulangan_schedule_id'] = $tulangan_schedule_id;

			$this->db->insert('tulangan_schedule_plan_lembar_kerja', $param);
		}
		else
		{
			$this->db->where(['tulangan_schedule_id' => $tulangan_schedule_id, 'tulangan_id' => $tulangan_id, 'shift' => $shift, 'day'=> $day]);
			$this->db->update('tulangan_schedule_plan_lembar_kerja', $param);
		}
	}

	/**
	 * [detailsik description]
	 * @return [type] [description]
	 */
	public function getdetailsik()
	{
		$this->load->model('Quotationorder_model');
		$this->load->model('Suratizinkirimhistory_model');

		$id 		= $this->input->post('id');
		$sik  		= $this->db->get_where('surat_izin_kirim', ['id' => $id])->row_array();
		$sik_product = $this->Suratizinkirimhistory_model->get_by_sik($id);
		$so   		= $this->db->get_where('sales_order', ['id' => $sik['sales_order_id']])->row_array();
		$qo 		= $this->Quotationorder_model->get_by_id($so['quotation_order_id']);
		$products 	= $this->db->get_where('quotation_order_products', ['quotation_order_id' =>$qo['id']])->result_array();

		$row['surat_izin_kirim'] 	= $sik;
		$row['sales_order'] 		= $so;
		$row['quotation_order']		= $qo;
		$row['products'] = $products;
		$row['product_sik'] = $sik_product;
 
		echo json_encode($row);	

	}
	/**
	 * [getgeneratepo description]
	 * @return [type] [description]
	 */
	public function getgeneratepo()
	{
		$post = $this->input->post();

		$this->load->model('Quotationorder_model');

		$po =  $this->Quotationorder_model->get_by_id($post['id']);

		$count = $this->db->get('sales_order')->num_rows();

		if(empty($count)) echo "";

		echo ($count +1) .'/PO/DC/'.$po['sales_code'].'/'. $po['lokasi_code'] .'/'. toRomawi(date('d')) .'/'. date('m') .'/'. date('Y'); 
	}
	
	/**
	 * [generatenoso description]
	 * @return [type] [description]
	 */
	public function generatenoso()
	{	
		$post = $this->input->post();

		$this->load->model('Quotationorder_model');

		$po =  $this->Quotationorder_model->get_by_id($post['id']);

		$count = $this->db->get('sales_order')->num_rows();

		if(empty($count)) echo "";
			
		$code = '';

		if(!empty($po['sales_code']))
			$code = $po['sales_code'];
		else
			$code = $po['marketing_code'];

		echo ($count +1) .'/'.$code.'/'. toRomawi(date('m')) .'/'. date('Y'); 
	}
	
	/**
	 * [getsales description]
	 * @return [type] [description]
	 */
	public function getsales()
	{
		$post = $this->input->post();

		$id = $post['id'];
		
		$row = $this->db->get_where('user', ['id' => $id])->row_array();

		echo json_encode($row);	
	}

	/**
	 * [saveuser description]
	 * @return [type] [description]
	 */
	public function saveuser()
	{
		$post = $this->input->post();

		$this->db->where(['id' => $post['pk']]);
	
		$this->db->update('user', ['active' => $post['value']]);
	}
	/**
	 * [saveusergroup description]
	 * @return [type] [description]
	 */
	public function saveusergroup()
	{
		$post = $this->input->post();

		$this->db->where(['id' => $post['pk']]);
	
		$this->db->update('user_group', ['active' => $post['value']]);
	}
	/**
	 * [savecabang description]
	 * @return [type] [description]
	 */
	public function savecabang()
	{
		$post = $this->input->post();

		$this->db->where(['id' => $post['pk']]);
	
		$this->db->update('cabang', ['active' => $post['value']]);
	}
	/**
	 * [saveproyek description]
	 * @return [type] [description]
	 */
	public function saveproyek()
	{
		$post = $this->input->post();

		$this->db->where(['id' => $post['pk']]);
	
		$this->db->update('proyek', ['active' => $post['value']]);
	}
	/**
	 * [savelokasi description]
	 * @return [type] [description]
	 */
	public function savelokasi()
	{
		$post = $this->input->post();

		$this->db->where(['id' => $post['pk']]);
	
		$this->db->update('lokasi', ['active' => $post['value']]);
	}
	/**
	 * [savespesifikasi description]
	 * @return [type] [description]
	 */
	public function savespesifikasi()
	{
		$post = $this->input->post();

		$this->db->where(['id' => $post['pk']]);
	
		$this->db->update('product_specification', ['active' => $post['value']]);
	}

	/**
	 * update save inline area
	 * @return [type] [description]
	 */
	public function savearea()
	{
		$post = $this->input->post();

		$this->db->where(['id' => $post['pk']]);
	
		$this->db->update('area', ['active' => $post['value']]);
	}

	/**
	 * update save inline customer
	 * @return [type] [description]
	 */
	public function savecustomer()
	{
		$post = $this->input->post();

		$this->db->where(['id' => $post['pk']]);
	
		$this->db->update('customer', ['active' => $post['value']]);
	}

	/**
	 * update status products
	 * @return [type] [description]
	 */
	public function saveproduct()
	{
		$post = $this->input->post();

		$this->db->where(['id' => $post['pk']]);
	
		$this->db->update('products', ['active' => $post['value']]);
	}

	/**
	 * [savequotationproductvol description]
	 * @return [type] [description]
	 */
	public function savequotationproductvol()
	{
		$post = $this->input->post();

		$this->db->where(['id' => $post['pk']]);
	
		$this->db->update('quotation_order_products', ['vol' => $post['value']]);
	}

	/**
	 * [savequotationproductdisc description]
	 * @return [type] [description]
	 */
	public function savequotationproductdisc()
	{
		$post = $this->input->post();

		$this->db->where(['id' => $post['pk']]);
	
		$this->db->update('quotation_order_products', ['disc' => $post['value']]);
	}

	/**
	 * [getnoquotation description]
	 * @return [type] [description]
	 */
	public function getnoquotation()
	{
		$id = @isset($_GET['id']) ? $_GET['id'] : @$_POST['id'];

		if(empty($id)) return;

		$data = $this->db->get_where('quotation_order', ['proyek_id' => $id])->result_array();
		
		if(!$data) return;

		echo json_encode($data);
	}

	/**
	 * [getnoquotation description]
	 * @return [type] [description]
	 */
	public function getnoquotationproyek()
	{
		$proyek = @isset($_GET['proyek']) ? $_GET['proyek'] : @$_POST['proyek'];

		if(empty($proyek)) return;

		$this->db->like('proyek', $proyek);

		$data = $this->db->get('quotation_order')->result_array();

		$result = [];
		
		foreach($data as $key => $item)
		{
            if($this->db->get_where('sales_order',['quotation_order_id' => $item['id']])->num_rows() > 0) continue;
			
			$result[$key] = $item;
		}	

		if(!$result) echo "";

		echo json_encode($result);
	}

	/**
	 * [gettulangan description]
	 * @return [type] [description]
	 */
	public function gettulangan()
	{
		$id = @isset($_POST['id']) ? $_POST['id'] : "";

		if(empty($id)) return;

		$this->load->model('Tulangan_model');
		
		$data = $this->Tulangan_model->get_by_id($id);
		
		if(!$data) return;

		echo json_encode($data);	
	}
	/**
	 * [getquotation description]
	 * @return [type] [description]
	 */
	public function getquotation()
	{
		$id = @isset($_GET['id']) ? $_GET['id'] : @$_POST['id'];

		if(empty($id)) return;

		$this->load->model('Quotationorder_model');
		
		$data = $this->Quotationorder_model->get_by_id($id);
		
		if(!$data) return;

		echo json_encode($data);	
	}
	/**
	 * [getareaproyek description]
	 * @return [type] [description]
	 */
	public function getareaproyek()
	{
		$id = @isset($_GET['id']) ? $_GET['id'] : @$_POST['id'];

		if(empty($id)) return;
		
		$this->db->from('proyek');
		$this->db->select('area.area, lokasi.name as lokasi');
		$this->db->join('lokasi', 'lokasi.id=proyek.lokasi_id');
		$this->db->join('area', 'area.id=proyek.area_id');
		$this->db->where(['proyek.id' => $id]);

		$data = $this->db->get()->row_array();

		echo $data['area']. ' - '. $data['lokasi'];
	}
	/**
	 * [getarealokasi description]
	 * @return [type] [description]
	 */
	public function getarealokasi()
	{
		$id = @isset($_GET['id']) ? $_GET['id'] : @$_POST['id'];

		if(empty($id)) return;

		$this->db->from('area_lokasi');
		$this->db->select('area_lokasi.lokasi_id as id, lokasi.name as lokasi');
		$this->db->join('lokasi', 'lokasi.id=area_lokasi.lokasi_id', 'left');
		$this->db->where(['area_id' => $id]);

		$data = $this->db->get();

		if(!$data) return;

		echo json_encode($data->result_array());	
	}

	/**
	 * [getarealokasi description]
	 * @return [type] [description]
	 */
	public function getarealokasiname()
	{
		$post = $this->input->post();

		if(empty($post['string'])) return;
		
		$query = "SELECT l.*, al.area_id FROM lokasi l inner join area_lokasi al on al.lokasi_id=l.id WHERE l.name LIKE '%". ltrim($post['string'], " ") ."%'";
		
		$data = $this->db->query($query)->row_array();
		
		if(!$data) return "";

		echo json_encode($data);	
	}
	

	public function getquotaionorderhistory()
	{
		$id = @isset($_GET['id']) ? $_GET['id'] : @$_POST['id'];

		if(empty($id)) return;

		$this->load->model('Quotationorderhistory_model');
		
		$data = $this->Quotationorderhistory_model->get_by_id($id);
		
		if(!$data) return;

		echo json_encode($data);
	}

	/**
	 * [getquotationproducts description]
	 * @return [type] [description]
	 */
	public function getquotationproducts()
	{
		$id = @$_GET['id'];

		if(empty($id)) return;

		$data = $this->db->get_where('quotation_order_products', ['quotation_order_id' => $id])->result_array();
		
		if(!$data) return;

		$this->load->model('Quotationorder_model');

		$result = $this->Quotationorder_model->get_by_id($id);

		$result['data'] = $data;

		echo json_encode($result);	
	}

	/**
	 * [getsalesorderroducts description]
	 * @return [type] [description]
	 */
	public function getsalesorderroducts()
	{
		$quotation_order_id = @$_POST['quotation_order_id'];
		$sales_order_id = @$_POST['sales_order_id'];

		if(empty($quotation_order_id) or empty($sales_order_id)) return;

		$this->load->model('Quotationorder_model');

		$data = $this->db->get_where('quotation_order_products', ['quotation_order_id' => $quotation_order_id])->result_array();
		
		if(!$data) return;

		$this->load->model('Quotationorder_model');

		$result = $this->Quotationorder_model->get_by_id($quotation_order_id);

		$result['data'] = $data;
		$result['sales_order'] = $this->db->get_where('sales_order', ['id' => $sales_order_id ])->row_array(); 

		echo json_encode($result);	
	}

	/**
	 * [getkodeproduct description]
	 * @return [type] [description]
	 */
	public function getkodetulangan()
	{
		$id = @$_GET['id'];

		if(empty($id)) return;

		$data = $this->db->get_where('tulangan',['id' => $id])->row_array();
		
		if(!$data) return;

		echo json_encode($data);
	}

	/**
	 * [getkodeproduct description]
	 * @return [type] [description]
	 */
	public function getkodeproduct()
	{
		$id = @$_GET['id'];

		if(empty($id)) return;

		$data = $this->db->get_where('products',['id' => $id])->row_array();
		
		if(!$data) return;

		echo json_encode($data);
	}

	public function deletepoproduct()
	{
		$id = @$_GET['id'];

		if(empty($id)) return;

		$this->db->where(['id' => $id]);
		$this->db->delete('quotation_order_products');
	}	

	/**
	 * [deleteprodukplan description]
	 * @return [type] [description]
	 */
	public function deleteprodukplan()
	{
		$id = $_POST['id'];

		$this->db->where(['id' => $id]);
		$this->db->delete('product_schedule_plan');
	}

	/**
	 * [deletelokasiarea description]
	 * @return [type] [description]
	 */
	public function deletelokasiarea()
	{
		$id = @$_GET['id'];

		if(empty($id)) return;

		$this->db->where(['id' => $id]);
		$this->db->delete('area_lokasi');
	}

	public function editlineproduct()
	{
		$post = $_POST;
		$params = [];
		$params['employee_id'] = $this->session->userdata('employee_id');
		$params['create_time'] = date("Y-m-d H:i:s");
		$params['status'] = 1; // waiting approved
		$params['employee_po_products_id'] = $post['id'];
		$params['harga_satuan'] = $post['harga_satuan'];
		$params['disc_ppn'] = $post['disc_ppn'];

		$this->db->insert('quotation_order_products_revisi', $params);
	}

	public function uploadproductqo()
	{
		if(isset($_FILES))
		{
			# upload file
			$config = Array();
			$config['upload_path'] 		= './upload/';
			$config['allowed_types'] 	= '*';
			$config['max_size']			= '2000';
			$config['max_width'] 		= '2000';
			$config['max_height']		= '2000';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload("file")):
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			else:

				$upload_data = $this->upload->data();
				
				// Load the spreadsheet reader library
				$this->load->library('Excel_reader');

				$this->excel_reader->setOutputEncoding('230787');
				$file = $upload_data['full_path'];
				$this->excel_reader->read($file);
				error_reporting(E_ALL ^ E_NOTICE);

				$data = $this->excel_reader->sheets[0];
			    for ($i = 1; $i <= $data['numRows']; $i++) {
			        
			        if ($data['cells'][$i][1] == '') continue;

			        if($i==1) continue;

					$dataexcel = [];
			        $dataexcel['kode'] = $data['cells'][$i][1];
			        $dataexcel['uraian'] = $data['cells'][$i][2];
			        $dataexcel['vol'] = $data['cells'][$i][3];
			        $dataexcel['satuan'] = $data['cells'][$i][4];
			        $dataexcel['weight'] = $data['cells'][$i][5];
			        $dataexcel['price'] = $data['cells'][$i][6];
			        $dataexcel['disc_ppn'] = $data['cells'][$i][7];
			    }
				
				echo json_encode($dataexcel);

				//delete file
	            $file = $config['upload_path'] . $upload_data['file_name'];
				unlink($upload_data['full_path']);

			endif;
		}
	}

	/**
	 * [deletesalesusertarget description]
	 * @return [type] [description]
	 */
	public function deletesalesusertarget()
	{
		$id = @$_POST['id'];

		if(empty($id)) return;

		$this->db->where(['id' => $id]);
		$this->db->delete('sales_target_user');
	}
}