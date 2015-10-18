<?php
//////////////////////////
//      YOURDRAFT       //
//   CREATED BY DANGAM  //
//     Project 2012     //
//////////////////////////
//   Файл: Нов Проект   //
include '../core/init.php';
protect_page();
include '../include/overall/header.php';
?>
<div id="infoBox">
    <div id="infoBoxHead">Нов Проект</div>
    <div id="infoBoxBody">
        <p>Имате идея за проект?</p>
        <p>От тук вие можете да създадете проекта на вашата идея?</p>
        <p>Изберете подходящо име, за да бъде лесно намерен и така лесно да намерите партнюори в реализирането му.</p>
        <p>Описанието на един проект е много важна част от него. Представете вашия проект със няколко думи.</p>
        <p>Всички полета за ЗАДЪЛЖИТЕЛНИ.</p>
    </div>
</div>
<div id="cont">
<?php
$output = "";
if (isset($_POST['project_name'], $_POST['project_description'])) {
   $project_name = $_POST['project_name'];
   $project_description = $_POST['project_description'];
   $errors = array();
   if (empty($project_name) || empty($project_description)) {
      $errors[] = 'Името и Описанието за задължителни';
   } else {
    
     if (strlen($project_name) > 150 || strlen($project_description) > 5000) {
        $errors[] = 'Едно или повече полета съдършат прекалено много текст';
     }

   }
   if (!empty($errors)) {
      foreach ($errors as $error) {
        echo $error, '<br />';
      }
   } else {
     create_project($project_name, $project_description);
     $output = "Успешно създадохте Проект";
   }
}
?>
    <?php echo $output; ?>
<form action="" method="post">
      <p>Име:<br /><input type="text" name="project_name" maxlength="55" /></p>
      <p>Описание:<br /><textarea name="project_description" rows="6" cols="35" maxlength="255"></textarea></p>
      <p><input type="submit" value="Създай" /></p>
</form>
</div>
</div>
<?php include '../include/overall/footer.php'; ?> 