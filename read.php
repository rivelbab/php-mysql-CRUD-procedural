<?php
/**
 * by @rivelbab on kali linux 2017 at Paris
 */
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once 'config.php';

    $sql = "SELECT * FROM user WHERE id = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        $param_id = trim($_GET["id"]);

        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){

                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                $name = $row["name"];
                $address = $row["address"];
                $age = $row["age"];
            } else{

                header("location: error.php");
                exit();
            }

        } else{
            echo "Oops! Une erreur s'est produite, veillez reesayer.";
        }
    }

    mysqli_stmt_close($stmt);
} else{
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Edition</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>utilisateur</h1>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p class="form-control-static"><?php echo $row["address"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>age</label>
                        <p class="form-control-static"><?php echo $row["age"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Retour</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
