
<div class="jumbotron">
    <h1>Admin Blog</h1>
</div>

<div class="col-sm-8 blog-main">

    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Library</a></li>
        <li class="active">Data</li>
    </ol>
    <div class="blog-post">

        <p>
            <a href="index.php?pageid=3">Overzicht</a> -
            <a href="index.php?pageid=3&action=toevoegen">toevoegen</a>
        </p>

        <!-- START BLOCK : MELDING -->

        <div class="alert alert-info" role="alert">
            <p>{MELDING}</p>
        </div>
        <!-- END BLOCK : MELDING -->

        <!-- START BLOCK : USERFORM -->
        <div class="blog">
            <form class="form-horizontal" action="{ACTION}" method="post">
                <div class="form-group">
                    <label for="inputgnaam" class="col-sm-4 control-label">Gebruikersnaam:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputgnaam" placeholder="Gebruikersnaam" name="gebruikersnaam" value="{GEBRUIKSNAAM}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputtitel" class="col-sm-4 control-label">Titel:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputtitle" placeholder="Titel" name="titel" value="{TITEL}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputconten" class="col-sm-4 control-label">content:</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="inputcontent" placeholder="content" name="content" >{CONTENT}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <input type="hidden" name="blogid" value="{blog}">
                        <button type="submit" class="btn btn-default">{BUTTON}</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- END BLOCK : USERFORM -->
        <!-- START BLOCK : BLOGLIST -->
        <form class="form-inline" action="index.php?pageid=3" method="post">
            <div class="form-group">
                <input type="text" class="form-control" id="Search" placeholder="Zoek Blog" name="search" value="{SEARCH}">
            </div>
            <button type="submit" class="btn btn-default">Zoek</button>
        </form>
        <!-- START BLOCK : USERLIST -->
                <div class="panel panel-prim0ary">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3> {Username}<span class="label label-default"></span></h3>
                            <h3 class="panel-title">{Title}</h3>
                        </div>
                        <div class="panel-body">
                            {Content}
                        </div>
                        <div class="panel-footer">
                            <a href="index.php?pageid=3&action=wijzigen&idblog={BLOGID}">Wijzigen</a>
                            <a href="index.php?pageid=3&action=verwijderen&idblog={BLOGID}">Verwijderen</a>
                        </div>
                    </div>
                </div>
        <!-- END BLOCK : USERLIST -->
        <!-- END BLOCK : BLOGLIST -->

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