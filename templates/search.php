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
    <div class="container">
        <section class="lots">
            <?php if(!get_lots_searched($link, $search, $page_items, $offset)): ?>
    
      <h2>Ничего не найдено по вашему запросу</h2>

    <?php else: ?>
            <h2>Результаты поиска по запросу «<span><?=$search;?></span>»</h2>
            <ul class="lots__list">
                <?php foreach ($lots_searched as $lot): ?>

                  <li class="lots__item lot">
                      <div class="lot__image">
                          <img src="img/<?=$lot["image"];?>" width="350" height="260" alt="">
                      </div>
                      <div class="lot__info">
                          <span class="lot__category"><?=$lot["category_name"];?></span>
                          <h3 class="lot__title">
                            <a class="text-link" href="lot.php?id=<?=$lot['id'];?>">
                              <?=esc($lot["title"]);?>
                            </a>
                          </h3>
                          <div class="lot__state">
                              <div class="lot__rate">
                                  <span class="lot__amount">Стартовая цена: <?=$lot['start_price'];?></span>
                                  <span class="lot__cost"><?= format_sum($lot['current_price']) == 0 ? $lot['start_price'] : format_sum($lot['current_price']) ?></span>
                              </div>
                              <div class="lot__timer timer">
                                  <?=time_left($lot); ?>
                              </div>
                          </div>
                      </div>
                  </li>

                <?php endforeach; ?>
            </ul>
        </section>
        <?=$pagination;?>
        <?php endif; ?>
    </div>
</main>
