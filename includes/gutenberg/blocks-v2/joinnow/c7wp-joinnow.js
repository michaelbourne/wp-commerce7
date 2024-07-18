(function (blocks, blockEditor, element, i18n, components) {

    const { registerBlockType } = blocks;
    const { useBlockProps, InspectorControls, BlockControls, AlignmentToolbar } = blockEditor;
    const { PanelBody, TextControl } = components;
    const { createElement, Fragment, useEffect } = element;
    const { __ } = i18n;

    const iconEl = createElement('svg', { preserveAspectRatio: 'xMinYMin meet', viewBox: '0 0 28 28' },
        createElement('path', { fill: '#333', d: "M12.7.8c-2.6.3-5 1.3-7 2.9S2.2 7.5 1.5 10c-.8 2.4-.8 5.1-.2 7.5.7 2.5 2.1 4.7 4 6.4.1.1.2.1.3.2h.3c.1 0 .2 0 .3-.1.1-.1.2-.1.2-.2.1-.1.1-.2.1-.3v-.3c0-.1 0-.2-.1-.3-.1-.1-.1-.2-.2-.2-1.5-1.3-2.6-2.9-3.2-4.8s-.7-3.9-.4-5.8c.3-1.9 1.1-3.7 2.3-5.3s2.8-2.7 4.6-3.5c1.8-.8 3.8-1.1 5.7-.9 1.9.2 3.8.9 5.4 2 1.6 1.1 2.9 2.6 3.8 4.4.9 1.8 1.3 3.7 1.2 5.6-.1 2.3-.9 4.5-2.3 6.3-1.3 1.8-3.2 3.3-5.3 4.1-2.1.8-4.3 1-6.5.5l8-15.1c.1-.2.2-.5.2-.8 0-.1 0-.2-.1-.3 0-.1-.1-.2-.2-.3-.1-.1-.2-.1-.3-.2-.1 0-.2-.1-.4 0h-10c-.2 0-.5.1-.7.2 0 .2 0 .3-.1.4 0 .1-.1.2 0 .3 0 .1 0 .2.1.3 0 .2 0 .3.1.4.2.2.4.2.7.2h8.5L9.6 24.7c-.7 1.1-.3 1.7 1.1 2.1 1.9.5 3.8.5 5.7.2 1.9-.4 3.7-1.1 5.3-2.3 1.6-1.1 2.9-2.6 3.8-4.3s1.5-3.6 1.6-5.5c.1-1.9-.1-3.9-.8-5.7-.7-1.8-1.8-3.4-3.1-4.8s-3-2.4-4.9-3C16.5.9 14.6.6 12.7.8z" })
    );

    registerBlockType('c7wp/joinnow', {
        title: __('Join Club Button'), // The title of block in editor.
        description: __('Displays a Commerce7 club sign-up button that reads either "Join Now" or "Edit Membership" based on the customers status in the club. You can change the default values for both states using the fields below.'),
        icon: iconEl,
        category: 'commerce7', // The category of block in editor.
        keywords: ['commerce7', 'club', 'button', 'join'],
        example: {},
        supports: {
            html: false,
        },
        attributes: {
            clubSlug: {
                type: 'string',
                source: 'attribute',
                selector: '.c7-club-join-button',
                attribute: 'data-club-slug',
                default: '6-bottle-club',
            },
            joinText: {
                type: 'string',
                source: 'attribute',
                selector: '.c7-club-join-button',
                attribute: 'data-join-text',
                default: 'Join Now',
            },
            editText: {
                type: 'string',
                source: 'attribute',
                selector: '.c7-club-join-button',
                attribute: 'data-edit-text',
                default: 'Edit Membership',
            },
            data: {
                type: 'string',
                source: 'attribute',
                selector: '.c7-club-join-button',
                attribute: 'data-club-slug',
                default: '6-bottle-club',
            },
            alignment: {
                type: 'string',
                default: 'left',
            },
        },
        deprecated: [
            {
                attributes: {
                    data: {
                        type: 'string',
                        source: 'attribute',
                        selector: '.c7-club-join-button',
                        attribute: 'data-club-slug',
                    },
                },
                save: function (props) {
                    return (
                        createElement('div', {
                            className: props.className
                        },
                            createElement('div', {
                                className: 'c7-club-join-button',
                                'data-club-slug': props.attributes.data,
                            }),
                        )
                    );
                },
                migrate: function (attributes) {
                    // Migrate function to map old attributes to new ones
                    const { data } = attributes;
                    // If joinText and editText were not set previously, they should have their default values
                    return {
                        clubSlug: data,
                        joinText: 'Join Now',
                        editText: 'Edit Membership',
                        alignment: 'left',
                    };
                }
            }
        ],
        edit: function (props) {
            const blockProps = useBlockProps();
            const { alignment, joinText, clubSlug, editText, className } = props.attributes;

            // Define the button class with conditional logic for alignment
            let buttonClasses = 'c7-club-join-button';
            if (alignment) {
                buttonClasses += ` has-text-align-${alignment}`;
            }

            // This effect runs when the component mounts and when the joinText changes.
            useEffect(() => {
                // If joinText is not set or is an empty string, set it to the default value.
                if (!joinText) {
                    props.setAttributes({ joinText: 'Join Now' });
                }

                // Check if alignment class is present in the className
                const hasAlignmentClass = /has-text-align-/.test(className);
                // If not, set the default alignment
                if (!hasAlignmentClass) {
                    props.setAttributes({ alignment: alignment || 'left' });
                }
            }, []);

            function updateAttributes(attrName, value) {
                props.setAttributes({ [attrName]: value });
            }

            // set slugProvided to true if a slug is provided and not blank.
            const slugProvided = props.attributes.clubSlug && props.attributes.clubSlug.length > 0;

            return (
                createElement(Fragment, {},
                    createElement(BlockControls, { key: 'controls' },
                        createElement(AlignmentToolbar, {
                            value: alignment,
                            onChange: (newAlignment) => updateAttributes('alignment', newAlignment),
                        })
                    ),
                    createElement(InspectorControls, null,
                        createElement(PanelBody, { title: 'Settings' },
                            createElement(TextControl, {
                                label: 'Club Slug',
                                value: clubSlug,
                                onChange: (value) => updateAttributes('clubSlug', value),
                            }),
                            createElement(TextControl, {
                                label: 'Join Text',
                                value: joinText,
                                onChange: (value) => updateAttributes('joinText', value),
                            }),
                            createElement(TextControl, {
                                label: 'Edit Text',
                                value: editText,
                                onChange: (value) => updateAttributes('editText', value),
                            }),
                        ),
                    ),
                    createElement('div', blockProps,
                        createElement('div', {
                            className: buttonClasses,
                            'data-club-slug': clubSlug,
                            'data-join-text': joinText,
                            'data-edit-text': editText,
                            // Directly create the link as a React component
                        },
                            slugProvided && createElement('a', {
                                className: 'c7-btn c7-btn--primary',
                                role: 'link',
                                tabindex: '-1',
                                disabled: true,
                                // Use children instead of dangerouslySetInnerHTML
                            }, joinText),
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
                                'Please enter a club slug in the block settings (generally in your right sidebar)'
                            )
                        )
                    ),
                )
            );
        },

        save: function (props) {
            const blockProps = useBlockProps.save();
            const { alignment, joinText, clubSlug, editText } = props.attributes;
            // Define the button class with conditional logic for alignment
            let buttonClasses = 'c7-club-join-button';
            if (alignment) {
                buttonClasses += ` has-text-align-${alignment}`;
            }

            return createElement('div', blockProps,
                createElement('div', {
                    className: buttonClasses,
                    'data-club-slug': clubSlug || '6-bottle-club',
                    'data-join-text': joinText || 'Join Now',
                    'data-edit-text': editText || 'Edit Membership',
                    // No innerHTML here; it's added by the front-end script
                })
            );
        },
    });
})(window.wp.blocks, window.wp.blockEditor, window.wp.element, window.wp.i18n, window.wp.components);