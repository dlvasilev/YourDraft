<?php
include '../core/init.php';
protect_page();
include '../include/overall/header.php';
?>
<div id="infoBox">
    <div id="infoBoxHead">Нова група</div>
    <div id="infoBoxBody">
         <p>От тук вие можете да създадете нова група.</p>
         <p>Двете полета са ЗАДЪЛЖИТЕЛНИ.</p>
         <p>Попълнете подходящо име на групата, защото после то не може да бъде променено.</p>
         <p>В описанието на групата, вие може да попълните най-важната информация за нея, така лесно другите потребители ще я намерят и тя ще се разрастне.</p>
    </div>
</div>
<div id="cont">
<?php
$output = "";
if (isset($_POST['group_name'], $_POST['group_description'])) {
   $group_name = $_POST['group_name'];
   $group_description = $_POST['group_description'];

   $errors = array();
   
   if (empty($group_name) || empty($group_description)) {
      $errors[] = 'Името и Описанието за задължителни';
   } else {
    
     if (strlen($group_name) > 55 || strlen($group_description) > 255) {
        $errors[] = 'Едно или повече полета съдършат прекалено много текст';
     }

   }
   
   if (!empty($errors)) {
      foreach ($errors as $error) {
        echo $error, '<br />';
      }
   } else {
     create_group($group_name, $group_description);
     $output = "Успешно създадохте група";
   }

}
?>
<?php echo $output; ?>
<form action="" method="post">
      Име: <input type="text" name="group_name" maxlength="55" /><br />
      Описание:<br /><textarea name="group_description" rows="6" cols="35" maxlength="255"></textarea><br />
      <input type="submit" value="Създай" />
</form>
</div>
<?php include '../include/overall/footer.php'; ?> 