<div class="server" onclick="javascript:window.location = '/rating/server/<?php echo $server->id ?>';">
    <a href="/rating/server/<?php echo $server->id; ?>"><?php echo $server->title; ?></a><br>
</div>
<div class="form-group has-success has-feedback">
    <input type="text" class="form-control" id="server_<?php echo $server->id ?>"
           value="<?php echo $server->address; ?>">
</div>
<hr>