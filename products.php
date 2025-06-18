<?php
session_start();
//session_destroy();
if($_SERVER['REQUEST_METHOD']==='POST'){
    $method='';
    $donation='';
    $currency='';
    $amount=$_POST['amount'];
  //if(isset($_POST['payment_method']) && isset($_POST['radio']) && is_numeric($_POST['radio']) && isset($_POST['q']) && is_numeric($_POST['q'])  && $_POST['radio']>0 && isset($_POST['currency'])){
        //$method=$_POST['payment_method'];
        //$amount=$_POST['radio'];
        $_SESSION['currency']=$_POST['currency'];
        $q=isset($_POST['q'])&& is_numeric($_POST['q']) && $_POST['q']>0?intval($_POST['q']):1;
        //check session 
        if(isset($_SESSION['cart'][$amount])){
            $prev=$_SESSION['cart'][$amount]['q'];
            $_SESSION['cart'][$amount]=['amount'=>$amount,'q'=>$prev+$q];
        }else{
            $_SESSION['cart'][$amount]=['amount'=>$amount,'q'=>$q];
        }

       //go to cart 
     // header('location: cart.php');
    
  }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>products</title>
        <link rel="stylesheet" href="layout/css/style.css" />
    </head>
    <body>
        <?php 
        if(isset($_SESSION['cart'])){
            echo '<a href="cart.php">'.count($_SESSION['cart']).' Go to cart'.'</a>';
        }else{echo '0'; }

        ?>
        <p>Donate now</p>
        <select style='margin-top:3vh' name='payment_method'>
                <option value=''>Choose payment method </option>
                <option value='card'>Card</option>
                <option value='bank'>Bank account</option>
                <option value='mobile'>Mobile wallet </option>
            </select>
        <?php $arr=[
            ['amount'=>20],
            ['amount'=>30],
            ['amount'=>40]
        ] ?>
        
        
            <div class='parent'>
                <?php
                foreach($arr as $item){
                  ?>
                     <div class='bg1'>
                        <form style='margin-top:3vh' action='products.php' method='post'>
                            <input type='hidden' name='amount' value='<?php echo $item['amount']?>'>
                            <div >
                                <span><?php echo $item['amount'] ?></span>
                                <select name='currency'>
                                    <option value='USD'>USD</option>
                                    <option value='EUR'>EUR</option>
                                    <option value='EGP'>EGP</option>
                                </select>
                                <input style='width:3vw' type='number'  name='q' min='1' max='10' placeholder='1' >
                            </div>
                            <button class='block' style='width:90%; margin:auto' type='submit'>OK</button>
                        </form>
                    </div>
                    
                  <?php
                }

                ?>
                
                <!--<div class='bg1'>
                    <input type='radio' name='radio' value='30'>
                    <span>30</span>
                    <select name='currency'>
                        <option value='USD'>USD</option>
                        <option value='EUR'>EUR</option>
                        <option value='EGP'>EGP</option>
                    </select>
                    <input type='number'  name='q' min='1' >
                </div>
                <div class='bg1'>
                    <input type='radio' name='radio' value='40'>
                    <span>40</span>
                    <select name='currency'>
                        <option value='USD'>USD</option>
                        <option value='EUR'>EUR</option>
                        <option value='EGP'>EGP</option>
                    </select>
                    <input type='number'  name='q' min='1' >
                    </div>-->
                    <!--<form action='backend.php?amount=40' method='post'><input type='hidden' name='amount' value='40'><button>click to pay </button></form>-->
                
            </div>

            
           
        <?php
       /* $symbol=$currency==='USD'?'$':($currency==='EUR'?'€':($currency==='EGP'?'L.E':''));
        if($method==='bank'){
            ?><p>pay <?php echo $symbol.$donation ?> to this bank account: DEZ55546676254</p><?php
        }elseif($method==='mobile'){
            ?><p>pay <?php echo $symbol.$donation ?> to this mobile number 0547765398</p><?php
        }*/

        ?>
        <a href='index.php'>pay</a>
        <div class='modal'>modal</div>
    </body>
</html>