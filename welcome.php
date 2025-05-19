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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <div class="dashboard">
        <!-- Header -->
        <header class="header">
            <h1><i class="fas fa-database"></i> <span>Database View</span></h1>
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo substr($login_session, 0, 1); ?>
                    </div>
                    <div class="user-name"><?php echo $login_session; ?></div>
                </div>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sign Out</span>
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content">
            <?php foreach ($tables as $table): ?>
                <div class="table-card">
                    <div class="table-card-header">
                        <h2 class="table-card-title">
                            <i class="fas fa-table"></i> 
                            <?php echo htmlspecialchars($table); ?>
                        </h2>
                    </div>
                    <div class="table-card-content">
                        <?php
                        $result = $conn->query("SELECT * FROM `$table`");
                        if ($result && $result->num_rows > 0):
                            echo "<table class='data-table sortable-table' id='table-" . htmlspecialchars($table) . "'><thead><tr>";
                            
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
                            
                            echo "</tr></thead><tbody>";
                            
                            // Rewind and display all rows
                            $result->data_seek(0);
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                foreach ($row as $key => $val) {
                                    // Special handling for status field
                                    if (strtolower($key) === 'status') {
                                        $status_class = strtolower($val) === 'done' ? 'status-done' : 'status-pending';
                                        echo "<td><span class='status-badge " . $status_class . "'>" . htmlspecialchars($val) . "</span></td>";
                                    } else {
                                        echo "<td>" . htmlspecialchars($val) . "</td>";
                                    }
                                }
                                
                                // Action column for makeup_slips
                                if ($table === 'makeup_slips') {
                                    echo "<td>";
                                    if (strtolower($row['status']) == 'pending') {
                                        echo '<form method="POST">
                                                <input type="hidden" name="update_id" value="' . intval($row['id']) . '">
                                                <button type="submit" class="action-btn">
                                                    <i class="fas fa-check"></i> Mark as Done
                                                </button>
                                              </form>';
                                    } else {
                                        echo '<span class="status-badge status-done"><i class="fas fa-check-circle"></i> Completed</span>';
                                    }
                                    echo "</td>";
                                }
                                
                                echo "</tr>";
                            }
                            
                            echo "</tbody></table>";
                        else:
                            echo "<div class='empty-state'>
                                    <i class='fas fa-database'></i>
                                    <p>No records found in $table.</p>
                                  </div>";
                        endif;
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </main>
    </div>

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
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            // Sort rows based on cell content in the specified column
            const sortedRows = rows.sort((rowA, rowB) => {
                let cellA = rowA.querySelectorAll('td')[columnIndex].textContent.trim();
                let cellB = rowB.querySelectorAll('td')[columnIndex].textContent.trim();
                
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
            
            // Remove existing rows
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }
            
            // Add sorted rows back to the table
            sortedRows.forEach(row => tbody.appendChild(row));
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>