<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  </head>
  <body class = "container">
      <?php
      
            include "connection.php";
            
            if(isset($_POST['submit']))
            {
                //write a prepared statement to insert data
                $insert = $connection->prepare("insert into kenworth(scp, class, image, containment, description) values(?,?,?,?,?)");
                $insert->bind_param("sssss", $_POST['scp'], $_POST['class'], $_POST['image'], $_POST['containment'], $_POST['description']);
                
                if($insert->execute())
                {
                    echo"
                        <div class='alert alert-success p-3 m-3'>Record successfully created</div>
                    ";
                }
                else
                {
                    echo"
                    <div class='alert alert-danger p-3'>Error: {$insert->error}</div>
                    ";
                }
            }  
            
            
      
      ?>
    <h1>Create a new SCP</h1>
    <p><a href="index.php" class="btn btn-dark">Back to index page</a></p>
    <div class="p-3 bg-light border shadow">
        <form method="post" action= "create.php" class="form-group">
            <label>Enter SCP ID:</label>
            <br>
            <input type="text" name="scp" placeholder="Scp..." class="form-control" required>
            <br><br>
            <label>Enter SCP Class:</label>
            <br>
            <input type="text" name="class" placeholder="Scp Class..." class="form-control">
            <br><br>
            <label>Enter SCP Image:</label>
            <br>
            <input type="text" name="image" placeholder="images/nameofimg.jpg" class="form-control">
            <br><br>
            <label>Enter SCP Containment:</label>
            <br>
            <textarea name="containment" class="form-control">Enter Containment info</textarea>
            <br><br>
            <label>Enter SCP Description:</label>
            <br>
            <textarea name="description" class="form-control">Enter description</textarea>
            <br><br>
            <input type="submit" name="submit" class="btn btn-primary">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>