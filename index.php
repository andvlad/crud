<!DOCTYPE html>
<html lang="ru">
  <head>
  	<meta charset="utf-8"/>
    <meta name='viewport' content='width=device-width,initial-scale=1'/>
    <meta content='true' name='HandheldFriendly'/>
    <meta content='width' name='MobileOptimized'/>
    <meta content='yes' name='apple-mobile-web-app-capable'/>
    <title>LPU</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>

  <body>

	<?php
	  $jFile = '*.json'
	  $hid = array();
	  $id = array();
	  $getfile = file_get_contents($jFile);
	  $jsonfile = json_decode($getfile);
	  $arr = array();
	  foreach ($jsonfile->LPU as $index => $obj) {
		$arr[$index] = array("id" => $obj->id,
						 	 "hid" => $obj->hid,
						 	 "full_name" => $obj->full_name,
						 	 "address" => $obj->address,
						 	 "phone" => $obj->phone);
	  }
	?>
	<table align="center">
      <tr>
          <th id="plus">Развернуть/свернуть все</th>
          <th>Наименование</th>
          <th>Адрес</th>
          <th>Телефон</th>
          <th><a href="#modal1" class="open_modal add">Добавить</a></th>
      </tr>

      <tbody>
        <?php for ($i = 0; $i < count($arr); $i++) {
    		
          if ( $arr[$i]['hid'] === null ) {
        	echo '<tr><td>';
        	if ( $arr[$i]['id'] == $arr[$i+1]['hid'] ) {
        	  echo '<div id="rmenu_' . $arr[$i]['id'] . '">+</div>';
        	}
        	  echo '</td>'; ?>
              <td><?php echo strip_tags($arr[$i]['full_name']); ?></td>
              <td><?php echo strip_tags($arr[$i]['address']); ?></td>
              <td><?php echo strip_tags($arr[$i]['phone']); ?></td>
              <td>
                <a class="edit" href="edit.php?id=<?php echo $i; ?>">Изменить</a>
                <a class="delete" href="delete.php?id=<?php echo $i; ?>">Удалить</a>
              </td>
            </tr>
          <?php } else {
        	echo '<tr id="hid_' . $arr[$i]['hid'] . $i . '">' ?>
              <td>|_</td>
              <td><?php echo strip_tags($arr[$i]['full_name']); ?></td>
              <td><?php echo strip_tags($arr[$i]['address']); ?></td>
              <td><?php echo strip_tags($arr[$i]['phone']); ?></td>
              <td>
                  <a class="edit" href="edit.php?id=<?php echo $i; ?>">Изменить</a>
                  <a class="delete" href="delete.php?id=<?php echo $i; ?>">Удалить</a>
              </td>
            </tr>
          <?php $hid[$i] = $arr[$i]['hid'];
    	  }
    	} 
    	$keys = array_keys($hid);
    	$hid_unique = array_values($hid); ?>

      </tbody>
	</table>

	<script>

	$(document).ready(function() {
	
	  var keys = JSON.parse('<?php echo json_encode($keys); ?>');
	  var hid_unique = JSON.parse('<?php echo json_encode($hid_unique); ?>');
	
	  $('[id^="hid_"]').hide();
	  $('#plus').click(function() {
	      $('[id^="hid_"]').toggle();
	  });
	  for ( var i = 0; i < hid_unique.length; i++ ) {
	    $("#rmenu_" + hid_unique[i]).click(function() {
	      $("#hid_" + hid_unique[i] + keys[i]).toggle();
	      var text = $("#hid_" + hid_unique[i] + keys[i]).text();
	      $("#hid_" + hid_unique[i] + keys[i]).text(text != "+" ? "+" : "-")
	    });
	    /*document.getElementById('rmenu_' + hid_unique[i]).addEventListener("click", () => {
	       document.getElementById('hid_' + hid_unique[i] + keys[i]).style.display = '';
	      });*/
	  }

	  var overlay = $('#overlay'); // пoдлoжкa
      var open_modal = $('.open_modal'); // все ссылки, кoтoрые будут oткрывaть oкнa
      var close = $('.modal_close, #overlay'); // все, чтo зaкрывaет мoдaльнoе oкнo
      var modal = $('.modal_div'); // все скрытые мoдaльные oкнa

      open_modal.click( function(event){
        event.preventDefault(); // отключаем стaндaртнoе пoведение
        var div = $(this).attr('href'); // вoзьмем стрoку с селектoрoм у нажатой ссылки
        overlay.fadeIn(300, //пoкaзывaем oверлэй
          function(){
            $(div) // берем стрoку с селектoрoм и делaем из нее jquery oбъект
              .css('display', 'block') 
              .animate({opacity: 1, top: '50%'}, 150); // плaвнo пoкaзывaем
          });
      });

      close.click( function(){ // лoвим клик пo крестику или oверлэю
        modal // все мoдaльные oкнa
          .animate({opacity: 0, top: '45%'}, 150, // плaвнo прячем
              function(){
                $(this).css('display', 'none');
                overlay.fadeOut(300); // прячем пoдлoжку
              }
          );
      });
	});

	</script>

	<div id="modal1" class="modal_div"> <!-- скрытый блок -->
		<span class="modal_close">X</span>
        <form action="add.php" method="POST">
        	<p>Добавление лечебного учреждения</p>
        	<p>ID</p>
    		<input type="text" name="id"/>
    		<input type="text" name="hid" placeholder="hid" />
    		<p>Наименование</p>
    		<textarea name="full_name"/></textarea>
    		<p>Адрес</p>
    		<textarea name="address"/></textarea>
    		<p>Телефон</p>
    		<input type="text" name="phone"/>
    		<p><button class="add" type="submit" name="add"/>Добавить</button></p>
		</form>
	</div>
	
	<div id="overlay"></div><!-- Пoдлoжкa -->

  </body>
</html>