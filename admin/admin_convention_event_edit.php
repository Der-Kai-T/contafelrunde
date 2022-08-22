
<?php
if(!isset($event_id)){
    if(isset($_GET['tr_convention_event_id'])){
        $event_id = $_GET['tr_convention_event_id'];
    }else{
        include("400.php");
        include("include/html_footer.php");
        die;
    }
}


$where = array();
$wh['col'] = "tr_convention_event_id";
$wh['typ'] = "=";
$wh['val'] = $event_id;
array_push($where, $wh);


$ev = db_select("tr_convention_event", $where);

if(count($ev) > 0){
    $event = $ev[0];
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
        <h1 class="m-0"><?php echo($global_application_name_header);?> Event <?php echo $event['tr_convention_event_name'];?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Startseite</a></li>
          <li class="breadcrumb-item">Administration</li>
          <?php //TODO Add Convention-Name to breadcrumps (needs join or seperate db call)?>
          <li class="breadcrumb-item"><?php echo $event['tr_convention_event_name'];?></li>
          <li class="breadcrumb-item active">Event bearbeiten</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<?php include("include/html_result.php"); ?>



<!-- Main content -->
<section class="content">



<form action="index.php?page=admin_convention_event_edit_script" method="POST">
<input type="hidden" name="tr_convention_id" value="<?php echo $event['tr_convention_id']?>">
<input type="hidden" name="tr_convention_event_id" value="<?php echo $event['tr_convention_event_id']?>">

<div class="row">
<div class="col-12">
    
        <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Event bearbeiten</h3>

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
                                <label class="col-form-label" for="tr_convention_event_name">Bezeichnung des Events</label>
                                <input required type="text" name="tr_convention_event_name"  class="form-control" placeholder="" value="<?php echo $event['tr_convention_event_name']; ?>">
                            </div>
                        </div>

                        <div class="col-6">
                        
                            <div class="form-group">
                                <label class="col-form-label" for="tr_convention_event_location">Veranstaltungsort</label>
                                <input required type="text" name="tr_convention_event_location"  class="form-control" placeholder="" value="<?php echo $event['tr_convention_event_location']; ?>">
                            </div>
                        </div>

                       
                    </div>

                    <div class="row">
                        <div class="col-3">
                        
                            <div class="form-group">
                                <label class="col-form-label" for="tr_convention_event_start_date">erster Tag</label>
                                <input required type="date" name="tr_convention_event_start_date"  class="form-control" placeholder="" value="<?php echo UnixToDateForm($event['tr_convention_event_start_ts']); ?>">
                            </div>
                        </div>

                        <div class="col-3">
                        
                            <div class="form-group">
                                <label class="col-form-label" for="tr_convention_event_start_time">Uhrzeit Beginn</label>
                                <input required type="time" name="tr_convention_event_start_time"  class="form-control" placeholder="" value="<?php echo UnixToClock($event['tr_convention_event_start_ts']); ?>">
                            </div>
                        </div>

                        <div class="col-3">
                        
                            <div class="form-group">
                                <label class="col-form-label" for="tr_convention_event_end_date">letzter Veranstaltungstag</label>
                                <input required type="date" name="tr_convention_event_end_date"  class="form-control" placeholder="" value="<?php echo UnixToDateForm($event['tr_convention_event_end_ts']); ?>">
                            </div>
                        </div>

                        <div class="col-3">
                        
                            <div class="form-group">
                                <label class="col-form-label" for="tr_convention_event_end_time">Uhrzeit Ende</label>
                                <input required type="time" name="tr_convention_event_end_time"  class="form-control" placeholder="" value="<?php echo UnixToClock($event['tr_convention_event_end_ts']); ?>">
                            </div>
                        </div>

                       
                    </div>



                    <div class="row">
                        <div class="col-12">
                        
                            <div class="form-group">
                                <label class="col-form-label" for="tr_convention_event_text">Beschreibung</label><br>
                                <textarea required name="tr_convention_event_text" id="tr_convention_event_text" class="form-control" placeholder=""><?php echo $event['tr_convention_event_text']; ?></textarea>
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