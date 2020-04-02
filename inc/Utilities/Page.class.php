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
<?php
    }

    public static function footer()
    {?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
    </html>

<?php
    }

    public static function notify(string $msg)
    {
        // alert at the top
        echo '<div class="alert alert-info alert-dismissible text-center">' . $msg .
            '<button class="close" data-dismiss="alert">&times;</button></div>';
    }

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
<?php
    }   

    public static function navBar(){

    }

    public static function login(){ ?>
        <form class="container" action="" method="POST">
        <div>
            <span>User name</span>
            <input class="form-control" type="text" name="username">
        </div>
        <div>
            <span>Password</span>
            <input class="form-control" type="text" name="password">
        </div>
        <div>
            <button class="btn btn-primary" type="submit">Login</button>
        </div>
        <div>
            <p><a class="btn btn-primary" href="signup.php">Sign Up</a></p>
        </div>

        </form>
<?php
    }

    // calendar on admin's homepage
    public static function adminCalendar(){

    }

    public static function employeeCalendar(){

    }

    // the form shown after click some shift in the calendar
    public static function editShift(){

    }

    // the form of creating employee
    public static function createEmployee($jobs){ ?>
        <form class="container" action="" method="POST">
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
            <button class="btn btn-primary" type="submit">Login</button>
        </div>
        </form>
<?php
    }

    // create shift
    public static function createShift(){

    }

    // all employees group by job
    // with delete & edit 
    public static function listEmployees(){

    }

    // admin sign up
    public static function signup(){ ?>
        <form class="container" action="" method="POST">
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
            <span>Company</span>
            <input class="form-control" type="text" name="company">
        </div>
        <div>
            <button class="btn btn-primary" type="submit">Login</button>
        </div>
        </form>
<?php
    }

    

}