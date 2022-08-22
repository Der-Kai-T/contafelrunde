
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo($global_application_name_header);?> Benutzerverwaltung</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Startseite</a></li>
              <li class="breadcrumb-item">Administration</li>
              <li class="breadcrumb-item active">Benutzer</li>
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
					<a href="index.php?page=admin_user_add" title="neuen Benutzer anlegen" class="btn btn-primary"><span class="fa fa-plus-circle"> </span> neu</a>
				</div>
			</div>
				
			<div class="card-body table-responsive p-0" style="height: auto;">
				<table class="table table-head-fixed">
					<thead>
							<tr>
								<th>Benutzer</th>
								<th>Conventions</th>
								
								<th>letzte Änderung</th>
								<th>Aktionen</th>
								
							</tr>
						</thead>
						
						<tbody >
							<?php
							

						
							$order = array();
							$order1['col'] = "tr_user_active";
							$order1['dir'] = "DESC";
							
							//array_push($order, $order1);

                            $order1['col'] = "tr_user_name";
							$order1['dir'] = "ASC";
							
							array_push($order, $order1);
							
							$db_array = db_select("tr_user", array(), $order);

						
							foreach($db_array as $line){
								
								$tr_user_id		    	= $line['tr_user_id'];
								$tr_user_name		 	= $line['tr_user_name'];
								$tr_user_mail 			= $line['tr_user_mail'];
								$tr_user_active	 		= $line['tr_user_active'];
								$tr_user_admin 			= $line['tr_user_admin'];
								$tr_user_modify_ts 		= UnixToTime($line['tr_user_modify_ts']);
								$tr_user_modify_id 		= db_get_user($line['tr_user_modify_id'])['user_full'];

                                $tr_user_icon           = "";
                                
                                
                                if($tr_user_admin == 1){
                                    $tr_user_icon .= "<i class='fas fa-screwdriver'></i>";
                                }

                                if($tr_user_active == 0){
                                    $tr_user_icon .= "<i class='fas fa-user-slash'></i>";
                                }

                                $convention_list        = "";
								echo "
									<tr>
										<th>$tr_user_name &nbsp; $tr_user_icon<br><a href='mailto:$tr_user_mail'>$tr_user_mail <i class='fas fa-at'></i></a></th>
										<td>$convention_list</td>
										
										
										<td>$tr_user_modify_ts<br>$tr_user_modify_id</td>
										<td><a href='index.php?page=z_department_edit&tr_user_id=$tr_user_id'><span class='fa fa-edit'></span></a></td>
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