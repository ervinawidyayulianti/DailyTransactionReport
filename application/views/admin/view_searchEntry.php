<div class="container conbre">
    <ol class="breadcrumb">
        <li class=""><a href='<?php echo base_url() ?>dashbord'>Dashbord</a></li>
        <li class="active">Advance Search</li>
    </ol>
</div>

<div class="container" style="margin-top: -15px; width: 83.5%; padding-bottom: 0; position: relative; background: #f5f5f5; padding: 10px; border-radius: 4px">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="form-inline" role="form" style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 10px;">
                        <div class="form-group">
                            <div class="input-group">
                                <select class="form-control" placeholder="Item name" id='item' name="item">
                                    <?php foreach ($query->result() as $row): ?>
                                    <option value="<?=$row->id ?>"><?=$row->item ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit" id='item-search'><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>                              
                        </div> <!-- form group [rows] -->
                        
                        <div style="display: inline-block" class="pull-right">
                        <div class="form-group">
                            <label>From</label>
                            <input type="text" class="form-control" id='from' placeholder="Start date" name="from">
                        </div><!-- form group [search] -->
                        <div class="form-group">
                            <label>To</label>
                            <input type="text" class="form-control" id='to' placeholder="End date" name="to">                         
                            <button class="btn btn-default" type="submit" id='date-search'><i class="glyphicon glyphicon-search"></i></button>
                        </div> <!-- form group [order by] --> 
                        </div>
                       
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>S. NO.</th><th>Item name</th><th>Weight</th><th>Nug</th><th>Total weight</th><th>Transaction type</th>
                        <th>Date</th><th>Notes</th><th>Action</th>
                    </tr>
                </thead>
                <tbody id='response-table'>
                    <tr><td colspan="9"><h2 style="color: #f5b149">Search your specific transaction here</h2></td></tr>

                </tbody>
            </table>
            
                </div>
        </div>
    </div>
</div>

<script>
$(function() {
$( "#from" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: "yy-mm-dd",
onClose: function( selectedDate ) {
$( "#to" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#to" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: "yy-mm-dd",
onClose: function( selectedDate ) {
$( "#from" ).datepicker( "option", "maxDate", selectedDate );
}
});

// search particular transaction
$("#item-search").on('click', function (e){
    e.preventDefault();
    var item = $("#item").val();
    console.log(item);
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?>dashbord/searchItem',
            data:'q='+item
        }).done(function (data){
            $("#response-table").html(data);
        });
    
});

// search transaction in a range
$("#date-search").on('click', function (e){
    e.preventDefault();
    var from = $("#from").val();
    var to = $("#to").val();
        $.ajax({
            type:'POST',
            url:'<?php echo base_url() ?>dashbord/searchAdvance',
            data:'from='+from+'&to='+to
        }).done(function (data){
            $("#response-table").html(data);
        });
    
});

$("#item").select2({
placeholder: "Select Item",
allowClear: true
});



$('.btn_delete').on('click', function(e) {
        e.preventDefault();
        console.log('clicked on del btn');
        if (confirm('are u sure?')){
            var url = '<?php echo base_url() ?>dashbord/delete_post';
            var data = $(this).attr('db_id');
            $.ajax({
                url: url,
                method: "POST",
                data: 'id=' + data
                }).done(function(data) {
                    window.location.reload();
                });
        }
        else{
            return false;
        }
});

});
</script>