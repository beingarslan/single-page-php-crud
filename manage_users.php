<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Manage Users</title>
</head>

<body>

    <div class="container mt-2">
        <?php
        include 'connect.php';
        if (isset($_POST['add_user'])) {
            $name = $_POST['full_name'];
            $email = $_POST['email'];
            // insert data into users table
            $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<div class="alert alert-success">User added successfully</div>';
            } else {
                echo '<div class="alert alert-danger">User could not be added</div>';
            }
        }

        ?>
        <div class="card">
            <div class="card-body">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_user">
                    Add User
                </button>

                <!-- Modal -->
                <div class="modal fade" id="add_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="manage_users.php" method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" required name="full_name" id="full_name" placeholder="Full Name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" required class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="Email">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="add_user" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Model end -->

            </div>
        </div>
    </div>

    <div class="container mt-2">
        <?php
        // Remove user
        if (isset($_POST['delete_user'])) {
            $id = $_POST['id'];
            $sql = "DELETE FROM users WHERE id = $id";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<div class="alert alert-success">User deleted successfully</div>';
            } else {
                echo '<div class="alert alert-danger">User could not be deleted</div>';
            }
        }

        // Edit user
        if (isset($_POST['edit_user'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $sql = "UPDATE users SET name = '$name', email = '$email' WHERE id = $id";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<div class="alert alert-success">User updated successfully</div>';
            } else {
                echo '<div class="alert alert-danger">User could not be updated</div>';
            }
        }



        ?>
        <div class="card">
            <div class="card-body">

                <?php
                // get all users
                $sql = "SELECT * FROM users";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    echo '<table class="table table-striped">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th>Name</th>';
                    echo '<th>Email</th>';
                    echo '<th>Action</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td>';
                        // Edit User
                        echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit_user' . $row['id'] . '">Edit</button>';

                        // Modal
                        echo '<div class="modal fade" id="edit_user' . $row['id'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
                        echo '<div class="modal-dialog">';
                        echo '<form action="manage_users.php" method="post">';
                        echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="exampleModalLabel">Edit User</h5>';
                        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                        echo '</div>';
                        echo '<div class="modal-body">';
                        echo '<div class="mb-3">';
                        echo '<label for="exampleFormControlTextarea1" class="form-label">Full Name</label>';
                        echo '<input type="text" class="form-control" required name="name" id="full_name" placeholder="Full Name" value="' . $row['name'] . '">';
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '</div>';
                        echo '<div class="mb-3">';
                        echo '<label for="exampleFormControlInput1" required class="form-label">Email address</label>';
                        echo '<input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="Email" value="' . $row['email'] . '">';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="modal-footer">';
                        echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
                        echo '<button type="submit" name="edit_user" class="btn btn-primary">Save changes</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                        // End Model

                        // Remove User
                        echo '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#remove_user' . $row['id'] . '">Remove</button>';
                        // Model
                        echo '<div class="modal fade" id="remove_user' . $row['id'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
                        echo '<div class="modal-dialog">';
                        echo '<form action="manage_users.php" method="post">';
                        echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="exampleModalLabel">Remove User</h5>';
                        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                        echo '</div>';
                        echo '<div class="modal-body">';
                        echo '<div class="mb-3">';
                        echo '<label for="exampleFormControlTextarea1" class="form-label">Are you sure you want to remove this user?</label>';
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="modal-footer">';
                        echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
                        echo '<button type="submit" name="delete_user" class="btn btn-danger">Remove</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                        // End Model
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<div class="alert alert-danger">No users found</div>';
                }
                ?>

            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>