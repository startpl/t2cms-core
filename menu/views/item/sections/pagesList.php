<div class="page-list menu-list-type" id="menu-page-list">
    <ul>
    <?php foreach($pages as $page):?>
        <li><a data-id="<?=$page['id'];?>" data-type="<?= \t2cms\menu\models\MenuItem::TYPE_BLOG_PAGE?>"><?=$page['pageContent']['name']?></a></li>
    <?php endforeach;?>
    </ul>
</div>
