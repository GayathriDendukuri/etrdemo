<?php

/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 22/01/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : Project Sparkle                                       *  
 * Modified by : Pradeep G     Date : 05/02/2014    Version : V1  *
 * Description : Header file - Includes can be defined here       *
 *****************************************************************/

function sendMail($to_email, $from_email, $subject, $message) {
    $headers = 'From:' . $from_email . "\r\n";
    $headers .= "Content-type: text/html; charset=\"UTF-8\"; format=flowed \r\n";
    $headers .= "Mime-Version: 1.0 \r\n";
    $headers .= "Content-Transfer-Encoding: quoted-printable \r\n";
    return mail($to_email, $subject, $message, $headers);
   /* $headers = array("From: from@example.com",
        "Reply-To: replyto@example.com",
        "X-Mailer: PHP/" . PHP_VERSION
     );
    $headers = implode("\r\n", $headers);
    return mail($to_email, $subject, $message, $headers);*/
}

function doPages($page_size, $thepage, $query_string, $total=0) {
    //per page count
    $index_limit = 5;


    //set the query string to blank, then later attach it with $query_string
    $query='';

    if(strlen($query_string)>0){
        $query = "&".$query_string;
    }

    //get the current page number example: 3, 4 etc: see above method description
    $current = get_current_page();

    $total_pages=ceil($total/$page_size);
    $start=max($current-intval($index_limit/2), 1);
    $end=$start+$index_limit-1;

    $pagging = '<div class="paging">';

    if($current==1) {
        $pagging .= '<span class="prn">< Previous</span> ';
    } else {
        $i = $current-1;
        $pagging .= '<a class="prn" title="go to page '.$i.'" rel="nofollow" href="'.$thepage.'?page='.$i.$query.'">< Previous</a> ';
        $pagging .= '<span class="prn">...</span> ';
    }

    if($start > 1) {
        $i = 1;
        $pagging .= '<a title="go to page '.$i.'" href="'.$thepage.'?page='.$i.$query.'">'.$i.'</a> ';
    }

    for ($i = $start; $i <= $end && $i <= $total_pages; $i++){
        if($i==$current) {
            $pagging .= '<span>'.$i.'</span> ';
        } else {
            $pagging .= '<a title="go to page '.$i.'" href="'.$thepage.'?page='.$i.$query.'">'.$i.'</a> ';
        }
    }

    if($total_pages > $end){
        $i = $total_pages;
        $pagging .= '<a title="go to page '.$i.'" href="'.$thepage.'?page='.$i.$query.'">'.$i.'</a> ';
    }

    if($current < $total_pages) {
        $i = $current+1;
        $pagging .= '<span class="prn">...</span> ';
        $pagging .= '<a class="prn" title="go to page '.$i.'" rel="nofollow" href="'.$thepage.'?page='.$i.$query.'">Next ></a> ';
    } else {
        $pagging .= '<span class="prn">Next ></span> ';
    }

    //if nothing passed to method or zero, then dont print result, else print the total count below:
    if ($total != 0){
        //prints the total result count just below the paging
        $pagging .= '('.$total.' Records)';
    }
    $pagging .= '</div>';

    return  $pagging;

}//end of method doPages()

//Both of the functions below required

function check_integer($which) {
    if(isset($_REQUEST[$which])){
        if (intval($_REQUEST[$which])>0) {
            //check the paging variable was set or not,
            //if yes then return its number:
            //for example: ?page=5, then it will return 5 (integer)
            return intval($_REQUEST[$which]);
        } else {
            return false;
        }
    }
    return false;
}//end of check_integer()

function get_current_page() {
    if(($var=check_integer('page'))) {
        //return value of 'page', in support to above method
        return $var;
    } else {
        //return 1, if it wasnt set before, page=1
        return 1;
    }
}//end of method get_current_page()

 /**
 * Returns an encrypted & utf8-encoded
 */
function encrypt($pure_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
}

/**
 * Returns decrypted original string
 */
function decrypt($encrypted_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
}
?>