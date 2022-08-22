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
            <h1 class="m-0"><?php echo($global_application_name_header); echo $convention['tr_convention_name'];?> </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Startseite</a></li>
              <li class="breadcrumb-item">Administration</li>
              <li class="breadcrumb-item active">Conventions</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<?php include("include/html_result.php"); ?>



<!-- Main content -->
<section class="content">



<form action="index.php?page=admin_convention_edit_script" method="POST">
	<input type="hidden" name="convention_id" value="<?php echo $convention['tr_convention_id'];?> ">
	<input type="hidden" name="convention_name_old" value="<?php echo $convention['tr_convention_name'];?>">

<div class="row">
    <div class="col-12">
        
            <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Stammdaten bearbeiten</h3>

                        <div class="card-tools">
                            
                        </div>
                    </div>
                    
                    <div class="card-body" style="height: auto;">
                        <div class="row">
                            <div class="col-6">
                            
                                <div class="form-group">
                                    <label class="col-form-label" for="tr_convention_name" >Con-Name</label>
                                    <input required type="text" name="tr_convention_name"  class="form-control" placeholder="" value="<?php echo $convention['tr_convention_name']; ?>">
                                </div>
                            </div>

                           
                        </div>


                        <div class="row">
                            <div class="col-12">
                            
                                <div class="form-group">
                                    <label class="col-form-label" for="tr_convention_text">Beschreibung</label><br>
                                    <textarea required name="tr_convention_text" id="tr_convention_text" class="form-control" placeholder="" rows="10"><?php echo $convention['tr_convention_text']; ?></textarea>
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



<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Wappenschild</h3>
				
				<div class="card-tools">
				</div>
			</div>

			<div class="card-body table-responsive " style="height: auto;">
				<div class="row">
					<div class="col-4">
						<?php
							if($convention['tr_convention_icon']==""){
								$icon = "../resources/coat_of_arms.png";
							}else{
								$icon = "../resources/img/logos/" . $convention['tr_convention_icon']. ".";
							}
							?>
						<img src="<?php echo $icon; ?>" height="250px">
					</div>
					
					<div class="col-8">

						<form action="index.php?page=admin_convention_shield_upload" method="POST" enctype="multipart/form-data" id="img_upload_form">
							<input type="hidden" name="convention_id" value="<?php echo $convention['tr_convention_id'];?> ">
							<p>Nur Bilder im Format jpg, jpeg, gif und png sind erlaubt. Maximal 5MB pro Bild</p>
							<p class="text-danger">Achtung: Ist bereits ein Wappenschild vorhanden (links wird kein leeres Wappenschild dargestellt), wird das bereits hochgeladene Wappenschild überschrieben, ohne dass es zurückgeholt werden kann.</p>
							

							<div class="form-group">
								<label for="exampleInputFile">Wappenschild hochladen</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="image" name="image">
										
										<label class="custom-file-label" for="image"><i class="fas fa-search"></i> &nbsp;Datei auswählen</label>
									</div>
									
									<div class="input-group-append">
										<!--<span class="input-group-text" onclick="$('#img_upload_form').submit()">Hochladen</span>-->
										<button type="submit" class="input-group-text"><span class='fas fa-upload'></span>&nbsp;hochladen</button>			
									</div>
								</div>
							</div>

						</form>
					</div>
				</div>


			</div>
		</div>
	</div>
</div>









