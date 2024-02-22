<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
     <!--[if gte mso 9]><xml>
        <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml><![endif]-->
        <title>Epic Email Confirmation to order</title>
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
                                <h1 style="color: #000; font-size: 18px; font-weight: 700; margin-bottom: 10px; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">TO: <span style="font-weight: 400;"><?=$additionalData['email_address'];?></span> </h1>
                                <h1 style="color: #000; font-size: 18px; font-weight: 700; margin-bottom: 10px; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">CC: <span style="font-weight: 400;"><?=$additionalData['parent_email_address'];?></span> </h1>
                                <h1 style="color: #000; font-size: 18px; font-weight: 700; margin-bottom: 20px; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">Subject: <span style="font-weight: 400;">HPU Storage Receipt – EPIC Storage</span> </h1>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; padding-left: 20px; padding-right: 20px; padding-top: 0px;">
                                <p style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">
                                    <?=$additionalData['first_name'].' '.$additionalData['last_name'];?>, 
                                </p>
                                <p style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">
                                    We processed the below transaction for your storage at High Point University. 
                                </p>
                                <p style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">
                                    You will receive a follow-up email from our office for box delivery and a reminder to schedule a time for pick up. If you know your time now for pickup, please go to our Schedule Page <a href="<?=base_url();?>scheduling/choose-schedule/<?=$additionalData['referenceCode'];?>" style="color: #89C4F2; text-decoration: none; font-weight: bold;"><?=base_url();?>scheduling/choose-schedule</a> to secure your spot. 
                                </p>
                                <p style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif;">
                                    If you have additional items to add to your order or if have any questions, please send an email to <a href="mailto: service@epicstoragesolutions.com" style="color: #89C4F2; text-decoration: none; font-weight: bold;">service@epicstoragesolutions.com</a> or call our office at 336 549 5216. 
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; padding-left: 20px; padding-right: 20px; padding-bottom: 20px;">
                                <div style="border: 1px solid #89C4F2; padding-left: 20px; padding-top: 20px; padding-right: 20px; padding-bottom: 20px;">
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" >
                                        <tr>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 40%;">Student Name:</td>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 60%;"> <?=$additionalData['first_name'].' '.$additionalData['last_name'];?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 40%;">Student ID:</td>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 60%;"> <?=$additionalData['student_id']?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 40%;">Student Email:</td>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 60%;"> <?=$additionalData['email_address']?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 40%;">Student Phone #:</td>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 60%;"> <?=$additionalData['phone_number']?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 40%;">Parents Phone #: </td>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 60%;"> <?=$additionalData['parent_phone_number']?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 40%;">Student Dorm and Room:</td>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 400; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 60%;"> <?=$additionalData['dorm_name'].' - Room No. '.$additionalData['dorm_room_number'];?></td>
                                        </tr>
                                    </table>
                                    <br>
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" >
                                        <tr>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 50%; border: 1px solid #89C4F2; padding: 3px 10px;">Base Amount </td>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 50%; border: 1px solid #89C4F2; padding: 3px 10px;">$<?=$additionalData['base_amount'];?> </td>
                                        </tr>
                                        <?php if(isset($additionalData['orderItems'])) : ?>
                                        <?php foreach ($additionalData['orderItems'] as $orderItem): ?>
                                            <tr>
                                                <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 50%; border: 1px solid #89C4F2; padding: 3px 10px;"><?= $orderItem['item_name'].' (x'.$orderItem['quantity'].')'; ?></td>
                                                <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 50%; border: 1px solid #89C4F2; padding: 3px 10px;">$<?= $orderItem['totalamount']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                        <tr>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 50%; border: 1px solid #89C4F2; padding: 3px 10px;">Study Abroad Additional Price </td>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 50%; border: 1px solid #89C4F2; padding: 3px 10px;">$<?=$additionalData['study_abroad_additional_storage_price'];?> </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 50%; border: 1px solid #89C4F2; padding: 3px 10px;">TOTAL </td>
                                            <td style="color: #000; font-size: 14px; margin-bottom: 20px; font-weight: 600; font-family: 'Poppins', 'fallback font 1', 'fallback font 2', sans-serif; width: 50%; border: 1px solid #89C4F2; padding: 3px 10px;">$<?=$additionalData['totalAmount']?></td>
                                        </tr>
                                       
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%; padding-left: 20px; padding-right: 20px; padding-bottom: 20px;">
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