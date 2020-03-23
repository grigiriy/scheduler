<div class="container-fluid">
    <footer class="mt-5" data-post_id="<?= $post->ID; ?>" data-user_id="<?= get_current_user_id(); ?> ">

    </footer>
</div>
<?php wp_footer() ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script>
$(document).ready(function() {

    const pageMain = document.querySelector('main');

    if ((pageMain.getAttribute('data-learning') === 'true') && pageMain.hasAttribute('data-learning')) {
        $is_learning = true;
    } else {
        if (pageMain.hasAttribute('data-learning')) {
            $(window).on('load', function() {
                $('#lesson_changed').modal('show');
            });
        }
        $is_learning = false;
    }


    $('#nav').find('a').addClass('nav-link');

    let $post_id = $('footer').data('post_id');
    let $user_id = $('footer').data('user_id');
    console.log('$post_id ', $post_id);
    console.log('$user_id ',
        $user_id);
    console.log('$is_learning ', $is_learning);

    $('#lesson_passed').click(function() {
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'lesson_passed',
                post_id: $post_id,
                user_id: $user_id,
            }, // можно также передать в виде объекта
            success: function(data) {
                $('#lesson_passed').html('ОКИ');
                console.log(data);
            },
            error: function(errorThrown) {
                $('#lesson_passed').html('не ок - нет пермишена');
                console.log(errorThrown);
            }
        });
    });

    let variant;
    $('#lesson_changed').click(function(e) {
        if (e.target.tagName === 'P') {
            if (e.target.parentNode.querySelector('.active')) {
                e.target.parentNode.querySelector('.active').classList.remove('active');
            }
            e.target.classList.add('active');
            let btn = e.target.parentNode.parentNode.querySelector('.modal-footer>button');
            btn.classList.remove('btn-secondary');
            btn.classList.add('btn-success');
            btn.removeAttribute('disabled');
            variant = e.target.getAttribute('data-variant');
        } else if (e.target.tagName === 'BUTTON' || e.target.parentNode.tagName === 'BUTTON') {
            if (variant) {

                $.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    type: 'POST',
                    data: {
                        action: 'lesson_changed',
                        post_id: $post_id,
                        user_id: $user_id,
                        is_learned: $is_learning,
                        frequency: variant
                    }, // можно также передать в виде объекта
                    success: function(data) {
                        $('#lesson_changed').find('.modal-footer>button').html('Success!');
                        console.log(data);
                    },
                    error: function(errorThrown) {
                        $('#lesson_changed').find('.modal-footer>button').html('error...');
                        $('#lesson_changed').find('.modal-footer>button').removeClass(
                            'btn-success').addClass('btn-danger');
                        console.log(errorThrown);
                    }
                });

            } else {
                console.log('not select att');
            }
        } else {
            console.log('not selected');

        }
    });
    $('#popup_frequency').bind('click', function() {
        $('#lesson_changed').find('.modal-footer>button').html('Save changes');
        $('#lesson_changed').find('.modal-footer>button').removeClass(
            'btn-success').addClass('btn-secondary');
    })
});
</script>
</body>

</html>