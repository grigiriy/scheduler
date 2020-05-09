</main>
</div>
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

    if (pageMain.hasAttribute('data-learning')) {
        if ((pageMain.getAttribute('data-learning') !== 'true') && (pageMain.getAttribute('data-can_add') ===
                'true')) {
            $(window).on('load', function() {
                $('#add_lesson').modal('show');
            });
        }
    }


    $('#nav').find('a').addClass('nav-link');

    let $post_id = $('footer').data('post_id');
    let $user_id = $('footer').data('user_id');
    console.log('$post_id ', $post_id);
    console.log('$user_id ',
        $user_id);


    $('#lesson_passed').click(function() {
        let $is_last = $('#lesson_passed').attr('data-last');
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'lesson_passed',
                post_id: $post_id,
            }, // можно также передать в виде объекта
            success: function(data) {
                $('#lesson_passed').remove();
                console.log(data);
            },
            error: function(errorThrown) {
                $('#lesson_passed').html('error...');
                console.log(errorThrown);
            }
        });
    });

    $('#favorite').click(function() {
        let __action = $('#favorite').text() === 'Add to favorite' ? 'add_to_favor' : 'remove_favor';
        let res_text = $('#favorite').text() === 'Add to favorite' ? '⭐️ Favorite' : 'Add to favorite';
        to_favorite($post_id, $user_id, __action, this, res_text);
    });

    $('#leave_course').click(function() {
        if (confirm('Are you sure?')) {

            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'leave_course',
                    post_id: $post_id,
                },
                success: function(data) {
                    $('#leave_course').hide();
                    $('#popup_start').show();
                    console.log('you left the corpse in place');
                    console.log(data);
                    window.location.href = window.location.href.split('/').slice(0, -2)
                        .join('/');
                },
                error: function(errorThrown) {
                    $('#leave_course').html('error...');
                    console.log(errorThrown);
                }
            });
        }
    });

    $('#popup_start').popover({
        trigger: 'focus'
    });


    $('#add_course').click(function(e) {
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'add_lesson',
                post_id: $post_id,
                user_id: $user_id,
            },
            success: function(data) {
                $('#add_course').html(
                    'Success!').attr('disabled', 'disabled');
                $('#popup_start').hide();
                $('#leave_course').show();
                console.log(data);
                window.location.href = window.location.href.split('/').slice(0, -2)
                    .join('/');
            },
            error: function(errorThrown) {
                $('#add_course').html(
                    'error...');
            }
        });
    });


    $('#course_filter').submit(function() {
        var filter = $(this);
        console.log(JSON.stringify(filter.serializeArray()));
        $.post({
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: 'myfilter',
                post_id: $post_id,
                data: JSON.stringify(filter.serializeArray())
            },
            beforeSend: function(xhr) {
                filter.find('input[type="submit"]').val(
                    'Progress...'); // изменяем текст кнопки
            },
            success: function(data) {
                filter.find('input[type="submit"]').val(
                    'Show lessons!'); // возвращаеи текст кнопки
                $('#courses_wrapper').html(data);
                rerenderImages();
            },
            error: function(errorThrown) {
                filter.find('input[type="submit"]').val(
                    'error...');
                console.log(errorThrown);
            }
        });
        return false;
    });
});

function to_favorite_before($_post_id, $_user_id, e) {
    let __action = $(e).hasClass('active') ? 'remove_favor' : 'add_to_favor';
    to_favorite($_post_id, $_user_id, __action, e);
}

function to_favorite($_post_id, $_user_id, __action, e, res_text) {
    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
            action: __action,
            post_id: $_post_id,
            user_id: $_user_id,
        }, // можно также передать в виде объекта
        success: function(data) {
            if (res_text) {
                $(e).html(res_text);
            } else {
                $(e).toggleClass('active');
            }
            console.log(data);
        },
        error: function(errorThrown) {
            if (res_text) {
                $(e).html('error...');
            }
            console.log(errorThrown);
        }
    });
}
</script>
</body>

</html>