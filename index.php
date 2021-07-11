<?php require_once 'functions.php';
include_once 'views/layouts/header.php';?>
<div class="container">
    <div class="row text-center">
            <h2>Список доступных таблиц</h2>
            <?php foreach (get_tables() as $table):?>
                <div class="col-12 ">
                    <a href="/table.php?table_id=<?php  echo $table['id']?>" class="tables-list"><?php echo $table['title']?></a>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<?php include_once 'views/layouts/footer.php';?>
