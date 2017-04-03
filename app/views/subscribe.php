<div class="modal fade" id="subscribe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Subscribe</h4>
            </div>
            <div class="model-message">
                    <h5>Будьте в курсе всех событий! Подпишитесь на ежедневные сводки новостей</h5>
            </div>
            <form class="form-horizontal" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-offset-2 col-sm-2 control-label">Email</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName3" class="col-sm-offset-2 col-sm-2 control-label">Name</label>
                        <div class="col-sm-5">
                            <input type="name" class="form-control" name="name" id="inputName3"
                                   placeholder="Name">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    setTimeout(function () {
        $('#subscribe').modal('show')
    }, 15000);

</script>