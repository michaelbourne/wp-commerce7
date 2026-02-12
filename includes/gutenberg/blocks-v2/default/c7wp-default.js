( function( blocks, blockEditor, element ) {

    var el = element.createElement;
    var useBlockProps = blockEditor.useBlockProps;

    const { __ } = wp.i18n;
    const iconEl = el('svg', { preserveAspectRatio: 'xMinYMin meet', viewBox: '0 0 28 28' },
        el('path', { fill: '#333', d: "M12.7.8c-2.6.3-5 1.3-7 2.9S2.2 7.5 1.5 10c-.8 2.4-.8 5.1-.2 7.5.7 2.5 2.1 4.7 4 6.4.1.1.2.1.3.2h.3c.1 0 .2 0 .3-.1.1-.1.2-.1.2-.2.1-.1.1-.2.1-.3v-.3c0-.1 0-.2-.1-.3-.1-.1-.1-.2-.2-.2-1.5-1.3-2.6-2.9-3.2-4.8s-.7-3.9-.4-5.8c.3-1.9 1.1-3.7 2.3-5.3s2.8-2.7 4.6-3.5c1.8-.8 3.8-1.1 5.7-.9 1.9.2 3.8.9 5.4 2 1.6 1.1 2.9 2.6 3.8 4.4.9 1.8 1.3 3.7 1.2 5.6-.1 2.3-.9 4.5-2.3 6.3-1.3 1.8-3.2 3.3-5.3 4.1-2.1.8-4.3 1-6.5.5l8-15.1c.1-.2.2-.5.2-.8 0-.1 0-.2-.1-.3 0-.1-.1-.2-.2-.3-.1-.1-.2-.1-.3-.2-.1 0-.2-.1-.4 0h-10c-.2 0-.5.1-.7.2 0 .2 0 .3-.1.4 0 .1-.1.2 0 .3 0 .1 0 .2.1.3 0 .2 0 .3.1.4.2.2.4.2.7.2h8.5L9.6 24.7c-.7 1.1-.3 1.7 1.1 2.1 1.9.5 3.8.5 5.7.2 1.9-.4 3.7-1.1 5.3-2.3 1.6-1.1 2.9-2.6 3.8-4.3s1.5-3.6 1.6-5.5c.1-1.9-.1-3.9-.8-5.7-.7-1.8-1.8-3.4-3.1-4.8s-3-2.4-4.9-3C16.5.9 14.6.6 12.7.8z" } )
    );

    blocks.registerBlockType( 'c7wp/default', {
        apiVersion: 3,
        title: __( 'Default Content', 'wp-commerce7' ),
        description: __( 'Placeholder for dynamic Commerce7 content on base routes. Required on product, club, collection, reservation, cart, and checkout pages.', 'wp-commerce7' ),
        icon: iconEl,
        category: 'commerce7',
        keywords: [ 'commerce7', 'default' ],
        example: {},
        attributes: {},
        supports: {
            html: false,
            customClassName: false,
        },
        edit: function( props ) {
            var blockProps = useBlockProps();

            return el( 'div', blockProps,
                el( 'div', { 
                    id: 'c7-content'
                },
                    el( 'h2', null,
                        __( 'Default dynamic content for Commerce7.', 'wp-commerce7' )
                    ),
                    el( 'p', null,
                        __( 'This block will automatically populate with content on a default route such as product, club, collection, reservation, cart, or checkout.', 'wp-commerce7' )
                    )
                )
            );
        },
        save: function( props ) {
            var blockProps = useBlockProps.save();

            return el( 'div', blockProps,
                el( 'div', { 
                    id: 'c7-content'
                })
            );
        },
        // Deprecated version to handle old blocks without proper className
        deprecated: [
            {
                attributes: {},
                save: function( props ) {
                    // Old save function that didn't use useBlockProps
                    return el( 'div', { 
                        className: props.className
                    },
                        el( 'div', { 
                            id: 'c7-content'
                        })
                    );
                }
            }
        ]
    } );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.element );