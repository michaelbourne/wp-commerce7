( function( blocks, blockEditor, element ) {
	const { createElement } = element;
	const { useBlockProps } = blockEditor;
	const { __ } = wp.i18n;

	blocks.registerBlockType( 'c7wp/login', {
		apiVersion: 3,
		title: __( 'Login/Logout Link', 'wp-commerce7' ),
		description: __( 'Add a Commerce7 login and logout link.', 'wp-commerce7' ),
		category: 'commerce7',
		keywords: [ 'commerce7', 'login' ],
		attributes: {},
		edit: function() {
			const blockProps = useBlockProps( { className: 'components-placeholder' } );
			return createElement(
				'div',
				blockProps,
				createElement( 'div', { id: 'c7-account' },
					createElement( 'strong', null, __( 'Commerce7 login/logout link will render here.', 'wp-commerce7' ) )
				)
			);
		},
		save: function() {
			const blockProps = useBlockProps.save();
			return createElement( 'div', blockProps, createElement( 'div', { id: 'c7-account' } ) );
		},
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.element );
