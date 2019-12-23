<!-- Jquery & etc -->

<!-- Nestable2 -->
<link href="<?=SITE_ROOT?>assets/css/plugins/nestable2/jquery.nestable.min.css" rel="stylesheet">
<script src="<?=SITE_ROOT?>assets/js/plugins/nestable2/jquery.nestable.min.js"></script>

<?php
function render_menu_item($conn, $id, $label, $url, $open_new_tab) {
    if($open_new_tab==1) {
        $checked = 'checked';
    }
    else {
        $checked = '';
    }
    return '<li class="dd-item dd3-item" data-id="'.$id.'" data-label="'.$label.'" data-url="'.$url.'" data-opennewtab="'.$open_new_tab.'">
        <div class="dd-handle dd3-handle"><i class="fa fa-arrows-alt"></i></div>
        <div class="dd3-content"><span>'.$label.'</span>
            <div class="item-edit"><i class="fa fa-edit text-success"></i></div>
        </div>
        <div class="item-settings d-none">
            <p><label>Label Navigasi<br><input type="text" class="form-control input-sm" name="navigation_label" value="'.$label.'"></label></p>
            <p><label>URL<br><input type="text" class="form-control input-sm" name="navigation_url" value="'.$url.'"></label></p>
            <p><label class="checkbox-inline"><input type="checkbox" id="checkbox_'.$id.'" class="form-control input-sm checkbox" name="navigation_open_new_tab" value="1" '.$checked.'>Buka tautan di tab baru</label></p>
            <p><a class="item-delete text-danger" href="javascript:;">Singkirkan</a> | <a class="item-close text-success" href="javascript:;">Batal</a></p>
        </div>';
}
 
function menu_tree($conn, $parent_id=0) {
    $items = '';
    $query = mysqli_query($conn, "SELECT * FROM menu WHERE parent_id='$parent_id' ORDER BY id_menu ASC") or die("SQL ERROR: ".mysqli_error());
    $jlh = mysqli_num_rows($query);
    if($jlh > 0) {
        $items .= '<ol class="dd-list">';
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
        foreach($result as $row) {
            $items .= render_menu_item($conn, $row['id_menu'], $row['label_menu'], $row['url_menu'], $row['open_new_tab']);
            $items .= menu_tree($conn, $row['id_menu']);
            $items .= '</li>';
        }
        $items .= '</ol>';
    }
    return $items;
}

function update_menu($conn, $menu, $parent=0) {
    if(!empty($menu)) {
        foreach($menu as $value) {
            $label = sanitize($conn, $value['label'], 0);
            $url = (empty($value['url'])) ? '#' : sanitize($conn, $value['url'], 0);
            $open_new_tab = sanitize($conn, $value['opennewtab'], 0);
            mysqli_query($conn, "INSERT INTO menu (label_menu, url_menu, parent_id, open_new_tab) VALUES ('$label', '$url', '$parent', '$open_new_tab')") or die("SQL ERROR: ".mysqli_error());
            $id = mysqli_insert_id($conn);
            if(array_key_exists('children', $value)) {
                update_menu($conn, $value['children'], $id);
            }
        }
    }
}

if(isset($_POST['menu'])) {
    $menu = $_POST['menu'];
    $array_menu = json_decode($menu, true);
    mysqli_query($conn, "DELETE FROM menu") or die("SQL ERROR: ".mysqli_error());
    update_menu($conn, $array_menu);
}
?>

<form id="add-item">
    <input type="text" name="name" placeholder="Name">
    <input type="text" name="url" placeholder="Url">
    <button type="submit">Add Item</button>
</form>

<hr>

<div class="dd" id="nestable">
    <?php
        $html_menu = menu_tree($conn, $parent_id=0);
        echo (empty($html_menu)) ? '<ol class="dd-list"></ol>' : $html_menu;
    ?>
</div>

<hr>

<form method="post">
    <input type="hidden" id="nestable-output" name="menu">
    <button type="submit">Save Menu</button>
</form>

