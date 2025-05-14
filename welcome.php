<?php
include('session.php');

// DB connection setup
$servername = "localhost";
$username = "root";
$password = "onelasalle"; // Set your password if needed
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle makeup_slips status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $conn->query("UPDATE makeup_slips SET status = 'Done' WHERE id = $id");
}

// Fetch all table names
$tables = [];
$table_result = $conn->query("SHOW TABLES");
while ($row = $table_result->fetch_array()) {
    $tables[] = $row[0];
}
?>
<html>
<head>
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
        }
        h1, h2 {
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 40px;
            background-color: white;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #eee;
        }
        .done {
            color: green;
            font-weight: bold;
        }
        .pending {
            color: orange;
            font-weight: bold;
        }
        form {
            display: inline;
        }
        a {
            text-decoration: none;
            color: #d00;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo $login_session; ?></h1>
    <h2><a href="logout.php">Sign Out</a></h2>

    <?php foreach ($tables as $table): ?>
        <h2>Table: <?php echo htmlspecialchars($table); ?></h2>

        <?php
        $result = $conn->query("SELECT * FROM `$table`");
        if ($result && $result->num_rows > 0):
            echo "<table><tr>";
            // Print table headers
            $first_row = $result->fetch_assoc();
            foreach (array_keys($first_row) as $col) {
                echo "<th>$col</th>";
            }
            // Add Action column for makeup_slips
            if ($table === 'makeup_slips') {
                echo "<th>Action</th>";
            }
            echo "</tr>";

            // Rewind and display all rows
            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $key => $val) {
                    echo "<td>" . htmlspecialchars($val) . "</td>";
                }

                // Action column for makeup_slips
                if ($table === 'makeup_slips') {
                    echo "<td>";
                    if (strtolower($row['status']) == 'pending') {
                        echo '<form method="POST">
                                <input type="hidden" name="update_id" value="' . intval($row['id']) . '">
                                <button type="submit">Mark as Done</button>
                              </form>';
                    } else {
                        echo '<span class="done">Done</span>';
                    }
                    echo "</td>";
                }

                echo "</tr>";
            }

            echo "</table>";
        else:
            echo "<p>No records found in $table.</p>";
        endif;
        ?>
    <?php endforeach; ?>

</body>
</html>

<?php $conn->close(); ?>
