<?php
/**
 * Description of mail
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>

<body style="width:100%;  margin:0; padding:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; background-color:#ffffff;">
    <table cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
	   style="height:auto !important; margin:0; padding:0; width:100% !important; background-color:#F0F0F0;color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:19px; margin-top:0; padding:0; font-weight:normal;">
	<tr>
	    <td>

		<div id="tablewrap" style="width:100% !important; max-width:600px !important; text-align:center; margin:0 auto;">
		    <table id="contenttable" width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="background-color:#FFFFFF; margin:0 auto; text-align:center; border:none; width: 100% !important; max-width:600px !important;border-top:8px solid #5191BD">
			<tr>
			    <td width="100%">
				<table bgcolor="#FFF" border="0" cellspacing="0" cellpadding="20" width="100%">
				    <tr>
					<td width="100%" bgcolor="#FFF" style="text-align:left;">
					    <header> 
						<div class="navbar-header aside-md"> 
						    <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
							<i class="fa fa-bars"></i> </a>
						    <a href="http://localhost/karibu_laravel/" class="navbar-brand">
							<img src="http://localhost/karibu_laravel/media/images/logo.png" class="m-r-sm"></a>
						    <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user"> 
							<i class="fa fa-cog"></i> </a> 
						</div> 
					    </header>
					    <p>
						Hi  <?= ucwords($user->name) ?>,                    
					    </p>


					    <p>This is your current statistics of using karibuSMS</p>

					    <table border='1' cellspacing='1' style="border: 2px solid #F0F0F0;">
						<thead>
						    <tr>
							<th>Total Contacts</th>
							<th> Sent SMS </th>
							<th>Remaining SMS</th>
							<th>Pending SMS</th>
						    </tr>
						</thead>
						<tbody>
						    <tr>
							<td><?=$total_people?></td>
							<td>
							    <div>
								<table border='1' cellspacing='0' bordercolor='#cccccc'>
								    <tr>
									<th>Internet</th>
									<th>Phone SMS</th>
									<th>Total</th>
								    </tr>
								    <tr>
									<td><?=array_shift($internet_sms)->internet_sms?></td>
									<td><?=array_shift($phone_sms)->phone_sms?></td>
									<td><?=$sms_sent?></td>
								    </tr>
								</table>
							    </div>
							</td>
							<td><?=$user->message_left==NULL ? '0' : $user->message_left?></td>
							<td><?=$pending_sms?></td>
						    </tr>
						</tbody>
					    </table>
					    <br/>
					    <ul>
						<p></p>
					    </ul>
					    <a style="font-weight:bold; text-decoration:none;" href="http://karibusms.com" target=\'_blank\'><div style="display:block; max-width:25% !important; width:auto !important;margin:auto; height:auto !important;background-color:#0EA426;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border-radius:10px;color:#ffffff;font-size:16px;text-align:center">Login Now</div></a>


					    <br/>

					    <p>If you have any request, please write us at <a href=\'mailto:info@karibusms.com\'>info@karibusms.com</a>.</p>

					    <br/>

					    <p>Regards,<br/>
						KaribuSMS  Team</p>
					</td>
				    </tr>
				</table>

				<table bgcolor="#F0F0F0" border="0" cellspacing="0" cellpadding="10" width="100%" style="border-top:2px solid #F0F0F0;margin-top:10px;border-bottom:3px solid #2489B3">
				    <tr>
					<td width="100%" bgcolor="#ffffff" style="text-align:center;">
					    <p style="color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:14px; margin-top:0; padding:0; font-weight:normal;padding-top:5px;">

						We have sent you this email because you are one among our important customer. If you do not need to receive these emails anymore, please <a href="http://karibusms.com/unsubscriber?client=43&from=email&refer=" target="_blank">click here</a>.

					    </p>
					</td>
				    </tr>
				</table>
			    </td>
			</tr>
		    </table>
		</div>
	    </td>
	</tr>
    </table> 
</body>