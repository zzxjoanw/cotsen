<?
    $status="during";
    //set page status:
        //pre = schedule
        //during = schedule shown on page
        //post = tournament over  
?>

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

        <title>Cotsen Open 2014 - Home</title>
        <meta name="description" content="">
        <meta name="author" content="Laura">
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
                
        
        <link rel="stylesheet" href="css/flipclock.css">
        <link rel="shortcut icon" href="images/favicon.png">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/screen.css" />
        
        <script src="js/flipclock.js"></script>
        <!--<script type="text/javascript">
            var clock;
            var counter;

            $(document).ready(function() {

                // Grab the current date
                var currentDate = new Date();

                // Set some date in the future. In this case, it's always Jan 1
                var futureDate  = new Date("October 25, 2014 8:30:00");

                // Calculate the difference in seconds between the future and current date
                var diff = futureDate.getTime() / 1000 - currentDate.getTime() / 1000;

                // Instantiate a coutdown FlipClock
                clock = $('.clock').FlipClock(diff, {
                    clockFace: 'DailyCounter',
                    countdown: true,
                    showSeconds: true
                });
            });
        </script>-->
    </head>
    <body>
        <?
            include 'includes/header.php';
        ?>
        <div id="main">
            <div id="images"><img src="images/2014-03.jpg"><img src="images/2014-04.jpg"></div>
            <?
                if ($status =="pre")
                {
                    ?>
                    <div class="container">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading" data-l10n-id="schedComingSoonTitle" id="schedComingSoonTitle">2016 Schedule coming soon!!</div>
                                <div class="panel-body" data-l10n-id="schedComingSoonText" id="schedComingSoonText">Keep an eye on this page for more information!</div>
                            </div>
                        </div>
                    </div>
                    <?
                }
            ?>
            <?
                if ($status =="during"):
            ?>
            <div class="section" id="schedule">
                <h3 style="margin-top:0">Event Schedule</h3>
                <div>
                    <table>
                        <tr>
                            <th colspan="2" data-l10-id="day1" id="day1">Saturday</th>
                            <th colspan="2" data-l10n-id="day2" id="day2">Sunday</th>
                        </tr>
                        <tr>
                            <td data-l10n-id="d1e1Time" id="d1e1Time">8:00am-9:00am</td>
                            <td data-l10n-id="d1e1Desc" id="d1e1Desc">(Registration)</td>
                            <td data-l10n-id="d2e1Time" id="d2e1Time">8:00am-10:00am</td>
                            <td data-l10n-id="d2e1Desc" id="d2e1Desc">(Pro game)</td>
                        </tr>
                        <tr>
                            <td data-l10n-id="d1e2Time" id="d1e2Time">10:00am-10:30am</td>
                            <td data-l10n-id="d1e2Time" id="d1e2Time">(Opening Announcements)</td>
                            <td data-l10n-id="d2e2Time" id="d2e2Time">9:00am-10:00am</td>
                            <td data-l10n-id="d2e2Time" id="d2e2Time">(Check-in)</td>
                        </tr>
                        <tr>
                            <td data-l10n-id="d1e3Time" id="d1e3Time">10:30am-1:00pm</td>
                            <td data-l10n-id="d1e3Time" id="d1e3Time">(Round 1)</td>
                            <td data-l10n-id="d2e3Time" id="d2e3Time">10:30am-1:00pm</td>
                            <td data-l10n-id="d2e3Time" id="d2e3Time">(Round 4)</td>
                        </tr>
                        <tr>
                            <td data-l10n-id="d1e4Time" id="d1e4Time">11:30am-1:30pm</td>
                            <td data-l10n-id="d1e4Time" id="d1e4Time">(Lunch)</td>
                            <td data-l10n-id="d2e4Time" id="d2e4Time">11:30am-1:30pm</td>
                            <td data-l10n-id="d2e4Time" id="d2e4Time">(Lunch)</td>
                        </tr>
                        <tr>
                            <td data-l10n-id="d1e1Time" id="d1e1Time">1:30pm-4:00pm</td>
                            <td data-l10n-id="d1e1Time" id="d1e1Time">(Round 2)</td>
                            <td data-l10n-id="d2e1Time" id="d2e1Time">1:30pm-4:00pm</td>
                            <td data-l10n-id="d2e1Time" id="d2e1Time">(Round 5)</td>
                        </tr>
                        <tr>
                            <td data-l10n-id="d1e1Time" id="d1e1Time">4:30pm-7:00pm</td>
                            <td data-l10n-id="d1e1Time" id="d1e1Time">(Round 3)</td>
                            <td data-l10n-id="d2e1Time" id="d2e1Time">5:00pm-6:00pm</td>
                            <td data-l10n-id="d2e1Time" id="d2e1Time">(Awards Ceremony)</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="section">
                <h3 style="margin-top:0">행사 일정</h3>
                <div>
                    <table>
                        <tr><th colspan="2">토요일</th><th colspan="2">일요일</th></tr>
                        <tr>
                            <td>8:00am-9:00am</td><td>(등록 절차)</td>
                            <td>8:00am-10:00am</td><td>(프로 게임)</td>
                        </tr>
                        <tr><td>10:00am-10:30am</td><td>(규칙에 관한 설명)</td><td>9:00am-10:00am</td><td>(체크인 및 수속)</td></tr>
                        <tr><td>10:30am-1:00pm</td><td>(라운드 1)</td><td>10:30am-1:00pm</td><td>(라운드 4)</td></tr>
                        <tr><td>11:30am-1:30pm</td><td>(점심음식 트럭)</td><td>11:30am-1:30pm</td><td>(점심음식 트럭)</td></tr>
                        <tr><td>1:30pm-4:00pm</td><td>(라운드 2)</td><td>1:30pm-4:00pm</td><td>(라운드 5)</td></tr>
                        <tr><td>4:30pm-7:00pm</td><td>(라운드 3)</td><td>5:00pm-6:00pm</td><td>(폐막식시상식)</td></tr>
                    </table>
                </div>
            </div>
            <div class="section"><!-- Chinese -->
                <h3 style="margin-top:0">活动日程</h3>
                <div>
                    <table>
                        <tr><th colspan="2">星期六</th><th colspan="2">星期天</th></tr>
                        <tr>
                            <td>8:00am-9:00am</td><td>(登记)</td>
                            <td>8:00am-10:00am</td><td>(职业七段杨以伦 下表演棋)</td>
                        </tr>
                        <tr><td>10:00am-10:30am</td><td>(比赛规则讨论)</td><td>9:00am-10:00am</td><td>(登记)</td></tr>
                        <tr><td>10:30am-1:00pm</td><td>(第1盘)</td><td>10:30pm-1:00pm</td><td>(第4盘)</td></tr>
                        <tr><td>11:30pm-1:30pm</td><td>(午餐)</td><td>11:30pm-1:30pm</td><td>(午餐)</td></tr>
                        <tr><td>1:30pm-4:00pm</td><td>(第2盘)</td><td>1:30pm-4:00pm</td><td>(第5盘)</td></tr>
                        <tr><td>4:30pm-7:00pm</td><td>(第3盘)</td><td>5:00pm-6:00pm</td><td>(颁奖典礼)</td></tr>
                    </table>
                </div>
            </div>
            <!--
            <div class="section">
                <h3>Japanese Schedule</h3>
                <div>
                    <table>
                        <tr><th>Saturday 星期六</th><th>Sunday 星期天</th></tr>
                        <tr>
                            <td>8:30am-9:30am (Registration 登记)</td>
                            <td>8:00am-10:00am (Pro game with Yilun Yang 7p 职业七段杨以伦 下表演棋)</td>
                        </tr>
                        <tr><td>10:30am-11:00am (Rules Discussion 比赛规则讨论)</td><td>10:00am-11:00am( Check-in    登记)</td></tr>
                        <tr><td>11:00am-12:30pm (Round 1 第1盘)</td><td>12:00pm-1:30pm (Round 4      第4盘)</td></tr>
                        <tr><td>12:00pm-2:00pm (Lunch 午餐)</td><td>1:00pm-3:00pm (Lunch            午餐)</td></tr>
                        <tr><td>1:30pm-3:00pm (Round 2 第2盘)</td><td>2:30pm-4:00pm ( Round 5        第5盘)</td></tr>
                        <tr><td>3:30pm-5:00pm (Round 3 第3盘)</td><td>5:00pm-6:00pm (Awards Ceremony  颁奖典礼)</td></tr>
                    </table>
                </div>
            </div>-->
            <?
            endif;
            ?>
            <?
                if(status == "post")
                { 
                    echo "Check back next year for more information!";
                }
            ?>
        </div>
    </body>
</html>