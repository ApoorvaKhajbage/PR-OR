<?php
session_start();

// Function to display the entire grade card of all students
function displayGradeCard($students) {
    if (!empty($students)) {
        echo "<div><h2>Grade Card</h2><table border='1'><tr><th>Name</th><th>Grade</th><th>Attendance</th></tr>";
        foreach ($students as $name => $data) {
            echo "<tr><td>$name</td><td>{$data['grade']}</td><td>{$data['attendance']}%</td></tr>";
        }
        echo "</table></div>";
    } else {
        echo "<div class='message'><p>No student data available.</p></div>";
    }
}

// Function to calculate average grade
function calculateAverage($students) {
    $totalGrades = array_sum(array_column($students, 'grade'));
    $averageGrade = count($students) > 0 ? $totalGrades / count($students) : 0;
    return round($averageGrade, 2);
}

// Function to check defaulter students based on attendance
function checkDefaulterStudents($students, $threshold) {
    return array_filter($students, function($student) use ($threshold) {
        return $student['attendance'] < $threshold;
    });
}

// Function to display details of failed students
function displayFailedStudents($students) {
    $passingThreshold = 60;
    $failedStudents = array_filter($students, function($student) use ($passingThreshold) {
        return $student['grade'] < $passingThreshold;
    });

    if (!empty($failedStudents)) {
        echo "<div><h2>Failed Students</h2><table border='1'><tr><th>Name</th><th>Grade</th></tr>";
        foreach ($failedStudents as $name => $data) {
            echo "<tr><td>$name</td><td>{$data['grade']}</td></tr>";
        }
        echo "</table></div>";
    } else {
        echo "<div class='message'><p>No students failed.</p></div>";
    }
}

// Function to display details of passed students
function displayPassedStudents($students, $passingThreshold) {
    $passedStudents = array_filter($students, function($student) use ($passingThreshold) {
        return $student['grade'] >= $passingThreshold;
    });

    if (!empty($passedStudents)) {
        echo "<div><h2>Passed Students</h2><table border='1'><tr><th>Name</th><th>Grade</th></tr>";
        foreach ($passedStudents as $name => $data) {
            echo "<tr><td>$name</td><td>{$data['grade']}</td></tr>";
        }
        echo "</table></div>";
    } else {
        echo "<div class='message'><p>No students passed.</p></div>";
    }
}

// Function to display the name and grade of the student with the highest grade
function displayHighestGrade($students) {
    $highestGrade = max(array_column($students, 'grade'));
    $highestGradeStudents = array_filter($students, function($student) use ($highestGrade) {
        return $student['grade'] == $highestGrade;
    });

    if (!empty($highestGradeStudents)) {
        echo "<div><h2>Highest Grade</h2><table border='1'><tr><th>Name</th><th>Grade</th></tr>";
        foreach ($highestGradeStudents as $name => $data) {
            echo "<tr><td>$name</td><td>$highestGrade</td></tr>";
        }
        echo "</table></div>";
    } else {
        echo "<div class='message'><p>No student found with the highest grade.</p></div>";
    }
}

// Function to display the name and grade of the student with the lowest grade
function displayLowestGrade($students) {
    $lowestGrade = min(array_column($students, 'grade'));
    $lowestGradeStudents = array_filter($students, function($student) use ($lowestGrade) {
        return $student['grade'] == $lowestGrade;
    });

    if (!empty($lowestGradeStudents)) {
        echo "<div><h2>Lowest Grade</h2><table border='1'><tr><th>Name</th><th>Grade</th></tr>";
        foreach ($lowestGradeStudents as $name => $data) {
            echo "<tr><td>$name</td><td>$lowestGrade</td></tr>";
        }
        echo "</table></div>";
    } else {
        echo "<div class='message'><p>No student found with the lowest grade.</p></div>";
    }
}

// Associative array to store student data
$students = $_SESSION['students'] ?? [];

