<?php
$host         = "localhost";
$user         = "root";
$pass         = "";
$database     = "binusian";

$connection   = mysqli_connect($host, $user, $pass, $database);
if (!$connection) { //check connection
    die("Connection Error!");
}
$nim     = "";
$name    = "";
$gender  = "";
$faculty = "";
$major   = "";
$success = "";
$error   = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if($op == 'delete'){
    $id = $_GET['id'];
    $mysql1 = "delete from mahasiswa where id = $id";
    $q1 = mysqli_query($connection,$mysql1);
    if($q1){
        $success = "Delete Data Successfull!";
    }else{
        $error = "Failed To Delete Data!";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $mysql1 = "select * from mahasiswa where id = '$id'";
    $q1 = mysqli_query($connection, $mysql1);
    $r1 = mysqli_fetch_array($q1);
    $nim = $r1['nim'];
    $name = $r1['name'];
    $gender = $r1['gender'];
    $faculty = $r1['faculty'];
    $major = $r1['major'];

    if ($nim == '') {
        $error = "Data Not Found";
    }
}

if (isset($_POST['save'])) {
    $nim     = $_POST['nim'];
    $name    = $_POST['name'];
    $gender  = $_POST['gender'];
    $faculty = $_POST['faculty'];
    $major   = $_POST['major'];

    if ($nim && $name && $gender && $faculty && $major) {
        if ($op == 'edit') {
            $mysql1 = "update mahasiswa set nim = '$nim',name = '$name',gender = '$gender',faculty = '$faculty',major = '$major'";
            $q1 = mysqli_query($connection, $mysql1);
            if ($q1) {
                $success = "Data Updated Successfully!";
            } else {
                $error = "Failed To Update Data!";
            }
        } else {
            $mysql1 = "insert into mahasiswa(nim,name,gender,faculty,major) values('$nim','$name','$gender','$faculty','$major')";
            $q1 = mysqli_query($connection, $mysql1);
            if ($q1) {
                $success = "Insert Data Successfully!";
            } else {
                $error = "Failed To Insert Data!";
            }
        }
    } else {
        $error = "Please Input All Your Data!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data University</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Team Xpendables
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;url=index.php");
                }
                ?>
                <?php
                if ($success) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success ?>
                    </div>
                <?php
                    header("refresh:3;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nim" id="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo $name ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="gender" id="gender">
                                <option value="">~ Choose Your Gender ~</option>
                                <option value="Male" <?php if ($gender == "Male") echo "selected" ?>>Male</option>
                                <option value="Female" <?php if ($gender == "Female") echo "selected" ?>>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="faculty" class="col-sm-2 col-form-label">Faculty</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="faculty" id="faculty" value="<?php echo $faculty ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="major" class="col-sm-2 col-form-label">Major</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="major" id="major" value="<?php echo $major ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="save" value="Save Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Student
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Name</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Faculty</th>
                            <th scope="col">Major</th>
                            <th scope="col">Action</th>
                        </tr>
                    <tbody>
                        <?php
                        $mysql2 = "select * from mahasiswa order by id desc";
                        $q2 = mysqli_query($connection, $mysql2);
                        $serial = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id = $r2['id'];
                            $nim = $r2['nim'];
                            $name = $r2['name'];
                            $gender = $r2['gender'];
                            $faculty = $r2['faculty'];
                            $major = $r2['major'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $serial++ ?></th>
                                <td scope="row"><?php echo $nim ?></td>
                                <td scope="row"><?php echo $name ?></td>
                                <td scope="row"><?php echo $gender ?></td>
                                <td scope="row"><?php echo $faculty ?></td>
                                <td scope="row"><?php echo $major ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php>op=delete&id=<?php echo $id ?>" onclick="return confirm('Are you sure to delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

</html>