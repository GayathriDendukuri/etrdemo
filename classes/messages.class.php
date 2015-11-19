<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 07/02/2014                                      *
 * Created By : Gayathri                                          *
 * Vision : Project Infofame                                       *  
 * Modified by : Gayathri     Date : 15/02/2014    Version : V1   *
 * Description : This class is used to add design messages        *
				                                                  *
 *****************************************************************/

 Class Messages{
	
	public function success($sMsg){		
		return $this->msgLayout($sMsg,2);
	}
	public function error($sMsg){
		return $this->msgLayout($sMsg,3);
	}
	public function warning($sMsg){
		return $this->msgLayout($sMsg,2);
	}
	
	public function addupdatesucessIndication($process,$action){
		$sMsg = $process." ".$action."ed sucessfully";
		return $this->msgLayout($sMsg,1);
	}
	public function duplicateIndication($process){
		$sMsg = $process." already exists, Please try again";
		return $this->msgLayout($sMsg,2);
	}
	public function errorIndication($process,$action){
		$sMsg = "Error on ".$action." ".$process.", Please try again";		
		return $this->msgLayout($sMsg,3);
	}
	public function changestatusIndication($process){
		$sMsg = $process." status changed sucessfully";
		return $this->msgLayout($sMsg,1);
	}
	
	public function msgLayout($sMsg,$sMsgStatus){
	
		$msgColor = ($sMsgStatus == 1) ? "green" : (($sMsgStatus == 2) ? "yellow" :"red"); 
		$smsg = '<div id="message-'.$msgColor.'">
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td id="msg1" class="'.$msgColor.'-left">'.$sMsg.'</td>
                        <td id="msg2" class="'.$msgColor.'-right"><a class="close-'.$msgColor.'"><img src="layouts/images/table/icon_close_'.$msgColor.'.gif"   alt="" /></a></td>
                    </tr>
                </table>
            </div>';
		return $smsg;
	}
}
?>