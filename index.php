

<?php

include '_dbconnect.php';      // throw error if file has but will move further even if the file doesn't exits 
// require '_dbconnect.php';         // throw error if file has but will not move further even if the file doesn't exits

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['snoEdit'])) {

        // variables for the post method 
        $snoEdit = $_POST['snoEdit'];
        $titleEdit = $_POST['titleEdit'];
        $descriptionEdit = $_POST['descEdit'];

        // submit in the database

        $update_sql = "UPDATE `notes` SET `Title` = '$titleEdit',`Description` = '$descriptionEdit' WHERE `notes`.`S_no` = $snoEdit";
        $update_result = mysqli_query($conn, $update_sql);
        if ($update_result) {
            $update = true;
        } else {
            echo "The record was not updated successfully!";
        }
    } else {


        // variables for the post method 

        $insert_title = $_POST['title'];
        $insert_description = $_POST['desc'];

        // submit in the database

        $insert_sql = "INSERT INTO `notes` (`Title`, `Description`) VALUES ('$insert_title', '$insert_description')";
        $insert_result = mysqli_query($conn, $insert_sql);

        if ($insert_result) {
            $insert = true;
        } else {
            echo "The record was not inserted successfully!";
        }
    }
}

if(isset($_GET['delete_id']))
{
    $id = $_GET['delete_id'];

    $delete_sql  = "DELETE FROM `notes` WHERE `notes`.`S_no` = $id";

    $delete_result = mysqli_query($conn, $delete_sql);

    if($delete_result)
    {
        $delete = true;
        header("Location: /php_crud/index.php");
    }
    else{
        die(mysqli_error($conn));
    }


}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iNotes - Notes taking made easy </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

</head>

<body>

    <!-- Navbar -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PHP CRUD</a>
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
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- End-Navbar -->

    <?php

    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been inserted.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been updated.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }

    ?>

    <div class="container my-4">
        <h2>Add a note</h2>
        <form action="/php_crud/index.php" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" id="desc" name="desc" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Add Note</button>
        </form>
    </div>

    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S_no</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $show_sql = "SELECT * FROM `notes`";
                $show_result = mysqli_query($conn, $show_sql);

                while ($row = mysqli_fetch_assoc($show_result)) {

                    $show_id = $row['S_no'];
                    $show_title = $row['Title'];
                    $show_desc = $row['Description'];

                    echo
                            "<tr>
                                <th scope='row'>" . $show_id . "</th>
                                <td>" . $show_title . "</td>
                                <td>" . $show_desc . "</td>
                                <td>
                                    <button class='btn btn-primary edit' id='$show_id'>Edit</button>
                                    <a href='/php_crud/index.php/?delete_id=$show_id' class='btn btn-danger'>Delete</a>
                                </td>
                            </tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <hr>

    <!-- Edit Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/php_crud/index.php" method="post">
                <input type="hidden" name="snoEdit" id="snoEdit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Note</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit">
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Note Description</label>
                            <textarea class="form-control" id="descEdit" name="descEdit" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Note</button>
                    </div>
            </form>
        </div>
    </div>
    </div>


</body>

<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable');
</script>
<script>
    var_edits = document.getElementsByClassName('edit');
    snoEdit = document.getElementById('snoEdit');
    titleEdit = document.getElementById('titleEdit');
    descriptionEdit = document.getElementById('descEdit');

    Array.from(var_edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit wala ", e);
            console.log(e.target.parentNode.parentNode);
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName('td')[0].innerText;
            description = tr.getElementsByTagName('td')[1].innerText;
            console.log(title, description);
            snoEdit.value = e.target.id;
            console.log(e.target.id);
            titleEdit.value = title;
            descriptionEdit.value = description;
            $('#myModal').modal('toggle');
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</html>