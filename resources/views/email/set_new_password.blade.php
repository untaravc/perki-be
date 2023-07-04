<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <!-- TODO: Change this title -->
    <title>Set New Password - Perki Jogja</title>
    <style>
        /* -------------------------------------
            GLOBAL RESETS
        ------------------------------------- */

        /*All the styling goes here*/

        img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
        }

        body {
            background-color: #f6f6f6;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%;
        }

        table td {
            font-family: sans-serif;
            font-size: 14px;
            vertical-align: top;
        }

        /* -------------------------------------
            BODY & CONTAINER
        ------------------------------------- */

        .body {
            background-color: #f6f6f6;
            width: 100%;
        }

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            display: block;
            margin: 0 auto !important;
            /* makes it centered */
            max-width: 580px;
            padding: 10px;
            width: 580px;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            max-width: 580px;
            padding: 10px;
        }

        /* -------------------------------------
            HEADER, FOOTER, MAIN
        ------------------------------------- */
        .main {
            background: #ffffff;
            border-radius: 4px;
            width: 100%;
        }

        .wrapper {
            box-sizing: border-box;
            padding: 20px;
        }

        .content-block {
            padding-bottom: 10px;
            padding-top: 10px;
        }

        .footer {
            clear: both;
            margin-top: 10px;
            text-align: center;
            width: 100%;
        }

        .footer td,
        .footer p,
        .footer span,
        .footer a {
            color: #999999;
            font-size: 12px;
            text-align: center;
        }

        /* -------------------------------------
            TYPOGRAPHY
        ------------------------------------- */
        h1,
        h2,
        h3,
        h4 {
            color: #231f20;
            font-family: sans-serif;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
        }

        h1 {
            font-size: 20px;
            line-height: 24px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        h2 {
            font-size: 16px;
            line-height: 22.4px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        p,
        ul,
        ol {
            font-family: sans-serif;
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 15px;
            color: #575d64;
        }

        p li,
        ul li,
        ol li {
            list-style-position: inside;
            margin-left: 5px;
            color: #575d64;
        }

        a {
            color: #243776;
            text-decoration: none;
        }

        /*
          Table Event
        */
        .event table {
            box-sizing: border-box;
            width: 100%;
        }

        .event-layout tbody tr td {
            padding-bottom: 16px;
        }

        .event table td {
            background-color: #ffffff;
            color: #575d64;
        }

        .event table tr td:first-child {
            width: 30%;
        }

        .event a {
            color: #575d64;
            text-decoration: underline;
        }

        /*
          Table transaction
        */
        .transaction table {
            box-sizing: border-box;
            width: 100%;
        }

        .transaction table td {
            background-color: #ffffff;
            color: #575d64;
            padding-bottom: 16px;
        }

        .transaction table tr td:first-child {
            width: 30%;
        }

        .transaction table tr td:last-child {
            width: 70%;
        }

        .transaction a {
            color: #575d64;
            text-decoration: underline;
        }

        /*
          Table payment method
        */
        .payment-method table {
            box-sizing: border-box;
            width: 100%;
            background-color: #eff0f6;
            padding: 24px;
            margin-top: 24px;
            margin-bottom: 24px;
        }

        .payment-method table td {
            color: #575d64;
            padding-bottom: 16px;
        }

        .payment-method table tr:last-child td {
            padding-bottom: 0px;
        }

        .payment-method table tr td:first-child {
            width: 30%;
        }

        .payment-method a {
            color: #575d64;
            text-decoration: underline;
        }

        /*
          Table payment
        */
        .payment table {
            box-sizing: border-box;
            width: 100%;
        }

        .payment table td {
            background-color: #ffffff;
            color: #575d64;
            padding-bottom: 16px;
        }

        .payment table tr td:first-child {
            width: 30%;
        }

        .payment table tr td:last-child {
            width: 70%;
            text-align: right;
        }

        .payment a {
            color: #575d64;
            text-decoration: underline;
        }

        /* -------------------------------------
            BUTTONS
        ------------------------------------- */
        .btn {
            box-sizing: border-box;
            width: 100%;
        }

        .btn > tbody > tr > td {
            padding-bottom: 15px;
        }

        .btn table {
            width: auto;
        }

        .btn table.full-width {
            width: 100%;
        }

        .btn table td {
            background-color: #ffffff;
            border-radius: 4px;
            text-align: center;
        }

        .btn a {
            background-color: #ffffff;
            border: solid 1px #243776;
            border-radius: 4px;
            box-sizing: border-box;
            color: #243776;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            padding: 12px 25px;
            text-decoration: none;
            text-transform: capitalize;
        }

        .btn a.full-width {
            width: 100%;
        }

        .btn-primary table td {
            background-color: #243776;
        }

        .btn-primary-outline table td {
            background-color: #ffffff;
        }

        .btn-primary a {
            background-color: #243776;
            border-color: #243776;
            color: #ffffff;
        }

        .btn-primary-outline a {
            background-color: #ffffff;
            border-color: #243776;
            color: #243776;
        }

        /* Logo */
        .logo {
            margin-bottom: 24px;
        }

        /* -------------------------------------
            OTHER STYLES THAT MIGHT BE USEFUL
        ------------------------------------- */
        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .align-center {
            text-align: center;
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .clear {
            clear: both;
        }

        .mt0 {
            margin-top: 0;
        }

        .mb0 {
            margin-bottom: 0;
        }

        .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0;
        }

        .powered-by a {
            text-decoration: none;
        }

        hr {
            border: 0;
            border-bottom: 1px solid #f6f6f6;
            margin: 20px 0;
        }

        /* -------------------------------------
            RESPONSIVE AND MOBILE FRIENDLY STYLES
        ------------------------------------- */
        @media only screen and (max-width: 620px) {
            table.body h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }

            table.body p,
            table.body ul,
            table.body ol,
            table.body td,
            table.body span,
            table.body a {
                font-size: 16px !important;
            }

            table.body .wrapper,
            table.body .article {
                padding: 10px !important;
            }

            table.body .content {
                padding: 0 !important;
            }

            table.body .container {
                padding: 0 !important;
                width: 100% !important;
            }

            table.body .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }

            table.body .btn table {
                width: 100% !important;
            }

            table.body .btn a {
                width: 100% !important;
            }

            table.body .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }
        }

        /* -------------------------------------
            PRESERVE THESE STYLES IN THE HEAD
        ------------------------------------- */
        @media all {
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

            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }

            #MessageViewBody a {
                color: inherit;
                text-decoration: none;
                font-size: inherit;
                font-family: inherit;
                font-weight: inherit;
                line-height: inherit;
            }

            .btn-primary table td:hover {
                background-color: #243776 !important;
            }

            .btn-primary-outline table td:hover {
                background-color: #243776 !important;
                color: #ffffff;
            }

            .btn-primary table td:hover a {
                background-color: #243776 !important;
            }

            .btn-primary-outline table td:hover a {
                background-color: #243776 !important;
                color: #ffffff;
            }

            .btn-primary a:hover {
                background-color: #243776 !important;
                border-color: #243776 !important;
            }

            .btn-primary-outline a:hover {
                background-color: #243776 !important;
                border-color: #243776 !important;
                color: #ffffff;
            }
        }

        /* simple utility */
        /* color */
        .text-primary {
            color: #243776;
        }

        .pb-0 {
            padding-bottom: 0px !important;
        }

        .pb-4 {
            padding-bottom: 16px !important;
        }

        .pb-6 {
            padding-bottom: 24px !important;
        }

        .mb-0 {
            margin-bottom: 0px !important;
        }

        .mb-4 {
            margin-bottom: 16px !important;
        }

        .mb-6 {
            margin-bottom: 24px !important;
        }
    </style>
