<section class="page__main page__main--popular">
    <div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link <?=($query_params['sort_value'] === 'views' || !isset($query_params['sort_value'])) ? 'sorting__link--active' : ""; ?> " href="#">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link <?=($query_params['sort_value'] === 'likes') ? 'sorting__link--active' : ""; ?>" href="#">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link <?=($query_params['sort_value'] === 'post-date') ? 'sorting__link--active' : ""; ?>" href="#">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all <?=($query_params['content_type_id'] === "all" || empty($query_params['content_type_id']))? 'filters__button--active"' : '"' ?>  href="<?= create_url('all',$query_params['sort_value'],$query_params['sort_order']) ?>">
                            <span>Все</span>
                        </a>
                    </li>
                    <!-- Выводим список типов контента в зависимости от типа постов  на странице-->
                    <?php $unique_post_type_list = $content_types;?> <!--список уникальных типов постов на странице -->
                    <?php foreach ($unique_post_type_list as $unique_post): ?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--<?= $unique_post['icon_name'] ?> <?=($query_params['content_type_id'] === $unique_post['id']) ? 'filters__button--active"' : '"' ?>" href="index.php?content_type_id=<?=$unique_post['id'] ?>">
                            <span class="visually-hidden">Фото</span>
                            <svg class="filters__icon" width="<?=$unique_post['width']?>" height="<?=$unique_post['height']?>">
                                <use xlink:href="#icon-filter-<?= $unique_post['icon_name'] ?>"></use>
                            </svg>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="popular__posts">
            <?php foreach ($posts_list as $key => $post): ?>
                <?php $post_date = generate_random_date($key); ?> <!--переменная с датой публикации -->
                <article class="popular__post post <?=$post["content_icon_name"]?>">
                    <header class="post__header">
                        <h2><a href="post.php?post_id=<?= $post["post_id"]?>"><?= $post["header"] ?></a></h2>
                    </header>
                    <div class="post__main">
                        <!--здесь содержимое карточки-->
                        <?php switch ($post["content_icon_name"]):
                            case 'post-quote': ?>
                                <!--содержимое для поста-цитаты-->
                                <blockquote>
                                    <p>
                                        <!--здесь текст-->
                                        <?=htmlspecialchars(htmlspecialchars($post["content"],ENT_QUOTES))?>
                                    </p>
                                    <cite>Неизвестный</cite>
                                </blockquote>
                                <?php break;?>
                            <?php case 'post-text': ?>
                                <!--содержимое для поста-текста-->
                                <?php if(strlen(htmlspecialchars($post["content"],ENT_QUOTES))<$text_max_symbols_number): ?>
                                    <p><?=htmlspecialchars($post["content"],ENT_QUOTES)?></p>
                                <?php else: ?>
                                    <p><?php echo(trim_text(htmlspecialchars($post["content"],ENT_QUOTES),$text_max_symbols_number))?></p>
                                    <a class="post-text__more-link" href="#">Читать далее</a>
                                <?php endif; ?>
                                <?php break;?>
                            <?php case 'post-picture': ?>
                                <!--содержимое для поста-фото-->
                                <div class="post-photo__image-wrapper">
                                    <img src="img/<?=htmlspecialchars($post["image"],ENT_QUOTES)?>" alt="Фото от пользователя" width="360" height="240">
                                </div>
                                <?php break;?>
                            <?php case 'post-link': ?>
                                <!--содержимое для поста-ссылки-->
                                <div class="post-link__wrapper">
                                    <a class="post-link__external" href="http://" title="Перейти по ссылке">
                                        <div class="post-link__info-wrapper">
                                            <div class="post-link__icon-wrapper">
                                                <img src="https://www.google.com/s2/favicons?domain=vitadental.ru" alt="Иконка">
                                            </div>
                                            <div class="post-link__info">
                                                <h3><?=$post["link"]?></h3>
                                            </div>
                                        </div>
                                        <span><?=htmlspecialchars($post["content"],ENT_QUOTES)?></span>
                                    </a>
                                </div>
                                <?php break;?>
                            <?php endswitch; ?>
                    </div>
                    <footer class="post__footer">
                        <div class="post__author">
                            <a class="post__author-link" href="#" title="<?= $post_date ?>"> <!-- генерируем случайную дату по индексу массива постов-->
                                <div class="post__avatar-wrapper">
                                    <!--укажите путь к файлу аватара-->
                                    <img class="post__author-avatar" src="img/<?=htmlspecialchars($post["avatar"],ENT_QUOTES)?>" alt="Аватар пользователя">
                                </div>
                                <div class="post__info">
                                    <b class="post__author-name"><?=htmlspecialchars($post["login"],ENT_QUOTES)?></b>
                                    <time class="post__time" datetime="<?= date("d.m.Y H:i",strtotime($post_date)) ?>"><?=time_delta($post_date)?></time>
                                </div>
                            </a>
                        </div>
                        <div class="post__indicators">
                            <div class="post__buttons">
                                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                    <svg class="post__indicator-icon" width="20" height="17">
                                        <use xlink:href="#icon-heart"></use>
                                    </svg>
                                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                        <use xlink:href="#icon-heart-active"></use>
                                    </svg>
                                    <span><?=$post["likes_count"] ?></span>
                                    <span class="visually-hidden">количество лайков</span>
                                </a>
                                <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <span><?=$post["comments_count"] ?></span>
                                    <span class="visually-hidden">количество комментариев</span>
                                </a>
                            </div>
                        </div>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
