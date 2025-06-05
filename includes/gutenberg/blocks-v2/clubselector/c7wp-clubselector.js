(function (blocks, blockEditor, element, i18n, components) {
    const { registerBlockType } = blocks;
    const { InspectorControls, InnerBlocks, useBlockProps } = blockEditor;
    const { PanelBody, TextControl, Button, RadioControl, SelectControl } = components;
    const { createElement, Fragment, useEffect } = element;
    const { __ } = i18n;

    const iconEl = createElement('svg', { preserveAspectRatio: 'xMinYMin meet', viewBox: '0 0 28 28' },
        createElement('path', { fill: '#333', d: "M12.7.8c-2.6.3-5 1.3-7 2.9S2.2 7.5 1.5 10c-.8 2.4-.8 5.1-.2 7.5.7 2.5 2.1 4.7 4 6.4.1.1.2.1.3.2h.3c.1 0 .2 0 .3-.1.1-.1.2-.1.2-.2.1-.1.1-.2.1-.3v-.3c0-.1 0-.2-.1-.3-.1-.1-.1-.2-.2-.2-1.5-1.3-2.6-2.9-3.2-4.8s-.7-3.9-.4-5.8c.3-1.9 1.1-3.7 2.3-5.3s2.8-2.7 4.6-3.5c1.8-.8 3.8-1.1 5.7-.9 1.9.2 3.8.9 5.4 2 1.6 1.1 2.9 2.6 3.8 4.4.9 1.8 1.3 3.7 1.2 5.6-.1 2.3-.9 4.5-2.3 6.3-1.3 1.8-3.2 3.3-5.3 4.1-2.1.8-4.3 1-6.5.5l8-15.1c.1-.2.2-.5.2-.8 0-.1 0-.2-.1-.3 0-.1-.1-.2-.2-.3-.1-.1-.2-.1-.3-.2-.1 0-.2-.1-.4 0h-10c-.2 0-.5.1-.7.2 0 .2 0 .3-.1.4 0 .1-.1.2 0 .3 0 .1 0 .2.1.3 0 .2 0 .3.1.4.2.2.4.2.7.2h8.5L9.6 24.7c-.7 1.1-.3 1.7 1.1 2.1 1.9.5 3.8.5 5.7.2 1.9-.4 3.7-1.1 5.3-2.3 1.6-1.1 2.9-2.6 3.8-4.3s1.5-3.6 1.6-5.5c.1-1.9-.1-3.9-.8-5.7-.7-1.8-1.8-3.4-3.1-4.8s-3-2.4-4.9-3C16.5.9 14.6.6 12.7.8z" })
    );

    const ALLOWED_BLOCKS = ['core/button'];
    const TEMPLATE = [
        ['core/button', {
            text: __('Join Club', 'wp-commerce7'),
            className: 'club-selector-button',
            url: '#',
            lock: {
                move: true,
                remove: true,
                update: true
            }
        }]
    ];

    registerBlockType('c7wp/clubselector', {
        title: __('Club Selector'), // The title of block in editor.
        description: __('Displays a club selector with either radio buttons or dropdown, and a dynamic button.'),
        icon: iconEl,
        category: 'commerce7', // The category of block in editor.
        keywords: ['commerce7', 'club'],
        example: {},
        attributes: {
            displayType: {
                type: 'string',
                default: 'radio',
            },
            clubs: {
                type: 'array',
                default: [],
            },
            isValid: {
                type: 'boolean',
                default: true,
            },
            radioGroupName: {
                type: 'string',
                default: '',
            },
        },
        supports: {
            customClassName: false,
            html: false,
            inserter: true,
        },
        edit: function (props) {
            const { attributes, setAttributes, clientId } = props;
            const { displayType, clubs } = attributes;
            const blockProps = useBlockProps();
            const radioGroupName = attributes.radioGroupName || 'club-selector';

            // Check for validation issues
            const validationIssues = [];
            if (!clubs.length) {
                validationIssues.push(__('No clubs added'));
            } else {
                // Check for empty or invalid clubs
                clubs.forEach((club, index) => {
                    if (!club.slug || !club.slug.trim()) {
                        validationIssues.push(__('Club #' + (index + 1) + ' has no slug'));
                    }
                    if (!club.name || !club.name.trim()) {
                        validationIssues.push(__('Club #' + (index + 1) + ' has no name'));
                    }
                    if (!club.buttonText || !club.buttonText.trim()) {
                        validationIssues.push(__('Club #' + (index + 1) + ' has no button text'));
                    }
                });

                // Check for duplicate slugs
                const slugs = clubs.map(club => club.slug?.toLowerCase()).filter(Boolean);
                const uniqueSlugs = new Set(slugs);
                if (slugs.length !== uniqueSlugs.size) {
                    validationIssues.push(__('Duplicate club slugs found'));
                }
            }

            // Force update button text and URL whenever clubs change
            useEffect(() => {
                const buttonBlock = wp.data.select('core/block-editor').getBlock(clientId).innerBlocks[0];
                if (buttonBlock && clubs.length > 0) {
                    const firstClub = clubs[0];
                    const clubRoute = window.c7wp_settings?.c7wp_frontend_routes?.club || 'club';

                    if (firstClub.slug && firstClub.name) {
                        wp.data.dispatch('core/block-editor').updateBlockAttributes(buttonBlock.clientId, {
                            text: firstClub.buttonText || __('Join Club', 'wp-commerce7'),
                            url: `/${clubRoute}/${firstClub.slug}/`
                        });
                    }
                }
            }, [clubs, clientId]);

            // Watch for button changes and revert if modified
            useEffect(() => {
                const block = wp.data.select('core/block-editor').getBlock(clientId);
                if (!block) return;
                // Filter to only core/button blocks
                const buttonBlocks = block.innerBlocks.filter(b => b.name === 'core/button');
                // If more than one button, remove extras
                if (buttonBlocks.length > 1) {
                    // Keep only the first button
                    const firstButton = buttonBlocks[0];
                    wp.data.dispatch('core/block-editor').replaceInnerBlocks(
                        clientId,
                        [firstButton],
                        false // do not update selection
                    );
                }
                const buttonBlock = wp.data.select('core/block-editor').getBlock(clientId).innerBlocks[0];
                if (buttonBlock) {
                    const unsubscribe = wp.data.subscribe(() => {
                        const currentButton = wp.data.select('core/block-editor').getBlock(buttonBlock.clientId);
                        if (currentButton && clubs.length > 0) {
                            const firstClub = clubs[0];
                            const clubRoute = window.c7wp_settings?.c7wp_frontend_routes?.club || 'club';

                            if (firstClub.slug && firstClub.name) {
                                const expectedUrl = `/${clubRoute}/${firstClub.slug}/`;
                                const expectedText = firstClub.buttonText || __('Join Club', 'wp-commerce7');

                                if (currentButton.attributes.url !== expectedUrl ||
                                    currentButton.attributes.text !== expectedText) {
                                    wp.data.dispatch('core/block-editor').updateBlockAttributes(buttonBlock.clientId, {
                                        text: expectedText,
                                        url: expectedUrl
                                    });
                                }
                            }
                        }
                    });

                    return () => unsubscribe();
                }
            }, [clubs, clientId]);

            const addClub = () => {
                console.log('Adding new club, current clubs:', clubs);
                const newClubs = [...clubs, { slug: '', name: '', buttonText: '' }];
                console.log('New clubs array:', newClubs);
                setAttributes({ clubs: newClubs });
            };

            const removeClub = (index) => {
                if (clubs.length <= 1) {
                    return;
                }
                const newClubs = [...clubs];
                newClubs.splice(index, 1);
                setAttributes({ clubs: newClubs });
            };

            const updateClub = (index, field, value) => {
                const newClubs = [...clubs];
                newClubs[index] = { ...newClubs[index], [field]: value };

                if (field === 'slug') {
                    if (!value) {
                        return; // Don't allow empty slugs
                    }
                }
                if (field === 'name' && !value) {
                    return; // Don't allow empty names
                }

                setAttributes({ clubs: newClubs });
            };

            // Add a new function to validate slugs on blur
            const validateSlug = (index, value) => {
                if (!value) return;

                const isDuplicate = clubs.some((club, i) =>
                    i !== index && club.slug && club.slug.toLowerCase() === value.toLowerCase()
                );

                if (isDuplicate) {
                    // Reset to previous value if duplicate
                    const newClubs = [...clubs];
                    newClubs[index] = { ...newClubs[index], slug: clubs[index].slug };
                    setAttributes({ clubs: newClubs });
                }
            };

            // Show placeholder if no clubs
            if (!clubs.length) {
                return createElement('div', { ...blockProps, className: 'components-placeholder' },
                    createElement('div', { className: 'components-placeholder__label' },
                        __('Club Selector')
                    ),
                    createElement('div', { className: 'components-placeholder__instructions' },
                        __('Please add at least one club to continue.')
                    ),
                    createElement(Button, {
                        isPrimary: true,
                        onClick: addClub,
                    }, __('Add Club'))
                );
            }

            // Show the editor UI
            return (
                createElement(Fragment, null,
                    createElement(InspectorControls, null,
                        createElement(PanelBody, { title: __('Club Selector Settings'), initialOpen: true },
                            createElement(TextControl, {
                                label: __('Radio Group Name', 'wp-commerce7'),
                                value: attributes.radioGroupName,
                                onChange: (value) => {
                                    // Sanitize: allow only a-z, A-Z, 0-9, -, _
                                    const sanitized = value.replace(/[^a-zA-Z0-9_-]/g, '');
                                    setAttributes({ radioGroupName: sanitized });
                                },
                                help: __('This must be unique if you use more than one Club Selector block on a page.', 'wp-commerce7'),
                                placeholder: __('premierclub', 'wp-commerce7'),
                                required: true,
                            }),
                            createElement(RadioControl, {
                                label: __('Display Type'),
                                selected: displayType,
                                options: [
                                    { label: __('Radio Buttons'), value: 'radio' },
                                    { label: __('Dropdown'), value: 'select' },
                                ],
                                onChange: (value) => setAttributes({ displayType: value }),
                            }),
                            createElement('div', null,
                                clubs.map((club, index) => (
                                    createElement('div', { key: index, className: 'club-item' },
                                        createElement(TextControl, {
                                            label: __('Club Slug'),
                                            value: club.slug,
                                            onChange: (value) => updateClub(index, 'slug', value),
                                            onBlur: (event) => validateSlug(index, event.target.value),
                                            __nextHasNoMarginBottom: true,
                                            placeholder: __('12-bottle-club', 'wp-commerce7'),
                                            required: true
                                        }),
                                        createElement(TextControl, {
                                            label: __('Club Name'),
                                            value: club.name,
                                            onChange: (value) => updateClub(index, 'name', value),
                                            __nextHasNoMarginBottom: true,
                                            placeholder: __('12 Bottles', 'wp-commerce7'),
                                            required: true
                                        }),
                                        createElement(TextControl, {
                                            label: __('Button Text'),
                                            value: club.buttonText,
                                            onChange: (value) => updateClub(index, 'buttonText', value),
                                            __nextHasNoMarginBottom: true,
                                            placeholder: __('Join the 12 Bottle Club', 'wp-commerce7'),
                                            required: true
                                        }),
                                        createElement(Button, {
                                            isDestructive: true,
                                            onClick: () => removeClub(index),
                                            disabled: clubs.length <= 1
                                        }, __('Remove Club')),
                                    )
                                )),
                                createElement(Button, {
                                    isPrimary: true,
                                    onClick: addClub,
                                }, __('Add Club')),
                            ),
                        ),
                    ),
                    createElement('div', { ...blockProps },
                        createElement('div', { className: 'club-selector-preview' },
                            validationIssues.length > 0 && createElement('div', {
                                className: 'components-notice is-warning',
                                style: { marginBottom: '1em' }
                            },
                                createElement('div', { className: 'components-notice__content' },
                                    createElement('p', null, __('The following issues need to be fixed before the block will render:')),
                                    createElement('ul', null,
                                        validationIssues.map((issue, index) =>
                                            createElement('li', { key: index }, issue)
                                        )
                                    )
                                )
                            ),
                            displayType === 'radio' ? (
                                createElement('div', { className: 'club-radio-buttons' },
                                    createElement('fieldset', null,
                                        createElement('legend', { className: 'screen-reader-text' }, __('Choose your desired club')),
                                        createElement('div', { className: 'radios' },
                                            clubs.map((club, index) => (
                                                createElement('div', { key: index, className: 'row' },
                                                    createElement('input', {
                                                        type: 'radio',
                                                        name: radioGroupName,
                                                        id: `club-${club.slug}`,
                                                        value: club.slug,
                                                        'data-button-text': club.buttonText,
                                                        className: 'choice',
                                                        checked: index === 0,
                                                        'aria-checked': index === 0,
                                                        'aria-label': club.name
                                                    }),
                                                    createElement('label', { htmlFor: `club-${club.slug}` }, club.name),
                                                )
                                            )),
                                        ),
                                    ),
                                )
                            ) : (
                                createElement('select', {
                                    className: 'club-select',
                                    'aria-label': __('Choose your desired club')
                                },
                                    clubs.map((club, index) => (
                                        createElement('option', {
                                            key: index,
                                            value: club.slug,
                                            'data-button-text': club.buttonText,
                                            selected: index === 0
                                        }, club.name)
                                    )),
                                )
                            ),
                            createElement('div', { className: 'wp-block-buttons' },
                                createElement(InnerBlocks,
                                    {
                                        allowedBlocks: ALLOWED_BLOCKS,
                                        template: TEMPLATE,
                                        templateLock: 'all',
                                        renderAppender: false
                                    }
                                ),
                            ),
                        ),
                    ),
                )
            );
        },
        save: function (props) {
            const { attributes } = props;
            const { displayType, clubs } = attributes;
            const radioGroupName = attributes.radioGroupName || 'club-selector';

            // Don't render if no clubs, any club is invalid, or slugs are not unique
            if (!clubs.length ||
                !clubs.every(club =>
                    club.slug && club.slug.trim() !== '' &&
                    club.name && club.name.trim() !== '' &&
                    club.buttonText && club.buttonText.trim() !== ''
                ) ||
                !clubs.every((club, index) =>
                    !clubs.some((otherClub, otherIndex) =>
                        index !== otherIndex &&
                        club.slug && otherClub.slug &&
                        club.slug.toLowerCase() === otherClub.slug.toLowerCase()
                    )
                )
            ) {
                return null;
            }

            const blockProps = useBlockProps.save();

            return (
                createElement('div', { ...blockProps, className: 'club-selector-wrapper' },
                    displayType === 'radio' ? (
                        createElement('div', { className: 'club-radio-buttons' },
                            createElement('fieldset', null,
                                createElement('legend', { className: 'screen-reader-text' }, __('Choose your desired club')),
                                createElement('div', { className: 'radios' },
                                    clubs.map((club, index) => (
                                        createElement('div', { key: index, className: 'row' },
                                            createElement('input', {
                                                type: 'radio',
                                                name: radioGroupName,
                                                id: `club-${club.slug}`,
                                                value: club.slug,
                                                'data-button-text': club.buttonText,
                                                className: 'choice',
                                                checked: index === 0,
                                                'aria-checked': index === 0,
                                                'aria-label': club.name
                                            }),
                                            createElement('label', { htmlFor: `club-${club.slug}` }, club.name),
                                        )
                                    )),
                                ),
                            ),
                        )
                    ) : (
                        createElement('select', {
                            className: 'club-select',
                            'aria-label': __('Choose your desired club')
                        },
                            clubs.map((club, index) => (
                                createElement('option', {
                                    key: index,
                                    value: club.slug,
                                    'data-button-text': club.buttonText,
                                    selected: index === 0
                                }, club.name)
                            )),
                        )
                    ),
                    createElement('div', { className: 'wp-block-buttons' },
                        createElement(InnerBlocks.Content),
                    ),
                )
            );
        },
    });
})(window.wp.blocks, window.wp.blockEditor, window.wp.element, window.wp.i18n, window.wp.components); 