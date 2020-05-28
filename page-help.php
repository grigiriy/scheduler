<?php
/**
 * Template Name: Help Page
 */
get_header();

if( !is_user_logged_in() ) {
?>
<script>
document.location.href = '/';
</script>

<?php
} else {
    while ( have_posts() ) {
        the_post();
?>
<div class="container">
    <div class="row">
        <div class="col-7">
            <div class="shadow-lg accordion bottom_rounded bg-white p-5 border-top border-success" id="help_accord">
                <div class="card border-0 bg-transparent">
                    <div class="card-header p-0 border-0 bg-transparent">
                        <h2>Frequently asked questions</h2>
                    </div>
                </div>
                <div
                    class="card py-3 bg-transparent border-dark border-bottom border-top-0 border-right-0 border-left-0">
                    <div class="row card-header px-0 border-0 bg-transparent" id="headingOne" data-toggle="collapse"
                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <p class="mb-0 h5 col-11">
                            1 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.
                            Proin gravida dolor sit amet lacus accumsan et viverra justo commodo?
                        </p>
                        <svg version="1.1" class="col-1 px-4" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 451.847 451.847"
                            style="enable-background:new 0 0 451.847 451.847;" xml:space="preserve" fill="currentColor">
                            <g>
                                <!-- Icons made by Freepik / https://www.flaticon.com/authors/freepik from Flaticon / https://www.flaticon.com/ -->
                                <path
                                    d="M225.923,354.706c-8.098,0-16.195-3.092-22.369-9.263L9.27,151.157c-12.359-12.359-12.359-32.397,0-44.751
                            c12.354-12.354,32.388-12.354,44.748,0l171.905,171.915l171.906-171.909c12.359-12.354,32.391-12.354,44.744,0
                            c12.365,12.354,12.365,32.392,0,44.751L248.292,345.449C242.115,351.621,234.018,354.706,225.923,354.706z" />
                            </g>
                        </svg>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#help_accord">
                        <div class="card-body px-0">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad
                            squid.
                            3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                            laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                            coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                            anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                            occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't
                            heard
                            of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>

                <div
                    class="card py-3 bg-transparent border-dark border-bottom border-top-0 border-right-0 border-left-0">
                    <div class="row card-header px-0 border-0 bg-transparent" id="headingTwo" type="button"
                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                        aria-controls="collapseTwo">
                        <p class="mb-0 h5 col-11">
                            2 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.
                            Proin gravida dolor sit amet lacus accumsan et viverra justo commodo?
                        </p>
                        <svg version="1.1" class="col-1 px-4" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 451.847 451.847"
                            style="enable-background:new 0 0 451.847 451.847;" xml:space="preserve" fill="currentColor">
                            <g>
                                <!-- Icons made by Freepik / https://www.flaticon.com/authors/freepik from Flaticon / https://www.flaticon.com/ -->
                                <path
                                    d="M225.923,354.706c-8.098,0-16.195-3.092-22.369-9.263L9.27,151.157c-12.359-12.359-12.359-32.397,0-44.751
                            c12.354-12.354,32.388-12.354,44.748,0l171.905,171.915l171.906-171.909c12.359-12.354,32.391-12.354,44.744,0
                            c12.365,12.354,12.365,32.392,0,44.751L248.292,345.449C242.115,351.621,234.018,354.706,225.923,354.706z" />
                            </g>
                        </svg>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#help_accord">
                        <div class="card-body px-0">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad
                            squid.
                            3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                            laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                            coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                            anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                            occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't
                            heard
                            of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>

                <div class="card py-3 border-0">
                    <div class="row card-header px-0 border-0 bg-transparent" id="headingThree" data-toggle="collapse"
                        data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <p class="mb-0 h5 col-11">
                            3 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.
                            Proin gravida dolor sit amet lacus accumsan et viverra justo commodo?
                        </p>
                        <svg version="1.1" class="col-1 px-4" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 451.847 451.847"
                            style="enable-background:new 0 0 451.847 451.847;" xml:space="preserve" fill="currentColor">
                            <g>
                                <!-- Icons made by Freepik / https://www.flaticon.com/authors/freepik from Flaticon / https://www.flaticon.com/ -->
                                <path
                                    d="M225.923,354.706c-8.098,0-16.195-3.092-22.369-9.263L9.27,151.157c-12.359-12.359-12.359-32.397,0-44.751
                            c12.354-12.354,32.388-12.354,44.748,0l171.905,171.915l171.906-171.909c12.359-12.354,32.391-12.354,44.744,0
                            c12.365,12.354,12.365,32.392,0,44.751L248.292,345.449C242.115,351.621,234.018,354.706,225.923,354.706z" />
                            </g>
                        </svg>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#help_accord">
                        <div class="card-body px-0">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad
                            squid.
                            3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                            laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                            coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                            anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                            occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't
                            heard
                            of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-5">
            <div class="shadow-lg bottom_rounded bg-white p-5 border-top border-success">
                <p class="h3 pb-4">Support Team</p>
            <p class="h4">
                <a class="text-dark" href="tel:+79998888877">+7 999 888-88-77</a>
            </p>
            </div>
            <form class="form-group card my-5 p-5 top_rounded bottom_rounded border-0 shadow-lg">
                <label class="h3" for="textarea">Write your question</label>
                <textarea class="my-4 form-control border-dark rounded_1 resize_none" id="textarea" rows="3"></textarea>
                <input type="submit" class="mt-3 mr-auto d-flex align-self-center btn btn-primary btn-round px-5 py-3"
                    value="Send" />
            </form>
            <div class="card my-5 p-5 top_rounded bottom_rounded border-0 shadow-lg">
                <p class="h3 pb-4">Write us here</p>
                <?php  get_template_part('/theme-helpers/template-parts/footer','social'); ?>
            </div>
        </div>
    </div>
</div>
<?php
    }
}

get_footer(); ?>