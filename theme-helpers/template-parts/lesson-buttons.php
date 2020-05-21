<div class="d-flex mt-3 mb-4">


    <button class="btn btn-primary btn-round py-3 pl-5 px-4 mr-1" onclick="showText(this)" id="show_text">
        <span class="mr-4">Show text</span>
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            width="10px" height="10px" viewBox="0 0 284.929 284.929" style="enable-background:new 0 0 284.929 284.929;"
            xml:space="preserve">
            <g>
                <!-- Icons made by Dave Gandy (https://www.flaticon.com/authors/dave-gandy)from Flaticon (https://www.flaticon.com/) -->
                <path fill="#fff" d="M282.082,76.511l-14.274-14.273c-1.902-1.906-4.093-2.856-6.57-2.856c-2.471,0-4.661,0.95-6.563,2.856L142.466,174.441
                        L30.262,62.241c-1.903-1.906-4.093-2.856-6.567-2.856c-2.475,0-4.665,0.95-6.567,2.856L2.856,76.515C0.95,78.417,0,80.607,0,83.082
                        c0,2.473,0.953,4.663,2.856,6.565l133.043,133.046c1.902,1.903,4.093,2.854,6.567,2.854s4.661-0.951,6.562-2.854L282.082,89.647
                        c1.902-1.903,2.847-4.093,2.847-6.565C284.929,80.607,283.984,78.417,282.082,76.511z" />
            </g>
        </svg>
    </button>

    <button class="btn bg-light m-2">
        <svg class="bi bi-flag-fill mr-1 mb-1" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M3.5 1a.5.5 0 01.5.5v13a.5.5 0 01-1 0v-13a.5.5 0 01.5-.5z"
                clip-rule="evenodd" />
            <path fill-rule="evenodd"
                d="M3.762 2.558C4.735 1.909 5.348 1.5 6.5 1.5c.653 0 1.139.325 1.495.562l.032.022c.391.26.646.416.973.416.168 0 .356-.042.587-.126a8.89 8.89 0 00.593-.25c.058-.027.117-.053.18-.08.57-.255 1.278-.544 2.14-.544a.5.5 0 01.5.5v6a.5.5 0 01-.5.5c-.638 0-1.18.21-1.734.457l-.159.07c-.22.1-.453.205-.678.287A2.719 2.719 0 019 9.5c-.653 0-1.139-.325-1.495-.562l-.032-.022c-.391-.26-.646-.416-.973-.416-.833 0-1.218.246-2.223.916A.5.5 0 013.5 9V3a.5.5 0 01.223-.416l.04-.026z"
                clip-rule="evenodd" />
        </svg>
        <?= get_the_terms( $post_id, 'course_level' )[0]->name; ?>
    </button>

    <button class="btn bg-light m-2 mr-4">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            class="mr-1 mb-1" width="1em" height="1em" x="0px" y="0px" viewBox="0 0 280.001 280.001"
            style="enable-background:new 0 0 280.001 280.001;" xml:space="preserve">
            <!-- Icons made by Freepik (https://www.flaticon.com/authors/freepik) from Flaticon (https://www.flaticon.com/)  -->
            <g id="XMLID_348_">
                <path id="XMLID_350_" d="M140.001,60.083c-8.284,0-15,6.716-15,15v49.981H75.02c-8.284,0-15,6.716-15,15c0,8.284,6.716,15,15,15
		                h64.981c8.284,0,15-6.716,15-15V75.083C155.001,66.799,148.285,60.083,140.001,60.083z" />
                <path id="XMLID_351_" d="M140.001,0C62.804,0,0,62.804,0,140.001c0,77.196,62.804,140,140,140c77.196,0,140-62.804,140-140
                        C280.001,62.804,217.197,0,140.001,0z M140.001,250.001c-60.654,0-110-49.346-110-110C30,79.346,79.346,30,140.001,30
                        s110,49.346,110,110.001C250.001,200.655,200.655,250.001,140.001,250.001z" />
            </g>
        </svg>
        <?= get_the_terms( $post_id, 'course_duration' )[0]->name; ?>
    </button>

    <?php foreach( get_the_terms( $post_id, 'course_tag' ) as $tag){ ?>
    <button class="btn">
        <svg class="mr-1 mb-1" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="1em" height="1em"
            viewBox="0 0 345.567 345.567" style="enable-background:new 0 0 345.567 345.567;" xml:space="preserve">
            <!-- Icons made by Good Ware (https://www.flaticon.com/authors/good-ware) from Flaticon (https://www.flaticon.com/) -->
            <g>
                <g>
                    <path d="M263.342,9.6c-5.98-5.995-14.092-9.375-22.56-9.4h-136V0c-8.481,0.015-16.61,3.396-22.6,9.4
            c-5.995,5.98-9.375,14.093-9.4,22.56v285.76c-0.128,7,2.145,13.832,6.44,19.36c6.028,7.745,16.469,10.539,25.56,6.84
            c7.998-3.506,14.628-9.532,18.88-17.16l49.12-78.32l49.12,78.32c4.252,7.628,10.882,13.654,18.88,17.16
            c9.125,3.746,19.628,0.949,25.68-6.84c4.252-5.544,6.482-12.375,6.32-19.36V31.96C272.694,23.556,269.303,15.525,263.342,9.6z
            M253.582,326.92c-0.788,1.037-1.878,1.806-3.12,2.2c-1.339,0.293-2.735,0.167-4-0.36c-4.67-2.242-8.518-5.893-11-10.44l-56-89.2
            c-0.676-1.126-1.618-2.069-2.744-2.744c-3.789-2.273-8.703-1.045-10.976,2.744l-56,89.08c-2.428,4.609-6.25,8.332-10.92,10.64
            c-1.264,0.53-2.661,0.656-4,0.36c-1.242-0.394-2.332-1.163-3.12-2.2c-1.917-2.688-2.875-5.942-2.72-9.24V32
            c0.108-8.681,7.119-15.692,15.8-15.8h68h68c8.601,0.152,15.5,7.158,15.52,15.76v285.72
            C256.457,320.978,255.499,324.232,253.582,326.92z" />
                </g>
            </g>
        </svg>
        <?= $tag->name; ?>
    </button>
    <?php
}
?>
</div>