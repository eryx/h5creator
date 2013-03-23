<?php

$projbase = H5C_DIR;

if ($this->req->proj == null) {
    die('ERROR');
}
$proj = preg_replace("/\/+/", "/", rtrim($this->req->proj, '/'));
if (substr($proj, 0, 1) == '/') {
    $projpath = $proj;
} else {
    $projpath = "{$projbase}/{$proj}";
}
if (strlen($projpath) < 1) {
    die("ERROR");
}

$ptpath = md5("");

$grps = array();
$glob = $projpath."/dataflow/*.grp.json";
foreach (glob($glob) as $v) {
    $json = file_get_contents($v);
    $json = json_decode($json, true);
    if (!isset($json['id'])) {
        continue;
    }

    $grps[$json['id']] = $json;
}
if (count($grps) == 0) {
    
    $id = hwl_string::rand(8, 2);

    $obj = $projpath ."/dataflow";
    $obj = preg_replace(array("/\.+/", "/\/+/"), array(".", "/"), $obj);
    if (!is_writable($obj)) {
        die("'$obj' is not Writable");
    }

    $obj .= "/{$id}.grp.json";
    $obj = preg_replace(array("/\.+/", "/\/+/"), array(".", "/"), $obj);

    $set = array(
        'id'    => $id,
        'name'  => 'Main',
    );
    hwl_util_dir::mkfiledir($obj);
    file_put_contents($obj, hwl_Json::prettyPrint($set));

    $grps[$id] = $set;
}
?>


<div class="h5c_tab_subnav" style="border-bottom: 1px solid #ddd;">
    <a href="#proj/dataflow/grp-new" class="b0hmqb">
        <img src="/fam3/icons/package_add.png" class="h5c_icon" />
        New Group
    </a>
    <a href="#proj/dataflow/actor-new" class="b0hmqb">
        <img src="/fam3/icons/brick_add.png" class="h5c_icon" />
        New Actor
    </a>
</div>

<div id="pt<?=$ptpath?>" class="h5c_gen_scroll" style="padding-top:10px;"></div>

<div id="_proj_dataflow_grpnew_div" class="hdev-proj-olrcm border_radius_5 displaynone">
    <div class="header">
        <span class="title">New Group</span>
        <span class="close"><a href="javascript:_file_close()">×</a></span>
    </div>
    <div class="sep clearhr"></div>
    <form id="_proj_dataflow_grpnew_form" action="/h5creator/proj/dataflow/grp-new" method="post">
    <input type="hidden" name="proj" value="<?=$proj?>" />
    <div>
        <h5>Name your Group</h5>
        <input type="text" size="30" name="name" class="inputname" value="" />
    </div>
    <div class="clearhr"></div>
    <div><input type="submit" value="Save" class="input_button" /></div>
    </form>
</div>

<div id="_proj_dataflow_actornew_div" class="hdev-proj-olrcm border_radius_5 displaynone">
    <div class="header">
        <span class="title">New Actor</span>
        <span class="close"><a href="javascript:_file_close()">×</a></span>
    </div>
    <div class="sep clearhr"></div>
    <form id="_proj_dataflow_actornew_form" action="/h5creator/proj/dataflow/actor-new" method="post">
    <input type="hidden" name="proj" value="<?=$proj?>" />
    <div>
        <h5>Select a Group</h5>
        <select name='grpid'>
        <?php
        foreach ($grps as $k => $v) {
            echo "<option value='{$k}'>{$v['name']}</option>";
        }
        ?>
        </select>
    </div>
    <div>
        <h5>Name your Actor</h5>
        <input type="text" size="30" name="name" class="inputname" value="" />
    </div>
    <div class="clearhr"></div>
    <div><input type="submit" value="Save" class="input_button" /></div>
    </form>
</div>

<script type="text/javascript">

var _proj = '<?=$proj?>';

$(".b0hmqb").click(function() {

    var uri = $(this).attr('href').substr(1);

    switch (uri) {
    case "proj/dataflow/grp-new":
        _proj_dataflow_grpnew_show();
        break;
    case "proj/dataflow/actor-new":
        _proj_dataflow_actornew_show();
        //h5cDialogOpen('/h5creator/proj/dataflow/actor-new?proj='+ _proj, 700, 450, 
        //    'Dataflow: New Actor', null);
        break;
    }
});

function _proj_dataflow_grpnew_show()
{
    var p = posFetch();
   
    var bw = $('body').width() - 30;
    var bh = $('body').height() - 50;
    var w = $("#_proj_dataflow_grpnew_div").outerWidth(true);
    var h = $("#_proj_dataflow_grpnew_div").height();

    var t = p.top;
    if ((t + h) > bh) {
        t = bh - h;
    }
    var l = p.left;
    if (l > (bw - w)) {
        l = bw - w;
    }
    
    $("#_proj_dataflow_grpnew_div").css({
        top: t+'px',
        left: l+'px'
    }).show(100);
    
    $("#_proj_dataflow_grpnew_div .inputname").focus();
}

function _proj_dataflow_actornew_show()
{
    var p = posFetch();
   
    var bw = $('body').width() - 30;
    var bh = $('body').height() - 50;
    var w = $("#_proj_dataflow_actornew_div").outerWidth(true);
    var h = $("#_proj_dataflow_actornew_div").height();

    var t = p.top;
    if ((t + h) > bh) {
        t = bh - h;
    }
    var l = p.left;
    if (l > (bw - w)) {
        l = bw - w;
    }
    
    $("#_proj_dataflow_actornew_div").css({
        top: t+'px',
        left: l+'px'
    }).show(100);
    
    $("#_proj_dataflow_actornew_div .inputname").focus();
}

$("#_proj_dataflow_actornew_form").submit(function(event) {

    event.preventDefault();
    
    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        timeout: 3000,
        success: function(data) {
            
            if (data == "OK") {
                hdev_header_alert('success', data);
                _proj_dataflow_tabopen('<?=$proj?>', '', 1);
                _file_close();
            } else {
                hdev_header_alert('error', data);
            }
        },
        error: function(xhr, textStatus, error) {
            hdev_header_alert('error', textStatus+' '+xhr.responseText);
        }
    });
});


function _proj_dataflow_tabopen(proj, path, force)
{
    var p = Crypto.MD5(path);

    if (force != 1 && $("#pt"+p).html() && $("#pt"+p).html().length > 1) {
        $("#pt"+p).empty();
        return;
    }
    
    $.ajax({
        type: "GET",
        url: '/h5creator/proj/dataflow/list',
        data: 'proj='+proj+'&path='+path,
        success: function(data) {
            $("#pt"+p).html(data);
            h5cLayoutResize();
        }
    });
}

function _file_close()
{
    $("#_proj_dataflow_grpnew_div .inputname").val('');
    $("#_proj_dataflow_grpnew_div").hide(100);

    $("#_proj_dataflow_actornew_div .inputname").val('');
    $("#_proj_dataflow_actornew_div").hide(100);
}


_proj_dataflow_tabopen('<?=$proj?>', '', 1);


</script>