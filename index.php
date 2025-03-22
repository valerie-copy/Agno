<?php
// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'phonebook_semis';
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add contact
if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO contacts (name, phone, address, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $_POST['name'], $_POST['phone'], $_POST['address'], $_POST['email']);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); // Prevent form resubmission
    exit;
}

// Edit contact
if (isset($_POST['edit'])) {
    $stmt = $conn->prepare("UPDATE contacts SET name=?, phone=?, address=?, email=? WHERE id=?");
    $stmt->bind_param("ssssi", $_POST['name'], $_POST['phone'], $_POST['address'], $_POST['email'], $_POST['id']);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); // Prevent form resubmission
    exit;
}

// Delete contact
if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM contacts WHERE id=?");
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); // Prevent form resubmission
    exit;
}

// Search contacts
$search = isset($_POST['search']) ? $_POST['search'] : '';
$sql = "SELECT * FROM contacts WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$search_param = "%$search%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<?php
// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'phonebook_semis';
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add contact
if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO contacts (name, phone, address, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $_POST['name'], $_POST['phone'], $_POST['address'], $_POST['email']);
    $stmt->execute();
    $stmt->close();
}

// Edit contact
if (isset($_POST['edit'])) {
    $stmt = $conn->prepare("UPDATE contacts SET name=?, phone=?, address=?, email=? WHERE id=?");
    $stmt->bind_param("ssssi", $_POST['name'], $_POST['phone'], $_POST['address'], $_POST['email'], $_POST['id']);
    $stmt->execute();
    $stmt->close();
}

// Delete contact
if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM contacts WHERE id=?");
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
    $stmt->close();
}

// Search contacts
$search = isset($_POST['search']) ? $_POST['search'] : '';
$sql = "SELECT * FROM contacts WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$search_param = "%$search%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pink Phonebook</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            margin: 0;
            padding: 20px;
            color: #333;
            text-align: center;
        }

        h2 {
            font-size: 2.5em;
            color: #ff6f61;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h3 {
            font-size: 2em;
            color: #ff6f61;
            margin-top: 30px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Form Styles */
        form {
            margin-bottom: 30px;
        }

        input {
            padding: 12px;
            margin: 8px;
            border: 1px solid rgba(255, 111, 97, 0.3);
            border-radius: 8px;
            width: 200px;
            font-size: 1em;
            background: rgba(255, 255, 255, 0.8);
            color: #333;
            transition: border-color 0.3s ease, background 0.3s ease;
        }

        input::placeholder {
            color: rgba(255, 111, 97, 0.7);
        }

        input:focus {
            border-color: #ff6f61;
            background: rgba(255, 255, 255, 1);
            outline: none;
        }

        button {
            padding: 12px 24px;
            background: linear-gradient(135deg, #ff6f61, #ff4757);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #ff4757, #ff6f61);
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        /* Table Styles */
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            border: 1px solid rgba(255, 111, 97, 0.2);
        }

        th {
            background: #ff6f61;
            color: white;
            font-size: 1.1em;
        }

        tr:nth-child(even) {
            background: rgba(255, 111, 97, 0.1);
        }

        tr:hover {
            background: rgba(255, 111, 97, 0.2);
        }

        /* Action Buttons */
        .actions {
            display: flex;
            justify-content: space-around;
        }

        .actions button {
            padding: 8px 16px;
            margin: 0 5px;
            font-size: 0.9em;
        }

        .actions button.edit {
            background: linear-gradient(135deg, #ff6f61, #ff4757);
        }

        .actions button.edit:hover {
            background: linear-gradient(135deg, #ff4757, #ff6f61);
        }

        .actions button.delete {
            background: linear-gradient(135deg, #ff4757, #ff6b81);
        }

        .actions button.delete:hover {
            background: linear-gradient(135deg, #ff6b81, #ff4757);
        }

        /* Edit Form Styles */
        .edit-form {
            background: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .edit-form input {
            margin: 5px;
            background: rgba(255, 255, 255, 0.8);
            color: #333;
        }

        .edit-form button {
            margin: 5px;
        }

        .edit-form button.cancel {
            background: linear-gradient(135deg, #6c757d, #5a6268);
        }

        .edit-form button.cancel:hover {
            background: linear-gradient(135deg, #5a6268, #6c757d);
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this contact?");
        }
        function toggleEdit(id) {
            let row = document.getElementById("row-" + id);
            let editForm = document.getElementById("edit-form-" + id);
            row.style.display = "none";
            editForm.style.display = "block";
        }
        function cancelEdit(id) {
            let row = document.getElementById("row-" + id);
            let editForm = document.getElementById("edit-form-" + id);
            row.style.display = "table-row";
            editForm.style.display = "none";
        }
    </script>
</head>
<body>
    <h2>Phonebook</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="phone" placeholder="Phone" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit" name="add">Add</button>
    </form>
    
    <form method="post">
        <input type="text" name="search" placeholder="Search by name">
        <button type="submit">Search</button>
    </form>
    
    <h3>Contacts</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($contact = $result->fetch_assoc()) { ?>
            <tr id="row-<?php echo $contact['id']; ?>">
                <td><?php echo htmlspecialchars($contact['name']); ?></td>
                <td><?php echo htmlspecialchars($contact['phone']); ?></td>
                <td><?php echo htmlspecialchars($contact['address']); ?></td>
                <td><?php echo htmlspecialchars($contact['email']); ?></td>
                <td>
                    <button type="button" onclick="toggleEdit('<?php echo $contact['id']; ?>')">Edit</button>
                    <form method="post" style="display:inline;" onsubmit="return confirmDelete();">
                        <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <tr id="edit-form-<?php echo $contact['id']; ?>" style="display: none;">
                <td colspan="5">
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                        <input type="text" name="name" value="<?php echo $contact['name']; ?>">
                        <input type="text" name="phone" value="<?php echo $contact['phone']; ?>">
                        <input type="text" name="address" value="<?php echo $contact['address']; ?>">
                        <input type="email" name="email" value="<?php echo $contact['email']; ?>">
                        <button type="submit" name="edit">Save</button>
                        <button type="button" onclick="cancelEdit('<?php echo $contact['id']; ?>')">Cancel</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>