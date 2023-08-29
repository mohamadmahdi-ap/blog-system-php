<?php
$base = "../";
$page_title = "مدیریت دسته بندی ها";

require_once "../configs/config.php";
require_once "../functions/functons.php";

$user = new User();
if($user->get_role(Tokenize::get_token()) == 1){
    $category = new Category();
    $all_categories = $category->getAll();

    if(isset($_GET['delete_category'])){
        $category_id = htmlspecialchars($_GET['delete_category']);
        $category->delete($category_id);
        go_back();
    }

}else{
    header("Location: ../pages/error404.php");
}
include ("dashboard-template.php");
?>
        <div class="dashboard-content table-content">
            <div class="manage-title">
                <h3>مدیریت دسته بندی ها</h3>
                <a href="edit-category.php" class="btn">جدید</a>
            </div>
            <table class="info-table">
                <thead>
                    <tr>
                        <th>شماره</th>
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>بنر</th>
                        <th>توضیحات</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach($all_categories as $category){?>
                    <tr>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $category['id']?></td>
                        <td><?php echo $category['title']?></td>
                        <td><img src="<?php echo $base.'media/category/'.$category['banner']?>" alt="category" class="category-banner"></td>
                        <td class="table-ellipsis"><span><?php echo $category['description']?></span></td>
                        <td><a href="edit-category.php?category_id=<?php echo $category['id']?>"><i class="fi fi-rr-edit"></i></a></td>
                        <td><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?delete_category=". $category['id']?>"><i class="fi fi-rr-trash"></i></a></td>
                    </tr>
                    <?php }?>

                </tbody>
            </table>
            
        </div>
    </div>
</main>
<script>
    activeMenuLink("manage-categories-link");
</script>