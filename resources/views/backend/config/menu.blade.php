@extends('backend.master')
@section('title', 'System Manager')
@section('content')
<style>
    a,a:visited {
    color: #4183C4;
    text-decoration: none;
    }
    a:hover {
    text-decoration: underline;
    }
    pre,code {
    font-size: 12px;
    }
    pre {
    width: 100%;
    overflow: auto;
    }
    small {
    font-size: 90%;
    }
    small code {
    font-size: 11px;
    }
    .placeholder {
    outline: 1px dashed #4183C4;
    }
    .mjs-nestedSortable-error {
    background: #fbe3e4;
    border-color: transparent;
    }
    #tree {
    width: 550px;
    margin: 0;
    }
    ol {
    max-width: 650px;
    padding-left: 25px;
    }
    ol.sortable,ol.sortable ol {
    list-style-type: none;
    }
    .sortable li div {
        border: 1px solid #d4d4d4;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        cursor: move;
        border-color: #D4D4D4 #D4D4D4 #BCBCBC;
        margin-bottom: 10px;
        padding: 3px;
    }
    li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
    border-color: #999;
    }
    .disclose, .expandEditor {
    cursor: pointer;
    width: 20px;
    display: none;
    }
    .sortable li.mjs-nestedSortable-collapsed > ol {
    display: none;
    }
    .sortable li.mjs-nestedSortable-branch > div > .disclose {
    display: inline-block;
    }
    .sortable span.ui-icon {
    display: inline-block;
    margin: 0;
    padding: 0;
    }
    .menuDiv {
    background: #EBEBEB;
    }
    .menuEdit {
    background: #FFF;
    }
    .itemTitle {
    vertical-align: middle;
    cursor: pointer;
    }
    .deleteMenu {
    float: right;
    cursor: pointer;
    }
    h1 {
    font-size: 2em;
    margin-bottom: 0;
    }
    h2 {
    font-size: 1.2em;
    font-weight: 400;
    font-style: italic;
    margin-top: .2em;
    margin-bottom: 1.5em;
    }
    h3 {
    font-size: 1em;
    margin: 1em 0 .3em;
    }
    p,ol,ul,pre,form {
    margin-top: 0;
    margin-bottom: 1em;
    }
    dl {
    margin: 0;
    }
    dd {
    margin: 0;
    padding: 0 0 0 1.5em;
    }
    code {
    background: #e5e5e5;
    }
    input {
    vertical-align: text-bottom;
    }
    .notice {
    color: #c33;
    }
    .setup-menu .dropdown-toggle{
        width: 100%;
        text-align: left;
    }
    .setup-menu .dropdown-toggle .caret{
        float: right;
        position: relative;
        top:10px;
    }
    .setup-menu .dropdown-menu{
        width: 100%;
        padding: 10px;
    }
    .setup-menu .btn-add-menu{
        text-align: center;
        margin-top: 10px;
    }

</style>
<script src="{{ asset('backend/js/jquery-ui.js') }}"></script>
<script src="{{ asset('backend/js/jquery.mjs.nestedSortable.js') }}"></script>
<script src="{{ asset('backend/js/multi-checkbox.js') }}"></script>
<link rel="stylesheet" href="{{ asset('backend/css/multi-checkbox.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/jquery-ui.css') }}">

<section class="content-header">
    <h1 class="text-center font-weight-600">Thiết lập menu</h1>
</section>
<section class="content setup-menu">
    <div class="row">
        <div class="col-sm-offset-7 col-sm-5">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <label>
                                Menu:
                            </label>
                            <div class="translation-column">
                                <select name="id-menu" class="form-control">
                                    <option value="1">Menu chính</option>
                                    <option value="2">Menu Footer</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <label>
                                Ngôn ngữ:
                            </label>
                            <div class="translation-column">
                                <select name="language_id" class="form-control">
                                    <option value="en" selected>English</option>
                                    <option value="vi"  >Tiếng Việt</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-4">
