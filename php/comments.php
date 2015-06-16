<?php

$content = new TemplatePower("template/files/comments.tpl");
$content->prepare();

if(isset($_GET['action']))
{
    $action = $_GET['action'];
}else{
    $action = NULL;
}


if(isset($_SESSION['roleid']))
{
    if($_SESSION['roleid']){
        switch($action)
        {
            case "leesmeer":
    //                $check = $db->prepare("SELECT count(*) FROM accounts AS a , blog as b
    //                                        WHERE a.idAccounts = b.Accounts_idAccounts
    //                                        AND b.idBlog = : blogid");
    //                $check->bindParam("blogid", $_GET['blogid']);
    //                $check->execute();

                $get_blog = $db->prepare("SELECT blog.*, accounts.* FROM blog, accounts
                                      WHERE blog.Accounts_idAccounts=accounts.idAccounts
                                      AND idBlog = :blogid");
                $get_blog->bindParam(":blogid", $_GET['idblog']);
                $get_blog->execute();

                $blog = $get_blog->fetch(PDO::FETCH_ASSOC);

                $content->newBlock("COMMENTTOEVOEGEN");
                $content->assign("ACTION", "index.php?pageid=6&action=reageer");
                $content->assign("BUTTON", "Reageren");
                $content->assign(array(
                    "BLOGID" => $blog['idBlog'],
                    "ACCOUNTID" => $blog['idAccounts'],
                    "TITEL" => $blog['Title'],
                    "USERNAME" => $blog['Username'],
                    "CONTENT" => $blog['Content']));

//                $content->newBlock("COMMENTFORM");
//                $content->assign("BLOGID", $blog['idBlog']);
//                $content->assign("ACTION", "index.php?pageid=6&action=reageer");
//                $content->assign("BUTTON", "Reageren");

                $get_comments = $db->prepare("SELECT blog.*, accounts.*, comments.* FROM blog, accounts, comments
                                              WHERE blog.idBlog = comments.Blog_idBlog
                                              AND comments.Blog_idBlog = :blogid
                                              AND comments.Accounts_idAccounts = accounts.idAccounts
                                               ORDER BY idComments DESC
                                              ");
                $get_comments->bindParam(":blogid", $_GET['idblog']);
                $get_comments->execute();

                while ($comments = $get_comments->fetch(PDO::FETCH_ASSOC)){
                    $content->newBlock("COMMENTS");
                    $content->assign(array(
                        "BLOGID" => $comments['idBlog'],
                        "USERNAME" => $comments['Username'],
                        "COMMENT" => $comments['Text']));
                    if ($_SESSION['roleid'] == 2) {
                        $content->newBlock("ADMINCOMMENT");
                        $content->assign("COMMENTSID", $comments['idComments']);
                    }
                }

                break;
            case "reageer":
                if (isset($_GET['idblog'])){
                    $get_comments = $db->prepare("SELECT blog.*, accounts.*, comments.* FROM blog, accounts, comments
                                              WHERE blog.idBlog = comments.Blog_idBlog
                                              AND comments.Blog_idBlog = :blogid
                                              AND comments.Accounts_idAccounts = accounts.idAccounts
                                              ORDER BY idComments DESC
                                              ");
                    $get_comments->bindParam(":blogid", $_GET['blogid']);
                    $get_comments->execute();
                    $blog = $get_blog->fetch(PDO::FETCH_ASSOC);

                    $content->newBlock("COMMENTTOEVOEGEN");
                    $content->assign("ACTION", "index.php?pageid=6&action=reageer");
                    $content->assign("BUTTON", "Reageren");
                    $content->assign(array(
                        "BLOGID" => $blog['idBlog'],
                        "ACCOUNTID" => $blog['idAccounts'],
                        "TITEL" => $blog['Title'],
                        "USERNAME" => $blog['Username'],
                        "COMMENTSID" => $blog['idComments'],
                        "CONTENT" => $blog['Content']));
                }elseif(!empty($_POST['comment'])){
                       // insert
                    $accountid = $_SESSION['accountid'];
                try{
                    $insert_comments = $db->prepare("INSERT INTO comments SET
                                                    Text = :text,
                                                    Accounts_idAccounts = :accountid,
                                                    Blog_idBlog = :blogid
                                                    ");
                    $insert_comments->bindParam(":text", $_POST['comment']);
                    $insert_comments->bindParam(":accountid", $accountid);
                    $insert_comments->bindParam(":blogid",$_POST['blogid']);
                    $insert_comments->execute();
                    $content->newBlock("MELDING");
                    $content->assign("MELDING", "Comment is toegevoegd");
                    $content->assign("BLOGID", $_POST['blogid']);
                }catch(PDOException $error){
                    $error->getMessage();
                    $content->newBlock("MELDING");
                    $content->assign("MELDING", $error);
                }
                }
                else {
                    $errors->newBlock("ERRORS");
                    $errors->assign("ERROR", "Waarom heb je het blogid in de url veranderd???");
                }
              break;
            case "verwijderen":
                if ($_SESSION['roleid'] == 2){

                        $delete_comments = $db->prepare("DELETE FROM comments
                                              WHERE idComments= :commentsid
                                              ");
                        $delete_comments->bindParam(":commentsid", $_GET['commentsid']);
                        $delete_comments->execute();
                    }

                break;
            case "wijzigen":
                if(isset($_POST['commentsid'])){
                    $update_comments = $db->prepare("UPDATE comments SET
                                                     Text = :text
                                                     WHERE idComments= :commentsid
                                              ");
                    $update_comments->bindParam(":commentsid", $_GET['commentsid']);
                    $update_comments->execute();
                }else {
                    // formulier
                    $get_comments = $db->prepare("SELECT comments.*, blog.*, accounts.* FROM comments, blog, accounts
                                                  WHERE idComments = :idcomment
                                                  AND comments.Accounts_idAccounts = accounts.idAccounts
                                                  AND comments.Blog_idBlog = blog.idBlog");
                    $get_comments->bindParam(":idcomment" , $_GET['commentsid']);
                    $get_comments->execute();
                    $comments = $get_comments->fetch(PDO::FETCH_ASSOC);
                    $content->newBlock("COMMENTFORM");

                    $content->assign("BUTTON", "Wijzigen Comments");
                    $content->assign(array(
                        "TITEL" => $comments['Title'] ,
                        "GEBRUIKSNAAM" => $comments['Username'],
                        "CONTENT" => $comments['Text'],
                        "blog" => $comments['idBlog']
                    ));
                }
            break;

            default:
                $content->newBlock("BLOGLIST");
                if (!empty($_POST['search'])){
                    $get_blog = $db->prepare("SELECT  blog.Content,
                                            blog.Title,
                                            blog.idBlog,
                                          accounts.Username
                                    FROM blog,accounts
                                    WHERE blog.Accounts_idAccounts = accounts.idAccounts
                                    AND (blog.Title LIKE :search
                                    OR blog.Content LIKE :search2
                                    OR accounts.Username LIKE :search3)
                                    ");
                    $search = "%" . $_POST['search'] . "%";
                    $get_blog->bindParam(":search", $search);
                    $get_blog->bindParam(":search2", $search);
                    $get_blog->bindParam(":search3", $search);
                    $get_blog->execute();
                    $content->assign("SEARCH", $_POST['search']);

                }else{
                    $get_blog = $db->query("SELECT  blog.Content,
                                            blog.Title,
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
