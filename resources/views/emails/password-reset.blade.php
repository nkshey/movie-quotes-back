<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify your email address</title>
     <style>
      @media only screen and (min-width: 768px) {
        .greeting {
          padding-bottom: 32px !important;
        }
        .alt-text {
          padding-bottom: 24px !important;
        }
      }
    </style>
</head>
<body>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0; font-family: Arial, Helvetica, sans-serif; background: linear-gradient(180deg, #181623 0%, #191725 50%, #0D0B14 100%);">
    <tr>
      <td align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width:1230px; color:#ffffff; padding:78px 36px 90px 36px;" align="center">
          <td align="center" style="padding-bottom:72px; font-size:12px; font-weight:600; color:#DDCCAA; line-height:24px; text-transform:uppercase;">
            <img src={{ asset('assets/movie-quotes-logo.png') }} alt="Movie Quotes Logo" style="display:block; padding-bottom:10px; border:0;">
            MOVIE QUOTES
          </td>

          <tr>
            <td align="left" class="greeting" style="font-size:16px; color:#ffffff; line-height:24px; padding:0 0 24px 0;">
              Hola {{ $username }}!
            </td>
          </tr>

          <tr>
            <td align="left" style="font-size:16px; color:#ffffff; line-height:24px; padding:0 0 24px 0;">
              We received a request to reset your password for your Movie Quotes account. Please click the button below to set a new password:
            </td>
          </tr>

          <tr>
            <td align="left" style="padding: 0 0 40px 0;">
              <a href={{ $url }}
                style="display:inline-block; background:#E31221; color:#ffffff; font-size:16px; text-decoration:none; height:38px; line-height:38px; padding:0 14px; border-radius:4px;">
                Reset password
              </a>
            </td>
          </tr>

          <tr>
            <td align="left" class="alt-text" style="font-size:16px; color:#ffffff; line-height:24px; padding:0 0 16px 0;">
              If clicking doesn't work, you can try copying and pasting it to your browser:
            </td>
          </tr>

          <tr>
            <td align="left" style="font-size:16px; line-height:24px; padding:0 0 40px 0;">
              <a href={{ $url }}
                style="color:#DDCCAA; text-decoration:none; word-break:break-all;">
                {{ $url }}
              </a>
            </td>
          </tr>

          <tr>
            <td align="left" style="font-size:16px; color:#ffffff; line-height:24px; padding:0 0 24px 0;">
              If you did not request a password reset, you can safely ignore this email. If you have any problems, please contact us:
              <a href="mailto:support@moviequotes.ge" style="color:#ffffff; text-decoration:none;">support@moviequotes.ge</a>
            </td>
          </tr>

          <tr>
            <td align="left" style="font-size:16px; color:#ffffff; line-height:24px;">
              MovieQuotes Crew
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
