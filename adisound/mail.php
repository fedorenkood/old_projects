<?php
if($_POST['submit']) { 
        $title = substr(htmlspecialchars(trim($_POST['title'])), 0, 1000); 
        $mess =  substr(htmlspecialchars(trim($_POST['mess'])), 0, 1000000); 
}
$name = $_POST['name'];
$phone = $_POST['phone'];
$product = $_POST['product'];
$address = $_POST['mytext'];

$REMOTE_ADDR = $_POST['REMOTE_ADDR'];

$to = "adibass.kiev@gmail.com";
$subject = "наушники Adidas";
$message = "Имя пославшего письмо: $name \nТелефон: $phone\nАдрес: $address\nПродукт:$product\nIP-адрес: $_SERVER[REMOTE_ADDR]";
mail ($to,$subject,$message,"Content-type:text/plain; charset = utf-8") or print "Не могу отправить письмо !!!";
?>
<html>

<head>
<meta http-equiv="refresh" content="5" url="http://adibass.com.ua/" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Adibass</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<link rel="stylesheet" type="text/css" href="css/fonts.css" />


    <!-- Add jQuery library -->
    <script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>

    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="fancybox/source/jquery.fancybox8cbb.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox8cbb.css?v=2.1.5" media="screen" />

    <!-- Add Button helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-buttons3447.css?v=1.0.5" />
    <script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons3447.js?v=1.0.5"></script>

    <!-- Add Thumbnail helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-thumbsf2ad.css?v=1.0.7" />
    <script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbsf2ad.js?v=1.0.7"></script>

    <!-- Add Media helper (this is optional) -->
    <script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-mediac924.js?v=1.0.6"></script>

<script type="text/javascript" src="js/custom.js"></script>

<link rel="stylesheet" href="assets/countdown/jquery.countdown.css" />
<script src="assets/countdown/jquery.countdown.js"></script>

<script type="text/javascript" src="js/jquery.maskedinput.js"></script>


<script type="text/javascript">
    $(document).ready(function() {

        var IE = /*@cc_on ! @*/ false;
        if (!IE) {
            $("#myphone").mask("+38"+"(999) 999-99-99");
            $("#myphone1").mask("+38"+"(999) 999-99-99");
            $("#myphone2").mask("+38"+"(999) 999-99-99");
            $("#myphone3").mask("+38"+"(999) 999-99-99");
        }
    });
</script>

<script type="text/javascript">
        $(document).ready(function() {

            $(".fancybox-effects-d").fancybox({
                padding: 0,

                openEffect : 'elastic',
                openSpeed  : 150,

                closeEffect : 'elastic',
                closeSpeed  : 150,

                closeClick : true,

                helpers : {
                    overlay : null
                }
            });


        });
    </script>




<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
</script>
</head>
<body>

    <div class="order-container">

        <div class="box-block">


            <h2>Спасибо за Ваш запрос....</h2>

           
        </div><!-- end_box-block -->

       
    </div><!-- end_order-container -->
   


</body>
</html>
