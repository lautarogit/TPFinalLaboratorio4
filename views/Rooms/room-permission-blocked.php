<h4 class="text-white">No tiene los permisos necesarios para ingresar a esta página</h4>
<a class="btn btn-info m-1" style="display: inline; border-radius: 2px 10px 10px 2px;" role="button" href="
<?php 
    if($rolId == 0)
    {
        echo FRONT_ROOT."Room/showClientRoomDashboard";
    }

    if($rolId == 1)
    {
        echo FRONT_ROOT."Room/showRoomDashboard";
    }
?>">Volver</a>