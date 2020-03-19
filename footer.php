<div class="container-fluid">
    <footer class="mt-5" data-post_id="<?= $post->ID; ?>" data-user_id="<?= get_current_user_id(); ?> ">

    </footer>
</div>
<?php wp_footer() ?>

<script>
$(document).ready(function() {
    $('#nav').find('a').addClass('nav-link');

    let $post_id = $('footer').data('post_id');
    let $user_id = $('footer').data('user_id');
    console.log('$post_id ', $post_id);
    console.log('$user_id ', $user_id);

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
            let btn = e.target.parentNode.querySelector('button');
            btn.classList.remove('btn-secondary');
            btn.classList.add('btn-danger');
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
                        frequency: variant
                    }, // можно также передать в виде объекта
                    success: function(data) {
                        $('#lesson_changed>button').html('ОКИ');
                        console.log(data);
                    },
                    error: function(errorThrown) {
                        $('#lesson_changed').html('не ок - нет пермишена');
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
});
</script>
</body>

</html>