// Handle add action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "add") {
    if(isset($_POST['name']) && isset($_POST['grade']) && isset($_POST['attendance'])) {
        $name = $_POST["name"];
        $grade = $_POST["grade"];
        $attendance = $_POST["attendance"];
        $students[$name] = ["grade" => $grade, "attendance" => $attendance];
        
        // Update session with the updated student data
        $_SESSION['students'] = $students;
    } else {
        echo "Error: Form data not submitted correctly.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grade Management System</title>
    <style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
    }

    .actions {
        margin-bottom: 20px;
        text-align: center;
    }

    .actions button {
        padding: 10px 20px;
        margin: 5px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .actions button:hover {
        background-color: #45a049;
    }

    .message {
        margin-top: 20px;
    }

    .message p {
        color: #555;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    th, td {
        text-align: left;
    }

    .add-student-form {
        margin-top: 20px;
    }

    .add-student-form label {
        display: block;
        margin-bottom: 5px;
    }

    .add-student-form input[type="text"],
    .add-student-form input[type="number"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .add-student-form button {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .add-student-form button:hover {
        background-color: #45a049;
    }
</style>

</head>
<body>

<div class="container">
    <h1>Student Grade Management System</h1>

    <div class="actions">
        <form method="post">
            <button type="submit" name="action" value="displayAverage">Average Grade</button>
            <button type="submit" name="action" value="displayHighestGrade">Highest Grade</button>
            <button type="submit" name="action" value="displayLowestGrade">Lowest Grade</button>
            <button type="submit" name="action" value="displayPassedStudents">Passed Students</button>
            <button type="submit" name="action" value="displayFailedStudents">Failed Students</button>
            <button type="submit" name="action" value="displayDefaulterStudents">Defaulter Students</button>
            <button type="submit" name="action" value="displayGradeCard">View Grade Card</button>
            <button type="submit" name="action" value="refresh">Refresh</button>
            <button type="submit" name="action" value="addStudent">Add Student Record</button>
        </form>
    </div>

    <!-- Add Student form -->
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "addStudent"): ?>
    <div class="add-student-form">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="grade">Grade:</label>
            <input type="number" id="grade" name="grade" min="0" max="100" required><br>
            <label for="attendance">Attendance:</label>
            <input type="number" id="attendance" name="attendance" min="0" max="100" required><br>
            <button type="submit" name="action" value="add">Add</button>
        </form>
    </div>
    <?php endif; ?>

    <!-- Display area -->
    <?php
    // Display the grade card or perform other actions based on form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
        switch ($_POST["action"]) {
            case "displayGradeCard":
                displayGradeCard($students);
                break;
            case "displayAverage":
                $averageGrade = calculateAverage($students);
                echo "<div class='message'><p><h2>Average Grade:</h2> $averageGrade</p></div>";
                break;
            case "displayHighestGrade":
                displayHighestGrade($students);
                break;
            case "displayLowestGrade":
                displayLowestGrade($students);
                break;
            case "displayPassedStudents":
                displayPassedStudents($students, 60);
                break;
            case "displayFailedStudents":
                displayFailedStudents($students);
                break;
            case "displayDefaulterStudents":
                $defaulterStudents = checkDefaulterStudents($students, 75);
                if (!empty($defaulterStudents)) {
                    echo "<div><h2>Defaulter Students (Attendance Below 75%)</h2><table border='1'><tr><th>Name</th><th>Attendance Percentage</th></tr>";
                    foreach ($defaulterStudents as $name => $student) {
                        echo "<tr><td>$name</td><td>{$student['attendance']}%</td></tr>";
                    }
                    echo "</table></div>";
                } else {
                    echo "<div class='message'><p>No defaulter students found.</p></div>";
                }
                break;
            case "refresh":
                // Do nothing, just refresh the page
                break;
            default:
                break;
        }
    }
    ?>

</div>

</body>
</html>