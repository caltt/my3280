<?php

// using Bootstrap for HTML

class Page
{
    public static function header()
    {?>
        <!doctype html>
        <html lang="en">
        <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

            <title>3280 Final</title>
        </head>
        <body>
<?php }

    public static function footer()
    {?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
    </html>

<?php }

    // notify at the top
    public static function notify(string $msg)
    {?>
        <div class="alert alert-info text-center mb-0 rounded-0 alert-dismissible fade show">
            <?=$msg?>
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
<?php }

    public static function searchBox()
    {?>
        <form CLASS="container py-4" action="" method="POST">
            <div class="form-inline justify-content-center mb-3">
                <!-- <label class="sr-only" for="keyword"></label> -->
                <input CLASS="form-control w-25 mx-1" TYPE="text" id="keyword" name="keyword" placeholder="Search Terms...">
                <button class="btn btn-primary mx-1">Go!</button>
            </div>
            <div class="custom-control custom-switch text-center">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="caseSensitive" value="sensitive">
                <label class="custom-control-label" for="customSwitch1">Case sensitive</label>
            </div>
        </form>
<?php }   

    public static function navBar()
    {?>
        <div class="container">
            <!-- navbar-expand-sm: sm or larger -->
            <nav class="navbar navbar-expand-md navbar-light">
                <a href="#" class="navbar-brand">3280</a>
                <!-- Burger Button -->
                <button class="navbar-toggler" data-toggle="collapse" data-target="#menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="menu" class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="login.php" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">???</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">!!!</a></li>
                    </ul>
                </div>
            </nav>
        </div>
<?php }

    public static function login(){ ?>
        <form class="container w-25 text-center" action="" method="POST">
            <div>
                <span>User name</span>
                <input class="form-control" type="text" name="username">
            </div>
            <div>
                <span>Password</span>
                <input class="form-control" type="text" name="password">
            </div>
            <div>
                <button class="btn btn-primary my-3" type="submit">Login</button>
            </div>
            <div>
                <p><a class="btn btn-primary" href="createAdmin.php">Sign Up</a></p>
            </div>
        </form>
<?php }

    // calendar on admin's homepage
    public static function adminCalendar($admin, $employees){ ?>
        <div class="container">
            <p>Welcome, <?=$admin->fullname?></p>
            <p><a href="createEmployee.php" class="btn btn-primary">Create employee</a></p>
            <p><a href="assign.php" class="btn btn-primary">Assign</a></p>
            <p><a href="logout.php" class="btn btn-primary">Log out</a></p>
        </div>

<?php }

    public static function employeeCalendar(){

    }

    // the form shown after click some shift in the calendar
    public static function editShift(){

    }

    // the form of creating employee
    public static function createEmployee($jobs){ ?>
        <form class="container w-25 text-center" action="" method="POST">
        <div>
            <span>Username</span>
            <input class="form-control" type="text" name="username">
        </div>
        <div>
            <span>Password</span>
            <input class="form-control" type="text" name="password">
        </div>
        <div>
            <span>Full Name</span>
            <input class="form-control" type="text" name="fullname">
        </div>
        <div>
            <span>Email</span>
            <input class="form-control" type="text" name="email">
        </div>
        <div>
            <span>Phone</span>
            <input class="form-control" type="text" name="phone">
        </div>
        <div>
            <span>Job</span>
            <select name="job_id">
<?php
            foreach ($jobs as $job){
                echo '<option value="' . $job->job_id . '">' . $job->job_title .  '</option>';
            } ?>
            </select>
        </div>
        <div>
            <table>
                <tr>
                    <td>*</td>
                    <td>Morning</td>
                    <td>Evening</td>
                    <td>Night</td>
                </tr>
                <tr>
                    <td>Monday</td>
                    <td><input type="checkbox" name="11" value="checked"></td>
                    <td><input type="checkbox" name="12" value="checked"></td>
                    <td><input type="checkbox" name="13" value="checked"></td>
                </tr>
                <tr>
                    <td>Tuesday</td>
                    <td><input type="checkbox" name="21" value="checked"></td>
                    <td><input type="checkbox" name="22" value="checked"></td>
                    <td><input type="checkbox" name="23" value="checked"></td>
                </tr>
                <tr>
                    <td>Wednesday</td>
                    <td><input type="checkbox" name="31" value="checked"></td>
                    <td><input type="checkbox" name="32" value="checked"></td>
                    <td><input type="checkbox" name="33" value="checked"></td>
                </tr>
                <tr>
                    <td>Thursday</td>
                    <td><input type="checkbox" name="41" value="checked"></td>
                    <td><input type="checkbox" name="42" value="checked"></td>
                    <td><input type="checkbox" name="43" value="checked"></td>
                </tr>
                <tr>
                    <td>Friday</td>
                    <td><input type="checkbox" name="51" value="checked"></td>
                    <td><input type="checkbox" name="52" value="checked"></td>
                    <td><input type="checkbox" name="53" value="checked"></td>
                </tr>
                <tr>
                    <td>Saturday</td>
                    <td><input type="checkbox" name="61" value="checked"></td>
                    <td><input type="checkbox" name="62" value="checked"></td>
                    <td><input type="checkbox" name="63" value="checked"></td>
                </tr>
                <tr>
                   <td>Sunday</td>
                    <td><input type="checkbox" name="71" value="checked"></td>
                    <td><input type="checkbox" name="72" value="checked"></td>
                    <td><input type="checkbox" name="73" value="checked"></td>
                </tr>
            </table>            
        </div>
        <div>
            <button class="btn btn-primary my-3" type="submit" name="action" value="createEmployee">Create Employee</button>
        </div>
        </form>
<?php }

