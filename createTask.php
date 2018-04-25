<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Create Task</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>

<body>
  
  <div class="container-fluid bg">
    <div class="d-flex p-4">
      <div class="card mx-auto bg-dark text-light">
        <div class="card-body">
          <h4 class="card-title">Make New Task</h4>
          <h5>So What Do You Need To Do?</h5>
          <div class="form-group">
            <form action="./php/createTask_action.php" method="post" required>
              Task Name: <input class="form-control" type="text" name="taskname" maxlength="100" ><br> Priority: <br>
              <input type="radio" name="priority" value="h" checked> RIGHT NOW! <br>
              <input type="radio" name="priority" value="m"> Sometime Soon. <br>
              <input type="radio" name="priority" value="l"> it can wait <br>
              <br>Category: <br>
              <input type="radio" name="category" value="school" checked> School <br>
              <input type="radio" name="category" value="work"> Work <br>
              <input type="radio" name="category" value="family"> Family <br>
              <input type="radio" name="category" value="organization"> Organization <br>
              <input type="radio" name="category" value="miscellaneous"> Miscellaneous <br>
              <br>Progress: <br>
              <input type="radio" name="progress" value="done" checked> D O N E <br>
              <input type="radio" name="progress" value="close"> Literally So Close <br>
              <input type="radio" name="progress" value="half"> Halfway. Glass Half Full? <br>
              <input type="radio" name="progress" value="started"> Could Be Worse <br>
              <input type="radio" name="progress" value="begin"> Lowkey Haven't Started <br>
              <div>
                <!--Only 6 Months in Advance-->
                <br>
                <label for="duedate">Due Date:</label>
                <input class="form-control" id="datetime" type="datetime-local" name="duedate" 
                       min="<?php echo date("Y-m-d h:ia"); ?>" 
                       max="<?php $d = strtotime("+6 months"); echo date("Y-m-d h:ia", $d); ?>" 
                       step="3600" required>
                <span class="validity"></span> <br> <br>
              </div>
              <input class="btn" type="Submit" name="Submit" value="Assign Groups?">
              <input class="btn" type="Submit" name="Submit" value="Create Task without Groups">
            </form> 
            <br><button class="btn btn-outline-success my-2 my-sm-0" id="home_button" type="submit">Go Back Home</button>
            <script>
              var btn = document.getElementById('home_button');
              btn.addEventListener('click', function() {
                var value = Cookies.get('current_user_permissions');
                console.log(value);
                if(value === "ad") document.location.href = '../adminhome.php';
                else document.location.href = '../home.php';
              });
            </script>
          </div>
          <!-- Form Group -->
        </div>
        <!-- Card Body -->
      </div>
      <!-- Card -->
    </div>
    <!-- Flex Box -->
  </div>
  <!-- Container -->

</body>

<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>  
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
</html>