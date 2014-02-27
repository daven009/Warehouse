function fixRow(clone,i){
	clone.find('[name^="data["]').each(function(){
		if($(this).attr('name')){
			$(this).attr('name',$(this).attr('name').replace(/^(\D+)(\d+)(\D+)/,function(str,m1,m2,m3){
				var newstr = i+1+"";
				return m1+newstr+m3;
			}));
			
		}
		
		if($(this).attr('id')){
			$(this).attr('id',$(this).attr('id').replace(/^(\D+)(\d+)(\D+)/,function(str,m1,m2,m3){
				var newstr = i+1+"";
				return m1+newstr+m3;
			}));
		}
		
	});
	
	clone.find('[data-input-name^="data["]').each(function(){
		
		if($(this).data('input-name')){
			$(this).data('input-name',$(this).data('input-name').replace(/^(\D+)(\d+)(\D+)/,function(str,m1,m2,m3){
				var newstr = i+1+"";
				return m1+newstr+m3;
			}));
		}
		
	});
	clone.find('[data-input-name^="data["]').each(function(){

		if($(this).attr('data-input-name')){
			$(this).attr('data-input-name',$(this).attr('data-input-name').replace(/^(\D+)(\d+)(\D+)/,function(str,m1,m2,m3){
				var newstr = i+1+"";
				return m1+newstr+m3;
			}));
		}
	});
	
	return clone;
}

$(document).ready(function(){
	$('body').on('keyup','.quantity',function(){
		var quantity = parseFloat($(this).val());
		if(typeof quantity!="NaN"){
			var price = $(this).parents('td').prev().find('.price').val();
			var total = quantity*price;
			$(this).parents('td').next().find('.totalprice').val(total);
		}
		
		var subtotal = 0;
		$('.totalprice').each(function(){
			if(typeof parseFloat($(this).val())!="NaN"){
				console.log(subtotal);
				subtotal += parseFloat($(this).val());
			}
		})
	})
})