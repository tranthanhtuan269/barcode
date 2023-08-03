<div class="seo-box">
    <div class="seo-title" data-toggle="collapse" data-target="#toh_seo_metabox">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active font-weight-600" aria-current="page">TOH SEO Tool</li>
            </ol>
        </nav>
    </div>
    <div id="toh_seo_metabox" class="collapse in">
        <div class="toh-seo-navigation clearfix">
            <a data-toggle="tab" href="#setting_panel_general" class="active">
                <span><i class="fa fa-cog fa-fw" aria-hidden="true"></i></span>
                <span>General</span>
            </a>
<!--             @if ( isset($social) )
            <a data-toggle="tab" href="#setting_panel_social">
                <span><i class="fa fa-share-alt fa-fw" aria-hidden="true"></i></span>
                <span>Social</span>
            </a>
            @endif
            @if ( isset($schema) )
            <a data-toggle="tab" href="#setting_panel_schema">
                <span><i class="fa fa-archive" aria-hidden="true"></i></span>
                <span>Schema</span>
            </a>
            @endif -->
        </div>
        <div class="toh-seo-content tab-content">
            <div id="setting_panel_general" class="tab-pane fade active in">
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="font-weight-bold">Meta title</label>
                        <input type="text" class="form-control" name="seo_title" placeholder="Tối đa 70 ký tự" maxlength="70" value="{{ isset($data_seo->seo_title) ? $data_seo->seo_title : '' }}">
                        <p class="alert-seo_title alert-errors"></p>
                    </div>
                    <div class="col-lg-6">
                        <label class="font-weight-bold">Keywords</label>
                        <input type="text" class="form-control" name="keywords" value="{{ isset($data_seo->keywords) ? $data_seo->keywords : '' }}">
                        <p class="alert-keywords alert-errors"></p>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="font-weight-bold">Meta description</label>
                        <textarea class="form-control" placeholder="Tối đa 200 ký tự" maxlength="200" name="seo_description">{{ isset($data_seo->seo_description) ? $data_seo->seo_description : '' }}</textarea>
                        <p class="alert-seo_description alert-errors"></p>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <label class="font-weight-bold">Index</label>
                            <div class="material-switch">
                                <input id="switch_seo_index" name="seo_indexed" type="checkbox" {{ (isset($data_seo->seo_indexed) && $data_seo->seo_indexed == 0) ? 'data-index=0' : 'data-index=1 checked' }} >
                                <label for="switch_seo_index" class="label-primary" id="seo_indexed_label"></label>
                            </div>
                        </div>
                    </div>

                    @if(isset($data_seo->show_status))
                    <div class="col-lg-3">
                        <div class="form-group clearfix">
                            <label class="font-weight-bold">Show</label>
                            <div class="material-switch">
                                <input id="switch_seo_show--barcode" name="seo_show--barcode" type="checkbox" {{ (isset($data_seo->show_status) && $data_seo->show_status == 0) ? 'data-show=0' : 'data-show=1 checked' }} >
                                <label for="switch_seo_show--barcode" class="label-primary" id="switch_seo_show--barcode-label"></label>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @if ( isset($social) )
            @include('backend.seo.social')
            @endif
            @if ( isset($schema) )
            @include('backend.seo.schema')
            @endif
        </div>
        <input type="hidden" name="submit_data_seo">
    </div>
</div>
<script>
    $('.toh-seo-navigation a').on('click', function(e){
        $('.toh-seo-navigation a').removeClass('active');
        $(this).addClass('active');
    });
    $('#seo_indexed_label').click(function(){
        if($('input[type=checkbox]').attr('data-index') == '1'){
            $('input[type=checkbox]').attr('data-index', '0');
        }else{
            $('input[type=checkbox]').attr('data-index', '1');
        }
    });

    $('#switch_seo_show--barcode-label').click(function(){
        if($('#switch_seo_show--barcode').attr('data-show') == '1'){
            $('#switch_seo_show--barcode').attr('data-show', '0');
        }else{
            $('#switch_seo_show--barcode').attr('data-show', '1');
        }
    });

    $('input[name=submit_data_seo]').click(function(){
        let schema_type;
        let check_schema = $('select[name=schema_select]').val();
        if (check_schema){
            schema_type = check_schema;
            $('#test_'+schema_type+'_schema').click();
        };
        let schema_code = $('textarea[name=test_schema_json]').val();
        let get_data_seo = {
            seo_title       : $('input[name=seo_title]').val().trim(),
            seo_description : $('textarea[name=seo_description]').val().trim(),
            keywords   : $('input[name=keywords]').val().trim(),
            seo_indexed     : $('input[name=seo_indexed]').attr('data-index'),
            seo_show_barcode     : $('#switch_seo_show--barcode').attr('data-show'),
            @if ( isset($social) )
            og_type         : $('input[name=og_type]').val().trim(),
            og_title        : $('input[name=og_title]').val().trim(),
            og_description  : $('textarea[name=og_description]').val().trim(),
            og_image        : $('input[name=og_image]').val().trim(),
            og_image_alt    : $('input[name=og_image_alt]').val().trim(),
            twitter_title   : $('input[name=twitter_title]').val().trim(),
            twitter_description   : $('textarea[name=twitter_description]').val().trim(),
            twitter_image   : $('input[name=twitter_image]').val().trim(),
            @endif
            @if ( isset($schema) )
            schema_type     : schema_type,
            schema_code     : schema_code,
            @endif
        }
        data_seo = get_data_seo;
    });
</script>