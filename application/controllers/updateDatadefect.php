<?php
class updateDatadefect extends CI_Controller
{
	public function updateDatadefectregister(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dt_wi_no = $_GET["dtWino"];
		$dt_lot_no = $_GET["dtLotNo"];
		$dt_seq_no = $_GET["dtSeqno"];
		$dt_type = $_GET["dtType"];
		$dtItemType = $_GET["dtItemType"];
		$dt_code = $_GET["dtCode"];
		$PartNo = $_GET["PartNo"];
		$sql = "update defect_transactions set dt_status_flg = '5' where dt_wi_no='{$dt_wi_no}' and dt_lot_no = '{$dt_lot_no}' and dt_seq_no = '{$dt_seq_no}' and dt_type = '{$dt_type}' and dt_code = '{$dt_code}' and dt_item_type = '{$dtItemType}' and dt_item_cd = '{$PartNo}'";
		$query = $this->TBK_FA01->query($sql);
		if ($query){
			echo "true";
		}else{
			echo "false";
		}
	}

	public function updateDefectactual(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dt_wi_no = $_GET["dtWino"];
		$dt_lot_no = $_GET["dtLotNo"];
		$dt_seq_no = $_GET["dtSeqno"];
		$dt_type = $_GET["dtType"];
		$dt_code = $_GET["dtCode"];
		$sql = "update defect_actual set da_status_flg = '5' where da_wi_no='{$dt_wi_no}' and da_lot_no = '{$dt_lot_no}' and da_seq_no = '{$dt_seq_no}' and da_type = '{$dt_type}' and da_code = '{$dt_code}' and da_transfer_flg = '0'";
		$query = $this->TBK_FA01->query($sql);
		if ($query){
			echo "true";
		}else{
			echo "false";
		}
	}

	public function updateDefectactualAdmin(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dt_wi_no = $_GET["dtWino"];
		$dt_lot_no = $_GET["dtLotNo"];
		$dt_seq_no = $_GET["dtSeqno"];
		$dt_type = $_GET["dtType"];
		$dt_code = $_GET["dtCode"];
		$dtItemType = $_GET["dtItemType"];
		$ItemCd = $_GET["ItemCd"];
		  $sql = "update defect_actual set da_status_flg = '5' where da_wi_no='{$dt_wi_no}' and da_lot_no = '{$dt_lot_no}' and da_seq_no = '{$dt_seq_no}' and da_type = '{$dt_type}' and da_code = '{$dt_code}' and da_transfer_flg = '0' and da_item_type = '{$dtItemType}' and da_item_cd  ='{$ItemCd}'";
		$query = $this->TBK_FA01->query($sql);
		if ($query){
			echo "true";
		}else{
			echo "false";
		}
	}
	public function insertDefectregister(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dt_wi_no = $_GET["dtWino"];
		$dt_line_cd = $_GET["dtLineno"];
		$dt_item_cd = $_GET["dtItemcd"];
		$dt_item_type = $_GET["dtItemtype"];
		$dt_lot_no = $_GET["dtLotNo"];
		$dt_seq_no = $_GET["dtSeqno"];
		$dt_type = $_GET["dtType"];
		$dt_code = $_GET["dtCode"];
		$dt_qty = $_GET["dtQty"];
		$dt_menu = $_GET["dtMenu"];
		$dt_actual_date = $_GET["dtActualdate"];
		$dt_status_flg = 1;//$_GET["dtStatusflg"];
		$sql  = "
				INSERT into defect_transactions (
					dt_wi_no,
					dt_line_cd,
					dt_item_cd,
					dt_item_type,
					dt_lot_no,
					dt_seq_no,
					dt_type,
					dt_code,
					dt_qty,
					dt_menu,
					dt_actual_date,
					dt_status_flg,
					dt_created_date,
					dt_created_by,
					dt_updated_date,
					dt_updated_by
					) Values(
					'{$dt_wi_no}',
					'{$dt_line_cd}',
					'{$dt_item_cd}',
					'{$dt_item_type}',
					'{$dt_lot_no}',
					'{$dt_seq_no}',
					'{$dt_type}',
					'{$dt_code}',
					'{$dt_qty}',
					'{$dt_menu}',
					'{$dt_actual_date}',
					'{$dt_status_flg}',
					 CURRENT_TIMESTAMP,
					'{$dt_line_cd}',
					 CURRENT_TIMESTAMP,
					'{$dt_line_cd}'
					)
		";
		$query = $this->TBK_FA01->query($sql);
		if($query){
			echo "true";
		}else{
			echo "false";
		}
	}
}
?>