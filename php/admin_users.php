<?php
$content = new TemplatePower("template/files/admin_users.tpl");
$content->prepare();
if(isset($_GET['action']))
{
    $action = $_GET['action'];
}
else{
    $action = NULL;
}
switch($action){
    case "toevoegen":
        if(!empty($_POST['vnaam'])
            && !empty($_POST['anaam'])
            && !empty($_POST['gnaam'])
            && !empty($_POST['email'])
            && !empty($_POST['password1'])
            && !empty($_POST['password2'])){
            // in db toevoegen
            if($_POST['password1'] == $_POST['password2'])
            {
                try {
                    $insert_user = $db->prepare("INSERT INTO users SET
                  Surename = :anaam,
                  Name = :vnaam,
                  Email = :email");
                    $insert_user->bindParam(":anaam", $_POST['anaam']);
                    $insert_user->bindParam(":vnaam", $_POST['vnaam']);
                    $insert_user->bindParam(":email", $_POST['email']);
                    $insert_user->execute();
                    $userid = $db->lastInsertId();

                    $insert_account = $db->prepare("INSERT INTO accounts SET
                    Username = :username,
                    Password = :password,
                    salt = :salt,
                    Users_idUsers = :userid,
                    Role_idRole = :roleid
                    ");
                    $insert_account->bindParam(":username", $_POST['gnaam']);
                    $password = sha1($_POST['password1']);
                    $insert_account->bindParam(":password", $password );
                    $insert_account->bindParam(":salt", $userid);
                    $insert_account->bindParam(":userid", $userid);
                    $insert_account->bindValue(":roleid", 1);
                    $insert_account->execute();
                    print "yeaahhhhh";
                }catch(PDOException $error)
                {
                    $errors->newBlock("ERRORS");
                    $errors->assign("ERROR", "er is een error: ".$error->getFile()." ".$error->getLine() . " " .$error->getMessage());
                }
            }else{
                $errors->newBlock("ERRORS");
                $errors->assign("ERROR", "Wachtwoorden komen niet overeen");
                $content->newBlock("USERFORM");
                $content->assign(array("ACTION" => "index.php?pageid=2&action=toevoegen",
                    "BUTTON" => "Toevoegen Gebruiker"));
            }
        }else{
            // formulier
            $content->newBlock("USERFORM");
            $content->assign(array("ACTION" => "index.php?pageid=2&action=toevoegen",
                "BUTTON" => "Toevoegen Gebruiker"));
        }
        break;
    case "wijzigen":
        if(isset($_GET['accountid']))
        {
            $content->newBlock("USERFORM");
            $get_account = $db->prepare("SELECT
                                            a.Username,
                                            u.Surename,
                                            u.Name,
                                            u.Email,
                                            u.idUsers,
                                            a.idAccounts
                                        FROM accounts a, users u
                                        WHERE a.idAccounts = :accountid
                                        AND a.Users_idUsers = u.idUsers");
            $get_account->bindParam(":accountid", $_GET['accountid']);
            $get_account->execute();
            $account = $get_account->fetch(PDO::FETCH_ASSOC);
            $content->assign(array(
                "VOORNAAM" => $account['Name'],
                "ACHTERNAAM" => $account['Surename'],
                "USERNAME" => $account['Username'],
                "EMAIL" => $account['Email'],
                "ACCOUNTID" => $account['idAccounts'],
                "USERID" => $account['idUsers'],
                "ACTION" => "index.php?pageid=2&action=wijzigen",
                "BUTTON" => "Wijzigen Gebruiker"
            ));
        }elseif(isset($_POST['accountid']))
        {
            // gebruiker moet wijzigen
            $update_account = $db->prepare("UPDATE accounts SET
                              Username = :username
                              WHERE idAccounts = :accountid
                              ");
            $update_account->bindParam(":username", $_POST['gnaam']);
            $update_account->bindParam(":accountid", $_POST['accountid']);
            $update_account->execute();
            $update_user = $db->prepare("UPDATE users SET
                              Surename = :achternaam,
                              Name = :voornaam,
                              Email = :email
                              WHERE idUsers = :userid
                              ");
            $update_user->bindParam(":voornaam", $_POST['vnaam']);
            $update_user->bindParam(":achternaam", $_POST['anaam']);
            $update_user->bindParam(":email", $_POST['email']);
            $update_user->bindParam(":userid", $_POST['userid']);
            $update_user->execute();
            $content->newBlock("MELDING");
            $content->assign("MELDING", "User gewijzigd");
        }
        break;
    case "verwijderen":
        if(isset($_GET['accountid']))
        {
            $content->newBlock("USERFORM");
            $get_account = $db->prepare("SELECT
                                            a.Username,
                                            u.Surename,
                                            u.Name,
                                            u.Email,
                                            u.idUsers,
                                            a.idAccounts
                                        FROM accounts a, users u
                                        WHERE a.idAccounts = :accountid
                                        AND a.Users_idUsers = u.idUsers");
            $get_account->bindParam(":accountid", $_GET['accountid']);
            $get_account->execute();
            $account = $get_account->fetch(PDO::FETCH_ASSOC);
            $content->assign(array(
                "VOORNAAM" => $account['Name'],
                "ACHTERNAAM" => $account['Surename'],
                "USERNAME" => $account['Username'],
                "EMAIL" => $account['Email'],
                "ACCOUNTID" => $account['idAccounts'],
                "USERID" => $account['idUsers'],
                "ACTION" => "index.php?pageid=2&action=verwijderen",
                "BUTTON" => "Verwijder Gebruiker"
            ));
        }elseif(isset($_POST['accountid']))
        {
            // gebruiker moet verwijderd woren
            /*
            $delete_account = $db->prepare("DELETE FROM accounts
                              WHERE idAccounts=:accountid");
            $delete_account->bindParam(":accountid", $_POST['accountid']);
            $delete_account->execute();
            */
            $delete_user = $db->prepare("DELETE FROM users
                              WHERE idUsers = :userid");
            $delete_user->bindParam(":userid", $_POST['userid']);
            $delete_user->execute();
            $content->newBlock("MELDING");
            $content->assign("MELDING", "User Verwijderd");
        }
        break;
    case "zoeken":
        break;
    default:
        // overzicht
        $content->newBlock("OVERZICHT");
        $get_gebruikers = $db->query("SELECT users.*, accounts.*
                                      FROM users, accounts
                                      WHERE users.idUsers = accounts.Users_idUsers
                                      ");
        while($users = $get_gebruikers->fetch(PDO::FETCH_ASSOC)){
            $content->newBlock("USERROW");
            $content->assign(array(
                "VOORNAAM" => $users['Name'],
                "ACHTERNAAM" => $users['Surename'],
                "USERNAME" => $users['Username'],
                "EMAIL" => $users['Email'],
                "ACCOUNTID" => $users['idAccounts']
            ));
        }
}
