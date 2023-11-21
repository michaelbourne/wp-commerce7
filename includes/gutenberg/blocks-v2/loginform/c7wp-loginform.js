(function (blocks, blockEditor, element, i18n, components) {

    const { registerBlockType } = blocks;
    const { InspectorControls } = blockEditor;
    const { TextControl, PanelBody } = components;
    const { createElement } = element;
    const { __ } = i18n;

    const iconEl = createElement('svg', { preserveAspectRatio: 'xMinYMin meet', viewBox: '0 0 28 28' },
    createElement('path', { fill: '#333', d: "M12.7.8c-2.6.3-5 1.3-7 2.9S2.2 7.5 1.5 10c-.8 2.4-.8 5.1-.2 7.5.7 2.5 2.1 4.7 4 6.4.1.1.2.1.3.2h.3c.1 0 .2 0 .3-.1.1-.1.2-.1.2-.2.1-.1.1-.2.1-.3v-.3c0-.1 0-.2-.1-.3-.1-.1-.1-.2-.2-.2-1.5-1.3-2.6-2.9-3.2-4.8s-.7-3.9-.4-5.8c.3-1.9 1.1-3.7 2.3-5.3s2.8-2.7 4.6-3.5c1.8-.8 3.8-1.1 5.7-.9 1.9.2 3.8.9 5.4 2 1.6 1.1 2.9 2.6 3.8 4.4.9 1.8 1.3 3.7 1.2 5.6-.1 2.3-.9 4.5-2.3 6.3-1.3 1.8-3.2 3.3-5.3 4.1-2.1.8-4.3 1-6.5.5l8-15.1c.1-.2.2-.5.2-.8 0-.1 0-.2-.1-.3 0-.1-.1-.2-.2-.3-.1-.1-.2-.1-.3-.2-.1 0-.2-.1-.4 0h-10c-.2 0-.5.1-.7.2 0 .2 0 .3-.1.4 0 .1-.1.2 0 .3 0 .1 0 .2.1.3 0 .2 0 .3.1.4.2.2.4.2.7.2h8.5L9.6 24.7c-.7 1.1-.3 1.7 1.1 2.1 1.9.5 3.8.5 5.7.2 1.9-.4 3.7-1.1 5.3-2.3 1.6-1.1 2.9-2.6 3.8-4.3s1.5-3.6 1.6-5.5c.1-1.9-.1-3.9-.8-5.7-.7-1.8-1.8-3.4-3.1-4.8s-3-2.4-4.9-3C16.5.9 14.6.6 12.7.8z" } )
    );

	registerBlockType( 'c7wp/loginform', {
        title: __( 'Login Form' ), // The title of block in editor.
        description: __( 'Displays a Commerce7 login form with an optional redirect path.' ),
		icon: iconEl,
        category: 'commerce7', // The category of block in editor.
        keywords: [ 'commerce7', 'form', 'login' ],
        example: {},
		attributes: {
            data: {
                type: 'string',
                source: 'attribute',
                selector: '#c7-login-form',
                attribute: 'data-redirect-to',
                default: '/profile',
            }
        },
		edit: function( props ) {

            function updateData( event ) {
                props.setAttributes( { data: event.target.value } );
            }

            return [
                createElement(InspectorControls, null,
                    createElement(PanelBody, { title: 'Settings' },
                        createElement(TextControl, {
                            label: 'Redirect to Path',
                            value: props.attributes.data,
                            help: 'Optionally specify a path to redirect to after login.',
                            onChange: updateData,
                        })
                    ),
                ),
                createElement( 'div', {
                    className: props.className
                    },
                    createElement( 'div', { 
                        id: 'c7-login-form',
                        'data-redirect-to': props.attributes.data,
                        },
                        createElement( 'form', {
                            className: 'c7-form c7-form--login',
                            'data-sku': props.attributes.data // Assuming you want to keep this attribute here as well
                            },
                            createElement('div', { className: 'c7-form__field' },
                                createElement('label', { className: 'c7-required' }, 'Email'),
                                createElement('input', {
                                    name: 'email',
                                    tabindex: '-1',
                                    disabled: true,
                                    type: 'text'
                                })
                            ),
                            createElement('div', { className: 'c7-form__field' },
                                createElement('label', { className: 'c7-required' }, 'Password'),
                                createElement('input', {
                                    name: 'password',
                                    tabindex: '-1',
                                    disabled: true,
                                    type: 'password'
                                })
                            ),
                            createElement('div', { className: 'c7-form__buttons c7-form__buttons--wide' },
                                createElement('button', {
                                    type: 'submit',
                                    tabindex: '-1',
                                    disabled: true,
                                    className: 'c7-btn c7-btn--primary'
                                }, createElement('span', null, 'Log in'))
                            )
                        )
                    )
                )
            ];
		},
		save: function( props ) {
            return (
                createElement( 'div', { 
                    className: props.className
                    },
                    createElement( 'div', { 
                        id: 'c7-login-form',
                        'data-redirect-to': props.attributes.data,
                        }
                    )
                )
            );
		},
	} );
})(window.wp.blocks, window.wp.blockEditor, window.wp.element, window.wp.i18n, window.wp.components);