</head>
<body>
<!-- TODO: Change this title -->
<!-- This is preheader text. Some clients will show this text as a preview. -->
<table
    role="presentation"
    border="0"
    cellpadding="0"
    cellspacing="0"
    class="body"
>
    <tr>
        <td>&nbsp;</td>
        <td class="container">
            <div class="content">
                <!-- START CENTERED WHITE CONTAINER -->
                <table role="presentation" class="main">
                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper">
                            <table
                                role="presentation"
                                border="0"
                                cellpadding="0"
                                cellspacing="0"
                            >
                                <tr>
                                    <td>
                                        <table
                                            role="presentation"
                                            border="0"
                                            cellpadding="0"
                                            cellspacing="0"
                                            class="logo"
                                        >
                                            <tbody>
                                            <tr>
                                                <td align="center">
                                                    <table
                                                        role="presentation"
                                                        border="0"
                                                        cellpadding="0"
                                                        cellspacing="0"
                                                    >
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <img
                                                                    src="https://perki-jogja.com/wp-content/uploads/2022/06/Logo-Perki-Jogja-2.png"
                                                                    alt="Useful alt text"
                                                                    height="36"
                                                                    style="
                                                                        border: 0;
                                                                        outline: none;
                                                                        text-decoration: none;
                                                                        display: block;
                                                                      "
                                                                />
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <h1>Set New Password</h1>
                                        <!-- TODO: Change this name -->
                                        <p>Hello <strong>{{$user['name']}}</strong></p>
                                        <p class="mb-0">
                                            Anda telah meminta melakukan pembaruan password.
                                            <br>
                                            Klik konfirmasi Reset Password,
                                            <br>
                                            Silakan <b>perbarui password</b> setelah berhasil login.
                                        </p>

                                        <table
                                            style="margin-top: 20px; margin-bottom: 20px; width: 100%; text-align: center"
                                            role="presentation"
                                            border="0"
                                            cellpadding="0"
                                            cellspacing="0"
                                            class="payment-method">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <a target="_blank"
                                                       href="https://jcu.perki-jogja.com/reset-password?email={{$user['email']}}&token={{$user['forgot_password_token']}}"
{{--                                                       href="http://localhost:5173/reset-password?email={{$user['email']}}&token={{$user['forgot_password_token']}}"--}}
                                                       style="background-color: darkblue;
                                                    text-decoration: none;
                                                    border-radius: 100px;
                                                    color: white; padding: 10px 25px">
                                                        Konfirmasi Reset Password
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <p class="mb-0">
                                            Get Special Room Prices for JCU 2023 participants.
                                            For more detailed information

                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- END MAIN CONTENT AREA -->
                </table>
                <!-- END CENTERED WHITE CONTAINER -->
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>
