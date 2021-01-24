<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bbb extends CI_Controller 
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
	
	var $mainTable="bbb";
	var $mainPk="id_bbb";
	var $viewLink="bbb";
	var $breadcrumbTitle="Daftar BBB";
	var $viewPage="BBBviewpage";
	var $addPage="BBBaddpage";
	
	//query
	var $ordQuery=" ORDER BY id_produksi ";
	var $tableQuery="
		bbb a
		INNER JOIN produksi b ON a.id_produksi = b.id_produksi
		INNER JOIN bahan    c ON a.qr_bahan   = c.barcode
						";
	var $fieldQuery="a.id_bbb,a.id_produksi,b.nama_barang,c.barcode,c.nama_bahan,a.jumlah"; //leave blank to show all field
						
	var $primaryKey="id_bbb";
	var $updateKey="id_bbb";
	
	//auto generate id
	var $defaultId="bbb01";
	var $prefix="bbb";
	var $suffix="01";	
	
	//view
	var $viewFormTitle="Data Penggunaan Bahan";
	var $viewFormTableHeader=array(
									"Id BBB",
									"Id Produksi",
									"Nama Barang",
									"Id Bahan",
									"Nama Bahan",
									"Jumlah (kg)",
									);
	//save
	var $saveFormTitle="Tambah Data Penggunaan Bahan";
	var $saveFormTableHeader=array(
									"Id BBB",
									"Id Produksi",
									"Id Bahan",
									"Jumlah (kg)",
									);
	
	//update
	var $editFormTitle="Edit Data Penggunaan Bahan";
	
	/*	
		========================================================== General Function =========================================================
	*/
	
	public function index()
	{
		//init modal
		$this->load->database();
		$this->load->model('Mmain');
		
			
		
		//init view
		
		$renderTemp=$this->Mmain->qRead($this->tableQuery.$this->ordQuery,$this->fieldQuery,"");
		
		$output['render']=$renderTemp;
		//init view
		$output['pageTitle']=$this->viewFormTitle;
		$output['breadcrumbTitle']=$this->breadcrumbTitle;
		$output['breadcrumbLink']=$this->viewLink;
		$output['saveLink']=$this->viewLink."/add";
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
		$list_bahan=$this->Mmain->qRead("bahan ORDER BY barcode","","");
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
		$bahan=$this->Mmain->qRead("bahan WHERE barcode = '".$savValTemp[2]."'","","")->result();
		if($bahan[0]->jumlah-$savValTemp[3]<0){
			$message = "Jumlah bahan melebihi stok";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<script type='text/javascript'>window.history.go(-1);</script>";
		}else{
			$this->Mmain->qUpd('bahan','barcode',$bahan[0]->barcode,[$bahan[0]->barcode,$bahan[0]->nama_bahan,$bahan[0]->h_beli,$bahan[0]->jumlah-$savValTemp[3]]);

			//echo implode("<br>",$savEmp);
			$this->Mmain->qIns($this->mainTable,$savValTemp);
		
			//redirect to form
			redirect($this->viewLink,'refresh');	
		}	
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