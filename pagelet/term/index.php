<!-- <div onresize="window.resize &amp;&amp; window.scr &amp;&amp; resize(scr, ws)">
</div> -->

<audio src="bell.ogg" id="bell" style="display: none;"></audio>
<div id="lc-terminal" class="lc-terminal less_scroll"></div>

<script>
//$('#lc-terminal').height($('#h5c-tablet-body-w1').height());

lc_terminal_start('lc-terminal', 'ws://' + window.location.hostname + ':9531/lesscreator/api/terminal-ws');
lessLocalStorage.Set("lcWebTerminal0", "1");
</script>