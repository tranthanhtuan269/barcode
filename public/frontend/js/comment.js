var totalComments = parseInt($('#total-comment').text())
var keyword = $('#keywords_not_good').val().replace(/\s/g, '').split(',');
let article_id = $('.detail-article').data("article-id");
let barcode_id = $('#barcode-id').val();
var typeComment = $('#type-comment').val();
var kyTu = ['Ă¡', 'Ă ', 'áº£', 'áº¡', 'Ă£', 'Äƒ', 'áº¯', 'áº±', 'áº³', 'áºµ', 'áº·', 'Ă¢', 'áº¥', 'áº§', 'áº©', 'áº«', 'áº­', 'a', 'b', 'c', 'd', 'Ä‘', 'Ă©', 'Ă¨', 'áº»', 'áº½', 'áº¹', 'Ăª', 'áº¿', 'á»', 'á»ƒ', 'á»…', 'á»‡', 'e', 'f', 'g', 'h', 'Ă­', 'Ă¬', 'á»‰', 'Ä©', 'á»‹', 'i', 'j', 'k', 'l', 'm', 'n', 'Ă³', 'Ă²', 'á»', 'Ăµ', 'á»', 'Ă´', 'á»‘', 'á»“', 'á»•', 'á»—', 'á»™', 'Æ¡', 'á»›', 'á»', 'á»Ÿ', 'á»¡', 'á»£', 'o', 'p', 'q', 'r', 's', 't', 'Ăº', 'Ă¹', 'á»§', 'Å©', 'á»¥', 'Æ°', 'á»©', 'á»«', 'á»­', 'á»¯', 'á»±', 'u', 'v', 'w', 'x', 'y','Ă½', 'á»³', 'á»·', 'á»¹', 'z', 'Ă', 'Ă€', 'áº¢', 'áº ', 'Ăƒ', 'Ä‚', 'áº®', 'áº°', 'áº²', 'áº´', 'áº¶', 'Ă‚', 'áº¤', 'áº¦', 'áº¨', 'áºª', 'áº¬', 'A', 'B', 'C', 'D', 'Ä', 'Ă‰', 'Ăˆ', 'áºº', 'áº¼', 'áº¸', 'Ă', 'áº¾', 'á»€', 'á»‚', 'á»„', 'á»†', 'E', 'F', 'G', 'H', 'Ă', 'ĂŒ', 'á»ˆ', 'Ä¨', 'á»', 'I', 'J', 'K', 'L', 'M', 'N', 'Ă“', 'Ă’', 'á»', 'Ă•', 'á»Œ', 'Ă”', 'á»', 'á»’', 'á»”', 'á»–', 'á»˜', 'Æ ', 'á»', 'á»œ', 'á»', 'á» ', 'á»¢', 'O', 'P', 'Q', 'R', 'S', 'T', 'Ă', 'Ă™', 'á»¦', 'Å¨', 'á»¤', 'Æ¯', 'á»¨', 'á»ª', 'á»¬', 'á»®', 'á»°', 'U', 'V', 'W', 'X','Y','Ă', 'á»²', 'á»¶', 'á»¸', 'Z','-','Đ'];
function dequy(){
	var parent_id = 0;
	$('.btn-reply').off('click')
	$('.btn-reply').on('click',function(){
		const data_id = $(this).attr('data-id');
		$('.repond-'+data_id).toggleClass('d-none');
		parent_id = $(this).attr("data-parent-id");
	})

	$('.btn-submit-comment').off('click')
	$('.btn-submit-comment').on('click',function(){
		var data_id = $(this).attr("data-id");
        let comment = $('.comment-'+data_id).val();
		comment = comment.trim();
        let author = $('.author-'+data_id).val();
        let email = $('.email-'+data_id).val();
        if(validateComment(comment,author,email,data_id)) {
			$('.btn-submit-comment').off('click')
            $.ajaxSetup({
            	headers:
	                {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            })

            $.ajax({
                method:"POST",
                data: {
                    "comment": comment,
                    "email" : email,
                    "author": author,
                    "article_id": article_id,
                    "barcode_id": barcode_id,
                    "type": typeComment,
                    "article_link": window.location.href,
                    "parent_id": parent_id
                },
                type:'POST',
                url:'/ajax/comment',
                beforeSend: function() {
	                    $(".ajax_waiting").addClass("loading");
	              },
	              complete: function() {
	                    $(".ajax_waiting").removeClass("loading");
	              },
                success:function(res) {
                	Swal.fire({
	                    title: 'success',
	                    text: "Thank you!",
                		type: 'success',
	                })
	                totalComments++
	                $('#total-comment').html(totalComments)
                    if(data_id !=0 ) {
                    $('.repond-'+data_id).addClass('d-none');
                    }
                    $('.list-comment-'+data_id).append(res);
                    $('.comment-'+data_id).val('');
	                $('.author-'+data_id).val('');
	                $('.email-'+data_id).val('');
                    dequy();
                }

            })
        }
    })

	$('.btn-delete-comment').click(function () {
		Swal.fire({
			title: 'Are you sure?',
			text: 'Do you want to delete?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes',
			cancelButtonText: 'No'
		}).then((result) => {
			if (result.isConfirmed) {
				let comment_id = $(this).data("id")
				$('.li-comment-' + comment_id).remove()
				$.ajaxSetup({
					headers:
					{
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				})
	
				$.ajax({
					method: "POST",
					data: {
						"barcode_id": barcode_id,
						"article_id": article_id,
						"comment_id": comment_id,
					},
					type: 'POST',
					url: '/ajax/delete_comment',
					beforeSend: function () {
						$(".ajax_waiting").addClass("loading");
					},
					complete: function () {
						$(".ajax_waiting").removeClass("loading");
					},
					success: function (res) {
						$('#total-comment').html(res.totalComments)
						totalComments = res.totalComments
						dequy();
					}
	
				})
			} else if (result.isDenied) {
				console.log('User canceled!');
			}
		});
		
	})
}

function validateComment(comment,author,email,data_id){
	if(check(keyword, comment, author, email)) {
		if(author == '') {
			Swal.fire({
                title: 'Error',
                text: "The name cannot be empty!",
        		type: 'error',
			})
			$('.author-'+data_id).focus()
			return false
		}else  {
			if(email=='') {
				Swal.fire({
	                    title: 'Error',
	                    text: "The email cannot be empty!",
	            		type: 'error',
					})
				$('.email-'+data_id).focus()
				return false
			}else {
		        atpos = email.indexOf("@")
				dotpos = email.lastIndexOf(".")
				if (atpos < 1 || ( dotpos - atpos < 2 )) {
		            Swal.fire({
	                    title: 'Error',
	                    text: "Please enter a valid email address!",
	            		type: 'error',
					})
		            $('.email-'+data_id).focus()
		            return false
		        }
	        	return true
			}
		}
	}
}	

function check(keyword, comment, author, email) {
	if(author == "Barcodelive" && email == "barcodelive@gmail.com") {
		return true
	}else {
		if(comment.length == 0) {
			Swal.fire({
	            title: 'Error',
	            text: "You have not entered content!",
	    		type: 'error',
			})
			$('.comment-'+data_id).focus()
			return false
		}else {
			comment = comment.toLowerCase()

		   	for (var i = 0; i < keyword.length; i++) {
		   		if(!checkComment(keyword[i], comment)){
		   			$(".ajax_waiting").removeClass("loading");
		   			Swal.fire({
	                    title: 'Error',
	                    text: "Your comment contains banned words or links!",
	            		type: 'error',
					})
					return false;
		   		}
		    }

		    if(detectURLs(comment)){
		    	$(".ajax_waiting").removeClass("loading");
	   			Swal.fire({
	                title: 'Error',
	                text: "Validate comment!",
	        		type: 'error',
				})
				return false;
		    }
		   	return true
		}
	}
}

function detectURLs(message) {
  var urlRegex = /(((https?:\/\/)|(www\.))[^\s]+)/g;
  return message.match(urlRegex)
}

function checkComment(keyword, allText) {
    var key = keyword;
    var newText = '';
    for (var i = 0; i < allText.length; i++) {
       var mo = newText.split('<').length;
       var dong = newText.split('>').length;
       if (mo > dong) {
           newText += allText[i];
           continue;
       }
       var thisValue = allText.substr(i, key.length);
       if (thisValue.toLowerCase() == key.toLowerCase()) {
           var before = allText.substr(0, i);
           var after = allText.substr(i + key.length, allText.length - i + key.length);
           if (kyTu.indexOf(before.substr(before.length - 1, 1)) == -1 && kyTu.indexOf(after.substr(0, 1)) == -1) {
               i += key.length;
               return false;
           }
       }
    }
    return true;
}

$('.comment-select').on('change',function() {
	var filter_comment = $(this).val();
	var totalComments = parseInt($('#total-comment').text()); 
	if(totalComments > 0 ) {
		$.ajaxSetup({
        	headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

        $.ajax({
        	method:"POST",
            data: {
                "filter_comment": filter_comment,
                "article_id": article_id,
                "barcode_id": barcode_id,
            },
            type:'POST',
            url:'/ajax/filter_comment',
            beforeSend: function() {
	            $(".ajax_waiting").addClass("loading");
	        },
	         complete: function() {
	            $(".ajax_waiting").removeClass("loading");
	        },
            success:function(res) {
            	$('.list-comment-0').html(res);
                dequy();
            }
        })
	}
})
dequy();





