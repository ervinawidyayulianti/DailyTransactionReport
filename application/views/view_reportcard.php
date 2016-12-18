<div class="container" style="margin-top: 53px;">
            <div class="col-md-12">
                <a href="#" class="cus-icon pull-left"><img id='back' src='<?php echo base_url() ?>bootstrap/images/icon/back.png'/></a>
            
                <div id="report-response" style="padding-left:12%">
                <div id="loader" style="text-align: center; margin-left: 30%; margin-top: 15%; display: none; position: absolute; z-index: 9999 ">
                    <img src="<?php echo base_url()?>bootstrap/images/loader2.gif" alt="loading.."/>&nbsp;&nbsp;<b>Loading data..</b>
                </div>
                    
                    <table class="metro table">
                        <thead>
                        <tr><td colspan="6" style="padding: 0px;"><span class="table-heading"><?php echo $item ?> - transaction report</span></td></tr>
                        </thead>
                        <thead>
                            <tr><th>SNO</th><th>price<small><sub>(IDR)</sub></small></th><th>QUANTITY</th><th>TOTAL price<small><sub>(IDR)</sub></small></th><th>TYPE</th><th>DATE</th></tr>
                        </thead>
                        <tbody>
                       <?php 
                       if(count($query->result())>0)
                       {$srno = 0;
                       foreach ($query->result() as $row){
                          $srno = $srno+1;
                          $created = strtotime($row->created);
                          $created =  date(' j F Y', $created );
                        echo'<tr><td>'.$srno.'</td><td>'.$row->price.'</td><td>'.$row->nug.'</td><td>'.$row->total_price.'</td><td>'.$row->transaction_type.'</td><td>'.$created.'</td></tr>';
                        }
                       }
                       else{
                           echo'<tr><td colspan="5" style="color:#3498db"><h2>No record found</h2></td></tr>';
                       }
                        echo '</tbody>';
                        ?>
                </table>
                    <div id="result" style="width: 100%; background: #F8F8F8; padding:12px;">
                        <i class="glyphicon glyphicon-print print" title="print" style="cursor: pointer"></i>&nbsp;&nbsp;<strong>Remaining stock</strong>&nbsp;&nbsp;&nbsp;
                        <span class="spntext">Total Quantity: <?php echo $quantity ?><small><sub>(piece)</sub></small></span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="spntext">Total price: <?php echo $price ?><small><sub>(IDR)</sub></small></span>&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
            </div>
            </div>
            
        </div>

<script>
$(document).ready(function (){
    $("#back").on('click', function (e){
    e.preventDefault();
    window.history.back();
    });
    
    $(".print").click(function (){
        window.print();
    });
});
</script>

<style>
    .spntext{
        font-size:18px; text-transform:uppercase; font-price:bold; color: #3498db;
    } 
    .spanval{
        
    }
</style>