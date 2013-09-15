<?php

use LessPHP\User\Session;

if (!Session::IsLogin()) {
    die("Access denied. <a href='/user'>Login</a>");
}
$lcinfo = file_get_contents(LESSCREATOR_DIR ."/lcproject.json");
$lcinfo = json_decode($lcinfo, true);
?>

<table id="hdev_header" width="100%">
  <tr>
    <td width="10px"></td>

    <td class="header_logo" width="380px">
      <img class="lc_icon" src="/lesscreator/static/img/for-test/less-logo-100.png" />
      <span class="title">Creator</span>
      <span class="version"><?php echo $lcinfo['version']?></span>      
    </td>

    <td align="right">
        <div class="hdev-header-alert border_radius_5 hdev_alert"></div>
    </td>

    <td align="right">

        <a class="btn btn-small" href="#launch" onclick="lcProjLaunch()">
            <i class="icon-play-circle"></i> 
            &nbsp;&nbsp;Launch&nbsp;&nbsp;
        </a>

        <div class="btn-group" >
            
            <div class="btn dropdown-toggle btn-small" data-toggle="dropdown" href="#">
                <i class="icon-folder-open"></i>
                &nbsp;&nbsp;Project&nbsp;&nbsp;
                <span class="caret" style="margin-top:8px;"></span>
            </div>
            <ul class="dropdown-menu pull-right text-left">
                <li><a href="javascript:lcProjNew()">Create Project</a></li>
                <li><a href="javascript:lcProjOpen()">Open Project</a></li>
            </ul>

        </div>
        
        <div class="btn-group" style="margin-left:0;">
            <div class="btn dropdown-toggle btn-small" data-toggle="dropdown" href="#">
                <i class="icon-user"></i>&nbsp;&nbsp;<?php echo Session::Instance()->uname?>&nbsp;&nbsp;<b class="caret"></b>
            </div>
            <ul class="dropdown-menu pull-right text-left">
                <?php
                $menus = Session::NavMenus('ue'); // TODO
                $prev = false;
                foreach ($menus as $menu) {
                    echo "<li><a href=\"/{$menu->projid}\">{$menu->name}</a></li>";
                    $prev = true;
                }                
                if ($prev) {
                    echo '<li class="divider"></li>';
                }                
                ?>                    
                <li><a href="/user/logout">Logout</a></li>
            </ul>                    
        </div>

        <a class="btn btn-small btn-inverse" href="http://git.oschina.net/eryx/lesscreator/issues/new" target="_blank">
            <img src="/lesscreator/static/img/proj/bug0-16.png" class="h5c_ico " /> 
            &nbsp;&nbsp;Report Issue&nbsp;&nbsp;
        </a>

    </td>

    <td width="10px"></td>
  </tr>
</table>

<table id="hdev_layout" border="0" cellpadding="0" cellspacing="0" class="">
  <tr>
    <!--
    http://www.daqianduan.com/jquery-drag/
    -->
    <td width="10px"></td>
   
    <td id="h5c-lyo-col-t" valign="top">
      <table width="100%" height="100%">
        <tr>
          <td id="h5c-tablet-framet0" class="hdev-layout-container" valign="top">
            
            <div id="h5c-tablet-tabs-framet0" class="h5c_tablet_tabs_frame ">
              <div class="h5c_tablet_tabs_lm">
                <div id="h5c-tablet-tabs-t0" class="h5c_tablet_tabs"></div>
              </div>
              <div class="h5c_tablet_tabs_lr">
                <div class="pgtab_more" onclick="h5cTabletMore('t0')"></div>
              </div>
            </div>

            <div id="h5c-tablet-body-t0" class="h5c_tablet_body less_scroll"></div>

          </td>
        </tr>

        <tr><td height="10px" id="h5c-resize-rowt0" class="h5c_resize_row hide"></td></tr>
        
        <tr>
          <td id="h5c-tablet-framet1" class="hdev-layout-container hide" valign="top">
            
            <div id="h5c-tablet-tabs-framet1" class="h5c_tablet_tabs_frame pgtabs_frame">
              <div class="h5c_tablet_tabs_lm">
                <div id="h5c-tablet-tabs-t1" class="h5c_tablet_tabs"></div>
              </div>
              <div class="h5c_tablet_tabs_lr">
              </div>
            </div>

            <div id="h5c-tablet-body-t1" class="h5c_tablet_body less_scroll"></div>

          </td>
        </tr>
      
      </table>
    </td>

    <!-- column blank 2 -->
    <td width="10px" id="h5c-lyo-col-w-ctrl" class="h5c_resize_col"></td>
    
    <td id="h5c-lyo-col-w" valign="top">
      <table width="100%" height="100%">
        <tr>
          <td id="h5c-tablet-framew0" class="hdev-layout-container" valign="top">
            
            <div id="h5c-tablet-tabs-framew0" class="h5c_tablet_tabs_frame">
              <div class="h5c_tablet_tabs_lm">
                <div id="h5c-tablet-tabs-w0" class="h5c_tablet_tabs"></div>
              </div>
              <div class="h5c_tablet_tabs_lr">
                <div class="pgtab_more lc_pgtab_more" href="#w0"></div>
              </div>
            </div>

            <div id="h5c-tablet-toolbar-w0" class="hide"></div>
            <div id="h5c-tablet-body-w0" class="h5c_tablet_body"></div>

          </td>
        </tr>

        <tr><td height="10px" id="h5c-resize-roww0" class="h5c_resize_row hide"></td></tr>
        
        <tr>
          <td id="h5c-tablet-framew1" class="hdev-layout-container hide" valign="top">
            
            <div id="h5c-tablet-tabs-framew1" class="h5c_tablet_tabs_frame pgtabs_frame">
              <div class="h5c_tablet_tabs_lm">
                <div id="h5c-tablet-tabs-w1" class="h5c_tablet_tabs"></div>
              </div>
              <div class="h5c_tablet_tabs_lr">
              </div>
            </div>

            <div id="h5c-tablet-body-w1" class="h5c_tablet_body less_scroll"></div>

          </td>
        </tr>
      
      </table>
    </td>

    <td width="10px"></td>

  </tr>