    // create assignment
    public static function assign($jobs, $shifts){ ?>
        <form class="container" action="" method="POST">
        <div>
            <span>Date</span>
            <input class="form-control" type="date" name="date">
        </div>
        <div>
            <span>Shift</span>
            <select class="form-control" name="shift">
<?php           foreach ($shifts as $shift){
                    echo '<option value="' . $shift->shift_id . '">' . $shift->shift_name . '</option>';
                } ?>
            </select>
        </div>
        <div>
            <span>Job</span>
            <select class="form-control" name="job">
<?php           foreach ($jobs as $job){
                    echo '<option value="' . $job->job_id . '">' . $job->job_title . '</option>';
                } ?>
            </select>
        </div>
        <div>
            <button class="btn btn-primary" type="submit" name="action" value="listEmployees">List available employees</button>
        </div>
        </form>   
<?php }

    // available employees with checkbox for assigning work
    // without delete & edit 
    public static function listAvailableEmployees($employees){ ?>
        
        <form class="container" method="POST">
        <table class="table">
        <tr>
            <td>*</td>
            <td>Name</td>
            <td>Email</td>
            <td>Phone</td>
        </tr>
        <?php
        foreach ($employees as $e){
            echo '<tr>';
            echo '<td><input type="checkbox" name="' . $e->employee_id . '" value="checked"</td>';
            echo '<td>' . $e->fullname . '</td>';
            echo '<td>' . $e->email . '</td>';
            echo '<td>' . $e->phone . '</td>';
            echo '</tr>';
        }
        ?>
        </table> 
        <button class="btn btn-primary" name="action" value="assign">Confirm</button>
        </form>
<?php }

    // all employees group by job
    // with delete & edit
    public static function listEmployees($employees){ ?>
        <table>
            <tr>
                <td>Name</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Edit</td>
                <td>Delete</td>
            </tr>
            <?php
            foreach ($employees as $e){
                echo '<tr>';
                echo '<td>' . $e->name . '</td>';
                echo '<td>' . $e->email . '</td>';
                echo '<td>' . $e->phone . '</td>';
                echo '<td><a href="?action=edit&id=' . $e->employee_id . '">Edit</a></td>';
                echo '<td><a href="?action=delete&id=' . $e->employee_id . '">Delete</a></td>';
                echo '</tr>';
            }
            ?>
        </table>   
<?php }


    // admin sign up
    public static function createAdmin(){ ?>
        <form class="container w-25 text-center" action="" method="POST">
        <div>
            <span>Username</span>
            <input class="form-control" type="text" name="username">
        </div>
        <div>
            <span>Password</span>
            <input class="form-control" type="password" name="password">
        </div>
        <div>
            <span>Confirm password</span>
            <input class="form-control" type="password" name="password2">
        </div>
        <div>
            <span>Full Name</span>
            <input class="form-control" type="text" name="fullname">
        </div>
        <div>
            <span>Email</span>
            <input class="form-control" type="text" name="email">
        </div>
        <div>
            <span>Phone</span>
            <input class="form-control" type="text" name="phone">
        </div>
        <div>
            <span>Company</span>
            <input class="form-control" type="text" name="company">
        </div>
        <div>
            <button class="btn btn-primary my-3" type="submit" name="action" value="createAdmin">Sign Up</button>
        </div>
        </form>
<?php }



    

}