<!--             <div class="form-group" id="pages">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Page
                    <span class="caret"></span></button>
                    <div class="dropdown-menu" role="menu" data-table="pages_translate" data-route="client.show-page">
                        @if(!empty($list_page))
                        <select id="my-select-page" name="page" multiple="multiple">
                            {!!  $list_page !!}
                        </select>
                        <div id="simulation-page">
                        </div>
                        <script>
                            $(function() {
                                $('#my-select-page').searchableOptionList({
                                    showSelectAll: true,
                                    maxHeight: '210px',
                                    tooltip:false,
                                });
                            });  
                        </script>
                        @endif
                        <div class="btn-add-menu"><button type="button" class="btn btn-sm btn-primary">Thêm vào menu</button></div>
                    </div>
                </div>
            </div> -->
            <div class="form-group" id="cat-articles">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Danh mục bài viết
                    <span class="caret"></span></button>
                    <div class="dropdown-menu" role="menu" data-table="article_categories" data-route="client.show-cat-article">
                        @if(!empty($list_article_cat))
                        <select id="my-select-cat-article-id" name="cat_article_id" multiple="multiple">
                            {!!  $list_article_cat !!}
                        </select>
                        <div id="simulation-cat-article">
                        </div>
                        <script>
                            $(function() {
                                $('#my-select-cat-article-id').searchableOptionList({
                                    showSelectAll: true,
                                    maxHeight: '210px',
                                    tooltip:false,
                                });
                            });  
                        </script>
                        @endif
                        <div class="btn-add-menu"><button type="button" class="btn btn-sm btn-primary">Thêm vào menu</button></div>
                    </div>
                </div>
            </div>
            <div class="form-group" id="articles">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Bài viết
                    <span class="caret"></span></button>
                    <div class="dropdown-menu" role="menu" data-table="articles" data-route="client.show-article">
                        @if(!empty($list_article))
                        <select id="my-select-article-id" name="article_id" multiple="multiple">
                            {!!  $list_article !!}
                        </select>
                        <div id="simulation-article">
                        </div>
                        <script>
                            $(function() {
                                $('#my-select-article-id').searchableOptionList({
                                    showSelectAll: true,
                                    maxHeight: '210px',
                                    tooltip:false,
                                });
                            });  
                        </script>
                        @endif
                        <div class="btn-add-menu"><button type="button" class="btn btn-sm btn-primary">Thêm vào menu</button></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Liên kết tùy chỉnh
                    <span class="caret"></span></button>
                    <div class="dropdown-menu" role="menu" data-table="" data-route="danh-muc-san-pham">
                        <div class="form-group">
                            <input type="text" id="url-link" value="" placeholder="URL..." class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" id="name-link" value="" placeholder="Tên danh mục..." class="form-control">
                        </div>
                        <div class="btn-add-menu special"><button type="button" class="btn btn-sm btn-primary">Thêm vào menu</button></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-8">
            <div id="menu">
                <ol class="root sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">

                </ol>
            </div>

            <div class="btn-save-menu text-center">
                <button type="button" class="btn btn-sm btn-primary">Lưu lại</button>
            </div>
        </div>
    </div>
