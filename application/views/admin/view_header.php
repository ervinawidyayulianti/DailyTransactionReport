<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE, NO-STORE, must-revalidate">
        <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
        <META HTTP-EQUIV="EXPIRES" CONTENT=0>
        <title>Shop/dashbord</title>
        <link rel="stylesheet" href="<?php echo base_url() ?>bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>bootstrap/UX/select2.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>bootstrap/UX/select2-bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>bootstrap/ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>bootstrap/css/bootstrap-editable.css" rel="stylesheet"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>bootstrap/css/style.css">
        <script src="<?php echo base_url() ?>bootstrap/js/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>bootstrap/ui/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>bootstrap/UX/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>bootstrap/Parsley/dist/parsley.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>bootstrap/js/bootstrap-editable.min.js"></script>
             
        <style>
            .cus-form{
                background-color: #f5f5f5; border: 1px solid #e3e3e3; border-radius: 4px; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05) inset;
            }
            .tran-type{
                border: 1px solid #ccc; border-radius: 4px; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset; line-height: 30px; background: #fff;
            }
            .tran-type label{display: inline; width: 50%; margin: 10px;}
        </style>
    </head>
    <body>
        
        <div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
				<div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button> 
                                    <a class="navbar-brand" href="<?php echo base_url().'dashbord'?>"><strong>Shop Dashboard</strong></a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
                                            <li><a href="<?php echo base_url() ?>"><strong>Metro Fashion </strong></a></li>
                                            <li><a href="<?php echo base_url().'dashbord'?>"><strong>Dashboard</strong></a></li>
                                            <li><a  href="<?php echo base_url().'itemlist' ?>"><strong>List item</strong></a></li>
					</ul>
					
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
                                                    <a style="margin-right: 15px;" href="#" class="dropdown-toggle" data-toggle="dropdown"><b>ADMIN</b><strong class="caret"></strong></a>
							<ul class="dropdown-menu">
                                                                
                                                            <li style="text-align:center;background:#ddd">
                                                                <img src="<?php echo base_url()?>bootstrap/images/default_avatar.png"/>
								</li>
								<li class="divider">
								</li>
								<li>
                                                                    <a href="<?php echo base_url() ?>admin/logout"><small><i class="glyphicon glyphicon-off"></i></small>&nbsp;&nbsp;Logout</a>
								</li>
							</ul>
						</li>
					</ul>
                                       <?php if($this->session->userdata('role') == 'admin'):?>
                                        <ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
                                                    <a style="margin-right: 15px;" href="#" class="dropdown-toggle" data-toggle="dropdown"><b>SETTING</b><strong class="caret"></strong></a>
							<ul class="dropdown-menu">
                                                                <li>
                                                                    <a href="<?php echo base_url() ?>init/resetData"><small><i class="glyphicon glyphicon-cog"></i></small>&nbsp;&nbsp;Reset Data</a>
								</li>
								<li>
                                                                    <a href="<?php echo base_url() ?>dashbord/manageUser"><small><i class="glyphicon glyphicon-saved"></i></small>&nbsp;&nbsp;Manage User</a>
								</li>
								<li>
									<a href="#"><small><i class="glyphicon glyphicon-pencil"></i></small>&nbsp;&nbsp;Change Password</a>
								</li>
								
							</ul>
						</li>
					</ul>
                                    <?php endif; ?>
				</div>
				
			</nav>
		</div>
	</div>
</div>