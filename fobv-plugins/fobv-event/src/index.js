/**
 * Main Javascript file for the FoBV Event plugin. 
 */

import FoBVEventDates from './components/FoBVEventDates';
import { registerBlockVariation } from '@wordpress/blocks';
import { registerPlugin} from '@wordpress/plugins';
import { dispatch } from '@wordpress/data';
import { select } from '@wordpress/data';
import { subscribe } from '@wordpress/data';

import './index.scss'; // Styling for the FoBV event dates component

registerBlockVariation( 'core/query', {
	name: 'fobv-event/query',
	title: 'Events List',
	description: 'Displays a list of upcoming events',
	category: 'fobv',
	allowedControls: [],
	attributes: {
		query: {
			perPage: 6,
			pages: 0,
			offset: 0,
			postType: 'fobv-event',
			order: 'asc',
			orderBy: 'date',
			author: '',
			search: '',
			exclude: [],
			sticky: 'exclude',
			inherit: false
		},
		displayLayout: {
			type: 'flex',
			columns: 3
		}
	},
    isActive: ( { namespace, query } ) => {
        return (
            query.postType === 'fobv-event'
        );
    },
	innerBlocks: [
		[
			'core/post-template',
			{},
			[
				[
					'core/group',
					{
						style: {
							spacing: {
								padding: {
									top: '30px',
									right: '30px',
									bottom: '30px',
									left: '30px'
								}
							}
						},
						layout: {
							inherit: false
						}	
					},
					[
						[ 'core/post-featured-image' ],
						[ 'core/post-title' ],
						[ 'core/post-excerpt' ]
					]
				]
			]
		],
		[ 'core/query-pagination' ],
		[ 'core/query-no-results' ]
	],
	scope: [ 'inserter' ]
} );

// Register the plugin so that our settings panel for event dates renders
registerPlugin( 'fobv-event-dates', {
	render: FoBVEventDates
} );

// Validation of the event dates on trying to publish an FoBV event post type

let wasSavingPost = false; // on initial load the editor won't be saving

const unsubscribe = subscribe(
	() => {
		const editor = select('core/editor');
		if (
			! wasSavingPost &&
			editor.isSavingPost() && ! editor.isAutosavingPost() &&
			editor.getCurrentPostAttribute('type') === 'fobv-event' &&
			editor.getEditedPostAttribute('status') === 'publish'
		) {
			wasSavingPost = true;
		} else if (
			wasSavingPost && ! editor.isSavingPost() &&
			editor.getCurrentPostAttribute('type') === 'fobv-event' &&
			editor.getEditedPostAttribute('status') === 'publish'
		) {
			wasSavingPost = false;
			const start_date = editor.getEditedPostAttribute('meta').
				_fobv_event_start_date;
			const end_date = editor.getEditedPostAttribute('meta').
				_fobv_event_end_date;
			let message = '';
			if ( ! start_date ) {
				message =
					'You cannot publish an event' + ' ' +
					'with no date.';
			} else {
				// current datetime as object
				const now = new Date();
				// today in YYYY-MM-DD format
				const today = now.toISOString().substring(0, 10);
				if ( start_date <= today ) {
					message =
						'You cannot publish an event' + ' ' +
						'with a date not later than today.';
				} else if (
					end_date && end_date < start_date
				) {
					message =
						'You cannot publish an event' + ' ' +
						'with an end date earlier than its date.'
				}
			}
			if ( message ) {
				message += ' ' +
					'This event has been reverted to draft.' + ' ' +
					'Edit the event settings to correct this and try again.'
				dispatch('core/editor').editPost( { status: 'draft' } );
				dispatch('core/editor').savePost();
				dispatch('core/notices').createErrorNotice(message);
			}
		}
	},
	'core' // only subscribe to state change of the core data module
);
