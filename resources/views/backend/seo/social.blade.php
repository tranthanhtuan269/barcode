<div id="setting_panel_social" class="tab-pane fade">
    <div class="social-tabs-navigation-wrapper">
        <div class="rank-math-tabs-navigation rank-math-custom social-tabs-navigation wp-clearfix" data-active-class="tab-active">
            <a href="#facebook_tab_content" data-toggle="tab" class="preview-network tab-facebook tab-active">
                <span><i class="fa fa-facebook fa-lg fa-fw" aria-hidden="true"></i>
                </span>Facebook
            </a>
            <a href="#twitter_tab_content" data-toggle="tab" class="preview-network tab-twitter">
                <span><i class="fa fa-twitter fa-lg fa-fw" aria-hidden="true"></i>
                </span>Twitter
            </a>
        </div>
    </div>
    <div class="social-tab-content tab-content">
        <div id="facebook_tab_content" class="tab-pane fade active in">
            <div class="form-group row">
                <div class="col-lg-8">
                    <label class="font-weight-bold">Type</label>
                    <input type="text" class="form-control" name="og_type" placeholder='Mặc định là "Website"' value="{{ isset($data_seo->og_type) ? $data_seo->og_type : '' }}">
                    <small>List Type: <a href="https://ogp.me/#types">https://ogp.me/</a></small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-8">
                    <label class="font-weight-bold">Title</label>
                    <input type="text" class="form-control" maxlength="80" placeholder="Tối đa 80 ký tự" name="og_title" value="{{ isset($data_seo->og_title) ? $data_seo->og_title : '' }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-8">
                    <label class="font-weight-bold">Description</label>
                    <textarea class="form-control" maxlength="200" placeholder="Tối đa 200 ký tự" name="og_description">{{ isset($data_seo->og_description) ? $data_seo->og_description : '' }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-8">
                    <label class="font-weight-bold">Image</label>
                    <input type="text" class="form-control" maxlength="200" name="og_image" value="{{ isset($data_seo->og_image) ? $data_seo->og_image : '' }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-8">
                    <label class="font-weight-bold">Alt Image</label>
                    <input type="text" class="form-control" maxlength="200" name="og_image_alt" value="{{ isset($data_seo->og_image_alt) ? $data_seo->og_image_alt : '' }}">
                </div>
            </div>
        </div>
        <div id="twitter_tab_content" class="tab-pane fade">
            <div class="form-group row">
                <div class="col-lg-8">
                    <div class="form-group clearfix">
                        <label class="font-weight-bold">Use Data from Facebook Tab</label>
                        <div class="material-switch">
                            <input id="switch_twitter_share" name="use_facebook_data" type="checkbox" data-facebook-og=0 >
                            <label for="switch_twitter_share" class="label-primary" id="use_facebook_og" ></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-8">
                    <label class="font-weight-bold">Title</label>
                    <input type="text" class="form-control" maxlength="80" placeholder="Tối đa 80 ký tự" name="twitter_title" value="{{ isset($data_seo->twitter_title) ? $data_seo->twitter_title : '' }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-8">
                    <label class="font-weight-bold">Description</label>
                    <textarea class="form-control" maxlength="200" placeholder="Tối đa 200 ký tự" name="twitter_description">{{ isset($data_seo->twitter_description) ? $data_seo->twitter_description : '' }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-8">
                    <label class="font-weight-bold">Image</label>
                    <input type="text" class="form-control" maxlength="200" name="twitter_image" value="{{ isset($data_seo->twitter_image) ? $data_seo->twitter_image : '' }}">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.social-tabs-navigation-wrapper .preview-network').on('click', function(e){
        $('.social-tabs-navigation-wrapper .preview-network').removeClass('tab-active');
        $(this).addClass('tab-active');
    });
    $('.social-tabs-navigation-wrapper .preview-network').on('click', function(e){
        $('.social-tabs-navigation-wrapper .preview-network').removeClass('tab-active');
        $(this).addClass('tab-active');
    });
    $('#use_facebook_og').click(function(){
        if($('input[name=use_facebook_data]').attr('data-facebook-og') == 0){
            $('input[name=use_facebook_data]').attr('data-facebook-og', 1);
            $('input[name=twitter_title]').val($('input[name=og_title]').val().trim());
            $('textarea[name=twitter_description]').html($('textarea[name=og_description]').val().trim());
            $('input[name=twitter_image]').val($('input[name=og_image]').val().trim());
        }else{
            $('input[name=use_facebook_data]').attr('data-facebook-og', 0);
            $('input[name=twitter_title]').val("{{ isset($data_seo->twitter_title) ? $data_seo->twitter_title : '' }}");
            $('textarea[name=twitter_description]').html("{{ isset($data_seo->twitter_description) ? $data_seo->twitter_description : '' }}");
            $('input[name=twitter_image]').val("{{ isset($data_seo->twitter_image) ? $data_seo->twitter_image : '' }}");
        }
    });
    $("input[name=og_image], input[name=twitter_image]").on({
        keydown: function(e) {
            if (e.which === 32)
            return false;
        },
        change: function() {
            this.value = this.value.replace(/\s/g, "");
        }
    });
</script>