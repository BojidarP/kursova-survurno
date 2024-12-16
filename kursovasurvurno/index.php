<?php

session_start();
require_once('./functions.php');
require_once('./db.php');
$current_page = isset($_GET['page']) ? $_GET['page'] : '';

$flash = [];
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a car BG</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body>
    
    <script>
       $(function() {
    
    $(document).on('click', '.add-favorite', function() {
        let btn = $(this);
        let carId = btn.data('car');

        $.ajax({
            url: 'ajax/add_favorite.php',
            method: 'POST',
            data: {
                car_id: carId
            },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.success) {
                    alert('Автомобилът беше добавен в любими');
                    let removeBtn = $('<button class="btn btn-sm btn-danger remove-favorite" data-car="' + carId + '">Премахни от любими</button>');
                    btn.replaceWith(removeBtn);
                } else {
                    alert('Възникна грешка: ' + res.error);
                }
            },
            error: function(error) {
                console.error(error);
            }
        });
    });

    
    $(document).on('click', '.remove-favorite', function() {
        let btn = $(this);
        let carId = btn.data('car');

        $.ajax({
            url: 'ajax/remove_favorite.php',
            method: 'POST',
            data: {
                car_id: carId
            },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.success) {
                    alert('Автомобилът беше премахнат от любими');
                    let addBtn = $('<button class="btn btn-sm btn-primary add-favorite" data-car="' + carId + '">Добави в любими</button>');
                    btn.replaceWith(addBtn);
                } else {
                    alert('Възникна грешка: ' + res.error);
                }
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
});

    </script>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary py-3">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold " href="#">Наем на автомобили</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <?php
                                if (isset($_GET['page']) && mb_strlen($_GET['page']) > 0 && $_GET['page'] == 'home') {
                                    echo '<a class="nav-link active" aria-current="page" href="?page=home">Начало</a>';
                                } else {
                                    echo '<a class="nav-link" aria-current="page" href="?page=home">Начало</a>';
                                }
                            ?>
                        </li>
                        <li class="nav-item">
                            <?php
                                $active = ((isset($_GET['page']) && mb_strlen($_GET['page']) > 0 && $_GET['page'] == 'cars') ? 'active' : '');
                                echo '<a class="nav-link ' . $active . '" href="?page=cars">Автомобили</a>';
                            ?>
                        </li>
                        <li class="nav-item">
                            <?php
                                echo '<a class="nav-link ' . ($current_page == 'contacts' ? 'active' : '') . '" href="?page=contacts">Контакти</a>';
                            ?>
                        </li>
                        <li class="nav-item">
                            <?php
                                echo '<a class="nav-link ' . ($current_page == 'add_car' ? 'active' : '') . '" href="?page=add_car">Добави автомобил</a>';
                            ?>
                        </li>
                    </ul>
                    <div class="d-flex flex-row gap-3 align-items-center">
    <?php
       
        if (isset($_SESSION['user_name'])) {
            
            echo '<p class="text-white">Здравейте, ' . $_SESSION['user_name'] . '</p>';
            echo '
                <form action="handlers/handle_logout.php" method="POST">
                    <button type="submit" class="btn btn-outline-light">Изход</button>
                </form>
            ';
        } else {
            
            echo '<a href="?page=login" class="btn btn-outline-light">Вход</a>';
            echo '<a href="?page=register" class="btn btn-outline-light">Регистрация</a>';
        }
    ?>
</div>
                </div>
            </div>
        </nav>
    </header>
    <main class="container py-4" style="min-height:80vh;">
        <?php
            if (isset($flash['message'])) {
                echo '
                    <div class="alert alert-' . $flash['message']['type'] . '">
                        '. $flash['message']['text'] . '
                    </div>
                ';
            }

            $page = $_GET['page'] ?? 'home';
            if (file_exists('./pages/' . $page . '.php')) {
                require_once('./pages/' . $page . '.php');
            } else {
                require_once('./pages/not_found.php');
            }
        ?>
    </main>
   
    <footer class="bg-primary text-center py-5 mt-auto">
    <div class="container">
        <span class="text-light">© 2024 All rights reserved</span>

       
        <div class="mt-3">
            <a href="https://www.facebook.com/uevarna" target="_blank" class="text-light me-3">
                <i class="fab fa-facebook" style="font-size: 1.5rem;"></i>
            </a>
            <a href="https://twitter.com/uevarna" target="_blank" class="text-light me-3">
                <i class="fab fa-twitter" style="font-size: 1.5rem;"></i>
            </a>
            <a href="https://www.instagram.com/uevarna/" target="_blank" class="text-light me-3">
                <i class="fab fa-instagram" style="font-size: 1.5rem;"></i>
            </a>
            <a href="https://www.linkedin.com/school/uevarna" target="_blank" class="text-light">
                <i class="fab fa-linkedin" style="font-size: 1.5rem;"></i>
            </a>
        </div>
    </div>
</footer>
        </body>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</html>
