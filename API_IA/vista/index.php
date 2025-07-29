<?php
    require_once('../functions/inc_functions.php');
    $vars = load_code($_GET['strid']);
    if(!is_array($vars)){
        header("Location: error.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $vars['screen_title']; ?></title>
    <style>
        .navbar {
        display: flex;
        align-items: center;
        background: #343a40;
        color: #fff;
        padding: 10px 20px;
        position: relative;
        border-radius: 0px 0px 0 0;
        margin-bottom: 20px;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.2rem;
            flex: 1;
        }
        .navbar-links {
            display: flex;
            gap: 15px;
        }
        .navbar-links a {
            color: #fff;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background 0.2s;
        }
        .navbar-links a:hover {
            background: #495057;
        }
        .navbar-toggle {
            display: none;
        }
        .navbar-icon {
            display: none;
            font-size: 1.8rem;
            cursor: pointer;
        }
        @media (max-width: 600px) {
            .navbar-links {
                display: none;
                flex-direction: column;
                background: #343a40;
                position: absolute;
                top: 48px;
                left: 0;
                width: 100%;
                border-radius: 0 0 8px 8px;
                z-index: 10;
            }
            .navbar-toggle:checked + .navbar-icon + .navbar-links {
                display: flex;
            }
            .navbar-icon {
                display: block;
            }
        }

        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
        }
    </style>
    <?php echo($vars['css']); ?>
</head>
<body>
    <?php if($vars['nav_bar_inc'] == 'Y'){ ?>
    <nav class="navbar">
        <div class="navbar-brand">INSUNET AI</div>
            <input type="checkbox" id="navbar-toggle" class="navbar-toggle">
            <label for="navbar-toggle" class="navbar-icon">&#9776;</label>
            <div class="navbar-links">
                <a href="#">Inicio</a>
                <a href="#">Registrar</a>
                <a href="#">Usuarios</a>
                <a href="#">Salir</a>
            </div>
    </nav>
    <?php } ?>
    <?php echo($vars['screencode']); ?>
    <input type="hidden" id="formid" name="formid" value="<?php echo $_GET['strid']; ?>">
</body>
</html>