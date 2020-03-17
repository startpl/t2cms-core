<div class="page-list" id="menu-page-list">
    <ul>
    <?php foreach($pages as $page):?>
        <li><a data-id="<?=$page['id'];?>"><?php debug($page);?></a></li>
    <?php endforeach;?>
    </ul>
</div>

