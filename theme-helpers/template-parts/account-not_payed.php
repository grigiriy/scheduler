<?php if ($is_time_to_add) { ?>
<div class="border-top border-success mb-5">
    <div class="card bg-white shadow-lg bottom_rounded flag_card new_day_card not_payed">
        <div class="card-body d-flex flex-column">

            <p class="card-title h3 mb-0 ml-3 pl-5">Start learn a new material</p>

            <div class="ml-auto mr-4 mb-5">
                <p class="h1">Oh no!</p>
                <p>It seems like you spent all lessons</p>
            </div>

            <div class="d-flex justify-content-around pt-5 my-5">
                <a href="/payment/" class="btn btn-peach btn-round py-3 px-5 mt-5">Buy new lessons</a>
            </div>
        </div>
    </div>
</div>
<?php } ?>