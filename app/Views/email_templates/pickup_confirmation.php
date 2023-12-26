<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
     <!--[if gte mso 9]><xml>
        <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml><![endif]-->
        <title>Epic Email Pickup Confirmation</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
          <!--[if !mso]><!-->
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
            <!--<![endif]-->
</head>
<body>
    
        <style>
            *{
                margin: 0;
                padding: 0
            }
           @media screen {
                @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
           }
           body, html{
               font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;
               font-weight: 400;
               font-size: 15px;
               line-height: 1.8;
           }
            input, textarea, #signatureCanvas{
                background-color: #fff !important;
            }
            .email-wrapper{
                display: block;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>
         <div width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly;  font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">
              <center style="width: 100%; border-radius: 10px; max-width: 600px; margin: 0 auto; overflow: hidden; border-radius: 0; border: 1px solid #f8f8f8;" class="email-wrapper">
                <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                    <thead>
                        <tr>
                            <td style="width: 100%;">
                                <div style="background-image: url('https://riftofheroes.net/assets/images/epic-header.png'); background-size: contain; background-repeat: no-repeat; background-position: top center;">
                                    <img src="https://riftofheroes.net/assets/images/epic-logo.png" alt="" style="width: 200px; margin-left: auto; margin-right: auto; display: block;">
                                </div>
                            </td>
                         </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 100%; padding-left: 20px; padding-right: 20px; padding-top: 50px;">
                                <h1 style="color: #000; font-size: 18px; font-weight: 700; margin-bottom: 10px; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">TO: <span style="font-weight: 400;"><?=$result['email_address'];?></span> </h1>
                                <h1 style="color: #000; font-size: 18px; font-weight: 700; margin-bottom: 20px; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">Subject: <span style="font-weight: 400;">EPIC Pickup Confirmation </span> </h1>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; padding-left: 20px; padding-right: 20px; padding-top: 0px;">
                                <p style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">
                                    <?=$result['first_name'].' '.$result['last_name'];?>, 
                                </p>
                                <p style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">
                                    EPIC has you scheduled for pickup (<?=date('F d, Y', strtotime($result['picking_date']));?>) at (<?=date('h:i A', strtotime($result['picking_time']));?>). If you need to change this time, you can do this up to 48 hours prior to your scheduled pickup. 
                                </p>
                                <p style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">
                                    If you need to add additional items or have any questions, please send an email to <a href="mailto: service@epicstoragesolutions.com" style="color: #89C4F2; text-decoration: none; font-weight: bold;">service@epicstoragesolutions.com</a> or call our office at 336 549 5216. 
                                </p>
                            </td>
                        </tr>
                      
                        <tr>
                            <td style="width: 100%; padding-left: 20px; padding-right: 20px; padding-bottom: 20px; padding-top: 50px;">
                                <div style="max-width: 300px; margin-left: auto;">
                                    <h3 style="font-size: 20px; font-weight: 500; color: #000; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;margin-bottom: 5px;">Thank you for your business,</h3>
                                    <h4 style="font-size: 25px; font-weight: 700; color: #000; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;line-height: 1;">EPIC Storage Solutions </h4>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%;">
                                <div style="background-image: url('https://riftofheroes.net/assets/images/epic-footer.png'); background-size: contain; background-repeat: no-repeat; background-position: bottom center; padding: 50px;">
                                  
                                </div>
                            </td>
                        </tr>
                    </tbody>
              </table>
              </center>
         </div>
        </body>
</html>