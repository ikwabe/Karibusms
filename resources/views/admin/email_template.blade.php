<?php
/**
 * Description of email_template
 *
 *  -----------------------------------------------------
 *  Copyright: INETS COMPANY LIMITED
 *  Website: www.inetstz.com
 *  Email: info@inetstz.com
 *  -----------------------------------------------------
 * @author Ephraim Swilla
 */
?>

<div id=":1n9" class="ii gt adP adO">
    <div id=":1n1" class="a3s aXjCH m158f4a8be2ea947f"><div>
	    <div style="width:100%;padding:24px 0 16px 0;background-color:#f5f5f5;text-align:center">
		<div style="display:inline-block;width:90%;max-width:680px;min-width:280px;text-align:left;font-family:Roboto,Arial,Helvetica,sans-serif">
		    <?php
		    $user = App\Http\Controllers\Controller::user_info();
		    $link = 'media/images/business/' . $user->client_id . '/' . $user->profile_pic;
		    $path = is_file($link) ? url('/') . '/' . $link : url('/') . '/media/images/business/0/default.png';
		    ?>
		    <p style="padding-left:20px;vertical-align:middle">
			<b><?=  ucfirst($user->name)?></b>
		    </p>
		    <div style="height:0px" dir="ltr" class="adM"></div>
		    <div style="display:block;padding:0 2px" class="adM">
			<div style="display:block;background:#fff;height:2px">
			</div>
		    </div><div style="border-left:1px solid #f0f0f0;border-right:1px solid #f0f0f0">
			<div style="padding:24px 32px 24px 32px;background:#fff;border-right:1px solid #eaeaea;border-left:1px solid #eaeaea" dir="ltr">
			    <div style="font-size:14px;line-height:18px;color:#444">
				<div style="height:20px"></div>
				<?=$content ?>
			    </div>
			    <div style="height:20px"></div>
			    <div>
			    </div>
			</div>
		    </div>
		    <table style="width:100%;border-collapse:collapse" role="presentation">
			<tbody>
			    <tr>
				<td style="padding:0px">
				    <table style="border-collapse:collapse;width:3px" role="presentation">
					<tbody>
					    <tr height="1"><td width="1" bgcolor="#f0f0f0" style="padding:0px"></td><td width="1" bgcolor="#eaeaea" style="padding:0px"></td><td width="1" bgcolor="#e5e5e5" style="padding:0px"></td></tr>
					    <tr height="1"><td width="1" bgcolor="#f0f0f0" style="padding:0px"></td>
						<td width="1" bgcolor="#eaeaea" style="padding:0px"></td><td width="1" bgcolor="#eaeaea" style="padding:0px"></td></tr>
					    <tr height="1">
						<td width="1" bgcolor="#f5f5f5" style="padding:0px"></td><td width="1" bgcolor="#f0f0f0" style="padding:0px"></td>
						<td width="1" bgcolor="#f0f0f0" style="padding:0px"></td></tr>
					</tbody>
				    </table>

				</td><td style="width:100%;padding:0px"><div style="height:1px;width:auto;border-top:1px solid #ddd;background:#eaeaea;border-bottom:1px solid #f0f0f0"></div>
				</td><td style="padding:0px">
				    <table style="border-collapse:collapse;width:3px" role="presentation">
					<tbody><tr height="1">
						<td width="1" bgcolor="#e5e5e5" style="padding:0px"></td>
						<td width="1" bgcolor="#eaeaea" style="padding:0px"></td>
						<td width="1" bgcolor="#f0f0f0" style="padding:0px"></td>
					    </tr>
					    <tr height="1">
						<td width="1" bgcolor="#eaeaea" style="padding:0px"></td>
						<td width="1" bgcolor="#eaeaea" style="padding:0px"></td>
						<td width="1" bgcolor="#f0f0f0" style="padding:0px"></td></tr>
					    <tr height="1"><td width="1" bgcolor="#f0f0f0" style="padding:0px"></td>
						<td width="1" bgcolor="#f0f0f0" style="padding:0px"></td>
						<td width="1" bgcolor="#f5f5f5" style="padding:0px"></td></tr>
					</tbody>
				    </table>
				</td>
			    </tr>
			</tbody>
		    </table>

		    <table style="padding:14px 10px 0 10px" role="presentation" dir="ltr">
			<tbody>
			    <tr><td style="width:100%;font-size:11px;font-family:Roboto,Arial,Helvetica,sans-serif;color:#646464;line-height:20px;min-height:40px;vertical-align:middle">Sent By : karibuSMS Support
				    <br>Copyright © <?=date('Y')?> : By <a href="http://karibusms.com" target="_blank" style="text-decoration: none;">KaribuSMS -Web application</a></td>
				<td style="padding-left:20px;vertical-align:middle">
				    <a href="http://karibusms.com" target="_blank">
					<img src="http://www.karibusms.com/media/images/logo.png" width="46" alt="karibuSMS" border="0" class="CToWUd">
				    </a>
				</td>
			    </tr></tbody></table></div></div></div></div>

</div>