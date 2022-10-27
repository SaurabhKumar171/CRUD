<?php

// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Buy books.', 'Please buy books only from that particular Store.', current_timestamp());

$insert=false;
$servername="localhost";
$username="root";
$password="";
$database="notes";

$cons=mysqli_connect($servername,$username,$password,$database); 

if(!$cons){
 die("OOPS ! can't be connected".mysqli_connect_error());
}
if($_SERVER['REQUEST_METHOD']=="POST"){
  $title=$_POST['title'];
  $description=$_POST['description'];

  $sql="INSERT INTO `notes` ( `title`, `description`) VALUES ('$title', '$description')";
  $result=mysqli_query($cons,$sql);

  if($result){
    // echo "The record has been inserted successfully!<br>";
    $insert =true;
  }
  else{
    echo "The record has not been inserted successfully because of this error --->".mysqli_error($cons);
  }
}

?>





<!doctype html>
<html lang="en">
   <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
      <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script>
   <script>
      $(document).ready( function () {
            $('#myTable').DataTable();
      } );
    </script>

    <title>iNotes - Notes taking made easy</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>

  <!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit modal
 </button> -->

<!--Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit this Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form action="/CRUD/index.php" method="POST">
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
           </div>

          <div class="form-group">
               <label for="desc">Note Description</label>
               <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
          </div>
             <button type="submit" class="btn btn-primary">Add Note</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
     
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">iNotes</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>

              <li class="nav-item">

                <a class="nav-link" href="#">Contact Us</a>
              </li>


            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>


      <?php
      if($insert){
        echo "<div class='alert alert-success' role='alert'>
        <strong></strong> 
        <h4 class='alert-heading'>Success!</h4>
        <p>Your notes has been inserted successfully</p>
      </div>";
      }
      ?>




      <div class="container my-3">
           <h2>Add a Note </h2>
        <form action="/CRUD/index.php" method="post">
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
              <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>

            <div class="form-group">
              <label for="desc">Note Description</label>
              <div class="form-floating">
                <textarea class="form-control"  id="description" name="description" rows="3"></textarea>
                <!-- <label for="floatingTextarea">Comments</label> -->
                <br>
              </div>
         
            <button type="submit" class="btn btn-primary">Add Note</button>
          </form>
      </div>

      <br>


      <div class="container my-4">

    <table class="table" id="myTable">
       <thead>
         <tr>
           <th scope="col">S.No</th>
           <th scope="col">Title</th>
           <th scope="col">Description</th>
           <th scope="col">Actions</th>
         </tr>
       </thead>

   <tbody>
      <?php
          $sql= "SELECT * FROM `notes`";
          $result = mysqli_query($cons,$sql);
          $sno=0;
          while($row =mysqli_fetch_assoc($result)){
            $sno=$sno+1;
            echo "<tr>
            <th scope='row'>".$sno."</th>
            <td>".$row['title']."</td>
            <td>".$row['description']."</td>
            <td> <button class='edit btn btn-sm btn-primary'>Edit</button> <a href='/del'>Delete</a> </td>
            </tr>";
          }
          ?>
    
  </tbody>
  </table>
  <hr>
      </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script>
      edits=document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click",(e)=>{
        console.log("edit ",);
         tr= e.target.parentNode.parentNode;
        title =tr.getElementsByTagName("td")[0].innerText;
        description=tr.getElementsByTagName("td")[1].innerText;
         console.log(title, description);
         titleEdit.value = title;
         descriptionEdit.value = description;
         //$('#editModal').modal('toggle');
       const myModalAlternative = new bootstrap.Modal('#editModal', 'toggle');
        })
      })
    </script>
  </body>
</html>