</section>
<script>       
    $('.setup-menu .dropdown-menu').on({
        "click":function(e){
          e.stopPropagation();
        }
    })
    
    $(document).ready(function(){
        var ns = $('ol.sortable').nestedSortable({
            forcePlaceholderSize: true,
            handle: 'div',
            helper: 'clone',
            items: 'li',
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            maxLevels: 100,
            isTree: true,
            expandOnHover: 700,
            startCollapsed: false,
            update: function(){
                arr = $(this).nestedSortable('toArray', {startDepthCount: 0});
                // demo = $(this).nestedSortable('toHierarchy', {startDepthCount: 0});
                // console.log(arr);
                // console.log(demo);
            }
        });

        function checkLevelMenu() {
            var id_menu = parseInt($('select[name="id-menu"]').val());

            if (id_menu == 1) {
                ns = $('ol.sortable').nestedSortable({ maxLevels: 2, });
            } else if (id_menu == 2) {
                ns = $('ol.sortable').nestedSortable({ maxLevels: 2, });
            } else {
                ns = $('ol.sortable').nestedSortable({ maxLevels: 1, });
            }
        }
        checkLevelMenu();

        $(document).on('click', '.disclose', function(e) {
            $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
            $(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
        });
        
        $('.expandEditor, .itemTitle').click(function(){
            var id = $(this).attr('data-id');
            $('#menuEdit'+id).toggle();
            $(this).toggleClass('ui-icon-triangle-1-n').toggleClass('ui-icon-triangle-1-s');
        });

        $(document).on('click', '.deleteMenu', function(e) {
            var id = $(this).attr('data-id');
            $('#menuItem_'+id).remove();;
        });
        
        function dump(arr,level) {
            var dumped_text = "";
            if(!level) level = 0;
        
            //The padding given at the beginning of the line.
            var level_padding = "";
            for(var j=0;j<level+1;j++) level_padding += "  aaa  ";
        
            if(typeof(arr) == 'object') { //Array/Hashes/Objects
                for(var item in arr) {
                    var value = arr[item];
        
                    if(typeof(value) == 'object') { //If it is an array,
                        dumped_text += level_padding + "'" + item + "' ...\n";
                        dumped_text += dump(value,level+1);
                    } else {
                        dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                    }
                }
            } else { //Strings/Chars/Numbers etc.
                dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
            }
            return dumped_text;
        }


        $(".btn-add-menu").click(function(){
            var id = 0;
            $(".clear-element").map(function() {
                var item = ($(this).attr("id")).replace("menuItem_", "");
                item = parseInt(item);
                
                if (item > id) {
                    id = item;
                }

            }).get();

            if ($(this).hasClass('special')) {
                if ( $('#url-link').val() == ''  || $('#name-link').val() == ''  ) {
                    $().toastmessage('showErrorToast', "Xin vui lòng nhập đầy đủ thông tin !");
                } else {
                    id = id + 1;
                    html = '';
                    html += ('<li style="display: list-item;" id="menuItem_' + id +'" class="clear-element page-item1 left" data-route="" data-table="" data-id-root="0" data-slug="" data-link="'+ $('#url-link').val() +'" data-name-cat="'+ $('#name-link').val() +'">');
                        html += '<div class="menuDiv">';
                            html += '<span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick"></span>';
                            html += '<span data-id="'+ id +'" class="itemTitle">'+ $('#name-link').val() +'</span>';
                            html += '<title="Click to delete item." data-id="'+ id +'" class="deleteMenu ui-icon ui-icon-closethick">';
                        html += '</div>';
                    html += '</li>';
                    $('#menu ol.root').append(html);
                }
            } else {
                var typeCat = $(this).parent().attr('data-table');
                var route = $(this).parent().attr('data-route');
                // alert(id);
                $('div[data-table="'+ typeCat +'"] option:selected').map(function(){
                    var html = '';
                    id = id + 1;
                    html += ('<li style="display: list-item;" id="menuItem_' + id +'" class="clear-element page-item1 left" data-route="'+ route +'" data-table="'+ typeCat +'" data-id-root="'+ $(this).val() +'" data-slug="'+ $(this).attr('data-slug') +'" data-link="" data-name-cat="'+ $(this).text() +'">');
                        html += '<div class="menuDiv">';
                            html += '<span title="Click to show/hide children" class="disclose ui-icon ui-icon-minusthick"></span>';
                            html += '<span data-id="'+ id +'" class="itemTitle">'+ $(this).text().replace(/--/g,' ').trim() +'</span>';
                            html += '<title="Click to delete item." data-id="'+ id +'" class="deleteMenu ui-icon ui-icon-closethick">';
                        html += '</div>';
                    html += '</li>';
                    $('#menu ol.root').append(html);
                }).get(); 
            }

        });

        
        $(".btn-save-menu").click(function(){
            arr = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
            arr.shift();

            arr_toHierarchy = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});

            list = [];
            $.each(arr, function(key, val) {
                var children = 0;
                $.each(arr_toHierarchy, function(k, v) {

                    if (v.id == arr[key].item_id && v.children != undefined) {
                        children = (v.children).length ;
                    }

                });
                var parent_id =  (arr[key].parent_id != null) ? arr[key].parent_id : 0 ;

                list.push({
                    'language' : $('select[name=language_id]').val(),
                    'id_tmp': parseInt(arr[key].item_id),
                    'id_root': $("#menuItem_" + arr[key].item_id).attr('data-id-root'),
                    'parent_id': parseInt(parent_id),
                    'route': $("#menuItem_" + arr[key].item_id).attr('data-route'),
                    'slug': $("#menuItem_" + arr[key].item_id).attr('data-slug'),
                    'name_table': $("#menuItem_" + arr[key].item_id).attr('data-table'),
                    'name_cat': $("#menuItem_" + arr[key].item_id).attr('data-name-cat').replace(/--/g,' ').trim(),
                    'id_menu': $('select[name="id-menu"]').val(),
                    'link': $("#menuItem_" + arr[key].item_id).attr('data-link'),
                    'children':children,
                 }); 
                
            });
            // console.log(JSON.stringify(list));return;
            var data    = {
                list     : JSON.stringify(list),
                id_menu  : $('select[name="id-menu"]').val(),
                language_id : $('select[name=language_id]').val(),
                _method  : "POST"
            };
            $.ajax({
                url: '{{ route("menu.setup-menu-ajax") }}',
                data : data,
                method: "POST",
                dataType:'json',
                success: function(data) {
                    if(data.status == 200){
                        $().toastmessage('showSuccessToast', data.Message);
                    }              
                },
                error: function(data) {
                    console.log('Error:', data);
                },
            });

        });

        var url_show_menu_ajax = '{{ route("menu.show-menu-ajax") }}';

        function showMenuAjax() {
            $.ajax({      
                url: url_show_menu_ajax,
                data : {
                         id : parseInt($('select[name="id-menu"]').val()),
                         language_id : $('select[name=language_id]').val(),
                         _token : $('meta[name="csrf-token"]').attr('content'),
                       },
                method: "POST",
                dataType: "html",
                success: function(data) {
                    $('#menu ol.root').html(data);    
                },
                error: function(data) {
                    console.log('Error:', data);
                },
            });
        }
        
        showMenuAjax();
        
        $('select[name=id-menu]').on('change', function() {
            checkLevelMenu();
            showMenuAjax();
        });

        $(document).on("change","select[name=language_id]",function() {
            showMenuAjax();
            var language_id = $('select[name=language_id]').val();
            $('.active-language img').attr('src', baseURL + '/general/images/'  +language_id+ '.png');

            var request = $.ajax({
                url: "{{ route('info-cat-article-by-lang') }}" + "?language_id=" + language_id,
                method: "GET",
                dataType: "html"
            });
            
            request.done(function (msg) {
                $('#my-select-cat-article-id').remove();
                $('#cat-articles .sol-container').empty().remove();
                $('#simulation-cat-article').html('');
                $('#simulation-cat-article').html('<select id="simulation-cat-article" name="cat_article_id" multiple="multiple"></select>');
                $("select[name=cat_article_id]").html(msg);
                $('select[name=cat_article_id]').searchableOptionList({
                    showSelectAll: true,
                    maxHeight: '210px',
                    tooltip:false,
                });
        
            });

            // var request = $.ajax({
            //     url: 1111,
            //     method: "GET",
            //     dataType: "html"
            // });
            
            // request.done(function (msg) {
            //     $('#my-select-page').remove();
            //     $('#pages .sol-container').empty().remove();
            //     $('#simulation-page').html('');
            //     $('#simulation-page').html('<select id="simulation-page" name="page" multiple="multiple"></select>');
            //     $("select[name=page]").html(msg);
            //     $('select[name=page]').searchableOptionList({
            //         showSelectAll: true,
            //         maxHeight: '210px',
            //         tooltip:false,
            //     });
        
            // });
        });
    });

    
</script>
@endsection
