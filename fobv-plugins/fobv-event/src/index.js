import { registerBlockVariation } from '@wordpress/blocks';
import { registerPlugin} from '@wordpress/plugins';
import FoBVEventStartDate from './components/FoBVEventStartDate';
import FoBVEventEndDate from './components/FoBVEventEndDate';

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

registerPlugin( 'fobv-event-start-date', {
	render: FoBVEventStartDate
} );

registerPlugin( 'fobv-event-end-date', {
	render: FoBVEventEndDate
} );
