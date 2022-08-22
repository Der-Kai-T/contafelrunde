
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

<form action="index.php?page=admin_user_add_script" method="POST">

<div class="row">
    <div class="col-12">
        
            <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">neuen Benutzer anlegen</h3>

                        <div class="card-tools">
                            
                        </div>
                    </div>
                    
                    <div class="card-body" style="height: auto;">
                        <div class="row">
                            <div class="col-6">
                            
                                <div class="form-group">
                                    <label class="col-form-label" for="tr_user_name">Name (wird so angezeigt)</label>
                                    <input required type="text" name="tr_user_name"  class="form-control" placeholder="">
                                </div>
                            </div>

                            <div class="col-6">

                                <div class="form-group">
                                    <label class="col-form-label" for="tr_user_mail">E-Mail</label>
                                    <input required type="text" name="tr_user_mail"  class="form-control" placeholder="">
                                </div>	
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-6">
                            
                                <div class="form-group">
                                    <label class="col-form-label" for="tr_user_admin">Administrator</label><br>
                                    <input type="checkbox" name="tr_user_admin" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </div>
                            </div>

                            <div class="col-6">

                                <div class="form-group">
                                    <label class="col-form-label" for="tr_user_active">Aktiv</label><br>
                                    <input type="checkbox" name="tr_user_active" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
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