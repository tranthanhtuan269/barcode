<section id="section-search">
	<div class="container">
		<div class="row h-100">
			<div class="col-sm-offset-3 col-sm-6 col-xs-12 d-flex col-search">
				<div class="item">
                    @if(Request::is('/'))
					<h1 class="text_search">
                        Barcode lookup for millions of products globally
					</h1>
                    @else
                    <p class="size-h1" class="text_search">
                        Information and images for millions of products globally
					</p>
                    @endif
					<div class="search">
						<input type="number" name="barcode" id="barcodetxt" class="form-control"  placeholder="Enter a barcode number" value="{{ isset($barcode) ? $barcode : '' }}" required>
						<button type="button" class="btn btn-primary searchbtn">Search</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
    $('.searchbtn').click(e => {
        var keywords = $('#barcodetxt').val();
        let a = validateKeywords(keywords);

        if(a === 0) {
            keywords = keywords.trim()
            $.ajaxSetup(
            {
                headers:
                {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
            var data    = {
                barcode : keywords,
            };
        
            $.ajax({
                type: "POST",
                url: "{{ route('get-slug-barcode') }}",
                data: data,
                dataType: 'json',
                beforeSend: function(r, a){
                    $(".ajax_waiting").addClass("loading");
                },
                complete: function() {
                    $(".ajax_waiting").removeClass("loading");
                },
                success: function(response) {
                    if(response.status == 200) {
                        window.location.replace("{{ route('index') }}" + "/barcode/" + response.slug + "-" + keywords);
                    } else {
                        window.location.replace("{{ route('index') }}" + "/barcode/s-" + keywords);
                    }
                },
                error: function (data) {
                    $(".ajax_waiting").removeClass("loading");
                    alert('Something wrong')
                }
            });
        }

        if(a === 1) {
            window.alert('The barcode must be a number')
        }

        if(a === 2) {
            window.alert('Please enter a barcode in the search box')
        }
    })

    $(document).keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
            $('.searchbtn').click();
            return false;  
        }
    });

	function validateKeywords(keywords) {
        let flag = 0;
        let check = /^\d+$/;
        if(keywords == '') {
            flag = 2;
        }else {
            if (!check.test(keywords)) {
                flag = 1;
            }
        }
        return flag;
	}
</script>