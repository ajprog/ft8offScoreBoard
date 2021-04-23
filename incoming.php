<?PHP
include 'dbconnect.php';
if (ispost()){

$seskey = $conn->query("SELECT qrx_key FROM qrz_session WHERE qrz_key_valid=1");

if ($seskey->num_rows = 0){
    $seskey=new_session();
}
}


?>
