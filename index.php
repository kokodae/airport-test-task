<?php
require_once 'config.php';

$type = $_GET['type'] ?? 'departure';
$date = $_GET['date'] ?? date('Y-m-d');
if (!in_array($type, ['departure', 'arrival'])) {
    $type = 'departure';
}

$dates = [];
for ($i = -1; $i <= 1; $i++) {
    $dateObj = new DateTime();
    $dateObj->modify("$i day");
    $formattedDate = $dateObj->format('Y-m-d');
    
    switch($i) {
        case -1:
            $label = 'Вчера, ' . $dateObj->format('j F');
            break;
        case 0:
            $label = 'Сегодня, ' . $dateObj->format('j F');
            break;
        case 1:
            $label = 'Завтра, ' . $dateObj->format('j F');
            break;
    }
    
    $dates[] = [
        'value' => $formattedDate,
        'label' => $label,
        'selected' => ($formattedDate == $date)
    ];
}

$stmt = $pdo->prepare("SELECT * FROM flights WHERE flight_type = ? AND flight_date = ? ORDER BY flight_time");
$stmt->execute([$type, $date]);
$flights = $stmt->fetchAll();

$title = ($type == 'departure') ? 'ВЫЛЕТ' : 'ПРИЛЕТ';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Онлайн-табло аэропорта</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Онлайн-табло аэропорта</h1>
        
        <div class="controls">
            <div class="flight-type">
                <a href="?type=departure&date=<?= htmlspecialchars($date) ?>" 
                   class="<?= $type == 'departure' ? 'active' : '' ?> underline">
                   ВЫЛЕТ
                </a>
                <span class="separator">|</span>
                <a href="?type=arrival&date=<?= htmlspecialchars($date) ?>" 
                   class="<?= $type == 'arrival' ? 'active' : '' ?> underline">
                   ПРИЛЕТ
                </a>
            </div>
            
            <div class="date-selector">
                <form method="GET" action="">
                    <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">
                    <select name="date" onchange="this.form.submit()" class="underline">
                        <?php foreach ($dates as $dateOption): ?>
                            <option value="<?= $dateOption['value'] ?>" 
                                <?= $dateOption['selected'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($dateOption['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>
        
        <div class="flights-table-wrapper">
            <table class="flights-table">
                <thead>
                    <tr>
                        <th>Время</th>
                        <th>Аэропорт</th>
                        <th>Авиакомпания</th>
                        <th>Номер рейса</th>
                        <th>Статус рейса</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($flights)): ?>
                        <tr>
                            <td colspan="5" class="no-flights">
                                Нет рейсов за выбранную дату
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($flights as $flight): ?>
                            <tr>
                                <td><?= htmlspecialchars(substr($flight['flight_time'], 0, 5)) ?></td>
                                <td><?= htmlspecialchars($flight['airport']) ?></td>
                                <td><?= htmlspecialchars($flight['airline']) ?></td>
                                <td><?= htmlspecialchars($flight['flight_number']) ?></td>
                                <td><?= htmlspecialchars($flight['status_text']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>