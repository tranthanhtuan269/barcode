$(document).ready(function(){
	var url = $('base').attr('href');
	var fullUrl = window.location.href;
  
	$('.nav-list').click(function(){
		if($(this).find('.menu-icon-right').hasClass('fa-angle-down')){
			$(this).find('.menu-icon-right').removeClass('fa-angle-down').addClass('fa-angle-right');
		}else{
			$(this).find('.menu-icon-right').addClass('fa-angle-down').removeClass('fa-angle-right');
		}
	});

});

function confimDelete(id) {
  $.ajsrConfirm({
      message: "Bạn có chắc chắn muốn xóa ?",
      okButton: "Đồng ý",
      onConfirm: function() {
          $('form#' + id).submit()
      },

  });
  return false;
}

function searchFormJs() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("search-form-js");
  filter = input.value.toUpperCase();
  table = document.getElementById("group-table");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function closePopup() {
  $("#btn-cancel").trigger("click");
}

$(document).keydown(function(e) {

  if (e.keyCode == 27) {
    $("#btn-cancel").trigger("click");
  }

});

function titleToSlug( title ){
    var slug;
    slug = title.toLowerCase();
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    slug = slug.replace(/ /gi, "-");
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    return slug;
}
function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        image_base_64 = e.target.result;
        $('#blah').attr('src', image_base_64);
      }
      var src = input.files[0];
      reader.readAsDataURL(src);

      $('#blah').show();
      $('#product-image').hide();
  }else{
    $('#blah').hide();
      $('#product-image').show();
  }
}

$("#file-image").change(function(){
    readURL(this);
});

// Jquery Dependency
$("input[data-type='currency']").on({
    keyup: function () {
        formatCurrency($(this));
    },
    blur: function () {
        formatCurrency($(this), "blur");
    }
});

function formatNumberCurrency(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

function formatCurrency(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.

    // get input value
    var input_val = input.val();

    // don't validate empty input
    if (input_val === "") {
        return;
    }

    // original length
    var original_len = input_val.length;

    // initial caret position 
    var caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumberCurrency(left_side);

        // validate right side
        right_side = formatNumberCurrency(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
            // right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = left_side + "." + right_side;
        // input_val = "$" + left_side + "." + right_side;

    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumberCurrency(input_val);
        // input_val = "$" + input_val;

        // final formatting
        if (blur === "blur") {
            // input_val += ".00";
        }
    }

    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}