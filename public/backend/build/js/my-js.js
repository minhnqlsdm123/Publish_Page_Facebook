//hien thi anh upload
function responsive_filemanager_callback(index) {
    var url = $('#' + index).val() + '?v=' + Date.now();
    alert(url);
    $("img#image-preview-" + index).attr("src", url);
    $("source#video-preview-"+index).attr("src", url);
}

//function open popup for filemanager
function open_popup(url) {
    var w = 880;
    var h = 570;
    var l = Math.floor((screen.width - w) / 2);
    var t = Math.floor((screen.height - h) / 2);
    var win = window.open(url, 'Filemanager', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
}
//reset input
function resetInput(id) {
    $('input#' + id).val('/backend/build/images/default.jpg');
    $('#image-preview-' + id).attr('src', '/backend/build/images/default.jpg');
}

$(document).on('click', '.remove-input', function(event) {
    event.preventDefault();
    $(this).parent().parent().parent().remove();
});

//add form upload image
function addImage(object, name, akey) {
    var id = Date.now();
    $(object).before('<div class="row" style="margin-bottom: 15px;"><div class="col-md-2"><img id="image-preview-' + id + '" class="img-fluid" src="/backend/build/images/default.jpg"></div><div class="col-md-8"><input type="text" name="' + name + '[]" id="' + id + '" value="/backend/build/images/default.jpg" class="form-control" /></div><div class="col-md-2"><div class="input-group-append"><button onclick="open_popup(\'/filemanager/dialog.php?type=1&popup=1&field_id=' + id + '&akey=' + akey + '\')" class="btn btn-primary" type="button"><i class="fa fa-cloud-upload"></i> Chọn</button> <button class="btn btn-danger remove-input" data-reset="' + id + '" type="button"><i class="material-icons"><i class="fa fa-trash"></i> Xóa</i></button></div></div></div> ');
}
