<?php

sleep(2);

session_start();

$nm_company = 'Petani Emas';
$nm_website = 'petaniemas.id';
$slogan_1 = 'Make XAUUSD';
$slogan_2 = '“Your Passive Income”';

$arr_akun = array(
    array("Chaizir", 45885771),
    array("Helmi", 45900748),
    array("Achyar", 45919719),
    array("Ferdi", 45933301),
    array("Syarfuni", 11111111),
);
//print_r($arr_akun);

$emoji_statistik = "&#128202;";
$emoji_dolar_karung = "&#128176;";
$emoji_dolar_kertas = "&#128181;";

if(isset($_POST['login']) && isset($_POST['password'])) {
    if($_POST['password']=='cv') {
        $_SESSION['FINGERPRINT'] = 1;
    }
    else {
        header("HTTP/1.1 401 Unauthorized");
        $error_message = 'Password salah!';
    }
}

if(isset($_GET['logout'])) {
    $_SESSION['FINGERPRINT'] = 0;
}

echo '<!doctype html>
    <html lang="en" data-bs-theme="auto">
    <head>
    <script src="https://getbootstrap.com/docs/5.3/assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>'.$nm_company.' - '.$slogan_1.' '.$slogan_2.'</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="petani-emas.png">
    <meta name="theme-color" content="#712cf9">
    <style>
    body {
        background: linear-gradient(-45deg, #1D1D1F, #3B3130, #B16C04);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
    }
    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
    .gold {
        font-size: 40px;
        text-transform: uppercase;
        line-height:1;
        text-align: center;
        background: linear-gradient(90deg, rgba(186,148,62,1) 0%, rgba(236,172,32,1) 20%, rgba(186,148,62,1) 39%, rgba(249,244,180,1) 50%, rgba(186,148,62,1) 60%, rgba(236,172,32,1) 80%, rgba(186,148,62,1) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;	
        animation: shine 3s infinite;
        background-size: 200%;
        background-position: left;
    }
    @keyframes shine {
        to{background-position: right}
    }
    </style>
    
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
<body class="bg-body-tertiary">
    
    <div class="container">';

    if(isset($_SESSION['FINGERPRINT']) && $_SESSION['FINGERPRINT']==1) {
        // https://www.exchangerate-api.com/docs/php-currency-api
        // Fetching JSON
        $req_url = 'https://v6.exchangerate-api.com/v6/566e96d95041fe3a6a4e0317/latest/USD';
        $response_json = file_get_contents($req_url);
        // Continuing if we got a result
        if(false !== $response_json) {
            // Try/catch for json_decode operation
            try {
                // Decoding
                $response = json_decode($response_json);
                // Check for success
                if('success' === $response->result) {
                    // YOUR APPLICATION CODE HERE, e.g.
                    $IDR_price = round($response->conversion_rates->IDR, 0);
                }
            }
            catch(Exception $e) {
                // Handle JSON parse error...
            }
        }
        
        echo '<style>
        .container {
          max-width: 960px;
        }
        </style>
        <main>
        <div class="py-5 text-center">
          <img class="d-block mx-auto mb-4" src="petani-emas.png" alt="" width="72" height="69">
          <h2 class="gold">'.$nm_company.'</h2>
          <p><a href="?logout" class="link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Logout</a></p>
          <p class="lead">Aplikasi Generator Laporan Portofolio Mingguan "'.$nm_company.'" adalah alat yang memudahkan fund manager dalam membuat laporan mingguan yang komprehensif dan aman, menggunakan data real-time dan personalisasi untuk memberikan informasi investasi yang jelas dan up-to-date kepada klien.</p>
        </div>
    
        <div class="row g-5">
        
          <div class="col-md-5 col-lg-4 order-md-last">
          
            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
              <div class="tradingview-widget-container__widget" style="background:#2B3035;"></div>
              <div class="tradingview-widget-copyright" style="display:none;"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
              <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
              {
              "symbol": "OANDA:XAUUSD",
              "width": "100%",
              "isTransparent": false,
              "colorTheme": "dark",
              "locale": "id"
            }
              </script>
            </div>
            <!-- TradingView Widget END -->
            
            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
              <div class="tradingview-widget-container__widget" style="background:#2B3035;"></div>
              <div class="tradingview-widget-copyright" style="display:none;"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
              <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-timeline.js" async>
              {
              "feedMode": "symbol",
              "symbol": "OANDA:XAUUSD",
              "isTransparent": false,
              "displayMode": "regular",
              "width": "100%",
              "height": "550",
              "colorTheme": "dark",
              "locale": "id"
            }
              </script>
            </div>
            <!-- TradingView Widget END -->
            
          </div>
          
          <div class="col-md-7 col-lg-8 mb-5">
          
            <h4 class="mb-3">Informasi Umum</h4>
            
            <form method="post" action="petani-emas.php">
            
              <div class="row g-3">
                
                <div class="col-sm-6">
                  <label class="form-label">Tanggal Perdagangan</label>';
                  $bln_thn_start = date('F Y', strtotime('last Monday'));
                  $bln_thn_stop = date('F Y', strtotime('last Friday'));
                  if($bln_thn_start==$bln_thn_stop) {
                      $print_tgl = konversi_tanggal('j', date('Y-m-d', strtotime('last Monday')), $bahasa="id")
                      .'-'.konversi_tanggal('j F Y', date('Y-m-d', strtotime('last Friday')), $bahasa="id");
                  }
                  else {
                      $print_tgl = konversi_tanggal('j F Y', date('Y-m-d', strtotime('last Monday')), $bahasa="id")
                      .'-'.konversi_tanggal('j F Y', date('Y-m-d', strtotime('last Friday')), $bahasa="id");
                  }
                  echo '<input type="text" class="form-control" name="tgl" value="'; if(isset($_POST['tgl'])) {echo $_POST['tgl'];} else {echo $print_tgl;} echo '" required>
                  <div class="invalid-feedback">
                    Valid tanggal perdagangan is required.
                  </div>
                </div>
                
                <div class="col-sm-6">
                  <label class="form-label">Kurs Dolar Saat Ini (Live)</label>
                  <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" class="form-control" value="'.number_format($IDR_price, 0).'" disabled>
                  </div>
                </div>
                
                <div class="col-md-12">
                  <label class="form-label">Kondisi Pasar</label>
                  <select class="form-select" name="kondisi" required>
                    <option value="">--- Pilih ---</option>
                    <option value="1"'; if(isset($_POST['kondisi']) && $_POST['kondisi']==1) {echo ' selected';} echo '>Cukup Kondusif (Profit Stabil)</option>
                    <option value="2"'; if(isset($_POST['kondisi']) && $_POST['kondisi']==2) {echo ' selected';} echo '>Kurang Kondusif (Profit Sedikit)</option>
                    <option value="3"'; if(isset($_POST['kondisi']) && $_POST['kondisi']==3) {echo ' selected';} echo '>Berlawanan Arah (Loss)</option>
                  </select>
                  <div class="invalid-feedback">
                    Please select a valid kondisi.
                  </div>
                </div>
              
              <hr class="my-4">';
              
              for($row = 0; $row < count($arr_akun); $row++) {
                $num = $row + 1;
                echo '<h4 class="mb-3">'.$arr_akun[$row][0].' <span class="badge bg-secondary">'.$arr_akun[$row][1].'</span></h4>';
                
                // bisa dikembangkan lagi menggunakan
                // Currency Format Input Field
                // https://codepen.io/559wade/pen/LRzEjj
                echo '<div class="col-sm-6">
                  <label class="form-label">Balance Saat Ini</label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" step="0.01" name="balance_'.$num.'" value="'; if(isset($_POST['balance_'.$num])) {echo $_POST['balance_'.$num];} echo '" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label">Profit Minggu Ini</label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" step="0.01" name="profit_'.$num.'" value="'; if(isset($_POST['profit_'.$num])) {echo $_POST['profit_'.$num];} echo '" required>
                  </div>
                </div>
                <input type="hidden" name="nama_'.$num.'" value="'.$arr_akun[$row][0].'">
                <input type="hidden" name="nomor_'.$num.'" value="'.$arr_akun[$row][1].'">
                <hr class="my-4">';
              }
              
              echo '</div>
              
              <input type="hidden" name="count" value="'.count($arr_akun).'">
              
              <button class="w-100 btn btn-warning btn-lg" id="generate" name="generate" type="submit">Generate Laporan</button>
              
            </form>
            
          </div>
        
        </div>';
        
        if(isset($_POST['generate'])) {
            //echo '<pre>'; print_r($_POST); echo '</pre>'; die();
            //echo '<hr>';
            echo '<div id="laporan" class="row mt-5">';
            if($_POST['kondisi']==1) {
                for($i = 0; $i < $_POST['count']; $i++) {
                    $num = $i + 1;
                    $balance_rupiah = $_POST['balance_'.$num] * $IDR_price;
                    echo '<div class="col-sm-6 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <a class="btn btn-success mb-3" id="btn_'.$_POST['nomor_'.$num].'" data-clipboard-target="#text_'.$_POST['nomor_'.$num].'">Copy ke WA '.$_POST['nama_'.$num].'</a>';
                    echo '<textarea id="text_'.$_POST['nomor_'.$num].'" class="form-control">_*Laporan Mingguan Portofolio*_ '.$emoji_statistik.'
_*Tanggal: '.$_POST['tgl'].'*_
_*Klien: '.$_POST['nama_'.$num].'*_
_*Nomor Akun: '.$_POST['nomor_'.$num].'*_

*1. Ringkasan Kinerja:*
Profit minggu ini sebesar $'.$_POST['profit_'.$num].' '.$emoji_dolar_karung.'

*2. Nilai Portofolio:*
Nilai portofolio Anda saat ini adalah $'.number_format($_POST['balance_'.$num], 2).' atau Rp'.number_format($balance_rupiah, 0).' (kurs dolar Rp'.number_format($IDR_price, 0).') '.$emoji_dolar_kertas.'

*3. Analisis Pasar*
Dalam minggu ini, EA kami telah bekerja dengan sangat baik, didukung oleh kondisi pasar yang cukup kondusif untuk membuka dan mengelola sejumlah posisi dengan efektif.

Terima kasih atas kepercayaannya. Jika ada pertanyaan, jangan ragu untuk menghubungi saya.

Salam,
Achyar Munandar, S.Kom
_Strategy & Fund Manager_</textarea>
<script>
var clipboard_'.$_POST['nomor_'.$num].' = new ClipboardJS("#btn_'.$_POST['nomor_'.$num].'");
clipboard_'.$_POST['nomor_'.$num].'.on("success", function(e) {
    document.getElementById("btn_'.$_POST['nomor_'.$num].'").classList.remove("btn-success");
    document.getElementById("btn_'.$_POST['nomor_'.$num].'").classList.add("btn-outline-secondary");
    document.getElementById("text_'.$_POST['nomor_'.$num].'").remove();
    console.info("Action:", e.action);
    console.info("Text:", e.text);
    console.info("Trigger:", e.trigger);
    e.clearSelection();
    Swal.fire({
        title: "Copied",
        icon: "success",
        timer: 2000,
        showConfirmButton: false
    });
});
clipboard_'.$_POST['nomor_'.$num].'.on("error", function(e) {
    console.error("Action:", e.action);
    console.error("Trigger:", e.trigger);
});
</script>';
                    echo '</div>
                        </div>
                    </div>';
                }
            }
            elseif($_POST['kondisi']==2) {
                for($i = 0; $i < $_POST['count']; $i++) {
                    $num = $i + 1;
                    $balance_rupiah = $_POST['balance_'.$num] * $IDR_price;
                    echo '<div class="col-sm-6 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <a class="btn btn-success mb-3" id="btn_'.$_POST['nomor_'.$num].'" data-clipboard-target="#text_'.$_POST['nomor_'.$num].'">Copy ke WA '.$_POST['nama_'.$num].'</a>';
                    echo '<textarea id="text_'.$_POST['nomor_'.$num].'" class="form-control">_*Laporan Mingguan Portofolio*_ '.$emoji_statistik.'
_*Tanggal: '.$_POST['tgl'].'*_
_*Klien: '.$_POST['nama_'.$num].'*_
_*Nomor Akun: '.$_POST['nomor_'.$num].'*_

*1. Ringkasan Kinerja:*
Profit minggu ini sebesar $'.$_POST['profit_'.$num].' '.$emoji_dolar_karung.'

*2. Nilai Portofolio:*
Nilai portofolio Anda saat ini adalah $'.number_format($_POST['balance_'.$num], 2).' atau Rp'.number_format($balance_rupiah, 0).' (kurs dolar Rp'.number_format($IDR_price, 0).') '.$emoji_dolar_kertas.'

*3. Analisis Pasar*
Berdasarkan analisis yang dijalankan EA kami, pergerakan pasar minggu ini kurang kondusif. Oleh karena itu, EA tidak membuka banyak posisi untuk menjaga modal Anda dengan hati-hati.

Terima kasih atas kepercayaannya. Jika ada pertanyaan, jangan ragu untuk menghubungi saya.

Salam,
Achyar Munandar, S.Kom
_Strategy & Fund Manager_</textarea>
<script>
var clipboard_'.$_POST['nomor_'.$num].' = new ClipboardJS("#btn_'.$_POST['nomor_'.$num].'");
clipboard_'.$_POST['nomor_'.$num].'.on("success", function(e) {
    document.getElementById("btn_'.$_POST['nomor_'.$num].'").classList.remove("btn-success");
    document.getElementById("btn_'.$_POST['nomor_'.$num].'").classList.add("btn-outline-secondary");
    document.getElementById("text_'.$_POST['nomor_'.$num].'").remove();
    console.info("Action:", e.action);
    console.info("Text:", e.text);
    console.info("Trigger:", e.trigger);
    e.clearSelection();
    Swal.fire({
        title: "Copied",
        icon: "success",
        timer: 2000,
        showConfirmButton: false
    });
});
clipboard_'.$_POST['nomor_'.$num].'.on("error", function(e) {
    console.error("Action:", e.action);
    console.error("Trigger:", e.trigger);
});
</script>';
                    echo '</div>
                        </div>
                    </div>';
                }
            }
            elseif($_POST['kondisi']==3) {
                for($i = 0; $i < $_POST['count']; $i++) {
                    $num = $i + 1;
                    $balance_rupiah = $_POST['balance_'.$num] * $IDR_price;
                    echo '<div class="col-sm-6 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <a class="btn btn-success mb-3" id="btn_'.$_POST['nomor_'.$num].'" data-clipboard-target="#text_'.$_POST['nomor_'.$num].'">Copy ke WA '.$_POST['nama_'.$num].'</a>';
                    echo '<textarea id="text_'.$_POST['nomor_'.$num].'" class="form-control">_*Laporan Mingguan Portofolio*_ '.$emoji_statistik.'
_*Tanggal: '.$_POST['tgl'].'*_
_*Klien: '.$_POST['nama_'.$num].'*_
_*Nomor Akun: '.$_POST['nomor_'.$num].'*_

*1. Ringkasan Kinerja:*
Loss minggu ini $'.$_POST['profit_'.$num].' '.$emoji_dolar_karung.'

*2. Nilai Portofolio:*
Nilai portofolio Anda saat ini adalah $'.number_format($_POST['balance_'.$num], 2).' atau Rp'.number_format($balance_rupiah, 0).' (kurs dolar Rp'.number_format($IDR_price, 0).') '.$emoji_dolar_kertas.'

*3. Analisis Pasar*
Meskipun EA kami bekerja dengan baik, kerugian masih bisa terjadi dalam minggu ini karena kondisi pasar yang kurang kondusif dan berlawanan arah. Namun, EA kami akan segera melakukan langkah pemulihan.

Terima kasih atas kepercayaannya. Jika ada pertanyaan, jangan ragu untuk menghubungi saya.

Salam,
Achyar Munandar, S.Kom
_Strategy & Fund Manager_</textarea>
<script>
var clipboard_'.$_POST['nomor_'.$num].' = new ClipboardJS("#btn_'.$_POST['nomor_'.$num].'");
clipboard_'.$_POST['nomor_'.$num].'.on("success", function(e) {
    document.getElementById("btn_'.$_POST['nomor_'.$num].'").classList.remove("btn-success");
    document.getElementById("btn_'.$_POST['nomor_'.$num].'").classList.add("btn-outline-secondary");
    document.getElementById("text_'.$_POST['nomor_'.$num].'").remove();
    console.info("Action:", e.action);
    console.info("Text:", e.text);
    console.info("Trigger:", e.trigger);
    e.clearSelection();
    Swal.fire({
        title: "Copied",
        icon: "success",
        timer: 2000,
        showConfirmButton: false
    });
});
clipboard_'.$_POST['nomor_'.$num].'.on("error", function(e) {
    console.error("Action:", e.action);
    console.error("Trigger:", e.trigger);
});
</script>';
                    echo '</div>
                        </div>
                    </div>';
                }
            }
            echo '</div>
            <script>
            document.getElementById("laporan").scrollIntoView({ behavior: "smooth", block: "start" });
            </script>';
        }
        echo '</main>';
    }
    else {
        echo '<style>
        html,
        body {
          height: 100%;
        }
        body {
          display: flex;
          align-items: center;
          padding-top: 40px;
          padding-bottom: 40px;
          background-color: #f5f5f5;
        }
        .form-signin {
          width: 100%;
          max-width: 330px;
          padding: 15px 15px 0px 15px;
          margin: auto;
        }
        .form-signin .form-floating:focus-within {
          z-index: 2;
        }
        .form-signin input[type="password"] {
          margin-bottom: 10px;
        }
        </style>
        <main class="form-signin">
            <form method="post" class="mt-2" action="petani-emas.php">
            <center><img class="mb-4" src="petani-emas.png" alt="" style=" width: 130px; height: auto; filter: blur(0); -webkit-filter: blur(0); "></center>
            <h1 class="h3 gold text-center mb-3 fw-normal">'.$nm_company.'</h1>';
            if(isset($error_message)) {
                echo '<div class="alert alert-warning">'.$error_message.'</div>';
            }
            echo '<div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password Admin" required>
                <label for="floatingPassword">Password Admin</label>
            </div>
            <button class="btn btn-warning w-100 py-2" name="login" type="submit">Login</button>
            </form>
            
            <div class="text-center fw-bold fst-italic mt-4 mb-4"><small>'.$slogan_1.' <span class="text-warning">'.$slogan_2.'</span></small></div>
            
            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
              <div class="tradingview-widget-container__widget" style="background:#2B3035;"></div>
              <div class="tradingview-widget-copyright" style="display:none;"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
              <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
              {
              "symbol": "OANDA:XAUUSD",
              "width": "100%",
              "isTransparent": false,
              "colorTheme": "dark",
              "locale": "id"
              }
              </script>
            </div>
            <!-- TradingView Widget END -->
            
        </main>';
    }
    
    echo '<footer class="text-body-secondary text-center text-small">
        <p class="mb-3">&copy; '.date('Y').' '.$nm_website.'</p>
        <p class="mb-3"><img src="petani-emas-norton.svg" width="80px"></p>
      </footer>
    </div>
    <script src="https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>';

// Konversi Tanggal
function konversi_tanggal($format, $tanggal="now", $bahasa="id") {
    // ('j-F-Y', $tgl, $bahasa='id_singkat') -> 10-Agu-2020
    // ('j F Y', $tgl, $bahasa='id') -> 10 Agustus 2020
    // ('j-F-Y', $tgl, $bahasa='en_singkat') -> 10-Aug-2020
    // ('j F Y', $tgl, $bahasa='en') -> 10 August 2020
    /*
    d - The day of the month (from 01 to 31)
    D - A textual representation of a day (three letters)
    j - The day of the month without leading zeros (1 to 31)
    l (lowercase 'L') - A full textual representation of a day
    N - The ISO-8601 numeric representation of a day (1 for Monday, 7 for Sunday)
    S - The English ordinal suffix for the day of the month (2 characters st, nd, rd or th. Works well with j)
    w - A numeric representation of the day (0 for Sunday, 6 for Saturday)
    z - The day of the year (from 0 through 365)
    W - The ISO-8601 week number of year (weeks starting on Monday)
    F - A full textual representation of a month (January through December)
    m - A numeric representation of a month (from 01 to 12)
    M - A short textual representation of a month (three letters)
    n - A numeric representation of a month, without leading zeros (1 to 12)
    t - The number of days in the given month
    L - Whether it's a leap year (1 if it is a leap year, 0 otherwise)
    o - The ISO-8601 year number
    Y - A four digit representation of a year
    y - A two digit representation of a year
    a - Lowercase am or pm
    A - Uppercase AM or PM
    B - Swatch Internet time (000 to 999)
    g - 12-hour format of an hour (1 to 12)
    G - 24-hour format of an hour (0 to 23)
    h - 12-hour format of an hour (01 to 12)
    H - 24-hour format of an hour (00 to 23)
    i - Minutes with leading zeros (00 to 59)
    s - Seconds, with leading zeros (00 to 59)
    u - Microseconds (added in PHP 5.2.2)
    e - The timezone identifier (Examples: UTC, GMT, Atlantic/Azores)
    I (capital i) - Whether the date is in daylights savings time (1 if Daylight Savings Time, 0 otherwise)
    O - Difference to Greenwich time (GMT) in hours (Example: +0100)
    P - Difference to Greenwich time (GMT) in hours:minutes (added in PHP 5.1.3)
    T - Timezone abbreviations (Examples: EST, MDT)
    Z - Timezone offset in seconds. The offset for timezones west of UTC is negative (-43200 to 50400)
    c - The ISO-8601 date (e.g. 2013-05-05T16:34:42+00:00)
    r - The RFC 2822 formatted date (e.g. Fri, 12 Apr 2013 12:01:05 +0200)
    U - The seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
    */
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
