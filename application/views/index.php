
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>eSikshya</title>
    <meta name="viewport" content="width=device-width" />
    <meta name="viewport" content="height=device-height" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    
    
    <script type="text/javascript" src="/assets/js/jquery.min.js" ></script>
    <script src="/assets/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/assets/js/jHtmlArea-0.6.0.min.js"></script>
    <script src="/assets/js/dropdown.js"></script>
    <!-- For Clock -->
    <script src="/assets/js/coolclock.js"></script>
    <script src="/assets/js/moreskins.js"></script>
    <script src="/assets/js/excanvas.js"></script>



    <!-- Le styles -->
    <link rel="stylesheet" href="/assets/css/jquery-ui.css" />
    <link rel="Stylesheet" type="text/css" href="/assets/jhtmlArea/style/jHtmlArea.css" />
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="/assets/css/bubble.css" rel="stylesheet">
    <!--This stylesheet is for footer-->
    <link href="/assets/css/docs.css" rel="stylesheet">
    <link href="/assets/css/prettify.css" rel="stylesheet">
    <style type="text/css">
       body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #FFFFFF;
      }

      .clock {
        float:left; display:block; margin:10px; padding:10px; background-color:#fff;
        
      }

      .form-signin {
        max-width: 400px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <div class="row">
        <div class="span2">
          <img src="/assets/img/eSikshaLogo.gif" height="100" width="100">
        </div>
        <div class="span7">
          <div class="page-header">
            <h2><strong>eSiksha </strong><br /> 
            <small>The new way of learning</small></h2>
          </div>
        </div>
        <!-- Small login in the top when in main page but dont show in login page -->
        <div class="span3 muted">
          <?php
              if ($page=="main") {
                $this->load->view('small_login');
              }
              else if ($page=="login_form" || $page=="forgot_form") {
                //Show Nothing
              }
              else {
                $this->load->view('greeting');
              }
          ?>
        </div>
      </div>
        
        <div class= "navbar navbar-inverse"  style="position: static;">
            <div class="navbar-inner">
                <div class="container">
                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <a class="brand" href="/admin/welcome">eSiksha</a>
                  </a>
                  <div class="nav-collapse collapse navbar-inverse-collapse">
                    <ul class="nav">
                  <?php
                     if($page != "login_form" || $page != "logout"){   
                        foreach($nav as $link){
                          if ($link->name == "Message") {
                            echo '<li class="dropdown">';
                            echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#"> Message <b class="caret"></b></a>';
                            echo '<ul class="dropdown-menu">';
                            echo '<li><a href="/admin/sendMessage">New Message</a></li>';
                            echo '<li class="divider"></li>';
                            echo '<li><a href="/admin/messageInbox">Inbox</a></li>';
                            echo '<li><a href="/admin/messageSent">Sent Item</a></li>';
                            echo '</ul></li>';
                          }
                          else {
                            echo "<li><a href='".base_url()."admin/".$link->name."' >".$link->name."</a></li>";
                          }  
                        } 
                    }
                  ?>
                    </ul>
                  </div>
                </div>
            </div>
       </div>
      <hr />
      <?php if($page) $this->load->view($page); ?> 
    </div>
    <br />
    

    <hr />

    <footer class="footer">
      <div class="container">
        <p>Project Designed for <a href="http://www.gcd.ie">Griffith College Dublin</a></p>
        <p>Code by Safal Shrestha</p>
        <p class="text-center">Powered By:</p>
        <ul class="footer-links">
          <li><a href="http://php.net/"><img src="/assets/img/php.png" height="45" width="45"></a></li>
          <li class="muted">·</li>
          <li><a href="http://ellislab.com/codeigniter"><img src="/assets/img/codeigniter.png" height="45" width="45"></a></li>
          <li class="muted">·</li>
          <li><a href=""><img src="/assets/img/javascript.png" height="45" width="45"></a></li>
          <li class="muted">·</li>
          <li><a href=""><img src="/assets/img/jquery.png" height="45" width="45"></a></li>
          <li class="muted">·</li>
          <li><a href=""><img src="/assets/img/ajax.png" height="45" width="45"></a></li>
          <li class="muted">·</li>
          <li><a href=""><img src="/assets/img/apache.png" height="45" width="45"></a></li>
          <li class="muted">·</li>
          <li><a href=""><img src="/assets/img/mysql.png" height="45" width="45"></a></li>
          <br />
          <li><a href=""><img src="/assets/img/twitterbootstrap.png" height="45" width="45"></a></li>
          <li class="muted">·</li>
          <li><a href=""><img src="/assets/img/htmlcss.png" height="45" width="45"></a></li>
          
        </ul>
      </div>
    </footer>
  </body>
  
</html>
