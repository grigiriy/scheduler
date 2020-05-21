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
    while ( have_posts() ) :
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
            <p>Call us</p>
            <p class="h3">
                <a class="text-dark" href="tel:+79998888877">+7 999 888-88-77</a>
            </p>
            <form class="form-group card my-5 p-5 top_rounded bottom_rounded border-0 shadow-lg">
                <label class="h3" for="textarea">Write your question</label>
                <textarea class="my-4 form-control border-dark rounded_1 resize_none" id="textarea" rows="3"></textarea>
                <input type="submit" class="mt-3 mr-auto d-flex align-self-center btn btn-primary btn-round px-5 py-3"
                    value="Send" />
            </form>
            <div class="card my-5 p-5 top_rounded bottom_rounded border-0 shadow-lg">
                <p class="h3 pb-4">Write us here</p>
                <div class="d-flex mr-5 pr-5">
                    <a href="#facebook" class="pr-3">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 112.196 112.196"
                            style="enable-background:new 0 0 112.196 112.196;" xml:space="preserve">
                            <g>
                                <!-- Icons made by Freepik (https://www.flaticon.com/authors/freepik) from Flaticon (https://www.flaticon.com/) -->
                                <circle style="fill:#3B5998;" cx="56.098" cy="56.098" r="56.098"></circle>
                                <path style="fill:#FFFFFF;"
                                    d="M70.201,58.294h-10.01v36.672H45.025V58.294h-7.213V45.406h7.213v-8.34
		                    c0-5.964,2.833-15.303,15.301-15.303L71.56,21.81v12.51h-8.151c-1.337,0-3.217,0.668-3.217,3.513v7.585h11.334L70.201,58.294z">
                                </path>
                            </g>
                        </svg>
                    </a>
                    <a href="#vk" class="px-3">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 112.196 112.196"
                            style="enable-background:new 0 0 112.196 112.196;" xml:space="preserve">
                            <g>
                                <g>
                                    <circle id="XMLID_11_" style="fill:#4D76A1;" cx="56.098" cy="56.098" r="56.098">
                                    </circle>
                                </g>
                                <!-- Icons made by Freepik (https://www.flaticon.com/authors/freepik) from Flaticon (https://www.flaticon.com/) -->
                                <path style="fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;" d="M53.979,80.702h4.403c0,0,1.33-0.146,2.009-0.878
                            c0.625-0.672,0.605-1.934,0.605-1.934s-0.086-5.908,2.656-6.778c2.703-0.857,6.174,5.71,9.853,8.235
                            c2.782,1.911,4.896,1.492,4.896,1.492l9.837-0.137c0,0,5.146-0.317,2.706-4.363c-0.2-0.331-1.421-2.993-7.314-8.463
                            c-6.168-5.725-5.342-4.799,2.088-14.702c4.525-6.031,6.334-9.713,5.769-11.29c-0.539-1.502-3.867-1.105-3.867-1.105l-11.076,0.069
                            c0,0-0.821-0.112-1.43,0.252c-0.595,0.357-0.978,1.189-0.978,1.189s-1.753,4.667-4.091,8.636c-4.932,8.375-6.904,8.817-7.71,8.297
                            c-1.875-1.212-1.407-4.869-1.407-7.467c0-8.116,1.231-11.5-2.397-12.376c-1.204-0.291-2.09-0.483-5.169-0.514
                            c-3.952-0.041-7.297,0.012-9.191,0.94c-1.26,0.617-2.232,1.992-1.64,2.071c0.732,0.098,2.39,0.447,3.269,1.644
                            c1.135,1.544,1.095,5.012,1.095,5.012s0.652,9.554-1.523,10.741c-1.493,0.814-3.541-0.848-7.938-8.446
                            c-2.253-3.892-3.954-8.194-3.954-8.194s-0.328-0.804-0.913-1.234c-0.71-0.521-1.702-0.687-1.702-0.687l-10.525,0.069
                            c0,0-1.58,0.044-2.16,0.731c-0.516,0.611-0.041,1.875-0.041,1.875s8.24,19.278,17.57,28.993
                            C44.264,81.287,53.979,80.702,53.979,80.702L53.979,80.702z"></path>
                            </g>
                        </svg>
                    </a>
                    <a href="#telegram" class="pl-3">
                        <svg enable-background="new 0 0 24 24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <!-- Icons made by Freepik (https://www.flaticon.com/authors/freepik) from Flaticon (https://www.flaticon.com/) -->
                            <circle cx="12" cy="12" fill="#039be5" r="12"></circle>
                            <path
                                d="m5.491 11.74 11.57-4.461c.537-.194 1.006.131.832.943l.001-.001-1.97 9.281c-.146.658-.537.818-1.084.508l-3-2.211-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.121l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953z"
                                fill="#fff"></path>
                        </svg>
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
endwhile;
}
get_footer(); ?>