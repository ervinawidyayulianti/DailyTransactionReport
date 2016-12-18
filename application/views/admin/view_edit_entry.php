
        
        <div class="container conbre">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().'dashbord'?>">Dashbord</a></li>
            <li class="active">Edit entry</li>
        </ol>
            <div id="ret"></div>
        </div>
        
        
        <div class="container well" style="margin-top: -15px; width: 83.5%">
	<div class="row clearfix">
		<div class="col-md-12 column">
                    <form class="form-horizontal cus-form" id="Edit_transaction" method="POST" action="<?php echo base_url().'dashbord/do_edit' ?>">
                        <?php foreach ($query->result() as $row): ?>  
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2">
                                <label>Select Item:<small>(<?php echo $item_val ?>)</small></label>
                                <select id="name" name="item" class="form-control input-sm">
                                    <option selected="selected" value="<?=$row->item_id ?>"><?php echo $item_val ?></option>
                                <?php foreach ($listquery->result() as $row1): ?>
                                    <option value="<?=$row1->id ?>"><?=$row1->item ?></option>
                                <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Weight</label>  
                                <input id="weight" name="weight" placeholder="placeholder" class="form-control input-sm" type="text" value="<?=$row->weight?>">
                                <span class="help-block">Weight in grams.</span>  
                
                            </td>
                            <td>
                                <label>Nug</label>  
                                <input id="nug" name="nug" placeholder="placeholder" class="form-control input-sm" type="text" value="<?=$row->nug ?>">
                                <span class="help-block">Nug in number like. 1 , 2, 3, 5 etc</span>  
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div>
                                    <label>Transaction type:<small>(<?=ucwords($row->transaction_type)?>)</small></label>  
                                </div>
                                <div class="tran-type">
                                <label>
                                    <input type="radio" checked="checked" value="<?=$row->transaction_type?>" name="transaction_type">
                                    <?=ucwords($row->transaction_type)?>
                                  </label>
                                <label>
                                    <input type="radio" value="<?php  echo $tt = ($row->transaction_type == 'buy') ? 'sale':'buy';?>" name="transaction_type">
                                    <?php echo ucwords($tt) ?>
                                    
                                  </label>
                                </div>
                            </td>
                            
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label>Date:<small>(<?=date('F jS Y',strtotime($row->created))?>)</small></label>
                                <input type="text" id="datepicker" name="date" class="form-control input-sm" value="<?=$row->created?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label>Comment</label>
                                <textarea class="form-control" id="comment" name="comment"><?=$row->comment?></textarea>
                            </td>
                        </tr>
                        <input type="hidden" name="id" value="<?=$row->id?>"/>
                        
                    </table>
                    <div style="padding-left: 10px; padding-bottom: 10px; margin-top: -8px;">
                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                        <a href="<?php echo base_url()?>dashbord" id="cancle" name="cancle" class="btn btn-warning">Cancel</a>                
                    </div>
                        <?php endforeach; ?>
                </form>
			
		</div>
             
	</div>
</div>
        
        
       
 <script src="<?php echo base_url() ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
 
 
 <script>
    $(function(){
        
        $("#Edit_transaction").submit(function( event ) {
           event.preventDefault();
            var url = $(this).attr('action');
            console.log(url);
            
            $.ajax({
                url: url,
                data: $("#Edit_transaction").serialize(),
                type: $(this).attr('method')
              }).done(function(data) {
                  $('#ret').html(data);
//                  window.location.reload();
//                $('#do_edit_post')[0].reset();
              });
            
        });
        
$( "#datepicker" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: "yy-mm-dd",
onClose: function( selectedDate ) {
$( "#to" ).datepicker( "option", "minDate", selectedDate );
}
});
    });

</script>
 
    </body>
</html>