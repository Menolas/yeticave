<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= $category['name']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form container <?php if (count($errors) > 0) {
        echo 'form--invalid';
    }; ?>" action="login.php" method="post">
        <h2>Вход</h2>
        <div class="form__item <?php if (isset($errors['email'])) {
        echo 'form__item--invalid';
    }; ?>">
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= isset($values['email']) ? $values['email'] : '' ?>">
            <span class="form__error">Введите e-mail</span>
        </div>
        <div class="form__item form__item--last <?php if (isset($errors['password'])) {
        echo 'form__item--invalid';
    }; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль">
            <span class="form__error">Введите пароль</span>
        </div>
        <?php if (count($errors) > 0): ?>
            <span class="form__error form__error--bottom">Пожалуйста, исправьте следующие ошибки в форме:</span>
            <ul>
    <?php foreach ($errors as $err => $val): ?>
                    <li><strong><?= $err; ?></strong> <?= $val; ?></li>
        <?php endforeach; ?>
            </ul>
<?php endif; ?>
        <button type="submit" class="button">Войти</button>
    </form>
</main>
