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
            cursor: pointer;
            position: relative;
        }
        th:hover {
            background-color: #ddd;
        }
        th::after {
            content: '';
            position: absolute;
            right: 8px;
            color: #666;
        }
        th.sort-asc::after {
            content: '▲';
        }
        th.sort-desc::after {
            content: '▼';
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
            echo "<table class='sortable-table' id='table-" . htmlspecialchars($table) . "'><tr>";
            // Print table headers
            $first_row = $result->fetch_assoc();
            $column_index = 0;
            foreach (array_keys($first_row) as $col) {
                echo "<th data-column='" . $column_index . "'>" . htmlspecialchars($col) . "</th>";
                $column_index++;
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all tables
            document.querySelectorAll('.sortable-table th').forEach(headerCell => {
                if (!headerCell.textContent.includes('Action')) {  // Skip the Action column
                    headerCell.addEventListener('click', () => {
                        const table = headerCell.closest('table');
                        const columnIndex = parseInt(headerCell.dataset.column);
                        const currentIsAscending = headerCell.classList.contains('sort-asc');
                        
                        // Remove sort classes from all headers in this table
                        table.querySelectorAll('th').forEach(th => {
                            th.classList.remove('sort-asc', 'sort-desc');
                        });
                        
                        // Add appropriate sort class
                        if (currentIsAscending) {
                            headerCell.classList.add('sort-desc');
                        } else {
                            headerCell.classList.add('sort-asc');
                        }
                        
                        // Sort the table
                        sortTableByColumn(table, columnIndex, !currentIsAscending);
                    });
                }
            });
        });

        function sortTableByColumn(table, columnIndex, ascending = true) {
            const tbody = table.querySelector('tbody') || table;
            const rows = Array.from(tbody.querySelectorAll('tr:not(:first-child)'));
            
            // Sort rows based on cell content in the specified column
            const sortedRows = rows.sort((rowA, rowB) => {
                const cellA = rowA.querySelectorAll('td')[columnIndex].textContent.trim();
                const cellB = rowB.querySelectorAll('td')[columnIndex].textContent.trim();
                
                // Check if the values are numbers
                const numA = parseFloat(cellA);
                const numB = parseFloat(cellB);
                
                if (!isNaN(numA) && !isNaN(numB)) {
                    return ascending ? numA - numB : numB - numA;
                } else {
                    // For text comparison, use localeCompare for proper string comparison
                    return ascending 
                        ? cellA.localeCompare(cellB) 
                        : cellB.localeCompare(cellA);
                }
            });
            
            // Remove existing rows except the header
            rows.forEach(row => tbody.removeChild(row));
            
            // Add sorted rows back to the table
            sortedRows.forEach(row => tbody.appendChild(row));
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>