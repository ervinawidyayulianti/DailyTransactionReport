
        <div class="container conbre">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url().'dashbord'?>">Dashbord</a></li>
            <li class="active">Item list</li>
        </ol>
        </div>
        
        
        <div class="container well" style="margin-top: -15px; width: 83.5%; padding-bottom: 15px;">
	<div class="row clearfix">
		<div class="col-md-12 column">
                    <div class="col-sm-4 clearfix">
                        <a id="modal-666931" href="#modal-container-666931" role="button" class="btn btn-default btn-sm" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i>Add New Item</a>&nbsp;
                    </div>
                    <div class="col-sm-6 succ_del clearfix">
                    </div>

                   <hr/>
			<table class="table">
				<thead>
					<tr>
						<th>
							S. NO.
						</th>
						<th>
							Item name
						</th>
						<th>
							Description
						</th>
						<th>
							Created on
						</th>
                                                
                                                <th>
							Action
						</th>
					</tr>
				</thead>
				<tbody><?php $sno = 1; ?>
                                     <?php foreach ($query->result() as $row): ?>
                                    
                                    <tr class="tbl_view">
						<td>
							<?php echo $sno; ?>
						</td>
						<td>
							<?=$row->item ?>
						</td>
						<td>
							<?=$row->comment?>
						</td>
						<td>
							<?php 
                                                        $created = strtotime($row->created);
                                                        echo date('F jS Y', $created )?>
						</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a  db_id ='<?php echo $row->id ?>' href="<?php echo base_url() ?>itemlist/load_edit_view/<?=$row->id?>"  role="button" data-toggle="modal" class="btn btn-default btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
                                                        <a db_id='<?php echo $row->id ?>' href="#delete" class="btn btn-default btn-sm btn_delete" title="Delete"><i class="glyphicon glyphicon-remove"></i></a>
                                                     </div>
                                                    
						</td>
					</tr>
                                        <?php $sno = $sno+1;  endforeach; ?>
					
                                        
                                    
					
				</tbody>
                                   
			</table>
                   <hr style="margin: 0"/>
                   <form action="<?php echo base_url() ?>init/exportItemExcel">
                   <button type="submit" class="btn btn-warning btn-sm pull-left">Export Excel</button>
                   </form>
                   <div class="pull-right" style="text-align: center"><?php echo $this->pagination->create_links();  ?></div>
		</div>
             
	</div>
            
</div>
        
        
        <!-- Add new item Model -->
        

       
        <div class="modal fade" id="modal-container-666931" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Add Item</h4>
                    </div>

                    <div class="modal-body">
                        <div id='ret'></div>
                        
                        <form class="form-horizontal" role="form" id="addItem" action="<?php echo base_url().'itemlist/add_item' ?>" method="POST">
                          <div class="form-group">
                              <label class="col-sm-3 control-label">Item name</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" name="item" id="item" placeholder="Item name">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Comment</label>
                              <div class="col-sm-9">
                                  <textarea class="form-control" rows="3" name="comment" placeholder="Optional"></textarea>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-9">
                                  <button type="submit" class="btn btn-success" name="submit" id="submit">Submit</button>
                              </div>
                            </div>
                          
                        </form>
                    </div>

                    </div>
                    
                </div>

            </div>

        
        
        <!-- Load Edit Model -->             
        
<div class="modal fade" id="edit_model" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
        </div>
    </div>
</div>
       
 
 
 <!--Add item script-->       
 <script>
    $(function(){
        $( "#addItem" ).submit(function( event ) {
           var url = $(this).attr('action');
                $.ajax({
                url: url,
                data: $("#addItem").serialize(),
                type: $(this).attr('method')
              }).done(function(data) {
                  $('#ret').html(data);
//                  window.location.reload();
                $('#addItem')[0].reset();
              });
            event.preventDefault();
        });
    });
</script>

<!--Refresh window when modal close-->
<script>
$("#modal-container-666931").on('hidden.bs.modal', function(e){window.location.reload();});
</script>

<!--Edit enrty script-->
<script>
$('.edit_btn').on('click', function(e) {
        e.preventDefault();
        var data = $(this).attr('db_id');
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type:"POST",
            data:'id='+data
        }).done(function(data){
            
        });
 });
</script>


<a class="confirmLink" href="#"></a>
<div id="dialog" title="Confirmation Required">
  Are you sure about this?
</div>
<script>
$("#dialog").dialog({
      autoOpen: false,
      modal: true
    });


  $(".confirmLink").click(function(e) {
    e.preventDefault();
    var targetUrl = $(this).attr("href");

    $("#dialog").dialog({
      buttons : {
        "Confirm" : function() {
         $(this).dialog("close");
         delfun();
          
        },
        "Cancel" : function() {
          $(this).dialog("close");
          return false;
        }
      }
    });

    $("#dialog").dialog("open");
  });
</script>

<!--Delete enrty script-->
<script>
$('.btn_delete').on('click', function(e) {
        e.preventDefault();
        delid = $(this).attr('db_id');
        $('.confirmLink').trigger('click'); return false;
        });
        
        var delfun = function(){
            var url = '<?php echo base_url() ?>itemlist/delete_item';
            var data = delid
            $.ajax({
                url: url,
                type:"POST",
                data:'id='+data
                }).done(function(data){
                window.location.reload();
                });
        };
        
 
 
</script>
    </body>
</html>