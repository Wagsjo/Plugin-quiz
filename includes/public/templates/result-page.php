
<?php 
    function result($amount_of_right_answers, $quiz_id, $number_of_questions, ) {

        $results = get_field( 'results', $quiz_id );
        // $results = get_field( 'results', $quiz_id );
        error_log(print_r($results, 1));

        foreach ($results as $result){
            if ($amount_of_right_answers >= $result['low_value'] && $amount_of_right_answers <= $result['high_value']) {
                $html = '<div class="box-result">
                    <h3 class="box-number-result">' . $amount_of_right_answers . '/' . $number_of_questions  . '</h3>
                    
                    <p>' . $result['result'] . '</p>
                    <div class="do-it-again-btn-cont">
                        <a class="do-it-again-btn" href="http://quizdatshit.local/quiz/">Gör test igen</a>
                    </div>
                </div>';
                // $html .= ;
                break;
            }
        }
        
        // $html .= '<a class="do-it-again-btn" href="http://quizdatshit.local/quiz/">Gör test igen</a>';

        // $html .= '<p>hej</p>';
        
        return $html;

    }
?>
