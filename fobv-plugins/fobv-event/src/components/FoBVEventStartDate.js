import { __ } from '@wordpress/i18n';
import { compose } from '@wordpress/compose';
import { withSelect, withDispatch } from '@wordpress/data';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { Button, Dropdown, PanelRow, DatePicker } from '@wordpress/components';

function display_date(date_in) {

	let string_out = 'You must select a start date';

	if (date_in) {

		string_out =
			date_in.substring(8, 10) + '-' +
			date_in.substring(5, 7) + '-' +
			date_in.substring(0, 4);

	}

	return string_out;

}

const FoBVEventStartDate = ( { postType, metaFields, setMetaFields } ) => {

	if ( 'fobv-event' !== postType ) return null;

	return (

		<PluginDocumentSettingPanel
			title={ __( 'Start date' ) } 
			icon="calendar"
			initialOpen={ true }
		>

			<PanelRow>

				<Dropdown
					renderToggle={ ( { isOpen, onToggle } ) => (

						<Button
							variant='link'
							onClick={ onToggle }
							aria-expanded={ isOpen }
						>
							{display_date(metaFields._fobv_event_start_date)}
						</Button>

					)}
					renderContent={ () => (
						<DatePicker 
    	        	        currentDate={
								metaFields._fobv_event_start_date | null
							}
        	        	    onChange={
								( newDate ) =>
								setMetaFields( {
									_fobv_event_start_date: newDate
								} )
							}
						/>
					)}
				/>

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
])(FoBVEventStartDate);
