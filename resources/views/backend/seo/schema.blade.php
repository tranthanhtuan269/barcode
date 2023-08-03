<div id="setting_panel_schema" class="tab-pane fade">
    <div class="toh-seo-rick-snippet clearfix">
        <div class="row">
            <div class="col-md-6">
                <label>Schema Type</label>
                <div class="form-group">
                    <select class="form-control custom-select custom-select-sm wrap" name="schema_select">
                        <option value="">None</option>
                        <option value="job_posting">Job Posting</span></option>
                        <option value="software_application">Software Application</span></option>
                        <option value="product">Product</span></option>
                        <option value="faq">FAQ</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="schema-content tab-content">
            <div class="headline-description">
                <hr>
                <div class="form-group row">
                    <div class="col-md-2">
                        <label>Headline</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="schema_title" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-2">
                        <label>Description</label>
                    </div>
                    <div class="col-md-8">
                        <textarea class="form-control"  name="schema_description"></textarea>
                    </div>
                </div>
                <hr>
            </div>
            <div id="schema_job_posting" class="tab-pane fade">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Salary (Recommended)</label>
                        <input type="number" class="form-control" name="job_posting_salary" placeholder="Lương" value="">
                    </div>
                    <div class="col-lg-4">
                        <label>Salary Currency</label>
                        <select name="job_posting_salary_currency" class="form-control wrap">
                            <option value="VND">VND</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Payroll (Recommended)</label>
                        <select name="job_posting_payroll" class="form-control wrap">
                            <option value="MONTH" selected>Monthly</option>
                            <option value="WEEK">Weekly</option>
                            <option value="YEAR">Yearly</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Date Posted</label>
                        <div class='input-group date' id='schema_jobposting_date_posted'>
                            <input type='text' class="form-control" placeholder="Ngày đăng" name="job_poting_date_posted">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label>Expiry Posted</label>
                        <div class='input-group date' id='schema_jobposting_expiry_posted'>
                            <input type='text' class="form-control" placeholder="Ngày hết hạn" name="job_poting_expiry_posted">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <script>
                            $(function () {
                                let timezone_offset = (new Date()).getTimezoneOffset();
                                let hour = -timezone_offset/60<10?'0'+-timezone_offset/60:-timezone_offset/60;
                                let minute = -timezone_offset%60<10?'0'+-timezone_offset%60:-timezone_offset%60;
                                let timezone = hour+':'+minute;
                                $('#schema_jobposting_date_posted').datetimepicker({
                                    format:'YYYY-MM-DDTHH:mm:ss+'+timezone
                                });
                                $('#schema_jobposting_expiry_posted').datetimepicker({
                                    format:'YYYY-MM-DDTHH:mm:ss+'+timezone
                                });
                            });
                        </script>
                    </div>
                    <div class="col-lg-4">
                        <label>Employment Type (Recommended)</label>
                        <br>
                        <select name="job_posting_employment_type" class="form-control wrap">
                            <option value="FULL_TIME" selected>Full Time</option>
                            <option value="PART_TIME">Part Time</option>
                            <option value="CONTRACTOR">Contractor</option>
                            <option value="TEMPORARY">Temporary</option>
                            <option value="INTERN">Intern</option>
                            <option value="VOLUNTEER">Volunteer</option>
                            <option value="PER_DIEM">Per Diem</option>
                            <option value="OTHER">Other</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Hiring Organization</label>
                        <input type="text" class="form-control" name="job_posting_organization" placeholder="Đơn vị tuyển dụng" value="Công ty TNHH phần mềm Tower Hà Nội">
                    </div>
                    <div class="col-lg-4">
                        <label>Organization URL (Recommended)</label>
                        <input type="text" class="form-control" name="job_posting_organization_url" placeholder="URL công ty" value="http://tohsoft.com/">
                    </div>
                    <div class="col-lg-4">
                        <label>Organization Logo (Recommended)</label>
                        <input type="text" class="form-control" placeholder="Logo công ty" name="job_posting_organization_logo" value="http://tohsoft.com/wp-content/uploads/2015/12/logo_website.png">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-3 col-sm-6">
                        <label>Street Address</label>
                        <input type="text" class="form-control" name="job_posting_street_address" value="48 Tố Hữu">
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label>Address Locality</label>
                        <input type="text" class="form-control" name="job_posting_address_locality" value="Nam Từ Liêm">
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label>Address Region</label>
                        <input type="text" class="form-control" name="job_posting_address_region" value="Hà Nội">
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label>Postal Code</label>
                        <input type="text" class="form-control" placeholder="Mã bưu điện" name="job_posting_postal_code" value="100000">
                    </div>
                </div>
                <div class="text-center">
                    <hr>
                    <div id="test_job_posting_schema" class="btn btn-primary">Get Schema</div>
                </div>
            </div>
            <div id="schema_software_application" class="tab-pane fade">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Operating System</label>
                        <input type="text" class="form-control" placeholder="Hệ điều hành" name="software_app_operating_system" value="">
                    </div>
                    <div class="col-md-6">
                        <label>Application Category</label>
                        <input type="text" class="form-control" placeholder="Danh mục ứng dụng" name="software_app_application_category" value="">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Price</label>
                        <input type="number" class="form-control" placeholder="Giá tiền" name="software_app_price" value="">
                    </div>
                    <div class="col-md-6">
                        <label>Price Currency</label>
                        <select name="software_app_price_currency" class="form-control wrap">
                            <option value="VND">VND</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Rating Value</label>
                        <input type="number" max="5" min="0" class="form-control" placeholder="Đánh giá trung bình" name="software_app_rating_value" value="">
                    </div>
                    <div class="col-md-6">
                        <label>Rating Count</label>
                        <input type="number" min="0" class="form-control" placeholder="Tổng số đánh giá" name="software_app_rating_count" value="">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Author Name</label>
                        <input type="text" class="form-control" placeholder="Tên tác giả ứng dụng" name="software_app_author_name" value="">
                    </div>
                    <div class="col-md-6">
                        <label>Image URL</label>
                        <input type="text" class="form-control" placeholder="URL ảnh" name="software_app_image_url" value="">
                    </div>
                </div>
                <div class="text-center">
                    <hr>
                    <div id="test_software_application_schema" class="btn btn-primary">Get Schema</div>
                </div>
            </div>
            <div id="schema_product" class="tab-pane fade">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Product SKU</label>
                        <input type="text" class="form-control" placeholder="Mã SKU" name="product_sku" value="">
                    </div>
                    <div class="col-md-6">
                        <label>Product Brand</label>
                        <input type="text" class="form-control" placeholder="Thương hiệu sản phẩm" name="product_brand" value="">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-3 col-sm-6">
                        <label>Low Price</label>
                        <input type="number" class="form-control" placeholder="Giá thấp nhất" name="product_low_price" value="">
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label>High Price</label>
                        <input type="number" class="form-control" placeholder="Giá cao nhất" name="product_high_price" value="">
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label>Product Currency</label>
                        <select class="form-control wrap" name="product_currency">
                            <option value="VND">VND</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <label>Offer Count</label>
                        <input type="number" min="1" class="form-control" placeholder="Số lượng cung cấp" name="product_offer_count" value="">
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Rating Value</label>
                        <input type="number" min='1' max='5' class="form-control" placeholder="Đánh giá trung bình" name="product_rating_value" value="">
                    </div>
                    <div class="col-md-6">
                        <label>Rating Count</label>
                        <input type="number" min=0 class="form-control" placeholder="Số lượt đánh giá" name="product_rating_count" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Product Image URL</label>
                        <input type="text" class="form-control" placeholder="URL ảnh sản phẩm" name="product_image_url" value="">
                    </div>
                </div>
                <div class="text-center">
                    <hr>
                    <div id="test_product_schema" class="btn btn-primary">Get Schema</div>
                </div>
            </div>
            <div id="schema_faq" class="tab-pane fade">
                <div id="frequently_asked_questions_box" data-count='1'>
                    <div id="question_anwser_1">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label>Question 1</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="schema_faq_question_1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label>Anwser</label>
                            </div>
                            <div class="col-md-8">
                                <textarea class="form-control"  name="schema_faq_anwser_1"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="btn btn-success add-schema-faq"><i class="fa fa-plus fa-fw" aria-hidden="true"></i><strong>ADD</strong></div>
                    <hr>
                    <div id="test_faq_schema" class="btn btn-primary">Get Schema</div>
                </div>
            </div>
            <br>
            <div class="text-center test-schema-on-google">
                <textarea class="form-control" name="test_schema_json" id="" rows="3"></textarea>
                <br>
                <a href="https://search.google.com/structured-data/testing-tool/u/0/" target="_blank" rel="noopener" class="btn btn-info" id="copy_test_schema_json">Copy & Test</a>
            </div>
        </div>
    </div>
