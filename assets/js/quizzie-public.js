(function($) {
	'use strict';

	let answeredQuestions = 0;
	// let quizDone = false;

	$(document).ready(function($) {
		$('.answers label').click(function() {
			const clickedElementId = $(this).children('input').attr('id');
			let answerText = $(this).text().trim();
			let quizId = $(this).parents('.quiz-wrapper').data('quizid');
			let questionText = $(this).parent().siblings('.question').text();
			let questionId = $(this).parents('.box').data('questionid');
			

			$.ajax({
				type: 'POST',
				url: my_ajax_object.ajax_url,
				data: {
					action: 'my_ajax_action',
					clickedElementId: clickedElementId,
					answerText: answerText,
					quizId: quizId,
					questionText: questionText,
					questionId: questionId,
					//håller koll på hur många frågor användaren svarat på.
					answeredQuestions: answeredQuestions,
					// quizDone: quizDone,
				},
				success: function(response) {
					console.log(response.data.quizDone);
					answeredQuestions = response.data.answeredQuestions;
					if(response.data.quizDone == true) {
						window.location.href = '../result-page';
					}

					const box = $('.box').filter(function() {
						return $(this).data('questionid') == questionId
					});
					box.find('.question').after('<div class="message ' + response.data.class + '">' + response.data.message + '</div>');
					box.find('.question').hide();
					box.find('.answers').hide();
					box.find('.answers label').off('click');

				  },
				error: function(response) {
					console.log(response)
				}
			});
		});
	});

  
  })(jQuery);