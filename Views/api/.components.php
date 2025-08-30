<?php
use function igk_html_node_a as _a;
use function igk_html_node_abbr as _abbr;
use function igk_html_node_address as _address;
use function igk_html_node_article as _article;
use function igk_html_node_button as _button;
use function igk_html_node_code as _code;
use function igk_html_node_col as _col;
use function igk_html_node_dialog as _dialog;
use function igk_html_node_dl as _dl;
use function igk_html_node_form as _form;
use function igk_html_node_frame as _frame;
use function igk_html_node_img as _img;
use function igk_html_node_input as _input;
use function igk_html_node_label as _label;
use function igk_html_node_pre as _pre;
use function igk_html_node_script as _script;
use function igk_html_node_select as _select;
use function igk_html_node_style as _style;
use function igk_html_node_table as _table;
use function igk_html_node_td as _td;
use function igk_html_node_template as _template;
use function igk_html_node_textarea as _textarea;
use function igk_html_node_time as _time;
if (!function_exists("a")) {
    function a()
    {
        return igk_html_node_a(...func_get_args());
    }
}
if (!function_exists("a_get")) {
    function a_get()
    {
        return igk_html_node_a_get(...func_get_args());
    }
}
if (!function_exists("a_post")) {
    function a_post()
    {
        return igk_html_node_a_post(...func_get_args());
    }
}
if (!function_exists("abbr")) {
    function abbr()
    {
        return igk_html_node_abbr(...func_get_args());
    }
}
if (!function_exists("abtn")) {
    function abtn()
    {
        return igk_html_node_abtn(...func_get_args());
    }
}
if (!function_exists("accordeon")) {
    function accordeon()
    {
        return igk_html_node_accordeon(...func_get_args());
    }
}
if (!function_exists("accordeon_menus")) {
    function accordeon_menus()
    {
        return igk_html_node_accordeon_menus(...func_get_args());
    }
}
if (!function_exists("aclearsandreload")) {
    function aclearsandreload()
    {
        return igk_html_node_aclearsandreload(...func_get_args());
    }
}
if (!function_exists("acronym")) {
    function acronym()
    {
        return igk_create_node("acronym", null, func_get_args());
    }
}
if (!function_exists("actionbar")) {
    function actionbar()
    {
        return igk_html_node_actionbar(...func_get_args());
    }
}
if (!function_exists("actiongroup")) {
    function actiongroup()
    {
        return igk_html_node_actiongroup(...func_get_args());
    }
}
if (!function_exists("actions")) {
    function actions()
    {
        return igk_html_node_actions(...func_get_args());
    }
}
if (!function_exists("address")) {
    function address()
    {
        return igk_html_node_address(...func_get_args());
    }
}
if (!function_exists("ajsbutton")) {
    function ajsbutton()
    {
        return igk_html_node_ajsbutton(...func_get_args());
    }
}
if (!function_exists("ajspickfile")) {
    function ajspickfile()
    {
        return igk_html_node_ajspickfile(...func_get_args());
    }
}
if (!function_exists("ajxa")) {
    function ajxa()
    {
        return igk_html_node_ajxa(...func_get_args());
    }
}
if (!function_exists("ajxabutton")) {
    function ajxabutton()
    {
        return igk_html_node_ajxabutton(...func_get_args());
    }
}
if (!function_exists("ajxappendto")) {
    function ajxappendto()
    {
        return igk_html_node_ajxappendto(...func_get_args());
    }
}
if (!function_exists("ajxdoctitle")) {
    function ajxdoctitle()
    {
        return igk_html_node_ajxdoctitle(...func_get_args());
    }
}
if (!function_exists("ajxform")) {
    function ajxform()
    {
        return igk_html_node_ajxform(...func_get_args());
    }
}
if (!function_exists("ajxlnkreplace")) {
    function ajxlnkreplace()
    {
        return igk_html_node_ajxlnkreplace(...func_get_args());
    }
}
if (!function_exists("ajxpaginationview")) {
    function ajxpaginationview()
    {
        return igk_html_node_ajxpaginationview(...func_get_args());
    }
}
if (!function_exists("ajxpickfile")) {
    function ajxpickfile()
    {
        return igk_html_node_ajxpickfile(...func_get_args());
    }
}
if (!function_exists("ajxreplacecontent")) {
    function ajxreplacecontent()
    {
        return igk_html_node_ajxreplacecontent(...func_get_args());
    }
}
if (!function_exists("ajxreplacesource")) {
    function ajxreplacesource()
    {
        return igk_html_node_ajxreplacesource(...func_get_args());
    }
}
if (!function_exists("ajxtabcomponent")) {
    function ajxtabcomponent()
    {
        return igk_html_node_ajxtabcomponent(...func_get_args());
    }
}
if (!function_exists("ajxtabcontrol")) {
    function ajxtabcontrol()
    {
        return igk_html_node_ajxtabcontrol(...func_get_args());
    }
}
if (!function_exists("ajxupdateview")) {
    function ajxupdateview()
    {
        return igk_html_node_ajxupdateview(...func_get_args());
    }
}
if (!function_exists("ajxuriloader")) {
    function ajxuriloader()
    {
        return igk_html_node_ajxuriloader(...func_get_args());
    }
}
if (!function_exists("angularapp")) {
    function angularapp()
    {
        return igk_html_node_angularapp(...func_get_args());
    }
}
if (!function_exists("apost")) {
    function apost()
    {
        return igk_html_node_apost(...func_get_args());
    }
}
if (!function_exists("app_hearder_bar")) {
    function app_hearder_bar()
    {
        return igk_html_node_app_hearder_bar(...func_get_args());
    }
}
if (!function_exists("app_login_form")) {
    function app_login_form()
    {
        return igk_html_node_app_login_form(...func_get_args());
    }
}
if (!function_exists("applet")) {
    function applet()
    {
        return igk_create_node("applet", null, func_get_args());
    }
}
if (!function_exists("apploginform")) {
    function apploginform()
    {
        return igk_html_node_apploginform(...func_get_args());
    }
}
if (!function_exists("area")) {
    function area()
    {
        return igk_create_node("area", null, func_get_args());
    }
}
if (!function_exists("arraydata")) {
    function arraydata()
    {
        return igk_html_node_arraydata(...func_get_args());
    }
}
if (!function_exists("arraylist")) {
    function arraylist()
    {
        return igk_html_node_arraylist(...func_get_args());
    }
}
if (!function_exists("article")) {
    function article()
    {
        return igk_html_node_article(...func_get_args());
    }
}
if (!function_exists("aside")) {
    function aside()
    {
        return igk_create_node("aside", null, func_get_args());
    }
}
if (!function_exists("assertnode")) {
    function assertnode()
    {
        return igk_html_node_assertnode(...func_get_args());
    }
}
if (!function_exists("attr_expression")) {
    function attr_expression()
    {
        return igk_html_node_attr_expression(...func_get_args());
    }
}
if (!function_exists("audio")) {
    function audio()
    {
        return igk_create_node("audio", null, func_get_args());
    }
}
if (!function_exists("author_community")) {
    function author_community()
    {
        return igk_html_node_author_community(...func_get_args());
    }
}
if (!function_exists("b")) {
    function b()
    {
        return igk_create_node("b", null, func_get_args());
    }
}
if (!function_exists("backgroundlayer")) {
    function backgroundlayer()
    {
        return igk_html_node_backgroundlayer(...func_get_args());
    }
}
if (!function_exists("badge")) {
    function badge()
    {
        return igk_html_node_badge(...func_get_args());
    }
}
if (!function_exists("balafoncomponentjs")) {
    function balafoncomponentjs()
    {
        return igk_html_node_balafoncomponentjs(...func_get_args());
    }
}
if (!function_exists("balafonjs")) {
    function balafonjs()
    {
        return igk_html_node_balafonjs(...func_get_args());
    }
}
if (!function_exists("bar")) {
    function bar()
    {
        return igk_html_node_bar(...func_get_args());
    }
}
if (!function_exists("base")) {
    function base()
    {
        return igk_create_node("base", null, func_get_args());
    }
}
if (!function_exists("basefont")) {
    function basefont()
    {
        return igk_create_node("basefont", null, func_get_args());
    }
}
if (!function_exists("bdi")) {
    function bdi()
    {
        return igk_create_node("bdi", null, func_get_args());
    }
}
if (!function_exists("bdo")) {
    function bdo()
    {
        return igk_create_node("bdo", null, func_get_args());
    }
}
if (!function_exists("beforerendernextsibling")) {
    function beforerendernextsibling()
    {
        return igk_html_node_beforerendernextsibling(...func_get_args());
    }
}
if (!function_exists("bgegamesurface")) {
    function bgegamesurface()
    {
        return igk_html_node_bgegamesurface(...func_get_args());
    }
}
if (!function_exists("big")) {
    function big()
    {
        return igk_create_node("big", null, func_get_args());
    }
}
if (!function_exists("bind")) {
    function bind()
    {
        return igk_html_node_bind(...func_get_args());
    }
}
if (!function_exists("bindarticle")) {
    function bindarticle()
    {
        return igk_html_node_bindarticle(...func_get_args());
    }
}
if (!function_exists("bindcontent")) {
    function bindcontent()
    {
        return igk_html_node_bindcontent(...func_get_args());
    }
}
if (!function_exists("bindmenu")) {
    function bindmenu()
    {
        return igk_html_node_bindmenu(...func_get_args());
    }
}
if (!function_exists("bindscript")) {
    function bindscript()
    {
        return igk_html_node_bindscript(...func_get_args());
    }
}
if (!function_exists("blocknode")) {
    function blocknode()
    {
        return igk_html_node_blocknode(...func_get_args());
    }
}
if (!function_exists("blockquote")) {
    function blockquote()
    {
        return igk_create_node("blockquote", null, func_get_args());
    }
}
if (!function_exists("bmcbutton")) {
    function bmcbutton()
    {
        return igk_html_node_bmcbutton(...func_get_args());
    }
}
if (!function_exists("bmccheckbox")) {
    function bmccheckbox()
    {
        return igk_html_node_bmccheckbox(...func_get_args());
    }
}
if (!function_exists("bmccombobox")) {
    function bmccombobox()
    {
        return igk_html_node_bmccombobox(...func_get_args());
    }
}
if (!function_exists("bmclineripple")) {
    function bmclineripple()
    {
        return igk_html_node_bmclineripple(...func_get_args());
    }
}
if (!function_exists("bmcloginpage")) {
    function bmcloginpage()
    {
        return igk_html_node_bmcloginpage(...func_get_args());
    }
}
if (!function_exists("bmcradio")) {
    function bmcradio()
    {
        return igk_html_node_bmcradio(...func_get_args());
    }
}
if (!function_exists("bmcripple")) {
    function bmcripple()
    {
        return igk_html_node_bmcripple(...func_get_args());
    }
}
if (!function_exists("bmcroundtool")) {
    function bmcroundtool()
    {
        return igk_html_node_bmcroundtool(...func_get_args());
    }
}
if (!function_exists("bmcshape")) {
    function bmcshape()
    {
        return igk_html_node_bmcshape(...func_get_args());
    }
}
if (!function_exists("bmcsurface")) {
    function bmcsurface()
    {
        return igk_html_node_bmcsurface(...func_get_args());
    }
}
if (!function_exists("bmctextarea")) {
    function bmctextarea()
    {
        return igk_html_node_bmctextarea(...func_get_args());
    }
}
if (!function_exists("bmctextfield")) {
    function bmctextfield()
    {
        return igk_html_node_bmctextfield(...func_get_args());
    }
}
if (!function_exists("bmctextlogofield")) {
    function bmctextlogofield()
    {
        return igk_html_node_bmctextlogofield(...func_get_args());
    }
}
if (!function_exists("bmctextsearchfield")) {
    function bmctextsearchfield()
    {
        return igk_html_node_bmctextsearchfield(...func_get_args());
    }
}
if (!function_exists("bmctooltip")) {
    function bmctooltip()
    {
        return igk_html_node_bmctooltip(...func_get_args());
    }
}
if (!function_exists("body")) {
    function body()
    {
        return igk_create_node("body", null, func_get_args());
    }
}
if (!function_exists("bodybox")) {
    function bodybox()
    {
        return igk_html_node_bodybox(...func_get_args());
    }
}
if (!function_exists("bootstrap_accordion")) {
    function bootstrap_accordion()
    {
        return igk_html_node_bootstrap_accordion(...func_get_args());
    }
}
if (!function_exists("bootstrap_alert")) {
    function bootstrap_alert()
    {
        return igk_html_node_bootstrap_alert(...func_get_args());
    }
}
if (!function_exists("bootstrap_badge")) {
    function bootstrap_badge()
    {
        return igk_html_node_bootstrap_badge(...func_get_args());
    }
}
if (!function_exists("bootstrap_breadcrumb")) {
    function bootstrap_breadcrumb()
    {
        return igk_html_node_bootstrap_breadcrumb(...func_get_args());
    }
}
if (!function_exists("bootstrap_button")) {
    function bootstrap_button()
    {
        return igk_html_node_bootstrap_button(...func_get_args());
    }
}
if (!function_exists("bootstrap_button_group")) {
    function bootstrap_button_group()
    {
        return igk_html_node_bootstrap_button_group(...func_get_args());
    }
}
if (!function_exists("bootstrap_card")) {
    function bootstrap_card()
    {
        return igk_html_node_bootstrap_card(...func_get_args());
    }
}
if (!function_exists("bootstrap_carousel")) {
    function bootstrap_carousel()
    {
        return igk_html_node_bootstrap_carousel(...func_get_args());
    }
}
if (!function_exists("bootstrap_closebutton")) {
    function bootstrap_closebutton()
    {
        return igk_html_node_bootstrap_closebutton(...func_get_args());
    }
}
if (!function_exists("bootstrap_collapse")) {
    function bootstrap_collapse()
    {
        return igk_html_node_bootstrap_collapse(...func_get_args());
    }
}
if (!function_exists("bootstrap_dropdown")) {
    function bootstrap_dropdown()
    {
        return igk_html_node_bootstrap_dropdown(...func_get_args());
    }
}
if (!function_exists("bootstrap_langselector")) {
    function bootstrap_langselector()
    {
        return igk_html_node_bootstrap_langselector(...func_get_args());
    }
}
if (!function_exists("bootstrap_listgroup")) {
    function bootstrap_listgroup()
    {
        return igk_html_node_bootstrap_listgroup(...func_get_args());
    }
}
if (!function_exists("bootstrap_masonry")) {
    function bootstrap_masonry()
    {
        return igk_html_node_bootstrap_masonry(...func_get_args());
    }
}
if (!function_exists("bootstrap_modal")) {
    function bootstrap_modal()
    {
        return igk_html_node_bootstrap_modal(...func_get_args());
    }
}
if (!function_exists("bootstrap_navbar")) {
    function bootstrap_navbar()
    {
        return igk_html_node_bootstrap_navbar(...func_get_args());
    }
}
if (!function_exists("bootstrap_navstab")) {
    function bootstrap_navstab()
    {
        return igk_html_node_bootstrap_navstab(...func_get_args());
    }
}
if (!function_exists("bootstrap_offcanvas")) {
    function bootstrap_offcanvas()
    {
        return igk_html_node_bootstrap_offcanvas(...func_get_args());
    }
}
if (!function_exists("bootstrap_pagination")) {
    function bootstrap_pagination()
    {
        return igk_html_node_bootstrap_pagination(...func_get_args());
    }
}
if (!function_exists("bootstrap_placeholder")) {
    function bootstrap_placeholder()
    {
        return igk_html_node_bootstrap_placeholder(...func_get_args());
    }
}
if (!function_exists("bootstrap_popover")) {
    function bootstrap_popover()
    {
        return igk_html_node_bootstrap_popover(...func_get_args());
    }
}
if (!function_exists("bootstrap_progress")) {
    function bootstrap_progress()
    {
        return igk_html_node_bootstrap_progress(...func_get_args());
    }
}
if (!function_exists("bootstrap_scrollspy")) {
    function bootstrap_scrollspy()
    {
        return igk_html_node_bootstrap_scrollspy(...func_get_args());
    }
}
if (!function_exists("bootstrap_spinner")) {
    function bootstrap_spinner()
    {
        return igk_html_node_bootstrap_spinner(...func_get_args());
    }
}
if (!function_exists("bootstrap_toast")) {
    function bootstrap_toast()
    {
        return igk_html_node_bootstrap_toast(...func_get_args());
    }
}
if (!function_exists("bootstrap_tooltip")) {
    function bootstrap_tooltip()
    {
        return igk_html_node_bootstrap_tooltip(...func_get_args());
    }
}
if (!function_exists("boxdialog")) {
    function boxdialog()
    {
        return igk_html_node_boxdialog(...func_get_args());
    }
}
if (!function_exists("br")) {
    function br()
    {
        return igk_create_node("br", null, func_get_args());
    }
}
if (!function_exists("btn")) {
    function btn()
    {
        return igk_html_node_btn(...func_get_args());
    }
}
if (!function_exists("buildselect")) {
    function buildselect()
    {
        return igk_html_node_buildselect(...func_get_args());
    }
}
if (!function_exists("bullet")) {
    function bullet()
    {
        return igk_html_node_bullet(...func_get_args());
    }
}
if (!function_exists("button")) {
    function button()
    {
        return igk_html_node_button(...func_get_args());
    }
}
if (!function_exists("button_group")) {
    function button_group()
    {
        return igk_html_node_button_group(...func_get_args());
    }
}
if (!function_exists("bview")) {
    function bview()
    {
        return igk_html_node_bview(...func_get_args());
    }
}
if (!function_exists("calcnode")) {
    function calcnode()
    {
        return igk_html_node_calcnode(...func_get_args());
    }
}
if (!function_exists("calendar")) {
    function calendar()
    {
        return igk_html_node_calendar(...func_get_args());
    }
}
if (!function_exists("canvabalafonscript")) {
    function canvabalafonscript()
    {
        return igk_html_node_canvabalafonscript(...func_get_args());
    }
}
if (!function_exists("canvaeditorsurface")) {
    function canvaeditorsurface()
    {
        return igk_html_node_canvaeditorsurface(...func_get_args());
    }
}
if (!function_exists("canvas")) {
    function canvas()
    {
        return igk_create_node("canvas", null, func_get_args());
    }
}
if (!function_exists("caption")) {
    function caption()
    {
        return igk_create_node("caption", null, func_get_args());
    }
}
if (!function_exists("cardid")) {
    function cardid()
    {
        return igk_html_node_cardid(...func_get_args());
    }
}
if (!function_exists("carousel")) {
    function carousel()
    {
        return igk_html_node_carousel(...func_get_args());
    }
}
if (!function_exists("cell")) {
    function cell()
    {
        return igk_html_node_cell(...func_get_args());
    }
}
if (!function_exists("cellrow")) {
    function cellrow()
    {
        return igk_html_node_cellrow(...func_get_args());
    }
}
if (!function_exists("center")) {
    function center()
    {
        return igk_create_node("center", null, func_get_args());
    }
}
if (!function_exists("centerbox")) {
    function centerbox()
    {
        return igk_html_node_centerbox(...func_get_args());
    }
}
if (!function_exists("centerbox_flex")) {
    function centerbox_flex()
    {
        return igk_html_node_centerbox_flex(...func_get_args());
    }
}
if (!function_exists("centerbox_grid")) {
    function centerbox_grid()
    {
        return igk_html_node_centerbox_grid(...func_get_args());
    }
}
if (!function_exists("checkbox")) {
    function checkbox()
    {
        return igk_html_node_checkbox(...func_get_args());
    }
}
if (!function_exists("circlewaiter")) {
    function circlewaiter()
    {
        return igk_html_node_circlewaiter(...func_get_args());
    }
}
if (!function_exists("cite")) {
    function cite()
    {
        return igk_create_node("cite", null, func_get_args());
    }
}
if (!function_exists("clearboth")) {
    function clearboth()
    {
        return igk_html_node_clearboth(...func_get_args());
    }
}
if (!function_exists("clearfloatbox")) {
    function clearfloatbox()
    {
        return igk_html_node_clearfloatbox(...func_get_args());
    }
}
if (!function_exists("cleartab")) {
    function cleartab()
    {
        return igk_html_node_cleartab(...func_get_args());
    }
}
if (!function_exists("clone_node")) {
    function clone_node()
    {
        return igk_html_node_clone(...func_get_args());
    }
}
if (!function_exists("clonenode")) {
    function clonenode()
    {
        return igk_html_node_clonenode(...func_get_args());
    }
}
if (!function_exists("code")) {
    function code()
    {
        return igk_html_node_code(...func_get_args());
    }
}
if (!function_exists("col")) {
    function col()
    {
        return igk_html_node_col(...func_get_args());
    }
}
if (!function_exists("colgroup")) {
    function colgroup()
    {
        return igk_create_node("colgroup", null, func_get_args());
    }
}
if (!function_exists("colviewbox")) {
    function colviewbox()
    {
        return igk_html_node_colviewbox(...func_get_args());
    }
}
if (!function_exists("combobox")) {
    function combobox()
    {
        return igk_html_node_combobox(...func_get_args());
    }
}
if (!function_exists("comment")) {
    function comment()
    {
        return igk_html_node_comment(...func_get_args());
    }
}
if (!function_exists("commentzone")) {
    function commentzone()
    {
        return igk_html_node_commentzone(...func_get_args());
    }
}
if (!function_exists("communitylink")) {
    function communitylink()
    {
        return igk_html_node_communitylink(...func_get_args());
    }
}
if (!function_exists("communitylinks")) {
    function communitylinks()
    {
        return igk_html_node_communitylinks(...func_get_args());
    }
}
if (!function_exists("communitynode")) {
    function communitynode()
    {
        return igk_html_node_communitynode(...func_get_args());
    }
}
if (!function_exists("component")) {
    function component()
    {
        return igk_html_node_component(...func_get_args());
    }
}
if (!function_exists("conditionalnode")) {
    function conditionalnode()
    {
        return igk_html_node_conditionalnode(...func_get_args());
    }
}
if (!function_exists("configsubmenu")) {
    function configsubmenu()
    {
        return igk_html_node_configsubmenu(...func_get_args());
    }
}
if (!function_exists("connection_community")) {
    function connection_community()
    {
        return igk_html_node_connection_community(...func_get_args());
    }
}
if (!function_exists("contact_block")) {
    function contact_block()
    {
        return igk_html_node_contact_block(...func_get_args());
    }
}
if (!function_exists("container")) {
    function container()
    {
        return igk_html_node_container(...func_get_args());
    }
}
if (!function_exists("containerrowcol")) {
    function containerrowcol()
    {
        return igk_html_node_containerrowcol(...func_get_args());
    }
}
if (!function_exists("cookiewarning")) {
    function cookiewarning()
    {
        return igk_html_node_cookiewarning(...func_get_args());
    }
}
if (!function_exists("copyright")) {
    function copyright()
    {
        return igk_html_node_copyright(...func_get_args());
    }
}
if (!function_exists("csscomponentstyle")) {
    function csscomponentstyle()
    {
        return igk_html_node_csscomponentstyle(...func_get_args());
    }
}
if (!function_exists("csslink")) {
    function csslink()
    {
        return igk_html_node_csslink(...func_get_args());
    }
}
if (!function_exists("cssstyle")) {
    function cssstyle()
    {
        return igk_html_node_cssstyle(...func_get_args());
    }
}
if (!function_exists("ctrlview")) {
    function ctrlview()
    {
        return igk_html_node_ctrlview(...func_get_args());
    }
}
if (!function_exists("data")) {
    function data()
    {
        return igk_create_node("data", null, func_get_args());
    }
}
if (!function_exists("datalist")) {
    function datalist()
    {
        return igk_create_node("datalist", null, func_get_args());
    }
}
if (!function_exists("dataschema")) {
    function dataschema()
    {
        return igk_html_node_dataschema(...func_get_args());
    }
}
if (!function_exists("dbdataschema")) {
    function dbdataschema()
    {
        return igk_html_node_dbdataschema(...func_get_args());
    }
}
if (!function_exists("dbentriescallback")) {
    function dbentriescallback()
    {
        return igk_html_node_dbentriescallback(...func_get_args());
    }
}
if (!function_exists("dbresult")) {
    function dbresult()
    {
        return igk_html_node_dbresult(...func_get_args());
    }
}
if (!function_exists("dbselect")) {
    function dbselect()
    {
        return igk_html_node_dbselect(...func_get_args());
    }
}
if (!function_exists("dbtableview")) {
    function dbtableview()
    {
        return igk_html_node_dbtableview(...func_get_args());
    }
}
if (!function_exists("dd")) {
    function dd()
    {
        return igk_create_node("dd", null, func_get_args());
    }
}
if (!function_exists("defercsslink")) {
    function defercsslink()
    {
        return igk_html_node_defercsslink(...func_get_args());
    }
}
if (!function_exists("definition")) {
    function definition()
    {
        return igk_html_node_definition(...func_get_args());
    }
}
if (!function_exists("definitions")) {
    function definitions()
    {
        return igk_html_node_definitions(...func_get_args());
    }
}
if (!function_exists("del")) {
    function del()
    {
        return igk_create_node("del", null, func_get_args());
    }
}
if (!function_exists("details")) {
    function details()
    {
        return igk_create_node("details", null, func_get_args());
    }
}
if (!function_exists("dfn")) {
    function dfn()
    {
        return igk_create_node("dfn", null, func_get_args());
    }
}
if (!function_exists("dialog")) {
    function dialog()
    {
        return igk_html_node_dialog(...func_get_args());
    }
}
if (!function_exists("dialog_circle_waiter")) {
    function dialog_circle_waiter()
    {
        return igk_html_node_dialog_circle_waiter(...func_get_args());
    }
}
if (!function_exists("dialogbox")) {
    function dialogbox()
    {
        return igk_html_node_dialogbox(...func_get_args());
    }
}
if (!function_exists("dialogboxcontent")) {
    function dialogboxcontent()
    {
        return igk_html_node_dialogboxcontent(...func_get_args());
    }
}
if (!function_exists("dialogboxoptions")) {
    function dialogboxoptions()
    {
        return igk_html_node_dialogboxoptions(...func_get_args());
    }
}
if (!function_exists("dir")) {
    function dir()
    {
        return igk_create_node("dir", null, func_get_args());
    }
}
if (!function_exists("div")) {
    function div()
    {
        return igk_create_node("div", null, func_get_args());
    }
}
if (!function_exists("divcontainer")) {
    function divcontainer()
    {
        return igk_html_node_divcontainer(...func_get_args());
    }
}
if (!function_exists("dl")) {
    function dl()
    {
        return igk_html_node_dl(...func_get_args());
    }
}
if (!function_exists("domainlink")) {
    function domainlink()
    {
        return igk_html_node_domainlink(...func_get_args());
    }
}
if (!function_exists("dropdown_button")) {
    function dropdown_button()
    {
        return igk_html_node_dropdown_button(...func_get_args());
    }
}
if (!function_exists("dt")) {
    function dt()
    {
        return igk_create_node("dt", null, func_get_args());
    }
}
if (!function_exists("dumpdata")) {
    function dumpdata()
    {
        return igk_html_node_dumpdata(...func_get_args());
    }
}
if (!function_exists("em")) {
    function em()
    {
        return igk_create_node("em", null, func_get_args());
    }
}
if (!function_exists("embed")) {
    function embed()
    {
        return igk_create_node("embed", null, func_get_args());
    }
}
if (!function_exists("enginecontrol")) {
    function enginecontrol()
    {
        return igk_html_node_enginecontrol(...func_get_args());
    }
}
if (!function_exists("error404")) {
    function error404()
    {
        return igk_html_node_error404(...func_get_args());
    }
}
if (!function_exists("expo")) {
    function expo()
    {
        return igk_html_node_expo(...func_get_args());
    }
}
if (!function_exists("expression_node")) {
    function expression_node()
    {
        return igk_html_node_expression_node(...func_get_args());
    }
}
if (!function_exists("facebook_login_button")) {
    function facebook_login_button()
    {
        return igk_html_node_facebook_login_button(...func_get_args());
    }
}
if (!function_exists("facebookcomments")) {
    function facebookcomments()
    {
        return igk_html_node_facebookcomments(...func_get_args());
    }
}
if (!function_exists("facebookfollowusbutton")) {
    function facebookfollowusbutton()
    {
        return igk_html_node_facebookfollowusbutton(...func_get_args());
    }
}
if (!function_exists("facebooklikebutton")) {
    function facebooklikebutton()
    {
        return igk_html_node_facebooklikebutton(...func_get_args());
    }
}
if (!function_exists("facebookoauthlink")) {
    function facebookoauthlink()
    {
        return igk_html_node_facebookoauthlink(...func_get_args());
    }
}
if (!function_exists("facebooksharebutton")) {
    function facebooksharebutton()
    {
        return igk_html_node_facebooksharebutton(...func_get_args());
    }
}
if (!function_exists("facebooktimeline")) {
    function facebooktimeline()
    {
        return igk_html_node_facebooktimeline(...func_get_args());
    }
}
if (!function_exists("fields")) {
    function fields()
    {
        return igk_html_node_fields(...func_get_args());
    }
}
if (!function_exists("fieldset")) {
    function fieldset()
    {
        return igk_create_node("fieldset", null, func_get_args());
    }
}
if (!function_exists("figcaption")) {
    function figcaption()
    {
        return igk_create_node("figcaption", null, func_get_args());
    }
}
if (!function_exists("figure")) {
    function figure()
    {
        return igk_create_node("figure", null, func_get_args());
    }
}
if (!function_exists("fixedactionbar")) {
    function fixedactionbar()
    {
        return igk_html_node_fixedactionbar(...func_get_args());
    }
}
if (!function_exists("flex")) {
    function flex()
    {
        return igk_html_node_flex(...func_get_args());
    }
}
if (!function_exists("floatingform")) {
    function floatingform()
    {
        return igk_html_node_floatingform(...func_get_args());
    }
}
if (!function_exists("followusbutton")) {
    function followusbutton()
    {
        return igk_html_node_followusbutton(...func_get_args());
    }
}
if (!function_exists("font")) {
    function font()
    {
        return igk_create_node("font", null, func_get_args());
    }
}
if (!function_exists("fontsymbol")) {
    function fontsymbol()
    {
        return igk_html_node_fontsymbol(...func_get_args());
    }
}
if (!function_exists("footer")) {
    function footer()
    {
        return igk_create_node("footer", null, func_get_args());
    }
}
if (!function_exists("form")) {
    function form()
    {
        return igk_html_node_form(...func_get_args());
    }
}
if (!function_exists("form_post")) {
    function form_post()
    {
        return igk_html_node_form_post(...func_get_args());
    }
}
if (!function_exists("formactionbutton")) {
    function formactionbutton()
    {
        return igk_html_node_formactionbutton(...func_get_args());
    }
}
if (!function_exists("formcref")) {
    function formcref()
    {
        return igk_html_node_formcref(...func_get_args());
    }
}
if (!function_exists("formfields")) {
    function formfields()
    {
        return igk_html_node_formfields(...func_get_args());
    }
}
if (!function_exists("formgroup")) {
    function formgroup()
    {
        return igk_html_node_formgroup(...func_get_args());
    }
}
if (!function_exists("formusagecondition")) {
    function formusagecondition()
    {
        return igk_html_node_formusagecondition(...func_get_args());
    }
}
if (!function_exists("frame")) {
    function frame()
    {
        return igk_html_node_frame(...func_get_args());
    }
}
if (!function_exists("framedialog")) {
    function framedialog()
    {
        return igk_html_node_framedialog(...func_get_args());
    }
}
if (!function_exists("frameset")) {
    function frameset()
    {
        return igk_create_node("frameset", null, func_get_args());
    }
}
if (!function_exists("gallery")) {
    function gallery()
    {
        return igk_html_node_gallery(...func_get_args());
    }
}
if (!function_exists("galleryfolder")) {
    function galleryfolder()
    {
        return igk_html_node_galleryfolder(...func_get_args());
    }
}
if (!function_exists("google_circle_waiter")) {
    function google_circle_waiter()
    {
        return igk_html_node_google_circle_waiter(...func_get_args());
    }
}
if (!function_exists("google_follow_us_button")) {
    function google_follow_us_button()
    {
        return igk_html_node_google_follow_us_button(...func_get_args());
    }
}
if (!function_exists("google_icon")) {
    function google_icon()
    {
        return igk_html_node_google_icon(...func_get_args());
    }
}
if (!function_exists("google_icon_outlined")) {
    function google_icon_outlined()
    {
        return igk_html_node_google_icon_outlined(...func_get_args());
    }
}
if (!function_exists("google_js_maps")) {
    function google_js_maps()
    {
        return igk_html_node_google_js_maps(...func_get_args());
    }
}
if (!function_exists("google_line_waiter")) {
    function google_line_waiter()
    {
        return igk_html_node_google_line_waiter(...func_get_args());
    }
}
if (!function_exists("google_login_button")) {
    function google_login_button()
    {
        return igk_html_node_google_login_button(...func_get_args());
    }
}
if (!function_exists("google_mapgeo")) {
    function google_mapgeo()
    {
        return igk_html_node_google_mapgeo(...func_get_args());
    }
}
if (!function_exists("google_oauth_link")) {
    function google_oauth_link()
    {
        return igk_html_node_google_oauth_link(...func_get_args());
    }
}
if (!function_exists("google_oth2_button")) {
    function google_oth2_button()
    {
        return igk_html_node_google_oth2_button(...func_get_args());
    }
}
if (!function_exists("google_recaptcha")) {
    function google_recaptcha()
    {
        return igk_html_node_google_recaptcha(...func_get_args());
    }
}
if (!function_exists("grid")) {
    function grid()
    {
        return igk_html_node_grid(...func_get_args());
    }
}
if (!function_exists("grid_selection")) {
    function grid_selection()
    {
        return igk_html_node_grid_selection(...func_get_args());
    }
}
if (!function_exists("h1")) {
    function h1()
    {
        return igk_create_node("h1", null, func_get_args());
    }
}
if (!function_exists("h2")) {
    function h2()
    {
        return igk_create_node("h2", null, func_get_args());
    }
}
if (!function_exists("h3")) {
    function h3()
    {
        return igk_create_node("h3", null, func_get_args());
    }
}
if (!function_exists("h4")) {
    function h4()
    {
        return igk_create_node("h4", null, func_get_args());
    }
}
if (!function_exists("h5")) {
    function h5()
    {
        return igk_create_node("h5", null, func_get_args());
    }
}
if (!function_exists("h6")) {
    function h6()
    {
        return igk_create_node("h6", null, func_get_args());
    }
}
if (!function_exists("hamburger_button_menu")) {
    function hamburger_button_menu()
    {
        return igk_html_node_hamburger_button_menu(...func_get_args());
    }
}
if (!function_exists("head")) {
    function head()
    {
        return igk_create_node("head", null, func_get_args());
    }
}
if (!function_exists("header")) {
    function header()
    {
        return igk_create_node("header", null, func_get_args());
    }
}
if (!function_exists("headerbar")) {
    function headerbar()
    {
        return igk_html_node_headerbar(...func_get_args());
    }
}
if (!function_exists("hgroup")) {
    function hgroup()
    {
        return igk_create_node("hgroup", null, func_get_args());
    }
}
if (!function_exists("hiddenfields")) {
    function hiddenfields()
    {
        return igk_html_node_hiddenfields(...func_get_args());
    }
}
if (!function_exists("hlineseparator")) {
    function hlineseparator()
    {
        return igk_html_node_hlineseparator(...func_get_args());
    }
}
if (!function_exists("hook")) {
    function hook()
    {
        return igk_html_node_hook(...func_get_args());
    }
}
if (!function_exists("hooknode")) {
    function hooknode()
    {
        return igk_html_node_hooknode(...func_get_args());
    }
}
if (!function_exists("horizontalpageview")) {
    function horizontalpageview()
    {
        return igk_html_node_horizontalpageview(...func_get_args());
    }
}
if (!function_exists("horizontalpane")) {
    function horizontalpane()
    {
        return igk_html_node_horizontalpane(...func_get_args());
    }
}
if (!function_exists("host")) {
    function host()
    {
        return igk_html_node_host(...func_get_args());
    }
}
if (!function_exists("hostobdata")) {
    function hostobdata()
    {
        return igk_html_node_hostobdata(...func_get_args());
    }
}
if (!function_exists("hr")) {
    function hr()
    {
        return igk_create_node("hr", null, func_get_args());
    }
}
if (!function_exists("hscrollbar")) {
    function hscrollbar()
    {
        return igk_html_node_hscrollbar(...func_get_args());
    }
}
if (!function_exists("hsep")) {
    function hsep()
    {
        return igk_html_node_hsep(...func_get_args());
    }
}
if (!function_exists("html")) {
    function html()
    {
        return igk_create_node("html", null, func_get_args());
    }
}
if (!function_exists("htmlnode")) {
    function htmlnode()
    {
        return igk_html_node_htmlnode(...func_get_args());
    }
}
if (!function_exists("huebar")) {
    function huebar()
    {
        return igk_html_node_huebar(...func_get_args());
    }
}
if (!function_exists("i")) {
    function i()
    {
        return igk_create_node("i", null, func_get_args());
    }
}
if (!function_exists("ibview")) {
    function ibview()
    {
        return igk_html_node_ibview(...func_get_args());
    }
}
if (!function_exists("if_condition")) {
    function if_condition()
    {
        return igk_html_node_if_condition(...func_get_args());
    }
}
if (!function_exists("if_node")) {
    function if_node()
    {
        return igk_html_node_if(...func_get_args());
    }
}
if (!function_exists("iframe")) {
    function iframe()
    {
        return igk_create_node("iframe", null, func_get_args());
    }
}
if (!function_exists("igkcopyright")) {
    function igkcopyright()
    {
        return igk_html_node_igkcopyright(...func_get_args());
    }
}
if (!function_exists("igkgloballangselector")) {
    function igkgloballangselector()
    {
        return igk_html_node_igkgloballangselector(...func_get_args());
    }
}
if (!function_exists("igkglobalthemeselector")) {
    function igkglobalthemeselector()
    {
        return igk_html_node_igkglobalthemeselector(...func_get_args());
    }
}
if (!function_exists("igkheaderbar")) {
    function igkheaderbar()
    {
        return igk_html_node_igkheaderbar(...func_get_args());
    }
}
if (!function_exists("igksitemap")) {
    function igksitemap()
    {
        return igk_html_node_igksitemap(...func_get_args());
    }
}
if (!function_exists("imagenode")) {
    function imagenode()
    {
        return igk_html_node_imagenode(...func_get_args());
    }
}
if (!function_exists("img")) {
    function img()
    {
        return igk_html_node_img(...func_get_args());
    }
}
if (!function_exists("imglnk")) {
    function imglnk()
    {
        return igk_html_node_imglnk(...func_get_args());
    }
}
if (!function_exists("include_js")) {
    function include_js()
    {
        return igk_html_node_include_js(...func_get_args());
    }
}
if (!function_exists("include_node")) {
    function include_node()
    {
        return igk_html_node_include(...func_get_args());
    }
}
if (!function_exists("innerimg")) {
    function innerimg()
    {
        return igk_html_node_innerimg(...func_get_args());
    }
}
if (!function_exists("input")) {
    function input()
    {
        return igk_html_node_input(...func_get_args());
    }
}
if (!function_exists("ins")) {
    function ins()
    {
        return igk_create_node("ins", null, func_get_args());
    }
}
if (!function_exists("jombotron")) {
    function jombotron()
    {
        return igk_html_node_jombotron(...func_get_args());
    }
}
if (!function_exists("js_autofix_width")) {
    function js_autofix_width()
    {
        return igk_html_node_js_autofix_width(...func_get_args());
    }
}
if (!function_exists("jsaextern")) {
    function jsaextern()
    {
        return igk_html_node_jsaextern(...func_get_args());
    }
}
if (!function_exists("jsbindns")) {
    function jsbindns()
    {
        return igk_html_node_jsbindns(...func_get_args());
    }
}
if (!function_exists("jsbtn")) {
    function jsbtn()
    {
        return igk_html_node_jsbtn(...func_get_args());
    }
}
if (!function_exists("jsbtnshowdialog")) {
    function jsbtnshowdialog()
    {
        return igk_html_node_jsbtnshowdialog(...func_get_args());
    }
}
if (!function_exists("jsbutton")) {
    function jsbutton()
    {
        return igk_html_node_jsbutton(...func_get_args());
    }
}
if (!function_exists("jsclone")) {
    function jsclone()
    {
        return igk_html_node_jsclone(...func_get_args());
    }
}
if (!function_exists("jsclonenode")) {
    function jsclonenode()
    {
        return igk_html_node_jsclonenode(...func_get_args());
    }
}
if (!function_exists("jsclonetarget")) {
    function jsclonetarget()
    {
        return igk_html_node_jsclonetarget(...func_get_args());
    }
}
if (!function_exists("jslogger")) {
    function jslogger()
    {
        return igk_html_node_jslogger(...func_get_args());
    }
}
if (!function_exists("jspwa")) {
    function jspwa()
    {
        return igk_html_node_jspwa(...func_get_args());
    }
}
if (!function_exists("jsreadyscript")) {
    function jsreadyscript()
    {
        return igk_html_node_jsreadyscript(...func_get_args());
    }
}
if (!function_exists("jsreplaceuri")) {
    function jsreplaceuri()
    {
        return igk_html_node_jsreplaceuri(...func_get_args());
    }
}
if (!function_exists("jsscript")) {
    function jsscript()
    {
        return igk_html_node_jsscript(...func_get_args());
    }
}
if (!function_exists("jsscript_options")) {
    function jsscript_options()
    {
        return igk_html_node_jsscript_options(...func_get_args());
    }
}
if (!function_exists("jsserviceworker")) {
    function jsserviceworker()
    {
        return igk_html_node_jsserviceworker(...func_get_args());
    }
}
if (!function_exists("jsview")) {
    function jsview()
    {
        return igk_html_node_jsview(...func_get_args());
    }
}
if (!function_exists("jswaiter")) {
    function jswaiter()
    {
        return igk_html_node_jswaiter(...func_get_args());
    }
}
if (!function_exists("jumbotron")) {
    function jumbotron()
    {
        return igk_html_node_jumbotron(...func_get_args());
    }
}
if (!function_exists("kbd")) {
    function kbd()
    {
        return igk_create_node("kbd", null, func_get_args());
    }
}
if (!function_exists("keygen")) {
    function keygen()
    {
        return igk_create_node("keygen", null, func_get_args());
    }
}
if (!function_exists("label")) {
    function label()
    {
        return igk_html_node_label(...func_get_args());
    }
}
if (!function_exists("labelinput")) {
    function labelinput()
    {
        return igk_html_node_labelinput(...func_get_args());
    }
}
if (!function_exists("layout")) {
    function layout()
    {
        return igk_html_node_layout(...func_get_args());
    }
}
if (!function_exists("layoutpresentation")) {
    function layoutpresentation()
    {
        return igk_html_node_layoutpresentation(...func_get_args());
    }
}
if (!function_exists("lborder")) {
    function lborder()
    {
        return igk_html_node_lborder(...func_get_args());
    }
}
if (!function_exists("legend")) {
    function legend()
    {
        return igk_create_node("legend", null, func_get_args());
    }
}
if (!function_exists("li")) {
    function li()
    {
        return igk_create_node("li", null, func_get_args());
    }
}
if (!function_exists("linewaiter")) {
    function linewaiter()
    {
        return igk_html_node_linewaiter(...func_get_args());
    }
}
if (!function_exists("link")) {
    function link()
    {
        return igk_create_node("link", null, func_get_args());
    }
}
if (!function_exists("linkbtn")) {
    function linkbtn()
    {
        return igk_html_node_linkbtn(...func_get_args());
    }
}
if (!function_exists("list_node")) {
    function list_node()
    {
        return igk_html_node_list(...func_get_args());
    }
}
if (!function_exists("listitem")) {
    function listitem()
    {
        return igk_html_node_listitem(...func_get_args());
    }
}
if (!function_exists("livenodecallback")) {
    function livenodecallback()
    {
        return igk_html_node_livenodecallback(...func_get_args());
    }
}
if (!function_exists("load_array")) {
    function load_array()
    {
        return igk_html_node_load_array(...func_get_args());
    }
}
if (!function_exists("loadarticle")) {
    function loadarticle()
    {
        return igk_html_node_loadarticle(...func_get_args());
    }
}
if (!function_exists("localizabletext")) {
    function localizabletext()
    {
        return igk_html_node_localizabletext(...func_get_args());
    }
}
if (!function_exists("login_form")) {
    function login_form()
    {
        return igk_html_node_login_form(...func_get_args());
    }
}
if (!function_exists("logo")) {
    function logo()
    {
        return igk_html_node_logo(...func_get_args());
    }
}
if (!function_exists("loop")) {
    function loop()
    {
        return igk_html_node_loop(...func_get_args());
    }
}
if (!function_exists("loremipsum")) {
    function loremipsum()
    {
        return igk_html_node_loremipsum(...func_get_args());
    }
}
if (!function_exists("mailto")) {
    function mailto()
    {
        return igk_html_node_mailto(...func_get_args());
    }
}
if (!function_exists("main")) {
    function main()
    {
        return igk_create_node("main", null, func_get_args());
    }
}
if (!function_exists("map")) {
    function map()
    {
        return igk_create_node("map", null, func_get_args());
    }
}
if (!function_exists("mark")) {
    function mark()
    {
        return igk_create_node("mark", null, func_get_args());
    }
}
if (!function_exists("markdown_document")) {
    function markdown_document()
    {
        return igk_html_node_markdown_document(...func_get_args());
    }
}
if (!function_exists("memoryusageinfo")) {
    function memoryusageinfo()
    {
        return igk_html_node_memoryusageinfo(...func_get_args());
    }
}
if (!function_exists("menu")) {
    function menu()
    {
        return igk_create_node("menu", null, func_get_args());
    }
}
if (!function_exists("menuitem")) {
    function menuitem()
    {
        return igk_create_node("menuitem", null, func_get_args());
    }
}
if (!function_exists("menukey")) {
    function menukey()
    {
        return igk_html_node_menukey(...func_get_args());
    }
}
if (!function_exists("menulayer")) {
    function menulayer()
    {
        return igk_html_node_menulayer(...func_get_args());
    }
}
if (!function_exists("menulist")) {
    function menulist()
    {
        return igk_html_node_menulist(...func_get_args());
    }
}
if (!function_exists("menus")) {
    function menus()
    {
        return igk_html_node_menus(...func_get_args());
    }
}
if (!function_exists("meta")) {
    function meta()
    {
        return igk_create_node("meta", null, func_get_args());
    }
}
if (!function_exists("meter")) {
    function meter()
    {
        return igk_create_node("meter", null, func_get_args());
    }
}
if (!function_exists("moreview")) {
    function moreview()
    {
        return igk_html_node_moreview(...func_get_args());
    }
}
if (!function_exists("msdialog")) {
    function msdialog()
    {
        return igk_html_node_msdialog(...func_get_args());
    }
}
if (!function_exists("mstitle")) {
    function mstitle()
    {
        return igk_html_node_mstitle(...func_get_args());
    }
}
if (!function_exists("nav")) {
    function nav()
    {
        return igk_create_node("nav", null, func_get_args());
    }
}
if (!function_exists("navigationlink")) {
    function navigationlink()
    {
        return igk_html_node_navigationlink(...func_get_args());
    }
}
if (!function_exists("nbsp")) {
    function nbsp()
    {
        return igk_html_node_nbsp(...func_get_args());
    }
}
if (!function_exists("newsletterregistration")) {
    function newsletterregistration()
    {
        return igk_html_node_newsletterregistration(...func_get_args());
    }
}
if (!function_exists("noframes")) {
    function noframes()
    {
        return igk_create_node("noframes", null, func_get_args());
    }
}
if (!function_exists("noscript")) {
    function noscript()
    {
        return igk_create_node("noscript", null, func_get_args());
    }
}
if (!function_exists("notagnode")) {
    function notagnode()
    {
        return igk_html_node_notagnode(...func_get_args());
    }
}
if (!function_exists("notagobdata")) {
    function notagobdata()
    {
        return igk_html_node_notagobdata(...func_get_args());
    }
}
if (!function_exists("notification")) {
    function notification()
    {
        return igk_html_node_notification(...func_get_args());
    }
}
if (!function_exists("notifyhost")) {
    function notifyhost()
    {
        return igk_html_node_notifyhost(...func_get_args());
    }
}
if (!function_exists("notifyhostbind")) {
    function notifyhostbind()
    {
        return igk_html_node_notifyhostbind(...func_get_args());
    }
}
if (!function_exists("notifyzone")) {
    function notifyzone()
    {
        return igk_html_node_notifyzone(...func_get_args());
    }
}
if (!function_exists("obdata")) {
    function obdata()
    {
        return igk_html_node_obdata(...func_get_args());
    }
}
if (!function_exists("object")) {
    function object()
    {
        return igk_create_node("object", null, func_get_args());
    }
}
if (!function_exists("obscript")) {
    function obscript()
    {
        return igk_html_node_obscript(...func_get_args());
    }
}
if (!function_exists("ol")) {
    function ol()
    {
        return igk_create_node("ol", null, func_get_args());
    }
}
if (!function_exists("onrendercallback")) {
    function onrendercallback()
    {
        return igk_html_node_onrendercallback(...func_get_args());
    }
}
if (!function_exists("optgroup")) {
    function optgroup()
    {
        return igk_create_node("optgroup", null, func_get_args());
    }
}
if (!function_exists("option")) {
    function option()
    {
        return igk_create_node("option", null, func_get_args());
    }
}
if (!function_exists("output")) {
    function output()
    {
        return igk_create_node("output", null, func_get_args());
    }
}
if (!function_exists("p")) {
    function p()
    {
        return igk_create_node("p", null, func_get_args());
    }
}
if (!function_exists("page")) {
    function page()
    {
        return igk_html_node_page(...func_get_args());
    }
}
if (!function_exists("pagecenterbox")) {
    function pagecenterbox()
    {
        return igk_html_node_pagecenterbox(...func_get_args());
    }
}
if (!function_exists("paginationview")) {
    function paginationview()
    {
        return igk_html_node_paginationview(...func_get_args());
    }
}
if (!function_exists("panelbox")) {
    function panelbox()
    {
        return igk_html_node_panelbox(...func_get_args());
    }
}
if (!function_exists("paneldialog")) {
    function paneldialog()
    {
        return igk_html_node_paneldialog(...func_get_args());
    }
}
if (!function_exists("parallaxnode")) {
    function parallaxnode()
    {
        return igk_html_node_parallaxnode(...func_get_args());
    }
}
if (!function_exists("param")) {
    function param()
    {
        return igk_create_node("param", null, func_get_args());
    }
}
if (!function_exists("paypal_button")) {
    function paypal_button()
    {
        return igk_html_node_paypal_button(...func_get_args());
    }
}
if (!function_exists("picker_zone")) {
    function picker_zone()
    {
        return igk_html_node_picker_zone(...func_get_args());
    }
}
if (!function_exists("picture")) {
    function picture()
    {
        return igk_create_node("picture", null, func_get_args());
    }
}
if (!function_exists("popupmenu")) {
    function popupmenu()
    {
        return igk_html_node_popupmenu(...func_get_args());
    }
}
if (!function_exists("pre")) {
    function pre()
    {
        return igk_html_node_pre(...func_get_args());
    }
}
if (!function_exists("printbtn")) {
    function printbtn()
    {
        return igk_html_node_printbtn(...func_get_args());
    }
}
if (!function_exists("progress")) {
    function progress()
    {
        return igk_create_node("progress", null, func_get_args());
    }
}
if (!function_exists("progressbar")) {
    function progressbar()
    {
        return igk_html_node_progressbar(...func_get_args());
    }
}
if (!function_exists("pwa_install_button")) {
    function pwa_install_button()
    {
        return igk_html_node_pwa_install_button(...func_get_args());
    }
}
if (!function_exists("pwa_install_script")) {
    function pwa_install_script()
    {
        return igk_html_node_pwa_install_script(...func_get_args());
    }
}
if (!function_exists("pwa_script")) {
    function pwa_script()
    {
        return igk_html_node_pwa_script(...func_get_args());
    }
}
if (!function_exists("q")) {
    function q()
    {
        return igk_create_node("q", null, func_get_args());
    }
}
if (!function_exists("radiobutton")) {
    function radiobutton()
    {
        return igk_html_node_radiobutton(...func_get_args());
    }
}
if (!function_exists("readonlytextzone")) {
    function readonlytextzone()
    {
        return igk_html_node_readonlytextzone(...func_get_args());
    }
}
if (!function_exists("registermailform")) {
    function registermailform()
    {
        return igk_html_node_registermailform(...func_get_args());
    }
}
if (!function_exists("renderingexpression")) {
    function renderingexpression()
    {
        return igk_html_node_renderingexpression(...func_get_args());
    }
}
if (!function_exists("repeatcontent")) {
    function repeatcontent()
    {
        return igk_html_node_repeatcontent(...func_get_args());
    }
}
if (!function_exists("replace_uri")) {
    function replace_uri()
    {
        return igk_html_node_replace_uri(...func_get_args());
    }
}
if (!function_exists("resimg")) {
    function resimg()
    {
        return igk_html_node_resimg(...func_get_args());
    }
}
if (!function_exists("responsenode")) {
    function responsenode()
    {
        return igk_html_node_responsenode(...func_get_args());
    }
}
if (!function_exists("rollin")) {
    function rollin()
    {
        return igk_html_node_rollin(...func_get_args());
    }
}
if (!function_exists("roundbullet")) {
    function roundbullet()
    {
        return igk_html_node_roundbullet(...func_get_args());
    }
}
if (!function_exists("row")) {
    function row()
    {
        return igk_html_node_row(...func_get_args());
    }
}
if (!function_exists("rowcolumn")) {
    function rowcolumn()
    {
        return igk_html_node_rowcolumn(...func_get_args());
    }
}
if (!function_exists("rowcontainer")) {
    function rowcontainer()
    {
        return igk_html_node_rowcontainer(...func_get_args());
    }
}
if (!function_exists("rp")) {
    function rp()
    {
        return igk_create_node("rp", null, func_get_args());
    }
}
if (!function_exists("rt")) {
    function rt()
    {
        return igk_create_node("rt", null, func_get_args());
    }
}
if (!function_exists("ruby")) {
    function ruby()
    {
        return igk_create_node("ruby", null, func_get_args());
    }
}
if (!function_exists("s")) {
    function s()
    {
        return igk_create_node("s", null, func_get_args());
    }
}
if (!function_exists("samp")) {
    function samp()
    {
        return igk_create_node("samp", null, func_get_args());
    }
}
if (!function_exists("script")) {
    function script()
    {
        return igk_html_node_script(...func_get_args());
    }
}
if (!function_exists("script_var")) {
    function script_var()
    {
        return igk_html_node_script_var(...func_get_args());
    }
}
if (!function_exists("scrollimg")) {
    function scrollimg()
    {
        return igk_html_node_scrollimg(...func_get_args());
    }
}
if (!function_exists("scrollloader")) {
    function scrollloader()
    {
        return igk_html_node_scrollloader(...func_get_args());
    }
}
if (!function_exists("search_box")) {
    function search_box()
    {
        return igk_html_node_search_box(...func_get_args());
    }
}
if (!function_exists("searchbox")) {
    function searchbox()
    {
        return igk_html_node_searchbox(...func_get_args());
    }
}
if (!function_exists("searchbutton")) {
    function searchbutton()
    {
        return igk_html_node_searchbutton(...func_get_args());
    }
}
if (!function_exists("searchfield")) {
    function searchfield()
    {
        return igk_html_node_searchfield(...func_get_args());
    }
}
if (!function_exists("section")) {
    function section()
    {
        return igk_create_node("section", null, func_get_args());
    }
}
if (!function_exists("sectiontitle")) {
    function sectiontitle()
    {
        return igk_html_node_sectiontitle(...func_get_args());
    }
}
if (!function_exists("select")) {
    function select()
    {
        return igk_html_node_select(...func_get_args());
    }
}
if (!function_exists("select_options")) {
    function select_options()
    {
        return igk_html_node_select_options(...func_get_args());
    }
}
if (!function_exists("selecttag")) {
    function selecttag()
    {
        return igk_html_node_selecttag(...func_get_args());
    }
}
if (!function_exists("separator")) {
    function separator()
    {
        return igk_html_node_separator(...func_get_args());
    }
}
if (!function_exists("sfsymbol")) {
    function sfsymbol()
    {
        return igk_html_node_sfsymbol(...func_get_args());
    }
}
if (!function_exists("sharedwithcommunity")) {
    function sharedwithcommunity()
    {
        return igk_html_node_sharedwithcommunity(...func_get_args());
    }
}
if (!function_exists("sidemenunavigation")) {
    function sidemenunavigation()
    {
        return igk_html_node_sidemenunavigation(...func_get_args());
    }
}
if (!function_exists("singlenodeviewer")) {
    function singlenodeviewer()
    {
        return igk_html_node_singlenodeviewer(...func_get_args());
    }
}
if (!function_exists("singlerowcol")) {
    function singlerowcol()
    {
        return igk_html_node_singlerowcol(...func_get_args());
    }
}
if (!function_exists("singleviewnode")) {
    function singleviewnode()
    {
        return igk_html_node_singleviewnode(...func_get_args());
    }
}
if (!function_exists("slabelcheckbox")) {
    function slabelcheckbox()
    {
        return igk_html_node_slabelcheckbox(...func_get_args());
    }
}
if (!function_exists("slabelinput")) {
    function slabelinput()
    {
        return igk_html_node_slabelinput(...func_get_args());
    }
}
if (!function_exists("slabelselect")) {
    function slabelselect()
    {
        return igk_html_node_slabelselect(...func_get_args());
    }
}
if (!function_exists("slabeltextarea")) {
    function slabeltextarea()
    {
        return igk_html_node_slabeltextarea(...func_get_args());
    }
}
if (!function_exists("small")) {
    function small()
    {
        return igk_create_node("small", null, func_get_args());
    }
}
if (!function_exists("source")) {
    function source()
    {
        return igk_create_node("source", null, func_get_args());
    }
}
if (!function_exists("space")) {
    function space()
    {
        return igk_html_node_space(...func_get_args());
    }
}
if (!function_exists("span")) {
    function span()
    {
        return igk_create_node("span", null, func_get_args());
    }
}
if (!function_exists("span_label")) {
    function span_label()
    {
        return igk_html_node_span_label(...func_get_args());
    }
}
if (!function_exists("spangroup")) {
    function spangroup()
    {
        return igk_html_node_spangroup(...func_get_args());
    }
}
if (!function_exists("spanlink")) {
    function spanlink()
    {
        return igk_html_node_spanlink(...func_get_args());
    }
}
if (!function_exists("strike")) {
    function strike()
    {
        return igk_create_node("strike", null, func_get_args());
    }
}
if (!function_exists("strong")) {
    function strong()
    {
        return igk_create_node("strong", null, func_get_args());
    }
}
if (!function_exists("style")) {
    function style()
    {
        return igk_html_node_style(...func_get_args());
    }
}
if (!function_exists("sub")) {
    function sub()
    {
        return igk_create_node("sub", null, func_get_args());
    }
}
if (!function_exists("submit")) {
    function submit()
    {
        return igk_html_node_submit(...func_get_args());
    }
}
if (!function_exists("submitbtn")) {
    function submitbtn()
    {
        return igk_html_node_submitbtn(...func_get_args());
    }
}
if (!function_exists("summary")) {
    function summary()
    {
        return igk_create_node("summary", null, func_get_args());
    }
}
if (!function_exists("sup")) {
    function sup()
    {
        return igk_create_node("sup", null, func_get_args());
    }
}
if (!function_exists("svg")) {
    function svg()
    {
        return igk_create_node("svg", null, func_get_args());
    }
}
if (!function_exists("svg_container")) {
    function svg_container()
    {
        return igk_html_node_svg_container(...func_get_args());
    }
}
if (!function_exists("svga")) {
    function svga()
    {
        return igk_html_node_svga(...func_get_args());
    }
}
if (!function_exists("svgajxformbtn")) {
    function svgajxformbtn()
    {
        return igk_html_node_svgajxformbtn(...func_get_args());
    }
}
if (!function_exists("svglnkbtn")) {
    function svglnkbtn()
    {
        return igk_html_node_svglnkbtn(...func_get_args());
    }
}
if (!function_exists("svgsymbol")) {
    function svgsymbol()
    {
        return igk_html_node_svgsymbol(...func_get_args());
    }
}
if (!function_exists("svguse")) {
    function svguse()
    {
        return igk_html_node_svguse(...func_get_args());
    }
}
if (!function_exists("swagger_app")) {
    function swagger_app()
    {
        return igk_html_node_swagger_app(...func_get_args());
    }
}
if (!function_exists("symbol")) {
    function symbol()
    {
        return igk_html_node_symbol(...func_get_args());
    }
}
if (!function_exists("sysarticle")) {
    function sysarticle()
    {
        return igk_html_node_sysarticle(...func_get_args());
    }
}
if (!function_exists("tabbutton")) {
    function tabbutton()
    {
        return igk_html_node_tabbutton(...func_get_args());
    }
}
if (!function_exists("table")) {
    function table()
    {
        return igk_html_node_table(...func_get_args());
    }
}
if (!function_exists("tableheader")) {
    function tableheader()
    {
        return igk_html_node_tableheader(...func_get_args());
    }
}
if (!function_exists("tablehost")) {
    function tablehost()
    {
        return igk_html_node_tablehost(...func_get_args());
    }
}
if (!function_exists("tbncommunityzone")) {
    function tbncommunityzone()
    {
        return igk_html_node_tbncommunityzone(...func_get_args());
    }
}
if (!function_exists("tbncontributorcommunauty")) {
    function tbncontributorcommunauty()
    {
        return igk_html_node_tbncontributorcommunauty(...func_get_args());
    }
}
if (!function_exists("tbnpresentationnode")) {
    function tbnpresentationnode()
    {
        return igk_html_node_tbnpresentationnode(...func_get_args());
    }
}
if (!function_exists("tbnunderconstructionpage")) {
    function tbnunderconstructionpage()
    {
        return igk_html_node_tbnunderconstructionpage(...func_get_args());
    }
}
if (!function_exists("tbody")) {
    function tbody()
    {
        return igk_create_node("tbody", null, func_get_args());
    }
}
if (!function_exists("td")) {
    function td()
    {
        return igk_html_node_td(...func_get_args());
    }
}
if (!function_exists("template")) {
    function template()
    {
        return igk_html_node_template(...func_get_args());
    }
}
if (!function_exists("text")) {
    function text()
    {
        return igk_html_node_text(...func_get_args());
    }
}
if (!function_exists("textarea")) {
    function textarea()
    {
        return igk_html_node_textarea(...func_get_args());
    }
}
if (!function_exists("textedit")) {
    function textedit()
    {
        return igk_html_node_textedit(...func_get_args());
    }
}
if (!function_exists("tfoot")) {
    function tfoot()
    {
        return igk_create_node("tfoot", null, func_get_args());
    }
}
if (!function_exists("th")) {
    function th()
    {
        return igk_create_node("th", null, func_get_args());
    }
}
if (!function_exists("thead")) {
    function thead()
    {
        return igk_create_node("thead", null, func_get_args());
    }
}
if (!function_exists("thumbnaildocument")) {
    function thumbnaildocument()
    {
        return igk_html_node_thumbnaildocument(...func_get_args());
    }
}
if (!function_exists("time")) {
    function time()
    {
        return igk_html_node_time(...func_get_args());
    }
}
if (!function_exists("tip")) {
    function tip()
    {
        return igk_html_node_tip(...func_get_args());
    }
}
if (!function_exists("title")) {
    function title()
    {
        return igk_create_node("title", null, func_get_args());
    }
}
if (!function_exists("titlelevel")) {
    function titlelevel()
    {
        return igk_html_node_titlelevel(...func_get_args());
    }
}
if (!function_exists("titlenode")) {
    function titlenode()
    {
        return igk_html_node_titlenode(...func_get_args());
    }
}
if (!function_exists("toast")) {
    function toast()
    {
        return igk_html_node_toast(...func_get_args());
    }
}
if (!function_exists("toast_notify")) {
    function toast_notify()
    {
        return igk_html_node_toast_notify(...func_get_args());
    }
}
if (!function_exists("togglebutton")) {
    function togglebutton()
    {
        return igk_html_node_togglebutton(...func_get_args());
    }
}
if (!function_exists("togglestatebutton")) {
    function togglestatebutton()
    {
        return igk_html_node_togglestatebutton(...func_get_args());
    }
}
if (!function_exists("togglethemebutton")) {
    function togglethemebutton()
    {
        return igk_html_node_togglethemebutton(...func_get_args());
    }
}
if (!function_exists("tooltip")) {
    function tooltip()
    {
        return igk_html_node_tooltip(...func_get_args());
    }
}
if (!function_exists("topnavbar")) {
    function topnavbar()
    {
        return igk_html_node_topnavbar(...func_get_args());
    }
}
if (!function_exists("tr")) {
    function tr()
    {
        return igk_create_node("tr", null, func_get_args());
    }
}
if (!function_exists("track")) {
    function track()
    {
        return igk_create_node("track", null, func_get_args());
    }
}
if (!function_exists("trackbarnode")) {
    function trackbarnode()
    {
        return igk_html_node_trackbarnode(...func_get_args());
    }
}
if (!function_exists("transitionblock")) {
    function transitionblock()
    {
        return igk_html_node_transitionblock(...func_get_args());
    }
}
if (!function_exists("tt")) {
    function tt()
    {
        return igk_create_node("tt", null, func_get_args());
    }
}
if (!function_exists("twitterfollowus")) {
    function twitterfollowus()
    {
        return igk_html_node_twitterfollowus(...func_get_args());
    }
}
if (!function_exists("twittertimeline")) {
    function twittertimeline()
    {
        return igk_html_node_twittertimeline(...func_get_args());
    }
}
if (!function_exists("u")) {
    function u()
    {
        return igk_create_node("u", null, func_get_args());
    }
}
if (!function_exists("uitrack")) {
    function uitrack()
    {
        return igk_html_node_uitrack(...func_get_args());
    }
}
if (!function_exists("ul")) {
    function ul()
    {
        return igk_create_node("ul", null, func_get_args());
    }
}
if (!function_exists("underconstructionpage")) {
    function underconstructionpage()
    {
        return igk_html_node_underconstructionpage(...func_get_args());
    }
}
if (!function_exists("userinfo")) {
    function userinfo()
    {
        return igk_html_node_userinfo(...func_get_args());
    }
}
if (!function_exists("usesvg")) {
    function usesvg()
    {
        return igk_html_node_usesvg(...func_get_args());
    }
}
if (!function_exists("video")) {
    function video()
    {
        return igk_create_node("video", null, func_get_args());
    }
}
if (!function_exists("videocontrols")) {
    function videocontrols()
    {
        return igk_html_node_videocontrols(...func_get_args());
    }
}
if (!function_exists("videofilestream")) {
    function videofilestream()
    {
        return igk_html_node_videofilestream(...func_get_args());
    }
}
if (!function_exists("view_code")) {
    function view_code()
    {
        return igk_html_node_view_code(...func_get_args());
    }
}
if (!function_exists("view_include")) {
    function view_include()
    {
        return igk_html_node_view_include(...func_get_args());
    }
}
if (!function_exists("viewcallback")) {
    function viewcallback()
    {
        return igk_html_node_viewcallback(...func_get_args());
    }
}
if (!function_exists("viewcontent")) {
    function viewcontent()
    {
        return igk_html_node_viewcontent(...func_get_args());
    }
}
if (!function_exists("visible")) {
    function visible()
    {
        return igk_html_node_visible(...func_get_args());
    }
}
if (!function_exists("vite_app")) {
    function vite_app()
    {
        return igk_html_node_vite_app(...func_get_args());
    }
}
if (!function_exists("vite_tag")) {
    function vite_tag()
    {
        return igk_html_node_vite_tag(...func_get_args());
    }
}
if (!function_exists("voku_paginator")) {
    function voku_paginator()
    {
        return igk_html_node_voku_paginator(...func_get_args());
    }
}
if (!function_exists("vscrollbar")) {
    function vscrollbar()
    {
        return igk_html_node_vscrollbar(...func_get_args());
    }
}
if (!function_exists("vsep")) {
    function vsep()
    {
        return igk_html_node_vsep(...func_get_args());
    }
}
if (!function_exists("vue_app")) {
    function vue_app()
    {
        return igk_html_node_vue_app(...func_get_args());
    }
}
if (!function_exists("vue_clone")) {
    function vue_clone()
    {
        return igk_html_node_vue_clone(...func_get_args());
    }
}
if (!function_exists("vue_component")) {
    function vue_component()
    {
        return igk_html_node_vue_component(...func_get_args());
    }
}
if (!function_exists("vue_item")) {
    function vue_item()
    {
        return igk_html_node_vue_item(...func_get_args());
    }
}
if (!function_exists("vue_menus")) {
    function vue_menus()
    {
        return igk_html_node_vue_menus(...func_get_args());
    }
}
if (!function_exists("vue_notag")) {
    function vue_notag()
    {
        return igk_html_node_vue_notag(...func_get_args());
    }
}
if (!function_exists("vue_router_link")) {
    function vue_router_link()
    {
        return igk_html_node_vue_router_link(...func_get_args());
    }
}
if (!function_exists("vue_scripttemplate")) {
    function vue_scripttemplate()
    {
        return igk_html_node_vue_scripttemplate(...func_get_args());
    }
}
if (!function_exists("vue_sfc_app")) {
    function vue_sfc_app()
    {
        return igk_html_node_vue_sfc_app(...func_get_args());
    }
}
if (!function_exists("vue_xtemplate")) {
    function vue_xtemplate()
    {
        return igk_html_node_vue_xtemplate(...func_get_args());
    }
}
if (!function_exists("walk")) {
    function walk()
    {
        return igk_html_node_walk(...func_get_args());
    }
}
if (!function_exists("wbr")) {
    function wbr()
    {
        return igk_create_node("wbr", null, func_get_args());
    }
}
if (!function_exists("webarticle")) {
    function webarticle()
    {
        return igk_html_node_webarticle(...func_get_args());
    }
}
if (!function_exists("webgl_surface")) {
    function webgl_surface()
    {
        return igk_html_node_webgl_surface(...func_get_args());
    }
}
if (!function_exists("webglgamesurface")) {
    function webglgamesurface()
    {
        return igk_html_node_webglgamesurface(...func_get_args());
    }
}
if (!function_exists("webglscriptsurface")) {
    function webglscriptsurface()
    {
        return igk_html_node_webglscriptsurface(...func_get_args());
    }
}
if (!function_exists("webglsurface")) {
    function webglsurface()
    {
        return igk_html_node_webglsurface(...func_get_args());
    }
}
if (!function_exists("webmasternode")) {
    function webmasternode()
    {
        return igk_html_node_webmasternode(...func_get_args());
    }
}
if (!function_exists("widget")) {
    function widget()
    {
        return igk_html_node_widget(...func_get_args());
    }
}
if (!function_exists("word")) {
    function word()
    {
        return igk_html_node_word(...func_get_args());
    }
}
if (!function_exists("wordcasesplitter")) {
    function wordcasesplitter()
    {
        return igk_html_node_wordcasesplitter(...func_get_args());
    }
}
if (!function_exists("wordsplitview")) {
    function wordsplitview()
    {
        return igk_html_node_wordsplitview(...func_get_args());
    }
}
if (!function_exists("xmlnode")) {
    function xmlnode()
    {
        return igk_html_node_xmlnode(...func_get_args());
    }
}
if (!function_exists("xmlviewer")) {
    function xmlviewer()
    {
        return igk_html_node_xmlviewer(...func_get_args());
    }
}
if (!function_exists("xslt")) {
    function xslt()
    {
        return igk_html_node_xslt(...func_get_args());
    }
}
if (!function_exists("xsltranform")) {
    function xsltranform()
    {
        return igk_html_node_xsltranform(...func_get_args());
    }
}
if (!function_exists("yield_node")) {
    function yield_node()
    {
        return igk_html_node_yield(...func_get_args());
    }
}
if (!function_exists("youtubevideo")) {
    function youtubevideo()
    {
        return igk_html_node_youtubevideo(...func_get_args());
    }
}