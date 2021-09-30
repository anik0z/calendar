<?php

include_once __DIR__ . '/../Controller/UserController.php';
include_once __DIR__ . '/../Controller/CalendarController.php';
include_once __DIR__ . '/../Controller/AppointmentController.php';

    if(!isset($_COOKIE["currentUser"])){
        header("Location: ../View/User/login.php");
    }else{
        /*
         * get the current user for have the information
         */
        $idCurrentUser = $_COOKIE["currentUser"];
        $userController = new UserController();
        $currentUser = $userController->getUser($idCurrentUser);

        /*
         *  get current date and get the information for print the calendar correct and the days
         *  Always be default it´s generated the data for the day of today!
         *  Update ( for the pagination this need to be change )
         *
         */
        $currentMonth = date('m');
        $currentMonthPrint = date("M");
        $currentYear = date('Y');
        $currentDay = date("d");
        $currentDate = date("Y-m-d");
        $maxDays = date('t');
        $firstDay = date('Y-m-01');
        $jumpDays = date('w',strtotime($firstDay));

        $maxSizeMatrix = 34;

        if(!empty($_GET)){
            if(!empty($_GET["month"]) || !empty($_GET["year"])){
                $currentMonth = $_GET["month"];
                $currentYear = $_GET["year"];
                $currentDate = date("Y-m-d", strtotime("$currentYear-$currentMonth-01"));
                $currentDay = date("d",strtotime($currentDate));
                $currentMonthPrint = date("M",strtotime($currentDate));
                $maxDays = date('t', strtotime($currentDate));
                $firstDay = $currentDate;
                $jumpDays = date('w',strtotime($firstDay));
            }
        }

        // Calculate the previous and next month for the pagination
        $previousDate = date('Y-m-d', strtotime('-1 month', strtotime($firstDay)));
        $previousMonth = date("m", strtotime($previousDate));
        $previousYear = date("Y", strtotime($previousDate));
        $nextDate = date('Y-m-d', strtotime('+1 month', strtotime($firstDay)));
        $nextMonth = date("m", strtotime($nextDate));;
        $nextYear = date("Y", strtotime($nextDate));;

        $appointmentController = new AppointmentController();
        $calendarController = new CalendarController();

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Calendar</title>
            <link rel="stylesheet" href="css/main.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        </head>
        <body>
        <header>
            <h1>Calendar</h1>
            <img src="img/Icinga_logo.png" alt="icinga" width="150" height="50">
            <img src="img/favicon.png" alt="nextways" width="50" height="50">
        </header>
        <main>
            <h4>Calendar for user: <?php echo $currentUser->getUsername() ?></h4>

            <!-- Create the form for pagination -->

            <div class="paginationMonth">
                <a href="index.php?month=<?php echo $previousMonth; ?>&year=<?php echo $previousYear; ?>"><<</a>
                <h5> DATE: <?php echo "$currentMonthPrint - $currentYear"; ?></h5>
                <a href="index.php?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>">>></a>
            </div>

            <table>
                <tr>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                    <th>Sunday</th>
                </tr>
                <?php

                // SHOW CALENDAR


                $daysRest = 0;

                if($jumpDays > 0){
                    echo "<tr>";
                    for($i = 0; $i < $jumpDays - 1; $i++){
                        echo "<td><p>empty</p></td>";
                    }
                    while($daysRest <= (7 - $jumpDays)){
                        $firstDay = date($currentYear.'- '.$currentMonth.' -'.($daysRest + 1));
                        $calendar = $calendarController->getDailyAppointment(($daysRest + 1),$currentMonth,$currentYear);

                        if($currentDay == $firstDay){
                            echo "<td class='currentDay'><p>".($daysRest + 1)."</p><ul>";
                        }else{
                            echo "<td><p>".($daysRest + 1)."</p><ul>";
                        }

                        foreach ($calendar as $appointment){
                            // Create the form with the links to update,remove or add
                            echo "<li>".
                                    '<div class="appointment">'.
                                        '<div class="title">'.$appointment->getTitle().'</div>'.
                                        '<div class="date">'.$appointment->getDate()->format("H:i").'</div>'.
                                        '<div class="description">'.$appointment->getDescription().'</div>'.
                                        '<div class="actions">'.
                                            '<form class="form" action="../View/Appointment/edit.php" method="post">'.
                                                '<div class="container">'.
                                                    '<input type="hidden" name="action" value="edit">'.
                                                    '<input type="hidden" name="id" value="'. $appointment->getId() .'">'.
                                                    '<button type="submit">Edit</button>'.
                                                '</div>'.
                                            '</form>'.
                                            '<form class="form" action="../Controller/AppointmentController.php" method="post">'.
                                                '<div class="container">'.
                                                    '<input type="hidden" name="action" value="delete">'.
                                                    '<input type="hidden" name="id" value="'. $appointment->getId() .'">'.
                                                    '<button type="submit">Delete</button>'.
                                                '</div>'.
                                            '</form>'.
                                        '</div>'.
                                        // Add form with post to doing the add button for each event
                                    '</div>'.
                                '</li>';
                        }

                        echo "</ul>";

                        echo '<form class="form" action="Appointment/add.php" method="post">'.
                                '<div class="container">'.
                                    '<input type="hidden" name="year" value="'. $currentYear .'">'.
                                    '<input type="hidden" name="month" value="'. $currentMonth .'">'.
                                    '<input type="hidden" name="day" value="'. ($daysRest + 1) .'">'.
                                    '<button type="submit">Add</button>'.
                                '</div>'.
                            '</form>';

                        echo "</td>";

                        $daysRest++;
                    }
                    echo "</tr>";
                    $i = $daysRest + 1;
                }else{
                    $i = 1;
                }

                $days = $i;

                while($i < $maxDays){
                    $j = 0;
                    if($i != 0 && $jumpDays < 0) {
                        echo "<tr>";
                    }
                    while($j < 7 && ($j + $i) <= $maxDays){
                        $firstDay = date($currentYear.'- '.$currentMonth.' -'.$days);
                        $calendar = $calendarController->getDailyAppointment($days,$currentMonth,$currentYear);

                        if($currentDay == $days){
                            echo "<td class='currentDay'><p>$days</p><ul>";
                        }else{
                            echo "<td><p>$days</p><ul>";
                        }

                        foreach ($calendar as $appointment){
                            // Create the form with the links to update,remove or add
                            echo "<li>".
                                    '<div class="appointment">'.
                                        '<div class="title">'.$appointment->getTitle().'</div>'.
                                        '<div class="date">'.$appointment->getDate()->format("H:i").'</div>'.
                                        '<div class="description">'.$appointment->getDescription().'</div>'.
                                        '<div class="actions">'.
                                            '<form class="form" action="../View/Appointment/edit.php" method="post">'.
                                                '<div class="container">'.
                                                    '<input type="hidden" name="action" value="edit">'.
                                                    '<input type="hidden" name="id" value="'. $appointment->getId() .'">'.
                                                    '<button type="submit">Edit</button>'.
                                                '</div>'.
                                            '</form>'.
                                            '<form class="form" action="../Controller/AppointmentController.php" method="post">'.
                                                '<div class="container">'.
                                                    '<input type="hidden" name="action" value="delete">'.
                                                    '<input type="hidden" name="id" value="'. $appointment->getId() .'">'.
                                                    '<button type="submit">Delete</button>'.
                                                '</div>'.
                                            '</form>'.
                                        '</div>'.
                                    '</div>'.
                                '</li>';
                        }

                        echo "</ul>";

                        echo '<form class="form" action="Appointment/add.php" method="post">'.
                                '<div class="container">'.
                                    '<input type="hidden" name="year" value="'. $currentYear .'">'.
                                    '<input type="hidden" name="month" value="'. $currentMonth .'">'.
                                    '<input type="hidden" name="day" value="'. $days .'">'.
                                    '<button type="submit">Add</button>'.
                                '</div>'.
                            '</form>';

                        echo "</td>";

                        $days++;
                        $j++;
                    }
                    $i += $j;

                    echo "</tr>";

                }

                ?>
            </table>

            <a class="buttonAdd" href="Appointment/add.php">Add</a>
        </main>
        </body>
        </html>

        <?php
    }
?>
