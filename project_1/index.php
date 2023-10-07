<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'ToDo_db';
$conn = mysqli_connect($server, $username, $password, $database);
if($conn->connect_error) {
  die('connection to mysql Failed: '.$conn->connect_error);
}

//CREATING A TODO ITEM
if(isset($_POST['add'])) {
  $item = $_POST['item'];
  if(!empty($item)) {
    $query = "INSERT INTO todo (name) VALUES ('$item')";
    if(mysqli_query($conn, $query)) {
      echo '<center>
      <div class="alert alert-success" role="alert">Item Added Successfully!
      </div>
      </center>
      ';
    } else {
      echo mysqli_error($conn);
    }
  } 
}

//CHECKING IF ACTION PARAMETER IS PRESENT
if(isset($_GET['action'])) {
  $itemId = $_GET['item'];
  if($_GET['action'] == 'done') {
    $query = "UPDATE todo SET status = 1 WHERE id = '$itemId'";
    if(mysqli_query($conn, $query)) {
      echo '<center>
      <div class="alert alert-info" role="alert">
      Item Marked as Done
      </div>
      </center>
      ';
    } else {
      echo mysqli_error($conn);
    }
  } else if ($_GET['action'] == 'delete') {
    $query = "DELETE FROM todo WHERE id = '$itemId'";
    if(mysqli_query($conn, $query)) {
      echo '<center>
      <div class="alert alert-danger" role="alert">Item has been Deleted</div>
      </center>
      ';
    }
  }
}
?>

<!-- HTML FILE -->
<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel="shortcut icon" type="x-icon" href="icon.png" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="styles.css" />
    <title>To-Do List Application</title>
  </head>
  <body>
    <main>
      <div class="container pt-5">
        <div class="row">
          <div class="col-sm-12 com md-3">
            <div class="col-sm-12 com md-6">
              <div class="card">
                <div class="card-header">
                  <p>To-Do List</p>
                </div>
                <div class="card-body">
                  <form method="post" action="<?= $_SERVER['PHP_SELF']?>">
                    <div class="input-field mb-3">
                      <input
                        type="text"
                        class="form-control"
                        name="item"
                        placeholder="Enter the task here"
                      />
                    </div>
                    <div>
                      <input
                        type="submit"
                        class="btn btn-dark"
                        name="add"
                        value="Add Item"
                      />
                    </div>
                  </form>
                  <div class="mt-5 mb-5"></div>
                  
                  <?php
                  $query = "SELECT * FROM todo";
                  $result = mysqli_query($conn, $query);
                  if($result->num_rows > 0) {
                    $i = 1;
                    while($row = $result->fetch_assoc()) {
                      $done = $row['status'] == 1 ? 'Done' : '';
                    echo ' 
                    <div class="row mt-4"> 
                    <div class="col-sm-12 col-md-1"><h5 style="color: white;">'.$i.'</h5></div>
                    <div class="task col-sm-12 col-md-6"><h5 style="color: white;" class='.$done.'>'.$row['name'].'</h5></div>
                    <div class="col=sm-12 col-md-5">
                      <a href="?action=done&item='.$row['id'].'" class="btn btn-outline-dark">Mark As Done</a>
                      <a href="?action=delete&item='.$row['id'].'" class="btn btn-outline-danger">Delete</a>
                    </div>
                    </div>
                    ';
                    $i++;
                    }
                  } else {
                    echo '
                    <center>
                    <img
                      src="folder.png"
                      width="100px"
                      alt="Empty List"
                    /><br /><span style="color: white;">Your List is Empty</span>
                    </center> 
                    ';
                  }
                  ?>
                    <div class="mt-5"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script>
      $(document).ready(function() {
        $(".alert").fadeTo(1500,500).slideUp(300,function(){
          $('.alert').slideUp(500);
        });
      })
    </script>
  </body>
</html>
