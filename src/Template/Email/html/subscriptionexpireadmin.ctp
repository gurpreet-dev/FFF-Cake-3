<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab" rel="stylesheet">
</head>

<body>
<div style="padding:15px 0; margin:0px auto;font-weight:400;background-size:160px"> <span class="HOEnZb"><font color="#888888"> </font></span><span class="HOEnZb"><font color="#888888"> </font></span>
  <table width="600" border="0" cellpadding="10" cellspacing="0" style="margin:0px auto;background:#fffefb;text-align:center;font-family: 'Roboto Slab', serif;">
    <tbody>
      
      <tr style="background:#fff">
        <td style="text-align:center;padding-top:20px;padding-bottom:20px;border-bottom:2px solid #6cb4a0;background-image: url(http://singhgurpreet.crystalbiltech.com/trip/images/website/tour.jpg);background-size: cover;background-repeat: no-repeat;background-position: center;"><img width="100px" src="http://singhgurpreet.crystalbiltech.com/fff/images/website/logo.png" alt="img" class="CToWUd"></td>
      </tr>
      <tr><td><h1 style="color:#c9434a;">Subscription has been expired for the following user.</h1></td></tr>
      <tr style="margin: auto;width: 50%;display: block;">
        <td align="left" style="width: 100%;float: left; padding: 10px;"><span style="width: 50%;float: left;font-weight: 600;word-wrap: break-word;">User Name:</span> <span style="width: 50%;float: right;color: #6cb4a0;"><?php echo $user['name']; ?></span></td>
      </tr>
      <tr style="margin: auto;width: 50%;display: block;">
        <td align="left" style="width: 100%;float: left; padding: 10px;"><span style="width: 50%;float: left;font-weight: 600;word-wrap: break-word;">User Email:</span> <span style="width: 50%;float: right;color: #6cb4a0;"><?php echo $user['email']; ?></span></td>
      </tr>

      <tr style="margin: auto;width: 50%;display: block;">
        <td align="left" style="width: 100%;float: left; padding: 10px;"><span style="width: 50%;float: left;font-weight: 600;word-wrap: break-word;">Subscription Price:</span> <span style="width: 50%;float: right;color: #6cb4a0;"><?php echo '$'.$user['plan']['price']; ?></span></td>
      </tr>

      <tr style="margin: auto;width: 50%;display: block;">
        <td align="left" style="width: 100%;float: left; padding: 10px;"><span style="width: 50%;float: left;font-weight: 600;word-wrap: break-word;">Subscription Duration:</span> <span style="width: 50%;float: right;color: #6cb4a0;"><?php echo $user['plan']['duration']; ?></span></td>
      </tr>

      <tr style="margin: auto;width: 50%;display: block;">
        <td align="left" style="width: 100%;float: left; padding: 10px;"><span style="width: 50%;float: left;font-weight: 600;word-wrap: break-word;">Subscribe Date:</span> <span style="width: 50%;float: right;color: #6cb4a0;"><?php echo $user['from']; ?></span></td>
      </tr>
      
      <tr>
        <td align="center"><p style="color:#000;font-weight:500">Issued on behalf of<br>
            Fiendly Family Fables </p></td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>