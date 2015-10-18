<?php
        foreach($projectArray as $data) {
            $projectQuery         = mysql_query("SELECT * FROM projects WHERE id = $data");
            $queryRow             = mysql_fetch_array($projectQuery);
            $projectID            = $queryRow['id'];
            $projectName          = $queryRow['project_name'];
            $projectDiscription   = $queryRow['discription'];
            $projectImage         = $queryRow['image'];
           ?>
                <div class="ActionsPanel_box_Img"><img src="<?php echo $url . $projectImage; ?>" alt="Project Image"/></div>
                <div class="ActionsPanel_box_Info">
                    <a href="<?php echo $url . 'project/open_project.php?id=' . $projectID; ?>" class="name"><?php echo $projectName; ?></a><br />
                    <a href="<?php echo $url . 'project/open_project.php?id=' . $projectID; ?>">Към групата</a>
                </div>
           <?php
        }
?>