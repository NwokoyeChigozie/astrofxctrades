<?php 
//include('href_create.php');
//echo create_href_base();
//$m_b = create_href_base();
   
session_start();
setcookie(session_name(), '', 100);
unset($_SESSION['username']);
unset($_SESSION['id']);
unset($_SESSION['email']);
session_unset();
session_destroy();
$_SESSION = array();

//header("Location: ./?a=login");
//header("Location: ./?a=login");
//header("Location: ./?a=login");
    echo "<script>
function navigate(){
window.location = './';
}

setTimeout(navigate, 2000);
</script>";
?>