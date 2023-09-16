/**
 * Component to insert into the document settings sidebar for FoBV event posts
 * that allows the post date (mandatory) and end date (optional) to be set.
 */

import { __ } from '@wordpress/i18n';
import { compose } from '@wordpress/compose';
import { withSelect, withDispatch } from '@wordpress/data';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import {
	__experimentalHeading as Heading,
	Button, DatePicker, Dropdown, Flex, PanelRow
} from '@wordpress/components';

// Scalable Vector Graphics path to produce the cross icon for closing dialogs
const cross_svg_path=
	'M12 13.06l3.712 3.713 1.061-1.06L13.061 12l3.712-3.712-1.06-1.06L12 ' +
	'10.938 8.288 7.227l-1.061 1.06L10.939 12l-3.712 3.712 1.06 1.061L12 ' +
	'13.061z';

// Function that takes in date strings and reformats them to a long form
function display_date(date_in) {

	let string_out = null;

	if (date_in) {

		const event_date = new Date(date_in);

		string_out =
			Intl.DateTimeFormat('en-GB', { month: 'long' }
			).format(event_date) + ' ' +
			Intl.DateTimeFormat('en-GB', { day: 'numeric' }
			).format(event_date) + ', ' +
			Intl.DateTimeFormat('en-GB', { year: 'numeric'}
			).format(event_date);

	}

	return string_out;

}

// The definition of our FoBV event dates panel for the document settings tab
const FoBVEventDates = ( { postType, metaFields, setMetaFields } ) => {

	if ( 'fobv-event' !== postType ) return null;

	return (
		<PluginDocumentSettingPanel	title={ __( 'Date(s)' ) } icon="calendar">
			<PanelRow className="fobv-event-panel-row">
				<span>Date</span>
				<span>
					<Dropdown
						className='fobv-event-event-dates-dropdown'
						popoverProps={ { placement: 'bottom-end' } }
						focusOnMount={true}
						renderToggle={ ( { isOpen, onToggle } ) => (
							<Button
								variant='link'
								onClick={ onToggle }
								aria-expanded={ isOpen }
							>
								{display_date(
									metaFields._fobv_event_start_date
								) || 'Mandatory'}
							</Button>
						)}
						renderContent={ ( { isOpen, onToggle } ) => 
							<div>
								<Flex>
									<Heading className="fobv-event-heading">
										Date
								 	</Heading>
								 	<Button
										icon={
											<svg>
												<path d={cross_svg_path}/>
											</svg>
										}
										onClick={ onToggle }
									/>
								</Flex>
								<DatePicker 
    	        	        		currentDate={
										metaFields._fobv_event_start_date
									}
        	        	    		onChange={
										( newDate ) => setMetaFields({
											_fobv_event_start_date: newDate
										})
									}
								/>
							</div>
						}
					/>
				</span>
			</PanelRow>
			<PanelRow className="fobv-event-panel-row">
				<span>End date</span>
				<span>
					<Dropdown
						className='fobv-event-event-dates-dropdown'
						popoverProps={ { placement: 'bottom-end' } }
						focusOnMount={true}
						renderToggle={ ( { isOpen, onToggle } ) => (
							<Button
								variant='link'
								onClick={ onToggle }
								aria-expanded={ isOpen }
							>
								{display_date(
									metaFields._fobv_event_end_date
								) || 'Optional' }
							</Button>
						)}
						renderContent={ ( { isOpen, onToggle } ) =>
							<div>
								<Flex>
									<Heading className="fobv-event-heading">
										Date
								 	</Heading>
								 	<Button
										icon={
											<svg>
												<path d={cross_svg_path}/>
											</svg>
										}
										onClick={ onToggle }
									/>
								</Flex>
								<DatePicker 
    		        	        	currentDate={
										metaFields._fobv_event_end_date
									}
        	        		    	onChange={
										( newDate ) => setMetaFields({
											_fobv_event_end_date: newDate
										})
									}
								/>
							</div>
						}
					/>
				</span>
			</PanelRow>
		</PluginDocumentSettingPanel>
	)
}

const applyWithSelect = withSelect( ( select ) => {
	return {
		metaFields: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
		postType: select( 'core/editor' ).getCurrentPostType()
	};
} );

const applyWithDispatch = withDispatch( ( dispatch ) => {
	return {
		setMetaFields ( newValue ) {
			dispatch('core/editor').editPost( { meta: newValue } )
		}
	}
} );

export default compose([
	applyWithSelect,
	applyWithDispatch
])(FoBVEventDates);
