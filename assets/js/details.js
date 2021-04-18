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
            //alert('Form was submitted, Thanks for your order!');
            //console.log(data);
            location.href = 'order-thanks.php';
          },
          error: function (response) {
            console.log(response);
        }
      });

    });


    //Confirm Order Status Submit Button

    $('.confirmOrderForm').each(function(){
      //console.info(this)

      //Access this button and disable it
      let thisButton = $(this).find(".confirmOrder")[0];
      //console.log(thisButton);
      $(thisButton).prop('disabled', 'disabled');

      //Access Select Input
      let sel = $(this).find("select");
      //console.log(sel);

      //Access select option
      let selectedOption = $(this).find(":selected").val(); 
      //console.log(selectedOption); 

      //check selected option and return according
      function verifyAdSettings() {
        if (selectedOption != '' || selectedOption != 'n/a') {
            return true;
        } else {
            return false
          }
      }

      // Enable or disable confirm button
      function updateFormEnabled() {
        if (verifyAdSettings()) {
          $(thisButton).prop('disabled', false);
        } else {
          $(thisButton).attr('disabled', 'disabled');
        }
      }

      //Run Functions
      $(sel).change(updateFormEnabled);


    });
    

    
});