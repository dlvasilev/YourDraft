<?php
/*
 * Project: drafter
 * Author : Daniel Vasilev (DANGAM)
 * All Rights Reserved
 * The DraftBoard
 */
include 'core/init.php';
if(!logged_in()) {
    header("location: home");
}
include 'include/overall/header.php';
?>
<div id="center_content">
    <div id="leftCol">
        <div class="ActionsPanel">
            <div id="DraftBoardProfile">
                <div id="DraftBoardProfile_Img"><img src="<?php echo $url . $user_data['profile']; ?>" alt="avatar"/></div>
                <div id="DraftBoardProfile_Info">
                    <a href="<?php echo $url . 'user/' . $user_data['username']; ?>" class="name"><?php echo $user_data['first_name'], " ", $user_data['last_name']?></a><br />
                    <a href="<?php echo $url . 'user/' . $user_data['username']; ?>">Към профила</a>
                </div>
            </div>
            <div id="DraftBoardDoings">
               <div id="DraftBoardDoings_Friends">
                   <div class="DraftBoardDoings_number">
                        <?php
                                     $ufriend_array = $user_data["friend_array"];
                                     if ($ufriend_array != "") {
                                         $ufriendArray = explode(",", $ufriend_array);
                                         $ufriendCount = count($ufriendArray);
                                         echo $ufriendCount;
                                     }
                         ?>
                    </div>
                    <div class="DraftBoardDoings_link">
                        <a href="<?php echo $url; ?>user/all_friends.php">Приятели</a>
                    </div>
                </div>
                <div id="DraftBoardDoings_Groups">
                   <div class="DraftBoardDoings_number">
                        <?php
                                     $group_array = $user_data["group_array"];
                                     if ($group_array != "") {
                                         $GroupArray = explode(",", $group_array);
                                         $GroupCount = count($GroupArray);
                                         echo $GroupCount;
                                     }
                         ?>
                    </div>
                    <div class="DraftBoardDoings_link">
                        <a href="<?php echo $url; ?>groups/">Групи</a>
                    </div>
                </div>
                <div id="DraftBoardDoings_Projects">
                   <div class="DraftBoardDoings_number">
                        <?php
                                     $project_array = $user_data["project_array"];
                                     if ($project_array != "") {
                                         $projectArray = explode(",", $project_array);
                                         $projectCount = count($projectArray);
                                         echo $projectCount;
                                     }
                         ?>
                    </div>
                    <div class="DraftBoardDoings_link">
                        <a href="<?php echo $url; ?>groups/">Проекти</a>
                    </div>
                </div>
            </div>
            <div id="DraftBoardPost">
                   <form method="post" action="" name="post_form">
                            <input name="post" type="text" class="post" id="post">
                            <textarea name="post_field" id="post_field"></textarea><br />
                            <div id="button_block">
                                <input type="submit"  value=" Сподели "  id="update_button"  class="update_button"/>
                                <input type="submit" name="cancel" id="cancel" value=" Отказ " />
                                <div id='flashmessage'>
                                    <div id="flash"></div>
                                </div>
                            </div>
                   </form>
            </div>
        </div>
        <div class="ActionsPanel">
            <div class="ActionsPanel_title">
                    <a href="<?php echo $url . 'groups/'; ?>">Групи</a>
            </div>
            <div class="ActionsPanel_box">
                <?php
                    $groups         = new Groups();
                    $groupArray     = $groups->getGroupsYouIn($session_user_id);
                    if ($groupArray === false) { ?>
                        <strong>Вие все още не участвате в групи.</strong>
                        <?php } else {
                        include 'core/load_group.php'; 
                    } 
                ?>
            </div>
        </div>
        <div class="ActionsPanel">
            <div class="ActionsPanel_title">
                    <a href="<?php echo $url . 'projects/'; ?>">Проекти</a>
            </div>
            <div class="ActionsPanel_box">
                    <?php
                        $projects         = new Projects();
                        $projectArray     = $projects->getProjectsYouIn($session_user_id);
                        if ($projectArray === false) { ?>
                            <strong>Вие все още нямате проекти.</strong>
                        <?php } else {
                            include 'core/load_project.php'; 
                        }
                    ?>
            </div>
        </div>
    </div>
    <div id="rightCol">
        <?php
                $Wall           = new Ploc();
                $plocsarray     = $Wall->FrPlocs($session_user_id);
                include 'user/load_plocs.php';
        ?>
    </div>
</div>
<?php include 'include/overall/footer.php'; ?>