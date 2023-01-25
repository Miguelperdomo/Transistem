<?php 
    session_start();
    include("../../../../../includes/validarsession.php");

    require_once("../../../../../connections/connection.php");
     
    $action = $_REQUEST['action'];

    $stmt=$base->prepare('SELECT id_ciudad, ciudad FROM ciudad WHERE id_depart=:cid ORDER BY ciudad');
    $stmt->execute(array(':cid'=>$action));

	?>
<div class="form-group">
    <div class="input-group col">
        <div class="input-group-prepend">
            <div class="input-group-text">Ciudad</div>
        </div>
        <select class="custom-select" name="ci" id="display">
            <option value="">Seleccionar: </option>
    <?php    
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
        
            ?>                
            <option value="<?php echo $row['id_ciudad']; ?>"><?php echo $row['ciudad']; ?></option>
            <?php  
        }
    ?>
        </select>
    </div>
</div>