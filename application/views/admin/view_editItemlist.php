        
        <div class="container conbre">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().'dashbord'?>">Dashbord</a></li>
            <li class=""><a href="<?php echo base_url().'itemlist'?>">Item List</a></li></li>
            <li class="active">Edit Item</li>
        </ol>
            <div id="ret">
            
            </div>
        </div>
        
        
        <div class="container well" style="margin-top: -15px; width: 83.5%">
	<div class="row clearfix">
		<div class="col-md-12 column">
                    <form class="form-horizontal" role="form" id="editItem" action="<?php echo base_url().'itemlist/do_edit' ?>" method="POST">
                        <?php foreach ($query->result() as $row): ?>  
                        <div class="form-group">
                              <label class="col-sm-3 control-label">Item name</label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" name="item" id="item" value="<?=$row->item?>">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Comment</label>
                              <div class="col-sm-9">
                                  <textarea class="form-control" rows="3" name="comment"><?=$row->comment?></textarea>
                              </div>
                            </div>
                            <input type="hidden" name="id" value="<?=$row->id?>"/>
                            <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-9">
                                  <button type="submit" class="btn btn-success btn-submit" name="submit" id="submit">Submit</button>
                                  <a href="<?php echo base_url().'itemlist'?>" class="btn btn-info">Cancle</a>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        </form>
			
		</div>
             
	</div>
</div>
        
        
       
 <script src="<?php echo base_url() ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
 
 
 <script>
    $(function(){
        $( "#editItem" ).submit(function( event ) {
           event.preventDefault();
            var url = $(this).attr('action');
            console.log(url);
            
            $.ajax({
                url: url,
                data: $("#editItem").serialize(),
                type: $(this).attr('method')
              }).done(function(data) {
                  $('#ret').html(data);
//                  window.location.reload();
//                $('#do_edit_post')[0].reset();
              });
            
        });
    });

</script>
 
    </body>
</html>