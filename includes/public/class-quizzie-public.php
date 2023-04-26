<?php
/**
 * The public specific functionality of the plugin.
 *
 * @since 1.0
 */

class Quizzie_Public {

	protected $plugin_name;
	protected $plugin_version;
	protected $answered_questions;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0
	 */
	public function __construct( $plugin_name, $plugin_version ) {
		$this->plugin_name    = $plugin_name;
		$this->plugin_version = $plugin_version;

		// Example action hook usage. Uncomment or delete.
		add_shortcode( 'my_shortcode', array( $this, 'my_shortcode_function' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_my_ajax_action', array( $this, 'my_ajax_callback' ) );
		add_action( 'wp_ajax_nopriv_my_ajax_action', array( $this, 'my_ajax_callback' ) );
	}
	
	function my_ajax_callback() {
		$clickedElementId = isset($_POST['clickedElementId']) ? $_POST['clickedElementId'] : '';
		$quizId = isset($_POST['quizId']) ? $_POST['quizId'] : '';
		$questionText = isset($_POST['questionText']) ? $_POST['questionText'] : '';
		$answerText = isset($_POST['answerText']) ? $_POST['answerText'] : '';
		$questionId = isset($_POST['questionId']) ? $_POST['questionId'] : '';
		$questionText = trim($questionText);
		$answered_questions = isset($_POST['answeredQuestions']) ? $_POST['answeredQuestions'] : '';
		$answered_questions++;
		$questions = get_field('questions', $quizId);
		$numberOfQuestions = count($questions);
		// $quiz_done = isset($_POST['quizDone']) ? $_POST['quizDone']: '';

		// error_log(print_r($quiz_done, 1));
		foreach ($questions as $question) {

		  if ($question['question'] === $questionText) {
			$correctAnswer = '';
			
			foreach ($question['answers'] as $answer) {

			  if ($answer['correct']) {
				$correctAnswer = $answer['answer'];
				break;
			  }
			}

			$isCorrect = $correctAnswer === $answerText;
			$message = $isCorrect ? 'Correct!' : 'Wrong!';
			$class = $isCorrect ? 'correct' : 'wrong';
			$quizDone = false;
			//när frågorna är slut, skicka det till js
			error_log(print_r($quizDone, 1));
			if ($numberOfQuestions == $answered_questions) {
				$quizDone = true;
			}
			error_log(print_r($quizDone, 1));
			
			wp_send_json_success(array(
			  'message' => $message,
			  'class' => $class,
			  'questionID' => $questionId,
			  'answeredQuestions' => $answered_questions,
			  'quizDone' => $quizDone,
			));
	  
			break;
		  }
		}
		
		wp_die();
	  }
	  

	function my_shortcode_function($attr) {

        $post_id = intval($attr['id']) ? $attr['id'] : false;
        if( ! $post_id ){
            return;
        }
		
        $questions = get_field('questions', $post_id); ?>

        <div class="quiz-wrapper" data-quizid="<?php echo $post_id; ?>">
            
            <?php foreach($questions as $question_id => $question): ?>

                <div class="box" data-questionID="<?php echo $question_id; ?>">
                    <div class="box-number">
						<?php echo $question_id +1;?>
					</div>
                    <div class="question">
                        <?php echo $question['question']; ?>
                        <br>
                    </div>
                
                    <div class="answers">
                    <?php foreach($question['answers'] as $i => $val):?>
                        
                        <label for="answer-<?php echo $question_id; ?>-<?php echo $i ?>">
                            <input type="radio" id="<?php echo $question_id; ?>-<?php echo $i ?>" name="answer-<?php echo $question_id?>">
                            <?php echo $val['answer'] . "<br>"; ?>
                        </label>
                        
                    <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    <?php }

	/**
	 * Enqueue scripts in WP admin
	 *
	 * @since   1.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'assets/js/quizzie-public.js', null, $this->plugin_version, true );
		wp_localize_script( $this->plugin_name, 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), ) );
		wp_enqueue_style( 'my-plugin-style', plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'assets/css/shortcode.css' );

	}


}
new Quizzie_Public( $plugin_name, $plugin_version );
