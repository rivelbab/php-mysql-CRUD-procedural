<?php
/**
 * by @rivelbab on kali linux 2017 at Paris
 */
// on inclue le fichier de configuration
require_once 'config.php';

// definition et initialisation des variables
$name = $address = $age = "";
$name_err = $address_err = $age_err = "";

// traitement des donnees issues du formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validation du nom
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Tapez-votre nom SVP.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Tapez un nom valide SVP.';
    } else{
        $name = $input_name;
    }

    // Validation de l'adresse
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = 'Tapez votre adresse SVP.';
    } else{
        $address = $input_address;
    }

    // Validation de l'age
    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Tapez votre age SVP.";
    } elseif(!ctype_digit($input_age)){
        $age_err = 'tapez une valeure positive SVP';
    } else{
        $age = $input_age;
    }

    // verification des erreurs de saisie avant l'ajout
    if(empty($name_err) && empty($address_err) && empty($age_err)){
        // preparation de la requette
        $sql = "INSERT INTO user (name, address, age) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_age);

            $param_name = $name;
            $param_address = $address;
            $param_age = $age;

            if(mysqli_stmt_execute($stmt)){
                //ajout avec success, redirection a l'accueil
                header("location: index.php");
                exit();
            } else{
                echo "Erreur, veillez ressayer.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    // on ferme la connexion
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Creation utilisateur</title>
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
                        <h2>Ajout utilisateur</h2>
                    </div>
                    <p>Veillez remplir ce formulaire pour ajouter un user</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="index.php" class="btn btn-default">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
