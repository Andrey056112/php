    <?php
    include 'includes/header.php';

    $errors = [];

    if (isset($_POST['submit'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $passwordRepeat = $_POST['password_repeat'];

    
        if (!$name || mb_strlen($name) > 100) {
            $errors['name'] = "неверное имя!";
        }
    
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Неверная почта!";
        }
    
        $emailExists = $db->prepare('SELECT * FROM users WHERE email=?');
        $emailExists->execute([$email]);
    
        if ($emailExists->fetch()) {
            $errors['email'] = 'Почта уже используется!';
        }
    
        if (!$password) {
            $errors['password'] = 'Пароль не введён!';
        }
    
        if ($password !== $passwordRepeat) {
            $errors['password_repeat'] = 'Неверное подтверждение пароля!';
        }
    
        if (count($errors) == 0) {
            $insertQuery = $db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
            $insertQuery->execute([
                'name' => $name,
                'email' => $email,
                'password' => md5($password),
            ]);
    
            // redirect('index.php');
        }
    
    }
    ?>

<div class="container">
    <h1 class="registration-title">Registration</h1>
    <form class="registration" action="registration.php" method="post" novalidate>
        <label>
            Имя: <br>
            <input type="text" name="name" value="<?= $name ?? '' ?>">
        </label>
        <label>
            <?= $errors['name'] ?? '' ?>
        </label>
        <label>
            Почта: <br>
            <input type="email" name="email" value="<?= $email ?? '' ?>">
        </label>
        <label>
            <?= $errors['email'] ?? '' ?>
        </label>
        <label>
            Пароль: <br>
            <input type="password" name="password">
        </label>
        <label>
            <?= $errors['password'] ?? '' ?>
        </label>
        <label>
            Подтверждение пароля: <br>
            <input type="password" name="password_repeat">
        </label>
        <label>
            <?= $errors['password_repeat'] ?? '' ?>
        </label>
        <input type="submit" name="submit" value="Зарегестрироваться">
    </form>
</div>