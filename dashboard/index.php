<?php
$base = "../";
$page_title = "داشبورد";

include_once ("dashboard-template.php");


?>
        <div class="dashboard-content">

            <div class="dashboard-box">
                <div class="dashboard-info">
                    <img src="../media/avatar/<?php echo $user_info['avatar'];?>" alt="">
                    <div class="user-info">
                        <h3>کاربر : <?php echo $user_info['show_name'];?></h3>
                        <h4>نام کاربری : <?php echo $user_info['username'];?></h4>
                        <h4>ایمیل : <?php echo $user_info['email'];?></h4>
                        <h4>تاریخ عضویت : <?php echo change_date($user_info['joined_date']);?></h4>
                        <h4> نقش : <?php echo ($user_info['user_role']==1)?"ادمین":"کاربر";?></h4>
                    </div>
                </div>
                
            </div>

            <!-- dashboard -->
        </div>
    </div>
</main>
<script>
    activeMenuLink("dashboard-link");
</script>
