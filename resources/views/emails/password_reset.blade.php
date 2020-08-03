<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1.0">
	<title>Password Reset</title>
</head>
<body style="margin: 0; padding: 0;">
    <table width= "100%" align="center" cellspacing="0" cellpadding="0" style="border: 1px groove cornflowerblue; max-width: 600px;">
    
    	  <tr>
            <td style="padding: 0 5% 0 5%">
             <p  style="font-family: 'Arial Rounded MT Bold',serif; font-size: large; font-weight: 600">Good Day</p>
             <p>Click the link below to reset your password</p>
                <p><a href="{{url('password_reset',$token)}}" >{{$token}} </a></p>
                <p>You are getting the message because a reset password was activated from our portal.if you did not attempt to reset your password , disregard the message.</p>
                <p>Regard.<br/>Unical Result Database Unit </p>
                
            </td>
        </tr>
         </table>
</body>
</html>