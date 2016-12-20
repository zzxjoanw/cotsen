<!DOCTYPE html>
<!-- 
    Attributions
    -Home Icon made by Icomoon from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com
-->
<html lang="en">
    <head>
        <meta charset="utf-8">

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>Cotsen Open 2016 - Home</title>
        <meta name="description" content="">
        <meta name="author" content="Laura">
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/screen.css" media="screen"/>
        
        <link rel="stylesheet" href="css/flipclock.css">
        <link rel="shortcut icon" href="images/favicon.png">

        <!-- translator -->
        <link rel="prefetch" type="application/l10n" href="localization/locales.ini" />
        <script type="text/javascript" src="localization/l10n.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/flipclock.js"></script>
        <script type="text/javascript">
            var clock;
            var counter;

            $(document).ready(function() {

                // Grab the current date
                var currentDate = new Date();

                // Set some date in the future. In this case, it's always Jan 1
                var futureDate  = new Date("October 22, 2016 8:30:00");

                // Calculate the difference in seconds between the future and current date
                var diff = futureDate.getTime() / 1000 - currentDate.getTime() / 1000;

                // Instantiate a coutdown FlipClock
                clock = $('.clock').FlipClock(diff, {
                    clockFace: 'DailyCounter',
                    countdown: true,
                    showSeconds: true
                });
            });
        </script>
        <script>
            $('#social').toggleon(function(){ //menu open
                $('#social-list').show();
                $('#social').css("top","90px");
            }).toggleoff(function(){ //menu closed
                $('#social-list').hide();
                $('#social').css("top","30px");
            });
        </script>
    </head>
    <body>
        <?
            include 'includes/header.php';
            include 'includes/feedback-box.php';
        ?>
        <div id="main">
            <div class="mainHeaderText" id="mainHeaderText">2016 Cotsen Open with 5th AGA Pro Prelim</div>
            <div class="container">
                <div class="row">
                    <div class="panel panel-default">
                        <div id="clock">
                            <h3 style="padding-bottom: 15px">Cotsen Open 2016 begins in &hellip;</h3>
                            <div class="clock"></div>
                        </div>
                    </div>
                </div>
            <div class="container">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">Announcement!</div>
                        <div class="panel-body">
                            The tournament is on October 22nd-23rd this year. <b>Pre-registration will close on Tuesday,
                            October 20th, at 11:59pm.</b>  Day-of registration will also be available at a price of
                            $25.  Pre-registration comes with great benefits, including $20 entry fee and free
                            food truck lunch on both days!  Pre-register now!
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Announcement!</div>
                        <div class="panel-body">Cotsen Open 2016 registration is now open!</div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">We have a new location!</div>
                        <div class="panel-body">
                            <address>
                                Korean Cultural Center Los Angeles
                                5505 Wilshire Blvd.
                                Los Angeles, CA 90036
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="images"><img src="images/2014-01.jpg"><img src="images/2014-02.jpg"></div>
        <footer>
            <p>
                &copy; <? echo date('Y'); ?> by dcwebdev.net
            </p>
        </footer>
    </body>
</html>
