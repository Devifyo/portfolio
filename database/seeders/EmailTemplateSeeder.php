<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        EmailTemplate::updateOrCreate(
            ['name' => 'contact_form'],
            [
                'subject' => 'New message from {{sender_name}} — via your Folio',
                'body'    => $this->contactFormHtml(),
            ]
        );
    }

    private function contactFormHtml(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>New message — Folio</title>
<!--[if mso]>
<noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
<![endif]-->
</head>
<body style="margin:0;padding:0;background-color:#f0f2f5;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','DM Sans',Helvetica,Arial,sans-serif;-webkit-font-smoothing:antialiased;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0f2f5;padding:48px 16px;">
  <tr>
    <td align="center">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:580px;width:100%;">

        <!-- ═══ HEADER ═══ -->
        <tr>
          <td style="background:linear-gradient(135deg,#1d4ed8 0%,#4f46e5 50%,#7c3aed 100%);border-radius:20px 20px 0 0;padding:40px 48px 36px;text-align:center;">
            <!-- Logo mark -->
            <table role="presentation" cellpadding="0" cellspacing="0" align="center" style="margin-bottom:20px;">
              <tr>
                <td style="width:44px;height:44px;background:rgba(255,255,255,0.15);border-radius:12px;text-align:center;vertical-align:middle;backdrop-filter:blur(8px);">
                  <span style="font-size:20px;line-height:44px;display:block;">⚡</span>
                </td>
                <td style="padding-left:10px;vertical-align:middle;">
                  <span style="font-size:22px;font-weight:800;color:#ffffff;letter-spacing:-0.5px;font-family:Georgia,serif;">Folio</span>
                </td>
              </tr>
            </table>
            <!-- Headline -->
            <h1 style="margin:0;font-size:26px;font-weight:800;color:#ffffff;letter-spacing:-0.5px;line-height:1.2;font-family:Georgia,serif;">
              You've got a new message
            </h1>
            <p style="margin:10px 0 0;font-size:14px;color:rgba(255,255,255,0.72);letter-spacing:0.02em;">
              Someone reached out through your portfolio
            </p>
          </td>
        </tr>

        <!-- ═══ BODY ═══ -->
        <tr>
          <td style="background:#ffffff;padding:40px 48px;">

            <!-- Greeting -->
            <p style="margin:0 0 6px;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;">
              Hey {{portfolio_owner_name}},
            </p>
            <p style="margin:0 0 28px;font-size:16px;color:#1e293b;line-height:1.65;">
              A visitor just sent you a message via your Folio portfolio. Here are the details:
            </p>

            <!-- Topic badge -->
            <table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
              <tr>
                <td style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:99px;padding:5px 14px;">
                  <span style="font-size:12px;font-weight:700;color:#1d4ed8;letter-spacing:0.05em;text-transform:uppercase;">
                    {{topic}}
                  </span>
                </td>
              </tr>
            </table>

            <!-- Message card -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:32px;">
              <tr>
                <td style="background:#f8fafc;border-left:4px solid #2563eb;border-radius:0 14px 14px 0;padding:22px 26px;">
                  <p style="margin:0 0 8px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;">Message</p>
                  <p style="margin:0;font-size:15px;color:#334155;line-height:1.75;white-space:pre-wrap;">{{message}}</p>
                </td>
              </tr>
            </table>

            <!-- Divider -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
              <tr>
                <td style="border-top:1px solid #e2e8f0;font-size:0;line-height:0;">&nbsp;</td>
              </tr>
            </table>

            <!-- Sender info card -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;padding:20px 22px;margin-bottom:32px;">
              <tr>
                <td>
                  <p style="margin:0 0 14px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;">From</p>
                  <table role="presentation" cellpadding="0" cellspacing="0">
                    <tr>
                      <!-- Avatar initial -->
                      <td style="width:46px;height:46px;vertical-align:top;">
                        <div style="width:46px;height:46px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#8b5cf6);text-align:center;line-height:46px;font-size:18px;font-weight:800;color:#ffffff;font-family:Georgia,serif;">
                          {{sender_initial}}
                        </div>
                      </td>
                      <td style="padding-left:14px;vertical-align:middle;">
                        <p style="margin:0;font-size:16px;font-weight:700;color:#0f172a;">{{sender_name}}</p>
                        <p style="margin:4px 0 0;font-size:13px;color:#64748b;">{{sender_email}}</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

            <!-- CTA Button -->
            <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td align="center">
                  <a href="mailto:{{sender_email}}?subject=Re: {{topic}}"
                     style="display:inline-block;background:#0f172a;color:#ffffff;font-size:14px;font-weight:700;padding:15px 36px;border-radius:12px;text-decoration:none;letter-spacing:0.02em;box-shadow:0 4px 14px rgba(15,23,42,0.18);">
                    Reply to {{sender_name}} &rarr;
                  </a>
                </td>
              </tr>
            </table>

          </td>
        </tr>

        <!-- ═══ FOOTER ═══ -->
        <tr>
          <td style="background:#f8fafc;border-top:1px solid #e2e8f0;border-radius:0 0 20px 20px;padding:28px 48px;text-align:center;">
            <p style="margin:0 0 6px;font-size:13px;color:#64748b;">
              Message received via your portfolio at
            </p>
            <a href="{{portfolio_url}}" style="font-size:13px;color:#2563eb;font-weight:600;text-decoration:none;">
              {{portfolio_url}}
            </a>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px;">
              <tr>
                <td style="border-top:1px solid #e2e8f0;padding-top:20px;text-align:center;">
                  <p style="margin:0;font-size:11px;color:#cbd5e1;letter-spacing:0.02em;">
                    Powered by <strong style="color:#94a3b8;font-weight:700;">Folio</strong>
                    &nbsp;&mdash;&nbsp; your portfolio, live in minutes.
                  </p>
                </td>
              </tr>
            </table>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>
HTML;
    }
}
