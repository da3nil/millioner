$(window).on('load', function () {
    $preloader = $('.loaderArea'),
      $loader = $preloader.find('.loader');
    $loader.fadeOut();
    $preloader.delay(350).fadeOut('slow');
  });

$(document).ready(function($) {

    // Добавляем маску для поля с номера телефона
    $('#phone').mask('+7 (999) 999-99-99');

    // Проверяет отмечен ли чекбокс согласия
    // с обработкой персональных данных
    $('#check').on('click', function() {
        if ($("#check").prop("checked")) {
            $('#button').attr('disabled', false);
        } else {
            $('#button').attr('disabled', true);
        }
    });

    // Отправляет данные из формы на сервер и получает ответ
    $('#contactForm').on('submit', function(event) {
        
        event.preventDefault();

        var form = $('#contactForm'),
            button = $('#button'),
            answer = $('#answer'),
            loader = $('#loader');

        $.ajax({
            url: 'handler.php',
            type: 'POST',
            data: form.serialize(),
            beforeSend: function() {
                answer.empty();
                button.attr('disabled', true).css('margin-bottom', '20px');
                // button.attr('disabled', true).css('border-top', '1px solid black');
                loader.fadeIn();
            },
            success: function(result) {
                loader.fadeOut(300, function() {
                    answer.text(result);
                });
                form.find('.field').val('');
                button.attr('disabled', false);
            },
            error: function() {
                loader.fadeOut(300, function() {
                    answer.text('Произошла ошибка! Попробуйте позже.');
                });
                button.attr('disabled', false);
            }
        });
    
    });

});

$(function(){
	
	var note = $('#note'),
		//ts = new Date(2014, 8, 6),
		ts = new Date(2019, 1, 10),
		newYear = true;
	
	if((new Date()) > ts){
		// The new year is here! Count towards something else.
		// Notice the *1000 at the end - time must be in milliseconds
		var date = new Date();
		date_d = date.getDay();
		date_h = date.getHours()+2;
		date_m = date.getMinutes();
		d_date = 50*24*60*60*1000-(date_d)*24*60*60*1000-date_h*60*60*1000-date_m*60*1000;
// 		ts = (new Date()).getTime() + d_date;
		ts = (new Date()).getTime() + d_date;
		newYear = false;
	}
		
	$('#countdown').countdown({
		timestamp	: ts,
		callback	: function(days, hours, minutes, seconds){
			
			var message = "";
			
			message += days + " day" + ( days==1 ? '':'s' ) + ", ";
			message += hours + " hour" + ( hours==1 ? '':'s' ) + ", ";
			message += minutes + " minute" + ( minutes==1 ? '':'s' ) + " and ";
			message += seconds + " second" + ( seconds==1 ? '':'s' ) + " <br />";
			
			if(newYear){
				message += "left until the new year!";
			}
			else {
				message += "left to 10 days from now!";
			}
			
			note.html(message);
		}
	});
	
});


function num_anim() {
	$({blurRadius: 0}).animate({blurRadius: 0}, {
				duration: 1000,
				easing: 'swing',
				step: function() {
					$(".count").css({
						"-webkit-filter": "blur("+this.blurRadius+"px)",
						"filter": "blur("+this.blurRadius+"px)"
					});
				}
			});
						var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(' ');
			$(".count").each(function() {
				var tcount = $(this).data("count");
				$(this).animateNumber({ number: tcount,
					easing: 'easeInQuad',
					"font-size": "40px",
					numberStep: comma_separator_number_step},
					1000);
	});
}

var $win = $(window);
var $marker = $('.members');
$win.scroll(function() {
    if ($win.scrollTop() + $win.height() >= $marker.offset().top) {
        $win.unbind('scroll');
        num_anim();
    }
});


if (screen.height > 1000) {
	console.log(1);
	num_anim();
}

// else {

// }

// var checkVisible = setInterval(function(){

//     // if element doesn't exist or isn't visible then end
// 	if(!$('.members').length || !$('#element').is(':visible'))
//         return;

//     // if element does exist and is visible then stop the interval and run code

//     clearInterval(checkVisible);
//     num_anim();
//     // place your code here to run when the element becomes visible

// },1000);



console.log(screen.height);


// Particles
var count_particles, update;
  count_particles = document.querySelector('.js-count-particles');
  update = function() {
    if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
      // count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
    }
    requestAnimationFrame(update);
  };
  requestAnimationFrame(update);


