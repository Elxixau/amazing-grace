<!DOCTYPE html>
<html>
<head>
    <title>Tiket Anda</title>
    <style>
            
    /* CSS */
    .button-50 {
    appearance: button;
    background-color: #000;
    background-image: none;
    border: 1px solid #000;
    border-radius: 4px;
    box-shadow: #fff 4px 4px 0 0,#000 4px 4px 0 1px;
    box-sizing: border-box;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    font-family: ITCAvantGardeStd-Bk,Arial,sans-serif;
    font-size: 14px;
    font-weight: 400;
    line-height: 20px;
    margin: 0 5px 10px 0;
    overflow: visible;
    padding: 12px 40px;
    text-align: center;
    text-transform: none;
    touch-action: manipulation;
    user-select: none;
    -webkit-user-select: none;
    vertical-align: middle;
    white-space: nowrap;
    }

    .button-50:focus {
    text-decoration: none;
    }

    .button-50:hover {
    text-decoration: none;
    }

    .button-50:active {
    box-shadow: rgba(0, 0, 0, .125) 0 3px 5px inset;
    outline: 0;
    }

    .button-50:not([disabled]):active {
    box-shadow: #fff 2px 2px 0 0, #000 2px 2px 0 1px;
    transform: translate(2px, 2px);
    }

    @media (min-width: 768px) {
    .button-50 {
        padding: 12px 50px;
    }
    }
    </style>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f4ff; padding: 40px; background-image: url('https://wallpapers.com/images/hd/colorful-doodle-art-deco-ed23easpq4wl4bri.jpg'); background-size: cover; background-position: center;">
    <div style="max-width: 600px; margin: auto; font-family: 'Arial', sans-serif; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
    
        <h2 style="color: #4f46e5; font-size: 24px;">Booking Berhasil!! </h2>
            <p style="font-size: 14px; color: #333;">Hai <strong> {{ $ticket->name }}</strong>, terima kasih telah melakukan booking dan ingin berpartisipasi mengikuti <strong>Amazing Grace</strong>.</p>
            <p style="font-size: 14px; color: #333;">Peluk jauh, <strong> Panitia Amazing Grace KBMK POLNES</strong>.</p>
            
            <!-- HTML !-->
           

            <p style="margin-top: 25px; font-size: 12px;">Scan QR Code berikut saat berada di pintu masuk:</p>
            <div style="text-align: center; ">
                <img src="{{ $qrUrl }}" alt="QR Code" style="margin: 20px 0; max-width: 200px; " />
                <p style="font-size: 14px; color: #555;">{{ $ticket->ticket_id }}</p> 
            </div>
    
        <div style="border-top: 2px dashed #ccc; border-bottom: 2px dashed #ccc; padding: 20px 0; margin-bottom: 30px;">
            <table style="width: 100%; font-size: 15px; color: #333;">
                <tr>
                    <td><strong>Order By</strong></td>
                    <td style="text-align: right;">{{ $ticket->name }}</td>
                </tr>
               
                <tr>
                    <td><strong>Email</strong></td>
                    <td style="text-align: right;">{{ $ticket->email }}</td>
                </tr>
                <tr>
                    <td><strong>Jumlah Seat</strong></td>
                    <td style="text-align: right;"> {{ $ticket->seat_count }}</td>
                </tr>
                <tr>
                    <td><strong>Group Seat</strong></td>
                    <td style="text-align: right;">{{$ticket->seat_group}}</td>
                </tr>
    
            </table>
        </div>

    
        <hr style="margin: 40px 0; border: none; border-top: 1px solid #eee;">
    
        <footer style="text-align: center; color: #888; font-size: 13px;">
            <p>&copy; {{ date('Y') }} Amazing Grace. All rights reserved.</p>
            <p>Jl. Cipto Mangunkusumo Kampus Gn. Lipan Samarinda Seberang</p>
            <p>Email: <a href="mailto:panitiakbmpolnes@gmail.com" style="color: #4f46e5; text-decoration: none;">panitiakbmkpolnes@gmail.com</a></p>
              <div style="margin-top: 20px;">
        <table align="center" cellpadding="10" cellspacing="0">
         
        </table>
    </div>
        </footer>
    </div>
  
</body>
</html>
