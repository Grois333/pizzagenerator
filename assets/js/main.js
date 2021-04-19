
//Active menu link if in page
$("a").each(function () {

    //For Home Page
    if ($(this).attr('href') === './' &&  window.location.href.indexOf("dashboard") === -1 && window.location.href.indexOf("details") === -1 && window.location.href.indexOf("login") === -1 && window.location.href.indexOf("register") === -1 && window.location.href.indexOf("order") === -1) {
        $(this).addClass('active');
    }

    //For Login Page
    if ($(this).attr('href') === 'login.php' &&  window.location.href.indexOf("login") !== -1 ) {
        $(this).addClass('active');
    }

     //For Register Page
     if ($(this).attr('href') === 'login.php' &&  window.location.href.indexOf("register") !== -1 ) {
        $(this).addClass('active');
    }

    //For account Page
    if ($(this).attr('href') === 'login.php' &&  window.location.href.indexOf("dashboard") !== -1 ) {
        $(this).addClass('active');
    }
});