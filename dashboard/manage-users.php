<?php
$base = "../";
$page_title = "مدیریت کاربران";


require_once "../configs/config.php";
require_once "../functions/functons.php";

$user= new User();
if($user->get_role(Tokenize::get_token()) ==1){

    $all_users = $user->getAll();

    if(isset($_GET['delete_user'])){
        $user_id = htmlspecialchars($_GET['delete_user']);
        $user->delete($user_id);
        go_back();
    }
    if(isset($_GET['change_role_user'])){
        $user_id = htmlspecialchars($_GET['change_role_user']);
        $user->change_role($user_id);
        go_back();
    }
}else{
    header("Location: ../pages/error404.php");
}
include ("dashboard-template.php");

?>
        <div class="dashboard-content table-content">
            <div class="manage-title">
                <h3>مدیریت کاربران</h3>
                <a href="edit-user.php" class="btn">جدید</a>
            </div>
            <table class="info-table">
                <thead>
                    <tr>
                        <th>شماره</th>
                        <th>شناسه</th>
                        <th>آواتار</th>
                        <th>نام نمایشی</th>
                        <th>ایمیل</th>
                        <th>نام کاربری</th>
                        <th>گذرواژه</th>
                        <th>تاریخ عضویت</th>
                        <th>نقش</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach($all_users as $user){
                        if($user['id']!=1){?>
                    <tr>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $user['id']?></td>
                        <td><img src="<?php echo $base.'media/avatar/'.$user['avatar']?>" alt="user" class="user-avatar"></td>
                        <td><?php echo $user['show_name']?></td>
                        <td><?php echo $user['email']?></td>
                        <td><?php echo $user['username']?></td>
                        <td><?php echo $user['user_password']?></td>
                        <td><?php echo change_date($user['joined_date'])?></td>
                        <td><div><?php echo ($user['user_role']==0)?'کاربر':'ادمین';?></div><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?change_role_user=".$user['id']?>"><i class="fi fi-sr-replace" style="font-size: 20px;"></i></a></td>
                        <td><a href="edit-user.php?user_id=<?php echo $user['id']?>"><i class="fi fi-rr-edit"></i></a></td>
                        <td><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?delete_user=".$user['id']?>"><i class="fi fi-rr-trash"></i></a></td>
                    </tr>
                    <?php }
                    }?>

                </tbody>
            </table>
            
        </div>
    </div>
</main>
<script>
    activeMenuLink("manage-users-link");
</script>