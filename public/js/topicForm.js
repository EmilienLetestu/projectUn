/**
 * Created by Emilien on 16/01/2018.
 */
$(document).ready(function (){

    $("#newTopicBtn").click(function (){
        var validate = true;
        var topic    = $("#newTopicForm input[type='text']");

        if(topic.val().length < 3 || topic.val().length > 20){
            topic.css('border-color','#F54041');
            $('#invalid_topic').show();
            $('#invalid_topic_icon').show();
            $('#valid_topic_icon').hide();
            validate = false;
        }
        else
        {
            topic.css('border-color','#5fdda1');
            $('#invalid_topic').hide();
            $('#invalid_topic_icon').hide();
            $('#valid_topic_icon').show();
        }
        return validate;
    });
});

