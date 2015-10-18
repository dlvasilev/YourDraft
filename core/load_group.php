<?php
        foreach($groupArray as $data) {
            $groupQuery = mysql_query("SELECT * FROM groups WHERE id = $data");
            $queryRow = mysql_fetch_array($groupQuery);
            $groupID            = $queryRow['id'];
            $groupName          = $queryRow['group_name'];
            $groupDiscription   = $queryRow['discription'];
            $groupImage         = $queryRow['image'];
           ?>
                <div class="ActionsPanel_box_Img"><img src="<?php echo $url . $groupImage; ?>" alt="Group Image"/></div>
                <div class="ActionsPanel_box_Info">
                    <a href="<?php echo $url . 'group/open_group.php?id=' . $groupID; ?>" class="name"><?php echo $groupName; ?></a><br />
                    <a href="<?php echo $url . 'group/open_group.php?id=' . $groupID; ?>">Към групата</a>
                </div>
           <?php
        }
?>