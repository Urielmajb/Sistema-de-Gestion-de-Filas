<h3>Welcome to Cashier Queuing System</h3>
<hr>
<div class="col-12">
    <div class="col-md-12">
        <?php 
            $vid = scandir('./video');
            $video = $vid[2];
            if($video):
        ?>
            <center><video src="./video/<?php echo $video ?>" autoplay muted controls id="vid_loop" class="bg-dark" loop style="height:50vh;width:75%"></video></center>
        <?php 
            endif; 
        ?>
        <form action="" id="upload-form">
            <input type="hidden" name="video" value="<?php echo $video; ?>">
            <div class="row justify-content-center my-2">
                <div class="form-group col-md-4">
                    <label for="vid" class="control-label">Update Video</label>
                    <input type="file" name="vid" id="vid" class="form-control" accept="video/*" required>
                </div>
            </div>
            <div class="row justify-content-center my-2">
                <center>
                    <button class="btn btn-primary" type="submit">Update</button>
                </center>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        $('#upload-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            _this.find('button').attr('disabled',true)
            _this.find('button[type="submit"]').text('updating video...')
            $.ajax({
                url:'./Actions.php?a=update_video',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                     _this.find('button').attr('disabled',false)
                     _this.find('button[type="submit"]').text('Update')
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        _el.addClass('alert alert-success')
                        location.reload()
                        if("<?php echo isset($department_id) ?>" != 1)
                        _this.get(0).reset();
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                     _this.find('button').attr('disabled',false)
                     _this.find('button[type="submit"]').text('Save')
                }
            })
        })
    })
</script>