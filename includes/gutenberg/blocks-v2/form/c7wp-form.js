(function (blocks, blockEditor, element, i18n, components) {

    const { registerBlockType } = blocks;
    const { InspectorControls } = blockEditor;
    const { TextControl, PanelBody } = components;
    const { createElement } = element;
    const { __ } = i18n;

    const iconEl = createElement('svg', { preserveAspectRatio: 'xMinYMin meet', viewBox: '0 0 28 28' },
    createElement('path', { fill: '#333', d: "M12.7.8c-2.6.3-5 1.3-7 2.9S2.2 7.5 1.5 10c-.8 2.4-.8 5.1-.2 7.5.7 2.5 2.1 4.7 4 6.4.1.1.2.1.3.2h.3c.1 0 .2 0 .3-.1.1-.1.2-.1.2-.2.1-.1.1-.2.1-.3v-.3c0-.1 0-.2-.1-.3-.1-.1-.1-.2-.2-.2-1.5-1.3-2.6-2.9-3.2-4.8s-.7-3.9-.4-5.8c.3-1.9 1.1-3.7 2.3-5.3s2.8-2.7 4.6-3.5c1.8-.8 3.8-1.1 5.7-.9 1.9.2 3.8.9 5.4 2 1.6 1.1 2.9 2.6 3.8 4.4.9 1.8 1.3 3.7 1.2 5.6-.1 2.3-.9 4.5-2.3 6.3-1.3 1.8-3.2 3.3-5.3 4.1-2.1.8-4.3 1-6.5.5l8-15.1c.1-.2.2-.5.2-.8 0-.1 0-.2-.1-.3 0-.1-.1-.2-.2-.3-.1-.1-.2-.1-.3-.2-.1 0-.2-.1-.4 0h-10c-.2 0-.5.1-.7.2 0 .2 0 .3-.1.4 0 .1-.1.2 0 .3 0 .1 0 .2.1.3 0 .2 0 .3.1.4.2.2.4.2.7.2h8.5L9.6 24.7c-.7 1.1-.3 1.7 1.1 2.1 1.9.5 3.8.5 5.7.2 1.9-.4 3.7-1.1 5.3-2.3 1.6-1.1 2.9-2.6 3.8-4.3s1.5-3.6 1.6-5.5c.1-1.9-.1-3.9-.8-5.7-.7-1.8-1.8-3.4-3.1-4.8s-3-2.4-4.9-3C16.5.9 14.6.6 12.7.8z" } )
    );

	blocks.registerBlockType( 'c7wp/form', {
        title: __( 'Custom Form' ), // The title of block in editor.
        description: __( 'Displays a Commerce7 custom form. These can be built in the Marketing tab of the Commerce7 CRM.' ),
		icon: iconEl,
        category: 'commerce7', // The category of block in editor.
        keywords: [ 'commerce7', 'form', 'contact' ],
        example: {},
		attributes: {
            data: {
                type: 'string',
                source: 'attribute',
                selector: '.c7-custom-form',
                attribute: 'data-form-code',
            }
        },
		edit: function( props ) {

            function updateData(value) {
                props.setAttributes({ data: value });
            }

            // set slugProvided to true if a slug is provided and not blank.
            const slugProvided = props.attributes.data && props.attributes.data.length > 0;

            return [
                createElement(InspectorControls, null,
                    createElement('div', {
                        className: 'components-notice is-warning', style: {
                            marginBottom: '5px',
                        }
                    },
                        createElement('small', null, 'The preview shown in your editor is for example purposes only, it does not reflect the form code you provide nor is it interactive.')
                    ),
                    createElement(PanelBody, { title: 'Settings' },
                        createElement(TextControl, {
                            label: 'Form Code',
                            value: props.attributes.data,
                            onChange: updateData,
                        })
                    ),
                ),
                createElement( 'div', {
                    className: props.className
                    },
                    createElement( 'div', { 
                        className: 'c7-custom-form',
                        'data-form-code': props.attributes.data,
                        },
                        slugProvided && createElement( 'form', { 
                            className: 'c7-form'
                        },
                            createElement( 'fieldset', null,
                                createElement( 'legend', { className: 'c7-sr-only' }, 'Contact Us' ),
                                createElement( 'div', { className: 'c7-form__field' },
                                    createElement( 'label', { className: 'c7-required' }, 'First & Last Name' ),
                                    createElement( 'input', { 
                                        name: 'fullName',
                                        type: 'text',
                                        value: '',
                                        disabled: true,
                                        tabIndex: "-1"
                                    })
                                ),
                                createElement( 'div', { className: 'c7-form__field' },
                                    createElement( 'label', { className: 'c7-required' }, 'Country' ),
                                    createElement( 'select', { 
                                        name: 'countryCode',
                                        disabled: true,
                                        tabIndex: "-1"
                                    },
                                        createElement( 'option', { value: 'CA' }, 'Canada' ),
                                        createElement( 'option', { value: 'US' }, 'United States' )
                                    )
                                ),
                                createElement( 'div', { className: 'c7-form__field' },
                                    createElement( 'label', { className: '' }, 'Phone' ),
                                    createElement( 'input', { 
                                        name: 'phone',
                                        type: 'tel',
                                        value: '',
                                        disabled: true,
                                        tabIndex: "-1"
                                    })
                                ),
                                createElement( 'div', { className: 'c7-form__field' },
                                    createElement( 'label', { className: 'c7-required' }, 'Email' ),
                                    createElement( 'input', { 
                                        name: 'email',
                                        type: 'email',
                                        value: '',
                                        disabled: true,
                                        tabIndex: "-1"
                                    })
                                ),
                                createElement( 'div', { className: 'c7-form__field' },
                                    createElement( 'label', { className: 'c7-required' }, 'Questions/Comments' ),
                                    createElement( 'textarea', { 
                                        name: 'questions-comments',
                                        rows: '3',
                                        disabled: true,
                                        tabIndex: "-1"
                                    })
                                )
                            ),
                            createElement( 'div', { className: 'c7-form__buttons' },
                                createElement( 'button', { 
                                    type: 'submit', 
                                    className: 'c7-btn c7-btn--primary' ,
                                    disabled: true,
                                    tabIndex: "-1"
                                }, createElement( 'span', null, 'Submit' ))
                            )
                        ),
                        !slugProvided && createElement('div', { className: 'c7-message c7-message--alert-error', role: 'presentation' },
                            createElement('svg', {
                                'aria-hidden': 'true',
                                focusable: 'false',
                                role: 'presentation',
                                xmlns: 'http://www.w3.org/2000/svg',
                                width: '18',
                                height: '18',
                                viewBox: '0 0 24 24',
                                fill: 'none',
                                stroke: '#000',
                                'stroke-width': '2',
                                'stroke-linecap': 'round',
                                'stroke-linejoin': 'round'
                            },
                                createElement('circle', { cx: '12', cy: '12', r: '10' }),
                                createElement('line', { x1: '12', y1: '8', x2: '12', y2: '12' }),
                                createElement('line', { x1: '12', y1: '16', x2: '12.01', y2: '16' })
                            ),
                            'Please enter a form code.'
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
                        className: 'c7-custom-form',
                        'data-form-code': props.attributes.data,
                        }
                    )
                )
            );
		},
	} );
})(window.wp.blocks, window.wp.blockEditor, window.wp.element, wp.i18n, wp.components);