<script>
$(document).ready(function () {
    var updateOutput = function () {
        $('#nestable-output').val(JSON.stringify($('#nestable').nestable('serialize')));
    };
    
    $('#nestable').nestable().on('change', updateOutput);
    
    updateOutput();
    
    $("#add-item").submit(function (e) {
        e.preventDefault();
        id = Date.now();
        var label = $("#add-item > [name='name']").val();
        var url = $("#add-item > [name='url']").val();
        if ((url == "") || (label == "")) return;
        var item =
            '<li class="dd-item dd3-item" data-id="' + id + '" data-label="' + label + '" data-url="' + url + '" data-opennewtab="0">' +
            '<div class="dd-handle dd3-handle"><i class="fa fa-arrows-alt"></i></div>' +
            '<div class="dd3-content"><span>' + label + '</span>' +
            '<div class="item-edit"><i class="fa fa-edit text-success"></i></div>' +
            '</div>' +
            '<div class="item-settings d-none">' +
            '<p><label>Label Navigasi<br><input type="text" class="form-control input-sm" name="navigation_label" value="' + label + '"></label></p>' +
            '<p><label>URL<br><input type="text" class="form-control input-sm" name="navigation_url" value="' + url + '"></label></p>' +
            '<p><label class="checkbox-inline"><input type="checkbox" id="checkbox_' + id + '" class="form-control input-sm checkbox" name="navigation_open_new_tab" value="1">Buka tautan di tab baru</label></p>' +
            '<p><a class="item-delete text-danger" href="javascript:;">Singkirkan</a> | <a class="item-close text-success" href="javascript:;">Batal</a></p>' +
            '<a class="item-close" href="javascript:;">Batal</a></p>' +
            '</div>' +
            '</li>';
        $("#nestable > .dd-list").append(item);
        $("#nestable").find('.dd-empty').remove();
        $("#add-item > [name='name']").val('');
        $("#add-item > [name='url']").val('');
        updateOutput();
    });
    
    $("body").delegate(".item-delete", "click", function (e) {
        $(this).closest(".dd-item").remove();
        updateOutput();
    });
    
    $("body").delegate(".item-edit, .item-close", "click", function (e) {
        var item_setting = $(this).closest(".dd-item").find(".item-settings");
        if(item_setting.hasClass("d-none")) {
            item_setting.removeClass("d-none");
        }
        else {
            item_setting.addClass("d-none");
        }
    });
    
    $("body").delegate("input[name='navigation_label']", "change paste keyup", function (e) {
        $(this).closest(".dd-item").data("label", $(this).val());
        $(this).closest(".dd-item").find(".dd3-content span").text($(this).val());
    });
    
    $("body").delegate("input[name='navigation_url']", "change paste keyup", function (e) {
        $(this).closest(".dd-item").data("url", $(this).val());
    });
    
    $(".checkbox").click(function(e) {
        var id_checkbox = $(this).attr('id');
        var id_list = id_checkbox.split("_");
        id_list = id_list[1];
        if($(this).prop("checked") == true){
            var value = 1;
        }
        else if($(this).prop("checked") == false){
            var value = 0;
        }
        $(this).closest(".dd-item").data("opennewtab", value);
        updateOutput();
    });
    
});
</script>

<style>
/**
 * Nestable Extras
 */
.nestable-lists {
    display: block;
    clear: both;
    padding: 30px 0;
    width: 100%;
    border: 0;
    border-top: 2px solid #ddd;
    border-bottom: 2px solid #ddd;
}

#nestable-menu {
    padding: 0;
    margin: 20px 0;
}

#nestable-output,
#nestable2-output {
    width: 100%;
    height: 7em;
    font-size: 0.75em;
    line-height: 1.333333em;
    font-family: Consolas, monospace;
    padding: 5px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
}

#nestable2 .dd-handle {
    color: #fff;
    border: 1px solid #999;
    background: #bbb;
    background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
    background: -moz-linear-gradient(top, #bbb 0%, #999 100%);
    background: linear-gradient(top, #bbb 0%, #999 100%);
}

#nestable2 .dd-handle:hover {
    background: #bbb;
}

#nestable2 .dd-item > button:before {
    color: #fff;
}

@media only screen and (min-width: 700px) {
    .dd {
        width: 48%;
    }
    .dd + .dd {
        margin-left: 2%;
    }
}

.dd-hover > .dd-handle {
    background: #2ea8e5 !important;
}

.dd-handle {
    padding: 4px 10px 5px 9px;
}

/**
 * Nestable Draggable Handles
 */

.dd3-content {
    display: block;
    height: 30px;
    margin: 5px 0;
    padding: 4px 10px 5px 40px;
    color: #333;
    text-decoration: none;
    font-weight: bold;
    border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background: linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
    border-radius: 3px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
}

.dd3-content:hover {
    color: #2ea8e5;
    background: #fff;
}

.dd-dragel > .dd3-item > .dd3-content {
    margin: 0;
}

.dd3-item > button {
    margin-left: 30px;
}

.dd3-handle {
    position: absolute;
    margin: 0;
    left: 0;
    top: 0;
    cursor: pointer;
    width: 30px;
    /* text-indent: 30px; */
    text-indent: unset;
    white-space: nowrap;
    overflow: hidden;
    border: 1px solid #aaa;
    background: #ddd;
    background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
    background: -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
    background: linear-gradient(top, #ddd 0%, #bbb 100%);
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.dd3-handle:before {
    /* content: '≡'; */
    display: block;
    position: absolute;
    left: 0;
    top: 3px;
    width: 100%;
    text-align: center;
    text-indent: 0;
    color: #fff;
    font-size: 20px;
    font-weight: normal;
}

.dd3-handle:hover {
    background: #ddd;
}

.item-edit {
    font-size: 13px;
    float: right;
    cursor: pointer;
}
.item-edit:hover {
    text-decoration: underline;
}

.item-settings.d-none {
    display: none!important;
}
.item-settings {
    display: block;
    padding: 10px;
    position: relative;
    z-index: 10;
    border: 1px solid #e5e5e5;
    background: #fff;
    border-top: none;
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
}
.item-settings p {
    margin-top: 0;
}

.item-settings p label {
    font-size: 13px;
    font-weight: normal;
    color: #666;
    line-height: 1.5;
    font-style: italic;
}

.item-settings p label input {
    border: 1px solid #ddd;
    box-shadow: inset 0 1px 2px rgba(0,0,0,.07);
    background-color: #fff;
    color: #32373c;
    outline: 0;
    border-spacing: 0;
    width: -webkit-fill-available;
    clear: both;
    margin: 0;
    font-size: 14px;
    padding: 5px;
    border-radius: 0;
    font-style: normal;
}

.item-settings p label input.checkbox {
    width: 15px;
    height: 20px;
}

.item-settings .item-delete, .item-settings .item-close {
    text-decoration: underline;
}
</style>
