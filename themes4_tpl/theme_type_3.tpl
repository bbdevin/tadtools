<div id="xoops_theme_content_zone" class="row" style="<{$content_zone}>">
    <!-- 若是有左區塊 -->
    <{if $xoBlocks.canvas_left}>
        <div id="xoops_theme_center_zone" class="col-lg-<{$cb_width}> order-lg-2" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-lg-<{$lb_width}> order-lg-1" style="background-color:<{$lb_color}>;">
            <div id="xoops_theme_left" style="<{$leftBlocks}>">
                <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625em;">:::</a>
                <{if $xoBlocks.canvas_left}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBlock.tpl"}>
                <{/if}>
            </div>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-lg-12" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>

<{if $xoBlocks.canvas_right}>
    <div id="xoops_theme_right_zone" class="row" style="background-color:<{$rb_color}>;">
        <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625em;">:::</a>
        <div class="col-lg-<{$rb_width}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBottom.tpl"}>
        </div>
        <div style="clear: both;"></div>
    </div>
<{/if}>
