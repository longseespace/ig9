<?php
if (!empty($mail)) {

}
?>

<!DOCTYPE html>
<html bgcolor="#f2f2f2" style="margin: 0; padding: 0; background-color: #f2f2f2">
  <head>
    <title>{subject}</title>
    
    <style type="text/css">
    /*<![CDATA[*/
      /* iOS automatically adds a link to addresses */
      /* Style the footer with the same color as the footer text */
      #footer a {
        color: #999999;
        -webkit-text-size-adjust: none;
        text-decoration: underline;
        font-weight: normal
      }
      #main_body {
        box-shadow: 0px 1px rgba(0, 0, 0, 0.1)
      }

      a { color: #FF9800; text-decoration: none; }

    /*]]>*/
    </style>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  <body bgcolor="#f2f2f2" style="font-size: 11px; margin: 0; padding: 0;  background-color: #f2f2f2;" marginheight="0" marginwidth="0" topmargin="0">

    <!-- one pixel image alt tag used to set email preheader (text which appears right after subject) -->
    <img id="hubspot-email-hidden-img" alt="" src="https://static.hubspot.com/img/trackers/blank001.gif" style="display: none!important; visibility: hidden; margin: 0px; padding: 0px" width="1" height="1"/>

    <!-- start container -->
    <table bgcolor="#f2f2f2" style="background-color: #f2f2f2; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none" cellpadding="0" cellspacing="0" border="0" width="100%">
      
      <tr>
        <td bgcolor="#f2f2f2" style="padding: 10px 20px; background-color: #f2f2f2">
          <div align="center">
            <table cellpadding="0" width="500" cellspacing="0" border="0">
              <tr>
                <td id="main_body" width="500" bgcolor="#fff" style="padding: 10px 20px 0; background-color: #fff; border: 1px solid #cccccc; border-bottom: 1px solid #acacac; border-radius: 4px">
                  <div align="center">
                    <table cellpadding="0" width="500" cellspacing="0" border="0">
                      <!-- start logo -->
                      
                      
                      <!-- end logo -->
                      <!-- start content -->
                      <tr>
                        <td style="padding: 0; background-color: #fff">
                          <div align="center">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family: sans-serif; font-size: 12px; color: #444444">
                              <tr>
                                <td>
                                  <div align="center">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:12px;">
                                      
  <tr>
    <td valign="top" width="100%" style="text-align: left; padding: 0; font-family: Helvetica, sans-serif; font-size: 13px; line-height: 23px; color: #444444">
      <div class="hubspot-editable">
        <table width='100%'>
          <tr>
            <td width="60%"><a href="http://ig9.vn"><img height=60 src="http://ig9.vn/themes/ig9/assets/img/logo.gif"></a></td>
            <td>
              <ul id='info' style='list-style: none; margin-top: 0; '>
                <li><a style='text-decoration: none; color:#FF9800; '; href='mailto:support@ig9.vn'><img src='http://ig9.vn/uploads/images/788c477035edff90e9644a1890669b21.jpg' height=16 style='vertical-align: middle;' /> support@ig9.vn</a></li>
                <li><img src='http://ig9.vn/uploads/images/57eeef64892d6c4fccec399abb1026da.jpg' height=16 style='position: relative; top: 3px;' /> (+84) 127 345 2178</li>
              </ul>
            </td>
          </tr>
        </table>
        
        
        <h1 style='color: #FF9800; font-size: 36px; font-family: Helvetica, Verdana; border-top: 1px dashed #E8E8E8; margin-top: 0; padding-top: 20px; text-align: center; '>Xin chúc mừng!</h1>

        <table width='100%'>
          <tr>
            <td width="170"><a href="{project-permalink}" style='text-decoration: none;'><img src="{project-image}" width=160 /></a></td>
            <td style='font-size: 14px; '>
              <p>Bạn đã trở thành người ủng hộ chính thức của dự án <a href="{project-permalink}" style='text-decoration: none;'><b>{project-title}</b></a> được thực hiện bởi {project-owner}</p>
            </td>
          </tr>
        </table>
        <h3 style='font-size: 14px'>IG9 xin xác nhận sự ủng hộ của bạn:</p></h3>

        <p>
        <h4 style='text-transform: uppercase; margin: 0; font-size: 11px; line-height: 14px;'>Mã giao dịch:</h4>
        {transaction-code}
        </p>

        <p>
        <h4 style='text-transform: uppercase; margin: 0; font-size: 11px; line-height: 14px;'>Người ủng hộ:</h4>
        {user-fullname}
        </p>

        <p>
        <h4 style='text-transform: uppercase; margin: 0; font-size: 11px; line-height: 14px;'>Số tiền ủng hộ:</h4>
        {transaction-amount}
        </p>

        <p>
        <h4 style='text-transform: uppercase; margin: 0; font-size: 11px; line-height: 14px;'>Phần thưởng:</h4>
        {reward-desc}
        </p>

        <table width='100%' style='border-top: 1px dashed #E8E8E8; '>
          <tr><td align='center' colspan=2><h2 style="font-size: 15px;line-height:40px;margin:0;color:#333">Chia sẻ dự án này với bạn bè!</h2></td></tr>
          <tr>
            <td width="50%" align='right'>
              <a href="{twitterUrl}" style='margin-right: 10px;'><img src='http://ig9.vn/themes/ig9/assets/img/share-twitter.gif' /></a>
            </td>
            <td align='left'>
              <a href="{facebookUrl}" style='margin-left: 10px;'><img src='http://ig9.vn/themes/ig9/assets/img/share-facebook.gif' /></a>
            </td>
          </tr>
        </table>

</div>
    </td>
  </tr>
  <tr>
    <td valign="top" style="text-align: left; padding: 0; font-family: sans-serif; font-size: 15px; line-height: 23px; color: #444444">&nbsp;</td>
  </tr>

                                    </table>
                                  </div>
                                </td>
                              </tr>
                              
                              
                            </table>
                          </div>
                        </td>
                      </tr>
                      <!-- end content -->
                    </table>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
      <!-- start footer -->
      <tr>
        <td bgcolor="#f2f2f2" style="background-color: #f2f2f2; padding: 13px 30px">
          <div align="center">
            <table cellpadding="0" width="500" cellspacing="0" border="0">
              <tr>
                <td align="center" bgcolor="#f2f2f2" style="background-color: #f2f2f2">
                  <p id="footer" style="font-family: Geneva, Verdana, Arial, Helvetica, sans-serif; text-align: center; font-size: 9px; line-height: 1.34em; color: #999999; display: block">
                    &copy; 2013 - Bản quyền của Công Ty Cổ Phần IG9
                  </p>
                </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
      <!-- end footer -->
    </table>
    <!-- end container -->
</body>
</html>