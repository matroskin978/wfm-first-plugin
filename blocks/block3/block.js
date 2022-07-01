(function (blocks, element, editor) {

    var el = element.createElement;

    blocks.registerBlockType('wfm-block/block3', {

        title: 'WFM Block 3',
        icon: 'welcome-view-site',
        category: 'text',
        attributes: {
            title: {
                type: 'string',
                default: 'Title',
            },
            content: {
                type: 'string',
                default: 'Content...',
            }
        },

        edit: function (props) {
            return el(
                'div',
                {className: props.className},
                el(
                    editor.RichText,
                    {
                        tagName: 'h3',
                        className: 'wfm-block-block3-title',
                        value: props.attributes.title,
                        onChange: function (title) {
                            props.setAttributes({title: title})
                        }
                    }
                ),
                el(
                    editor.RichText,
                    {
                        tagName: 'div',
                        className: 'wfm-block-block3-content',
                        value: props.attributes.content,
                        onChange: function (content) {
                            props.setAttributes({content: content})
                        }
                    }
                )
            );
        },

        save: function (props) {
            return el(
                'div',
                {className: props.className},
                el(
                    editor.RichText.Content,
                    {
                        tagName: 'h3',
                        className: 'wfm-block-block3-title',
                        value: props.attributes.title
                    }
                ),
                el(
                    editor.RichText.Content,
                    {
                        tagName: 'div',
                        className: 'wfm-block-block3-content',
                        value: props.attributes.content
                    }
                )
            );
        }

    });

})(window.wp.blocks, window.wp.element, window.wp.blockEditor);