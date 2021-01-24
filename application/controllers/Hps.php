<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hps extends CI_Controller 
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
	var $breadcrumbTitle="Data HPS";
	var $viewPage="HPSviewpage";
	var $addPage="HPSaddpage";
	
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
	var $viewFormTitle="Data HPS";
	var $viewFormTableHeader=array(
									"Id Produksi",
									"Id Produksi",
									"Nama Barang",
									"Id Bahan",
									"Nama Bahan",
									"Jumlah",
									);
	//save
	var $saveFormTitle="Tambah Data HPS";
	var $saveFormTableHeader=array(
									"Id Produksi",
									"Id Produksi",
									"Id Bahan",
									"Jumlah",
									);
	
	//update
	var $editFormTitle="Edit Data HPS";
	
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
			array_push($list_produksi,[$row->id_produksi,$row->jumlah]);
		}
		$id_produksi = '';
		if($this->input->get('id_produksi') !== NULL){
			$id_produksi = $this->input->get('id_produksi');
		}else{
			if(!empty($list_produksi))
				$id_produksi = $list_produksi[0][0];
			else
			$id_produksi = 0;
		}
			
		$query_bbb=$this->Mmain->qRead("bbb a
			INNER JOIN bahan b ON a.qr_bahan = b.barcode
			WHERE a.id_produksi = '".$id_produksi."'","a.jumlah,b.h_beli,b.nama_bahan","");
		$total_bbb = 0;
		$data_bbb = [];
		foreach($query_bbb->result() as $row){
			$total_bbb = $total_bbb + ($row->h_beli*$row->jumlah);
			array_push($data_bbb, $row);
		}
		$query_btk=$this->Mmain->qRead("btk a
			INNER JOIN kariyawan b ON a.id_karyawan = b.id_kariyawan
			WHERE a.id_produksi = '".$id_produksi."'","b.gaji_kariyawan,a.jam_kerja, b.nama_kariyawan","");
		$total_btk= 0;
		$data_btk = [];
		foreach($query_btk->result() as $row){
			$total_btk = $total_btk + ($row->gaji_kariyawan*$row->jam_kerja);
			array_push($data_btk, $row);
		}
		$query_bopt=$this->Mmain->qRead("bopt a
			INNER JOIN overheadtetap    b ON a.id_overheadtetap   = b.id_overhead
			WHERE a.id_produksi = '".$id_produksi."'","b.harga,b.nama_overhead","");
		$total_bopt= 0;
		$data_bopt = [];
		foreach($query_bopt->result() as $row){
			$total_bopt = $total_bopt + ($row->harga);
			array_push($data_bopt, $row);
		}
		$query_bopv=$this->Mmain->qRead("bopv a
			INNER JOIN overheadvariabel    b ON a.id_overheadvariabel   = b.id_overhead
			WHERE a.id_produksi = '".$id_produksi."'","a.jumlah,b.harga,b.nama_overhead","");
		$total_bopv= 0;
		$data_bopv = [];
		foreach($query_bopv->result() as $row){
			$total_bopv = $total_bopv + ($row->harga*$row->jumlah);
			array_push($data_bopv, $row);
		}
		//init view
		
		// $renderTemp=$this->Mmain->qRead($this->tableQuery.$this->ordQuery,$this->fieldQuery,"");
		
		// $output['render']=$renderTemp;
		//init view
		$output['id_produksi']=$id_produksi;
		$output['list_produksi']=$list_produksi;
		$output['data']=[$total_bbb,$total_btk,$total_bopt,$total_bopv];
		$output['list_data']=[$data_bbb,$data_btk,$data_bopt,$data_bopv];
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