<?
    function checkValues()
    {
        if($_POST['fname'] == "") return false;
        if($_POST['lname'] == "") return false;
        if($_POST['dob'] == "") return false;
        if($_POST['country'] == "") return false;
        if($_POST['street'] == "") return false;
        if($_POST['city'] == "") return false;
        if($_POST['state'] == "") return false;
        if($_POST['zip'] == "") return false;
        if($_POST['email'] == "") return false;
        if($_POST['phone'] == "") return false;
        
        return true;
    }
    
    function sanitize($var, $conn)
    {
        return @$conn->real_escape_string(trim($var));
    }
    
    $status="prereg";
    //set page status:
        //notyet = registration not ready yet
        //prereg = prereg open
        //atdoor = registration at door only
        //post = tournament over  
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>Cotsen Open 2016 - Registration</title>
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
        
        <script>
            $(document).ready(function() {
                $( "#datepicker" ).datepicker({dateFormat: "yy-mm-dd", changeYear:true, yearRange:"-100:-5" });
                var rect = document.getElementById("datepicker").getBoundingClientRect();
                console.log(rect.top, rect.right, rect.bottom, rect.left);
                $("#ui-datepicker-div").css("left",rect.right + 50);
        
                var countryList = [<? include "includes/country-list.php" ?>];
                $("#country").autocomplete({ source:countryList});
            });
        </script>
        
        <style>
            .error { border:1px solid red; }
        </style>
    </head>
    <body>
        <?
            include "includes/header.php";
            
            if( (isset($_POST['bttnSubmit'])) && (checkValues()) ) //form submitted properly, not paid yet
            {
                //error_reporting(E_ALL);
                //ini_set('display_errors', '1');
                
                include 'includes/login.php';
                
                $conn = new mysqli($host, $username, $password, $dbname) or die("Unable to connect to database. Please try registering again later.");

                /*function sanitize($var, $conn)
                {
                    return $conn->real_escape_string(trim($var));
                }*/
                
                $conn->set_charset("utf8");
                
                if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
                
                $pps = $conn->prepare("SELECT * FROM tblContestant WHERE AGANumber = ?");
                $pps->bind_param("s",$_POST['agaNum']);
                $pps->execute();
                $pps->store_result();
                
                /*$AGANumber = sanitize($_POST['agaNum'], $conn);
                $fname = sanitize($_POST['fname'], $conn);
                $lname = sanitize($_POST['lname'], $conn);
                $dob = sanitize($_POST['dob'], $conn);
                $country = sanitize($_POST['country'], $conn);
                $street = sanitize($_POST['street'], $conn);
                $city = sanitize($_POST['city'], $conn);
                $state = sanitize($_POST['state'], $conn);
                $zip = sanitize($_POST['zip'], $conn);
                $email = sanitize($_POST['email'], $conn);
                $phone = sanitize($_POST['phone'], $conn);
                $club = sanitize($_POST['club'], $conn);*/
               
                if($pps->num_rows == 1)
                {
                    $pps->close();
                    
                    //$pps = $conn->prepare("UPDATE tblContestant SET AGANumber=?,fName=?,lName=?, dofb=?, country=?, street=?, city=?,
                        //state=?, zip=?, email=?, phone=?, club=? WHERE AGANumber = ?");
                    //$pps->bind_param("sssssssssssss",$AGANumber,$fname,$lname,$dob,$country,$street,$city,$state,$zip,$email,$phone,
                        //$club, $AGANumber);
                    
                    //$pps->execute();
                    //$pps->close();
                }
                else
                {
                    $pps->close();
                    
                    $pps = $conn->prepare("INSERT INTO tblContestant (AGANumber,fName,lName, dofb,country,street, city,state,zip,
                        email,phone,club) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                    if($pps->bind_param("ssssssssssss",$AGANumber,$fname,$lname,$dob,$country,$street,$city,$state,$zip,$email,$phone,
                        $club))
                    {
                        $AGANumber = sanitize($_POST['agaNum'], $conn);
                        $fname = sanitize($_POST['fname'], $conn);
                        $lname = sanitize($_POST['lname'], $conn);
                        $dob = sanitize($_POST['dob'], $conn);
                        $country = sanitize($_POST['country'], $conn);
                        $street = sanitize($_POST['street'], $conn);
                        $city = sanitize($_POST['city'], $conn);
                        $state = sanitize($_POST['state'], $conn);
                        $zip = sanitize($_POST['zip'], $conn);
                        $email = sanitize($_POST['email'], $conn);
                        $phone = sanitize($_POST['phone'], $conn);
                        $club = sanitize($_POST['club'], $conn);
                                          
                        if($pps->execute())
                        {
                            $pps->close();
                        }
                        else
                        {
                            echo "error: ". $pps->error;
                        }
                    }
                    else
                    {
                        echo "error: ". $pps->error;
                    }
                }
                
                if(!$pps = $conn->prepare("INSERT INTO tblParticipation (year, AGANumber) VALUES(2015,?)"))
                {
                    echo "error2:".$conn->error;
                }
                else
                {
                    $pps->bind_param("s",$AGANumber);
                    $pps->execute();
                }
                
                //send confirmation email
                date_default_timezone_set('Etc/UTC');
                require 'phpmailer/PHPMailerAutoload.php';
                $mail = new PHPMailer;
                $mail->Username = "cotsenopen@gmail.com";
                $mail->Password = "ericcotsen";
                //include 'includes/email-login.php';
                $mail->isSMTP();
                $mail->SMTPDebug = 0; //0=no output, 2=server communication
                $mail->Debugoutput = 'html';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;

                $mail->setFrom('cotsenopen@gmail.com', 'Cotsen Open');
                $mail->addAddress('cotsenopen@gmail.com','Cotsen Open'); //handles users who don't ...
                $mail->addCC($_POST['email'], $_POST['fname']. " ".$_POST['lname']); // enter an email address
                $mail->Subject = '2016 Cotsen Open registration confirmation';
                $body =    'Thanks for registering!<br/>'
                         . 'Here\'s the information you submitted. If you need to change it, email '
                         . '<a href="mailto:cotsenopen@gmail.com">cotsenopen@gmail.com</a>.'
                         
                         . '<table border=1>'
                         . '<tr><td colspan=2 align=center>Personal Info</td></tr>'
                         . '<tr><td>First (Given) Name</td><td>' . $_POST['fname'] . '</td></tr>'
                         . '<tr><td>Last (Family) Name</td><td>' . $_POST['lname'] . '</td></tr>'
                         . '<tr><td>Date of Birth</td><td>' . $_POST['dob'] . '</td></tr>'
                         
                         . '<tr><td colspan=2 align=center>Contact Info</td></tr>'
                         . '<tr><td>Country</td><td>' . $_POST['country'] . '</td></tr>'
                         . '<tr><td>Street Address</td><td>' . $_POST['street'] . '</td></tr>'
                         . '<tr><td>City</td><td>' . $_POST['city'] . '</td></tr>'
                         . '<tr><td>State/Province</td><td>' . $_POST['state'] . '</td></tr>'
                         . '<tr><td>Zip/Postcode</td><td>' . $_POST['zip'] . '</td></tr>'
                         . '<tr><td>Email</td><td>' . $_POST['email'] . '</td></tr>'
                         . '<tr><td>Phone</td><td>' . $_POST['phone'] . '</td></tr>'
                         
                         . '<tr><td colspan=2 align=center>Competition Info</td></tr>'
                         . '<tr><td>AGA Number</td><td>' . $_POST['agaNum'] . '</td></tr>'
                         . '<tr><td>Club Name</td><td>' . $_POST['club'] . '</td></tr>'
                         . ' </table>'
                         . 'We look forward to seeing you at the tournament!<br/>'
                         . '  -- The Cotsen Open team';
                $mail->msgHTML($body);
                
                //send the message, check for errors
                $mail->send();
                
                ?>
                <br>
                Thanks for registering!<br>
                <!--<br>
                You can pay with Paypal now, or in cash at the door. You'll get the benefits of preregistration either way!<br/>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="NG3PQGVBXT2EY">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form>-->
                <?
            }
            elseif(isset($_POST['bttnSubmit'])&&(!checkValues())) //form submitted with invalid/blank entries
            { ?>
                <form action="new-reg-form.php" method="post">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading">Payment Methods</div>
                            <div class="panel-body">
                                <!--After filling out the form, you'll be given the choice of paying with
                                <a href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_flow&SESSION=-xhkV9jNq_Pd1xm7jjn5Dr8IFjXYcX3tKiYfORCXaM1T_J23Z5uG56QdEEq&dispatch=50a22
2a57771920b6a3d7b606239e4d529b525e0b7e69bf0224adecfb0124e9b61f737ba21b08198cf7658296ddbf66bbd0b039a3775ce6f">PayPal</a>
                                or paying at the door. You'll get the benefits of pre-registration either way!-->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!--<div class="panel panel-default">
                            <div class="panel-heading">QuickReg</div>
                            <div class="panel-body">
                                <label for="quickreg">If you attended last year's tournament, enter your AGA number</label>
                                <input type="text" name="quickreg" id="quickreg">
                                <button class="btn btn-primary">Sign me up!</button>
                            </div>
                        </div>-->
                        <div class="panel panel-default">
                            <div class="panel-heading">Personal Info</div>
                            <div class="panel-body">
                                <div>
                                    <label for="fname">First Name (Given Name)</label>
                                    <span>*</span>
                                    <input type="text" name="fname" id="fname"
                                        <?
                                            if($_POST[fname] == "")
                                            {
                                                echo 'class="error"';
                                            }
                                            else
                                            {
                                                echo 'value="' . $_POST[fname] . '"';
                                            }
                                        ?>
                                    >
                                </div>
                                <div>
                                    <label for="lname">Last Name (Family Name)</label>
                                    <span>*</span>
                                    <input type="text" name="lname" id="lname"
                                        <?
                                            if($_POST[lname] == "")
                                            {
                                                echo 'class="error"s';
                                            }
                                            else
                                            {
                                                echo 'value="' . $_POST[lname] . '"';
                                            }
                                        ?>
                                    >
                                </div>
                                <div>
                                    <label for="dob">Date of Birth</label>
                                    <span>*</span>
                                    <input type="text" name="dob" id="datepicker" 
                                        <?
                                            if($_POST[dob] == "")
                                            {
                                                echo 'class="error"';
                                            }
                                            else
                                            {
                                                echo 'value="' . $_POST[dob] . '"';
                                            }
                                        ?>
                                    >
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">Contact Information</div>
                            <div class="panel-body">
                                <div>
                                    <label for="country">Country</label>
                                    <span>*</span>
                                    <input type="text" name="country" id="country"
                                        <?
                                            if($_POST[country] == "")
                                            {
                                                echo 'class="error"';
                                            }
                                            else
                                            {
                                                echo 'value="' . $_POST[country] . '"';
                                            }
                                        ?>
                                    >
                                </div>
                                <div>
                                    <label for="street">Street Address</label>
                                    <span>*</span>
                                    <input type="text" name="street" id="street"
                                        <?
                                            if($_POST[street] == "")
                                            {
                                                echo 'class="error"';
                                            }
                                            else
                                            {
                                                echo 'value="' . $_POST[street] . '"';
                                            }
                                        ?> 
                                    >
                                </div>
                                <div>
                                    <label for="city">City</label>
                                    <span>*</span>
                                    <input type="text" name="city" id="city"
                                        <?
                                            if($_POST[city] == "")
                                            {
                                                echo 'class="error"';
                                            }
                                            else
                                            {
                                                echo 'value="' . $_POST[city] . '"';
                                            }
                                        ?> 
                                    >
                                </div>
                                <div>
                                    <label for="state">State/Province</label>
                                    <span>*</span>
                                    <input type="text" name="state" id="state"
                                        <?
                                            if($_POST[state] == "")
                                            {
                                                echo 'class="error"';
                                            }
                                            else
                                            {
                                                echo 'value="' . $_POST[state] . '"';
                                            }
                                        ?> 
                                    >
                                </div>
                                <div>
                                    <label for="zip">Zip/Postcode</label>
                                    <span>*</span>
                                    <input type="text" name="zip" id="zip"
                                        <?
                                            if($_POST[zip] == "")
                                            {
                                                echo 'class="error"';
                                            }
                                            else
                                            {
                                                echo 'value="' . $_POST[zip] . '"';
                                            }
                                        ?> 
                                    >
                                </div>
                                <div>
                                    <label for="email">Email</label>
                                    <span>*</span>
                                    <input type="text" name="email" id="email"
                                        <?
                                            if($_POST[email] == "")
                                            {
                                                echo 'class="error"';
                                            }
                                            else
                                            {
                                                echo 'value="' . $_POST[email] . '"';
                                            }
                                        ?>
                                    >
                                </div>
                                <div>
                                    <label for="phone">Phone Number</label>
                                    <span>*</span>
                                    <input type="text" name="phone" id="phone"
                                        <?
                                            if($_POST[phone] == "")
                                            {
                                                echo 'class="error"';
                                            }
                                            else
                                            {
                                                echo 'value="' . $_POST[phone] . '"';
                                            }
                                        ?> 
                                    >
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">Competition Info</div>
                            <div class="panel-body">
                               <div>
                                    <label for="agaNum">AGA Number</label>
                                    <span>*</span>
                                    <input type="text" name="agaNum" id="agaNum"
                                        <?
                                            if($_POST[agaNum] == "")
                                            {
                                                echo 'class="error"';
                                            }
                                            else
                                            {
                                                echo 'value="' . $_POST[agaNum] . '"';
                                            }
                                        ?> 
                                    >
                                </div>
                                <div>
                                    <label for="club">Club Name</label>
                                    <span>*</span>
                                    <input type="text" name="club" id="club"
                                        <?
                                            if($_POST[club] == "")
                                            {
                                                echo 'class="error"';
                                            }
                                            else
                                            {
                                                echo 'value="' . $_POST[club] . '"';
                                            }
                                        ?> 
                                    >
                                </div>
                            </div>
                        </div>
                        <div style="width:100%; text-align:center">
                            <button class="btn btn-primary" value="submit" name="bttnSubmit">Register!</button>
                        </div>
                    </form>
                
            <? }
            else if($_GET['paid']==1): //returning from paypal page
            { ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Thanks for paying!</div>
                    <div class="panel-body">See you at the tournament!</div>
                </div>
            <? }
            else: //form not submitted yet
            { 
                if($status == "notyet")
                {
                    ?>
                        <div class="container">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Announcement!</div>
                                    <div class="panel-body">
                                        The registration period for this year's tournament hasn't started yet. Check back soon!
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?
                }
                elseif($status == "post")
                {
                    ?>
                        <div class="container">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Announcement!</div>
                                    <div class="panel-body">Check back next year for the 2016 tournament!</div>
                                </div>
                            </div>
                        </div>
                    <?
                }
                elseif($status == "atdoor")
                {
                    ?>
                        <div class="container">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Announcement!</div>
                                    <div class="panel-body">
                                        The prereg period for this year's tournament has ended, but you can still register at the door.
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?
                }
                else //status == prereg
                {
                    ?>
                    <form action="new-reg-form.php" method="post">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">Payment Methods</div>
                                <div class="panel-body">
                                    After filling out the form, you'll be given the choice of paying with
                                    <a href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_flow&SESSION=-xhkV9jNq_Pd1xm7jjn5Dr8IFjXYcX3tKiYfORCXaM1T_J23Z5uG56QdEEq&dispatch=50a22
    2a57771920b6a3d7b606239e4d529b525e0b7e69bf0224adecfb0124e9b61f737ba21b08198cf7658296ddbf66bbd0b039a3775ce6f">PayPal</a>
                                    or paying at the door. You'll get the benefits of pre-registration either way!
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!--<div class="panel panel-default">
                                <div class="panel-heading">QuickReg</div>
                                <div class="panel-body">
                                    <label for="quickreg">If you attended last year's tournament, enter your AGA number</label>
                                    <input type="text" name="quickreg" id="quickreg">
                                    <button class="btn btn-primary">Sign me up!</button>
                                </div>
                            </div>-->
                            <div class="panel panel-default">
                                <div class="panel-heading">Personal Info</div>
                                <div class="panel-body">
                                    <div>
                                        <label for="fname">First Name (Given Name)</label>
                                        <span>*</span>
                                        <input type="text" name="fname" id="fname">
                                    </div>
                                    <div>
                                        <label for="lname">Last Name (Family Name)</label>
                                        <span>*</span>
                                        <input type="text" name="lname" id="lname">
                                    </div>
                                    <div>
                                        <label for="dob">Date of Birth</label>
                                        <span>*</span>
                                        <input type="text" name="dob" id="datepicker">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel panel-default">
                                <div class="panel-heading">Contact Information</div>
                                <div class="panel-body">
                                    <div>
                                        <label for="country">Country</label>
                                        <span>*</span>
                                        <input type="text" name="country" id="country">
                                    </div>
                                    <div>
                                        <label for="street">Street Address</label>
                                        <span>*</span>
                                        <input type="text" name="street" id="street">
                                    </div>
                                    <div>
                                        <label for="city">City</label>
                                        <span>*</span>
                                        <input type="text" name="city" id="city">
                                    </div>
                                    <div>
                                        <label for="state">State/Province</label>
                                        <span>*</span>
                                        <input type="text" name="state" id="state">
                                    </div>
                                    <div>
                                        <label for="zip">Zip/Postcode</label>
                                        <span>*</span>
                                        <input type="text" name="zip" id="zip">
                                    </div>
                                    <div>
                                        <label for="email">Email</label>
                                        <span>*</span>
                                        <input type="text" name="email" id="email">
                                    </div>
                                    <div>
                                        <label for="phone">Phone Number</label>
                                        <span>*</span>
                                        <input type="text" name="phone" id="phone">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel panel-default">
                                <div class="panel-heading">Competition Info</div>
                                <div class="panel-body">
                                   <div>
                                        <label for="agaNum">AGA Number (leave blank for none)</label>
                                        <input type="text" name="agaNum" id="agaNum">
                                    </div>
                                    <div>
                                        <label for="club">Club Name (leave blank for none)</label>
                                        <input type="text" name="club" id="club">
                                    </div>
                                </div>
                            </div>
                            <div style="width:100%; text-align:center">
                                <button class="btn btn-primary" value="submit" name="bttnSubmit">Register!</button>
                            </div>
                        </form>
                    <?
                }
            }
            endif;