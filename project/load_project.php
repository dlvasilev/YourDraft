<?php
        foreach($projectArray as $data) {
            $projectQuery = mysql_query("SELECT * FROM projects WHERE id = $data");
            $queryRow = mysql_fetch_array($projectQuery);
            $projectID            = $queryRow['id'];
            $projectName          = $queryRow['project_name'];
            $projectDiscription   = $queryRow['discription'];
            $projectImage         = $queryRow['image'];
           ?>
        <div class="group_content">
            <div class="group_image">
                <img src="../<?php echo $projectImage; ?>" alt="Group Image" />
            </div>
            <div class="group_name">
                <a href="open_project.php?id=<?php echo $projectID  ?>"><?php echo $projectName; ?></a>
            </div>
                <div class="group_text">
                    <p><?php echo $projectDiscription;?></p>
                </div>
        </div>
           <?php
        }
?>
