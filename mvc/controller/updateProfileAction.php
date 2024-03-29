<?php
session_start();


$fname = $lname = $file = $addressLine = $district = $division = $postcode = $country = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
  $fname = sanitize($_POST["fname"]);
  $lname = sanitize($_POST["lname"]);
  $addressLine = sanitize($_POST["addressLine"]);
  $postcode = sanitize($_POST["postcode"]);
  $password = sanitize($_POST["password"]);
  $isValid = true;
    if (empty($password))
      {
        $_SESSION['password_error_msg'] = "password can not be empty";
        $isValid = false;
      }

    if ($isValid === true)
      {
        $_SESSION['password_error_msg'] = "";

        $filename = "../model/users.json";
        $file = fopen($filename, "r");
        $fz = filesize($filename);
        if ($fz > 0)
        {
          $fr = fread($file, $fz);
          $users = json_decode($fr);
          $found = false;

          for($i = 0; $i < count($users); $i++)
          {
            if ($users[$i]->password === $password)
            {
              $found = true;
              break;
            }
          }
          if ($found === true)
          {
            $_SESSION['password'] = $password;
            header("Location: ../view/profile.php");
          }
          else
          {
            $_SESSION['password_error_msg'] = "Password does not match";
            header("Location: ../view/updateProfile.php");
          }
        }
        
      }
   
}

  
  $file = fopen("../model/users.json", "a");

  $content = array(array("email" => $_SESSION['email'], "fname" => $fname, "lname" => $lname, "addressLine" => $addressLine, "postcode" => $postcode, "password" => $password));

  $content = json_encode($content);
    fwrite($file, $content);
  
  

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
  $fname = sanitize($_POST["fname"]);
  $lname = sanitize($_POST["lname"]);
  $addressLine = sanitize($_POST["addressLine"]);
  $district = sanitize($_POST["district"]);
  $division = sanitize($_POST["division"]);
  $postcode = sanitize($_POST["postcode"]);
  $country = sanitize($_POST["country"]);


  echo "Update Successful..!";
  header("Location: ../view/profile.php");
}

function sanitize($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

session_destroy();
?>