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
              <?php foreach ($bids as $bid): ?>
                <tr class="history__item">
                  <td class="history__name"><?=$bid['name'];?></td>
                  <td class="history__price"><?=$bid['amount'];?> р</td>
                  <td class="history__time"><?=get_time_bid_created($bid['created_at']);?></td>
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
    </section>
  </main>