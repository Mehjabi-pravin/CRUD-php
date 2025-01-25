<?php
// Database connectivity
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    if (isset($_POST['submit']))
     {
         // Insert new notes
        $var_Title = $_POST['Title'];
        $var_Description = $_POST['Description'];

        $sql = "INSERT INTO notes (Title, Description) VALUES ('$var_Title', '$var_Description')";
        $insertResult = mysqli_query($conn, $sql);

        if ($insertResult) 
        {
            echo '<div class="alert alert-primary" role="alert">Data inserted successfully!</div>';
        } 
        else 
        {
            echo "Data insertion failed: " . mysqli_error($conn);
        }
    } 



    elseif (isset($_POST['update'])) 
    { 
        // Update existing note
        $var_sno = $_POST['sno'];
        $var_title = $_POST['Title'];
        $var_des = $_POST['Description'];

        $sql = "UPDATE notes SET Title='$var_title', Description ='$var_des' WHERE sno='$var_sno'";
        $updateResult = mysqli_query($conn, $sql);

        if ($updateResult)
         {
            echo '<div class="alert alert-success" role="alert">Note updated successfully!</div>';
         } 
        else
         {
            echo "Update failed: " . mysqli_error($conn);
         }
    } 



     // Delete note
    elseif (isset($_POST['delete'])) 

    { 
        $sno = $_POST['sno'];

        $sql = "DELETE FROM notes WHERE sno='$sno'";
        $deleteResult = mysqli_query($conn, $sql);

        if ($deleteResult) {
            echo '<div class="alert alert-danger" role="alert">Note deleted successfully!</div>';
        } else {
            echo "Delete failed: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Project</title>
    <link rel="stylesheet" href="styles.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
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

<div class="container my-4">
    <h2>Add a New Note</h2>
    <form action="inotes.php" method="post">
        <div class="mb-3">
          <label for="Title" class="form-label">Title</label>
          <input type="text" class="form-control" id="Title" name="Title" required>
        </div>
        <div class="mb-3">
          <label for="Description" class="form-label">Note Description</label>
          <input type="text" class="form-control" name="Description" id="Description" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<div class="container mt-5">
    <h2>Notes Table</h2>
    <table class="table" id="notesTable">
        <thead>
            <tr>
                <th scope="col">Sno</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM notes";
            $selectResult = mysqli_query($conn, $sql);
            $no=0;

            while ($row = mysqli_fetch_assoc($selectResult)) {
                echo "<tr>";
                $no+=1;
                echo "<td>" . $no  . "</td>";
                echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
                echo "<td>
                        <button class='btn btn-sm btn-warning edit-btn' data-bs-toggle='modal' data-bs-target='#editModal' data-sno='" . $row['sno'] . "' data-title='" . htmlspecialchars($row['Title']) . "' data-des='" . htmlspecialchars($row['Description']) . "'>Edit</button>
                        <button class='btn btn-sm btn-danger delete-btn' data-bs-toggle='modal' data-bs-target='#deleteModal' data-sno='" . $row['sno'] . "'>Delete</button>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="inotes.php" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="sno" id="edit-sno">

          <div class="mb-3">
            <label for="edit-title" class="form-label">Title</label>
            <input type="text" class="form-control" id="edit-title" name="Title">
          </div>

          <div class="mb-3">
            <label for="edit-des" class="form-label">Description</label>
            <input type="text" class="form-control" id="edit-des" name="Description">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" name="update" class="btn btn-primary">Save changes</button>
        </div>


      </form>
    </div>
  </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="inotes.php" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Delete Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


        <div class="modal-body">
          Are you sure you want to delete this note?

          <input type="hidden" name="sno" id="delete-sno">
        </div>

        <div class="modal-footer">
          <button type="submit" name="delete" class="btn btn-danger">Delete</button>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#notesTable').DataTable();

    $('.edit-btn').click(function() {
        $('#edit-sno').val($(this).data('sno'));
        $('#edit-title').val($(this).data('Title'));
        $('#edit-des').val($(this).data('Description'));
    });

    $('.delete-btn').click(function() {
        $('#delete-sno').val($(this).data('sno'));
    });
});

</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>