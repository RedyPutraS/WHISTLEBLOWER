<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        Whistleblower - PT. Multi Nitrotama Kimia (MNK)
    </title>
</head>
<body style="background: rgb(249, 249, 249);">
    <div class="col-12">
        <table class="body-wrap" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">
            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                <td style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                <td class="container" width="600" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                    <div class="content" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                        <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">
                            <tr style="font-family: 'Roboto', sans-serif; font-size: 14px; margin: 0;">
                                <td class="content-wrap" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;" valign="top">
                                    <meta itemprop="name" content="Confirm Email" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />
                                    <table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                            <td class="content-block" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                                <div style="text-align: center;margin-bottom: 15px;">
                                                    <img src="{{ url('/') }}/assets/dashboard/images/logomnk.png" alt="">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                            <td class="content-block" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;  text-align: center;" valign="top">
                                                <h4 style="font-family: 'Roboto', sans-serif; font-weight: 500; margin-top: 0; margin-bottom: 10px;">
                                                    Notifikasi Laporan No. {{ $complaint->f_noreg }}
                                                </h4>
                                            </td>
                                        </tr>
                                        <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                            <td class="content-block" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;  text-align: center;" valign="top">
                                                <p style="font-size: 19px; margin-bottom: 10px;">
                                                    Status Laporan Saat Ini: 
                                                </p>
                                                <div>
                                                    <span style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: .8125rem; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: .25rem; text-transform: capitalize; background: {{ $complaint->status->s_warna_background }}; color: {{ $complaint->status->s_warna_teks }}; margin: 0; border-style: solid; border-width: 1px; padding: .5rem .9rem;">
                                                        {{ $complaint->status->s_nama }}
                                                    </span>
                                                </div>
                                                <p style="font-size: 13px; margin-top: 10px;">
                                                    Diperbarui pada {{ \Carbon\Carbon::parse($complaint->formulirpengaduan_riwayatterbaru->created_at)->translatedFormat('d M Y H:i') }}
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                            <td class="content-block" style="font-family: 'Roboto', sans-serif; color: #878a99; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; line-height: 1.4em; padding: 0 0 26px; text-align: center;" valign="top">
                                                <p style="font-weight: 600; margin-bottom: 13px;">
                                                    Token laporan: {{ $complaint->f_token }}
                                                </p>
                                                <p style="font-weight: 600; margin-bottom: 13px;">
                                                    {{ $complaint->formulirpengaduan_riwayatterbaru->fr_keterangan }}
                                                </p>
                                                <p style="margin-bottom: 0;">
                                                    Terima kasih telah membuat pengaduan kepada PT. Multi Nitrotama Kimia. <br>
                                                    Anda bisa melacak perkembangan laporan anda dengan mengakses halaman Whistleblower berikut ini.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                            <td class="content-block" itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 22px; text-align: center;" valign="top">
                                                <a href="{{ route('index') }}" itemprop="url" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: .8125rem; color: #FFF; text-decoration: none; font-weight: 400; text-align: center; cursor: pointer; display: inline-block; border-radius: .25rem; text-transform: capitalize; background-color: #002c5b; margin: 0; border-color: #002c5b; border-style: solid; border-width: 1px; padding: .5rem .9rem;">
                                                    Kunjungi Whistleblower
                                                </a>
                                            </td>
                                        </tr>
                                        <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                            <td class="content-block" style="color: #878a99; text-align: center;font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0; padding-top: 5px" valign="top">
                                                <p style="margin-bottom: 10px; margin-top: 10px;">
                                                    Atau masuk melalui link berikut:
                                                </p>
                                                <a href="{{ route('index') }}" target="_blank">
                                                    {{ route('index') }}
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <div style="text-align: center; margin: 25px auto 0px auto;font-family: 'Roboto', sans-serif;">
                            <p style="color: #878a99; line-height: 1.5;">
                                Pesan ini terkirim otomatis oleh sistem. Harap untuk tidak membalas email ini!
                            </p>
                            <p style="font-family: 'Roboto', sans-serif; font-size: 14px;color: #98a6ad; margin: 0px;">
                                2023 Whistleblower PT. Multi Nitrotama Kimia (MNK)
                            </p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <!-- end table -->
    </div>
</body>
</html>