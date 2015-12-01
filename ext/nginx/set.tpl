<div>
    <label class="checkbox-inline">
      <input name="state" type="checkbox" value="1" onchange="lcExt.nginx.StateRefresh()" {[ if (it.state) { ]}checked{[ } ]} > Enable Nginx
    </label>

    <select id="lcext-nginx-tplname" style="display:none" onchange="lcExt.nginx.StateRefresh()">
    {[~it.cfgtpls :v]}
      <option value="{[=v.name]}" {[ if (it.cfgtpl == v.name) { ]} selected {[ } ]}>{[=v.summary]}</option>
    {[~]}
    </select>
</div>

<div id="lcext-nginx-conf" style="display:none"></div>

<div style="padding:5px 0;">
    <button class="btn btn-inverse" onclick="lcExt.nginx.SetSave()">Save</button>
</div>
