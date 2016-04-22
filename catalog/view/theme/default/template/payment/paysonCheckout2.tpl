<?php
if (isset($snippet)){
    $style =   "width:"  . $width . $width_type  . ";"  . "height:"  . $height . $height_type;
    if($status == 'readyToPay'){
        echo $header; 
        echo $column_left; 
        echo $column_right; 
        ?>
        <div class="container"><?php echo $content_top; ?>
            <iframe id='checkoutIframe' name='checkoutIframe' style=<?php echo $style ?> src='<?php echo $snippet ?>'frameborder='0'  scrolling='no'>> </iframe>  
        </div>

        <?php 
        echo $footer;
    }else{ 
        ?>

        <div style=<?php  echo $style; ?>>
        <?php 
            echo $snippet; 
        ?>
        </div> 
        <?php 
    }
}else{ ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo 'Checkout-ID kunde inte hämtas för denna transation.'; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
<?php     
} 
?>