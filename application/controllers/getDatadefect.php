<?php
class getDatadefect extends CI_Controller
{
	public function GetDataAdminAdjust(){
		
	}
	public function getChildpart(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$wi = $_GET["wi"];
		$sql  = "select * from sup_work_plan_supply_dev where WI='$wi' and LVL='2' ";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function GetDefect(){
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$WI = $_GET["wi"];
		$lotNo = $_GET["lotNo"];
		$shift = $_GET["shift"];
		$sql = "SELECT
				ISNULL(SUM( da.da_qty ), 0) As TotalDefect
			FROM
			production_actual as pd, 
			defect_actual as da
			WHERE
			pd.wi = '{$WI}' and 
			pd.lot_no = '{$lotNo}' and 
			pd.shift_prd = '{$shift}' and 
			pd.wi= da.da_wi_no  
			AND pd.lot_no = da.da_lot_no  
			AND da.da_status_flg = '1' 
			AND da.da_item_type = '1'"; 
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo $get[0]["TotalDefect"];
		}

	}
	public function getDataDefectDMS(){
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$sql  = "EXEC [dbo].[GET_DATA_DEFECT]";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function getQtyofdefectcode(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dt_wi_no = $_GET["dtWino"];
		$dt_lot_no = $_GET["dtLotNo"];
		$dt_seq_no = $_GET["dtSeqno"];
		$dt_type = $_GET["dtType"];
		$dt_code = $_GET["dtCode"];
		$ItemCd = $_GET["ItemCd"];
		  $sql = "SELECT sum(da_qty) as qty from defect_actual 
				where   da_wi_no='{$dt_wi_no}' and 
				da_lot_no = '{$dt_lot_no}' and 
				da_seq_no = '{$dt_seq_no}' and 
				da_type = '{$dt_type}' and da_code = '{$dt_code}' and da_status_flg = '1' and da_item_cd = '{$ItemCd}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get) || $get["0"]["qty"]== ""){
			echo "0";
		}else{
			echo  $get["0"]["qty"];
		}
	}
	public function getDataplan(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$itemCd = $_GET["itemCd"];
		$flg = $_GET["flg"];

		$sql = "SELECT TOP 1  *  from sup_work_plan_supply_dev where ITEM_CD = '{$itemCd}' and LVL = '{$flg}'  ";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function getDatadefectcodeprint(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$wi = $_GET["wi"];
		$lot = $_GET["lot"];
		$seq_no = $_GET["seqNo"];
		$item_cd = $_GET["itemCd"];
		$dfType = $_GET["dfType"];
	  	$sql = " SELECT da_item_cd ,  da_code , sum(da_qty) as total_defect ,
					(select sum (da_qty)  from defect_actual where 	  
					    da_wi_no = '{$wi}' and 
		  				da_lot_no = '{$lot}' and 
		  				da_seq_no = '{$seq_no}' and 
		 				da_item_cd = '{$item_cd}' and 
		 				da_type =  '{$dfType}' and 
		 			    da_status_flg = '1' ) as total_defect_all
		  from defect_actual 
		  where da_wi_no = '{$wi}' and 
		  da_lot_no = '{$lot}' and 
		  da_seq_no = '{$seq_no}' and 
		  da_item_cd = '{$item_cd}' and
		  da_type  = '{$dfType}' and 
		  da_status_flg = '1'
		  GROUP BY da_item_cd , da_code ";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function getBoxInformation(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$wi = $_GET["wi"];
		$lot = $_GET["lot"];
		$seq = $_GET["seq"];
		$sql = "SELECT COUNT(dti_id) as box_no FROM defect_tag_information  WHERE dti_wi_no = '{$wi}' 
	AND dti_lot_no ='{$lot}' AND dti_seq_no = '{$seq}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo $get[0]["box_no"];
		}
	}
	public function getDefectadmindetailncFG(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$LineCd = $_GET["LineCd"];
		$LsDate = $_GET["sDate"];
		$LeDate = $_GET["eDate"];
		// if (date("H:i:s") >= "00:00:00" And date("H:i:s")<="07:59:59"){
  		// 	$sDate = date($LsDate,strtotime('-1 day'))." 20:00:00";
		// 	$eDate = $LeDate." 07:59:59";
		// }else{
		// 	$sDate = $LsDate." 08:00:00";
		// 	$eDate = $LeDate." 19:59:59";
		// }
		if (date('H') == "20"){
			// $sDate = date('Y-m-d',strtotime($LsDate , '-1 day'))." 20:00:00";
			if(date('H') == "00"){
				$sDate  =  date('Y-m-d', strtotime($LsDate . "-1 days"))." 20:00:00";
			}else{
				$sDate  =$LsDate." 20:00:00";
			}
			if(date('H') >= "00" && date('H') <= "07"){
				$eDate = $LeDate." 07:59:59";
			}else{
				$eDate  =  date('Y-m-d', strtotime($LeDate . "+1 days"))." 07:59:59";
			}
	  }else{
		  $sDate = $LsDate." 08:00:00";
		  $eDate = $LeDate." 19:59:59";
	  }


			  $sql = "SELECT
			 A.WI AS WI,
			 A.LINE_CD AS LINE_CD,
			 A.SEQ_NO AS SEQ_NO,
			 A.LOT_NO AS LOT_NO,
			 ISNULL( B.ITEM_CD , A.ITEM_CD ) AS ITEM_CD,
			 A.SHIFT AS SHIFT,
			 A.ACT_QTY AS ACT_QTY,
			 ISNULL( ( A.ACT_QTY - B.DEF_QTY ), A.ACT_QTY ) AS GOOD_QTY,
			 ISNULL( B.DEF_QTY , 0 ) AS DEF_QTY ,
			 ISNULL(F.TOTAL_DEFECT  , 0) AS TOTAL_DEFECT
		 FROM
			 (
			 SELECT
				 wi AS WI,
				 line_cd AS LINE_CD,
				 item_cd AS ITEM_CD,
				 seq_no AS SEQ_NO,
				 shift_prd AS SHIFT,
				 plan_qty AS PLAN_QTY,
				 act_qty AS ACT_QTY,
				 lot_no AS LOT_NO,
				 NULL AS DEF_QTY 
			 FROM
				 production_actual 
			 WHERE
				 line_cd = '{$LineCd}' 
				 AND prd_st_date BETWEEN '{$sDate}' 
				 AND '{$eDate}' 
				 AND act_qty <> '0' 
			 ) AS A

			 LEFT JOIN(
		SELECT SUM
		( da_qty ) AS TOTAL_DEFECT,
		da_wi_no,
		da_seq_no 
	FROM
		defect_actual 
	WHERE
		da_status_flg != '5' 
		AND da_transfer_flg = '0' 
		AND da_line_cd = '{$LineCd}' 
		AND da_created_date BETWEEN '{$sDate}'  
		AND '{$eDate}' 
		AND da_item_type = '1' 
	GROUP BY
		da_wi_no,
		da_line_cd,
		da_seq_no,
		da_lot_no 
		) as F   ON A.WI = F.da_wi_no 
	AND A.SEQ_NO = F.da_seq_no 
			 LEFT OUTER JOIN (
			 SELECT
				 da_wi_no AS WI,
				 da_line_cd AS LINE_CD,
				 da_item_cd AS ITEM_CD,
				 da_seq_no AS SEQ_NO,
				 NULL AS SHIFT,
				 NULL AS PLAN_QTY,
				 NULL AS ACT_QTY,
				 da_lot_no AS LOT_NO,
				 SUM ( da_qty ) AS DEF_QTY 
			 FROM
				 defect_actual 
			 WHERE
				 da_type = '2' 
				 AND da_status_flg != '5' 
				 AND da_item_type = '1'
			 GROUP BY
				 da_wi_no,
				 da_line_cd,
				 da_item_cd,
				 da_seq_no,
				 da_lot_no 
			 ) B ON A.WI = B.WI 
			 AND A.SEQ_NO = B.SEQ_NO
				 LEFT OUTER JOIN (
			 SELECT
				 da_wi_no AS WI,
				 da_line_cd AS LINE_CD,
				 NULL AS ITEM_CD,
				 da_seq_no AS SEQ_NO,
				 NULL AS SHIFT,
				 NULL AS PLAN_QTY,
				 NULL AS ACT_QTY,
				 da_lot_no AS LOT_NO,
				 SUM ( da_qty ) AS TOTAL_DEFECT ,
				 da_seq_no
			 FROM
				 defect_actual
			 WHERE
				  da_status_flg != '5' 
				 AND da_item_type = '1'
			 GROUP BY
				 da_wi_no,
				 da_line_cd,
				 da_seq_no,
				 da_lot_no 
			 ) C ON B.WI = C.WI 
		 AND B.SEQ_NO = C.SEQ_NO
		 LEFT JOIN(
			SELECT
				 SUM ( da_qty ) AS TOTAL_DEFECT,
				 da_wi_no,
				 da_seq_no 
			 FROM
				 defect_actual 
			 WHERE
				 da_status_flg != '5' 
				 AND da_transfer_flg = '0' 
				 AND da_line_cd = '{$LineCd}'
				 AND da_created_date BETWEEN '{$sDate}'  AND '{$eDate}' 
				 AND da_item_type = '1'
			 GROUP BY
				 da_wi_no,
				 da_line_cd,
				 da_seq_no,
				 da_lot_no
		 ) D ON C.WI = D.da_wi_no 
		AND C.da_seq_no = D.da_seq_no 
		 ORDER BY
			 A.SEQ_NO ASC ";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}

	public function getDefectadmindetailngFG(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$LineCd = $_GET["LineCd"];
		$LsDate = $_GET["sDate"];
		$LeDate = $_GET["eDate"];
		// if (date("H:i:s") >= "00:00:00" And date("H:i:s")<="07:59:59"){
  		// 	$sDate = date($LsDate,strtotime('-1 day'))." 20:00:00";
		// 	$eDate = $LeDate." 07:59:59";
		// }else{
		// 	$sDate = $LsDate." 08:00:00";
		// 	$eDate = $LeDate." 19:59:59";
		// }
		// if (date("H:i:s") >= "00:00:00" And date("H:i:s")<="07:59:59"){
  		// 	$sDate = date($sDate,strtotime('-1 day'));
		// }
		if (date('H') == "20"){
			// $sDate = date('Y-m-d',strtotime($LsDate , '-1 day'))." 20:00:00";
			if(date('H') == "00"){
				$sDate  =  date('Y-m-d', strtotime($LsDate . "-1 days"))." 20:00:00";
			}else{
				$sDate  =$LsDate." 20:00:00";
			}
			if(date('H') >= "00" && date('H') <= "07"){
				$eDate = $LeDate." 07:59:59";
			}else{
				$eDate  =  date('Y-m-d', strtotime($LeDate . "+1 days"))." 07:59:59";
			}
	  }else{
		  $sDate = $LsDate." 08:00:00";
		  $eDate = $LeDate." 19:59:59";
	  }
		      $sql = "SELECT
					A.WI AS WI,
					A.LINE_CD AS LINE_CD,
					A.SEQ_NO AS SEQ_NO,
					A.LOT_NO AS LOT_NO,
					ISNULL( B.ITEM_CD , A.ITEM_CD ) AS ITEM_CD,
					A.SHIFT AS SHIFT,
					A.ACT_QTY AS ACT_QTY,
					ISNULL( ( A.ACT_QTY - B.DEF_QTY ), A.ACT_QTY ) AS GOOD_QTY,
					ISNULL( B.DEF_QTY , 0 ) AS DEF_QTY ,
					ISNULL(F.TOTAL_DEFECT, 0) AS TOTAL_DEFECT
				FROM
					(
					SELECT
						wi AS WI,
						line_cd AS LINE_CD,
						item_cd AS ITEM_CD,
						seq_no AS SEQ_NO,
						shift_prd AS SHIFT,
						plan_qty AS PLAN_QTY,
						act_qty AS ACT_QTY,
						lot_no AS LOT_NO,
						NULL AS DEF_QTY 
					FROM
						production_actual 
					WHERE
						line_cd = '{$LineCd}' 
						AND prd_st_date BETWEEN '{$sDate}' 
						AND '{$eDate}' 
						AND act_qty <> '0' 
					) AS A
					LEFT JOIN(
						SELECT SUM
						( da_qty ) AS TOTAL_DEFECT,
						da_wi_no,
						da_seq_no 
					FROM
						defect_actual 
					WHERE
						da_status_flg != '5' 
						AND da_transfer_flg = '0' 
						AND da_line_cd = '{$LineCd}' 
						AND da_created_date BETWEEN '{$sDate}'  
						AND '{$eDate}' 
						AND da_item_type = '1' 
					GROUP BY
						da_wi_no,
						da_line_cd,
						da_seq_no,
						da_lot_no 
						) as F   ON A.WI = F.da_wi_no 
					AND A.SEQ_NO = F.da_seq_no 
					LEFT OUTER JOIN (
					SELECT
						da_wi_no AS WI,
						da_line_cd AS LINE_CD,
						da_item_cd AS ITEM_CD,
						da_seq_no AS SEQ_NO,
						NULL AS SHIFT,
						NULL AS PLAN_QTY,
						NULL AS ACT_QTY,
						da_lot_no AS LOT_NO,
						SUM ( da_qty ) AS DEF_QTY 
					FROM
						defect_actual 
					WHERE
						da_type = '1' 
						AND da_status_flg != '5' 
						AND da_item_type = '1'
					GROUP BY
						da_wi_no,
						da_line_cd,
						da_item_cd,
						da_seq_no,
						da_lot_no 
					) B ON A.WI = B.WI 
					AND A.SEQ_NO = B.SEQ_NO
						LEFT OUTER JOIN (
					SELECT
						da_wi_no AS WI,
						da_line_cd AS LINE_CD,
						NULL AS ITEM_CD,
						da_seq_no AS SEQ_NO,
						NULL AS SHIFT,
						NULL AS PLAN_QTY,
						NULL AS ACT_QTY,
						da_lot_no AS LOT_NO,
						SUM ( da_qty ) AS TOTAL_DEFECT ,
						da_seq_no
					FROM
						defect_actual 
					WHERE
						 da_status_flg != '5' 
						AND da_item_type = '1' 
					GROUP BY
						da_wi_no,
						da_line_cd,
						da_seq_no,
						da_lot_no 
					) C ON B.WI = C.WI 
				AND B.SEQ_NO = C.SEQ_NO

				LEFT JOIN (
		
		SELECT SUM
			( da_qty ) AS TOTAL_DEFECT ,
			da_wi_no,
			da_seq_no
		FROM
			defect_actual 
		WHERE
			da_status_flg != '5' 
			AND da_transfer_flg = '0' 
			AND da_line_cd = '{$LineCd}' 
			AND da_created_date BETWEEN '{$sDate}' 
			AND '{$eDate}' 
			AND da_item_type = '1' 
		GROUP BY
			da_wi_no,
			da_line_cd,
			da_seq_no,
			da_lot_no 
		) D ON C.WI = D.da_wi_no 
		AND C.da_seq_no = D.da_seq_no
				ORDER BY
					A.SEQ_NO ASC";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function getDefectactualadmin(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$lineCd = $_GET["LineCd"];
		$sDate = $_GET["sDate"];
		$eDate = $_GET["eDate"];
		$sql  = "SELECT
				da.da_item_cd,
				da.da_code,
				da.da_qty AS total_nc,
				da.da_item_type ,
				sdm.description
			FROM
				defect_actual as da, 
				sys_defect_mst as sdm
			WHERE
				da.da_line_cd = '{$lineCd}' 
				AND da.da_actual_date Between '{$sDate} 08:00:00' and '{$eDate} 23:59:59' 
				AND da.da_type = '2' 
				AND da.da_code = sdm.defect_cd
				And da.da_status_flg = '1'
				ANd da.da_transfer_flg != '1'
			GROUP BY
				da.da_item_cd,
				da.da_code,
				da.da_qty,
				da.da_item_type ,
				sdm.description
				order by da.da_item_type asc";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function getDefectcode(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		// $sql  = "select * from sys_defect_mst where enable = '1'";
		$LineCd= $_GET["LineCd"];
		$sql  = "EXEC [dbo].[GetDataGroupDefectByLine] @LineCd = '{$LineCd}'";
		$query = $this->TBK_FA01->query($sql);

		$get = $query->result_array();   
		if(empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function getDefectnc(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dfWi = $_GET["dfWi"];
		$dfSeq = $_GET["dfSeq"];
		$dfLot = $_GET["dfLot"];
		$dfType = $_GET["dfType"];
		 $sql = "SELECT
				dt.dt_item_cd,
				dt.dt_code,
				SUM (dt.dt_qty) AS total_nc,
				dt.dt_item_type ,
				sdm.description,
				defect_name
			FROM
				defect_transactions as dt, 
				sys_defect_mst as sdm
			WHERE
				dt.dt_wi_no = '{$dfWi}' 
				AND dt.dt_seq_no = '{$dfSeq}' 
				AND dt.dt_lot_no = '{$dfLot}' 
				AND dt.dt_type = '{$dfType}' 
				AND dt.dt_code = sdm.defect_cd
				And dt.dt_status_flg = '1'
			GROUP BY
				dt.dt_item_cd,
				dt.dt_code,
				dt.dt_item_type ,
				sdm.description,
				defect_name
				order by dt.dt_item_type asc";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function getDefectncPartNo(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dfWi = $_GET["dfWi"];
		$dfSeq = $_GET["dfSeq"];
		$dfLot = $_GET["dfLot"];
		$dfType = $_GET["dfType"];
		$PartNo = $_GET["PartNo"];
		 $sql = "SELECT
				 ISNULL(SUM(dt.dt_qty) , 0) AS total_nc
				 FROM
					 defect_transactions as dt, 
					 sys_defect_mst as sdm
			WHERE
				dt.dt_wi_no = '{$dfWi}' 
				AND dt.dt_seq_no = '{$dfSeq}' 
				AND dt.dt_lot_no = '{$dfLot}' 
				AND dt.dt_type = '{$dfType}' 
				AND dt.dt_code = sdm.defect_cd
				And dt.dt_status_flg = '1'
				AND dt.dt_item_cd = '{$PartNo}'
		";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo $get[0]["total_nc"];
		}
	}
	public function  Getdatachildpartsummarychild(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dfWi = $_GET["dfWi"];
		$dfSeq = $_GET["dfSeq"];
		$dfLot = $_GET["dfLot"];
		 $sql = "SELECT
						dt.dt_item_cd,
						dt.dt_code,
						SUM ( dt.dt_qty ) AS total_nc,
						dt.dt_item_type ,
						sdm.description ,
						dt.dt_type,
						sdm.defect_name
					FROM
						defect_transactions AS dt,
						sys_defect_mst AS sdm 
					WHERE
						dt.dt_wi_no = '{$dfWi}' 
						AND dt.dt_seq_no = '{$dfSeq}' 
						AND dt.dt_lot_no = '{$dfLot}' 
						AND dt.dt_code = sdm.defect_cd 
						AND dt.dt_status_flg = '1' 
						AND dt.dt_item_type = '2'
						AND dt.dt_qty <> '0'
					GROUP BY
						dt.dt_item_cd,
						dt.dt_code,
						dt.dt_item_type,
						sdm.description ,
						dt.dt_type,
						sdm.defect_name
					ORDER BY
						dt.dt_item_type ASC";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}

	public function  Getdatachildpartsummarychildgrouppart(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dfWi = $_GET["dfWi"];
		$dfSeq = $_GET["dfSeq"];
		$dfLot = $_GET["dfLot"];
		$dfType = $_GET["dfType"];
		 $sql = "SELECT
						dt.dt_item_cd,
						SUM ( dt.dt_qty ) AS total_nc,
						dt.dt_item_type 
					FROM
						defect_transactions AS dt,
						sys_defect_mst AS sdm 
					WHERE
						dt.dt_wi_no = '{$dfWi}' 
						AND dt.dt_seq_no = '{$dfSeq}' 
						AND dt.dt_lot_no = '{$dfLot}' 
						AND dt.dt_code = sdm.defect_cd 
						AND dt.dt_status_flg = '1' 
						AND dt.dt_item_type = '2'
						AND dt.dt_type = '{$dfType}'
						AND dt.dt_qty <> '0'
					GROUP BY
						dt.dt_item_cd,
						dt.dt_item_type
					ORDER BY
						dt.dt_item_type ASC";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function  GetdatachildpartsummarychildgrouppartAdminAdjust(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dfWi = $_GET["dfWi"];
		$dfSeq = $_GET["dfSeq"];
		$dfLot = $_GET["dfLot"];
		$dfType = $_GET["dfType"];
		$ItemCd = $_GET["ItemCd"];
		 $sql = "SELECT
						dt.dt_item_cd,
						SUM ( dt.dt_qty ) AS total_nc,
						dt.dt_item_type 
					FROM
						defect_transactions AS dt,
						sys_defect_mst AS sdm 
					WHERE
						dt.dt_wi_no = '{$dfWi}' 
						AND dt.dt_seq_no = '{$dfSeq}' 
						AND dt.dt_lot_no = '{$dfLot}' 
						AND dt.dt_code = sdm.defect_cd 
						AND dt.dt_status_flg = '1' 
						AND dt.dt_item_type = '2'
						AND dt.dt_type = '{$dfType}'
						AND dt.dt_qty <> '0'
						AND dt.dt_item_cd = '{$ItemCd}' 
					GROUP BY
						dt.dt_item_cd,
						dt.dt_item_type
					ORDER BY
						dt.dt_item_type ASC";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}



	public function  Getdatachildpartsummaryfg(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dfWi = $_GET["dfWi"];
		$dfSeq = $_GET["dfSeq"];
		$dfLot = $_GET["dfLot"];
		 $sql = "SELECT
						dt.dt_item_cd,
						dt.dt_code,
						SUM ( dt.dt_qty ) AS total_nc,
						dt.dt_item_type ,
						sdm.description ,
						dt.dt_type,
						sdm.defect_name
					FROM
						defect_transactions AS dt,
						sys_defect_mst AS sdm 
					WHERE
						dt.dt_wi_no = '{$dfWi}' 
						AND dt.dt_seq_no = '{$dfSeq}' 
						AND dt.dt_lot_no = '{$dfLot}' 
						AND dt.dt_code = sdm.defect_cd 
						AND dt.dt_status_flg = '1' 
						AND dt.dt_item_type = '1'
						AND dt.dt_qty <> '0'
					GROUP BY
						dt.dt_item_cd,
						dt.dt_code,
						dt.dt_item_type,
						sdm.description ,
						dt.dt_type,
						sdm.defect_name
					ORDER BY
						dt.dt_item_type ASC";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}


		public function  Getdatachildpartsummaryfggrouppart(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$dfWi = $_GET["dfWi"];
		$dfSeq = $_GET["dfSeq"];
		$dfLot = $_GET["dfLot"];
		$dfType = $_GET["dfType"];
		 $sql = "SELECT
						dt.dt_item_cd,
						SUM ( dt.dt_qty ) AS total_nc,
						dt.dt_item_type 
					FROM
						defect_transactions AS dt,
						sys_defect_mst AS sdm 
					WHERE
						dt.dt_wi_no = '{$dfWi}' 
						AND dt.dt_seq_no = '{$dfSeq}' 
						AND dt.dt_lot_no = '{$dfLot}' 
						AND dt.dt_code = sdm.defect_cd 
						AND dt.dt_status_flg = '1' 
						AND dt.dt_item_type = '1'
						AND dt.dt_type = '{$dfType}'
						AND dt.dt_qty <> '0'
					GROUP BY
						dt.dt_item_cd,
						dt.dt_item_type
					ORDER BY
						dt.dt_item_type ASC";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function GetMainPartNo(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$Wi = $_GET["Wi"];
		$sql = "select ITEM_CD from sup_work_plan_supply_dev where WI = '{$Wi}' and LVL='1'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo $get[0]["ITEM_CD"];
		}
	}
	public function GetDataPlan_wi_partNo(){
		$Wi = $_GET["Wi"];
		$PartNo = $_GET["PartNo"];
		$this->TBK_FA01 = $this->load->database('tbkkfa01_db', true);
		$sql = "select TOP 1 * from sup_work_plan_supply_dev where WI = '{$Wi}' and ITEM_CD='{$PartNo}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo  json_encode($get);
		}
	}
	public function GetDataPlan_wi_partNo_dev(){
		$Wi = $_GET["Wi"];
		$PartNo = $_GET["PartNo"];
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$sql = "select TOP 1 * from sup_work_plan_supply_dev where WI = '{$Wi}' and ITEM_CD='{$PartNo}'";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo  json_encode($get);
		}
	}
	public function GetItemType($itemType){
		$status = "0";
		if($itemType == "FG"){
			$status = "1";
		}else{
			$status = "2";
		}
		return $status;
	}
	public function GetType($Type){
		$status = "0";
		if($Type == "FG"){
			$status = "1";
		}else{
			$status = "2";
		}
		return $status;
	}
	public function GetPartBySelectDateWi(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$LineCd = $_GET["LineCd"];
		$LsDate = $_GET["sDate"];
		$LeDate = $LsDate;
		$Shift = $_GET["Shift"];
		$wi =  $_GET["Wi"];
		$itemType = $this->GetItemType($_GET["itemType"]);
		$seqNo =  $_GET["seqNo"];
		$Type = $_GET["Type"];
		// if ($Shift == "Q" || $Shift == "B"){
  		// 	$sDate = date($LsDate,strtotime('-1 day'))." 20:00:00";
		// 	$eDate = $LeDate." 07:59:59";
		// }else{
		// 	$sDate = $LsDate." 08:00:00";
		// 	$eDate = $LeDate." 19:59:59";
		// }
		if ($Shift == "Q" || $Shift == "B"){
			// $sDate = date('Y-m-d',strtotime($LsDate , '-1 day'))." 20:00:00";
			if(date('H') == "00"){
				$sDate  =  date('Y-m-d', strtotime($LsDate . "-1 days"))." 20:00:00";
			}else{
				$sDate  =$LsDate." 20:00:00";
			}
			if(date('H') >= "00" && date('H') <= "07"){
				$eDate = $LeDate." 07:59:59";
			}else{
				$eDate  =  date('Y-m-d', strtotime($LeDate . "+1 days"))." 07:59:59";
			}
	  }else{
		  $sDate = $LsDate." 08:00:00";
		  $eDate = $LeDate." 19:59:59";
	  }
	           $sql = "SELECT
				pda.wi ,
				dfa.da_item_cd,
				dfa.da_seq_no,
				dfa.da_lot_no,
				dfa.da_code,
				dfa.da_qty ,
				sdm.description ,
				sdm.defect_name,
					( SELECT 
						ISNULL(SUM ( da_qty ), 0) FROM defect_actual WHERE da_wi_no = '{$wi}' AND da_seq_no = '{$seqNo}' AND da_type = '2'  AND da_status_flg = '1' AND da_item_type = '1' 	AND da_actual_date BETWEEN '$sDate' and '$eDate' AND defect_actual.da_transfer_flg = '0') AS TOTAL_NC ,
					( SELECT ISNULL(SUM ( da_qty ), 0) FROM defect_actual WHERE da_wi_no = '{$wi}' AND da_seq_no = '{$seqNo}'   AND da_type = '1'  AND da_status_flg = '1' AND da_item_type = '1' 	AND da_actual_date BETWEEN '$sDate' and '$eDate' AND defect_actual.da_transfer_flg = '0') AS TOTAL_NG ,
					( SELECT  act_qty FROM production_actual WHERE wi = '{$wi}' AND seq_no = '{$seqNo}' AND  prd_st_date BETWEEN'$sDate' and '$eDate' ) AS TOTAL_ACTUAL 
				FROM
					production_actual AS pda
					LEFT JOIN defect_actual AS dfa ON dfa.da_line_cd = pda.line_cd 
				  AND pda.lot_no = dfa.da_lot_no
				  AND pda.wi = '{$wi}'
				  AND pda.seq_no = '{$seqNo}'  
			      AND dfa.da_item_type = '{$itemType}'
				  AND pda.prd_st_date BETWEEN '$sDate' and '$eDate'
				  AND pda.shift_prd = '{$Shift}'
				  AND dfa.da_type = '{$Type}'
				  LEFT JOIN sys_defect_mst AS sdm ON dfa.da_code = sdm.defect_cd 
				    AND sdm.enable = '1' 
					AND sdm.del_flg = '0'
					AND dfa.da_status_flg = '1'
				where 
					pda.wi = '{$wi}' AND 
			        dfa.da_item_type = '{$itemType}'
				    AND pda.seq_no = '{$seqNo}'  
				 	AND dfa.da_seq_no = '{$seqNo}' 
					AND pda.prd_st_date BETWEEN '$sDate' and '$eDate'
					AND pda.shift_prd = '{$Shift}'
					AND dfa.da_type = '{$Type}'
					AND dfa.da_status_flg = '1'
					AND dfa.da_transfer_flg = '0'
					GROUP BY 
					pda.wi ,
					dfa.da_item_cd,
					dfa.da_seq_no,
					dfa.da_lot_no,
					dfa.da_code,
					dfa.da_qty ,
					sdm.description ,
					sdm.defect_name";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
	public function GetPartBySelectDate(){
		parse_str($_SERVER['QUERY_STRING'], $_GET); 
		$this->TBK_FA01 = $this->load->database('test_new_fa02', true);
		$LineCd = $_GET["LineCd"];
		$sDate = $_GET["sDate"];
		$eDate = $sDate;
		$Shift = $_GET["Shift"];
		$Type = $_GET["Type"];
		$LsDate =  $sDate;
		$LeDate = $LsDate;
		if ($Shift == "Q" || $Shift == "B"){
			// $sDate = date('Y-m-d',strtotime($LsDate , '-1 day'))." 20:00:00";
			if(date('H') == "00"){
				$sDate  =  date('Y-m-d', strtotime($LsDate . "-1 days"))." 20:00:00";
			}else{
				$sDate  =$LsDate." 20:00:00";
			}
			if(date('H') >= "00" && date('H') <= "07"){
				$eDate = $LeDate." 07:59:59";
			}else{
				$eDate  =  date('Y-m-d', strtotime($LeDate . "+1 days"))." 07:59:59";
			}
	  }else{
		  $sDate = $LsDate." 08:00:00";
		  $eDate = $LeDate." 19:59:59";
	  }
	      $sql = "SELECT
					dfa.da_wi_no , 
					--dfa.da_item_cd,
					(select top 1 pda.item_cd from production_actual AS pda  , defect_actual AS dfa where pda.wi =dfa.da_wi_no) AS da_item_cd,
					dfa.da_seq_no,
					dfa.da_lot_no
				FROM
					production_actual AS pda
					LEFT JOIN defect_actual AS dfa ON dfa.da_line_cd = pda.line_cd 
				 and pda.lot_no = dfa.da_lot_no
					AND pda.prd_st_date BETWEEN '$sDate' and '$eDate' 
					AND pda.shift_prd = '{$Shift}'
					--AND dfa.da_item_type = '1'
					AND dfa.da_status_flg = '1'
					AND dfa.da_type = '{$Type}'
				where 
				    pda.prd_st_date BETWEEN '$sDate' and '$eDate' 
					AND pda.shift_prd = '{$Shift}'
					--AND dfa.da_item_type = '1'
					AND dfa.da_status_flg = '1'
					AND dfa.da_type = '{$Type}'
					GROUP BY 
					dfa.da_wi_no , 
				--	dfa.da_item_cd,
					dfa.da_seq_no,
					dfa.da_lot_no Order by dfa.da_seq_no asc";
		$query = $this->TBK_FA01->query($sql);
		$get = $query->result_array();
		if (empty($get)){
			echo "0";
		}else{
			echo json_encode($get);
		}
	}
}
?>