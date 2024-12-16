<?php
    
?>

<form class="border rounded p-4 w-50 mx-auto" method="POST" action="./handlers/handle_add_rental.php" enctype="multipart/form-data">
    <h3 class="text-center">Добави кола под наем</h3>
    
    <div class="mb-3">
        <label for="title" class="form-label">Модел:</label>
        <input type="text" class="form-control" id="title" name="title">
    </div>
    
    <div class="mb-3">
        <label for="price" class="form-label">Цена на ден:</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price">
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Изображение на колата:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Описание на колата:</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-success mx-auto">Добави</button>
</form>
