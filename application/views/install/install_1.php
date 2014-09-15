
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
          <h4>Thank you for purchasing BitcoinPokerDice.</h4>
          <p>Let's spend a few minutes installing BitcoinPokerDice on your server.</p>
          <p>Before you continue, please make sure you have the follwing information handy:</p>
          <ul>
            <li>MySQL database information including host, username, and password.</li>
            <li>Blockchain.info identifier and password.</li>
          </ul>
          <hr />
          <a href="<?=site_url('install/step_2');?>" class="btn btn-info pull-right">Go To Step 2</a>
        </div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
\