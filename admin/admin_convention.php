
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo($global_application_name_header);?> Conventions</h1>
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



<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Benutzer verwalten</h3>

				<div class="card-tools">
					<a href="index.php?page=admin_convention_add" title="neue Convention anlegen" class="btn btn-primary"><span class="fa fa-plus-circle"> </span> neu</a>
				</div>
			</div>
				
			<div class="card-body table-responsive p-0" style="height: auto;">
				<table class="table table-head-fixed">
					<thead>
							<tr>
								<th>Convention</th>
								<th>nächstes Event</th>
								<th>berechtigte Benutzer</th>
								
								<th>letzte Änderung</th>
								<th>Aktionen</th>
								
							</tr>
						</thead>
						
						<tbody >
							<?php
							

						
							$order = array();
							$order1['col'] = "tr_convention_name";
							$order1['dir'] = "ASC";
							
							array_push($order, $order1);
							
							$db_array = db_select("tr_convention", array(), $order);

						
							foreach($db_array as $line){
								
								$tr_convention_id		    	= $line['tr_convention_id'];
								$tr_convention_icon		 	    = $line['tr_convention_icon'];
								$tr_convention_name 			= $line['tr_convention_name'];

								$tr_convention_modify_ts 		= UnixToTime($line['tr_convention_modify_ts']);
								$tr_convention_modify_id 		= db_get_user($line['tr_convention_modify_id'])['user_full'];

                                
                                $event            = "";
                                $user_list        = "";
								echo "
									<tr>
										<th>$tr_convention_name</th>
                                        <td>$event</td>
										<td>$user_list</td>
										
										
										<td>$tr_convention_modify_ts<br>$tr_convention_modify_id</td>
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