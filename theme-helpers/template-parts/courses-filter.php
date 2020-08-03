<form class="mb-5" id="course_filter">
<?php if (carbon_get_theme_option( 'teacher' )) { ?>
    <div>
        <label class="h6" for="select_level">
            <svg class="bi bi-flag-fill mr-1 mb-1" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3.5 1a.5.5 0 01.5.5v13a.5.5 0 01-1 0v-13a.5.5 0 01.5-.5z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd"
                    d="M3.762 2.558C4.735 1.909 5.348 1.5 6.5 1.5c.653 0 1.139.325 1.495.562l.032.022c.391.26.646.416.973.416.168 0 .356-.042.587-.126a8.89 8.89 0 00.593-.25c.058-.027.117-.053.18-.08.57-.255 1.278-.544 2.14-.544a.5.5 0 01.5.5v6a.5.5 0 01-.5.5c-.638 0-1.18.21-1.734.457l-.159.07c-.22.1-.453.205-.678.287A2.719 2.719 0 019 9.5c-.653 0-1.139-.325-1.495-.562l-.032-.022c-.391-.26-.646-.416-.973-.416-.833 0-1.218.246-2.223.916A.5.5 0 013.5 9V3a.5.5 0 01.223-.416l.04-.026z"
                    clip-rule="evenodd" />
            </svg>
            Chose level
        </label>
        <select class="custom-select mr-sm-2" name="course_level" id="select_level">
            <option value="any">All</option>
            <?php foreach ($terms as $term) : ?>
            <option value="<?= $term->term_id ?>"><?= $term->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label class="h6 mt-5" for="select_duration">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" class="mr-1 mb-1" width="1em" height="1em" x="0px" y="0px"
                viewBox="0 0 280.001 280.001" style="enable-background:new 0 0 280.001 280.001;" xml:space="preserve">
                <g id="XMLID_348_">
                    <path id="XMLID_350_" d="M140.001,60.083c-8.284,0-15,6.716-15,15v49.981H75.02c-8.284,0-15,6.716-15,15c0,8.284,6.716,15,15,15
		                h64.981c8.284,0,15-6.716,15-15V75.083C155.001,66.799,148.285,60.083,140.001,60.083z" />
                    <path id="XMLID_351_" d="M140.001,0C62.804,0,0,62.804,0,140.001c0,77.196,62.804,140,140,140c77.196,0,140-62.804,140-140
                        C280.001,62.804,217.197,0,140.001,0z M140.001,250.001c-60.654,0-110-49.346-110-110C30,79.346,79.346,30,140.001,30
                        s110,49.346,110,110.001C250.001,200.655,200.655,250.001,140.001,250.001z" />
                </g>
            </svg>
            Chose lesson duration
        </label>
        <select class="custom-select mr-sm-2" id="select_duration" name="course_duration">
            <option value="any">All</option>
            <?php foreach ($terms as $term) : ?>
            <option value="<?= $term->term_id ?>"><?= $term->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
<?php } ?>
    <div class="d-flex flex-wrap">
        <label class="h6 <?php carbon_get_theme_option( 'teacher' ) ? '' : 'mt-5' ;?> d-block w-100">
            <svg class="mr-1 mb-1" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="1em" height="1em"
                viewBox="0 0 345.567 345.567" style="enable-background:new 0 0 345.567 345.567;" xml:space="preserve">
                <!-- Icons made by Good Ware https://www.flaticon.com/authors/good-ware from Flaticon https://www.flaticon.com/ -->
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

            Themes</label>
            <code class="bg-light">
            <h3>CSS</h3>
            .course_tag span{}
            </code>
        <?php
    
        $course_tags = get_terms( 'course_tag', [
        'hide_empty' => false,
        ] );
        
        foreach ($course_tags as $course_tag) {?>
        <label class="btn-checkbox mr-2 course_tag" for="<?= $course_tag->slug ?>">

            <input name="course_tag" id="<?= $course_tag->slug ?>" type="checkbox" value="<?= $course_tag->term_id?>" />
            <span class="btn rounded-0"><?= $course_tag->name?></span>

        </label>
        <?php } ?>
    </div>

    <div class="mt-5 d-flex">
        <input type="submit" class=" btn btn-warning btn-round px-4 py-3" value="Show lessons">
    </div>

</form>