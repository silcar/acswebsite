jQuery(document).ready(function($){

	/* Register onChange function for display fields */
	$('.review-criteria-value input').change( function(){
		finalScore = 0;
		scoreCount = 0;
		$('.review-criteria-value input').each( function( index ){
			currentValue = $(this).val();
			if ( '' != currentValue && ! isNaN( currentValue ) ) {
				finalScore = finalScore + Number( $(this).val() );
				scoreCount = scoreCount + 1;
			}
		});
		finalScore = Math.round( ( finalScore / scoreCount) * 10 ) / 10;
		
		$('#fearless_review_final_score').val( finalScore );
	});
	
	/* Show/hide review fields */
	$('#fearless_review_enabled').change(function(){
		if ( $(this).is( ':checked' ) ) {
			$('#review .rwmb-field').show();
		} else {
			$('#review .rwmb-field').not('.review-enabled').hide();
		}
	});
	$('#fearless_review_enabled').trigger('change');
	
});