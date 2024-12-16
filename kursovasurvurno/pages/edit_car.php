<?php
    $car_id = $_GET['car_id'] ?? 0; 
    if ($car_id <= 0) {
        header('Location: ./index.php?page=cars');
        exit;
    } else {
        
        $query = "SELECT * FROM cars WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $car_id]);

        $car = $stmt->fetch();
    }
?>

<form class="border rounded p-4 w-50 mx-auto" method="POST" action="./handlers/handle_edit_car.php" enctype="multipart/form-data">
    <h3 class="text-center">Редактирай кола под наем</h3>
    <div class="mb-3">
        <label for="model" class="form-label">Модел:</label>
        <input type="text" class="form-control" id="model" name="model" value="<?php echo htmlspecialchars($car['title']); ?>">
    </div>
    <div class="mb-3">
        <label for="daily_price" class="form-label">Дневна цена:</label>
        <input type="number" step="0.01" class="form-control" id="daily_price" name="daily_price" value="<?php echo htmlspecialchars($car['price_per_day']); ?>">
    </div>
    
    <div class="mb-3">
        <label for="image" class="form-label">Изображение:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>
    <div class="mb-3">
        <img class="img-fluid" src="uploads/<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['image']); ?>">
    </div>
    <input type="hidden" name="car_id" value="<?php echo $car_id ?>"> <!-- Hidden input to store car_id -->
    <button type="submit" class="btn btn-success mx-auto">Редактирай</button>
</form>