</div>
<script>
    function getJobPostingSchema(){
        let item = {};
        item['@context']        = 'https://schema.org';
        item['@type']           = 'JobPosting';
        item['title']           = $('input[name=schema_title]').val().trim();
        item['description']     = $('textarea[name=schema_description]').val().trim();
        item['identifier']          = {};
        item['identifier']['@type'] = 'PropertyValue';
        item['identifier']['name']  = $('input[name=job_posting_organization]').val().trim();
        // item['identifier']['value'] = '';
        item['datePosted']      = $('input[name=job_poting_date_posted]').val().trim();
        item['validThrough']    = $('input[name=job_poting_expiry_posted]').val().trim();
        item['employmentType']  = $('select[name=job_posting_employment_type]').val().trim();
        item['hiringOrganization']              = {};
        item['hiringOrganization']['@type']     = 'Organization';
        item['hiringOrganization']['name']      = $('input[name=job_posting_organization]').val().trim();
        item['hiringOrganization']['sameAs']    = $('input[name=job_posting_organization_url]').val().trim();
        item['hiringOrganization']['logo']      = $('input[name=job_posting_organization_logo]').val().trim();
        item['jobLocation']             = {};
        item['jobLocation']['@type']    = 'Place';
        item['jobLocation']['address']                      = {};
        item['jobLocation']['address']['@type']             = 'PostalAddress';
        item['jobLocation']['address']['streetAddress']     = $('input[name=job_posting_street_address]').val().trim();
        item['jobLocation']['address']['addressLocality']   = $('input[name=job_posting_address_locality]').val().trim();
        item['jobLocation']['address']['addressRegion']     = $('input[name=job_posting_address_region]').val().trim();
        item['jobLocation']['address']['postalCode']        = $('input[name=job_posting_postal_code]').val().trim();
        item['jobLocation']['address']['addressCountry']    = 'Việt Nam';
        item['baseSalary']              = {};
        item['baseSalary']['@type']     = 'MonetaryAmount';
        item['baseSalary']['currency']  = $('select[name=job_posting_salary_currency]').val().trim();
        item['baseSalary']['value']             = {};
        item['baseSalary']['value']['@type']    = 'QuantitativeValue';
        item['baseSalary']['value']['value']    = $('input[name=job_posting_salary]').val().trim();
        item['baseSalary']['value']['unitText'] = $('select[name=job_posting_payroll]').val().trim();

        let jsonObj = [];
        jsonObj.push(item);
        let schemaJson = JSON.stringify(jsonObj);

        return schemaJson;
    }
    function getSoftwareApplicationSchema(){
        let item = {};
        item['@context']            = 'https://schema.org';
        item['@type']               = 'SoftwareApplication';
        item['name']                = $('input[name=schema_title]').val().trim();
        item['url']                 = 'http://tohsoft.com/san-pham-dich-vu/ung-dung-di-dong-3';
        item['description']         = $('textarea[name=schema_description]').val().trim();
        item['operatingSystem']     = $('input[name=software_app_operating_system]').val().trim();
        item['applicationCategory'] = $('input[name=software_app_application_category]').val().trim();
        item['image']               = $('input[name=software_app_image_url]').val().trim();
        item['author']          = {};
        item['author']['@type'] = 'Person';
        item['author']['name']  = $('input[name=software_app_author_name]').val().trim();
        item['aggregateRating'] = {};
        item['aggregateRating']['@type']        = 'AggregateRating';
        item['aggregateRating']['ratingValue']  = $('input[name=software_app_rating_value]').val().trim();
        item['aggregateRating']['ratingCount']  = $('input[name=software_app_rating_count]').val().trim();
        item['offers']                  = {};
        item['offers']['@type']         = 'Offer';
        item['offers']['price']         = $('input[name=software_app_price]').val().trim();
        item['offers']['priceCurrency'] = $('select[name=software_app_price_currency]').val().trim();
        item['offers']['availability']  = 'https://schema.org/InStock';

        let jsonObj = [];
        jsonObj.push(item);
        let schemaJson = JSON.stringify(jsonObj);

        return schemaJson;
    }
    function getProductSchema(){
        let item = {};
        item['@context']            = 'https://schema.org';
        item['@type']               = 'product';
        item['sku']                 = $('input[name=product_sku]').val().trim();
        item['name']                = $('input[name=schema_title]').val().trim();
        item['image']               = $('input[name=product_image_url]').val().trim();
        item['description']         = $('textarea[name=schema_description]').val().trim();

        item['offers']                  = {};
        item['offers']['@type']         = 'AggregateOffer';
        item['offers']['lowPrice']      = $('input[name=product_low_price]').val().trim();
        item['offers']['highPrice']     = $('input[name=product_high_price]').val().trim();
        item['offers']['priceCurrency'] = $('select[name=product_currency]').val().trim();
        item['offers']['offerCount']    = $('input[name=product_offer_count]').val().trim();

        item['aggregateRating']                 = {};
        item['aggregateRating']['@type']        = 'AggregateRating';
        item['aggregateRating']['ratingValue']  = $('input[name=product_rating_value]').val().trim();
        item['aggregateRating']['reviewCount']  = $('input[name=product_rating_count]').val().trim();

        item['review']                          = {};
        item['review']['@type']                 = 'Review';
        item['review']['itemReviewed']          = {};
        item['review']['itemReviewed']['@type'] = 'CreativeWork';
        item['review']['author']            = {};
        item['review']['author']['@type']   = 'Thing';
        item['review']['author']['name']    = 'Customer';

        item['brand']           = {};
        item['brand']['@type']  = 'Thing';
        item['brand']['name']   = $('input[name=product_brand]').val().trim();

        let jsonObj = [];
        jsonObj.push(item);
        let schemaJson = JSON.stringify(jsonObj);

        return schemaJson;
    }
    function getFAQSchema(){
        let question_count = $('#frequently_asked_questions_box').attr('data-count');

        let item = {};
        item['@context']        = 'https://schema.org';
        item['@type']           = 'FAQPage';
        item['mainEntity']      = [];
        
        for (let index = 1; index <= question_count; index++) {
            let subItem = {};
            subItem['@type'] = 'Question';
            subItem['name'] = $('input[name=schema_faq_question_'+index+']').val().trim();
            subItem['acceptedAnswer'] = {};
            subItem['acceptedAnswer']['@type'] = 'Answer';
            subItem['acceptedAnswer']['text'] = $('textarea[name=schema_faq_anwser_'+index+']').val().trim();
            item['mainEntity'].push(subItem);
        }

        let jsonObj = [];
        jsonObj.push(item);
        let schemaJson = JSON.stringify(jsonObj);

        return schemaJson;
    }
    $('select[name=schema_select]').on('change', function (e) {
        var value_selected = $(this).val();
        $('.schema-content div').removeClass('active in');
        $('.schema-content #schema_'+value_selected).addClass('active in');
        $('textarea[name=test_schema_json]').val('');

        if( $('select[name=schema_select]').val() == '' ){
            $('.headline-description').hide();
            $('.test-schema-on-google').hide();
        }else{
            $('.headline-description').show();
            $('.test-schema-on-google').show();
        }
    });
    if( $('select[name=schema_select]').val() == '' ){
        $('.headline-description').hide();
        $('.test-schema-on-google').hide();
    }else{
        $('.headline-description').show();
        $('.test-schema-on-google').show();
    }
    $('.add-schema-faq').click(function(){
        let question_count = $('#frequently_asked_questions_box').attr('data-count');
        $('#frequently_asked_questions_box').attr('data-count', ++question_count)
        let html = '<hr>';
        html += '<div id="question_anwser_'+question_count+'">';
            html +='<div class="form-group row">';
                html +='<div class="col-md-2">';
                    html +='<label>Question '+question_count+'</label>';
                html +='</div>';
                html +='<div class="col-md-8">';
                    html +='<input type="text" class="form-control" name="schema_faq_question_'+question_count+'">';
                html +='</div>';
            html +='</div>';
            html += '<div class="form-group row">';
                html += '<div class="col-md-2">';
                    html += '<label>Anwser</label>';
                html += '</div>';
                html += '<div class="col-md-8">';
                    html += '<textarea class="form-control"  name="schema_faq_anwser_'+question_count+'"></textarea>';
                html += '</div>';
            html += '</div>';
        html += '</div>';

        $('#frequently_asked_questions_box').append(html);
    });

    $('#test_job_posting_schema').click(function(){
        $('textarea[name=test_schema_json]').val(getJobPostingSchema());
    });
    $('#test_software_application_schema').click(function(){
        $('textarea[name=test_schema_json]').val(getSoftwareApplicationSchema());
    });
    $('#test_product_schema').click(function(){
        $('textarea[name=test_schema_json]').val(getProductSchema());
    });
    $('#test_faq_schema').click(function(){
        $('textarea[name=test_schema_json]').val(getFAQSchema());
    });

    $('#copy_test_schema_json').click(function(){
        let copy_text = $('textarea[name=test_schema_json]').val().trim();
        let temp = $("<input>");
        $("body").append(temp);
        temp.val(copy_text).select();
        document.execCommand("copy");
        temp.remove();
    });
</script>