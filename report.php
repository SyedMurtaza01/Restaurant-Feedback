<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit;
}

include('config.php');

$stmt = $pdo->query("SELECT COUNT(*) as total_reviews FROM feedback");
$totalReviews = $stmt->fetch(PDO::FETCH_ASSOC)['total_reviews'];

$stmt = $pdo->query("SELECT COUNT(*) as good_reviews FROM feedback WHERE rating = 'Good'");
$totalGood = $stmt->fetch(PDO::FETCH_ASSOC)['good_reviews'];

$stmt = $pdo->query("SELECT COUNT(*) as okay_reviews FROM feedback WHERE rating = 'Okay'");
$totalOkay = $stmt->fetch(PDO::FETCH_ASSOC)['okay_reviews'];

$stmt = $pdo->query("SELECT COUNT(*) as bad_reviews FROM feedback WHERE rating = 'Bad'");
$totalBad = $stmt->fetch(PDO::FETCH_ASSOC)['bad_reviews'];

$filter_rating = isset($_GET['rating']) ? $_GET['rating'] : 'All';
$filter_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$query = "SELECT id, rating, voice_note, mobile_number, created_at FROM feedback WHERE DATE(created_at) = :date";

if ($filter_rating != 'All') {
    $query .= " AND rating = :rating";
}

$query .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':date', $filter_date);

if ($filter_rating != 'All') {
    $stmt->bindParam(':rating', $filter_rating);
}

$stmt->execute();
$feedbacks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            font-weight: 600;
            color: #007bff;
        }

        .header p {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .card-container {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-around;
            gap: 20px;
            flex-wrap: wrap;
        }

        .feedback-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 250px;
            max-width: 300px;
            transition: transform 0.3s ease;
        }

        .feedback-card:hover {
            transform: scale(1.05);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .feedback-table th {
            text-align: center;
            background-color: #007bff;
            color: #fff;
        }

        .feedback-table td {
            text-align: center;
            vertical-align: middle;
        }

        .feedback-table .no-voice-note {
            color: #6c757d;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .dataTables_filter input {
            width: 250px;
            padding: 10px;
            border-radius: 25px;
            border: 2px solid #007bff;
            font-size: 1rem;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
        }

        .dataTables_filter input:focus {
            border-color: #0056b3;
            box-shadow: 0 0 10px rgba(0, 86, 179, 0.5);
        }

        .dataTable tbody tr {
            margin-bottom: 10px;
        }

        .dataTable td,
        .dataTable th {
            padding: 12px;
        }

        .logout-btn {
            margin-top: 30px;
        }

        .logout-btn .btn {
            width: 200px;
            font-size: 1.1rem;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .logout-btn .btn:hover {
            background-color: #c82333;
            color: #fff;
        }

        .filter-container select {
            font-size: 1.1rem;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .emoji-filter {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .emoji-filter button {
            background-color: #007bff;
            border: none;
            padding: 10px;
            border-radius: 12%;
            font-size: 1.2rem;
            color: white;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .emoji-filter button:hover {
            background-color: #0056b3;
        }


        .filter-container input[type="date"] {
            height: 50px;
        }

        @media (max-width: 768px) {

            .feedback-table th,
            .feedback-table td {
                font-size: 12px;
            }

            .card-container {
                flex-direction: column;
                align-items: center;
            }

            .emoji-filter {
                flex-direction: column;
                gap: 10px;
                justify-content: center;
            }

            .filter-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h2>Manager Feedback Report</h2>
            <p>View all customer feedbacks submitted through the feedback form.</p>
        </div>

        <div class="card-container">
            <div class="feedback-card">
                <div class="card-title">Total Reviews</div>
                <div class="card-icon">📊</div>
                <div class="h3"><?php echo $totalReviews; ?></div>
            </div>

            <div class="feedback-card">
                <div class="card-title">Total Good</div>
                <div class="card-icon">👍</div>
                <div class="h3"><?php echo $totalGood; ?></div>
            </div>

            <div class="feedback-card">
                <div class="card-title">Total Okay</div>
                <div class="card-icon">👌</div>
                <div class="h3"><?php echo $totalOkay; ?></div>
            </div>

            <div class="feedback-card">
                <div class="card-title">Total Bad</div>
                <div class="card-icon">👎</div>
                <div class="h3"><?php echo $totalBad; ?></div>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-3 align-items-center">

            <form action="" method="GET" class="d-flex">
                <input type="date" name="date" value="<?php echo $filter_date; ?>" class="form-control w-auto">
                <button type="submit" class="btn btn-primary ms-2">Filter by Date</button>
            </form>

            <div class="emoji-filter">
                <button class="btn btn-outline-primary" onclick="window.location.href='?date=<?php echo $filter_date; ?>&rating=Good'">👍</button>
                <button class="btn btn-outline-warning" onclick="window.location.href='?date=<?php echo $filter_date; ?>&rating=Okay'">👌</button>
                <button class="btn btn-outline-danger" onclick="window.location.href='?date=<?php echo $filter_date; ?>&rating=Bad'">👎</button>
            </div>
        </div>

        <br>

        <div class="card">
            <div class="table-container">
                <div class="table-responsive">
                    <table id="feedbackTable" class="table table-bordered table-striped table-hover feedback-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Rating</th>
                                <th>Voice Note</th>
                                <th>Mobile Number</th>
                                <th>Submitted On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($feedbacks) > 0): ?>
                                <?php foreach ($feedbacks as $feedback): ?>
                                    <tr>
                                        <td><?php echo ($feedback['id']); ?></td>
                                        <td>
                                            <?php
                                            $ratingClass = '';
                                            if ($feedback['rating'] == 'Good') {
                                                $ratingClass = 'text-success';
                                            } elseif ($feedback['rating'] == 'Okay') {
                                                $ratingClass = 'text-warning';
                                            } else {
                                                $ratingClass = 'text-danger';
                                            }
                                            ?>
                                            <span class="<?php echo $ratingClass; ?>"><?php echo $feedback['rating']; ?></span>
                                        </td>
                                        <td>
                                            <?php if ($feedback['voice_note']): ?>
                                                <audio controls>
                                                    <source src="<?php echo ($feedback['voice_note']); ?>" type="audio/mp3">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            <?php else: ?>
                                                <span class="no-voice-note">No voice note</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo ($feedback['mobile_number']) ?: 'N/A'; ?></td>
                                        <td><?php echo date('Y-m-d H:i:s', strtotime($feedback['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No feedback found for this date and rating.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="logout-btn text-center">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#feedbackTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 100]
            });
        });
    </script>

</body>

</html>