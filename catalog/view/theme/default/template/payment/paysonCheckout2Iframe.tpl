<?php
echo $header; 
echo $column_left; 
echo $column_right; 
if (isset($snippet)){
    $style =   "width:"  . $width . $width_type  . ";"  . "height:"  . $height . $height_type;
    if($status == 'readyToPay'){
?>
        <div class="container"><?php echo $content_top; ?>
            <iframe id='checkoutIframe' name='checkoutIframe' style=<?php echo $style ?> src='<?php echo $snippet ?>'frameborder='0'  scrolling='no'>> </iframe>  
        </div>
<?php 
    }else{ 
?>

        <div style=<?php  echo $style; ?>>
<?php 
            echo $snippet; 
?>
        </div> 
<?php 
    }
}else{ 
?>
    <div class="container"><?php echo $content_top; ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_checkout_id; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    </div>
<?php     
} 
echo $footer;
?>