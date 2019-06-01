<?php
$PAGE_TITLE = 'список работ';
require './templates/header.php';
require './utils/db.php';
require './safeFromGet.php';

$sqlSelect = 'select * from documents';
$sqlWhere = [];

if ($t = safeFromGet('type')) {
    array_push($sqlWhere, 'type = \'' . $t . '\'');
}

if ($t = safeFromGet('number')) {
    array_push($sqlWhere, 'number = ' . intval($t));
}

if ($t = safeFromGet('student')) {
    array_push($sqlWhere, 'student like \'%' . $t . '%\'');
}

if ($t = safeFromGet('teacher')) {
    array_push($sqlWhere, 'teacher like \'%' . $t . '%\'');
}

if ($t = safeFromGet('course')) {
    array_push($sqlWhere, 'course = ' . intval($t));
}

if ($t = safeFromGet('group')) {
    array_push($sqlWhere, 'group like \'%' . $t . '%\'');
}

if ($t = safeFromGet('intramural')) {
    array_push($sqlWhere, 'intramural like \'%' . $t . '%\'');
}

if ($t = safeFromGet('subject')) {
    array_push($sqlWhere, 'subject like \'%' . $t . '%\'');
}

if ($t = safeFromGet('theme')) {
    array_push($sqlWhere, 'theme like \'%' . $t . '%\'');
}

if ($t = safeFromGet('score')) {
    array_push($sqlWhere, 'score = '. intval($t));
}

if ($t = safeFromGet('year')) {
    array_push($sqlWhere, 'year = ' . intval($t));
}

$sqlWhereText = implode(' and ', $sqlWhere);
$sqlFullReq = 'select * from documents ' . ($sqlWhereText ? ' where ' : '') . $sqlWhereText;
$data = mysqli_query($DBC, $sqlFullReq);
?>
<form class="mb-4" method='GET'>
    <h5>🔎 Поиск по каталогу</h5>
    <div class="input-group">
        <select name='type' class="custom-select">
            <option value='' selected>Без типа</option>
            <option value="к">Курсовая</option>
            <option value="в">ВКБР</option>
            <option value="!">Прочее</option>
        </select>
        <input value='<?= safeFromGet('number') ?>' name='number' type="text" class="form-control" placeholder="Номер" pattern="[0-9]+">
        <input value='<?= safeFromGet('student') ?>' name='student' type="text" class="form-control" placeholder="Студент">
        <input value='<?= safeFromGet('teacher') ?>' name='teacher' type="text" class="form-control" placeholder="Преподаватель">
        <input value='<?= safeFromGet('course') ?>' name='course' type="text" class="form-control" placeholder="Курс" pattern="[0-9]+">
        <input value='<?= safeFromGet('group') ?>' name='group' type="text" class="form-control" placeholder="Группа">
        <input value='<?= safeFromGet('intramural') ?>' name='intramural' type="text" class="form-control" placeholder="ОЗО">
        <input value='<?= safeFromGet('subject') ?>' name='subject' type="text" class="form-control" placeholder="Предмет">
        <input value='<?= safeFromGet('theme') ?>' name='theme' type="text" class="form-control" placeholder="Тема">
        <input value='<?= safeFromGet('score') ?>' name='score' type="text" class="form-control" placeholder="Оценка">
        <input value='<?= safeFromGet('year') ?>' name='year' type="text" class="form-control" placeholder="Год" pattern="[12][0-9]{3}">
        <div class="input-group-append" id="button-addon4">
            <button type="submit" class="btn btn-primary">🔎</button>
        </div>
    </div>
</form>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Номер</th>
            <th scope="col">Студент</th>
            <th scope="col">Преподаватель</th>
            <th scope="col">Группа</th>
            <th scope="col">ОЗО</th>
            <th scope="col">Предмет</th>
            <th scope="col">Тема</th>
            <th scope="col">Оценка</th>
            <th scope="col">Дата</th>
        </tr>
    </thead>
    <?php if (mysqli_num_rows($data) == 0) {
        echo "Нет записей";
    } else {
        echo "<tbody>";
        while ($row = mysqli_fetch_array($data)) { ?>
            <tr>
                <th scope="row"><?= $row['type'] ?>-<?= $row['number'] ?></th>
                <td><?= $row['student'] ?></td>
                <td><?= $row['teacher'] ?></td>
                <td><?= $row['course'] ?> <?= $row['group'] ?></td>
                <td><?= $row['subject'] ?></td>
                <td><?= $row['theme'] ?></td>
                <td><?= $row['score'] ?></td>
                <td><?= $row['date'] ?></td>
            </tr>
        <?php }

    echo "</tbody>";
    } ?>
</table>
<?php require './templates/footer.php' ?>