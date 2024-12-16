<?php
require_once('./functions.php');
require_once('./db.php');
    

$cars = [];
$search = '';
$where_search = '';
$params = [];


if (isset($_GET['search']) && mb_strlen($_GET['search']) > 0) {
    $search = $_GET['search'];
    $where_search = 'WHERE title LIKE :search';  
    $params = [':search' => '%' . $search . '%'];
}

$query = "SELECT * FROM cars $where_search";


$stmt = $pdo->prepare($query);
$stmt->execute($params);


while ($row = $stmt->fetch()) {
    $fav_query = "SELECT id FROM `favorite_cars_users` WHERE user_id = :user_id AND car_id = :car_id";
    $fav_stmt = $pdo->prepare($fav_query);
    $fav_stmt->execute([ 
        ':user_id' => $_SESSION['user_id'] ?? 0,
        ':car_id' => $row['id']
    ]);
    $fav_car = $fav_stmt->fetch();
    $row['is_favorite'] = $fav_car ? 1 : 0;
    $cars[] = $row;
}
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <form class="d-flex" method="GET">
                <input type="hidden" name="page" value="cars">
                <input type="text" class="form-control me-2" name="search" placeholder="Търсене на автомобил" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-primary" type="submit">Търсене</button>
            </form>
        </div>
        <div class="col-md-4 text-end">
            <?php
                if (isset($_COOKIE['last_search'])) {
                    echo '<span class="text-muted">Последно търсене: <strong>' . htmlspecialchars($_COOKIE['last_search']) . '</strong></span>';
                }
            ?>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
    <?php
        foreach ($cars as $car) {
           
            $car_image = !empty($car['image']) ? $car['image'] : 'uploads/default_car_image.jpg';

            
            $fav_query = "SELECT id FROM `favorite_cars_users` WHERE user_id = :user_id AND car_id = :car_id";
            $fav_stmt = $pdo->prepare($fav_query);
            $fav_stmt->execute([ 
                ':user_id' => $_SESSION['user_id'] ?? 0,
                ':car_id' => $car['id']
            ]);
            $fav_car = $fav_stmt->fetch();
            $is_favorite = $fav_car ? true : false;

            
            if ($is_favorite) {
                $fav_button = '
                    <button class="btn btn-sm btn-danger remove-favorite w-100" data-car="' . htmlspecialchars($car['id']) . '">
                        Премахни от любими
                    </button>
                ';
            } else {
                $fav_button = '
                    <button class="btn btn-sm btn-primary add-favorite w-100" data-car="' . htmlspecialchars($car['id']) . '">
                        Добави в любими
                    </button>
                ';
            }

            
            echo '
                <div class="col">
                    <div class="card shadow-sm border-0">
                        <img src="' . htmlspecialchars($car_image) . '" class="card-img-top" alt="Car Image">
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($car['title']) . '</h5>
                            <p class="card-text">Цена: ' . htmlspecialchars($car['price_per_day']) . ' лв/ден</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="?page=edit_car&car_id=' . $car['id'] . '" class="btn btn-warning btn-sm">Редактирай</a>
                                <form method="POST" action="./handlers/handle_delete_car.php" class="d-inline">
                                    <input type="hidden" name="car_id" value="' . $car['id'] . '">
                                    <button class="btn btn-danger btn-sm" type="submit">Изтрий</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            ' . $fav_button . '
                        </div>
                    </div>
                </div>
            ';
        }
    ?>
</div>
<script>
    document.querySelectorAll('.add-favorite').forEach(button => {
    button.addEventListener('click', function () {
        const carId = this.getAttribute('data-car');
        
        // Проверка дали потребителят е логнат
        fetch('./ajax/add_favorite.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ car_id: carId })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json(); 
        })
        .then(data => {
            if (data.success) {
                alert('Добавено в любими!');
                location.reload(); 
            } else {
                // Ако потребителят не е логнат, покажи известие
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Нещо се обърка! Грешка: ' + error.message);
        });
    });
});
 
document.querySelectorAll('.add-favorite').forEach(button => {
    button.addEventListener('click', function () {
        const carId = this.getAttribute('data-car');
        
        // Изключи бутона след натискане, за да предотвратиш многократно натискане
        this.disabled = true;

        fetch('./ajax/add_favorite.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ car_id: carId })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json(); 
        })
        .then(data => {
            if (data.success) {
                alert('Добавено в любими!');
                location.reload(); 
            } else {
                alert(`Грешка при добавянето: ${data.error}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Нещо се обърка! Грешка: ' + error.message);
        })
        .finally(() => {
            // Разблокирай бутона след като заявката е завършена
            this.disabled = false;
        });
    });
});

