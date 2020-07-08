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
        <div class="col-12 col-md-7">
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
                        <p class="mb-0 h5 col-10 col-lg-11">
                        Why do I need a Wishlist?
                        </p>
                        <svg version="1.1" class="col-2 col-lg-1" xmlns="http://www.w3.org/2000/svg"
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
                        As only 1 video can be added in 2 days, Wishlist can collect your preferences of what to learn next.
                        </div>
                    </div>
                </div>

                <div
                    class="card py-3 bg-transparent border-dark border-bottom border-top-0 border-right-0 border-left-0">
                    <div class="row card-header px-0 border-0 bg-transparent" id="headingTwo" type="button"
                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                        aria-controls="collapseTwo">
                        <p class="mb-0 h5 col-10 col-lg-11">
                        How much time will I need to invest?
                        </p>
                        <svg version="1.1" class="col-2 col-lg-1" xmlns="http://www.w3.org/2000/svg"
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
                        You will have 2 reviews a day for approximately 30 minutes each.
                        </div>
                    </div>
                </div>

                <div
                    class="card py-3 bg-transparent border-dark border-bottom border-top-0 border-right-0 border-left-0">
                    <div class="row card-header px-0 border-0 bg-transparent" id="headingThree" data-toggle="collapse"
                        data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <p class="mb-0 h5 col-10 col-lg-11">
                        Will I have homework?
                        </p>
                        <svg version="1.1" class="col-2 col-lg-1" xmlns="http://www.w3.org/2000/svg"
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
                        No. Focus on reviewing the material and it will help you memorize everything better. If you feel like putting extra effort you can do more reviews.
                        </div>
                    </div>
                </div>

                <div
                    class="card py-3 bg-transparent border-dark border-bottom border-top-0 border-right-0 border-left-0">
                    <div class="row card-header px-0 border-0 bg-transparent" id="headingFour" data-toggle="collapse"
                        data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <p class="mb-0 h5 col-10 col-lg-11">
                        It is too hard. How can I make the schedule lighter?
                        </p>
                        <svg version="1.1" class="col-2 col-lg-1" xmlns="http://www.w3.org/2000/svg"
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
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#help_accord">
                        <div class="card-body px-0">
                        You can skip adding new lessons.
                        </div>
                    </div>
                </div>

                <div
                    class="card py-3 bg-transparent border-dark border-bottom border-top-0 border-right-0 border-left-0">
                    <div class="row card-header px-0 border-0 bg-transparent" id="headingFive" data-toggle="collapse"
                        data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        <p class="mb-0 h5 col-10 col-lg-11">
                        Why the button “Choose this lesson” does not work?
                        </p>
                        <svg version="1.1" class="col-2 col-lg-1" xmlns="http://www.w3.org/2000/svg"
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
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#help_accord">
                        <div class="card-body px-0">
                        The system is based on creating the schedule of reviews for each lesson to help you keep focused. If you add several lessons in one day you may be overwhelmed with too many reviews afterwards. That is why you can add only 1 lesson in 2 days. This will give you both - a balanced schedule and a habit to revise the language daily.
                        </div>
                    </div>
                </div>

                <div class="card py-3 border-0">
                    <div class="row card-header px-0 border-0 bg-transparent" id="headingSix" data-toggle="collapse"
                        data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        <p class="mb-0 h5 col-10 col-lg-11">
                        I missed one of the reviews and I cannot find the video. What should I do?
                        </p>
                        <svg version="1.1" class="col-2 col-lg-1" xmlns="http://www.w3.org/2000/svg"
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
                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#help_accord">
                        <div class="card-body px-0">
                        Check the page “Passed”. When all reviews are done videos can be found there.
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-12 col-md-5 mt-5 mt-md-0">
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