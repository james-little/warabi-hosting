<?php

add_filter( 'hb_search_form_markup', 'adomus_booking_hero_search_form', 10, 2 );

function adomus_booking_hero_search_form( $form_markup, $form_id ) {
	if ( $form_id != 'hero-search-form' ) {
		return $form_markup;
	} else {
		return '
			<form [form_id] class="[form_class]" method="POST" data-search-only="[search_only_data]" action="[form_action]">
				[form_title]
				<div class="hb-searched-summary">
					<p class="hb-check-dates-wrapper hb-chosen-check-in-date">[string_chosen_check_in]<span></span></p>
					<p class="hb-check-dates-wrapper hb-chosen-check-out-date">[string_chosen_check_out]<span></span></p>
					<p class="hb-people-wrapper hb-chosen-adults">[string_chosen_adults]<span></span></p>
					<p class="hb-people-wrapper hb-people-wrapper-last hb-chosen-children">[string_chosen_children]<span></span></p>
					<p class="hb-booking-change-search">
						<input type="button" value="[string_change_search_button]" />
					</p>
				</div><!-- .hb-searched-summary -->
				<div class="hb-search-fields-and-submit">
					<div class="hb-search-fields hb-clearfix">
						<p class="hb-check-dates-wrapper">
							[check_in_label]
							<input value="" id="check-in-date" name="hb-check-in-date" class="hb-input-datepicker hb-check-in-date" type="text" placeholder="[check_in_placeholder]" />
							<input class="hb-check-in-hidden" name="hb-check-in-hidden" type="hidden" value="[check_in]" />
							<span class="hb-datepick-check-in-out-mobile-trigger hb-datepick-check-in-mobile-trigger"></span>
							<span class="hb-datepick-check-in-out-trigger hb-datepick-check-in-trigger"></span>
						</p>
						<p class="hb-check-dates-wrapper">
							[check_out_label]
							<input value="" id="check-out-date" name="hb-check-out-date" class="hb-input-datepicker hb-check-out-date" type="text" placeholder="[check_out_placeholder]" />
							<input class="hb-check-out-hidden" name="hb-check-out-hidden" type="hidden" value="[check_out]" />
							<span class="hb-datepick-check-in-out-mobile-trigger hb-datepick-check-out-mobile-trigger"></span>
							<span class="hb-datepick-check-in-out-trigger hb-datepick-check-out-trigger"></span>
						</p>
						<p class="hb-people-wrapper hb-people-wrapper-adults">
							[adults_label]
							[people_selects_adults]
							<input class="hb-adults-hidden" type="hidden" value="[adults]" />
						</p>
						<p class="hb-people-wrapper hb-people-wrapper-children hb-people-wrapper-last">
							[children_label]
							[people_selects_children]
							<input class="hb-children-hidden" type="hidden" value="[children]" />
						</p>
						<p class="hb-booking-search-submit">
							<input type="submit" value="[string_search_button]" />
						</p>
					</div><!-- .hb-search-fields -->
					<p class="hb-search-error"></p>
					<p class="hb-search-no-result"></p>
				</div><!-- .hb-search-fields-and-submit -->
				<input type="hidden" class="hb-results-show-only-accom-id" name="hb-results-show-only-accom-id" />
				<div class="hb-accom-list"></div>
			</form><!-- end #hb-booking-search-form -->';
	}
}

function htw_is_active() {
}