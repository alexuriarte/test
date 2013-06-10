<?php
include_once("constants.php");
include_once("functions.php");
?>
<!DOCTYPE html>
<html>
  <head>
        <title>Scalr Demo App</title>
        <link type="text/css" href="/static/css/bootstrap.css" rel="stylesheet">
        <link type="text/css" href="/static/css/bootstrap-responsive.css" rel="stylesheet">
        <link type="image/x-icon" href="/static/img/favicon.ico" rel="shortcut icon" />
        <style type="text/css">code{color:#15d;} code.error{color:#d14}.hero-unit img{margin-right:10px;margin-top:10px}</style>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="hero-unit">
           <img src="/static/img/scalr-logo.png" alt="Scalr Logo" class="pull-left"/>
           <h1>Custom Metric App</h1>
           <p>This is the Custom Metric demo app. You submit metric values, and those will be picked up
              by the custom metric.</p>
        </div>
        <div class="container">
<?
if (METHOD === "GET") { 
?>
        <h2>Current Value of the Metric</h2>
        <p>The Metric is set to:
          <span class="badge badge-info"><b><?php echo read_metric(); ?></b></span>
        </p>
        <small class="muted">This value will be used by Scalr for autoscaling.</small>

        <h2>Modify this value</h2>
        <form action="/" method="post" class="form-inline">
            <fieldset>
                <div class="input-append">
                  <input autofocus="autofocus" type="text" name="value" placeholder="New Value..."/>
                  <input type="submit" class="btn btn-success" value="Submit it!"/>
                </div>
            </fieldset>
        </form>
<? 
} elseif (METHOD === "POST") {
  $value = $_POST["value"];
  if (is_numeric($value)) {
    write_metric((float) $value);
    header("Location: /");
  } else { ?>
      <p>This value (<? echo $value; ?>) is invalid.</p>
      <p>Try a number!</p>
      <p><a href="/">Please try again</a></p>
<?  
  }
} else {
  echo "Unsupported method";
}
?>
</div>
  </body>
</html>
