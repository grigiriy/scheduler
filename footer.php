<div class="container-fluid">
    <footer data-id="<?= $post->ID; ?>">

    </footer>
</div>
<?php wp_footer() ?>

<script>
$(document).ready(function() {
    $('#nav').find('a').addClass('nav-link');

    let $post_id = $('footer').data('id');

    console.log($post_id);

    $('#submit_lesson').click(function() {
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'lesson_passed',
                post_id: $post_id
            }, // можно также передать в виде объекта
            success: function(data) {
                $('#submit_lesson').html(data);
                console.log(data);
            },
            error: function(errorThrown) {
                $('#submit_lesson').html('не ок - нет пермишена');
                console.log(errorThrown);
            }
        });
        // если элемент – ссылка, то не забываем:
        // return false;
    });
});
</script>
</body>

</html>