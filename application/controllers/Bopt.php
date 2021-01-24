<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bopt extends CI_Controller 
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
	
	var $mainTable="bopt";
	var $mainPk="id_bopt";
	var $viewLink="bopt";
	var $breadcrumbTitle="Daftar BOPT";
	var $viewPage="BOPTviewpage";
	var $addPage="BOPTaddpage";
	
	//query
	var $ordQuery=" ORDER BY id_produksi ";
	var $tableQuery="
		bopt a
		INNER JOIN produksi b ON a.id_produksi = b.id_produksi
		INNER JOIN overheadtetap    c ON a.id_overheadtetap   = c.id_overhead
						";
	var $fieldQuery="a.id_bopt,a.id_produksi,c.id_overhead,c.nama_overhead"; //leave blank to show all field
						
	var $primaryKey="id_bopt";
	var $updateKey="id_bopt";
	
	//auto generate id
	var $defaultId="bopt01";
	var $prefix="bopt";
	var $suffix="01";	
	
	//view
	var $viewFormTitle="Data BOPT";
	var $viewFormTableHeader=array(
									"Id bopt",
									"Id Produksi",
									"Id OverheadTetap",
									"Nama Overhead",
									);
	//save
	var $saveFormTitle="Tambah Data BOPT";
	var $saveFormTableHeader=array(
									"Id bopt",
									"Id Produksi",
									"Id OverheadTetap",
									);
	
	//update
	var $editFormTitle="Edit Data BOPT";
	
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
		$list_overheadtetap=$this->Mmain->qRead("overheadtetap ORDER BY id_overhead","","");
		$input_overheadtetap = '';
		foreach($list_overheadtetap->result() as $row)
		{ 
			if($txtVal[2]==$row->id_overhead)
				$input_overheadtetap = $input_overheadtetap.'<option selected value="'.$row->id_overhead.'">'.$row->id_overhead." - ".$row->nama_overhead.'</option>';
			else
				$input_overheadtetap = $input_overheadtetap.'<option value="'.$row->id_overhead.'">'.$row->id_overhead." - ".$row->nama_overhead.'</option>';
		}
		$output['formTxt']=array(
								$codeTemp.
								"<input type='text' class='form-control' id='txtid0' name=txt[] value='".$txtVal[0]."' readonly>",
								"<select class='form-control' name=txt[]>".$input_produksi."
								  </select>",
								"<select class='form-control' name=txt[]>".$input_overheadtetap."
							  	</select>",
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