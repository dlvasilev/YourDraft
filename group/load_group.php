<?php
        foreach($groupArray as $data) {
            $groupQuery = mysql_query("SELECT * FROM groups WHERE id = $data");
            $queryRow = mysql_fetch_array($groupQuery);
            $groupID            = $queryRow['id'];
            $groupName          = $queryRow['group_name'];
            $groupDiscription   = $queryRow['discription'];
            $groupImage         = $queryRow['image'];
           ?>
        <div class="group_content">
            <div class="group_image">
                <img src="../<?php echo $groupImage; ?>" alt="Group Image" />
            </div>
            <div class="group_name">
                <a href="open_group.php?id=<?php echo $groupID  ?>"><?php echo $groupName; ?></a>
            </div>
                <div class="group_text">
                    <p><?php echo $groupDiscription;?></p>
                </div>
        </div>
           <?php
        }
?>