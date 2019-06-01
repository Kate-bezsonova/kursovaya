<?php
require './utils/db.php';


if (!empty($_POST)) {
    $in_type = mysqli_real_escape_string($DBC, trim($_POST['type']));
    $in_number = trim($_POST['number']);
    $in_student = mysqli_real_escape_string($DBC, trim($_POST['student']));
    $in_teacher = mysqli_real_escape_string($DBC, trim($_POST['teacher']));
    $in_subject = mysqli_real_escape_string($DBC, trim($_POST['subject']));
    $in_theme = mysqli_real_escape_string($DBC, trim($_POST['theme']));
    $in_score = trim($_POST['score']);
    $in_year = trim($_POST['year']);

    if (
        empty($in_type) || empty($in_number) || empty($in_student) || empty($in_teacher)
        || empty($in_subject) || empty($in_theme) || empty($in_score) || empty($in_year)
    ) {
        die("Неверный запрос");
    }

    if (
        !empty($in_type) && !empty($in_number) && !empty($in_student) && !empty($in_teacher)
        && !empty($in_subject) && !empty($in_theme) && !empty($in_score) && !empty($in_year)
    ) {
        $query = "SELECT 'type', 'number', 'student', 'teacher', 'subject', 'theme', 'score','year', FROM documents WHERE 
            type = '$in_type' AND password = '$in_password'";
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

require './safeFromGet.php';

$sqlInsert = [];

if ($t = safeFromGet('number')) {
    array_push($sqlInsert, 'number = ' . intval($t));
}

if ($t = safeFromGet('type')) {
    array_push($sqlInsert, 'type = \'' . $t . '\'');
}

if ($t = safeFromGet('subject')) {
    array_push($sqlInsert, 'subject ilike \'%' . $t . '%\'');
}

if ($t = safeFromGet('theme')) {
    array_push($sqlInsert, 'theme ilike \'%' . $t . '%\'');
}

if ($t = safeFromGet('student')) {
    array_push($sqlInsert, 'student ilike \'%' . $t . '%\'');
}

if ($t = safeFromGet('teacher')) {
    array_push($sqlInsert, 'teacher ilike \'%' . $t . '%\'');
}

if ($t = safeFromGet('score')) {
    array_push($sqlInsert, 'score ilike \'%' . $t . '%\'');
}

if ($t = safeFromGet('year')) {
    array_push($sqlInsert, 'year = ' . intval($t));
}
$sqlWhereText = implode(' and ', $sqlWhere);
$sqlFullReq = 'select * from documents ' . ($sqlWhereText ? ' where ' : '') . $sqlWhereText;

$data = mysqli_query($DBC, $sqlFullReq);


$PAGE_TITLE = 'ввод данных';
require './templates/header.php';
?>

<div class="card">
    <div class="card-body">
        <h3>Вход в систему</h3>
        <form method="POST">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="inputType">
                <label class="form-check-label" for="exampleCheck1">Вид работы</label>
            </div>
            <div class="form-group">
                <label class="form-check-label" for="inputType"></label>
                <input type="checkbox" class="form-check-input" name='type' id="inputType">
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