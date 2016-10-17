<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magic Link Request</title>
    <style type="text/css">
        /* Template styling */

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            width: 100%;
            max-width: 100%;
            font-size: 17px;
            line-height: 24px;
            color: #373737;
            background: #F9F9F9;
        }
        h1,
        h2,
        h3,
        h4 {
            color: #2ab27b;
            margin-bottom: 12px;
            line-height: 26px;
        }
        p,
        ul,
        ul li {
            font-size: 17px;
            margin: 0 0 16px;
            line-height: 24px;
        }
        ul {
            margin-bottom: 24px;
        }
        ul li {
            margin-bottom: 8px;
        }
        p.mini {
            font-size: 12px;
            line-height: 18px;
            color: #ABAFB4;
        }
        p.message {
            font-size: 16px;
            line-height: 20px;
            margin-bottom: 4px;
        }
        hr {
            margin: 2rem 0;
            width: 100%;
            border: none;
            border-bottom: 1px solid #ECECEC;
        }
        a,
        a:link,
        a:visited,
        a:active,
        a:hover {
            font-weight: bold;
            color: #439fe0;
            text-decoration: none;
            word-break: break-word;
        }
        a:active,
        a:hover {
            text-decoration: underline;
        }
        .time {
            font-size: 11px;
            color: #ABAFB4;
            padding-right: 6px;
        }
        .emoji {
            vertical-align: bottom;
        }
        .avatar {
            border-radius: 2px;
        }
        #footer p {
            margin-top: 16px;
            font-size: 12px;
        }
        /* Client-specific Styles */

        #outlook a {
            padding: 0;
        }
        body {
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0 auto;
            padding: 0;
        }
        .ExternalClass {
            width: 100%;
        }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }
        #backgroundTable {
            margin: 0;
            padding: 0;
            width: 100%;
            line-height: 100% !important;
        }
        /* Some sensible defaults for images
        Bring inline: Yes. */

        img {
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }
        a img {
            border: none;
        }
        .image_fix {
            display: block;
        }
        /* Outlook 07, 10 Padding issue fix
        Bring inline: No.*/

        table td {
            border-collapse: collapse;
        }
        /* Fix spacing around Outlook 07, 10 tables
        Bring inline: Yes */

        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        /* Mobile */

        @media only screen and (max-device-width: 480px) {
            /* Part one of controlling phone number linking for mobile. */

            a[href^="tel"],
            a[href^="sms"] {
                text-decoration: none;
                color: blue;
                /* or whatever your want */

                pointer-events: none;
                cursor: default;
            }
            .mobile_link a[href^="tel"],
            .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: orange !important;
                pointer-events: auto;
                cursor: default;
            }
        }
        /* Not all email clients will obey these, but the important ones will */

        @media only screen and (max-width: 480px) {
            .card {
                padding: 1rem 0.75rem !important;
            }
            .link_option {
                font-size: 14px;
            }
            hr {
                margin: 2rem -0.75rem !important;
                padding-right: 1.5rem !important;
            }
        }
        /* More Specific Targeting */

        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
            /* You guessed it, ipad (tablets, smaller screens, etc) */
            /* repeating for the ipad */

            a[href^="tel"],
            a[href^="sms"] {
                text-decoration: none;
                color: blue;
                /* or whatever your want */

                pointer-events: none;
                cursor: default;
            }
            .mobile_link a[href^="tel"],
            .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: orange !important;
                pointer-events: auto;
                cursor: default;
            }
        }
        /* iPhone Retina */

        @media only screen and (-webkit-min-device-pixel-ratio: 2) and (max-device-width: 640px) {
            /* Must include !important on each style to override inline styles */

            #footer p {
                font-size: 9px;
            }
        }
        /* Android targeting */

        @media only screen and (-webkit-device-pixel-ratio: .75) {
            /* Put CSS for low density (ldpi) Android layouts in here */

            img {
                max-width: 100%;
                height: auto;
            }
        }
        @media only screen and (-webkit-device-pixel-ratio: 1) {
            /* Put CSS for medium density (mdpi) Android layouts in here */

            img {
                max-width: 100%;
                height: auto;
            }
        }
        @media only screen and (-webkit-device-pixel-ratio: 1.5) {
            /* Put CSS for high density (hdpi) Android layouts in here */

            img {
                max-width: 100%;
                height: auto;
            }
        }
        /* Galaxy Nexus */

        @media only screen and (min-device-width: 720px) and (max-device-width: 1280px) {
            img {
                max-width: 100%;
                height: auto;
            }
            body {
                font-size: 16px;
            }
        }
        /* end Android targeting */
    </style>
</head>

<body style="background: #F9F9F9; color: #373737; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 17px; line-height: 24px; max-width: 100%; width: 100% !important; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; margin: 0 auto; padding: 0;">
<!--[if mso]>
<style type="text/css">

    td { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important; }

</style>
<![endif]-->