</table>

<div class="pgtab-openfiles-ol hdev-lcmenu less_scroll"></div>

<div id="lc_editor_tools" class="hide">

    <div class="editor_bar hdev-ws hdev-tabs hcr-pgbar-editor">
        
        <div class="tabitem" onclick="lcEditor.SaveCurrent()">
            <div class="ctn"><i class="icon-hdd"></i> Save</div>
        </div>

        <div class="tabitemline"></div>
        <div class="tabitem" onclick="lcEditor.Search()">
            <div class="ctn"><i class="icon-search"></i> Search</div>
        </div>

        <div class="tabitemline"></div>
        <div class="tabitem" onclick="lcEditor.Undo()">
            <div class="ctn"><i class="icon-chevron-left"></i> Undo</div>
        </div>

        <div class="tabitem" onclick="lcEditor.Redo()">
            <div class="ctn"><i class="icon-chevron-right"></i> Redo</div>
        </div>
        
        <!-- <div class="tabitemline"></div>
        <div class="tabitem">
            <div class="ico"><img src="/lesscreator/static/img/disk.png" align="absmiddle" /></div>
            <div class="ctn"><input onclick="lcEditor.ConfigSet('editor_autosave')" type="checkbox" id="editor_autosave" name="editor_autosave" value="on" /> Auto Saving</div>
        </div> -->

        <!-- <div class="tabitemline"></div>
        <div class="tabitem">
            <div class="ico"><img src="/lesscreator/static/img/w3_vim.png" align="absmiddle" /></div>
            <div class="ctn"><input onclick="lcEditor.ConfigSet('editor_keymap_vim')" type="checkbox" id="editor_keymap_vim" name="editor_keymap_vim" value="on" /> VIM Mode</div>
        </div> -->
        
        <div class="tabitemline"></div>
        <div class="tabitem" onclick="lcEditor.ConfigModal()">
            <div class="ctn"><i class="icon-cog"></i> Setting</div>
        </div>
    </div>

    <div class="lc_editor_searchbar hide form-inline">
        <div class="input-prepend input-append">
            <span class="add-on"><i class="icon-search"></i></span>
            <input class="input-small" type="text" name="find" value="Find Word" />
            <button class="btn" onclick="lcEditor.SearchNext()">Search</button>
        </div>

        <label class="inline"> or </label>
        
        <div class="input-append">
            <input class="input-small" name="replace" type="text" value="Replace with">
            <button class="btn" type="button" onclick="lcEditor.SearchReplace(false)">Replace</button>
            <button class="btn" type="button" onclick="lcEditor.SearchReplace(true)">Replace All</button>
        </div>
        
        <!-- <label class="checkbox inline">
          <input onclick="lcEditor.ConfigSet('editor_search_case')" type="checkbox" id="editor_search_case" name="editor_search_case" value="on" />
          Match case
        </label> -->

        <button type="button" class="close" onclick="lcEditor.Search()">&times;</button>
    </div>
</div>

<script>
$(".lc_pgtab_more").click(function(event) {
    
    event.stopPropagation();

    h5cTabletMore($(this).attr('href').substr(1));

    $(document).click(function() {
        $('.pgtab-openfiles-ol').empty().hide();
        $(document).unbind('click');
    });
});
</script>