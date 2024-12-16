<?php


if (isset($_POST['submit'])) {
    $errors = [];
    foreach ($_POST as $key => $value) {
        if (empty($value) && $key != 'submit') {
            $errors[] = 'Полето ' . $key . ' е задължително';
        }
    }
    if (count($errors) == 0) {
        
        echo '
            <div class="alert alert-success" role="alert">
                Благодарим ви ' . $_POST['name'] . ', че се свързахте с нас относно наем на кола.
                Ще се свържем с вас на ' . $_POST['email'] . ' възможно най-скоро.
            </div>
        ';
    } else {
       
        echo '
            <div class="alert alert-danger" role="alert">
                Възникнаха следните грешки:
                <ul>';

            foreach ($errors as $error) {
                echo '<li>' . $error . '</li>';
            }

        echo '
                </ul>
            </div>
        ';
    }
}
?>
<h1>Свържете се с нас относно наем на кола</h1>
<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Имена</label>
        <input type="text" class="form-control" id="name" placeholder="Вашето име" name="name">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Имейл</label>
        <input type="email" class="form-control" id="email" placeholder="Вашият имейл" name="email">
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Съобщение</label>
        <textarea class="form-control" id="message" rows="4" name="message" placeholder="Оставете въпрос или коментар относно наема на кола"></textarea>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Изпрати</button>
</form>
