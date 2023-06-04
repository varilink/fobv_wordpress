import { __ } from '@wordpress/i18n';
import { compose } from '@wordpress/compose';
import { withSelect, withDispatch } from '@wordpress/data';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { PanelRow, DatePicker } from '@wordpress/components';

const FoBVEventEndDate = ( { postType, metaFields, setMetaFields } ) => {

	if ( 'fobv-event' !== postType ) return null;

	return(
		<PluginDocumentSettingPanel 
			title={ __( 'End date' ) } 
			icon="calendar"
			initialOpen={ false }
		>
			<PanelRow>
				<DatePicker 
                    currentDate={ metaFields._fobv_event_end_date }
                    onChange={ ( newDate ) => setMetaFields( { _fobv_event_end_date: newDate } ) }
                    __nextRemoveHelpButton
                    __nextRemoveResetButton
				/>
			</PanelRow>
		</PluginDocumentSettingPanel>
	);
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
])(FoBVEventEndDate);
