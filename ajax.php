<?php

include("db.php");
    
if(trim(htmlentities(addslashes(filter_input(INPUT_GET, 'type')), ENT_QUOTES)) === "loginUser")
{
    try {
        $username = trim(filter_input(INPUT_GET, 'username'));
        $password = trim(filter_input(INPUT_GET, 'password'));
        
        $fetch = $db->prepare("SELECT * FROM `users` WHERE user_name = :username");
        $fetch->bindParam(':username', $username, PDO::PARAM_STR);
	$fetch->execute();
        $result = $fetch->fetch(PDO::FETCH_OBJ);
        
        if($result)
        {
            if(password_verify($password, $result->password_hash))
            {
                $currentDateTime = date('Y-m-d H:i:s');
                
                $update = $db->prepare("UPDATE `users` SET `last_login` = :lastlogin WHERE `client_id` = :clientid");
                $update->bindParam(':lastlogin', $currentDateTime);
                $update->bindParam(':clientid', $result->client_id);
                $loginUpdate = $update->execute();

                $resultArray['error'] = 0;
                $resultArray['errorMessage'] = "None";
                $resultArray['userName'] = $result->user_name;
                $_SESSION['username'] = $result->user_name;
                
                echo json_encode($resultArray);
            }
            
            else
            {
                $resultArray['error'] = 1;
                $resultArray['errorMessage'] = "Incorrect Password";
                echo json_encode($resultArray);
            }
        }
        
        else
        {
            $resultArray['error'] = 1;
            $resultArray['errorMessage'] = "Incorrect Username";
            echo json_encode($resultArray);
        }
        
    } catch (PDOException $e) {
        $resultArray['error'] = 1;
        $resultArray['errorMessage'] = $e->getMessage();
        echo json_encode($resultArray);
    }
}