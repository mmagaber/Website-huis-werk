
<div class="jumbotron">
    <h1>Comment Blog</h1>
</div>

<div class="col-sm-8 blog-main">

    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Library</a></li>
        <li class="active">Data</li>
    </ol>
    <div class="blog-post">
        <p>
            <a href="index.php?pageid=6">Overzicht</a>
        </p>
        <!-- START BLOCK : MELDING -->

        <div class="alert alert-info" role="alert">
            <p>{MELDING}</p>
        </div>
        <meta http-equiv="refresh" content="2; url=index.php?pageid=6&action=leesmeer&idblog={BLOGID}">
        <!-- END BLOCK : MELDING -->

        <!-- START BLOCK : BLOGLIST -->
        <form class="form-inline" action="index.php?pageid=6" method="post">
            <div class="form-group">
                <input type="text" class="form-control" id="Search" placeholder="Zoek Blog" name="search" value="{SEARCH}">
            </div>
            <button type="submit" class="btn btn-default">Zoek</button>
        </form>
        <!-- START BLOCK : USERLIST -->
        <div class="panel panel-primary">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3> {Username}<span class="label label-default"></span></h3>
                    <h3 class="panel-title">{Title}</h3>
                </div>
                <div class="panel-body">
                    {Content}
                </div>
                <div class="panel-footer">
                    <a href="index.php?pageid=6&action=leesmeer&idblog={BLOGID}">Lees Meer</a>
                </div>
            </div>
        </div>
        <!-- END BLOCK : USERLIST -->
        <!-- END BLOCK : BLOGLIST -->


        <!-- START BLOCK : COMMENTTOEVOEGEN -->

            <div class="leesmeer">

                <div class="panel panel-prim0ary">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="user"> Gebruiker</p>
                            <h3>{USERNAME} </h3>
                        </div>
                        <div class="panel-body">
                           <h4 class="titel"> {TITEL} </h4>
                        </div>
                        <div class="panel-body">
                             <p>{CONTENT} </p>
                        </div>
                    </div>
                </div>
                <form class="form-horizontal" action="{ACTION}" method="post">
                <div class="form-group">
                    <label for="inputconten" class="col-sm-4 control-label">comment</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="inputcomment" placeholder="comment" name="comment"></textarea>
                    </div>
                </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <input type="hidden" name="accountid" value="{ACCOUNTID}">
                            <input type="hidden" name="blogid" value="{BLOGID}">

                            <button type="submit" class="btn btn-default">{BUTTON}</button>
                        </div>
                    </div>
                </form>

            </div>

            <!-- START BLOCK : COMMENTS -->
            <div class="panel panel-prim0ary">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3> {Username}<span class="label label-default"></span></h3>
                    </div>
                    <div class="panel-body">
                        <h3>{COMMENT}</h3>
                    </div>

                    <!-- START BLOCK : ADMINCOMMENT -->
                    <div class="panel-footer">
                        <a href="index.php?pageid=6&action=wijzigen&commentsid={COMMENTSID}">wijzigen</a>
                        <a href="index.php?pageid=6&action=verwijderen&commentsid={COMMENTSID}">Verwijderen</a>
                    </div>
                </div>
                <!-- END BLOCK : ADMINCOMMENT -->
            </div>
            <!-- END BLOCK : COMMENTS -->



        <!-- END BLOCK : COMMENTTOEVOEGEN -->
        <!-- START BLOCK : COMMENTFORM -->
        <form class="form-horizontal" action="{ACTION}" method="post">
            <div class="form-group">
                <label for="inputconten" class="col-sm-4 control-label">comment</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="inputcomment" placeholder="comment" name="comment">{CONTENT}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    <input type="hidden" name="accountid" value="{ACCOUNTID}">
                    <input type="hidden" name="blogid" value="{BLOGID}">

                    <button type="submit" class="btn btn-default">{BUTTON}</button>
                </div>
            </div>
        </form>
        <!-- END BLOCK : COMMENTFORM -->
    </div><!-- /.blog-post -->
</div>

<div class="col-sm-3 col-sm-offset-1 blog-sidebar">

    <div class="sidebar-module sidebar-module-inset">
        <h4>About</h4>
        <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
    </div>
    <div class="sidebar-module">
        <h4>Archives</h4>
        <ol class="list-unstyled">
            <li><a href="#">March 2014</a></li>
            <li><a href="#">February 2014</a></li>
            <li><a href="#">January 2014</a></li>
            <li><a href="#">December 2013</a></li>
            <li><a href="#">November 2013</a></li>
            <li><a href="#">October 2013</a></li>
            <li><a href="#">September 2013</a></li>
            <li><a href="#">August 2013</a></li>
            <li><a href="#">July 2013</a></li>
            <li><a href="#">June 2013</a></li>
            <li><a href="#">May 2013</a></li>
            <li><a href="#">April 2013</a></li>
        </ol>
    </div>
    <div class="sidebar-module">
        <h4>Elsewhere</h4>
        <ol class="list-unstyled">
            <li><a href="#">GitHub</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Facebook</a></li>
        </ol>
    </div>
</div>