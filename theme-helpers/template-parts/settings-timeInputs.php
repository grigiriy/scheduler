<div class="d-flex">
    <div class="mr-3 <?= isset($is_step) ? 'mb-3' : ''; ?>">
        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-clock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm8-7A8 8 0 1 1 0 8a8 8 0 0 1 16 0z"/>
            <path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
        </svg>
    </div>
    <div class="mb-3 timer_input <?= isset($is_step) ? '' : 'd-flex'; ?>" data-type="mrng_practice">
        <label class="align-self-center <?= isset($is_step) ? 'mb-4' : ''; ?>">First lesson</label>
        <input type="text"
            class="<?= isset($is_step) ? 'w-100 ml-n5' : 'ml-auto w-50'; ?> p-2 timepicker bg-lightGrey rounded-lg border-0"
            value="<?= carbon_get_user_meta($user_id,'mrng_practice');?>"
            >
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
    </div>

</div>

<div class="d-flex">
    <div class="mr-3">
        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-clock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm8-7A8 8 0 1 1 0 8a8 8 0 0 1 16 0z"/>
            <path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
        </svg>
    </div>
    <div class="mb-3 timer_input <?= isset($is_step) ? '' : 'd-flex'; ?>" data-type="evng_practice">
        <label class="align-self-center <?= isset($is_step) ? 'mb-4' : ''; ?>">Second lesson</label>
        <input type="text"
            class="<?= isset($is_step) ? 'w-100 ml-n5' : 'ml-auto w-50'; ?> p-2 timepicker bg-lightGrey rounded-lg border-0"
            value="<?= carbon_get_user_meta($user_id,'evng_practice');?>"
            disabled="disapled"
            >
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
    </div>

</div>
