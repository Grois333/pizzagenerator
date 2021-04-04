// jQuery document ready
$(document).ready(function() {

    $('form[name="order"]').on('submit', function (e) {

        // ... your validation rules come here,

        e.preventDefault();

        // $.ajax({
        //   type: 'post',
        //   url:  form.method,
        //   data: $('form').serialize(),
        //   success: function () {
        //     alert('form was submitted');
        //   }
        // });

      });

    
});