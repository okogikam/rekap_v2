<?php
    
    $url = "../pages/index.php";
    
include 'function.php';
   include 'connect.php';

   if(isset($_POST['login']))
    {
        $username = get_input($_POST['username']);
        $password = get_input($_POST['password']);
//       $url = $_POST['url'];
        
       
        $query = "SELECT * FROM user WHERE User_nama='$username' OR User_Email = '$username'";
       $result = $conn->query($query);
       if(!$result){
           $error= $conn->error;
           header('Location:../login.php?error=$error');
       }else{   
            $row = $result->fetch_array(MYSQLI_BOTH);
           
            $result->close();
            $salt1 = "qm%h";
            $salt2 = "*7!@";

            $token = hash('ripemd128',"$salt1$password$salt2");
           
            if($password == $row['Password'])
            {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['user_id'] = $row['id'];
                if(isset($_POST['remember'])){
                    ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 4);
                }else
                {
                    ini_set('session.gc_maxlifetime', 60 * 60 * 24);
                }
                

                header("Location:$url");
            }
           else {
            header('Location:../index.php?error=1');
           }
       }
        
    }  
?>