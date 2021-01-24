<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Btk extends CI_Controller 
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
	
	var $mainTable="btk";
	var $mainPk="id_btk";
	var $viewLink="btk";
	var $breadcrumbTitle="Daftar BTK";
	var $viewPage="BTKviewpage";
	var $addPage="BTKaddpage";
	
	//query
	var $ordQuery=" ORDER BY id_produksi ";
	var $tableQuery="
		btk a
		INNER JOIN produksi b ON a.id_produksi = b.id_produksi
		INNER JOIN kariyawan    c ON a.id_karyawan   = c.id_kariyawan
						";
	var $fieldQuery="a.id_btk,a.id_produksi,c.id_kariyawan,c.nama_kariyawan,c.type_kariyawan,a.jam_kerja"; //leave blank to show all field
						
	var $primaryKey="id_btk";
	var $updateKey="id_btk";
	
	//auto generate id
	var $defaultId="btk01";
	var $prefix="btk";
	var $suffix="01";	
	
	//view
	var $viewFormTitle="Data BTK";
	var $viewFormTableHeader=array(
									"Id BTK",
									"Id Produksi",
									"Id Karyawan",
									"Nama Karyawan",
									"Pekerjaan",
									"Jam Kerja (per Hari)",
									);
	//save
	var $saveFormTitle="Tambah Data BTK";
	var $saveFormTableHeader=array(
									"Id btk",
									"Id Produksi",
									"Id Karyawan",
									"Jam Kerja (per Hari)",
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
		$list_kariyawan=$this->Mmain->qRead("kariyawan ORDER BY id_kariyawan","","");
		$input_kariyawan = '';
		foreach($list_kariyawan->result() as $row)
		{ 
			if($txtVal[2]==$row->id_kariyawan)
				$input_kariyawan = $input_kariyawan.'<option selected value="'.$row->id_kariyawan.'">'.$row->id_kariyawan." - ".$row->nama_kariyawan." - ".$row->type_kariyawan.'</option>';
			else
				$input_kariyawan = $input_kariyawan.'<option value="'.$row->id_kariyawan.'">'.$row->id_kariyawan." - ".$row->nama_kariyawan." - ".$row->type_kariyawan.'</option>';
		}
		$output['formTxt']=array(
								$codeTemp.
								"<input type='text' class='form-control' id='txtid0' name=txt[] value='".$txtVal[0]."' readonly>",
								"<select class='form-control' name=txt[]>".$input_produksi."
								  </select>",
								"<select class='form-control' name=txt[]>".$input_kariyawan."
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