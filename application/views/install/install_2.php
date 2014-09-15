
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>BPD Installer</title>

    <!-- Bootstrap core CSS -->
    <link href="/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/dist/css/install.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">
      <div class="header">
        <h3 class="text-muted">BitcoinPokerDice Installer</h3>
      </div>
      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Checking if config files are writable.</h4>
          
          <p>The install needs to be able to write to certain configuration files during the installion process.  Before you continue, the following files must be writable.</p>
          <ul>
            <?php foreach($files as $file):?>
              <li><?php echo $file['path'];?> <i class="<?php echo ($file['writable']) ? 'glyphicon glyphicon-ok text-green':'glyphicon glyphicon-remove text-red';?>"></i></li>
            <?php endforeach;?>
          </ul>
          <p><strong>After the installion process is complete, these files will be write protected again.</strong></p>
          <hr />
          <a href="<?=site_url('install/step_2');?>" class="btn btn-info pull-right <?php echo ($disable_next) ? 'disabled':'';?>">Go To Step 2</a>
        </div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>