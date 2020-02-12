<?php
    $content=file_get_contents('https://tw.rter.info/capi.php');
    $currency=json_decode($content);
    /*
    * 資料欄位範例
    * { "USDTWD": {"Exrate": 32.403, "Date": "2015-10-28 15:37:00"} }
    * { "美金兌台幣": [現價, UTC date] }
    */
    $amount=$currency->USDTWD->Exrate;
    $targetAmount=floor(1/$currency->USDTWD->Exrate*10000)/10000;    
?>

<!DOCTYPE html>
<html>

<head>
    <title>exchange</title>
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
    <div class="d-flex">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">EXCHANGE CONVERTER</h5>
                <!-- Exchange Converter -->
                <div id="exchangeConverterPanel" class="row container m-0 justify-content-center">
                    <div class="text-center">
                        <img class="rounded-circle mb-3 shadow" src="./img/taiwan.png" alt="flag_tw" height="60"
                            width="60">
                        <div>
                            <input id="amount" class="text-center text-dark font-weight-bolder" type="text" size="10"
                                value="1" />
                        </div>
                    </div>
                    <div class="col-4 text-center text-gray90">
                        <i class="fas fa-exchange-alt fa-4x"></i>
                    </div>
                    <div class="text-center">
                        <img class="rounded-circle mb-3 shadow" src="./img/united-states.png" alt="flag_us" height="60"
                            width="60">
                        <div>
                            <input id="targetAmount" class="text-center text-primary font-weight-bolder" type="text"
                                size="10" value="<?php echo $targetAmount;?>" />
                        </div>
                    </div>
                </div>
                <!-- Exchange Converter End -->

                <!-- Exchange List -->
                <ul class="list-group">
                    <?php
                        foreach($currency as $key => $value ){
                            echo '<li class="list-group-item list-group-item-success">'.$key.' : '.$currency->$key->Exrate.'</li>';
                        }
                    ?>
                </ul>
                <!-- Exchange List End -->
            </div>
            <div class="card-footer">
                <button type="button" class="btn" id="left-panel-link">Register</button>
                <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal1"
                    id="right-panel-link">
                    Learn More
                </button>
            </div>
        </div>
    </div>

    <script>
    function errorAlert() {
        alert('Input Type Error : Only Number ');
        $('#amount').val(1);
        $('#targetAmount').val('<?php echo $targetAmount; ?>');
    }

    $('#amount').on('input', () => {
        // Error : 正規化失敗
        if ($('#amount').val().match(/^\d*/)) {
            const targetAmount = '<?php echo $targetAmount; ?>';
            $('#targetAmount').val(Math.floor(targetAmount * $('#amount').val() * 10000) / 1000);
        }
        errorAlert();
    });

    $('#targetAmount').on('input', () => {
        const amount = '<?php echo $amount; ?>';
        $('#amount').val(Math.floor(amount * $('#targetAmount').val() * 10000) / 1000);
    });
    </script>
</body>

</html>