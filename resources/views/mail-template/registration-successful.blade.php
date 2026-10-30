<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>Pendaftaran berhasil - The Eras Night</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f0fa; color:#241746; font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f4f0fa; padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="width:100%; max-width:600px; background-color:#ffffff; border-radius:20px; overflow:hidden;">
                    <tr>
                        <td style="padding:34px 40px; background-color:#241746; background-image:linear-gradient(135deg,#241746,#49316f); color:#ffffff;">
                            <p style="margin:0 0 18px; color:#e7c982; font-size:12px; font-weight:bold; letter-spacing:3px; text-transform:uppercase;">✦ The Eras Night</p>
                            <h1 style="margin:0; font-family:Georgia, 'Times New Roman', serif; font-size:32px; font-weight:normal; line-height:1.2;">Pendaftaranmu<br>berhasil!</h1>
                            <p style="margin:16px 0 0; color:#e6dff0; font-size:15px; line-height:1.6;">Satu malam penuh musik dan kenangan sudah menantimu.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 40px 12px;">
                            <p style="margin:0 0 10px; color:#645879; font-size:15px;">Hai, <strong style="color:#241746;">{{ $userName }}</strong>!</p>
                            <p style="margin:0; color:#645879; font-size:14px; line-height:1.7;">Terima kasih sudah mendaftar. Berikut ringkasan pendaftaranmu—simpan email ini sebagai referensi.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 40px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #e9e3f1; border-radius:14px;">
                                <tr>
                                    <td style="padding:20px 22px; border-bottom:1px solid #eee9f4;">
                                        <p style="margin:0 0 6px; color:#827894; font-size:11px; font-weight:bold; letter-spacing:1.5px; text-transform:uppercase;">Detail tiket</p>
                                        <p style="margin:0; color:#241746; font-size:18px; font-weight:bold;">{{ $ticketName }}</p>
                                        <p style="margin:6px 0 0; color:#645879; font-size:14px;">{{ $ticketQuantity }} tiket</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:18px 22px; border-bottom:1px solid #eee9f4;">
                                        <p style="margin:0 0 6px; color:#827894; font-size:11px; font-weight:bold; letter-spacing:1.5px; text-transform:uppercase;">Jadwal konser</p>
                                        <p style="margin:0; color:#241746; font-size:15px; font-weight:bold;">{{ $eventDate }}</p>
                                        <p style="margin:6px 0 0; color:#645879; font-size:14px;">Mulai {{ $eventTime }} · Pintu dibuka {{ $doorTime }}</p>
                                        <p style="margin:6px 0 0; color:#645879; font-size:14px;">{{ $venue }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:18px 22px; border-bottom:1px solid #eee9f4;">
                                        <p style="margin:0 0 6px; color:#827894; font-size:11px; font-weight:bold; letter-spacing:1.5px; text-transform:uppercase;">Total</p>
                                        <p style="margin:0; color:#241746; font-size:17px; font-weight:bold;">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:18px 22px;">
                                        <p style="margin:0 0 7px; color:#827894; font-size:11px; font-weight:bold; letter-spacing:1.5px; text-transform:uppercase;">Kode booking</p>
                                        <p style="margin:0; color:#49316f; font-family:'Courier New', monospace; font-size:20px; font-weight:bold; letter-spacing:2px;">{{ $bookingCode }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 40px 30px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#fff8e8; border-radius:10px;">
                                <tr>
                                    <td style="padding:14px 16px; color:#725a2d; font-size:12px; line-height:1.6;">
                                        <strong>Informasi:</strong> Ini adalah konfirmasi pendaftaran simulasi fan-made, bukan tiket masuk atau acara resmi. Simpan kode booking untuk referensi.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:22px 30px; background-color:#f8f6fb; color:#827894; font-size:11px; line-height:1.6;">
                            Dibuat dengan ✦ untuk malam yang tak terlupakan.<br>
                            The Eras Night · Jakarta · 2026
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
