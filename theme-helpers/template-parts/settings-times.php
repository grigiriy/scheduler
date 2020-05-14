<div class="card-body row bd-callout__no_bs bd-callout-warning">
    <div class="col-12">
        <p class="h5">Convinient time to study</p>
    </div>
    <div class="col-6">

        <p class="text-muted">
            Choose the right time to add new material with the teacher and repeat the materials you have covered - we
            will send reminders.
        </p>
    </div>
    <div class="col-6">
        <div class="d-flex">
            <div class="mr-3">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32.75px" height="32.75px" x="0px" y="0px"
                    viewBox="0 0 280.001 280.001" style="enable-background:new 0 0 280.001 280.001;"
                    xml:space="preserve">
                    <!-- Icons made by Freepik (https://www.flaticon.com/authors/freepik) from Flaticon (https://www.flaticon.com/)  -->
                    <g id="XMLID_348_">
                        <path id="XMLID_350_" d="M140.001,60.083c-8.284,0-15,6.716-15,15v49.981H75.02c-8.284,0-15,6.716-15,15c0,8.284,6.716,15,15,15
		                h64.981c8.284,0,15-6.716,15-15V75.083C155.001,66.799,148.285,60.083,140.001,60.083z" />
                        <path id="XMLID_351_" d="M140.001,0C62.804,0,0,62.804,0,140.001c0,77.196,62.804,140,140,140c77.196,0,140-62.804,140-140
                        C280.001,62.804,217.197,0,140.001,0z M140.001,250.001c-60.654,0-110-49.346-110-110C30,79.346,79.346,30,140.001,30
                        s110,49.346,110,110.001C250.001,200.655,200.655,250.001,140.001,250.001z" />
                    </g>
                </svg>
            </div>
            <div class="mb-3 timer_input" data-type="mrng_practice">
                <label>Learn new material with teacher</label>
                <input type="text" class="w-50 p-2 timepicker bg-lightGrey rounded-lg border-0"
                    value="<?= carbon_get_user_meta($user_id,'mrng_practice');?>">
                <span class="top_angle">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                        <!-- Icons made by Freepik (https://www.flaticon.com/authors/freepik) from flaticon (https://www.flaticon.com/) -->
                        <g>
                            <path fill="#888" d="M507.521,427.394L282.655,52.617c-12.074-20.122-41.237-20.122-53.311,0L4.479,427.394
			                c-12.433,20.72,2.493,47.08,26.655,47.08h449.732C505.029,474.474,519.955,448.114,507.521,427.394z" />
                        </g>
                    </svg>
                </span>
                <span class="bottom_angle">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                        <!-- Icons made by Freepik (https://www.flaticon.com/authors/freepik) from flaticon (https://www.flaticon.com/) -->
                        <g>
                            <path fill="#888" d="M507.521,427.394L282.655,52.617c-12.074-20.122-41.237-20.122-53.311,0L4.479,427.394
			                c-12.433,20.72,2.493,47.08,26.655,47.08h449.732C505.029,474.474,519.955,448.114,507.521,427.394z" />
                        </g>
                    </svg>
                </span>
                <span style="display:none" class="edit btn btn-link border-0 position-absolute mt-1">Update</span>
            </div>

        </div>

        <div class="d-flex">
            <div class="mr-3">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" width="32.75px" height="32.75px" x="0px" y="0px"
                    viewBox="0 0 280.001 280.001" style="enable-background:new 0 0 280.001 280.001;"
                    xml:space="preserve">
                    <!-- Icons made by Freepik (https://www.flaticon.com/authors/freepik) from Flaticon (https://www.flaticon.com/)  -->
                    <g id="XMLID_348_">
                        <path id="XMLID_350_" d="M140.001,60.083c-8.284,0-15,6.716-15,15v49.981H75.02c-8.284,0-15,6.716-15,15c0,8.284,6.716,15,15,15
		                h64.981c8.284,0,15-6.716,15-15V75.083C155.001,66.799,148.285,60.083,140.001,60.083z" />
                        <path id="XMLID_351_" d="M140.001,0C62.804,0,0,62.804,0,140.001c0,77.196,62.804,140,140,140c77.196,0,140-62.804,140-140
                        C280.001,62.804,217.197,0,140.001,0z M140.001,250.001c-60.654,0-110-49.346-110-110C30,79.346,79.346,30,140.001,30
                        s110,49.346,110,110.001C250.001,200.655,200.655,250.001,140.001,250.001z" />
                    </g>
                </svg>
            </div>
            <div class="mb-3 timer_input" data-type="evng_practice">
                <label>Repetition of material</label>
                <input type="text" class="w-50 p-2 timepicker bg-lightGrey rounded-lg border-0"
                    value="<?= carbon_get_user_meta($user_id,'evng_practice');?>">
                <span class="top_angle">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                        <!-- Icons made by Freepik (https://www.flaticon.com/authors/freepik) from flaticon (https://www.flaticon.com/) -->
                        <g>
                            <path fill="#888" d="M507.521,427.394L282.655,52.617c-12.074-20.122-41.237-20.122-53.311,0L4.479,427.394
			                c-12.433,20.72,2.493,47.08,26.655,47.08h449.732C505.029,474.474,519.955,448.114,507.521,427.394z" />
                        </g>

                    </svg>
                </span>
                <span class="bottom_angle">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                        <!-- Icons made by Freepik (https://www.flaticon.com/authors/freepik) from flaticon (https://www.flaticon.com/) -->
                        <g>
                            <path fill="#888" d="M507.521,427.394L282.655,52.617c-12.074-20.122-41.237-20.122-53.311,0L4.479,427.394
			                c-12.433,20.72,2.493,47.08,26.655,47.08h449.732C505.029,474.474,519.955,448.114,507.521,427.394z" />
                        </g>

                    </svg>
                </span>
                <span style="display:none" class="edit btn btn-link border-0 position-absolute mt-1">Update</span>
            </div>

        </div>
    </div>
</div>