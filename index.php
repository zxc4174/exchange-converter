<?php
    $content=file_get_contents('https://tw.rter.info/capi.php');
    $currency=json_decode($content);
    /*
    * 資料欄位範例
    * { "USDTWD": {"Exrate": 32.403, "Date": "2015-10-28 15:37:00"} }
    * { "美金兌台幣": [現價, UTC date] }
    */
    $targetAmount=floor(1/$currency->USDTWD->Exrate*$currency->USDUSD->Exrate*10000)/10000;
    
    if(isset($_POST['currentNation']) && isset($_POST['nextNation'])){
        switch ($_POST['nextNation']){
            case 'taiwan':
                $arr = array ('img'=>'./img/taiwan.png','exrate'=>$currency->USDTWD->Exrate,'utc'=>$currency->USDTWD->UTC);
                echo json_encode($arr);
                break;
            case 'united-states':
                $arr = array ('img'=>'./img/united-states.png','exrate'=>$currency->USDUSD->Exrate,'utc'=>$currency->USDUSD->UTC);
                echo json_encode($arr);
                break;
            case 'japan':
                $arr = array ('img'=>'./img/japan.png','exrate'=>$currency->USDJPY->Exrate,'utc'=>$currency->USDJPY->UTC);
                echo json_encode($arr);
                break;
            case 'china':
                $arr = array ('img'=>'./img/china.png','exrate'=>$currency->USDCNH->Exrate,'utc'=>$currency->USDCNH->UTC);
                echo json_encode($arr);
                break;
            default:
                break;
        }
        exit;
    }
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
                    <div id="nationOption" class="text-center row mt-3">
                        <span class="col-3">
                            <img id="taiwan" class="rounded-circle mb-3 shadow" src="./img/taiwan.png" alt="flag_tw"
                                height="60" width="60">
                            <p class="font-small text-gray">Taiwan</p>
                        </span>
                        <span class="col-3">
                            <img id="united-states" class="rounded-circle mb-3 shadow" src="./img/united-states.png"
                                alt="flag_us" height="60" width="60">
                            <p class="font-small text-gray">United States</p>
                        </span>
                        <span class="col-3">
                            <img id="japan" class="rounded-circle mb-3 shadow" src="./img/japan.png" alt="flag_jp"
                                height="60" width="60">
                            <p class="font-small text-gray">Japan</p>
                        </span>
                        <span class="col-3">
                            <img id="china" class="rounded-circle mb-3 shadow" src="./img/china.png" alt="flag_cn"
                                height="60" width="60">
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
                <h5 class="card-title text-center mb-4">EXCHANGE CONVERTER</h5>
                <!-- Exchange Converter -->
                <div id="exchangeConverterPanel" class="row container m-0 justify-content-center">
                    <div class="text-center">
                        <img id="nation_A" class="rounded-circle mb-3 shadow img-fluid" src="./img/taiwan.png"
                            alt="nation_A" height="60" width="60" data-toggle="modal" data-target="#nationSelectModal">
                        <p id="utc_A" class="font-small text-gray"><?php echo $currency->USDTWD->UTC;?></p>
                        <div>
                            <input id="amount" class="text-center text-dark font-weight-bolder" type="text" size="10"
                                value=1 />
                        </div>
                    </div>
                    <div id="change_icon" class="text-center text-gray90">
                        <i class="fas fa-exchange-alt fa-4x"></i>
                    </div>
                    <div class="text-center">
                        <img id="nation_B" class="rounded-circle mb-3 shadow img-fluid" src="./img/united-states.png"
                            alt="nation_B" height="60" width="60" data-toggle="modal" data-target="#nationSelectModal">
                        <p id="utc_B" class="font-small text-gray"><?php echo $currency->USDTWD->UTC;?></p>
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

    <!-- Copyright -->
    <div class="text-center text-light mt-3">
        <p>Copyright &copy; 2020 BY YUHSIANG LO</p>
    </div>
    <!-- Copyright -->

    <script>
    let exrate_A = '<?php echo $currency->USDTWD->Exrate; ?>';
    let exrate_B = '<?php echo $currency->USDUSD->Exrate; ?>';
    $('input').on('input', (elm) => {
        if (elm.target.id == 'amount') {
            $('#targetAmount').val(Math.floor(1 / exrate_A * exrate_B * elm.target.value * 10000) / 10000);
        } else if (exrate_A == exrate_B) {
            $('#amount').val(elm.target.value);
            $('#targetAmount').val(elm.target.value);
        } else {
            $('#amount').val(Math.floor(1 / exrate_B * exrate_A * elm.target.value * 10000) / 10000);
        }
    });

    let currentNation = "";
    let nextNation = "";
    $('#exchangeConverterPanel img').on('click', (elm) => {
        currentNation = elm.target.id;
        $('#nationSelectModal img').on('click', (flag) => {
            nextNation = flag.target.id;
            $.ajax({
                type: 'post',
                data: {
                    currentNation: elm.target.id,
                    nextNation: flag.target.id
                },
                success: (response) => {
                    // console.log("ajax post success");
                    let jsonData = JSON.parse(response);
                    $('#' + currentNation).attr('src', jsonData.img);
                    if (currentNation === 'nation_A') {
                        $('#utc_A').text(jsonData.utc);
                        exrate_A = jsonData.exrate;
                    } else {
                        $('#utc_B').text(jsonData.utc);
                        exrate_B = jsonData.exrate;
                    }
                    if (exrate_A == exrate_B) {
                        $('#targetAmount').val(1);
                    } else {
                        $('#targetAmount').val(Math.floor(1 / exrate_A * exrate_B * 10000) /
                            10000);
                    }
                    $('#amount').val(1);
                }
            });
        });
    });
    </script>
</body>

</html>