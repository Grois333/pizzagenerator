// jQuery document ready
$(document).ready(function() {

    $('form[name="orderForm"]').on('submit', function (e) {

        //Validation rules come here
        if($('input[name=name]').val() == ""){
          $(".orderName-error").text('Name is required');
        } else{ $(".orderName-error").text('');}
        
        if($('input[name=phone]').val() == ""){
          $(".orderPhone-error").text('Phone is required');
        } else {$(".orderPhone-error").text('');}

        if($('input[name=email]').val() == ""){
          $(".orderEmail-error").text('Email is required');
        } else {$(".orderEmail-error").text('');}

        // All inputs empty return false
        if($('input[name=name]').val() == "" || $('input[name=phone]').val() == "" || $('input[name=email]').val() == "" ){
          return false;
        }
        
        e.preventDefault();

        $.ajax({
          type: 'post',
          url:  'details.php',
          data: $(this).serialize(),  //get all input data
          success: function (data) {
            alert('Form was submitted, Thanks for your order!');
            //console.log(data);
            //location.href = 'index.php';
          },
          error: function (response) {
            console.log(response);
        }
      });

    });
    
});