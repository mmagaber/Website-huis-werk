<?php

$content = new TemplatePower("template/files/admin_blog.tpl");
$content->prepare();

if(isset($_GET['action']))
{
    $action = $_GET['action'];
}else{
    $action = NULL;
}
if(isset($_SESSION['accountid']))
{
    if($_SESSION['roleid'] == 2){
switch($action)

{
    case "toevoegen":
        if(!empty($_POST['titel'])
            && !empty($_POST['content'])){
            // insert

            $accountid =($_SESSION['accountid']);

                $insert_account = $db->prepare("INSERT INTO blog SET
                  Title = :title,
                  Content = :content,
                  Accounts_idAccounts = :accountid");
                $insert_account->bindParam(":title", $_POST['titel']);
                $insert_account->bindParam(":content", $_POST['content']);
                $insert_account->bindValue(":accountid",$accountid );
                $insert_account->execute();

                print "Yeahhhhhhh you get the job done";

            }else{
            // formulier
            $content->newBlock("USERFORM");
            $content->assign("ACTION", "index.php?pageid=3&action=toevoegen");
            $content->assign("BUTTON", "Toevoegen blog");
            $content->assign("GEBRUIKSNAAM", $_SESSION['username']);
        }
        break;
    case "wijzigen":

        if(isset($_POST['blogid']))
        {
            $update_account = $db->prepare("UPDATE blog
                                          SET Title = :title,
                                              Content = :content
                                          WHERE idblog = :blogid");

            $update_account->bindParam(":username", $_POST['gnaam']);
            $update_account->execute();
        }else {
            // formulier

            $get_users = $db->prepare("SELECT blog.*, accounts.* FROM blog, accounts  WHERE idBlog = :idblog
                                      AND blog.Accounts_idAccounts = accounts.idAccounts");
            $get_users->bindParam(":idblog" , $_GET['idblog']);
            $get_users->execute();
            $user = $get_users->fetch(PDO::FETCH_ASSOC);
            $content->newBlock("USERFORM");
            $content->assign("ACTION", "index.php?pageid=3&action=wijzigen");
            $content->assign("BUTTON", "Wijzigen Blog");
            $content->assign(array(
               "TITEL" => $user['Title'] ,
                "GEBRUIKSNAAM" => $user['Username'],
                "CONTENT" => $user['Content'],
                "blog" => $user['idBlog']
            ));
        }

        break;
    case "verwijderen":
        if(isset($_POST['blogid']))
        {
            $delete_account = $db->prepare("DELETE FROM blog WHERE idBlog = :blogid");
            $delete_account->bindParam(":blogid", $_POST['blogid']);
            $delete_account->execute();

        }else{
            $content->newBlock("USERFORM");
            $get_blog = $db->prepare("SELECT
                                        a.Username,
                                        b.Title,
                                        b.Content,
                                        b.idBlog,
                                        a.idAccounts
                                        FROM accounts AS a, blog AS b
                                        WHERE b.idBlog = :blogid
                                        AND b.Accounts_idAccounts = a.idAccounts");
            $get_blog->bindParam(":blogid", $_GET['idblog']);
            $get_blog->execute();
            $blog = $get_blog->fetch(PDO::FETCH_ASSOC);
            $content->assign(array(
                "GEBRUIKSNAAM" => $blog['Username'],
                "TITEL" => $blog['Title'],
                "CONTENT" => $blog['Content'],
                "blog" => $blog['idBlog'],
                "ACTION" => "index.php?pageid=3&action=verwijderen",
                "BUTTON" => "Verwijder Blog"
            ));

        }
        break;
    default:
        $content->newBlock("BLOGLIST");
        if (isset($_POST['search'])){
            $get_blog = $db->prepare("SELECT  blog.Content,
                                            blog .Title,
                                            blog.idBlog,
                                          accounts.Username
                                    FROM blog,accounts
                                    WHERE blog.Accounts_idAccounts = accounts.idAccounts
                                    AND (blog.Title LIKE :search
                                    OR blog.Content LIKE :search2
                                    OR accounts.Username LIKE :search3)
                                    ");
            $search = "%".$_POST['search']."%";
            $get_blog->bindParam(":search", $search);
            $get_blog->bindParam(":search2", $search);
            $get_blog->bindParam(":search3", $search);
            $get_blog->execute();
            $content->assign("SEARCH", $_POST['search']);

        }else{
            $get_blog = $db->query("SELECT  blog.Content,
                                            blog .Title,
                                            blog.idBlog,
                                            accounts.Username
                                    FROM blog, accounts
                                    WHERE blog.Accounts_idAccounts = accounts.idAccounts");
        }
        while($users = $get_blog->fetch(PDO::FETCH_ASSOC)){
            $content->newBlock("USERLIST");
            $content->assign(array(
                "Title" => $users['Title'],
                "Content" => $users['Content'],
                "Username" => $users['Username'],
                "BLOGID" => $users['idBlog']
            ));
        }
    }

        }
    else{
        $errors->newBlock("ERRORS");
        $errors->assign("ERROR", "je bent geen Admin : ");
    }
    }
else{
    $errors->newBlock("ERRORS");
    $errors->assign("ERROR", "u moet inlogin : ");
}
