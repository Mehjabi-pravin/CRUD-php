<?php     
$insert = false;
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assign values only if 'Title' and 'Description' exist in $_POST
    if (isset($_POST['Title']) && isset($_POST['Description'])) {
        $var_Title = $_POST['Title'];
        $var_Description = $_POST['Description'];

        // SQL query for insertion
        $sql = "INSERT INTO notes (Title, Description) VALUES ('$var_Title', '$var_Description')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $insert = true; // for alert
        } else {
            echo "Failed: " . mysqli_error($conn);
        }
    }
}



?>

<!Doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <title>iNotes - Notes Taking Made Easy</title>
    <script>

    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">iNotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
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
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php
    //alert for insertion 
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Your note has been successfully inserted.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }

   
    ?>


    <!-- for insertion -->
    <div class="container my-4">
        <h2>Add a Note</h2>
        <!-- Form -->
        <form action="/CRUD/inotes.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="Title" name="Title">
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" id="Description" name="Description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Table -->
    <div class="container">
        <table class="table table-striped table-hover" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>

                </tr>
            </thead>
            <tbody>

















                <!-- edit modal -->
                
                <!-- Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editModalLabel">Edit this note</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form -->
                                <form action="/CRUD/inotes.php" method="POST">
                                    <input type ="hidden" name = "snoEdit" id = "snoEdit">
                                    
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Note Title</label>
                                        <input type="text" class="form-control" id="TitleEdit" name="TitleEdit">
                                    </div>
                                    <div class="mb-3">
                                        <label for="desc" class="form-label">Note Description</label>
                                        <textarea class="form-control" id="DescriptionEdit" name="DescriptionEdit"></textarea>
                                    </div>
                                    <button type="submit" name="vicky" class="btn btn-primary">Update Note</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>





















                <?php
            $sql = "SELECT * FROM `notes`";
            $result = mysqli_query($conn, $sql);

            // Fetching and displaying notes
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <th scope='row'>" . $row['sno'] . "</th>
                        <td>" . $row['Title'] . "</td>
                        <td>" . $row['Description'] . "</td>
                        <td><button type='button' class='btn btn-primary' id= ".$row['sno']."  data-bs-toggle='modal' data-bs-target='#editModal'>
                                Edit</button>
                        </td>
                      </tr>";
            }
            
            ?>
            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-HwB7FRA3GztlBg7OSxZBYWoX1jxsV3JN8W6gWT6VRQQ=" crossorigin="anonymous"></script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>

    <script>
    edits = document.getElementsByClassName('Edit'); // Fix: Correct the class name capitalization
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            // Get the row data
            tr = e.target.parentNode.parentNode;
            Title = tr.getElementsByTagName("td")[1].innerText; // Title column
            Description = tr.getElementsByTagName("td")[2].innerText; // Description column

            // Populate modal fields
            document.getElementById("TitleEdit").value = Title;
            document.getElementById("DescriptionEdit").value = Description;
            document.getElementById("snoEdit").value = e.target.id; // Set the ID (sno)

            // Toggle modal
            $('#editModal').modal('toggle');
        });
    });
    </script>
</body>

</html>