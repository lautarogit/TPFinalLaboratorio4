<?php 
     require_once("header.php"); 
     require_once("nav.php");
?>

<div class="dashboard uk-flex"> 
     <div class="box">
          <h2>Agregar tarea</h2>
          <form action="" method="POST">
               <div class="uk-margin">
                    <label for="id">ID</label>
                    <input type="number" name="id" class="uk-input"/>
               </div>

               <div class="uk-margin">
                    <label for="user">Título</label>
                    <input type="text" name="title" class="uk-input"/>
               </div>

               <div class="uk-margin">
                    <label for="">Fecha</label>
                    <input type="date" name="date" class="uk-input"/>
               </div>

               <div class="uk-margin">
                    <label for="">Descripción</label>
                    <textarea name="description" class="uk-textarea"></textarea>
               </div>

               <div class="uk-margin">
                    <label for="">Recordatorio</label>
                    <select class="uk-select" name="reminder">
                         <option>5 min</option>
                         <option>10 min</option>
                         <option>30 min</option>
                         <option>1 hora</option>
                         <option>1 día</option>
                    </select>
               </div>
          <button type="submit" name="send" class="uk-button uk-button-primary">Enviar</button>
     </form>
</div>