@extends('layouts_frontend.master')

@section('title', 'Barcode Live')

@section('content')
<div id="special-field" class="special" data-barcode="10"></div>
<div class="list-barcode account">
	<div class="container">
		<div class="row">
			<h3>Product List</h3>
			@include('layouts_frontend.notification')
			<div class="item_search clearfix">
				<div class="pull-right">
					<div class="add_new_barcode">
						<a id="create-barcode-btn"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new product</a>
						<!-- <a id="create-barcode-btn">Add new barcode</a> -->
					</div>
				</div>
			</div>

			<div class="detail clearfix">
				<div class="col-sm-12">
					<div class="table-responsive">
						<table id="barcode-grid"  cellpadding="0" cellspacing="0" class="toggle-vis" border="0" class="display" width="100%">
					        <thead>
					            <tr>
									<th class="barcode-field">ID</th>
									<th class="barcode-field">Barcode</th>
					                <th class="name-field">Name</th>
					                <th class="model-field">Model</th>
					                <th class="manufacturer-field">Manufacturer</th>
					                <th class="avg_price-field">Average Price</th>
					                <th class="created_at-field">Created At</th>
					            </tr>
					        </thead>
					        <tbody id="barcode-list">
					        </tbody>
						</table>

						<script type="text/javascript">							
						    $(document).ready(function() {

								// add new barcode if added
								var list_new = <?php if(null !== session('list_barcode')){ echo json_encode(session('list_barcode')); } else { echo '[]'; } ?>;

						    	var barcodes = [];
						        if(localStorage.getItem("barcodes") != null){
						          barcodes = JSON.parse(localStorage.getItem("barcodes"));
						        }

								for(var i = 0; i < list_new.length; i++){
									// document.write(list_new[i]);
									console.log(list_new[i].barcode);

									var index = checkExist(list_new[i].barcode, barcodes);

									if(index != -1){
										barcodes.splice(index, 1)
									}
								}
								barcodes = barcodes.concat(list_new);
								console.log(barcodes);
								localStorage.setItem("barcodes", JSON.stringify(barcodes));
						        var html = '';

						        for(var i = 0; i < barcodes.length; i++){
						        	if(barcodes[i] == null) continue;
						        	html += '<tr>\
								        		<td class="id-field" width="2%">\
								                	'+(i+1)+'\
												</td>\
												<td class="barcode-field">'+barcodes[i].barcode+'</td>\
								                <td class="name-field">'+barcodes[i].name+'</td>\
								                <td class="model-field">'+barcodes[i].model+'</td>\
								                <td class="manufacturer-field">'+barcodes[i].manufacturer+'</td>\
								                <td class="avg_price-field">'+barcodes[i].avg_price+'</td>\
								                <td class="created_at-field">'+barcodes[i].created_at+'</td>\
								        	</tr>';
						        }


						        $('#barcode-list').html(html)

						        console.log(barcodes);

							    $('#create-barcode-btn').click(function(){
							      var numBarcode = $('#special-field').attr("data-barcode");

							      if(undefined == typeof(numBarcode) || 0 >= numBarcode){
							          swal(settingSweetalerForPayment("{!! $messages_check_buy_barcode !!}"))
							              .then((result) => {
							                  if (result.value) {
							                      window.location.href = baseURL + "/payment";
							                  }
							              });
							      }else{
							        window.location.href = baseURL + "/barcode/add";
							      }
							    });

						    	$('#select-column-display').click(function(){
						    		if($('.select-holder').hasClass("hide")){
						    			$('.select-holder').removeClass("hide");
						    		}else{
						    			$('.select-holder').addClass("hide");
						    		}
						    	});

						    	$('.select-holder').mouseleave(function() {
								    setTimeout(function() {
								        $('.select-holder').addClass("hide");
								    }, 100);
								});

								$('#barcode-grid').mouseleave(function() {
								    setTimeout(function() {
								        $('.select-holder').addClass("hide");
								    }, 100);
								});

						    	// sort
						    	// index
						    	// display

								//select all checkboxes
								$("#select-all-btn").change(function(){  
								    $('#barcode-grid tbody input[type="checkbox"]').prop('checked', $(this).prop("checked"));
								    // save localstore
								    setCheckboxChecked();
								});

								// function highlightCheckbox() {

								// }

						    	$('body').on('click', '#barcode-grid tbody input[type="checkbox"]', function() {
								    if(false == $(this).prop("checked")){
								        $("#select-all-btn").prop('checked', false); 
								    }
								    if ($('#barcode-grid tbody input[type="checkbox"]:checked').length == $('#barcode-grid tbody input[type="checkbox"]').length ){
								        $("#select-all-btn").prop('checked', true);
								    }

								    // save localstore
								    setCheckboxChecked();
						    	});

						    	$('input[name="disableCol"]').on( 'click', function () {
							        var column_selected_name = $(this).attr('data-column');
							        if($('th.' + column_selected_name).hasClass("hide")){
							        	$('.' + $(this).attr('data-column')).removeClass("hide");
							        }else{
							        	$('.' + $(this).attr('data-column')).addClass("hide");
							        }

							    } );

							    $('input[type="search"]').attr("placeholder", "Barcode...");
							    $('input[type="search"]').addClass('searchTxt');
							    $('input[type="search"]').keydown(function (e) {
							        // Allow: backspace, delete, tab, escape, enter and .
							        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
							             // Allow: Ctrl+A, Command+A
							            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
							             // Allow: home, end, left, right, down, up
							            (e.keyCode >= 35 && e.keyCode <= 40)) {
							                 // let it happen, don't do anything
							                 return;
							        }
							        // Ensure that it is a number and stop the keypress
							        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
							            e.preventDefault();
							        }
							    });
							    $('input[type="search"]').keyup(function (e) {
								    e.preventDefault();
									if(searchPrev == 0 && searchCurr == 0){
							        	searchPrev = searchCurr = $('.searchTxt').val().length;
							        }else{
							        	searchPrev = searchCurr;
							        	searchCurr = $('.searchTxt').val().length;
							        }

							        if(searchCurr == 0 && searchCurr < searchPrev){
							        	// alert(1);
							        	if(orderCurrent.length > 0){
							        		$('.' + orderCurrent + '-field').removeClass('sorting');
								        	$('.' + orderCurrent + '-field').addClass('sorting_' + orderCurrentType);

								        	var index_col = $('.' + orderCurrent + '-field').attr('data-column-index');
								        	
								        	changeSort(orderCurrent, orderCurrentType);
							        	}
							        }
								});			
						    });

							function changeSort( name, sort ) {
							   for (var i in dataJsonSetup) {
							     if (dataJsonSetup[i].name == name) {
							        dataJsonSetup[i].sort = sort;
							        break; //Stop this loop, we found it!
							     }
							   }
							}

							function getCurrentIndex(orderCurrentObj) {
								$.each($('th'), function(key, value){
						    		if($(this).hasClass(orderCurrentObj)){
						    			return key;
						    		}
						    	});
							}

							function array_move(arr, old_index, new_index) {
							    if (new_index >= arr.length) {
							        var k = new_index - arr.length + 1;
							        while (k--) {
							            arr.push(undefined);
							        }
							    }
							    arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
							    return arr; // for testing
							};

							function setCheckboxChecked(){
								barcodeCheckList = [];
								$.each($('.check-barcode'), function( index, value ) {
									if($(this).prop('checked')){
										barcodeCheckList.push($(this).attr("id"));
										$(this).closest("tr").addClass('highlight');
									} else {
										$(this).closest("tr").removeClass('highlight');
									}
								});
							}

							function checkCheckboxChecked(){
								var count_row = 0;
								var listBarcode = $('.check-barcode');
								if(listBarcode.length > 0){
									$.each(listBarcode, function( index, value ) {
										if(containsObject($(this).attr("id"), barcodeCheckList)){
											$(this).prop('checked', 'true');
											count_row++;
										}
									});

									if(count_row == listBarcode.length){
										$('#select-all-btn').prop('checked', true);
									}else{
										$('#select-all-btn').prop('checked', false);
									}
								}else{
									$('#select-all-btn').prop('checked', false);
								}
							}

							function containsObject(obj, list) {
							    var i;
							    for (i = 0; i < list.length; i++) {
							        if (list[i] === obj) {
							            return true;
							        }
							    }

							    return false;
							}
						    
						    function removeItem($id){
								swal(settingSweetaler("{!! $messages_delete_barcode !!}"))
							    .then((result) => {
							      if (result.value) {
							    	var data = {
									  	id:$id,
									  	_method:'delete'
									};
									$.ajaxSetup(
									{
									  	headers:
									  	{
									  		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
										}
									});
									$.ajax({
										type: "POST",
										url: "{{ url('/') }}/barcode/del",
										data: data,
										beforeSend: function() {
										    $("#pre_ajax_loading").show();
										},
										complete: function() {
										    $("#pre_ajax_loading").hide();
										},
										success: function (response) {
											var obj = $.parseJSON(response);

											var barcodes = [];
									        if(localStorage.getItem("barcodes") != null){
									          barcodes = JSON.parse(localStorage.getItem("barcodes"));
									        }
											if(obj.Response == "Success"){
												$('#remove-' + $id).parent().parent().hide("slow");

												var index = checkExist($id, barcodes);

										        if(index != -1){
										          barcodes.splice(index, 1)
										        }

									        	localStorage.setItem("barcodes", JSON.stringify(barcodes));
											}else{
												swal({
												    title: "A product does not exist.",
												});
											}
										},
										error: function (data) {
										 	swal({
										        html: '<div class="alert-danger">Please check your internet connection and try again.</div>',
										    });
										}
									});
							      }
							    });
						    }

						    function checkExist($id, $arr){
						    	for(var i=0; i< $arr.length; i++){
						    		if($arr[i].id == $id){
						    			return i;
						    		}
						    	}

						    	return -1;
						    }

						    function removeOrderClass(){
						    	$.each($('th'), function(key, value){
						    		if($(this).hasClass('sorting_asc') || $(this).hasClass('sorting_desc')){
								    	var classString = $(this).attr('class');
								    	var classList = classString.split(' ');
								    	orderCurrent = classList[0].substring(0, classList[0].length - 6);
								    	if($(this).hasClass('sorting_asc')){
								    		orderCurrentType = 'asc';
						    				$(this).removeClass('sorting_asc');
								    	}else{
								    		orderCurrentType = 'desc';
						    				$(this).removeClass('sorting_desc');
								    	}
						    			$(this).addClass('sorting');
						    		}
						    	});
						    }

						    $('#apply-all-btn').click(function (){
						      	var $id_list = '';
						    	$.each($('.check-barcode'), function (key, value){
					    			if($(this).prop('checked') == true) {
								    	$id_list += $(this).attr("data-column") + ',';
								    }
					    		});

					    		if ($id_list.length > 0) {
									swal(settingSweetaler("{{ $messages_delete_barcode }}"))
								    .then((result) => {
								      if (result.value) {
									      	var $id_list = '';
									    	$.each($('.check-barcode'), function (key, value){
								    			if($(this).prop('checked') == true) {
											    	$id_list += $(this).attr("data-column") + ',';
											    }
								    		});

								    		if($id_list.length > 0){
										    	var data = {
												  	id_list:$id_list,
												  	_method:'delete'
												};
												$.ajaxSetup(
												{
												  	headers:
												  	{
												  		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
													}
												});
												$.ajax({
													type: "POST",
													url: "{{ url('/') }}/barcode/delMulti",
													data: data,
													beforeSend: function() {
													    $("#pre_ajax_loading").show();
													},
													complete: function() {
													    $("#pre_ajax_loading").hide();
													},
													success: function (response) {
														var obj = $.parseJSON(response);
														if(obj.Response == "Success"){
															$.each($('.check-barcode'), function (key, value){
												    			if($(this).prop('checked') == true) {
															    	$(this).parent().parent().hide("slow");
															    }
												    		});
														}else{
															swal({
															    title: "A barcode does not exist.",
															});
														}
													},
													error: function (data) {
													 	swal({
													        html: '<div class="alert-danger">Please check your internet connection and try again.</div>',
													    });
													}
												});
											}
									    }
									});
					    		} else {
						            swal({
						              html: '<div class="alert-danger">{!! $messages_check_selected_delete !!}</div>',
						            })
					    		}
						    });
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection