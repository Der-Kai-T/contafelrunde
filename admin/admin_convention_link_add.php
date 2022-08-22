
<?php
if(!isset($convention_id)){
    if(isset($_GET['tr_convention_id'])){
        $convention_id = $_GET['tr_convention_id'];
    }else{
        include("400.php");
        include("include/html_footer.php");
        die;
    }
}


$where = array();
$wh['col'] = "tr_convention_id";
$wh['typ'] = "=";
$wh['val'] = $convention_id;
array_push($where, $wh);


$con = db_select("tr_convention", $where);

if(count($con) > 0){
    $convention = $con[0];
}else{
    include("999.php");
    include("include/html_footer.php");
    die;
}

$now        		= time();


?>




<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><?php echo($global_application_name_header);?> <?php echo $convention['tr_convention_name'];?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Startseite</a></li>
          <li class="breadcrumb-item">Administration</li>
          <li class="breadcrumb-item"><?php echo $convention['tr_convention_name'];?></li>
          <li class="breadcrumb-item active">Link hinzufügen</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<?php include("include/html_result.php"); ?>



<!-- Main content -->
<section class="content">



<form action="index.php?page=admin_convention_link_add_script" method="POST">
<input type="hidden" name="tr_convention_id" value="<?php echo htmlspecialchars($convention_id)?>">

<div class="row">
<div class="col-12">
    
        <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Link hinzufügen</h3>

                    <div class="card-tools">
                        
                    </div>
                </div>

                <?php
                //Fields: Start and End, Name, Location, Description

                ?>
                
                <div class="card-body" style="height: auto;">
                    <div class="row">
                        <div class="col-6">
                        
                            <div class="form-group">
                                <label class="col-form-label" for="tr_convention_link_href">href</label>
                                <input required type="text" name="tr_convention_link_href"  class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="col-6">
                        
                            <div class="form-group">
                                <label class="col-form-label" for="tr_convention_link_text">Link-Text (Hover)</label>
                                <input required type="text" name="tr_convention_link_text"  class="form-control" placeholder="">
                            </div>
                        </div>

                       
                    </div>



                    <div class="row">
                        <div class="col-12">
                        <div class="form-group">
                                <label class="col-form-label" for="tr_convention_link_type_id">Link-Type (icon)</label>
                                <select required class="form-control" name="tr_convention_link_type_id">
                                    <?php
                                        $order = array();
                                        $or['col'] = "tr_convention_link_type_name";
                                        $or['dir'] = "ASC";
                                        array_push($order, $or);

                                        $db_array = db_select("tr_convention_link_type", array(), $order);

                                        foreach($db_array as $line){
                                            $icon_id = $line['tr_convention_link_type_id'];
                                            $icon_name = $line['tr_convention_link_type_name'];
                                            $icon = $line['tr_convention_link_type_icon'];
                                            
                                            echo "<option value='$icon_id' data-content='<i class=\"$icon\"></i>'> $icon_name\n";

                                        }
                                        //TODO Add Icon-Support
                                    ?>
                                    </select>
                            </div>
                            
                        </div>

                        
                    </div>
                    
                    
                    

                    
                    
                </div>

                <div class="card-footer">
                <button type="submit" class="btn btn-primary">Eintrag speichern</button>
                </div>

                
        </div>
    
</div>
</div>


                
        
</form>