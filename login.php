<?php
require './utils/db.php';


if (!empty($_POST)) {
    $in_username = mysqli_real_escape_string($DBC, trim($_POST['login']));
    $in_password = mysqli_real_escape_string($DBC, trim($_POST['pwd']));

    if (empty($in_username) || empty($in_password)) {
        die("Неверный запрос");
    }

    if (!empty($in_username) && !empty($in_password)) {
        $query = "SELECT 'user_id','username' FROM signup WHERE 
            username = '$in_username' AND password = '$in_password'";
        $data = mysqli_query($DBC, $query);

        if ($data and mysqli_num_rows($data) >= 1) {
            $row = mysqli_fetch_assoc($data);
            setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));
            setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));
            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/list.php';
            header('Location: ' . $home_url);
        } else {
            echo '<div class="alert alert-danger" role="alert">Ошибка входа</div>';
        }
    }

    exit(0);
}

$PAGE_TITLE = 'вход в систему';
require './templates/header.php';
?>

<div class="card">
    <div class="card-body">
        <h3>Вход в систему</h3>
        <form method="POST">
            <div class="form-group">
                <label for="inputLogin">Имя пользователя</label>
                <input class="form-control" name='login' id="inputLogin" placeholder="Введите логин">
            </div>
            <div class="form-group">
                <label for="inputPassword">Пароль</label>
                <input type="password" class="form-control" name='pwd' id="inputPassword" placeholder="Пароль">
            </div>
            <button type="submit" name='submit' class="btn btn-primary">Вход</button>
        </form>
    </div>
</div>

<?php require './templates/footer.php' ?>