<div class="container" style="margin-top: 57px;">
<div class="row">
    <div class="col-md-6">
        <div class="thumbnail btn btn-primary">
            
             <i style="color: #f0ad4e; font-size: 50px;" class="glyphicon glyphicon-refresh"></i>
            <div class="caption">
                <h3>
                    Reset All Transaction
                </h3>
                <p>
                <b> 
                    After reset process all the transaction will be deleted.<br>
                    That will not be reverser in future.<br>
                    We suggest <a href="<?php echo base_url() ?>dashbord/">export excel</a> file before Reset process ! thanks
                </b>
                </p>
                <p>
                    <button class="btn btn-warning reset-tbl" db-table="transaction">RESET</button>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="thumbnail btn btn-primary">
            <i style="color: #f0ad4e; font-size: 50px;" class="glyphicon glyphicon-refresh"></i>
            <div class="caption">
                <h3>
                    Reset All Items
                </h3>
                    <p>
                        <b>  After reset process all the item and also transaction will be deleted.<br>
                            That will not be reverser in future.
                            We suggest <a href="<?php echo base_url() ?>itemlist/">export excel</a><br> and <a href="<?php echo base_url() ?>dashbord/">export transaction</a> file also before Reset process ! thanks
                        </b>
                    </p>
                <p>
                    <button class="btn btn-warning reset-tbl" db-table="item">RESET</button>
                </p>
            </div>
        </div>
    </div>
</div>
    
    <div class="row div-pass" style="display: none">
        <div class="col-md-8 col-md-offset-2">
            <form id="resetForm" action="<?php echo base_url() ?>init/resetTransactionItem" method="POST">
                <label for="password">Enter Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password" id="password"/>
                <input type="hidden" name="tabl" id="tabl" value=""/>
                <input type="submit" value="CONTINUE" class="btn btn-warning btn-block"/>
                <button id="cancle-process" class="btn-block btn btn-primary">CANCEL</button>
            </form>
        </div>
        
    </div>
    <div id="loder" style="text-align: center; padding-top: 50px; display: none">
        <img src="<?php echo base_url() ?>bootstrap/images/loader2.gif" alt="Reseting.."/>
    </div>
    <div id="response" style="padding-top:30px"></div>
</div>

<script>
$(document).ready(function (){
    $("#resetForm").submit(function (e){
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        $("#loder").show();
        $.ajax({
            url:url,
            type:'POST',
            data:data
        }).done(function(data){
           $("#loder").hide();
           $("#response").html(data);
           
        });
    });
    
    $(".reset-tbl").on('click', function (e){
        e.preventDefault();
        var tbl_name = $(this).attr('db-table');
        $("#tabl").val(tbl_name);
        $(".div-pass").slideDown('fast');
    });
    
    $("#cancle-process").click(function (e){
        e.preventDefault();
        $(".div-pass").slideUp('fast');
    });
});
</script>
</body>
</html>
