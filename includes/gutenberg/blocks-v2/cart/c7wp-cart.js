( function( blocks, blockEditor, element ) {
	const { createElement } = element;
	const { useBlockProps } = blockEditor;
	const { __ } = wp.i18n;

	blocks.registerBlockType( 'c7wp/cart', {
		apiVersion: 3,
		title: __( 'Cart', 'wp-commerce7' ),
		description: __( 'Add a Commerce7 cart icon or flyout.', 'wp-commerce7' ),
		category: 'commerce7',
		keywords: [ 'commerce7', 'cart' ],
		attributes: {},
		edit: function() {
			const blockProps = useBlockProps( { className: 'components-placeholder' } );
			return createElement(
				'div',
				blockProps,
				createElement( 'div', { id: 'c7-cart' },
					createElement( 'strong', null, __( 'Commerce7 cart will render here.', 'wp-commerce7' ) )
				)
			);
		},
		save: function() {
			const blockProps = useBlockProps.save();
			return createElement( 'div', blockProps, createElement( 'div', { id: 'c7-cart' } ) );
		},
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.element );
