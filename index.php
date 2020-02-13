<?php
    $content=file_get_contents('https://tw.rter.info/capi.php');
    $currency=json_decode($content);
    /*
    * 資料欄位範例
    * { "USDTWD": {"Exrate": 32.403, "Date": "2015-10-28 15:37:00"} }
    * { "美金兌台幣": [現價, UTC date] }
    */
    $USD_A='USDTWD';
    $USD_B='USDUSD';
    $UTC_A=$currency->$USD_A->UTC;
    $UTC_B=$currency->$USD_B->UTC;
    $amount=1;
    $targetAmount=floor(1/$currency->$USD_A->Exrate*$currency->$USD_B->Exrate*10000)/10000;    
?>

<!DOCTYPE html>
<html>

<head>
    <title>EXCHANGE CONVERTER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Font Awesome JS Icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- Custom styles -->
    <link rel="stylesheet" type="text/css" href="./style/indexStyle.css">

    <!-- jQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <!-- Bootstrap.JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>

<body class="bg-dark">
    <!-- Modal -->
    <div class="modal fade" id="nationSelectModal" tabindex="-1" role="dialog" aria-labelledby="nationSelectModal"
        aria-hidden="true">
        <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body bg-light">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <br />
                    <div id="nationOption" class="text-center row">
                        <span class="col-3">
                            <img class="rounded-circle mb-3 shadow" src="./img/taiwan.png" alt="flag_tw" height="60"
                                width="60">
                            <p class="font-small text-gray">Taiwan</p>
                        </span>
                        <span class="col-3">
                            <img class="rounded-circle mb-3 shadow" src="./img/united-states.png" alt="flag_us"
                                height="60" width="60">
                            <p class="font-small text-gray">United States</p>
                        </span>
                        <span class="col-3">
                            <img class="rounded-circle mb-3 shadow" src="./img/japan.png" alt="flag_jp" height="60"
                                width="60">
                            <p class="font-small text-gray">Japan</p>
                        </span>
                        <span class="col-3">
                            <img class="rounded-circle mb-3 shadow" src="./img/china.png" alt="flag_cn" height="60"
                                width="60">
                            <p class="font-small text-gray">China</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->

    <div class="d-flex">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">EXCHANGE CONVERTER</h5>
                <!-- Exchange Converter -->
                <div id="exchangeConverterPanel" class="row container m-0 justify-content-center">
                    <div class="text-center">
                        <img class="rounded-circle mb-3 shadow img-fluid" src="./img/taiwan.png" alt="flag_A"
                            height="60" width="60" data-toggle="modal" data-target="#nationSelectModal">
                        <p class="font-small text-gray"><?php echo $UTC_A?></p>
                        <div>
                            <input id="amount" class="text-center text-dark font-weight-bolder" type="text" size="10"
                                value="<?php echo $amount;?>" />
                        </div>
                    </div>
                    <div class="col-4 text-center text-gray90">
                        <i class="fas fa-exchange-alt fa-4x"></i>
                    </div>
                    <div class="text-center">
                        <img class="rounded-circle mb-3 shadow img-fluid" src="./img/united-states.png" alt="flag_B"
                            height="60" width="60" data-toggle="modal" data-target="#nationSelectModal">
                        <p class="font-small text-gray"><?php echo $UTC_B?></p>
                        <div>
                            <input id="targetAmount" class="text-center text-primary font-weight-bolder" type="text"
                                size="10" value="<?php echo $targetAmount;?>" />
                        </div>
                    </div>
                </div>
                <!-- Exchange Converter End -->
            </div>
        </div>
    </div>

    <script>
    $('#amount').on('input', () => {
        const targetAmount = '<?php echo $targetAmount; ?>';
        $('#targetAmount').val(Math.floor(targetAmount * $('#amount').val() * 10000) / 10000);
    });

    $('#targetAmount').on('input', () => {
        const exrate_A = '<?php echo $currency->$USD_A->Exrate; ?>';
        $('#amount').val(Math.floor(exrate_A * $('#targetAmount').val() * 10000) / 10000);
    });
    </script>
</body>

</html>