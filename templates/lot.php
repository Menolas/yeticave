<main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
          <li class="nav__item">
            <a href="all-lots.html"><?=$category['name'];?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <section class="lot-item container">
      <h2><?=$lot['title'];?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="img/<?=$lot['image'];?>" width="730" height="548" alt="Сноуборд">
          </div>
          <p class="lot-item__category">Категория: <span><?=$lot['category_name'];?></span></p>
          <p class="lot-item__description"><?=$lot['description'];?></p>
        </div>
        <div class="lot-item__right">
          <?php if (isset($_SESSION['user']) && is_time_left($lot['end_date']) && $user['id'] !== $lot['user_id'] && !find_user_bid($link, $user['id'], $lot['id'])): ?>

            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                  <?=time_left($lot); ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount"><?=$lot["start_price"];?></span>
                        <span class="lot-item__cost"><?= format_sum($lot['current_price']) == 0 ? $lot['start_price'] : format_sum($lot['current_price']); ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                      Мин. ставка <span><?= count(db_get_bids($link, $lot['id'])) == 0 ? $lot['start_price'] : $lot['min_bid'];?> р</span>
                    </div>
                </div>
                
                <form class="lot-item__form" action="add-bid.php" method="post">
                  <p class="lot-item__form-item">
                    <label for="cost">Ваша ставка</label>
                    <input id="cost" type="number" name="amount" placeholder="<?= count(db_get_bids($link, $lot['id'])) == 0 ? $lot['start_price'] : $lot['min_bid'];?> р">
                    <input class="visually-hidden" type="text" name="lot_id" value="<?=$lot['id'];?>">
                  </p>
                  <button type="submit" class="button">Сделать ставку</button>
                </form>
                
            </div>
          
          <?php endif; ?>
          <div class="history">
            <h3>История ставок (<span>10</span>)</h3>
            <table class="history__list">
              <tr class="history__item">
                <td class="history__name">Иван</td>
                <td class="history__price">10 999 р</td>
                <td class="history__time">5 минут назад</td>
              </tr>
              <tr class="history__item">
                <td class="history__name">Константин</td>
                <td class="history__price">10 999 р</td>
                <td class="history__time">20 минут назад</td>
              </tr>
              <tr class="history__item">
                <td class="history__name">Евгений</td>
                <td class="history__price">10 999 р</td>
                <td class="history__time">Час назад</td>
              </tr>
              <tr class="history__item">
                <td class="history__name">Игорь</td>
                <td class="history__price">10 999 р</td>
                <td class="history__time">19.03.17 в 08:21</td>
              </tr>
              <tr class="history__item">
                <td class="history__name">Енакентий</td>
                <td class="history__price">10 999 р</td>
                <td class="history__time">19.03.17 в 13:20</td>
              </tr>
              <tr class="history__item">
                <td class="history__name">Семён</td>
                <td class="history__price">10 999 р</td>
                <td class="history__time">19.03.17 в 12:20</td>
              </tr>
              <tr class="history__item">
                <td class="history__name">Илья</td>
                <td class="history__price">10 999 р</td>
                <td class="history__time">19.03.17 в 10:20</td>
              </tr>
              <tr class="history__item">
                <td class="history__name">Енакентий</td>
                <td class="history__price">10 999 р</td>
                <td class="history__time">19.03.17 в 13:20</td>
              </tr>
              <tr class="history__item">
                <td class="history__name">Семён</td>
                <td class="history__price">10 999 р</td>
                <td class="history__time">19.03.17 в 12:20</td>
              </tr>
              <tr class="history__item">
                <td class="history__name">Илья</td>
                <td class="history__price">10 999 р</td>
                <td class="history__time">19.03.17 в 10:20</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </section>
  </main>