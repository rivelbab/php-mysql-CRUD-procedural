<?php
/**
 * by @rivelbab on kali linux 2017 at Paris
 */
require_once 'config.php';

$name = $address = $age = "";
$name_err = $address_err = $age_err = "";

if(isset($_POST["id"]) && !empty($_POST["id"])){

    $id = $_POST["id"];

    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Entrer un nom valide.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Entrer un nom valide.';
    } else{
        $name = $input_name;
    }

    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = 'Entrer une adresse valide';
    } else{
        $address = $input_address;
    }

    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Entrer votre age";
    } elseif(!ctype_digit($input_age)){
        $age_err = 'Le nombre doit etre positive.';
    } else{
        $age = $input_age;
    }

    if(empty($name_err) && empty($address_err) && empty($age_err)){

        $sql = "UPDATE user SET name=?, address=?, age=? WHERE id=?";

        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_age, $param_id);

            $param_name = $name;
            $param_address = $address;
            $param_age = $age;
            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){

                header("location: index.php");
                exit();
            } else{
                echo "Une erreur s'est produite, veillez reesayer.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

        $id =  trim($_GET["id"]);

        $sql = "SELECT * FROM user WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = $id;

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
    }  else{
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mise a jour</title>
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
                        <h2>Mise a jour utilisateur</h2>
                    </div>

                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nom</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Addresse</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                            <label>age</label>
                            <input type="text" name="age" class="form-control" value="<?php echo $age; ?>">
                            <span class="help-block"><?php echo $age_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Valider">
                        <a href="index.php" class="btn btn-default">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
