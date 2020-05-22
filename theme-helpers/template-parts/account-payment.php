<?php
$role = wp_get_current_user()->roles[0];
$paysoon = 3 >= $paid;
$is_personal = isset($calend_days); //КОСТЫЛЬ - проверяет на какой странице по наличию переденной из родителя переменной календ_дейз



if(
    // $role === 'administrator' ||
    $role !== 'author' &&
    $role !== 'editor' 
){ ?>

<div class="card top_rounded shadow-lg <?= $is_personal ? 'p-5 ':'p-4 '?><?= $paysoon ? 'bg-danger' : '' ?>">
    <div class="d-flex">
        <?php if ( $paysoon ) { ?>
        <svg class="mr-3" id="Layer_1" enable-background="new 0 0 512 512" viewBox="0 0 512 512" width="55px"
            height="55px" xmlns="http://www.w3.org/2000/svg">
            <g>
                <path
                    d="m512 142.54v318.8c0 27.94-22.72 50.66-50.66 50.66h-410.68c-27.94 0-50.66-22.72-50.66-50.66v-318.8l256-50z"
                    fill="#f6f6f6" />
                <path d="m512 142.54v318.8c0 27.94-22.72 50.66-50.66 50.66h-205.34v-419.46z" fill="#efefef" />
                <path
                    d="m512 85.2v57.34h-512v-57.34c0-27.93 22.72-50.66 50.66-50.66h410.68c27.94 0 50.66 22.73 50.66 50.66z"
                    fill="#ff7d47" />
                <path d="m512 85.2v57.34h-256v-108h205.34c27.94 0 50.66 22.73 50.66 50.66z" fill="#ff405c" />
                <g>
                    <g fill="#454554">
                        <path
                            d="m158.701 0c-8.284 0-15 6.716-15 15v63.085c0 8.284 6.716 15 15 15s15-6.716 15-15v-63.085c0-8.284-6.716-15-15-15z" />
                        <path
                            d="m94 0c-8.284 0-15 6.716-15 15v63.085c0 8.284 6.716 15 15 15s15-6.716 15-15v-63.085c0-8.284-6.716-15-15-15z" />
                        <path
                            d="m223.401 0c-8.284 0-15 6.716-15 15v63.085c0 8.284 6.716 15 15 15s15-6.716 15-15v-63.085c0-8.284-6.716-15-15-15z" />
                    </g>
                    <path
                        d="m353.299 0c-8.284 0-15 6.716-15 15v63.085c0 8.284 6.716 15 15 15s15-6.716 15-15v-63.085c0-8.284-6.716-15-15-15z"
                        fill="#2e2e2e" />
                    <path
                        d="m288.599 0c-8.284 0-15 6.716-15 15v63.085c0 8.284 6.716 15 15 15s15-6.716 15-15v-63.085c0-8.284-6.716-15-15-15z"
                        fill="#2e2e2e" />
                    <path
                        d="m418 0c-8.284 0-15 6.716-15 15v63.085c0 8.284 6.716 15 15 15s15-6.716 15-15v-63.085c0-8.284-6.716-15-15-15z"
                        fill="#2e2e2e" />
                </g>
                <path
                    d="m357.86 363.39c0 56.17-45.69 101.86-101.86 101.86s-101.86-45.69-101.86-101.86c0-1.99.01-3.79.12-5.68 1.67-57.02 30.05-72.37 33.28-73.93 3.55-1.76 7.87-1.7 11.49.19 3.62 1.93 6.1 5.46 6.68 9.46 0 .04 1.15 7.42 4.64 15.07 2.03 4.43 4.35 7.96 6.95 10.55.47-12.92 1.77-28.39 5.38-42.66 5.22-20.62 17.52-41.95 33.32-58.79 5.84-6.24 12.17-11.86 18.8-16.6 3.85-2.8 8.95-3.19 13.25-.96 4.26 2.2 6.9 6.54 6.9 11.33 0 21.99 11.09 36.91 25.12 55.8 16.03 21.57 34.18 46.02 37.23 85.71.28 3.74.56 7.94.56 10.51z"
                    fill="#ff7d47" />
                <path
                    d="m357.3 352.88c.28 3.74.56 7.94.56 10.51 0 56.17-45.69 101.86-101.86 101.86v-247.65c5.84-6.24 12.17-11.86 18.8-16.6 3.85-2.8 8.95-3.19 13.25-.96 4.26 2.2 6.9 6.54 6.9 11.33 0 21.99 11.09 36.91 25.12 55.8 16.03 21.57 34.18 46.02 37.23 85.71z"
                    fill="#ff405c" />
                <path
                    d="m303.99 417.26c0 26.46-21.53 47.99-47.99 47.99s-47.99-21.53-47.99-47.99c0-11.19 6.2-24.64 19.5-42.34 8.67-11.53 17.25-20.6 17.61-20.98 2.83-2.98 6.77-4.67 10.88-4.67s8.05 1.69 10.88 4.67c.36.38 8.94 9.45 17.61 20.98 13.3 17.7 19.5 31.15 19.5 42.34z"
                    fill="#fff16b" />
                <path
                    d="m303.99 417.26c0 26.46-21.53 47.99-47.99 47.99v-115.98c4.11 0 8.05 1.69 10.88 4.67.36.38 8.94 9.45 17.61 20.98 13.3 17.7 19.5 31.15 19.5 42.34z"
                    fill="#ffd845" />
            </g>
            <!-- Icons made by Freepik("https://www.flaticon.com/authors/freepik) from Flaticon( https://www.flaticon.com/) -->
        </svg>
        <?php } else { ?>
        <svg class="mr-3" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="55px" height="55px"
            viewBox="0 0 32.75 32.75" style="enable-background:new 0 0 32.75 32.75;" xml:space="preserve">
            <!-- Icons made by Freepik (https://www.flaticon.com/authors/freepik) from flaticon(https://www.flaticon.com/" title="Flaticon) -->
            <g>
                <g>
                    <path fill="#60a9f8" d="M29.375,1.25h-1.123c0.029-0.093,0.059-0.186,0.059-0.289c0-0.53-0.432-0.961-0.963-0.961s-0.961,0.431-0.961,0.961
                        c0,0.103,0.028,0.196,0.059,0.289h-3.68c0.029-0.093,0.059-0.186,0.059-0.289C22.823,0.431,22.393,0,21.861,0
                        C21.331,0,20.9,0.431,20.9,0.961c0,0.103,0.029,0.196,0.059,0.289h-3.682c0.029-0.093,0.059-0.186,0.059-0.289
                        c0-0.53-0.43-0.961-0.961-0.961c-0.531,0-0.961,0.431-0.961,0.961c0,0.103,0.028,0.196,0.058,0.289h-3.681
                        c0.029-0.093,0.059-0.186,0.059-0.289C11.85,0.431,11.419,0,10.889,0c-0.531,0-0.962,0.431-0.962,0.961
                        c0,0.103,0.028,0.196,0.058,0.289h-3.68c0.03-0.093,0.059-0.186,0.059-0.289C6.364,0.43,5.934,0,5.403,0
                        C4.872,0,4.441,0.431,4.441,0.961c0,0.103,0.028,0.196,0.058,0.289H3.375c-1.518,0-2.75,1.233-2.75,2.75v26
                        c0,1.518,1.232,2.75,2.75,2.75H26.27l5.855-5.855V4C32.125,2.483,30.893,1.25,29.375,1.25z M30.625,26.273l-0.311,0.311h-2.355
                        c-1.102,0-2,0.9-2,2v2.355l-0.311,0.311H3.375c-0.689,0-1.25-0.561-1.25-1.25V5h28.5V26.273z">
                    </path>
                    <polygon fill="#60a9f8"
                        points="23.064,15.562 21.188,13.686 15.375,19.5 12.561,16.686 10.686,18.561 15.375,23.25">
                    </polygon>
                </g>
            </g>
        </svg>
        <?php } ?>
        <div class="mr-auto <?= ( $paysoon ) ? 'text-white' : '' ?>">
            <p class="mb-0">You've got</p>
            <p class="h3">
                <?php
                echo $paid . ' new lessons';
                ?>
            </p>
        </div>
        <?php if ($paysoon){
                if( !$is_personal ){?>
    </div>
    <?php } ?>
    <a href="/payment/"
        class="<?= ( $is_personal ) ? '' : 'mt-3' ?> mr-auto d-flex align-self-center btn btn-warning btn-round px-5 py-3">
        Buy more lessons!
    </a>
    <?php
        }
    if( $is_personal ){?>
</div>
<?php } ?>
</div>

<?php } ?>