<?php
/**
 * Created by PhpStorm.
 * User: rickross
 * Date: 1/10/15
 * Time: 10:51 AM
 */
require('config.php');

if(!empty($_POST)){
    if(empty($_POST['username']) || empty($_POST['password'])){
        $response['success']=0;
        $response['message']="All Fields Required";

        die(json_encode($response));
    }
    $query="SELECT COUNT(*) AS count FROM users WHERE user_username=:user";

    $query_params=array(
        ':user'=>$_POST['username']
    );

    try{
        $stmt=$db->prepare($query);

        $result=$stmt->execute($query_params);

        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $username_count=$row['count'];
        }
        if($username_count>0){
            $response['success']=0;
            $response['message']="username is already taken";
            die(json_encode($response));
        }



    }catch (PDOException $e){
        $response["success"] = 0;
        $response["message"] = "Something went wrong. Please try again later";
        die(json_encode($response));
    }
    $query="INSERT INTO users(user_username,user_Password)
 VALUES(:user,:pass,:displayname)";
    $encr_user_pass=md5($_POST['password']);

    $query_params=array(
        ':user'=>$_POST['username'],
        ':pass'=>$encr_user_pass,
        ':displayname'=>$_POST['displayname']
    );
    try{
        $stmt=$db->prepare($query);
        $result=$stmt->execute($query_params);
    }catch (PDOException $ex){
        $response['success']=0;
        $response['message']="Username is already in use please  rtry again";
        die(json_encode($response));
    }
    $response['success']=1;
    $response['message']="Username successfully Added";
    echo json_encode($response);

}else{

    ?>

    <h1>Register</h1>
    <form action="register.php" method="post">
        Username: <br/>
        <input type="text" name="username" placeholder="Username"/><br/>
        Password: <br/>
        <input name="password" type="password" placeholder="Password"/><br/>
        Display Name: <br/>
        <input type="text" name="displayname" placeholder="Display Name"/><br/>
        <input type="submit" value="Register User"/>
    </form>
<?php
}