<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; line-height: 24px; margin: 0; padding: 0; width: 100%; font-size: 17px; color: #373737; background: #F9F9F9;">
    <tr>
        <td valign="top" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                <tr>
                    <td valign="bottom" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse; padding: 20px 16px 12px;">
                        <div style="text-align: center;">
                            <a href="https://www.slack.com" style="color: #439fe0; font-weight: bold; text-decoration: none; word-break: break-word;">
                                <img src="https://www.gravatar.com/avatar/{{$gravatar}}?d=http://aeroscripts.x10host.com/images/default.jpg&s=450" width="120" height="120" style="-ms-interpolation-mode: bicubic; border-radius:50%; outline: none; text-decoration: none; border: none; margin-left: -1.5rem;">
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td valign="top" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse;">
            <table cellpadding="32" cellspacing="0" border="0" align="center" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: white; border-radius: 0.5rem; margin-bottom: 1rem;">
                <tr>
                    <td width="546" valign="top" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse;">
                        <div style="max-width: 600px; margin: 0 auto;">

                            <div style="background: white; border-radius: 0.5rem; margin-bottom: 1rem;">
                                <h2 style="color: #2ab27b; line-height: 30px; margin-bottom: 12px; margin: 0 0 12px;">Hi there,</h2>


                                <p style="font-size: 17px; line-height: 24px; margin: 0 0 16px;">We sent you a link to easily reset your JRCS Password. This is a one time link meaning that it can only be used once to reset your password before it expires.</p>

                                <p style="font-size: 17px; line-height: 24px; margin: 0 0 16px;">
                                    After you click on the link below it will expire and you will be able to reset your JRCS password.
                                </p>



                                <table width="100%" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                    <tr>
                                        <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse; height: 1rem;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse; height: 1rem; border-top: 1px solid #ECECEC;">&nbsp;</td>
                                    </tr>
                                </table>
                                <div style="padding: 12px 0 4px 0; font-weight: bold; font-size: 21px; line-height: 1.4em; text-align: center;">
                                    {{$title}}
                                </div>

                                <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                    <tr>
                                        <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse; text-align: center; padding: 16px 0; font-size: 17px; line-height: 24px;">
                            </div>
                            <br>
                            <table style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                <tr style="width: 100%;">
                                    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse; width: 100%; text-align: center; padding-top: 7px;">
                                            <span style="display: inline-block; border-radius: 4px; background: #1f8b5f; border-bottom: 2px solid #1f8b5f;">
				<a href="{{$token}}" style="color: white; font-weight: normal; text-decoration: none; word-break: break-word; font-size: 17px; line-height: 24px; border-top: 10px solid; border-bottom: 10px solid; border-right: 22px solid; border-left: 32px solid; background-color: #2ab27b; border-color: #2ab27b; display: inline-block; letter-spacing: 1px; min-width: 80px; text-align: center; border-radius: 4px; text-shadow: 0 1px 1px rgba(0,0,0,0.25);">
					Reset Password
				</a>
			</span>
                                    </td>
                                </tr>
                            </table>
                    </td>
                </tr>
            </table>
            <table width="100%" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                <tr>
                    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse; height: 1rem;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse; height: 1rem; border-top: 1px solid #ECECEC;">&nbsp;</td>
                </tr>
            </table>
            <div style="padding: 12px 0 4px 0; font-weight: bold; font-size: 21px; line-height: 1.4em; text-align: center;">
                Interested in these things from JRCS?
            </div>

            <table width="100%" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                <tr>
                    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse; height: 1rem;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse; height: 1rem; border-top: 1px solid #ECECEC;">&nbsp;</td>
                </tr>
            </table>
            <p style="font-size: 17px; line-height: 24px; margin: 0 0 16px;">Forgotten your password for the team you've already joined? No problem! <a href="https://cop4813group.slack.com/forgot" style="color: #439fe0; font-weight: normal !important; text-decoration: none; word-break: break-word;">We can send you a password reset email</a>.</p>

            <p style="font-size: 17px; line-height: 24px; margin: 0 0 16px;">
                More JRCS Marketing can go here if its necessary <a href="https://slack.com/signin/find" style="color: #439fe0; font-weight: normal !important; text-decoration: none; word-break: break-word;">try a different email</a>, or forge ahead and <a href="https://slack.com/create" style="color: #439fe0; font-weight: normal !important; text-decoration: none; word-break: break-word;">create a new team</a>!
            </p>

            <p style="font-size: 17px; line-height: 24px; margin: 0 0 16px;">Please <a href="mailto:feedback@slack.com" style="color: #439fe0; font-weight: normal !important; text-decoration: none; word-break: break-word;">let us know</a> if you have any other questions or feedback. And thanks for using JRCS!</p>

            <p style="font-size: 17px; line-height: 24px; margin: 0 0 16px;">
                Cheers,
                <br> The team at JRCS
            </p>
            </div>

            </div>
        </td>
    </tr>
</table>
</td>
</tr>
<tr>
    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-top: 1rem; background: white; color: #989EA6;">
            <tr>
                <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse; height: 5px; background-image: url('https://a.slack-edge.com/66f9/img/email-ribbon_@2x.png'); background-repeat: repeat-x; background-size: auto 5px;"></td>
            </tr>
            <tr>
                <td valign="top" align="center" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; border-collapse: collapse; padding: 16px 8px 24px;">
                    <div style="max-width: 600px; margin: 0 auto;">
                        <p style="font-size: 12px; line-height: 20px; margin: 0 0 16px; margin-top: 16px;">
                            Made by <a href="https://slack.com" style="color: #439fe0; font-weight: bold; text-decoration: none; word-break: break-word;">JRCS, Inc</a>
                            <a href="http://jrcs.herokuapp.com" style="color: #439fe0; font-weight: bold; text-decoration: none; word-break: break-word;">Our Website</a>
                            <br><a href="#" style="color: #989EA6; font-weight: normal; text-decoration: none; word-break: break-word; pointer-events: none;">123 Fake Avenue North Jacksonville, Florida 32246</a>
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
</body>

</html>