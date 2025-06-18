<?php
session_start();
//session_destroy();
$receivedAmount=20;
$receivedCurrency='USD';
//check remove cart item
if (isset($_GET['delete'])) {
   $deleteThis=$_GET['delete'];
   unset($_SESSION['cart'][$deleteThis]);
   //echo '<script>alert("Item deleted")</script>';
   
}

?>
  <!DOCTYPE html>
  <html>
      <head>
          <meta charset="utf-8" />
          <title>cart</title>
          <link rel="stylesheet" href="linkToCSS" />
      </head>
      <body>
        <h2>Cart page</h2>
        <?php
          //check session 
          if(isset($_SESSION['cart'])){
            echo '<a href="cart.php">'.count($_SESSION['cart']).'</a> '.'<span>Items in cart</span>';
          }else{echo '0'; }
          echo '<a href="products.php"> Add more items</a>';

          if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
            
            ?> <table>
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Donation</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody> 
            <?php
            $no=1;
            $total=0;
             foreach($_SESSION['cart'] as $donation=>$quantity){
                      
                   ?> <tr>
                          <td><?php echo $no ?></td>
                          <td class='donation'><?php echo $donation ?></td>
                          <td><button class='minus'>-</button> <span class='quan'><?php echo  $quantity['q'] ?></span> <button class='plus'>+</button></td>
                          <td><?php echo  $donation*$quantity['q'] ?></td>
                          <td><a href='?delete=<?php echo $donation ?>'>delete</a></td>
                      </tr>
             <?php  $no++; $total+= $donation*$quantity['q']; } 
             
             ?>
                  </tbody>
                </table>
                <h2 id='total'><?php echo $total; ?></h2>
                <input type='hidden' id='currency' value='<?php echo $_SESSION['currency']; ?>' >
                <button id='payButton'>Pay</button>
          <?php }else{
           ?>
            <h3>Cart is empty</h3>
            <a href='products.php'>Add more items</a>
           <?php 
          } ?>
          
      </body>
      <script>
        const plus=document.querySelectorAll('.plus');
        const minus=document.querySelectorAll('.minus');
        const total=document.querySelector('#total');
        const currency=document.querySelector('#currency');
        const payButton=document.querySelector('#payButton');

        //increment
        plus.forEach((e)=>{
              e.onclick=function(){
                //get its value
              let prevQuatity=Number(this.previousElementSibling.textContent);
              let newQuatity= prevQuatity+1;
              this.previousElementSibling.textContent=newQuatity;
               //get donation from parent's previous sibling
               let donation=Number(this.parentElement.previousElementSibling.textContent);
               //add subtotal(donation*newQuatity) in parent's next sibling
               this.parentElement.nextElementSibling.textContent=donation*newQuatity;
               //get old total
               let oldTotal=Number(total.textContent);
               //remove old subtotal(donation*prevQuatity) & add new subtotal(donation*newQuatity)
               let newTotal=oldTotal-(donation*prevQuatity)+(donation*newQuatity);
               //update new total
               total.textContent=newTotal;
            };
        });
        //decrement
        minus.forEach((e)=>{
              e.onclick=function(){
              let prevQuatity=Number(this.nextElementSibling.textContent);
              if(prevQuatity>1){
                let newQuatity= prevQuatity-1;
              this.nextElementSibling.textContent=newQuatity;
              //get donation from parent's previous sibling
              let donation=Number(this.parentElement.previousElementSibling.textContent);
               //add subtotal(donation*newQuatity) in parent's next sibling
               this.parentElement.nextElementSibling.textContent=donation*newQuatity;
               //get old total
               let oldTotal=Number(total.textContent);
               //remove old subtotal(donation*prevQuatity) & add new subtotal(donation*newQuatity)
               let newTotal=oldTotal-(donation*prevQuatity)+(donation*newQuatity);
               //update new total
               total.textContent=newTotal;
              }
            };
        });
        //payButton
        payButton.onclick=function(){
          location.href='backend.php?amount='+Number(total.textContent)+'&currency='+currency.value+'';
        }

        
        
      </script>
  </html>
  <?php
 