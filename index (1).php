<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <style>
      img {
        max-width: 100%; /* Ensure images fit within the container */
        height: auto; /* Maintain aspect ratio */
      }
    </style>
  </head>
  <body class="container">
        <?php include "connection.php"; ?>
        <div>
            <ul class="nav navbar-dark bg-dark">
                
                <?php foreach($result as $link): ?>
                    <li class="nav-item active">
                        <a href="index.php?link=<?php echo $link['scp']; ?>" class ="nav-link text-light"><?php echo $link['scp']; ?></a>
                    </li>
                <?php endforeach; ?>
                
                <li class="nav-item active">
                    <a href="create.php" class ="nav-link text-light">Create a new SCP Record.</a>
                </li>
            </ul>
        </div>
    <h1>SCP CRUD Application</h1>
    <div>
        <?php
        
            if(isset($_GET['link']))
            {
                $scp = $_GET['link'];
                
                //prepared statement
                $stmt = $connection->prepare("select * from kenworth where scp =?");
                if(!$stmt)
                {
                    echo "<p>Error in preparing SQL statement</p>";
                    exit;
                }
                $stmt->bind_param("s", $scp);
                
                if($stmt->execute())
                {
                    $result = $stmt->get_result();
                    
                    // check if a record has been retrieved
                    if($result->num_rows > 0)
                    {
                        $array = array_map('htmlspecialchars', $result->fetch_assoc());
                        $update = "update.php?update=" .$array['id'];
                        $delete = "index.php?delete=" .$array['id'];
                        
                        echo "
                            <div class='card card-body shadow mb-3'>
                            <h2 class='card-title'>{$array['scp']}</h2>
                            <h4>{$array['containment']}</h4>
                            <p><img src ='{$array['image']}' alt='{$array['scp']}'></p>
                            <p>{$array['description']}</p>
                            <p>
                                <a href='{$update}' class='btn btn-warning'>Update Record</a>
                                <a href='{$delete}' class='btn btn-warning'>Delete Record</a>
                            </p>
                            <p>
                                <a href='index.php' class='btn btn-secondary'>Back to Index</a>
                            </p>
                            </div>
                        
                        ";
                    }
                    else
                    {
                        echo "<p>No record found for scp {$array['scp']}</p>";
                    }
                }
                else
                {
                    echo"<p>Error executing the statement</p>";
                }
                
            }
            else
            {
                echo "
                    <p>Welcome to the SCP Database</p>
                    <p><img src='images/scplogo.jpg' alt='SCP application' class='img-fluid'></p>
                ";
            }
            
            //delete record
            if(isset($_GET['delete']))
            {
                $delID = $_GET['delete'];
                $delete = $connection->prepare("delete from kenworth where id=?");
                $delete->bind_param("i", $delID);
                
                if($delete->execute())
                {
                    echo "<div class='alert alert-warning'>Record Deleted...</div>";
                }
                else
                {
                    echo "<div class='alert alert-danger'>Error deleting record {$delete->error}.</div>";
                }
            }
        
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>