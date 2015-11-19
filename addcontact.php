<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 20/02/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : Project Taxreceipt - 2013                             *
 * Modified by : Pradeep G     Date : 20/02/2014    Version : V1  *
 * Description : List donation page                               *
 *****************************************************************/

include('includes/header.inc.php');
$_SESSION['indicator'] = "before";
$objUser = new User();
$userDetails = array();
if(@$_GET['imei']!=""){
    $userDetails = $objUser->getuserDetailsAll($_GET['imei']); 
   
}

if(is_array($userDetails)){
 $process = "update";

}else if($userDetails == "no_data"){
	$process = "add";
}
$name = "";$pingip="";$cnum = "";$restnum = "";$place = "";$city = "";$coutry = "";
if(count($userDetails) > 2){
    $name = $userDetails['name'];  $pingip = $userDetails['pingip']; $cnum = $userDetails['cnum'];
    $restnum = $userDetails['resetnum']; $place = $userDetails['place'];
    $city = $userDetails['city']; $coutry = $userDetails['country'];
    $process = "update";
}

$coutries =  array("India","Italy","France","Canada","USA");
include('layouts/common/header.html');
?>


<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Add Contact</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
    <th rowspan="3" class="sized"><img src="layouts/images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
    <th class="topleft"></th>
    <td id="tbl-border-top">&nbsp;</td>
    <th class="topright"></th>
    <th rowspan="3" class="sized"><img src="layouts/images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
<td id="tbl-border-left"></td>
<td>
<!--  start content-table-inner -->
<div id="content-table-inner">

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
<td>


    <!-- start id-form -->
    <form id="login" action="view_users.php" method="post" onsubmit="return check();" >
    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
        <tr>
            <th valign="top">Contact Person Name:</th>
            <td><input type="text" name="name" class="inp-form" autofocus required value="<?php echo $name; ?>"/></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <th valign="top">Ping IP Address</th>
            <td><input type="text" name="pingip" class="inp-form" required value="<?php echo $pingip; ?>"/></td>
            <th valign="top">Contact Number</th>
            <td><input type="text" name="cnum" class="inp-form" required value="<?php echo $cnum; ?>"/></td>
        </tr>
        <tr>
            <th valign="top">Reset Number</th>
            <td><input type="text" name="mobile"  class="inp-form" required value="<?php echo $restnum; ?>"/></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <th valign="top">City</th>
            <td><input type="text" name="city"  class="inp-form" required value="<?php echo $city; ?>"/></td>
        </tr>
        <tr>
            <th valign="top">Place</th>
            <td><input type="text" name="place" class="inp-form" required value="<?php echo $place; ?>"/></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <th valign="top">Country</th>
            <td>
                <select required name="country" class="styledselect_form_1">
                    <?php
                    for($i=0;$i<count($coutries);$i++){
                        $selected = ($coutries[$i] == $coutry) ? "selected='selected'" : "";
                        echo '<option '.$selected.' value="'.$coutries[$i].'">'.$coutries[$i].'</option>';
                    }
                    ?>
                </select>
            </td>
            <td></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="submit" class="form-submit"  id="submit" name="btncontact" value="Submit"/>
                <input type="reset" value="" class="form-reset"  />
                <input type="hidden" value="<?php echo $process; ?>" name="process"/>
		<input type="hidden"  name="form_hidden" value="from_add_form"/>	
                <input type="hidden" value="<?php echo @$_GET['imei']; ?>" name="imei" id="imei"/>
            </td>
            <td></td>
        </tr>
    </table>
    </form>
    <!-- end id-form  -->

</td>

</tr>
<tr>
    <td><img src="layouts/images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
    <td></td>
</tr>
</table>

<div class="clear"></div>


</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
    <th class="sized bottomleft"></th>
    <td id="tbl-border-bottom">&nbsp;</td>
    <th class="sized bottomright"></th>
</tr>
</table>


<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->

<script>
function check(){
    if(document.getElementById('imei').value == ''){
        alert("'imei' missing");
        return false;
    }
}
</script>

<div class="clear">&nbsp;</div>
<?php
include('layouts/common/footer.html');
?>