<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Events</h3>

				<div class="card-tools">
					<a href="index.php?page=admin_convention_event_add&tr_convention_id=<?php echo $convention['tr_convention_id']; ?>" title="neues Convention-Event anlegen" class="btn btn-primary"><span class="fa fa-plus-circle"> </span> neu</a>
				</div>
			</div>
				
			<div class="card-body table-responsive p-0" style="height: auto;">
				<table class="table table-head-fixed">
					<thead>
							<tr>
								<th>Event</th>
								<th>Location</th>
								<th>Zeitraum</th>
								
								<th>letzte Änderung</th>
								<th>Aktionen</th>
								
							</tr>
						</thead>
						
						<tbody >
							<?php
							
                            $sql        = "SELECT * FROM tr_convention_event WHERE tr_convention_id = :conid AND tr_convention_event_end_ts > :ts ORDER BY tr_convention_event_start_ts ASC";

                            $pdo 		= new PDO($pdo_mysql, $pdo_db_user, $pdo_db_pwd);

                            $statement	= $pdo->prepare($sql);
                            
                            $statement->bindParam(':conid', $convention['tr_convention_id']);
                            $statement->bindParam(':ts', $now);
                            
                            $statement->execute();

                            $events = array();

                            while($row = $statement->fetch()){
                                foreach ($row as $key => $value){
                                    $row[$key] = db_parse($value);
                                }

                                array_push($events, $row);
                            }

						
							foreach($events as $line){
								
								$tr_convention_event_id		    	= $line['tr_convention_event_id'];
								$tr_convention_event_name		 	= $line['tr_convention_event_name'];
								$tr_convention_event_location 		= $line['tr_convention_event_location'];
								$tr_convention_event_text 			= $line['tr_convention_event_text'];

								$tr_convention_event_start_ts 		= UnixToTime($line['tr_convention_event_start_ts']);
								$tr_convention_event_end_ts 		= UnixToTime($line['tr_convention_event_end_ts']);



								$tr_convention_event_modify_ts 		= UnixToTime($line['tr_convention_event_modify_ts']);
								$tr_convention_event_modify_id 		= db_get_user($line['tr_convention_event_modify_id'])['user_full'];

                                
                                
								echo "
									<tr>
										<th>$tr_convention_event_name</th>
                                        <td>$tr_convention_event_location</td>
										<td>$tr_convention_event_start_ts <br>$tr_convention_event_end_ts</td>
										
										
										<td>$tr_convention_event_modify_ts<br>$tr_convention_event_modify_id</td>
										<td><a href='index.php?page=admin_convention_event_edit&tr_convention_event_id=$tr_convention_event_id'><span class='fa fa-edit'></span></a></td>
									</tr>
								
								";


							}
								
								
							
							?>
						
						</tbody>
				
				
				</table>
	  
	  
			</div>
		</div>
	</div>
</div>







<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Links</h3>

				<div class="card-tools">
					<a href="index.php?page=admin_convention_add_link&tr_convention_id=<?php echo $convention['tr_convention_id']; ?>" title="neuen Convention-Link anlegen" class="btn btn-primary"><span class="fa fa-plus-circle"> </span> neu</a>
				</div>
			</div>
				
			<div class="card-body table-responsive p-0" style="height: auto;">
				<table class="table table-head-fixed">
					<thead>
							<tr>
								<th>Link-Text</th>
								<th>Link-href</th>
								<th>Link-Typ (Icon)</th>
								
								<th>letzte Änderung</th>
								<th>Aktionen</th>
								
							</tr>
						</thead>
						
						<tbody >
							<?php
							
                            $sql        = "SELECT * FROM tr_convention_link l, tr_convention_link_type t WHERE l.tr_convention_link_type_id = t.tr_convention_link_type_id AND l.tr_convention_id = :conid";

                            $pdo 		= new PDO($pdo_mysql, $pdo_db_user, $pdo_db_pwd);

                            $statement	= $pdo->prepare($sql);
                            
                            $statement->bindParam(':conid', $convention['tr_convention_id']);
                            
                            
                            $statement->execute();

                            $links = array();

                            while($row = $statement->fetch()){
                                foreach ($row as $key => $value){
                                    $row[$key] = db_parse($value);
                                }

                                array_push($links, $row);
                            }

						
							foreach($links as $line){
								
								$tr_convention_event_id		    	= $line['tr_convention_link_id'];
								$tr_convention_event_name		 	= $line['tr_convention_link_text'];
								$tr_convention_event_location 		= $line['tr_convention_link_href'];
								$tr_convention_event_text 			= $line['tr_convention_link_type_name'];
								$tr_convention_event_text 			= $line['tr_convention_link_type_icon'];

                                $tr_convention_event_modify_ts 		= UnixToTime($line['tr_convention_link_modify_ts']);
								$tr_convention_event_modify_id 		= db_get_user($line['tr_convention_link_modify_id'])['user_full'];

                                
                                
								echo "
									<tr>
										<th>$tr_convention_event_name</th>
                                        <td>$tr_convention_event_location</td>
										<td>$tr_convention_event_start_ts <br>$tr_convention_event_end_ts</td>
										
										
										<td>$tr_convention_event_modify_ts<br>$tr_convention_event_modify_id</td>
										<td><a href='index.php?page=admin_convention_edit&tr_convention_id=$tr_convention_id'><span class='fa fa-edit'></span></a></td>
									</tr>
								
								";


							}
								
								
							
							?>
						
						</tbody>
				
				
				</table>
	  
	  
			</div>
		</div>
	</div>
</div>