( function ( blocks, element, blockEditor ) {
    var el = element.createElement;

    blocks.registerBlockType( 'wfm-block/block2', {
        edit: function ( props ) {
            var blockProps = blockEditor.useBlockProps();
            return el( 'p', blockProps, 'Hello World (from the editor).' );
        },
        save: function () {
            var blockProps = blockEditor.useBlockProps.save();
            return el( 'h3', blockProps, 'Hola mundo!!! (from the frontend).' );
        },
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor );