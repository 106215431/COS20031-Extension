<?php

require "includes/auth.php";
require "includes/db.php";
include "includes/header.php";
include "includes/navbar.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm  = $_POST["confirm"];

    if (empty($username) || empty($password) || empty($confirm))
    {
        $message = '<div class="alert alert-danger">
                        Please fill in all fields.
                    </div>';
    }

    elseif ($password != $confirm)
    {
        $message = '<div class="alert alert-danger">
                        Passwords do not match.
                    </div>';
    }

    else
    {
        // Check duplicate username
        $check = $conn->prepare(
            "SELECT Username
             FROM Users
             WHERE Username = ?"
        );

        $check->bind_param("s", $username);
        $check->execute();

        $result = $check->get_result();

        if($result->num_rows > 0)
        {
            $message = '<div class="alert alert-warning">
                            Username already exists.
                        </div>';
        }
        else
        {
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO Users
                (
                    Username,
                    Password
                )
                VALUES
                (
                    ?, ?
                )"
            );

            $stmt->bind_param(
                "ss",
                $username,
                $hashedPassword
            );

            if($stmt->execute())
            {
                $message = '<div class="alert alert-success">
                                Administrator created successfully.
                            </div>';
            }
            else
            {
                $message = '<div class="alert alert-danger">
                                Failed to create administrator.
                            </div>';
            }
        }
    }
}
?>

<div class="container mt-4 mb-5">

    <div class="card shadow-sm dashboard-card">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">
                Create Administrator
            </h4>

        </div>

        <div class="card-body">

            <?= $message ?>

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

    <label class="form-label">

        Password

        <i class="bi bi-info-circle-fill text-primary ms-1"
           tabindex="0"
           role="button"
           data-bs-toggle="popover"
           data-bs-trigger="focus"
           data-bs-placement="right"
           data-bs-html="true"
           data-bs-content="
            <strong>Password Requirements</strong><br><br>
            • Minimum 8 characters<br>
            • At least one uppercase letter<br>
            • At least one lowercase letter<br>
            • At least one number<br>
            • At least one special character">

        </i>

    </label>

   <input
    type="password"
    name="password"
    class="form-control"
    required
    pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}"
    title="Password must be at least 8 characters and contain an uppercase letter, lowercase letter, number, and special character.">

</div>

                <div class="mb-3">

                    <label class="form-label">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="confirm"
                        class="form-control"
                        required>

                </div>

                <button
                    class="btn btn-success">

                    Create Administrator

                </button>

            </form>

        </div>

    </div>

<?php

$result = $conn->query("
SELECT
    Username
FROM Users
ORDER BY Username;
");

?>

    <div class="card shadow-sm dashboard-card mt-4">

        <div class="card-header">

            Existing Administrators

        </div>

        <div class="card-body">

            <table class="table table-striped">

                <thead>

                    <tr>

                        <th>Username</th>

                    </tr>

                </thead>

                <tbody>

                <?php while($row = $result->fetch_assoc()) { ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($row["Username"]) ?>
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include "includes/footer.php"; ?>