<?
    session_start();
    if(!isset($_SESSION['isLoggedIn']))
    {
        $_SESSION['isLoggedIn'] = 0;
    }
    
    if(!isset($_GET['action']))
    {
        $_GET['action'] = "";
    }

    include '../includes/login-live.php'; //holds login credentials
    include '../includes/db-functions.php';
    include '../includes/user-functions.php';
    $connection = connect($host,$username,$password,$dbname);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>Cotsen Open 2015 - Admin</title>
        <meta name="description" content="">
        <meta name="author" content="Laura">
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
         
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-lightness/jquery-ui.css">
        
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="css/screen.css" />
                
        <style>
            span { height:30px; }
        </style>
    </head>
    <body style="top:0">
        <nav class="navbar navbar-default">
            <a href="../index.php"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Back to main site</a>
            <a href="admin.php">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Back to admin overview
            </a>
        </nav>
            <?
                if($_SESSION['isLoggedIn'] == 0)
                {
                    if( (@$_POST['username']== $username) && (@$_POST['password']==$password) )
                    {
                        $_SESSION['isLoggedIn'] = 1;
                        header("Location:admin.php");
                    }
                    else
                    {
                        if(isset($_POST['bttnSubmit'])) { echo "You entered an invalid username and/or password."; }
                    ?>
                        <form name="login" action="admin.php" method="post">
                            <label for="username">Username:</label>
                            <input type="text" name="username" id="username">
                            
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password">
                            
                            <input type="submit" value="Submit" name="bttnSubmit">
                        </form>
                    <?
                    }
                }
                else
                {
                    if($_GET['action'] == "view")
                    {
                        $userArray = getUserInfo($connection,$_GET['id']);
                        $currentAGANumber = -1;
                        /* user array can return multiple users, but will (should) only ever return one from this call */
                        ?>
                            <form action="admin.php?action=update&id=<? echo $userArray[0][13] ?>" method="post">
                                <div>
                                    <label for="fname">First (Given) Name:</label>
                                    <input type="text" value="<? echo $userArray[0][1] ?>" name="fname">
                                </div>
                                <div>
                                <label for="lname">Last (Family) Name:</label>
                                <input type="text" value="<? echo $userArray[0][2] ?>" name="lname"><br/>
                                 </div>
                                <div>
                                <label for="dob">Date of Birth:</label>
                                <input type="text" value="<? echo $userArray[0][3] ?>" name="dofb" id="datepicker">
                                 </div>
                                <div>
                                <label for="country">Country</label>
                                <input type="text" value="<? echo $userArray[0][4] ?>" name="country">
                                 </div>
                                <div>
                                <label for="street">Street</label>
                                <input type="text" value="<? echo $userArray[0][5] ?>" name="street">
                                 </div>
                                <div>
                                <label for="city">City</label>
                                <input type="text" value="<? echo $userArray[0][6] ?>" name="city">
                                 </div>
                                <div>
                                <label for="state">State:</label>
                                <input type="text" value="<? echo $userArray[0][7] ?>" name="state">
                                 </div>
                                <div>
                                <label for="zip">Zip: </label>
                                <input type="text" value="<? echo $userArray[0][8] ?>" name="zip">
                                 </div>
                                <div>
                                <label for="email">Email</label>
                                <input type="text" value="<? echo $userArray[0][9] ?>" name="email" size="30">
                                 </div>
                                <div>
                                <label for="phone">Phone:</label>
                                <input type="text" value="<? echo $userArray[0][10] ?>" name="phone">
                                 </div>
                                <div>
                                <label for="club">Club:</label>
                                <input type="text" value="<? echo $userArray[0][11] ?>" name="club">
                                 </div>
                                <input type="submit" value="Submit" name="bttnSubmit">
                            </form>
                        <?
                    }
                    else if($_GET['action'] == "update")
                    {
                        updateUser($connection,$_POST,$_GET['id']);
                        $_GET['action']=NULL;
                        ?>
                            <form action="admin.php" method="post">
                                <input type="submit" value="Return to main page">
                            </form>
                        <?
                    }
                    else if($_GET['action'] == 'delete')
                    {
                        echo "<form action='admin.php?action=confirm&id=" . $_GET['id'] . "' method='post'>";
                        echo "Really delete member " . $_GET['num'] . "?";  //add name?
                        echo "<input type='submit' value='Delete' class='btn btn-warning'>";
                    }
                    else if($_GET['action'] == 'confirm')
                    {
                        deleteUser($connection,$_GET['id']);
                        echo "delete confirmation";
                        
                        if(!$pps = $conn->prepare("DELETE FROM tblContestant WHERE id = ?"))
                        {
                            echo "Error: " . $pps->error;
                        }
                        
                        if( (!$pps->bind_param("i",$_GET['id'])) )
                        {
                            echo "Error: " . $pps->error;
                        }
                        
                        if(!$pps->execute())
                        {
                            echo "Error: " . $pps->error;
                        }
                        
                        if(!$pps->close())
                        {
                            echo "Error: " . $pps->error;
                        }
                    }
                    else
                    {
                        //main contestant list
                        $userArray = getUserInfo($connection);
                        ?>
                        <table border=1 width="100%">
                            <tr>
                                <th>View Details</th>
                                <th>Delete</th>
                                <th>First (Given) Name</th>
                                <th>Last (Family) Name</th>

                                <th>AGA Number</th>
                                <th>Club Name</th>

                                <th>Reg Time</th>

                                <th></th>
                            </tr>
                        <?
                        for($i=0;$i<count($userArray);$i++)
                        {
                            echo "<tr>";

                            //view link
                            echo "<td>";
                            echo "<a href=\"admin.php?action=view&id=".$userArray[$i][13]."\">"; //row ID
                            echo "<span class=\"history glyphicon glyphicon-zoom-in\"></span>";
                            echo "</a>";
                            echo "</td>";

                            //delete link
                            echo "<td>";
                            echo "<a href=\"admin.php?action=delete&id=".$userArray[$i][13]."\">"; //row id
                            echo "<span class=\"delete glyphicon glyphicon-remove\"></span>";
                            echo "</a>";
                            echo "</td>";
                            
                            echo "<td>" . $userArray[$i][1] . "</td>"; //fname
                            echo "<td>" . $userArray[$i][2] . "</td>"; //lname
                            echo "<td>" . $userArray[$i][0] . "</td>"; //aga number
                            echo "<td>" . $userArray[$i][11] . "</td>"; //club name
                            
                            echo "<td>" . $userArray[$i][12] . "</td>"; //reg time
                            
                            echo "</tr>";
                        }
                    }
                }
            ?>
        </table>
    </body>
</html>