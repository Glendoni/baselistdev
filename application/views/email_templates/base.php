<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<style type="text/css">
		/* Based on The MailChimp Reset INLINE: Yes. */  
		/* Client-specific Styles */
		#outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
		body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;} 
		/* Prevent Webkit and Windows Mobile platforms from changing default font sizes.*/ 
		.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */  
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		/* Forces Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */ 
		#backgroundTable {margin:0; padding:0; width:100% !important; /*line-height: 100% !important;*/}
		/* End reset */

		/* Some sensible defaults for images
		Bring inline: Yes. */
		img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;} 
		a img {border:none;} 
		.image_fix {display:block;}

		/* Yahoo paragraph fix
		Bring inline: Yes. */
		p {margin: 1em 0;}

		/* Hotmail header color reset
		Bring inline: Yes. */

		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}

		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
		color: red !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
		}

		h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
		color: purple !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
		}

		/* Outlook 07, 10 Padding issue fix
		Bring inline: No.*/
		table td {border-collapse: collapse;}

		/* Remove spacing around Outlook 07, 10 tables
		Bring inline: Yes */
		table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }

		/* Styling your links has become much simpler with the new Yahoo.  In fact, it falls in line with the main credo of styling in email and make sure to bring your styles inline.  Your link colors will be uniform across clients when brought inline.
		Bring inline: Yes. */


		/***************************************************
		****************************************************
		MOBILE TARGETING
		****************************************************
		***************************************************/
		@media only screen and (max-device-width: 480px) {
			/* Part one of controlling phone number linking for mobile. */
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						pointer-events: none;
						cursor: default;
					}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						pointer-events: auto;
						cursor: default;
					}

		}

		/* More Specific Targeting */

		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
		/* You guessed it, ipad (tablets, smaller screens, etc) */
			/* repeating for the ipad */
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: blue; /* or whatever your want */
						pointer-events: none;
						cursor: default;
					}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: orange !important;
						pointer-events: auto;
						cursor: default;
					}
		}

		@media only screen and (-webkit-min-device-pixel-ratio: 2) {
		/* Put your iPhone 4g styles in here */ 
		}

		/* Android targeting */
		@media only screen and (-webkit-device-pixel-ratio:.75){
		/* Put CSS for low density (ldpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1){
		/* Put CSS for medium density (mdpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1.5){
		/* Put CSS for high density (hdpi) Android layouts in here */
		}
		/* end Android targeting */
span.preheader { display: none !important; }

	</style>

	<!-- Targeting Windows Mobile -->
	<!--[if IEMobile 7]>
	<style type="text/css">
	
	</style>
	<![endif]-->   

	<!-- ***********************************************
	****************************************************
	END MOBILE TARGETING
	****************************************************
	************************************************ -->

	<!--[if gte mso 9]>
		<style>
		/* Target Outlook 2007 and 2010 */
		</style>
	<![endif]-->
</head>
<body>
<!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
<table width="100%" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" bgcolor="#F4F4F4" style="margin:0; padding:10px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial !important;background-color:#F4F4F4;" align="center">
	<tr>
		<td valign="top"> 
		<!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
		<table cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
				<td width="200" valign="top" style="padding-left:20px;"><h1 style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial !important;float:left;font-size:16px;font-weight:600;line-height:70px;color:#fff;text-transform:lowercase;"><a href="http://www.sonovate.com/" style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial !important;color:inherit;"><img src="http://www.sonovate.com/assets/images/sonovate-logo-blue.png" class="logo" alt="Sonovate Logo" style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial !important;vertical-align:middle;margin-top:0;margin-bottom:0;margin-right:5px;margin-left:0;width:100px;height:18px;"><span class="mobile-hide" style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial !important;"></span></a></h1></td>
				<td width="200" valign="top"></td>
				<td width="200" valign="top"></td>
			</tr>
            <tr>
				

			</tr>
		</table>
<table bgcolor="#fff" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr>
				<td width="540" valign="top" colspan="3" bgcolor="#fff" style="color:#5c7099 !important; padding: 0 50px;">
<div class="content" style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial !important; font-size:14px" >

<singline style="font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial !important;" >
<h2 style="color:#293d66;font-size:27px;line-height:36px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial !important;font-weight:600; padding-top:10px; margin-bottom:0px; text-align:center;" >Sonovate</h2>
<h2 style="color:#293d66;font-size:23px;line-height:26px;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial !important;font-weight:100; margin-top:0; padding-top:0px; text-align:center;" >
  Finance for Recruitment Agencies Placing Contractors</h2>
<?php echo isset($sender_message)?$sender_message:''; ?>

<div style='font-size:12px; line-height:20px; float:left; '>
<font face='arial, helvetica, sans-serif'>
<span style='font-size:14px; font-weight:bold;'>
<?php echo isset($sender_name)?ucfirst($sender_name):'' ?>
</span>
<br>
<?php echo isset($sender_role)?ucfirst($sender_role):'' ?>
<span style='margin:0 10px 4px 10px; font-weight:bolder;border-right-width: 3px;border-right-style: solid; border-right-color: #4ba1d2;'>
</span>
<b>
Sonovate
</b>
</font>

<div style='border-top: 1px dotted #999999; margin-top:10px; padding-top:10px; height:80px; width:330px;'>
<div style='font-weight:bold; width:50px; float:left;'>
<font face='arial, helvetica, sans-serif'>
Office
</font>
</div>
<div style='float:left; width:200px'>
<font face='arial, helvetica, sans-serif'>
<?php echo isset($sender_direct_line)?ucfirst($sender_direct_line):'' ?>
</font></div>
<div style='clear:both;'>
</div>
<div style='font-weight:bold; width:50px; float:left;'>
<font face='arial, helvetica, sans-serif'>
Mobile
</font>
</div>
<div style='width:200px; float:left;'>
<font face='arial, helvetica, sans-serif'>
<?php echo isset($sender_mobile)?ucfirst($sender_mobile):'' ?>
</font>
</div>
<div style='clear:both;'>
</div>
<div style='border-top: 1px dotted #999999; margin-top:10px; padding-top:10px; font-size:12px;width:330px;'><font face='arial, helvetica, sans-serif'><a href='https://www.linkedin.com/pub/<?php echo isset($sender_linkedin)?ucfirst($sender_linkedin):'' ?>' target='_blank' style='color:#4875B4; text-decoration:none;'>
<span style='vertical-align:top; '><strong>Connect</strong> with me on LinkedIn</span></a></font>
<br><font face='arial, helvetica, sans-serif'><a href='https://twitter.com/sonovate' target='_blank' style='color:#33CCFF; text-decoration:none;'><span style='vertical-align:top; '><strong>Follow Us</strong> On Twitter</span></a></font></div><img style='margin-top:10px;' src='http://www.sonovate.com/assets/sonovate_logo-feb-2013.png' width='96' height='17'></div></div>        
         </div>
			
               </td>

			</tr>
        <tr>
          <td valign="top" colspan="3" bgcolor="#fff" style="color:#5c7099 !important; padding: 0 50px;">&nbsp;</td>
        </tr>
            
		</table>

		</td>
	</tr>
    
    <tr>
    <td>&nbsp;</td>
    </tr>
</table>    

       
<!-- End of wrapper table -->
</body>
</html>