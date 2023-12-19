<?php
    session_start();   
    include('../../conn.php');
    $root = "../../";
    $id_utente = $_SESSION['id_utente'];
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

      <title>THE PROJECT SOCIETY</title>

      <link type="text/css" rel="stylesheet" href="../../res/css/homepage.css" />
      <link type="text/css" rel="stylesheet" href="../../res/css/control/listautenti.css" />
      

  </head>

  <body>

    <div class="homepage">
      <div class="homepage-sidebar">
        <div class="intestazione">
          <div class="logo">TPS</div>
        </div>
        <div class="homepage-sidebar-list">
          <a class="elem" href="homepage.php">Homepage</a>
          <a class="elem" href="bacheca.php">Bacheca</a>
          <a class="elem">Progetti</a>
          <a class="elem">Bozze</a>
          <a class="elem">Storico</a>
          <div class="divisore"></div>
          <a class="elem">Logout</a>
        </div>
      </div>
      <div class="dashboard">
        <div class="toolbar"></div>
        <div class="cards">

        <div class="container">
        <table class="user-list">
            <thead>
                <tr>
                    <th><span>User</span></th>
                    <th><span>Created</span></th>
                    <th><span>Status</span></th>
                    <th><span>Email</span></th>
                    <th>Tools</th>
                </tr>
            </thead>

        <?php
            $conn = connect_to_db($servername, $db_username, $db_password, $db_name);
            $query = "SELECT * FROM utente";
            $result = $conn->query($query);

            while ($row = mysqli_fetch_assoc($result)){
            echo "        <tbody>\n";
            echo "            <tr>\n";
            echo "                <td>\n";
            echo "                    <div class=\"container-user-info\">\n";
            echo "                        <img src=\"../../img/avatar/" . $row['avatar'] . "\" alt=\"\">\n";
            echo "                        <a href=\"#\" class=\"user-link\">" . $row['username'] . "</a>\n";
            echo "                        <span class=\"user-type\">" . $row['tipo'] . "</span>\n";
            echo "                    </div>\n";
            echo "                </td>\n";
            echo "                <td>\n";
            echo "                    " . $row['data'] . "\n";
            echo "                </td>\n";

            if($row['ban'] == 0){
                echo "                <td>\n";
                echo "                    <span class=\"positiveStatus\">Attivo</span>\n";
                echo "                </td>\n";
            }else{
                echo "                <td>\n";
                echo "                    <span class=\"negativeStatus\">Sospeso</span>\n";
                echo "                </td>\n";
            }
            echo "                <td>\n";
            echo "                    <a>" . $row['email'] . "</a>\n";
            echo "                </td>\n";

            if($row['ban'] == 0){
                echo "          <td>\n";
                echo "          <form class=\"form-ban\" action=\"../../lib/ban-sban.php\" method=\"post\">\n";
                echo "                   <input type=\"hidden\" name=\"id_profilo\" value=" . $row['id'] . "></input>\n";
                echo "                   <input type=\"hidden\" name=\"ban\" value=\"sospendi\"></input>\n";
                echo "                   <button type=\"submit\">Sospendi</button>\n";
                echo "          </form>\n";
                echo "          </td>\n";
            }elseif($row['ban'] == 1){
                echo "          <td>\n";
                echo "          <form class=\"form-ban\" action=\"../../lib/ban-sban.php\" method=\"post\">\n";
                echo "                   <input type=\"hidden\" name=\"id_profilo\" value=" . $row['id'] . "></input>\n";
                echo "                  <input type=\"hidden\" name=\"ban\" value=\"riabilita\"></input>\n";
                echo "                   <button type=\"submit\">Riabilita</button>\n";
                echo "          </form>\n";
                echo "          </td>\n";
            }

            echo "            </tr>\n";
            echo "        </tbody>\n";
            }
        ?>
        </table>
            
        </div>
      </div>
    </div>
  </body>
                
</html>

