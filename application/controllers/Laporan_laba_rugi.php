<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_laba_rugi extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Commonfunction','','fn');
				
		if(!isset($this->session->userdata['name']))		
			redirect("login","refresh");
	}
	/*	
		====================================================== Variable Declaration =========================================================
	*/
	
	var $mainTable="produksi";
	var $mainPk="id_produksi";
	var $viewLink="produksi";
	var $breadcrumbTitle="Laporan Laba Rugi";
	var $viewPage="laporan_laba_rugiviewpage";
	var $addPage="laporan_laba_rugiaddpage";
	
	//query
	var $ordQuery=" ORDER BY id_produksi ";
	var $tableQuery="
		produksi a
		INNER JOIN produksi b ON a.id_produksi = b.id_produksi
		INNER JOIN bahan    c ON a.qr_bahan   = c.barcode
						";
	var $fieldQuery="a.id_produksi,a.id_produksi,b.nama_barang,c.barcode,c.nama_bahan,a.jumlah"; //leave blank to show all field
						
	var $primaryKey="id_produksi";
	var $updateKey="id_produksi";
	
	//auto generate id
	var $defaultId="produksi01";
	var $prefix="produksi";
	var $suffix="01";	
	
	//view
	var $viewFormTitle="Laporan Laba Rugi";
	var $viewFormTableHeader=array(
									"Id Produksi",
									"Id Produksi",
									"Nama Barang",
									"Id Bahan",
									"Nama Bahan",
									"Jumlah",
									);
	//save
	var $saveFormTitle="Laporan Laba Rugi";
	var $saveFormTableHeader=array(
									"Id Produksi",
									"Id Produksi",
									"Id Bahan",
									"Jumlah",
									);
	
	//update
	var $editFormTitle="Laporan Laba Rugi";
	
	/*	
		========================================================== General Function =========================================================
	*/
	
	public function index()
	{
		//init modal
		$this->load->database();
		$this->load->model('Mmain');
		$query_produksi=$this->Mmain->qRead("produksi ORDER BY id_produksi","","");
		$list_produksi=array();
		foreach($query_produksi->result() as $row){
			array_push($list_produksi,$row->id_produksi);
		}
		$bulan = date("m");
		$tahun = date("Y");

		if($this->input->get('bulan') !== NULL || $this->input->get('tahun') !== NULL){
			$bulan = $this->input->get('bulan');
			$tahun = $this->input->get('tahun');
		}

		$query_bbb=$this->Mmain->qRead("bbb a
			INNER JOIN bahan b ON a.qr_bahan = b.barcode
			INNER JOIN produksi c ON a.id_produksi = c.id_produksi
			WHERE c.tanggal >= '".$tahun."-".$bulan."-1' AND c.tanggal <= '".$tahun."-".$bulan."-31'","a.jumlah,b.h_beli","");
		$total_bbb = 0;
		foreach($query_bbb->result() as $row){
			$total_bbb = $total_bbb + ($row->h_beli*$row->jumlah);
		}
		$query_btk=$this->Mmain->qRead("btk a
			INNER JOIN kariyawan b ON a.id_karyawan = b.id_kariyawan
			INNER JOIN produksi c ON a.id_produksi = c.id_produksi
			WHERE c.tanggal >= '".$tahun."-".$bulan."-1' AND c.tanggal <= '".$tahun."-".$bulan."-31'","b.gaji_kariyawan,a.jam_kerja","");
		$total_btk= 0;
		foreach($query_btk->result() as $row){
			$total_btk = $total_btk + ($row->gaji_kariyawan*$row->jam_kerja);
		}
		$query_bopt=$this->Mmain->qRead("bopt a
			INNER JOIN overheadtetap    b ON a.id_overheadtetap   = b.id_overhead
			INNER JOIN produksi c ON a.id_produksi = c.id_produksi
			WHERE c.tanggal >= '".$tahun."-".$bulan."-1' AND c.tanggal <= '".$tahun."-".$bulan."-31'","b.harga","");
		$total_bopt= 0;
		foreach($query_bopt->result() as $row){
			$total_bopt = $total_bopt + ($row->harga);
		}
		$query_bopv=$this->Mmain->qRead("bopv a
			INNER JOIN overheadvariabel    b ON a.id_overheadvariabel   = b.id_overhead
			INNER JOIN produksi c ON a.id_produksi = c.id_produksi
			WHERE c.tanggal >= '".$tahun."-".$bulan."-1' AND c.tanggal <= '".$tahun."-".$bulan."-31'","a.jumlah,b.harga","");
		$total_bopv= 0;
		foreach($query_bopv->result() as $row){
			$total_bopv = $total_bopv + ($row->harga*$row->jumlah);
		}
		$query_penjualan=$this->Mmain->qRead("penjualan WHERE  tgl_penjualan >= '".$tahun."-".$bulan."-1' AND tgl_penjualan <= '".$tahun."-".$bulan."-31'","","");
		$total_penjualan= 0;
		foreach($query_penjualan->result() as $row){
			$total_penjualan = $total_penjualan + ($row->pcs*$row->harga_per_pcs);
		}
		//init view
		
		// $renderTemp=$this->Mmain->qRead($this->tableQuery.$this->ordQuery,$this->fieldQuery,"");
		
		// $output['render']=$renderTemp;
		//init view
		$output['bulan']=$bulan;
		$output['tahun']=$tahun;
		$output['list_produksi']=$list_produksi;
		$output['data']=[$total_bbb,$total_btk,$total_bopt,$total_bopv,$total_penjualan];
		$output['pageTitle']=$this->viewFormTitle;
		$output['breadcrumbTitle']=$this->breadcrumbTitle;
		$output['breadcrumbLink']=$this->viewLink;
		$output['saveLink']=$this->viewLink."/";
		$output['deleteLink']=$this->viewLink."/delete";
		$output['primaryKey']=$this->primaryKey;
		$output['tableHeader']=$this->viewFormTableHeader;
		
		//render view
		$this->fn->getheader();
		$this->load->view($this->viewPage,$output);
		$this->fn->getfooter();
	}
	

	
	public function add($isEdit="")
	{
		//init modal
		$this->load->database();
		$this->load->model('Mmain');
		
		
		//init view
		$output['pageTitle']=$this->saveFormTitle;
		$output['breadcrumbTitle']=$this->breadcrumbTitle;
		$output['breadcrumbLink']=$this->viewLink;
		$output['saveLink']=$this->viewLink."/save";
		$output['tableHeader']=$this->saveFormTableHeader;
		$output['formLabel']=$this->saveFormTableHeader;
		
		$imgTemp="";
		$codeTemp="";
		if(!empty($isEdit))
		{
			
			$output['pageTitle']=$this->editFormTitle;
			$output['saveLink']=$this->viewLink."/update";
			$pid=$isEdit;
			$render=$this->Mmain->qRead($this->tableQuery,$this->fieldQuery,$this->mainPk."  = '".$pid."'");
			foreach($render->result() as $row)
			{
				foreach($row as $col)
				{
					$txtVal[]= $col;
				}
			}
			
				
				//$cboloc=$this->fn->createCbofromDb("tb_loc","id_loc as id,nm_loc as nm","",$txtVal[6]);
				//$cbosex=$this->fn->createCbo(array(1,0),array("Male","Female"),$txtVal[8]);
					
				
		}
		else
		{	
				for($i=0;$i<count($this->viewFormTableHeader);$i++)
				{
					$txtVal[]="";
				}	
				
				//generate id
				$newId=$this->Mmain->autoId($this->mainTable,$this->mainPk,$this->prefix,$this->defaultId,$this->suffix);	
				$txtVal[0]=$newId;
				
			
				//$cbosex=$this->fn->createCbo(array(1,0),array("Male","Female"),"");
				//$cbostat=$this->fn->createCbo(array(1,0),array("Active","Inactive"),"");
		}
		$list_produksi=$this->Mmain->qRead("produksi ORDER BY id_produksi","","");
		$input_produksi = '';
		foreach($list_produksi->result() as $row)
		{ 
			if($txtVal[1]==$row->id_produksi)
				$input_produksi = $input_produksi.'<option selected value="'.$row->id_produksi.'">'.$row->id_produksi." - ".$row->nama_barang.'</option>';
			else
				$input_produksi = $input_produksi.'<option value="'.$row->id_produksi.'">'.$row->id_produksi." - ".$row->nama_barang.'</option>';
		}
		$list_bahan=$this->Mmain->qRead("bahan ORDER BY id_bahan","","");
		$input_bahan = '';
		foreach($list_bahan->result() as $row)
		{ 	
			if($txtVal[3]==$row->barcode)
				$input_bahan = $input_bahan.'<option selected value="'.$row->barcode.'">'.$row->barcode." - ".$row->nama_bahan.'</option>';
			else
			$input_bahan = $input_bahan.'<option value="'.$row->barcode.'">'.$row->barcode." - ".$row->nama_bahan.'</option>';
		}
		$output['formTxt']=array(
								$codeTemp.
								"<input type='text' class='form-control' id='txtid0' name=txt[] value='".$txtVal[0]."' readonly>",
								"<select class='form-control' name=txt[]>".$input_produksi."
								  </select>",
								"<select class='form-control' name=txt[]>".$input_bahan."
							  	</select>",
								"<input type='text' class='form-control' id='txtid1' name=txt[] value='".$txtVal[5]."' required>",
								);
	
		
		// //load view
		$this->fn->getheader();
		$this->load->view($this->addPage,$output);
		$this->fn->getfooter();
	}	
	
	public function save()
	{
		//retrieve values
		$savValTemp=$this->input->post('txt');
		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		
		
	
		//echo implode("<br>",$savEmp);
		$this->Mmain->qIns($this->mainTable,$savValTemp);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}
	
	//delete record
	public function delete($valId)
	{		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$this->Mmain->qDel($this->mainTable,$this->mainPk,$valId);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}
	
	//update record
	public function update()
	{
		//retrieve values
		$savValTemp=$this->input->post('txt');
		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		//echo implode("<br>",$savEmp);
		$this->Mmain->qUpd($this->mainTable,$this->mainPk,$savValTemp[0],$savValTemp);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}
	
}

?>