(function(blocks, blockEditor, components) {
    var el = wp.element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var TextControl = components.TextControl;
    var SelectControl = components.SelectControl;
    var ToggleControl = components.ToggleControl;
    var Button = components.Button;
    var InspectorControls = blockEditor.InspectorControls;

    // Define a variable to store fetched options
    var fetchedOptions = null;

    registerBlockType('insapption-ai/insapption-ai-block', {
        title: 'Insapption AI',
        icon: 'smiley',
        category: 'common',
        attributes: {
            contentType: {
                type: 'string'
            },
            contentTone: {
                type: 'string'
            },
            contentLanguage: {
                type: 'string'
            },
            contentTopic: {
                type: 'string'
            },
            generateImage: {
                type: 'boolean',
                default: false,
            },
            loading: {
                type: 'boolean',
                default: false,
            },
            welcomeVisible: {
                type: 'boolean',
                default: true,
            },
            error: {
                type: 'string',
                default: '',
            },
        },
        edit: function(props) {
            var contentType = props.attributes.contentType;
            var contentTone = props.attributes.contentTone;
            var contentLanguage = props.attributes.contentLanguage;
            var contentTopic = props.attributes.contentTopic;
            var generateImage = props.attributes.generateImage;
            var languages = props.attributes.languages;
            var types = props.attributes.types;
            var tones = props.attributes.tones;
            var loading = props.attributes.loading;
            var error = props.attributes.error;
            var welcomeVisible = props.attributes.welcomeVisible;
            var contentBlocks = [];
            const { apikey, websiteUrl } = window.insapption_ai_block_object;

            // Fetch options from API only if they haven't been fetched yet
            function fetchOptions() {
                if (!fetchedOptions) {
                    fetch('https://ai.insapption.com/api/get-options', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({}),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data && data.languages && data.types && data.tones) {
                            fetchedOptions = {
                                languages: data.languages,
                                types: data.types,
                                tones: data.tones,
                            };
                            // Update SelectControl options for languages, types, and tones
                            // Update state or props with the fetched options
                            // For example:
                            props.setAttributes({ languages: fetchedOptions.languages });
                            props.setAttributes({ types: fetchedOptions.types });
                            props.setAttributes({ tones: fetchedOptions.tones });
                            props.setAttributes({ contentType: fetchedOptions.types[0].value });
                            props.setAttributes({ contentTone: fetchedOptions.tones[0].value });
                            props.setAttributes({ contentLanguage: fetchedOptions.languages[0].value });
                        } else {
                            // Handle error when data is missing
                        }
                    })
                    .catch((error) => {
                        // Handle API call error
                        console.error('API call failed:', error);
                    });
                }
            }

            // Call fetchOptions() to retrieve options when the block is loaded
            fetchOptions();

            function updateContentType(value) {
                props.setAttributes({ contentType: value });
            }

            function updateContentTone(value) {
                props.setAttributes({ contentTone: value });
            }

            function updateContentLanguage(value) {
                props.setAttributes({ contentLanguage: value });
            }

            function updateContentTopic(value) {
                props.setAttributes({ contentTopic: value });
            }

            function updateGenerateImage(checked){
                props.setAttributes({ generateImage: checked });
            }

            function setLoading(loadingState) {
                props.setAttributes({ loading: loadingState });
            }

            function setWelcomeVisible(welcomeState){
                props.setAttributes({ welcomeVisible: welcomeState });
            }

            function setError(errorMessage) {
                props.setAttributes({ error: errorMessage });
            }

            function createContent() {
                // Update post title based on content topic
                wp.data.dispatch('core/editor').editPost({ title: contentTopic });
                // Show the loader GIF
                setWelcomeVisible(false);
                setLoading(true);
                setError('');
                // Make an API call to your OpenAI endpoint
                fetch('https://ai.insapption.com/api/generate-content', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        contentType: contentType,
                        contentLanguage: contentLanguage,
                        contentTone: contentTone,
                        contentTopic: contentTopic,
                        generateImage: generateImage,
                        apikey: apikey,
                        websiteUrl: websiteUrl
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.message === 'success') {
                        setLoading(false);
                        const paragraphs = data.content.split('\n\n'); // Split content into paragraphs
                        if(data.image !== null){

                            const blocks = paragraphs.map((paragraph, index) => {
                                if (index === 1) {
                                    // Insert an image block after the first paragraph
                                    return wp.blocks.createBlock('core/image', {
                                        url: data.image,
                                    });
                                } else {
                                    // Create paragraph blocks for the rest of the content
                                    return wp.blocks.createBlock('core/paragraph', {
                                        content: paragraph,
                                    });
                                }
                            });

                            wp.data.dispatch('core/block-editor').insertBlocks(blocks);

                        }else{

                            wp.data.dispatch('core/block-editor').insertBlocks(
                                paragraphs.map((paragraph) =>
                                    wp.blocks.createBlock('core/paragraph', {
                                        content: paragraph,
                                    })
                                )
                            );

                        }

                        // Replace the block with the generated content
                        wp.data.dispatch('core/block-editor').replaceBlocks(props.clientId, contentBlocks);
                        // Reset fetchedOptions to null to allow fetching again
                        fetchedOptions = null;
                    } else {
                        // Show the error message
                        setError(data.error);

                        // Clear the loading state
                        setLoading(false);
                    }
                })
                .catch((error) => {
                    // Handle API call error
                    setError(`API call failed: ${error}`);

                    // Clear the loading state
                    setLoading(false);
                });
            }

            return [
                el(InspectorControls, {
                    key: 'inspector'
                },
                el(SelectControl, {
                    label: 'Content Language',
                    value: contentLanguage,
                    options: languages,
                    onChange: updateContentLanguage,
                    className: 'custom-select-control',
                }),
                el(SelectControl, {
                    label: 'Content Type',
                    value: contentType,
                    options: types,
                    onChange: updateContentType,
                    className: 'custom-select-control',
                }),
                el(TextControl, {
                    label: 'Content Topic',
                    value: contentTopic,
                    onChange: updateContentTopic,
                    className: 'custom-select-control',
                }),
                el(SelectControl, {
                    label: 'Content Tone',
                    value: contentTone,
                    options: tones,
                    onChange: updateContentTone,
                    className: 'custom-select-control',
                }),
                el(ToggleControl, {
                    label: 'Do you want to generate an image related to the content?',
                    checked: generateImage,
                    onChange: updateGenerateImage,
                    className: 'custom-select-control',
                }),
                el(Button, {
                    isPrimary: true,
                    onClick: createContent,
                    className: 'custom-generate-button',
                    disabled: loading,
                }, 'Generate')
                ),
                el('div', { className: 'insapption-ai-block' },
                    welcomeVisible && el('h5', { style: { textAlign: 'center' } }, 'Generate Content With InsapptionAI'),
                    welcomeVisible && el('p', { style: { textAlign: 'center' } }, 'Your generated content will be shown in this area.'),
                    
                    
                    loading && el('img', { src: '/wp-content/plugins/insapption-ai/img/loader.gif', alt: 'Loading...' }), // Show loader GIF when loading
                    error && el('p', { style: { color: 'red' } }, error), // Show error message
                )
            ];
        },
        save: function() {
            return null;
        },
    });
})(
    window.wp.blocks,
    window.wp.blockEditor,
    window.wp.components
);
