<?php

?>

<form class="border rounded p-4 w-50 mx-auto" method="POST" action="./handlers/handle_register.php">
    <h3 class="text-center">Регистрация за наем на автомобил</h3>
    <div class="mb-3">
        <label for="names" class="form-label">Пълно име</label>
        <input type="text" class="form-control" id="names" name="names" value="<?php echo $flash['data']['names'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Имейл</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $flash['data']['email'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label for="phone_number" class="form-label">Телефонен номер</label>
        <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?php echo $flash['data']['phone_number'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Парола</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3">
        <label for="repeat_password" class="form-label">Повтори парола</label>
        <input type="password" class="form-control" id="repeat_password" name="repeat_password">
    </div>
    <button type="submit" class="btn btn-primary mx-auto">Регистрирай се</button>
</form>
