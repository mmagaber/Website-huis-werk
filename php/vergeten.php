<?php
include_once("include/function.php");
$content = new TemplatePower("template/files/vergeten.tpl");
$content->prepare();

if(isset($_GET['action']))
{
    $action = $_GET['action'];
}
else{
    $action = NULL;
}

switch($action)
{
    case"1":

        if(!empty($_POST['email'])){
            $check_email = $db->prepare("SELECT COUNT(*) FROM accounts a, users u
                                    WHERE a.Users_idUsers = u.idUsers
                                    AND u.Email = :email");
            $check_email->bindParam(":email", $_POST['email']);
            $check_email->execute();

            if($check_email->fetchColumn() == 1){
                $get_account= $db->prepare("SELECT * FROM accounts a, users u
                                    WHERE a.Users_idUsers = u.idUsers
                                    AND u.Email = :email");
                $get_account->bindParam(":email", $_POST['email']);
                $get_account->execute();
                $account = $get_account->fetch(PDO::FETCH_ASSOC);
                //random code genereren en dezelfde code opsturen
                $code = hashgenerator();

                $update_account = $db->prepare("Update accounts set Reset = :code
                                                where idAccounts = :accountid");
                $update_account->bindParam(":code", $code);
                $update_account->bindParam(":accountid", $account['idAccounts']);
                $update_account->execute();

                //index.php?pageid=8&action=2&code=$code
                $content->newBlock("LINK");
                $content->assign("CODE", $code);
            }
        }
        else{
            $content->newBlock("VERGETENFORM");
        }

        break;

    case"2":
        if(isset($_GET['code']))
        break;

    case"3":
        break;


    default:

}