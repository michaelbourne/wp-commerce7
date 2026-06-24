( function ( blocks, blockEditor, element, i18n, components ) {
	const { registerBlockType } = blocks;
	const { InspectorControls, useBlockProps } = blockEditor;
	const { PanelBody, TextControl, Button, RadioControl } = components;
	const { createElement, Fragment } = element;
	const { __ } = i18n;

	const iconEl = createElement(
		'svg',
		{ preserveAspectRatio: 'xMinYMin meet', viewBox: '0 0 28 28' },
		createElement( 'path', {
			fill: '#333',
			d: 'M12.7.8c-2.6.3-5 1.3-7 2.9S2.2 7.5 1.5 10c-.8 2.4-.8 5.1-.2 7.5.7 2.5 2.1 4.7 4 6.4.1.1.2.1.3.2h.3c.1 0 .2 0 .3-.1.1-.1.2-.1.2-.2.1-.1.1-.2.1-.3v-.3c0-.1 0-.2-.1-.3-.1-.1-.1-.2-.2-.2-1.5-1.3-2.6-2.9-3.2-4.8s-.7-3.9-.4-5.8c.3-1.9 1.1-3.7 2.3-5.3s2.8-2.7 4.6-3.5c1.8-.8 3.8-1.1 5.7-.9 1.9.2 3.8.9 5.4 2 1.6 1.1 2.9 2.6 3.8 4.4.9 1.8 1.3 3.7 1.2 5.6-.1 2.3-.9 4.5-2.3 6.3-1.3 1.8-3.2 3.3-5.3 4.1-2.1.8-4.3 1-6.5.5l8-15.1c.1-.2.2-.5.2-.8 0-.1 0-.2-.1-.3 0-.1-.1-.2-.2-.3-.1-.1-.2-.1-.3-.2-.1 0-.2-.1-.4 0h-10c-.2 0-.5.1-.7.2 0 .2 0 .3-.1.4 0 .1-.1.2 0 .3 0 .1 0 .2.1.3 0 .2 0 .3.1.4.2.2.4.2.7.2h8.5L9.6 24.7c-.7 1.1-.3 1.7 1.1 2.1 1.9.5 3.8.5 5.7.2 1.9-.4 3.7-1.1 5.3-2.3 1.6-1.1 2.9-2.6 3.8-4.3s1.5-3.6 1.6-5.5c.1-1.9-.1-3.9-.8-5.7-.7-1.8-1.8-3.4-3.1-4.8s-3-2.4-4.9-3C16.5.9 14.6.6 12.7.8z',
		} )
	);

	const defaultClub = () => ( {
		slug: '',
		name: '',
		joinText: __( 'Join Now', 'wp-commerce7' ),
		editText: __( 'Edit Membership', 'wp-commerce7' ),
	} );

	const getValidationIssues = ( clubs ) => {
		const issues = [];

		if ( ! clubs.length ) {
			issues.push( __( 'No clubs added', 'wp-commerce7' ) );
			return issues;
		}

		clubs.forEach( ( club, index ) => {
			if ( ! club.slug || ! club.slug.trim() ) {
				issues.push( __( 'Club #' + ( index + 1 ) + ' has no slug', 'wp-commerce7' ) );
			}
			if ( ! club.name || ! club.name.trim() ) {
				issues.push( __( 'Club #' + ( index + 1 ) + ' has no name', 'wp-commerce7' ) );
			}
		} );

		const slugs = clubs.map( ( club ) => club.slug?.toLowerCase() ).filter( Boolean );
		if ( slugs.length !== new Set( slugs ).size ) {
			issues.push( __( 'Duplicate club slugs found', 'wp-commerce7' ) );
		}

		return issues;
	};

	const renderJoinButtonPreview = ( club, isActive ) => {
		const slugProvided = club.slug && club.slug.trim();

		return createElement(
			'div',
			{
				className: 'club-join-button-wrap' + ( isActive ? ' is-active' : '' ),
				key: club.slug || club.name || Math.random(),
				hidden: ! isActive,
			},
			createElement(
				'div',
				{
					className: 'c7-club-join-button',
					'data-club-slug': club.slug,
					'data-join-text': club.joinText || __( 'Join Now', 'wp-commerce7' ),
					'data-edit-text': club.editText || __( 'Edit Membership', 'wp-commerce7' ),
				},
				slugProvided
					? createElement(
							'a',
							{
								className: 'c7-btn c7-btn--primary',
								role: 'link',
								tabIndex: -1,
								disabled: true,
							},
							club.joinText || __( 'Join Now', 'wp-commerce7' )
					  )
					: createElement(
							'div',
							{ className: 'c7-message c7-message--alert-error', role: 'presentation' },
							__( 'Please enter a club slug', 'wp-commerce7' )
					  )
			)
		);
	};

	registerBlockType( 'c7wp/clubselector-v2', {
		apiVersion: 3,
		title: __( 'Club Selector v2', 'wp-commerce7' ),
		description: __(
			'Improved Club Selector with Commerce7 join buttons.',
			'wp-commerce7'
		),
		icon: iconEl,
		category: 'commerce7',
		keywords: [ 'commerce7', 'club', 'selector', 'join' ],
		attributes: {
			displayType: {
				type: 'string',
				default: 'radio',
			},
			clubs: {
				type: 'array',
				default: [],
			},
			radioGroupName: {
				type: 'string',
				default: '',
			},
		},
		supports: {
			customClassName: false,
			html: false,
		},
		edit: function ( props ) {
			const { attributes, setAttributes, clientId } = props;
			const { displayType, clubs } = attributes;
			const blockProps = useBlockProps( {
				className: ! clubs.length ? 'components-placeholder' : undefined,
			} );
			const radioGroupName = attributes.radioGroupName || 'club-selector-v2-' + clientId.slice( 0, 8 );
			const validationIssues = getValidationIssues( clubs );

			const addClub = () => {
				setAttributes( { clubs: [ ...clubs, defaultClub() ] } );
			};

			const removeClub = ( index ) => {
				if ( clubs.length <= 1 ) {
					return;
				}
				const newClubs = [ ...clubs ];
				newClubs.splice( index, 1 );
				setAttributes( { clubs: newClubs } );
			};

			const updateClub = ( index, field, value ) => {
				const newClubs = [ ...clubs ];
				newClubs[ index ] = { ...newClubs[ index ], [ field ]: value };
				setAttributes( { clubs: newClubs } );
			};

			const validateSlug = ( index, value ) => {
				if ( ! value ) {
					return;
				}
				const isDuplicate = clubs.some(
					( club, i ) => i !== index && club.slug && club.slug.toLowerCase() === value.toLowerCase()
				);
				if ( isDuplicate ) {
					const newClubs = [ ...clubs ];
					newClubs[ index ] = { ...newClubs[ index ], slug: clubs[ index ].slug };
					setAttributes( { clubs: newClubs } );
				}
			};

			if ( ! clubs.length ) {
				return createElement(
					'div',
					blockProps,
					createElement( 'div', { className: 'components-placeholder__label' }, __( 'Club Selector v2', 'wp-commerce7' ) ),
					createElement(
						'div',
						{ className: 'components-placeholder__instructions' },
						__( 'Improved Club Selector with Commerce7 join buttons.', 'wp-commerce7' )
					),
					createElement(
						Button,
						{
							variant: 'primary',
							onClick: addClub,
						},
						__( 'Add Club', 'wp-commerce7' )
					)
				);
			}

			return createElement(
				Fragment,
				null,
				createElement(
					InspectorControls,
					null,
					createElement(
						PanelBody,
						{ title: __( 'Club Selector v2 Settings', 'wp-commerce7' ), initialOpen: true },
						createElement( TextControl, {
							label: __( 'Radio Group Name', 'wp-commerce7' ),
							value: attributes.radioGroupName,
							onChange: ( value ) => {
								const sanitized = value.replace( /[^a-zA-Z0-9_-]/g, '' );
								setAttributes( { radioGroupName: sanitized } );
							},
							help: __(
								'Must be unique if you use more than one Club Selector v2 block on a page.',
								'wp-commerce7'
							),
							placeholder: __( 'premierclub', 'wp-commerce7' ),
						} ),
						createElement( RadioControl, {
							label: __( 'Display Type', 'wp-commerce7' ),
							selected: displayType,
							options: [
								{ label: __( 'Radio Buttons', 'wp-commerce7' ), value: 'radio' },
								{ label: __( 'Dropdown', 'wp-commerce7' ), value: 'select' },
							],
							onChange: ( value ) => setAttributes( { displayType: value } ),
						} ),
						createElement(
							'div',
							null,
							clubs.map( ( club, index ) =>
								createElement(
									'div',
									{ key: index, className: 'club-item-v2' },
									createElement( TextControl, {
										label: __( 'Club Slug', 'wp-commerce7' ),
										value: club.slug,
										onChange: ( value ) => updateClub( index, 'slug', value ),
										onBlur: ( event ) => validateSlug( index, event.target.value ),
										placeholder: __( '12-bottle-club', 'wp-commerce7' ),
									} ),
									createElement( TextControl, {
										label: __( 'Club Name', 'wp-commerce7' ),
										value: club.name,
										onChange: ( value ) => updateClub( index, 'name', value ),
										placeholder: __( '12 Bottles', 'wp-commerce7' ),
									} ),
									createElement( TextControl, {
										label: __( 'Join Text', 'wp-commerce7' ),
										value: club.joinText,
										onChange: ( value ) => updateClub( index, 'joinText', value ),
									} ),
									createElement( TextControl, {
										label: __( 'Edit Membership Text', 'wp-commerce7' ),
										value: club.editText,
										onChange: ( value ) => updateClub( index, 'editText', value ),
									} ),
									createElement(
										Button,
										{
											variant: 'secondary',
											isDestructive: true,
											onClick: () => removeClub( index ),
											disabled: clubs.length <= 1,
										},
										__( 'Remove Club', 'wp-commerce7' )
									)
								)
							),
							createElement(
								Button,
								{
									variant: 'primary',
									onClick: addClub,
								},
								__( 'Add Club', 'wp-commerce7' )
							)
						)
					)
				),
				createElement(
					'div',
					{ ...blockProps },
					createElement(
						'div',
						{ className: 'club-selector-v2-preview' },
						validationIssues.length > 0 &&
							createElement(
								'div',
								{ className: 'components-notice is-warning', style: { marginBottom: '1em' } },
								createElement(
									'div',
									{ className: 'components-notice__content' },
									createElement( 'p', null, __( 'Fix these issues before the block will render:', 'wp-commerce7' ) ),
									createElement(
										'ul',
										null,
										validationIssues.map( ( issue, index ) => createElement( 'li', { key: index }, issue ) )
									)
								)
							),
						displayType === 'radio'
							? createElement(
									'div',
									{ className: 'club-radio-buttons-v2' },
									createElement(
										'fieldset',
										null,
										createElement( 'legend', { className: 'screen-reader-text' }, __( 'Choose your desired club', 'wp-commerce7' ) ),
										createElement(
											'div',
											{ className: 'radios' },
											clubs.map( ( club, index ) =>
												createElement(
													'div',
													{ key: index, className: 'row' },
													createElement( 'input', {
														type: 'radio',
														name: radioGroupName,
														id: 'club-v2-' + club.slug + '-' + clientId,
														value: club.slug,
														className: 'choice-v2',
														defaultChecked: index === 0,
														'aria-label': club.name,
													} ),
													createElement( 'label', { htmlFor: 'club-v2-' + club.slug + '-' + clientId }, club.name )
												)
											)
										)
									)
							  )
							: createElement(
									'select',
									{ className: 'club-select-v2', 'aria-label': __( 'Choose your desired club', 'wp-commerce7' ) },
									clubs.map( ( club, index ) =>
										createElement(
											'option',
											{ key: index, value: club.slug, selected: index === 0 },
											club.name
										)
									)
							  ),
						createElement(
							'div',
							{ className: 'club-join-buttons-v2' },
							clubs.map( ( club, index ) => renderJoinButtonPreview( club, index === 0 ) )
						)
					)
				)
			);
		},
		save: function () {
			return null;
		},
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.element, window.wp.i18n, window.wp.components );
