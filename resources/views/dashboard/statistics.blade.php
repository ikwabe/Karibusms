	<div class="main-header clearfix">
		    <div class="page-title">
			<h3 class="no-margin">Dashboard</h3>
			<span>Welcome back Mr.Prakasam Mathaiyan</span>
		    </div><!-- /page-title -->

		    <ul class="page-stats">
			<li>
			    <div class="value">
				<span>New visits</span>
				<h4 id="currentVisitor">4239</h4>
			    </div>
			    <span id="visits" class="sparkline"><canvas width="79" height="35" style="display: inline-block; width: 79px; height: 35px; vertical-align: top;"></canvas></span>
			</li>
			<li>
			    <div class="value">
				<span>My balance</span>
				<h4>$<strong id="currentBalance">32025</strong></h4>
			    </div>
			    <span id="balances" class="sparkline"><canvas width="69" height="35" style="display: inline-block; width: 69px; height: 35px; vertical-align: top;"></canvas></span>
			</li>
		    </ul><!-- /page-stats -->
		</div>

		<div class="inner-continer">
		    <div class="row">

			<div class="col-sm-6 col-md-3">
			    <div class="panel-stat3 bg-danger">
				<h2 class="m-top-none" id="userCount">3031</h2>
				<h5>Registered users</h5>
				<i class="fa fa-arrow-circle-o-up fa-lg"></i><span class="m-left-xs">5% Higher than last week</span>
				<div class="stat-icon">
				    <i class="fa fa-user fa-3x"></i>
				</div>                            
			    </div>
			</div>  <!-- /.col -->

			<div class="col-sm-6 col-md-3">
			    <div class="panel-stat3 bg-info">
				<h2 class="m-top-none"><span id="serverloadCount">15</span>%</h2>
				<h5>Server Load</h5>
				<i class="fa fa-arrow-circle-o-up fa-lg"></i><span class="m-left-xs">1% Higher than last week</span>
				<div class="stat-icon">
				    <i class="fa fa-hdd-o fa-3x"></i>
				</div>
			    </div>
			</div>  <!-- /.col -->

			<div class="col-sm-6 col-md-3">
			    <div class="panel-stat3 bg-warning">
				<h2 class="m-top-none" id="orderCount">592</h2>
				<h5>New Orders</h5>
				<i class="fa fa-arrow-circle-o-up fa-lg"></i><span class="m-left-xs">3% Higher than last week</span>
				<div class="stat-icon">
				    <i class="fa fa-shopping-cart fa-3x"></i>
				</div>
			    </div>
			</div>  <!-- /.col -->

			<div class="col-sm-6 col-md-3">
			    <div class="panel-stat3 bg-success">
				<h2 class="m-top-none" id="visitorCount">10672</h2>
				<h5>Total Visitors</h5>
				<i class="fa fa-arrow-circle-o-up fa-lg"></i><span class="m-left-xs">15% Higher than last week</span>
				<div class="stat-icon">
				    <i class="fa fa-bar-chart-o fa-3x"></i>
				</div>
			    </div>
			</div>  <!-- /.col -->

		    </div>

		    <div class="row">

			<div class="col-md-8">
			    <div class="panel panel-white no-border">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="fs-stats"></i> Traffic</h3>

				    <div class="panel-tools">
					<a class="btn btn-xs btn-link panel-collapse collapses" href="javascript:void(0);"></a>
					<a class="btn btn-xs btn-link panel-refresh" href="javascript:void(0);"><i class="fs-refresh"></i></a>
				    </div>
				</div>
				<div class="panel-body">
				    <div class="chart" id="trafficWidget"></div>
				</div>
				<div class="panel-footer">
				    <div class="row row-merge">
					<div class="col-xs-3 text-center border-right">
					    <h4 class="no-margin">1232</h4>
					    <small class="text-muted">Visitors</small>
					</div>
					<div class="col-xs-3 text-center border-right">
					    <h4 class="no-margin">5421</h4>
					    <small class="text-muted">Orders</small>
					</div>
					<div class="col-xs-3 text-center border-right">
					    <h4 class="no-margin">3021</h4>
					    <small class="text-muted">Tickets</small>
					</div>
					<div class="col-xs-3 text-center">
					    <h4 class="no-margin">7098</h4>
					    <small class="text-muted">Customers</small>
					</div>
				    </div><!-- ./row -->
				</div>
			    </div>

			</div>

			<div class="col-md-4">
			    <div class="panel panel-white no-border">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="fa fa-rss"></i> Feeds</h3>

				    <div class="panel-tools">
					<a class="btn btn-xs btn-link panel-collapse collapses" href="javascript:void(0);"></a>
					<a class="btn btn-xs btn-link panel-refresh" href="javascript:void(0);"><i class="fs-refresh"></i></a>
				    </div>
				</div>
				<div class="panel-body " style="padding: 3px;">
				    <div class="scroller" data-height="380px">
					<ul class="list-group collapse in" id="feedList">
					    <li class="list-group-item clearfix">
						<div class="activity-icon bg-primary small">
						    <i class="fa fa-envelope-o"></i>
						</div>
						<div class="pull-left m-left-sm">
						    <span>John Doe Sent a Message</span><br>
						    <small class="text-muted"><i class="fa fa-clock-o"></i> 1m ago</small>
						</div>
					    </li>
					    <li class="list-group-item clearfix">
						<div class="activity-icon bg-danger small">
						    <i class="fa fa-camera"></i>
						</div>
						<div class="pull-left m-left-sm">
						    <span>John Doe Add a new photo.</span><br>
						    <small class="text-muted"><i class="fa fa-clock-o"></i> 2m ago</small>
						</div>
					    </li>
					    <li class="list-group-item clearfix">
						<div class="activity-icon bg-success small">
						    <i class="fa fa-usd"></i>
						</div>
						<div class="pull-left m-left-sm">
						    <span>2 items sold.</span><br>
						    <small class="text-muted"><i class="fa fa-clock-o"></i> 30m ago</small>
						</div>	
					    </li>
					    <li class="list-group-item clearfix">
						<div class="activity-icon bg-info small">
						    <i class="fa fa-comment"></i>
						</div>
						<div class="pull-left m-left-sm">
						    <span>John Doe commented on <a href="#">This Article</a></span><br>
						    <small class="text-muted"><i class="fa fa-clock-o"></i> 1hr ago</small>
						</div>
					    </li>
					    <li class="list-group-item clearfix">
						<div class="activity-icon bg-success small">
						    <i class="fa fa-usd"></i>
						</div>
						<div class="pull-left m-left-sm">
						    <span>3 items sold.</span><br>
						    <small class="text-muted"><i class="fa fa-clock-o"></i> 2days ago</small>
						</div>	
					    </li>
					    <li class="list-group-item clearfix">
						<div class="activity-icon bg-info small">
						    <i class="fa fa-comment"></i>
						</div>
						<div class="pull-left m-left-sm">
						    <span>John Doe commented on <a href="#">This Article</a></span><br>
						    <small class="text-muted"><i class="fa fa-clock-o"></i> 1hr ago</small>
						</div>
					    </li>
					    <li class="list-group-item clearfix">
						<div class="activity-icon bg-info small">
						    <i class="fa fa-comment"></i>
						</div>
						<div class="pull-left m-left-sm">
						    <span>John Doe commented on <a href="#">This Article</a></span><br>
						    <small class="text-muted"><i class="fa fa-clock-o"></i> 1hr ago</small>
						</div>
					    </li>
					</ul>
				    </div>                                    
				</div>
			    </div>
			</div>

		    </div>

		    <div class="row">
			<div class="col-md-6">
			    <div class="panel panel-default">
				<div class="panel-heading">
				    <i class="fa fa-check"></i> To Do List 

				</div>
				<div class="panel-body no-padding collapse in" id="toDoListWidget">
				    <ul class="list-group task-list no-margin collapse in">
					<li class="list-group-item selected">
					    <label class="label-checkbox inline">
						<input type="checkbox" class="task-finish" checked="">
						<span class="custom-checkbox"></span>
					    </label>
					    SEO Optimisation
					    <span class="pull-right">
						<a href="#" class="task-del"><i class="fa fa-trash-o fa-lg text-danger"></i></a>
					    </span>
					</li>
					<li class="list-group-item">
					    <label class="label-checkbox inline">
						<input type="checkbox" class="task-finish">
						<span class="custom-checkbox"></span>
					    </label>
					    Unit Testing
					    <span class="pull-right">
						<a href="#" class="task-del"><i class="fa fa-trash-o fa-lg text-danger"></i></a>
					    </span>
					</li>
					<li class="list-group-item">
					    <label class="label-checkbox inline">
						<input type="checkbox" class="task-finish">
						<span class="custom-checkbox"></span>
					    </label>
					    Mobile Development 
					    <span class="pull-right">
						<a href="#" class="task-del"><i class="fa fa-trash-o fa-lg text-danger"></i></a>
					    </span>
					    <span class="badge badge-success m-right-xs">3</span>
					</li>
					<li class="list-group-item">
					    <label class="label-checkbox inline">
						<input type="checkbox" class="task-finish">
						<span class="custom-checkbox"></span>
					    </label>
					    Database Migration
					    <span class="pull-right">
						<a href="#" class="task-del"><i class="fa fa-trash-o fa-lg text-danger"></i></a>
					    </span>
					</li>
					<li class="list-group-item">
					    <label class="label-checkbox inline">
						<input type="checkbox" class="task-finish">
						<span class="custom-checkbox"></span>
					    </label>
					    New Frontend Layout <span class="label label-warning m-left-xs">PENDING</span>
					    <span class="pull-right">
						<a href="#" class="task-del"><i class="fa fa-trash-o fa-lg text-danger"></i></a>
					    </span>
					</li>
					<li class="list-group-item">
					    <label class="label-checkbox inline">
						<input type="checkbox" class="task-finish">
						<span class="custom-checkbox"></span>
					    </label>
					    Bug Fixes <span class="label label-danger m-left-xs">IMPORTANT</span>
					    <span class="pull-right">
						<a href="#" class="task-del"><i class="fa fa-trash-o fa-lg text-danger"></i></a>
					    </span>
					</li>
				    </ul><!-- /list-group -->
				</div>
			    </div>
			</div>

			<div class="col-md-6">
			    <div class="panel panel-success">
				<div class="panel-heading">
				    <h3 class="panel-title">Chat With Al Pacino</h3>
				</div>
				<div class="panel-body" id="chats">

				    <div class="scroller" data-height="160px" data-always-visible="1" data-rail-visible1="1">
					<ul class="chats">

					    <li class="in">
						<img class="avatar" alt="" src="admin_assets/assets/images/demo/avatar-10.jpg" />
						<div class="message">
						    <span class="arrow"></span>
						    <a href="#" class="name">Al Pacino</a>
						    <span class="datetime">at Jul 25, 2012 11:09</span>
						    <span class="body">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
						    </span>
						</div>
					    </li>

					    <li class="out">
						<img class="avatar" alt="" src="admin_assets/assets/images/demo/avatar-1.jpg" />
						<div class="message">
						    <span class="arrow"></span>
						    <a href="#" class="name">Prakasam Mathaiyan</a>
						    <span class="datetime">at Jul 25, 2012 11:09</span>
						    <span class="body">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
						    </span>
						</div>
					    </li>

					    <li class="in">
						<img class="avatar" alt="" src="admin_assets/assets/images/demo/avatar-10.jpg" />
						<div class="message">
						    <span class="arrow"></span>
						    <a href="#" class="name">Al Pacino</a>
						    <span class="datetime">at Jul 25, 2012 11:09</span>
						    <span class="body">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
						    </span>
						</div>
					    </li>

					    <li class="out">
						<img class="avatar" alt="" src="admin_assets/assets/images/demo/avatar-1.jpg" />
						<div class="message">
						    <span class="arrow"></span>
						    <a href="#" class="name">Prakasam Mathaiyan</a>
						    <span class="datetime">at Jul 25, 2012 11:09</span>
						    <span class="body">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
						    </span>
						</div>
					    </li>

					    <li class="in">
						<img class="avatar" alt="" src="admin_assets/assets/images/demo/avatar-10.jpg" />
						<div class="message">
						    <span class="arrow"></span>
						    <a href="#" class="name">Al Pacino</a>
						    <span class="datetime">at Jul 25, 2012 11:09</span>
						    <span class="body">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
						    </span>
						</div>
					    </li>

					    <li class="out">
						<img class="avatar" alt="" src="admin_assets/assets/images/demo/avatar-1.jpg" />
						<div class="message">
						    <span class="arrow"></span>
						    <a href="#" class="name">Prakasam Mathaiyan</a>
						    <span class="datetime">at Jul 25, 2012 11:09</span>
						    <span class="body">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
						    </span>
						</div>
					    </li>

					    <li class="in">
						<img class="avatar" alt="" src="admin_assets/assets/images/demo/avatar-10.jpg" />
						<div class="message">
						    <span class="arrow"></span>
						    <a href="#" class="name">Al Pacino</a>
						    <span class="datetime">at Jul 25, 2012 11:09</span>
						    <span class="body">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit, 
							sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
						    </span>
						</div>
					    </li>
					</ul>
				    </div>

				    <div class="chat-form">
					<div class="input-cont">   
					    <input class="form-control" type="text" placeholder="Type a message here..." />
					</div>
					<div class="btn-cont"> 
					    <span class="arrow"></span>
					    <a href="javascript:;" class="btn btn-info"><i class="fs-checkmark-2"></i></a>
					</div>
				    </div>

				</div>
			    </div>
			</div>
		    </div>

		</div>

	<script src="admin_assets/assets/js/dashboard.js"></script>
	
	<script>
	    jQuery(document).ready(function () {
		Dashboard.init();
	    });
	</script>